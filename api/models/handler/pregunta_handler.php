<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class PreguntasHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $imagen = null;
    protected $pregunta = null;
    protected $contenido = null;
    protected $empleado = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/preguntas/';

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT p.id_pregunta, p.imagen_pregunta, p.nombre_pregunta, p.contenido_pregunta, e.nombre_empleado
                    FROM tb_preguntas p
                    JOIN tb_empleado e ON p.id_empleado = e.id_empleado
                WHERE nombre_pregunta LIKE ? OR contenido_pregunta LIKE ? or nombre_empleado like ?
                ORDER BY nombre_pregunta';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_preguntas(imagen_pregunta, nombre_pregunta, contenido_pregunta, id_empleado)
                VALUES(?, ?, ?, ?)';
        $params = array($this->imagen, $this->pregunta, $this->contenido, $this->empleado);
        return Database::executeRow($sql, $params);
    }
    
    public function readAll()
    {
        $sql = 'SELECT p. id_pregunta, p.imagen_pregunta, p.nombre_pregunta, p.contenido_pregunta, e.nombre_empleado
                FROM tb_preguntas p
                JOIN tb_empleado e ON p.id_empleado = e.id_empleado ';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT*FROM tb_preguntas 
                where id_pregunta = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readFilename()
    {
        $sql = 'SELECT imagen_pregunta
                FROM tb_preguntas
                WHERE id_pregunta = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_preguntas
                SET  nombre_pregunta = ?, contenido_pregunta = ?, id_empleado = ?
                WHERE id_pregunta = ?';
        $params = array($this->pregunta, $this->contenido, $this->empleado, $this->id);
        return Database::executeRow($sql, $params);
    }    

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_preguntas
                WHERE id_pregunta = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
