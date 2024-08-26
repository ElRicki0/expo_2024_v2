<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla servicios.
 */

class Citahandler
{
    protected $id = null;
    protected $nombre = null;
    protected $fechaR = null;
    protected $fechaC = null;
    protected $estado = null;
    protected $sesiones = null;
    protected $cliente = null;
    protected $servicio = null;
    protected $empleado = null;
    protected $fechaI = null;
    protected $fechaF = null;
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT ct.id_cita, ct.nombre_cita, ct.fecha_asignacion_cita, ct.estado_cita, ct.numero_seciones, c.nombre_cliente, s.tipo_servicio
                from tb_citas ct
                join tb_clientes c on ct.id_cliente = c.id_cliente
                join tb_servicios s on ct.id_servicio = s.id_servicio
                WHERE nombre_cita LIKE ? OR estado_cita LIKE ? OR numero_seciones LIKE ? OR nombre_cliente LIKE ? OR fecha_asignacion_cita LIKE ?
                ORDER BY fecha_asignacion_cita';
        $params = array($value, $value, $value, $value, $value);
        return Database::getRows($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT ct.id_cita, ct.nombre_cita, ct.fecha_asignacion_cita, ct.estado_cita, ct.numero_seciones, c.nombre_cliente, ct.id_cliente, s.tipo_servicio
                from tb_citas ct
                join tb_clientes c on ct.id_cliente = c.id_cliente
                join tb_servicios s on ct.id_servicio = s.id_servicio';
        return Database::getRows($sql);
    }

    public function citasPorCliente()
    {
        $sql = 'SELECT ct.nombre_cita, ct.fecha_asignacion_cita, ct.fecha_creacion_cita, ct.estado_cita, ct.numero_seciones, c.nombre_cliente, ct.id_cliente, s.tipo_servicio
                from tb_citas ct
                join tb_clientes c on ct.id_cliente = c.id_cliente
                join tb_servicios s on ct.id_servicio = s.id_servicio
                WHERE ct.id_cliente = ?';
        $params = array($this->cliente);
        return Database::getRows($sql, $params);
    }

    public function readAllCliente()
    {
        $sql = 'SELECT ct.id_cita, ct.fecha_creacion_cita, ct.fecha_asignacion_cita, ct.estado_cita, ct.numero_seciones, s.tipo_servicio
                from tb_citas ct
                inner join tb_clientes c on ct.id_cliente = c.id_cliente
                inner join tb_servicios s on ct.id_servicio = s.id_servicio
                where ct.id_cliente = ? AND ct.estado_cita = "pendiente"';
        $params = array($_SESSION['idCliente']);
        return Database::getRows($sql, $params);
    }

    public function readAllClienteAprobado()
    {
        $sql = 'SELECT ct.id_cita, ct.fecha_creacion_cita, ct.fecha_creacion_cita, ct.numero_seciones, ct.fecha_asignacion_cita, ct.estado_cita, ct.numero_seciones, s.tipo_servicio, ep.nombre_empleado
                from tb_citas ct
                inner join tb_clientes c on ct.id_cliente = c.id_cliente
                inner join tb_servicios s on ct.id_servicio = s.id_servicio
                inner join tb_empleados ep on ct.id_empleado = ep.id_empleado

                where ct.id_cliente = ? AND ct.estado_cita <> "pendiente"';
        $params = array($_SESSION['idCliente']);
        return Database::getRows($sql, $params);
    }

    public function readOne()
    {
        $sql = 'SELECT *
                FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function createRow()
    {
        $sql = 'INSERT INTO tb_citas(nombre_cita, fecha_asignacion_cita, estado_cita, numero_seciones, id_cliente, id_servicio, id_empleado)
                VALUES(?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->fechaC, $this->estado, $this->sesiones, $this->cliente, $this->servicio, $this->empleado);
        return Database::executeRow($sql, $params);
    }

    public function createRowCliente()
    {
        $sql = 'INSERT INTO tb_citas ( id_cliente, id_servicio) 
                VALUES (?, ?)';
        $params = array($_SESSION['idCliente'], $this->servicio);
        return Database::executeRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_citas
                SET nombre_cita = ?, fecha_asignacion_cita = ?, estado_cita = ?, numero_seciones = ?, id_cliente = ?, id_servicio = ?, id_empleado= ? 
                WHERE id_cita = ?';
        $params = array($this->nombre, $this->fechaC, $this->estado, $this->sesiones, $this->cliente, $this->servicio, $this->empleado, $this->id);
        return Database::executeRow($sql, $params);
    }

    // Método deleteRow: elimina un empleado de la base de datos según su ID.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_citas
                WHERE id_cita = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    /*
    *   Métodos para generar gráficos.
    */
    public function readCantidadCliente()
    {
        $sql = 'SELECT
                    c.nombre_cliente,
                    COUNT(ct.id_cita) AS cantidad_citas
                FROM
                    tb_citas ct
                JOIN
                    tb_clientes c ON ct.id_cliente = c.id_cliente
                GROUP BY
                    c.id_cliente
                ORDER BY
                    cantidad_citas DESC
                LIMIT 5';
        return Database::getRows($sql);
    }

    public function readCantidadClientePendiente()
    {
        $sql = 'SELECT
                    c.nombre_cliente,
                    COUNT(ct.id_cita) AS cantidad_citas
                FROM
                    tb_citas ct
                JOIN
                    tb_clientes c ON ct.id_cliente = c.id_cliente
                WHERE
                    ct.estado_cita LIKE "pendiente"
                GROUP BY
                    c.id_cliente
                ORDER BY
                    cantidad_citas DESC
                    limit 5';
        return Database::getRows($sql);
    }

    public function readCantidadClienteEstado()
    {
        $sql = 'SELECT
                    estado_cita,
                    COUNT(*) AS cantidad_citas
                FROM
                    tb_citas
                WHERE
                    estado_cita IN ("pendiente", "proceso", "terminado")
                GROUP BY
                    estado_cita;';
        return Database::getRows($sql);
    }

    public function graficoBarrasPrediccionCitas()
    {
        $sql = 'WITH CitasSemanales AS (
                SELECT 
                    id_servicio,
                COUNT(*) AS citas_esta_semana
                FROM 
                    tb_citas
                WHERE 
                    YEARWEEK(fecha_asignacion_cita, 1) = YEARWEEK(NOW(), 1)
                GROUP BY 
                    id_servicio
                    )
                SELECT 
                    s.id_servicio,
                    s.tipo_servicio,
                ROUND(
                    CASE 
                WHEN COALESCE(cs.citas_esta_semana, 0) = 0 THEN 5
                ELSE COALESCE(cs.citas_esta_semana, 0) * 1.05
                    END, 
                    0
                    ) AS prediccion_proxima_semana
                    FROM 
                    tb_servicios s
                LEFT JOIN 
                        CitasSemanales cs ON s.id_servicio = cs.id_servicio
                ORDER BY 
                    s.id_servicio;
                    limit 5;';
        return Database::getRows($sql);
    }

    public function graficoEntreFechas()
    {
        $sql = 'SELECT 
            s.tipo_servicio, 
            COUNT(c.id_cita) AS cantidad_veces_realizado
        FROM 
            tb_citas c
        JOIN 
            tb_servicios s ON c.id_servicio = s.id_servicio
        WHERE c.fecha_asignacion_cita BETWEEN ? AND ?
        GROUP BY 
            s.tipo_servicio
        ';
        $params = array($this->fechaI, $this->fechaF);
        return Database::executeRow($sql, $params);
    }

    // métodos paa generar gráficas
    public function readClientesServicio()
    {
        $sql = 'SELECT 
                    cl.nombre_cliente, 
                    s.tipo_servicio,
                    COUNT(c.id_cita) AS cantidad_veces_solicitado
                FROM 
                    tb_citas c
                JOIN 
                    tb_clientes cl ON c.id_cliente = cl.id_cliente
                JOIN 
                    tb_servicios s ON c.id_servicio = s.id_servicio
                WHERE 
                    s.id_servicio = ?
                GROUP BY 
                    cl.nombre_cliente, s.tipo_servicio
                ORDER BY 
                    cantidad_veces_solicitado DESC;';
        $params = array($this->servicio);
        return Database::getRows($sql, $params);
    }


    public function reporteCitasMesActual()
    {
        $sql = 'SELECT 
                    c.id_cita,
                    c.nombre_cita,
                    c.fecha_creacion_cita,
                    c.fecha_asignacion_cita,
                    c.estado_cita,
                    c.numero_seciones,
                    cl.nombre_cliente,
                    cl.apellido_cliente,
                    s.tipo_servicio,
                    e.nombre_empleado,
                    e.apellido_empleado
                FROM 
                    tb_citas c
                INNER JOIN 
                    tb_clientes cl ON c.id_cliente = cl.id_cliente
                INNER JOIN 
                    tb_servicios s ON c.id_servicio = s.id_servicio
                LEFT JOIN 
                    tb_empleados e ON c.id_empleado = e.id_empleado
                WHERE 
                    YEAR(c.fecha_creacion_cita) = YEAR(CURDATE()) AND 
                    MONTH(c.fecha_creacion_cita) = MONTH(CURDATE());';
                    
        return Database::getRows($sql);
    }
}
