<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/servicio_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de servicios');
// Se instancia el modelo Servicios para obtener los datos.
$servicio = new ServicioData;
if ($dataServicio = $servicio->readAll()) {
    
    // Establecer el color de fondo verde oscuro para los encabezados.
    $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

    // Establecer la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Imprimir las celdas con los encabezados.
    $pdf->cell(28, 10, 'Identificador', 'TB', 0, 'C', 1);
    $pdf->cell(62, 10, 'Tipo de servicio', 'TB', 0, 'C', 1);
    $pdf->cell(100, 10, 'Descripcion', 'TB', 1, 'C', 1);

    // Establecer la fuente para los datos de los servicios.
    $pdf->setFont('Arial', '', 11);

    // Recorrer los registros fila por fila.
    foreach ($dataServicio as $servicioRow) {

        // Imprimir identificador, tipo de servicio y descripcion.
        $pdf->cell(28, 10, $servicioRow['id_servicio'], 'T', 0, 'C');
        $pdf->cell(62, 10, $pdf->encodeString($servicioRow['tipo_servicio']), 'T', 0, 'C');
        $pdf->MultiCell(100, 10, $pdf->encodeString($servicioRow['descripcion_servicio']), 'T', 'J');
    }
} else {
    // Si no hay servicios para mostrar
    $pdf->cell(0, 10, $pdf->encodeString('No hay servicios para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Servicios.pdf');