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
    protected $imagen = null;

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
        $sql = 'INSERT INTO tb_servicios (tipo_servicio, descripcion_servicio, id_imagen, id_empleado)
                VALUES(?, ?, ?, ?)';
        $params = array($this->servicio, $this->descripcion, $this->imagen, $_SESSION['idEmpleado']);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT s.id_servicio, s.tipo_servicio, s.descripcion_servicio, i.nombre_imagen, i.imagen_1, i.imagen_2, i.imagen_3, 
                s.id_empleado, e.nombre_empleado, e.apellido_empleado
                FROM tb_servicios
                INNER JOIN tb_imagenes i ON i.id_imagen = s.id_imagen
                INNER JOIN tb_empleados e ON s.id_empleado = e.id_empleado
                ORDER BY tipo_servicio';
        return Database::getRows($sql);
    }

    public function readAllGaleria()
    {
        $sql = ' SELECT imagen_1 AS imagen FROM tb_imagenes
UNION ALL
SELECT imagen_2 FROM tb_imagenes
WHERE imagen_2 IS NOT NULL
UNION ALL
SELECT imagen_3 FROM tb_imagenes
WHERE imagen_3 IS NOT NULL
ORDER BY RAND()
LIMIT 8;

                    ';
        return Database::getRows($sql);
    }

    public function readAll8()
    {
        $sql = 'SELECT s.id_servicio, s.tipo_servicio, s.descripcion_servicio, i.imagen_1
                FROM tb_servicios s
                INNER JOIN tb_imagenes i ON s.id_imagen = i.id_imagen
                ORDER BY RAND()
                LIMIT 8;
                ';
        return Database::getRows($sql);
    }

    public function readOne() 
    {
        $sql = 'SELECT s.id_servicio, s.tipo_servicio, s.descripcion_servicio, i.imagen_1, s.id_empleado
                FROM tb_servicios s
                INNER JOIN tb_imagenes i ON s.id_imagen = i.id_imagen
                WHERE id_servicio = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function readOnePublico() 
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
                SET tipo_servicio = ?, descripcion_servicio = ?, id_imagen = ?
                WHERE id_servicio = ?';
        $params = array($this->servicio, $this->descripcion, $this->imagen, $this->id);
        return Database::executeRow($sql, $params);
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
                FROM tb_servicios s
                LEFT JOIN tb_citas c ON s.id_servicio = c.id_servicio
                GROUP BY s.id_servicio, s.tipo_servicio
                LIMIT 5;';
        return Database::getRows($sql);
    }

    // métodos paa generar gráficas
    public function graficoPastelServicio()
    {
        $sql = 'WITH citas_por_semana AS (
                SELECT s.id_servicio, s.tipo_servicio, YEARWEEK(c.fecha_asignacion_cita, 1) AS semana,
                COUNT(c.id_cita) AS num_citas
                FROM tb_citas c
                JOIN tb_servicios s ON c.id_servicio = s.id_servicio
                WHERE c.fecha_asignacion_cita IS NOT NULL
                GROUP BY s.id_servicio, s.tipo_servicio, YEARWEEK(c.fecha_asignacion_cita, 1)),citas_agrupadas AS (
                SELECT id_servicio, tipo_servicio, AVG(num_citas) AS promedio_citas, COUNT(DISTINCT semana) AS semanas
                FROM citas_por_semana
                GROUP BY id_servicio, tipo_servicio)
                SELECT id_servicio, tipo_servicio,
                ROUND (promedio_citas) AS prediccion_citas_siguiente_semana
                FROM citas_agrupadas;';
        return Database::getRows($sql);
    }

    /*
     *   Métodos para generar reportes.
     */
    public function servicioCliente()
    {
        $sql = 'SELECT DISTINCT cl.id_cliente, cl.nombre_cliente, cl.apellido_cliente, c.numero_seciones, c.nombre_cita,
                    c.fecha_creacion_cita
                FROM tb_clientes cl
                INNER JOIN tb_citas c ON cl.id_cliente = c.id_cliente
                INNER JOIN tb_servicios s ON c.id_servicio = s.id_servicio
                WHERE c.id_servicio = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }
}
