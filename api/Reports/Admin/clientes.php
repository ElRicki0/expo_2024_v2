<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/cliente_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de clientes');
// Se instancia el modelo Administrador para obtener los datos.
$cliente = new ClienteData;
// Se verifica si existen registros de administradores para mostrar, de lo contrario se imprime un mensaje.
if ($dataClientes = $cliente->readAll()) {

    // Establecer el color de fondo verde oscuro para los encabezados.
    $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

    // Establecer la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);

    // Imprimir las celdas con los encabezados.
    $pdf->cell(38, 10, 'Nombre completo', 'TB', 0, 'C', 1);
    $pdf->cell(38, 10, 'DUI', 'TB', 0, 'C', 1);
    $pdf->cell(40, 10, 'Correo', 'TB', 0, 'C', 1);
    $pdf->cell(38, 10, 'Telefono', 'TB', 0, 'C', 1);
    $pdf->cell(35, 10, $pdf->encodeString('Nacimiento'), 'TB', 1, 'C', 1);


    // Establecer la fuente para los datos de los administradores.
    $pdf->setFont('Arial', '', 11);

    // Recorrer los registros fila por fila.
    foreach ($dataClientes as $rowClientes) {

        // Concatenar nombre y apellido
        $nombreCompleto = $rowClientes['nombre_cliente'] . ' ' . $rowClientes['apellido_cliente'];

        // Imprimir el nombre completo en una sola celda
        $pdf->cell(38, 10, $nombreCompleto, 'T', 0, 'J');

        // Imprimir contacto y cumpleaños
        $pdf->cell(38, 10, $rowClientes['dui_cliente'], 'T', 0, 'C');
        $pdf->cell(40, 10, $rowClientes['correo_cliente'], 'T', 0, 'C');
        $pdf->cell(38, 10, $rowClientes['telefono_cliente'], 'T', 0, 'C');
        $pdf->cell(35, 10, $rowClientes['nacimiento_cliente'], 'T', 1, 'C');
    }
} else {
    // Si no hay empleados para mostrar
    $pdf->cell(0, 10, $pdf->encodeString('No hay clientes para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Clientes.pdf');