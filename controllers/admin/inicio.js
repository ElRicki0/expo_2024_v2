// importación de ruta api
const SERVICIOS_API ='services/admin/servicio.php';
const CITA_API = 'services/admin/cita.php';
const COMENTARIO_API = 'services/admin/comentario.php';
// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoBarras();
    graficoBarras2();
    graficoLienalCitas();
    graficaComentariosTop5();
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
        barGraph('chart1', empleado, citas, 'CANTIDAD DE CITAS', 'EMPLEADOS CON CITAS PENDIENTES');
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


const graficoLienalCitas = async () => {
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
        lineGraph('chart3', estados, clientes, 'Cantidades de citas', 'Cantidad de citas por estados');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.error);
    }
}

const graficaComentariosTop5 = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(COMENTARIO_API, 'graficaComentariosTop5');
    
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let comentarios = [];
        let servicios = [];
        
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            comentarios.push(row.numero_comentarios);
            servicios.push(row.tipo_servicio);
        });
        
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js.
        lineGraph('chart4', servicios, comentarios, 'Número de Comentarios', 'Servicios');
    } else {
        document.getElementById('chart4').remove();
        console.log(DATA.error);
    }
}
