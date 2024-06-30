<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla empleados.
 */

class EmpleadoHandler{

    /*
     *  Declaración de atributos para el manejo de datos.
     */

    protected $id = null;
    protected $nombre = null;
    protected $dui = null;
    protected $telefono = null;
    protected $correo = null;
    protected $fecha = null;
    protected $estado = null;

    /*
     *  Métodos para gestionar la cuenta del empleado.
     */

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

    public function changeStatus()
    {
        $sql = 'UPDATE tb_clientes
                SET estado_cliente = ?
                WHERE id_cliente = ?';
        $params = array($this->estado, $this->id);
        return Database::executeRow($sql, $params);
    }

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    public function searchRows() {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_cliente, nombre_cliente, apellido_cliente, dui_client, telf_cliente, correo_cliente
                FROM tb_clientes
                WHERE apellido_cliente LIKE ? OR nombre_cliente LIKE ?
                ORDER BY apellido_cliente';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_empleado(nombre_empleado, dui_empleado, correo_empleado, telefono_empleado, nacimiento_empleado)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->dui, $this->correo, $this->telefono, $this->fecha);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, dui_empleado, correo_empleado, telefono_empleado, nacimiento_empleado
                FROM tb_empleado
                ORDER BY nombre_empleado';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_empleado, nombre_empleado, dui_empleado, correo_empleado, telefono_empleado, nacimiento_empleado
                FROM tb_empleado
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_empleado
                SET nombre_empleado = ?, dui_empleado = ?, correo_empleado = ?, telefono_empleado = ?, nacimiento_empleado = ?
                WHERE id_empleado = ?';
        $params = array($this->nombre, $this->dui, $this->correo, $this->telefono, $this->fecha, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_empleado
                WHERE id_empleado = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}