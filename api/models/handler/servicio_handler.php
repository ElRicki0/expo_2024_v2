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

    public function searchPublicRows()
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

    public function readAll8()
    {
        $sql = 'SELECT *
                FROM tb_servicios
                ORDER BY tipo_servicio
                limit 8';
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

    /*
    *   Métodos para generar gráficos.
    */
    public function readCantidadCitas()
    {
        $sql = 'SELECT
                    s.id_servicio,
                    s.tipo_servicio,
                    COUNT(c.id_cita) AS cantidad_citas
                FROM
                    tb_servicios s
                LEFT JOIN
                    tb_citas c ON s.id_servicio = c.id_servicio
                GROUP BY
                    s.id_servicio, s.tipo_servicio
                	LIMIT 5;';
        return Database::getRows($sql);
    }

    public function readCantidadBeneficios()
    {
        $sql = 'SELECT
                    s.id_servicio,
                    s.tipo_servicio,
                    s.descripcion_servicio,
                    s.imagen_servicio,
                    COUNT(b.id_beneficio) AS cantidad_beneficios
                FROM
                    tb_servicios s
                LEFT JOIN
                    tb_beneficios b ON s.id_servicio = b.id_servicio
                GROUP BY
                    s.id_servicio, s.tipo_servicio, s.descripcion_servicio, s.imagen_servicio
                ORDER BY
                    cantidad_beneficios DESC;';
        return Database::getRows($sql);
    }

    
}
