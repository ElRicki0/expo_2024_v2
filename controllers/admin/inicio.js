// importación de ruta api
const SERVICIOS_API = 'services/admin/servicio.php';
const CITA_API = 'services/admin/cita.php';


// Constante para establecer la modal de cambiar contraseña.
const PASSWORD_MODAL = new bootstrap.Modal('#passwordModal');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoBarras();
    graficoBarras2();
    GraficoLineal1();
    GraficoLineal2();
    obtenerFechaClave();

});

/*
*   Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarras = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(CITA_API, 'readCantidadClientePendiente');
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
        barGraph('chart1', empleado, citas, 'CANTIDAD DE CITAS', 'EMPLEADOS CON CITAS PENDIENTES');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

const obtenerFechaClave = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(USER_API, 'getFechaClave');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        console.log('claves correctas :)');
    } else {
        console.log('error1');
        openPassword();
    }
}


/*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarras2 = async () => {
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
            servicio.push(row.tipo_servicio.slice(0, 12));
            citas.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        barGraph('chart2', servicio, citas, 'CITAS POR SERVICIOS', 'SERVICIOS CON MAS CITAS REALIZADAS');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.error);
    }
}


const GraficoLineal1 = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(CITA_API, 'readCantidadClienteEstado');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estados = [];
        let clientes = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estados.push(row.estado_cita.slice(0, 12));
            clientes.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        lineGraph('chart3', estados, clientes, 'Cantidades de citas', 'CANTIDAD DE CITAS POR SU ESTADO');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.error);
    }
}

const GraficoLineal2 = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(CITA_API, 'graficoBarrasPrediccionCitas');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let citas = [];
        let servicio = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            citas.push(row.prediccion_proxima_semana);
            servicio.push(row.tipo_servicio);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        lineGraph('chart4', servicio, citas, 'CITAS PROXIMA SEMANA', 'PREDICCIÓN DE CITAS POR SEMANA FUTURA');
    } else {
        document.getElementById('chartP2').remove();
        console.log(DATA.error);
    }
}

/*
*   Función para preparar el formulario al momento de cambiar la constraseña.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openPassword = () => {
    // Se abre la caja de diálogo que contiene el formulario.
    PASSWORD_MODAL.show();
    // Se restauran los elementos del formulario.
    PASSWORD_FORM.reset();
}