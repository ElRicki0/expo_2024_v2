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


    public function searchRows() {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT*from tb_citas where 
        fecha_cita like ? or estado_cita like ? or numero_seciones like ? 
        order by fecha_cita';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_cita, fecha_cita, estado_cita, numero_seciones from tb_citas
                ORDER BY fecha_cita';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT* 
                FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_citas
                SET estado_cita = ?
                WHERE id_cita = ?';
        $params = array($this->estado, $this->id);
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