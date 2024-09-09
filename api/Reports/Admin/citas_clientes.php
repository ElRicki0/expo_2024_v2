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
    if ($cita->setCliente($_GET['id_cliente']) && $cliente->setId($_GET['id_cliente'])) {

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
                $pdf->cell(40, 10, 'Cita', 'TB', 0, 'C', 1);
                $pdf->cell(40, 10, 'Servicio', 'TB', 0, 'C', 1);
                $pdf->cell(30, 10, 'Estado', 'TB', 0, 'C', 1);
                $pdf->cell(20, 10, 'Secciones', 'TB', 0, 'C', 1);
                $pdf->cell(60, 10, $pdf->encodeString('Fecha de creación'), 'TB', 1, 'C', 1);

                // Se establece la fuente para los datos de las citas.
                $pdf->setFont('Arial', '', 11);

                // Recorrer los registros fila por fila.
                foreach ($dataCitas as $citaRow) {
                    // Imprimir nombre, correo y identificador
                    $pdf->cell(40, 10, $citaRow['nombre_cita'], 'T', 0, 'C');
                    $pdf->cell(40, 10, $pdf->encodeString($citaRow['tipo_servicio']), 'T', 0, 'C');
                    $pdf->cell(30, 10, $citaRow['estado_cita'], 'T', 0, 'C');
                    $pdf->cell(20, 10, $citaRow['numero_seciones'], 'T', 0, 'C');

                    // Imprimir solo la fecha de creación
                    $pdf->cell(60, 10, $citaRow['fecha_creacion_cita'], 'T', 1, 'C'); // Cambié a 'TB', 1 para que haga un salto de línea después
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