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

    /*
     * Métodos para realizar las operaciones CRUD (Create, Read, Update, Delete) y búsqueda.
     */

    // Método para buscar comentarios en la base de datos según un término de búsqueda.
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
    // Método para obtener todos los comentarios registrados en la base de datos.
    public function readAll()
    {
        $sql = 'SELECT c.id_comentario, c.contenido_comentario, cl.nombre_cliente, s.tipo_servicio, c.estado_comentario
                from tb_comentarios c
                join tb_clientes cl on c.id_cliente= cl.id_cliente
                join tb_servicios s on c.id_servicio = s.id_servicio
                ORDER BY contenido_comentario';
        return Database::getRows($sql);
    }
    // Método para obtener comentarios al azar y mostrarlos en el índice o página principal, limitado a 3 comentarios.
    public function readIndex(): array|bool
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

    public function createRow()
    {
        $sql = 'INSERT INTO tb_com(nombre_empleado, apellido_empleado, dui_empleado, correo_empleado, nacimiento_empleado, estado_empleado, imagen_empleado)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->comentario, $this->cliente, $this->servicio, $this->estado);
        return Database::executeRow($sql, $params);
    }

    // Método para obtener un comentario específico según su ID.
    public function readOne()
    {
        $sql = 'SELECT* 
                FROM tb_comentarios
                WHERE id_comentario = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }
    // Método para cambiar el estado del comentario (activarlo o desactivarlo).
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
