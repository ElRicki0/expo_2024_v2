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

    // Se establece el valor del cliente, de lo contrario se muestra un mensaje.
    if ($cliente->setId($_GET['idCliente']) && $cita->setId($_GET['idCliente'])) {
        // Se verifica si el cliente existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readOne()) {
            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Cita realizados por : ' . $rowCliente['nombre_cliente']);

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataClientes = $cliente->reporteCitasMesActual()) {
                // Se establece un color de relleno para los encabezados.
                $pdf->setFillColor(0, 21, 26);
                // Se establece la fuente para los encabezados.
                $pdf->setFont('Times', 'B', 15);
                $pdf->SetTextColor(223, 223, 223);
                // Se imprimen las celdas con los encabezados.
                $pdf->cell(85, 10, 'Servicio', 1, 0, 'C', 1);
                $pdf->cell(40, 10, $pdf->encodeString('Dirección Pedido'), 1, 0, 'C', 1);
                $pdf->cell(30, 10, 'Cantidad', 1, 0, 'C', 1);
                $pdf->cell(40, 10, 'Fecha de pedido', 1, 1, 'C', 1);


                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Times', 'B', 15);

                // Se recorren los registros fila por fila.
                foreach ($dataClientes as $rowCliente) {
                    $pdf->SetTextColor(10, 10, 10);
                    $pdf->setFont('Times', 'B', 16);

                    // Guardar la posición Y actual
                    $yStart = $pdf->GetY();
                    // Guardar la posición X antes de la multicelda
                    $xStart = $pdf->GetX();

                    // Imprimir la multicelda de productos_pedidos y obtener su altura
                    $pdf->MultiCell(85, 10, $pdf->encodeString($rowCliente['cita']), 1, 'C');
                    $yEndProductos = $pdf->GetY();
                    $multiCellHeightProductos = $yEndProductos - $yStart;

                    // Volver a la posición X inicial y Y inicial
                    $pdf->SetXY($xStart + 85, $yStart);

                    // Guardar la posición X antes de la multicelda de direccion_pedido
                    $xStartDireccion = $pdf->GetX();

                    // Imprimir la multicelda de direccion_pedido y obtener su altura
                    $pdf->MultiCell(40, 10, $rowCliente['direccion_pedido'], 1, 'C');
                    $yEndDireccion = $pdf->GetY();
                    $multiCellHeightDireccion = $yEndDireccion - $yStart;

                    // Obtener la altura máxima entre las dos multiceldas
                    $multiCellHeight = max($multiCellHeightProductos, $multiCellHeightDireccion);

                    // Volver a la posición Y inicial para la siguiente celda
                    $pdf->SetXY($xStartDireccion + 40, $yStart);

                    // Imprimir las celdas fijas con la altura de la multicelda más alta
                    $pdf->cell(30, $multiCellHeight, $rowCliente['cantidad_cita'], 1, 0, 'C');
                    $pdf->cell(40, $multiCellHeight, $rowCliente['fecha_registro'], 1, 1, 'C');

                    // Ajustar la posición Y para la siguiente fila
                    $pdf->SetY($yStart + $multiCellHeight);
                }
            } else {
                $pdf->SetTextColor(10, 10, 10);
                $pdf->setFont('Times', 'B', 16);
                $pdf->cell(0, 10, $pdf->encodeString('No hay citas de este cliente'), 1,  'C');
            }

            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Pedidos_cliente.pdf');
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
