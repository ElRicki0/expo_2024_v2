<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */

 class Citahandler{
    protected $id = null;
    protected $fecha = null;
    protected $estado = null;
    protected $seciones = null;
    protected $id_cliente = null;
    protected $id_servicio = null;
    protected $id_empleado = null;


    public function searchRows() {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT*from tb_citas where 
        fecha_cita like ? or estado_cita like ? or numero_seciones like ? or id_cliente like ? or id_servicio like ? or id_empleado like ?
        order by fecha_cita';
        $params = array($value, $value, $value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cita, fecha_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado
                from tb_citas
                ORDER BY fecha_cita';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_cita, fecha_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado
                FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_citas
                SET fecha_cita = ?, estado_cita = ?, numero_seciones = ? id_cliente = ?, id_servicio = ?, id_empleado = ? 
                WHERE id_cita = ?';
        $params = array($this->fecha, $this->estado, $this->seciones, $this->id_cliente, $this->id_servicio, $this->id_empleado, $this->id);
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