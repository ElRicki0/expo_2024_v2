<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;

// Se verifica si existe un valor para el id_cliente, de lo contrario se muestra un mensaje.
if (isset($_GET['id_cliente'])) {
    // Se incluyen las clases para la transferencia y acceso a datos.
    require_once('../../models/data/cita_data.php');
    require_once('../../models/data/cliente_data.php');

    // Se instancian las entidades correspondientes.
    $cita = new CitaData;
    $cliente = new ClienteData;

    // Se establece el valor del cliente, de lo contrario se muestra un mensaje.
    if ($cliente->setId($_GET['id_cliente'])) {

        // Se verifica si el cliente existe, de lo contrario se muestra un mensaje.
        if ($rowCliente = $cliente->readOne()) {

            // Se inicia el reporte con el encabezado del documento.
            $pdf->startReport('Reporte de citas');

            // Se obtienen las citas del cliente.
            if ($dataCitas = $cita->citasPorCliente()) {
                
                // Establecer el color de fondo verde oscuro para los encabezados.
                $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

                // Establecer la fuente para los encabezados.
                $pdf->setFont('Arial', 'B', 11);

                // Imprimir las celdas con los encabezados.
                $pdf->cell(30, 10, 'Cita', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Servicio', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Secciones', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Fecha de creacion', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Fecha de asignacion', 'TB', 1, 'C', 1);

                // Se establece la fuente para los datos de las citas.
                $pdf->setFont('Arial', '', 11);

                // Recorrer los registros fila por fila.
                foreach ($dataClientes as $clienteRow) {

                    // Imprimir nombrem correo y identificador
                    $pdf->cell(30, 10, $clienteRow['nombre_cita'], 'TB', 0, 'C');
                    $pdf->cell(30, 10, $clienteRow['tipo_servicio'], 'TB', 0, 'C');
                    $pdf->cell(30, 10, $clienteRow['estado_cita'], 'TB', 0, 'C');
                    $pdf->cell(30, 10, $clienteRow['numero_seciones'], 'TB', 0, 'C');
                    $pdf->cell(30, 10, $clienteRow['fecha_creacion_cita'], 'TB', 0, 'C');
                    $pdf->cell(30, 10, $clienteRow['fecha_asignacion_cita'], 'TB', 1, 'C');
                }
            } else {
                $pdf->cell(0, 10, $pdf->encodeString('No hay citas para el cliente'), 1, 1);
            }
            // Se llama implícitamente al método footer() y se envía el documento al navegador web.
            $pdf->output('I', 'Citas_Cliente.pdf');
        } else {
            print ('Cliente inexistente');
        }
    } else {
        print ('Cliente incorrecto');
    }
} else {
    print ('Debe seleccionar un cliente');
}