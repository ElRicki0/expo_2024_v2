<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */

class Citahandler
{
    protected $id = null;
    protected $nombre = null;
    protected $fecha = null;
    protected $estado = null;
    protected $sesiones = null;
    protected $cliente = null;
    protected $servicio = null;
    protected $empleado = null;


    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT ct.id_cita, ct.nombre_cita, ct.fecha_cita, ct.estado_cita, ct.numero_seciones, c.nombre_cliente, s.tipo_servicio, e.nombre_empleado
                from tb_citas ct
                join tb_clientes c on ct.id_cliente = c.id_cliente
                join tb_empleados e on ct.id_empleado = e.id_empleado
                join tb_servicios s on ct.id_servicio = s.id_servicio
                WHERE nombre_cita LIKE ? OR estado_cita LIKE ? OR numero_seciones LIKE ? OR nombre_cliente LIKE ? OR nombre_empleado LIKE ?
                ORDER BY fecha_cita';
        $params = array($value, $value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT ct.id_cita,  ct.nombre_cita, ct.fecha_cita, ct.estado_cita, ct.numero_seciones, c.nombre_cliente, s.tipo_servicio, e.nombre_empleado
                from tb_citas ct
                join tb_clientes c on ct.id_cliente = c.id_cliente
                join tb_empleados e on ct.id_empleado = e.id_empleado
                join tb_servicios s on ct.id_servicio = s.id_servicio
                ORDER BY fecha_cita';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT *
                FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_citas(nombre_cita, fecha_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->fecha, $this->estado, $this->sesiones, $this->cliente, $this->servicio, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_citas
                SET nombre_cita = ?, fecha_cita = ?, estado_cita = ?, numero_seciones = ?, id_cliente = ?, id_servicio = ?, id_empleado= ? 
                WHERE id_cita = ?';
        $params = array($this->nombre, $this->fecha, $this->estado, $this->sesiones, $this->cliente, $this->servicio, $this->empleado, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Método deleteRow: elimina un empleado de la base de datos según su ID.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
