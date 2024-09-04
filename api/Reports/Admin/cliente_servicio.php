<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se verifica si existe un valor para la servicio, de lo contrario se muestra un mensaje.
if (isset($_GET['idCliente'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/cliente_data.php');
    require_once('../../models/data/servicio_data.php');
    // Se instancian las entidades correspondientes.
    $cliente = new ClienteData;
    $servicio = new ServicioData;
    // Se establece el valor de la servicio, de lo contrario se muestra un mensaje.
    if ($cliente->setId($_GET['idCliente'])) {

        // Se verifica si la servicio existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readOne()) {

            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Servicios relacionados del cliente');

            // Imprimir el texto "usuario:" en negrita y alineado a la izquierda.
            $pdf->setFont('Arial', 'B', 10); // Establecer la fuente en Arial, negrita, tamaño 10
            $pdf->cell(18, 0, 'Cliente: ', 0, 0, 'L'); // Alineado a la izquierda

            // Concatenar nombre y apellido
            $nombreCompleto = $rowCliente['nombre_cliente'] . ' ' . $rowCliente['apellido_cliente'];

            // Configurar el título alineado a la izquierda.
            $pdf->setFont('Arial', '', 10);
            $pdf->cell(0, 0, $nombreCompleto, 0, 0, 'L');

            $pdf->ln(7); // Mover a la siguiente línea

            // Se verifica si existen registros para mostrar, de lo contrario se imprime un mensaje.
            if ($dataCliente = $cliente->clienteServicios()) {
                // Establecer el color de fondo verde oscuro para los encabezados.
                $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

                // Establecer la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);

                // Se imprimen las celdas con los encabezados.
                $pdf->cell(30, 10, 'ID servicio', 'TB', 0, 'C', 1);
                $pdf->cell(40, 10, 'Nombre servicio', 'TB', 0, 'C', 1);
                $pdf->cell(120, 10, $pdf->encodeString('Descripción servicio'), 'TB', 1, 'C', 1);

                // Se establece la fuente para los datos de los productos.
                $pdf->setFont('Arial', '', 11);

                // Se recorren los registros fila por fila.
                foreach ($dataCliente as $rowCliente) {

                    // Se imprimen las celdas con los datos de los productos.
                    $pdf->Cell(30, 10, $pdf->encodeString($rowCliente['id_servicio']), 'T', 0, 'C');
                    $pdf->Cell(40, 10, $pdf->encodeString($rowCliente['tipo_servicio']), 'T', 0, 'C');

                    // Imprimir la descripción del servicio usando MultiCell
                    $pdf->MultiCell(120, 10, $pdf->encodeString($rowCliente['descripcion_servicio']), 'T', 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay servicios para el cliente'), 1, 1);
            }

            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'cliente.pdf');
        } else {
            print ('cliente inexistente');
        }
    } else {
        print ('cliente incorrecto');
    }
} else {
    print ('Debe seleccionar un cliente');
}