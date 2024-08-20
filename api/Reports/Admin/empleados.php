<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/empleado_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('');
// Se instancia el modelo Administrador para obtener los datos.
$empleado = new EmpleadoData;
// Se verifica si existen registros de administradores para mostrar, de lo contrario se imprime un mensaje.
if ($dataEmpleados = $empleado->readAll()) {
    // Se establece un color de relleno para los encabezados.
    $pdf->setFillColor(239, 233, 228);
    // Se establece la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Se imprimen las celdas con los encabezados.
    $pdf->cell(70, 10, 'Nombre completo', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Especialidad', 1, 0, 'C', 1);
    $pdf->cell(60, 10, 'Contacto', 1, 1, 'C', 1);

    // Se establece la fuente para los datos de los administradores.
    $pdf->setFont('Arial', '', 11);

    // Se recorren los registros fila por fila.
    foreach ($dataEmpleados as $rowEmpleados) {
        // Concatenar nombre y apellido
        $nombreCompleto = $rowEmpleados['nombre_empleado'] . ' ' . $rowEmpleados['apellido_empleado'];

        // Imprimir el nombre completo en una sola celda
        $pdf->cell(70, 10, $nombreCompleto, 1, 0);
        $pdf->cell(60, 10, $rowEmpleados['especialidad_empleado'], 1, 0);
        $pdf->cell(60, 10, $rowEmpleados['correo_empleado'], 1, 1);
    }

} else {
    $pdf->cell(0, 10, $pdf->encodeString('No hay empleados para mostrar'), 1, 1);
}
// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Empleados.pdf');
