<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
 *	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
 */
class TratamientoHandler
{
    /*
     *   Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $nota = null;
    protected $cita = null;

    /*
     *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT nt.id_tratamiento, nt.nombre_tratamiento, nt.notas_adicionales, c.nombre_cita
                from tb_nombres_tratamientos nt 
                join tb_citas c on nt.id_cita = c.id_cita
                WHERE nombre_tratamiento LIKE
                ORDER BY nombre_tratamiento';
        $params = array($value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_nombres_tratamientos(nombre_tratamiento, notas_adicionales, id_cita)
                VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->nota, $this->cita);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT nt.id_tratamiento, nt.nombre_tratamiento, nt.notas_adicionales, c.nombre_cita
                from tb_nombres_tratamientos nt 
                join tb_citas c on nt.id_cita = c.id_cita
                ORDER BY nombre_tratamiento';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT * FROM tb_nombres_tratamientos
                WHERE id_tratamiento = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_nombres_tratamientos
                SET nombre_tratamiento = ?, notas_adicionales = ?, id_cita = ?
                WHERE id_tratamiento = ?';
        $params = array($this->nombre, $this->nota, $this->cita, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_nombres_tratamientos
                WHERE id_tratamiento = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}