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
    protected $telefono = null;
    protected $nacimiento = null;
    protected $estado = null;

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT*from tb_clientes where 
        nombre_cliente like ? or apellido_cliente like ? or dui_cliente like ? or correo_cliente like ? or telefono_cliente like ? 
        or nacimiento_cliente like ? or estado_cliente like ?
        order by nombre_cliente';
        $params = array($value, $value, $value, $value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_cliente, correo_cliente, contrasenia_cliente, telefono_cliente, nacimiento_cliente, estado_cliente from tb_clientes
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
                SET estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

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
            $_SESSION['correo_cliente'] = $this->correo;
            return true;
        } else {
            return false;
        }
    }

    // Método para crear un nuevo registro de cliente
    public function createRow()
    {
        $sql = 'INSERT INTO tb_clientes(nombre_cliente, apellido_cliente, dui_cliente, telefono_cliente, correo_cliente, contrasenia_cliente, nacimiento_cliente)
                    VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->apellido, $this->dui, $this->telefono, $this->correo, $this->contrasenia, $this->nacimiento);
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
}
