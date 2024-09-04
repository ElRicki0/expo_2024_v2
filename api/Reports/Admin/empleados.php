<?php
// Se incluye la clase con las plantillas para generar reportes.
require_once('../../helpers/report.php');
// Se incluyen las clases para la transferencia y acceso a datos.
require_once('../../models/data/empleado_data.php');

// Se instancia la clase para crear el reporte.
$pdf = new Report;
// Se inicia el reporte con el encabezado del documento.
$pdf->startReport('Reporte de empleados');
// Se instancia el modelo Administrador para obtener los datos.
$empleado = new EmpleadoData;
// Se verifica si existen registros de administradores para mostrar, de lo contrario se imprime un mensaje.
if ($dataEmpleados = $empleado->readAll()) {
    // Establecer el color de fondo verde oscuro para los encabezados.
    $pdf->setFillColor(99, 193, 116); // RGB para verde oscuro

    // Establecer la fuente para los encabezados.
    $pdf->setFont('Arial', 'B', 11);
    // Imprimir las celdas con los encabezados.
    $pdf->cell(60, 10, 'Nombre completo', 'TB', 0, 'C', 1);
    $pdf->cell(40, 10, 'Contacto', 'TB', 0, 'C', 1);
    $pdf->cell(40, 10, $pdf->encodeString('Nacimiento'), 'TB', 0, 'C', 1);
    $pdf->cell(50, 10, 'Especialidad', 'TB', 1, 'C', 1);

    // Establecer la fuente para los datos de los administradores.
    $pdf->setFont('Arial', '', 11);

    // Recorrer los registros fila por fila.
    foreach ($dataEmpleados as $rowEmpleados) {
        // Guardar la posición actual
        $xPos = $pdf->getX();
        $yPos = $pdf->getY();

        // Concatenar nombre y apellido
        $nombreCompleto = $rowEmpleados['nombre_empleado'] . ' ' . $rowEmpleados['apellido_empleado'];

        // Imprimir el nombre completo en una sola celda
        $pdf->cell(60, 10, $nombreCompleto, 'T', 0, 'C');

        // Imprimir contacto y cumpleaños
        $pdf->cell(40, 10, $rowEmpleados['correo_empleado'], 'T', 0, 'C');
        $pdf->cell(40, 10, $rowEmpleados['nacimiento_empleado'], 'T', 0, 'C');

        // Imprimir la especialidad en la última columna
        $pdf->cell(50, 10, $rowEmpleados['especialidad_empleado'], 'T', 1, 'C');
    }
} else {
    // Si no hay empleados para mostrar
    $pdf->cell(0, 10, $pdf->encodeString('No hay empleados para mostrar'), 1, 1, 'C');
}

// Se llama implícitamente al método footer() y se envía el documento al navegador web.
$pdf->output('I', 'Empleados.pdf');
