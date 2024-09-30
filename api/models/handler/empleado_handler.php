<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla empleados.
 */

class EmpleadoHandler
{

    /*
     *  Declaración de atributos para el manejo de datos.
     */

    protected $id = null;
    protected $nombre = null;
    protected $apellido = null;
    protected $dui = null;
    protected $correo = null;
    protected $fecha = null;
    protected $estado = null;

    /*
     *  Métodos para gestionar la cuenta del empleado.
     */

    public function updateRowEstado()
    {
        $sql = 'UPDATE tb_empleados
                SET estado_empleado = CASE 
                WHEN estado_empleado = 0 THEN 1 
                ELSE 0 END
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    // Método searchRows: busca empleados en la base de datos según un criterio de búsqueda.
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT *
                FROM tb_empleados
                WHERE nombre_empleado LIKE ? or dui_empleado like ? or correo_empleado  like ? or nacimiento_empleado like ?
                ORDER BY nombre_empleado';
        $params = array($value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    // Método createRow: inserta un nuevo empleado en la base de datos.
    public function createRow()
    {
        $sql = 'INSERT INTO tb_empleados(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado)
                VALUES(?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->fecha, $this->estado);
        return Database::executeRow($sql, $params);
    }

    // Método createRow: inserta un nuevo empleado en la base de datos.
    public function createNewRow()
    {
        $sql = 'INSERT INTO tb_empleados(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado)
                VALUES(?, ?, ?, ?, ?, 1)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->fecha);
        return Database::executeRow($sql, $params);
    }

    // Método readAll: lee todos los empleados de la base de datos.
    public function readAll()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado, especialidad_empleado, imagen_empleado
                FROM tb_empleados
                ORDER BY nombre_empleado';
        return Database::getRows($sql);
    }
    
    // Método readAll: lee todos los empleados de la base de datos.
    public function readAllOne()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado, especialidad_empleado, imagen_empleado
                FROM tb_empleados
                WHERE id_empleado <> ?';
        $params = array($_SESSION['idEmpleado']);
        // Se obtiene la información del perfil del administrador actual.
        return Database::getRows($sql, $params);
    }

    // Método readAll: lee todos los empleados de la base de datos.
    public function readIndex()
    {
        $sql = 'SELECT * FROM tb_empleados
                ORDER BY RAND()
                LIMIT 3';
        return Database::getRows($sql);
    }

    // Método readOne: lee un empleado específico de la base de datos según su ID.
    public function readOne()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado
                FROM tb_empleados
                WHERE id_empleado = ? AND  id_empleado <> ?';
        $params = array($this->id, $_SESSION['idEmpleado']);
        return Database::getRow($sql, $params);
    }

    // Método updateRow: actualiza los datos de un empleado en la base de datos.
    public function updateRow()
    {
        $sql = 'UPDATE tb_empleados
                SET nombre_empleado = ?, apellido_empleado = ?, dui_empleado = ?, correo_empleado = ?, nacimiento_empleado = ?, estado_empleado=?
                WHERE id_empleado = ?';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->correo, $this->fecha, $this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Método deleteRow: elimina un empleado de la base de datos según su ID.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_empleados
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    public function checkUserCodigoSesion($codigoUsuario)
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

    /*
     *   Métodos para generar gráficos.
     */
    public function readEstadoEmpleado()
    {
        $sql = 'SELECT 
                    CASE 
                        WHEN estado_empleado = 0 THEN "Inactivo"
                        WHEN estado_empleado = 1 THEN "Activo"
                    END AS estado,
                    COUNT(*) AS cantidad
                FROM tb_empleados
                GROUP BY estado_empleado;';
        return Database::getRows($sql);
    }

    public function readCantidadServiciosEmpleado()
    {
        $sql = 'SELECT 
                    e.id_empleado,
                    e.nombre_empleado,
                    s.tipo_servicio,
                    COUNT(*) AS cantidad_servicios
                FROM tb_citas c
                JOIN tb_servicios s ON c.id_servicio = s.id_servicio
                JOIN tb_empleados e ON c.id_empleado = e.id_empleado
                WHERE c.id_empleado = ?
                GROUP BY e.id_empleado, s.tipo_servicio
                ORDER BY e.id_empleado, s.tipo_servicio;';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}