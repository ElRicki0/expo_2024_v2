<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */
class ClienteHandler
{
    protected $id = null;
    protected $nombre = null;
    protected $apellido = null;
    protected $dui = null;
    protected $correo = null;
    protected $contrasenia = null;
    protected $fechaContrasenia = null;
    protected $telefono = null;
    protected $nacimiento = null;
    protected $estado = null;
    protected $codigo = null; // Inicialmente nulo
    protected $codigoUsuario = null; // Inicialmente nulo
    protected $imagen = null; // Inicialmente nulo

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/clientes/';

    public function __construct()
    {
        // Generar un código aleatorio de 6 dígitos y asignarlo a $codigo
        $this->codigo = rand(100000, 999999);
        $this->fechaContrasenia = date('Y-m-d'); // Formato año-mes-día
    }

    // Método para obtener el código para recuperación de clave
    public function getCodigo()
    {
        return $this->codigo;
    }

    // Metodo para asignar 90 Dias para la clave
    public function getFechaContrasenia()
    {
        return $this->fechaContrasenia;
    }

    /*
     *   Métodos para gestionar la cuenta del cliente.
     */
    // Método para verificar las credenciales del cliente al iniciar sesión
    public function checkUser($email, $contraseña)
    {
        $sql = 'SELECT id_cliente, correo_cliente, contrasenia_cliente, estado_cliente
                FROM tb_clientes
                WHERE correo_cliente = ?';
        $params = array($email);
        $data = Database::getRow($sql, $params);

        // Verifica si la contraseña coincide con el hash almacenado y establece los datos del cliente si es válido
        if (password_verify($contraseña, $data['contrasenia_cliente'])) {
            $this->id = $data['id_cliente'];
            $this->correo = $data['correo_cliente'];
            $this->estado = $data['estado_cliente'];
            return true;
        } else {
            return false;
        }
    }

    // Método para verificar y establecer el estado activo del cliente
    public function checkStatus()
    {
        if ($this->estado) {
            $_SESSION['idCliente'] = $this->id;
            $_SESSION['correoCliente'] = $this->correo;
            return true;
        } else {
            return false;
        }
    }

    public function readProfile()
    {
        $sql = 'SELECT nombre_cliente, imagen_cliente, apellido_cliente, dui_cliente, correo_cliente, telefono_cliente, nacimiento_cliente 
                from tb_clientes where id_cliente = ?;';
        $params = array($_SESSION['idCliente']);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_cliente
                FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia_cliente
                FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($_SESSION['idCliente']);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['contrasenia_cliente'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE tb_clientes
                SET contrasenia_cliente = ?, codigo_cliente = ?, fecha_contrasenia=?
                WHERE id_cliente = ?';
        $params = array($this->contrasenia, $this->codigo, $this->fechaContrasenia, $_SESSION['idCliente']);
        return Database::executeRow($sql, $params);
    }

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT*from tb_clientes
            where nombre_cliente like ?
            or apellido_cliente like ?
            or correo_cliente like ?
            or telefono_cliente like ?
            order by nombre_cliente';
        $params = array($value, $value, $value, $value  );
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, contrasenia_cliente, telefono_cliente, nacimiento_cliente, estado_cliente, imagen_cliente from tb_clientes
                ORDER BY nombre_cliente';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT* 
                FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRowEstado()
    {
        $sql = 'UPDATE tb_clientes
                SET estado_cliente = CASE 
                WHEN estado_cliente = 0 THEN 1 
                ELSE 0 END
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    // Método para crear un nuevo registro de cliente
    public function createRow()
    {
        $sql = 'INSERT INTO tb_clientes(nombre_cliente, apellido_cliente, dui_cliente, telefono_cliente, correo_cliente, contrasenia_cliente, nacimiento_cliente, codigo_cliente, fecha_contrasenia)
                    VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->telefono, $this->correo, $this->contrasenia, $this->nacimiento, $this->codigo, $this->fechaContrasenia);
        return Database::executeRow($sql, $params);
    }

    public function createAdminRow()
    {
        $sql = 'INSERT INTO tb_clientes(nombre_cliente, apellido_cliente, dui_cliente, telefono_cliente, correo_cliente, contrasenia_cliente, nacimiento_cliente, codigo_cliente, fecha_contrasenia, imagen_cliente)
                    VALUES(?, ?, ?, ?, ?, "$2y$10$1QuF.8fuqgt4TpohL8kXNeqyTfNFTx.zfHGrPoTRKGMsSt19VUcia", ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->telefono, $this->correo, $this->nacimiento, $this->codigo, $this->fechaContrasenia, $this->imagen);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_clientes
                WHERE id_cliente = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE tb_clientes
                SET nombre_cliente = ?, apellido_cliente = ?, dui_cliente = ?, correo_cliente = ?, telefono_cliente = ?, nacimiento_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->telefono, $this->nacimiento, $_SESSION['idCliente']);
        return Database::executeRow($sql, $params);
    }

    // Metodo para leer el perfil del cliente movil
    public function readOneCorreo($correo)
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, telefono_cliente, correo_cliente, nacimiento_cliente
                    FROM tb_clientes
                    WHERE correo_cliente = ?';
        $params = array($correo);
        return Database::getRow($sql, $params);
    }
    // métodos paa generar gráficas
    public function readClienteCitas()
    {
        $sql = 'SELECT s.tipo_servicio, 
                COUNT(c.id_cita) AS cantidad_citas,
                cl.nombre_cliente
                FROM tb_citas c
                JOIN tb_servicios s ON c.id_servicio = s.id_servicio 
                JOIN tb_clientes cl ON c.id_cliente = cl.id_cliente
                WHERE c.id_cliente = ?
                GROUP BY s.tipo_servicio';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    public function reporteCitasMesActual()
    {
        $sql = 'SELECT 
                    c.id_cita,
                    c.nombre_cita,
                    c.fecha_creacion_cita,
                    c.fecha_asignacion_cita,
                    c.estado_cita,
                    c.numero_seciones,
                    cl.nombre_cliente,
                    cl.apellido_cliente,
                    s.tipo_servicio,
                    e.nombre_empleado,
                    e.apellido_empleado
                FROM tb_citas c
                INNER JOIN tb_clientes cl ON c.id_cliente = cl.id_cliente
                INNER JOIN tb_servicios s ON c.id_servicio = s.id_servicio
                LEFT JOIN tb_empleados e ON c.id_empleado = e.id_empleado
                WHERE YEAR(c.fecha_creacion_cita) = YEAR(CURDATE()) 
                AND MONTH(c.fecha_creacion_cita) = MONTH(CURDATE());';
        return Database::getRows($sql);
    }

    public function clienteServicios()
    {
        $sql = 'SELECT DISTINCT 
                    s.id_servicio,
                    s.tipo_servicio,
                    s.descripcion_servicio
                FROM tb_clientes cl
                JOIN tb_citas c ON cl.id_cliente = c.id_cliente
                JOIN tb_servicios s ON c.id_servicio = s.id_servicio
                WHERE cl.id_cliente = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Método para leer un cliente.
    public function readOneRecuperacion()
    {
        $sql = 'SELECT a.id_cliente, a.correo_cliente, a.nombre_cliente, a.apellido_cliente, a.codigo_cliente
                    FROM tb_clientes a
                    WHERE a.correo_cliente =?';
        $params = array($this->correo);
        return Database::getRow($sql, $params);
    }


    // Método para verificar las credenciales del cliente al iniciar sesión
    public function checkUserCodigo($codigoUsuario)
    {
        $sql = 'SELECT id_cliente, correo_cliente, contrasenia_cliente, estado_cliente, codigo_cliente
                FROM tb_clientes
                WHERE codigo_cliente = ?';
        $params = array($codigoUsuario);
        // Verifica si la contraseña coincide con el hash almacenado y establece los datos del cliente si es válido
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } else {
            // Si la contrasenia coincide con el hash almacenado, se inicia la sesión del administrador.
            $_SESSION['idCliente'] = $data['id_cliente'];
            $_SESSION['correoCliente'] = $data['correo_cliente'];
            return true;
        }
        return false;
    }


//     // Método para verificar el inicio de sesión del administrador.
//     public function checkUserCodigo($codigoUsuario)
//     {
//         $sql = 'SELECT a.id_cliente, a.correo_cliente, a.nombre_cliente, a.codigo_cliente
//                     FROM tb_clientes a
//                     WHERE a.codigo_cliente =?';
//         $params = array($codigoUsuario);
//         // Se intenta obtener el registro del administrador según el correo.
//         if (!($data = Database::getRow($sql, $params))) {
//             return false; // Si no se encuentra el usuario, retorna falso.
//         } else {
//             // Si la contrasenia coincide con el hash almacenado, se inicia la sesión del administrador.
//             $_SESSION['idCliente'] = $data['id_cliente'];
//             $_SESSION['correo_cliente'] = $data['correo_cliente'];
//             return true; // Retorna verdadero indicando que el inicio de sesión fue exitoso.
//         }
//         return false; // Si la contrasenia no coincide, retorna falso.
//     }
}
