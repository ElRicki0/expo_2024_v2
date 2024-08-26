<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se verifica si existe un valor para el cliente, de lo contrario se muestra un mensaje.
if (isset($_GET['idCliente'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/cliente_data.php');
    require_once('../../models/data/cita_data.php');

    // Se instancian las entidades correspondientes.
    $cliente = new ClienteData;
    $cita = new CitaData;

    // Se establece el valor del cliente.
    if ($cliente->setId($_GET['idCliente'])) {
        // Se verifica si el cliente existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Citas realizadas por: ' . $rowCliente['nombre_cliente']);

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataClientes = $cliente->reporteCitasMesActual()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(0, 21, 26);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 15);
                $pdf->SetTextColor(223, 223, 223);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(85, 10, 'Nombre Cita', 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Número de Secciones', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Estado', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Servicio', 1, 1, 'C', 1);

                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', '', 12);

                // Se recorren los registros fila por fila.
                foreach ($dataClientes as $rowCliente) {
                    $pdf->SetTextColor(10, 10, 10);
                    $pdf->cell(85, 10, $pdf->encodeString($rowCliente['nombre_cita']), 1, 0, 'C');
                    $pdf->cell(30, 10, $rowCliente['numero_seciones'], 1, 0, 'C');
                    $pdf->cell(40, 10, $rowCliente['estado_cita'], 1, 0, 'C');
                    $pdf->cell(40, 10, $rowCliente['tipo_servicio'], 1, 1, 'C');
                }
            } else {
                $pdf->SetTextColor(10, 10, 10);
                $pdf->setFont('Times', 'B', 16);
                $pdf->cell(0, 10, $pdf->encodeString('No hay citas para este cliente en el mes actual'), 1, 1, 'C');
            }

            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Citas_cliente.pdf');
        } else {
            // Mensaje en caso de que el cliente no exista.
            print('Cliente inexistente');
        }
    } else {
        // Mensaje en caso de que el cliente sea incorrecto.
        print('Cliente incorrecto');
    }
} else {
    // Mensaje en caso de que no se haya seleccionado un cliente.
    print('Debe seleccionar un cliente');
}
?>
