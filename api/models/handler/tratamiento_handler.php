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
     // Método para buscar filas en la tabla según un valor de búsqueda.
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
    // Método para crear una nueva fila en la tabla de tratamientos.
    public function createRow()
    {
        $sql = 'INSERT INTO tb_nombres_tratamientos(nombre_tratamiento, notas_adicionales, id_cita)
                VALUES(?, ?, ?)';
        $params = array($this->nombre, $this->nota, $this->cita);
        return Database::executeRow($sql, $params);
    }

    // Método para leer todas las filas de la tabla de tratamientos.
    public function readAll()
    {
        $sql = 'SELECT nt.id_tratamiento, nt.nombre_tratamiento, nt.notas_adicionales, c.nombre_cita
                from tb_nombres_tratamientos nt 
                join tb_citas c on nt.id_cita = c.id_cita
                ORDER BY nombre_tratamiento';
        return Database::getRows($sql);
    }
    // Método para leer una fila específica de la tabla de tratamientos según el ID.
    public function readOne()
    {
        $sql = 'SELECT * FROM tb_nombres_tratamientos
                WHERE id_tratamiento = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    // Método para actualizar una fila existente en la tabla de tratamientos.
    public function updateRow()
    {
        $sql = 'UPDATE tb_nombres_tratamientos
                SET nombre_tratamiento = ?, notas_adicionales = ?, id_cita = ?
                WHERE id_tratamiento = ?';
        $params = array($this->nombre, $this->nota, $this->cita, $this->id);
        return Database::executeRow($sql, $params);
    }
    // Método para eliminar una fila de la tabla de tratamientos.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_nombres_tratamientos
                WHERE id_tratamiento = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}