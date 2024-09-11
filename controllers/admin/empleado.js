// Constante para completar la ruta de la API.
const EMPLEADO_API = 'services/admin/empleado.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer los elementos de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle'),
    CHART_MODAL = new bootstrap.Modal('#chartModal');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_EMPLEADO = document.getElementById('idEmpleado'),
    NOMBRE_EMPLEADO = document.getElementById('nombreEmpleado'),
    APELLIDO_EMPLEADO = document.getElementById('apellidoEmpleado'),
    CORREO_EMPLEADO = document.getElementById('correoEmpleado'),
    DUI_EMPLEADO = document.getElementById('duiEmpleado'),
    FECHA_EMPLEADO = document.getElementById('fechaEmpleado'),
    ESTADO_EMPLEADO = document.getElementById('estadoEmpleado');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoDona();
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
    donaGraph();
});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_EMPLEADO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(EMPLEADO_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Este código recarga la página
        // window.location.reload();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(EMPLEADO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se establece un icono para el estado del empleado.
            (row.estado_empleado) ? icon = 'bi bi-eye-fill' : icon = 'bi bi-eye-slash-fill';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
            <tr>
                <td>${row.nombre_empleado} ${row.apellido_empleado}</td>
                <td>${row.dui_empleado}</td>
                <td>${row.correo_empleado}</td>
                <td>${row.nacimiento_empleado}</td>
                <td><i class="${icon}"></i></td>
                <td>
                <button class="btn btn-danger" onclick="openDelete(${row.id_empleado})">
                    <i class="bi bi-trash3-fill"></i>
                </button>
                <button class="btn btn-primary" onclick="openUpdate(${row.id_empleado})">
                    <i class="bi bi-pen-fill"></i>
                </button>
                <button class="btn btn-primary" onclick="openState(${row.id_empleado})">
                    <i class="bi bi-exclamation-octagon"></i>
                </button>
                <button type="button" class="btn btn-warning" onclick="openChart(${row.id_empleado})">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </button>
            </td>
        </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openState = async (id) => {
    // Se muestra un mensaje de confirmación y se captura la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de cambiar el estado del empleado?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idEmpleado', id);

        // Petición para cambiar el estado del cliente
        const DATA = await fetchData(EMPLEADO_API, 'updateRowEstado', FORM);

        // Se comprueba si la respuesta es satisfactoria
        if (DATA.status) {
            sweetAlert(1, DATA.message, true); // Mensaje de éxito
            fillTable(); // Recargar la tabla para visualizar los cambios
        } else {
            sweetAlert(2, DATA.error, false); // Mensaje de error
        }
    }
}

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'AGREGAR EMPLEADO';
    // Se prepara el formulario.
    SAVE_FORM.reset();
}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idEmpleado', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(EMPLEADO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'EDITAR EMPLEADO';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_EMPLEADO.value = ROW.id_empleado;
        NOMBRE_EMPLEADO.value = ROW.nombre_empleado;
        APELLIDO_EMPLEADO.value = ROW.apellido_empleado;
        CORREO_EMPLEADO.value = ROW.correo_empleado;
        DUI_EMPLEADO.value = ROW.dui_empleado;
        FECHA_EMPLEADO.value = ROW.nacimiento_empleado;
        ESTADO_EMPLEADO.checked = ROW.estado_empleado;
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar al empleado de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idEmpleado', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(EMPLEADO_API, 'deleteRow', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
*   Función asíncrona para mostrar un gráfico de pastel con el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoDona = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(EMPLEADO_API, 'readEstadoEmpleado');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let cantidad = [];
        let estado = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            cantidad.push(row.cantidad);
            estado.push(row.estado);
        });
        // Llamada a la función para generar y mostrar un gráfico de pastel. Se encuentra en el archivo components.js
        donaGraph('chart1', estado, cantidad, 'ESTADO DE EMPLEADOS', 'ACTIVIDAD DE EMPLEADOS');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

/*
*   Función asíncrona para mostrar un gráfico parametrizado.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openChart = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idEmpleado', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(EMPLEADO_API, 'readCantidadServiciosEmpleado', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con el error.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        CHART_MODAL.show();
        // Se declaran los arreglos para guardar los datos a graficar.
        let servicios = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            servicios.push(row.tipo_servicio);
            citas.push(row.cantidad_servicios);
        });
        // Se agrega la etiqueta canvas al contenedor de la modal.
        document.getElementById('chartContainer').innerHTML = `<canvas id="chart"></canvas>`;
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart', servicios, citas, 'Cantidad de citas', 'citas asignadas al empleado');
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
*   Función para abrir un reporte automático de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/empleados.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}