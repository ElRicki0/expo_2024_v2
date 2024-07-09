<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */

class ServicioHandler
{
    protected $id = null;
    protected $servicio = null;
    protected $descripcion = null;
    protected $foto = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/servicios/';

    /*
     *  Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
     */

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT *
                FROM tb_servicios
                WHERE tipo_servicio LIKE ? OR descripcion_servicio like ? 
                ORDER BY tipo_servicio';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }
    

    public function createRow()
    {
        $sql = 'INSERT INTO tb_servicios (tipo_servicio, descripcion_servicio, imagen_servicio)
                VALUES(?, ?, ?)';
        $params = array($this->servicio, $this->descripcion, $this->foto);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT *
                FROM tb_servicios
                ORDER BY tipo_servicio';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT *
                FROM tb_servicios
                WHERE id_servicio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_servicios
                SET tipo_servicio = ?, descripcion_servicio = ?, imagen_servicio = ?
                WHERE id_servicio = ?';
        $params = array($this->servicio, $this->descripcion, $this->foto, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_servicio 
                FROM tb_servicios
                WHERE id_servicio  = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_servicios
                WHERE id_servicio = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
