// importación de ruta api
const SERVICIOS_API ='services/admin/servicio.php';
const CITA_API = 'services/admin/cita.php';
// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoBarras();
    graficoPastel();
    console.log("pitoooo");
    // Llamada a la función para llenar la tabla con los registros existentes.
    // fillTable();
});

/*
*   Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarras = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(   CITA_API, 'readCantidadClientePendiente');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let empleado = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            empleado.push(row.nombre_cliente);
            citas.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', empleado, citas, 'CITAS PENDIENTES', 'EMPLEADOS CON CITAS PENDIENTES');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

/*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoPastel = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(SERVICIOS_API, 'readCantidadCitas');
    console.log(DATA);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let servicio = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            servicio.push(row.tipo_servicio);
            citas.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        pieGraph('chart2', servicio, citas, 'CITAS REALIZADAS', 'SERVICIOS CON MAS CITAS REALIZADAS');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.error);
    }
}