<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/administrador_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de administradores');
// Se instancia el modelo Administrador para obtener los datos.
$administrador = new AdministradorData;
// Se verifica si existen registros de administradores para mostrar, de lo contrario se imprime un mensaje.
if ($dataAdministrador = $administrador->readAll()) {
    // Establecer el color de fondo verde oscuro para los encabezados.
    $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

    // Establecer la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Imprimir las celdas con los encabezados.
    $pdf->cell(62, 10, 'Identificador', 'TB', 0, 'C', 1);
    $pdf->cell(62, 10, 'Nombre de administrador', 'TB', 0, 'C', 1);
    $pdf->cell(62, 10, 'Contacto', 'TB', 1, 'C', 1);

    // Establecer la fuente para los datos de los administradores.
    $pdf->setFont('Arial', '', 11);

    // Recorrer los registros fila por fila.
    foreach ($dataAdministrador as $administradorRow) {

        // Imprimir nombrem correo y identificador
        $pdf->cell(62, 10, $administradorRow['id_admin'], 'TB', 0, 'C');
        $pdf->cell(62, 10, $administradorRow['nombre_admin'], 'TB', 0, 'C');
        $pdf->cell(62, 10, $administradorRow['correo_admin'], 'TB', 1, 'C');
    }
} else {
    // Si no hay administradores para mostrar
    $pdf->cell(0, 10, $pdf->encodeString('No hay administradores para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Administradores.pdf');
