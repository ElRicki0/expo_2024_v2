<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la servicio, de lo contrario se muestra un mensaje.
if (isset($_GET['idServicio'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/servicio_data.php');
    require_once('../../models/data/cliente_data.php');
    // Se instancian las entidades correspondientes.
    $servicio = new ServicioData;
    $cliente = new ClienteData;
    // Se establece el valor de la servicio, de lo contrario se muestra un mensaje.
    if ($servicio->setId($_GET['idServicio'])) {

        // Se verifica si la servicio existe, de lo contrario se muestra un mensaje.
        if ($rowServicio = $servicio->readOne()) {

            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Clientes del servicio: ' . $rowServicio['tipo_servicio']);

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataServicio = $servicio->servicioCliente()) {

                // Establecer el color de fondo verde oscuro para los encabezados.
                $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

                // Se establece la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);

                // Se imprimen las celdas con los encabezados.
                $pdf->cell(50, 10, 'Nombre cliente', 'TB', 0, 'C', 1);
                $pdf->cell(60, 10, 'Nombre de la cita', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Secciones', 'TB', 0, 'C', 1);
                $pdf->cell(50, 10, $pdf->encodeString('Fecha de creación'), 'TB', 1, 'C', 1);

                // Se establece la fuente para los datos de los clientes.
                $pdf->setFont('Arial', '', 11);

                // Se recorren los registros fila por fila.
                foreach ($dataServicio as $rowServicio) {
                    
                    // Se imprimen las celdas con los datos de los clientes.
                    $nombreCompleto = $rowServicio['nombre_cliente'] . ' ' . $rowServicio['apellido_cliente'];

                    // Imprimir el nombre completo en una sola celda
                    $pdf->cell(50, 10, $nombreCompleto, 'T', 0, 'C');
                    $pdf->cell(60, 10, $rowServicio['nombre_cita'], 'T', 0, 'C');
                    $pdf->cell(30, 10, $rowServicio['numero_seciones'], 'T', 0, 'C');
                    $pdf->cell(50, 10, $rowServicio['fecha_creacion_cita'], 'T', 1, 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay clientes para el servicio'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Servicio.pdf');
        } else {
            print ('Servicio inexistente');
        }
    } else {
        print ('Servicio incorrecto');
    }
} else {
    print ('Debe seleccionar un servicio');
}