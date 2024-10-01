<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class ImagenHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $nombre = null;
    protected $imagen1 = null;
    protected $imagen2 = null;
    protected $imagen3 = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/imagenes/';

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT * FROM tb_imagenes
        where nombre_imagen like ?';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_imagenes(nombre_imagen, imagen_1, imagen_2, imagen_3)
                VALUES(?, ?, ?, ?)';
        $params = array($this->nombre, $this->imagen1, $this->imagen2, $this->imagen3);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_imagenes
                SET nombre_imagen = ?, imagen_1 = ?, imagen_2 = ?, imagen_3 = ?
                WHERE id_imagen = ?';
        $params = array($this->nombre, $this->imagen1, $this->imagen2, $this->imagen3, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT * FROM tb_imagenes';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT*FROM tb_imagenes 
                where id_imagen = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_1, imagen_2, imagen_3
                FROM tb_imagenes
                WHERE id_imagen = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_imagenes
                WHERE id_imagen = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
