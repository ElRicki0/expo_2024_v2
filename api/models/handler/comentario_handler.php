<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */
class ComentarioHandler
{
    protected $id = null;
    protected $comentario = null;
    protected $cliente = null;
    protected $servicio = null;
    protected $estado = null;

    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT c.id_comentario, c.contenido_comentario, cl.nombre_cliente, s.tipo_servicio
                    from tb_comentarios c
                    join tb_clientes cl on c.id_cliente= cl.id_cliente
                    join tb_servicios s on c.id_servicio = s.id_servicio
                WHERE contenido_comentario LIKE ? OR nombre_cliente LIKE ?
                ORDER BY contenido_comentario';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT c.id_comentario, c.contenido_comentario, cl.nombre_cliente, s.tipo_servicio, c.estado_comentario
                    from tb_comentarios c
                    join tb_clientes cl on c.id_cliente= cl.id_cliente
                    join tb_servicios s on c.id_servicio = s.id_servicio
                ORDER BY contenido_comentario';
        return Database::getRows($sql);
    }

    public function readIndex()
    {
        $sql = 'SELECT cm.id_comentario, cm.contenido_comentario, cm.estado_comentario, cl.nombre_cliente, cl.apellido_cliente, sv.tipo_servicio, sv.imagen_servicio
                FROM tb_comentarios cm
                INNER JOIN tb_clientes cl ON cl.id_cliente = cm.id_cliente
                INNER JOIN tb_servicios sv ON cm.id_servicio = cm.id_servicio 
                ORDER by RAND()
                limit 3
        ';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT* 
                FROM tb_comentarios
                WHERE id_comentario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRowEstado()
    {
        $sql = 'UPDATE tb_comentarios
                SET estado_comentario = CASE 
                WHEN estado_comentario = 0 THEN 1 
                ELSE 0 END
                WHERE id_comentario = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}