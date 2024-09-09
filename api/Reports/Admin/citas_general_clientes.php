<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/cita_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de citas del mes');
// Se instancia el modelo Administrador para obtener los datos.
$cita = new CitaData;
// Se verifica si existen registros de administradores para mostrar, de lo contrario se imprime un mensaje.
if ($CitaData = $cita->readAll()) {
    // Establecer el color de fondo verde oscuro para los encabezados.
    $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

    // Establecer la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Imprimir las celdas con los encabezados.
    $pdf->cell(70, 10, 'Nombre Cita', 'TB', 0, 'C', 1);
    $pdf->cell(35, 10, 'Secciones', 'TB', 0, 'C', 1);
    $pdf->cell(40, 10, 'Estado', 'TB', 0, 'C', 1);
    $pdf->cell(40, 10, 'Servicio', 'TB', 1, 'C', 1);

    // Establecer la fuente para los datos de los administradores.
    $pdf->setFont('Arial', '', 11);

    // Recorrer los registros fila por fila.
    foreach ($CitaData as $citasRow) {

        // Imprimir nombrem correo y identificador
        $pdf->SetTextColor(10, 10, 10);
        $pdf->cell(70, 10, $pdf->encodeString($citasRow['nombre_cita']), 'T', 0, 'C');
        $pdf->cell(35, 10, $citasRow['numero_seciones'], 'T', 0, 'C');
        $pdf->cell(40, 10, $citasRow['estado_cita'], 'T', 0, 'C');
        $pdf->cell(40, 10, $pdf->encodeString($citasRow['tipo_servicio']), 'T', 1, 'C');
    }
} else {
    // Si no hay administradores para mostrar
    $pdf->cell(0, 10, $pdf->encodeString('No hay administradores para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Administradores.pdf');