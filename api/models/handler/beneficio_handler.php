<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');
/*
*	Clase para manejar el comportamiento de los datos de la tabla PRODUCTO.
*/
class BeneficioHandler
{
    /*
    *   Declaración de atributos para el manejo de datos.
    */
    protected $id = null;
    protected $titulo = null;
    protected $contenido = null;
    protected $servicio = null;

    /*
    *   Métodos para realizar las operaciones SCRUD (search, create, read, update, and delete).
    */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT b.titulo_beneficio, b.contenido_beneficio, s.tipo_servicio 
                FROM tb_beneficios b
                join  tb_servicios s ON b.id_servicio = s.id_servicio
                WHERE titulo_beneficio LIKE ?
                ORDER BY titulo_beneficio';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_beneficios(titulo_beneficio, contenido_beneficio, id_servicio)
                VALUES(?, ?, ?)';
        $params = array($this->titulo, $this->contenido, $this->servicio);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT b. id_beneficio, b.titulo_beneficio, b.contenido_beneficio, s.tipo_servicio 
                    FROM tb_beneficios b
                    join  tb_servicios s ON b.id_servicio = s.id_servicio ';
        return Database::getRows($sql);
    }

    public function readAllOne()
    {
        $sql = 'SELECT b. id_beneficio, b.titulo_beneficio, b.contenido_beneficio, s.tipo_servicio 
                    FROM tb_beneficios b
                    join  tb_servicios s ON b.id_servicio = s.id_servicio 
                    where b.id_servicio = ?';
        $params = array($this->servicio);
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT*FROM tb_beneficios 
                where id_beneficio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    public function updateRow()
    {
        $sql = 'UPDATE tb_beneficios
                SET  titulo_beneficio = ?, contenido_beneficio = ?, id_servicio = ?
                WHERE id_beneficio = ?';
        $params = array($this->titulo, $this->contenido, $this->servicio, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_beneficios
                WHERE id_beneficio = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
