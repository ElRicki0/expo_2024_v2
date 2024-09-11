// Constante para completar la ruta de la API.
const CITA_API = 'services/admin/cita.php';
const EMPLEADO_API = 'services/admin/empleado.php';
const SERVICIO_API = 'services/admin/servicio.php';
const CLIENTE_API = 'services/admin/cliente.php';

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer el contenido de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');

// constantes para mostrar datos de citas durante un periodo de tiempo
const MODAL_GRAFIC = new bootstrap.Modal('#modalGrafic'),
    MODAL_G_TITLE = document.getElementById('modalGraficTitle');

// constantes para mostrar datos de citas durante un periodo de tiempo
const CHART_MODAL = new bootstrap.Modal('#chartModal');

// constantes para mostrar un dato en especifico
const DATE_FORM = document.getElementById('saveDate'),
    FECHA_INICIO = document.getElementById('fechaInicio'),
    FECHA_FINAL = document.getElementById('fechaFinal');

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_CITA = document.getElementById('idCita'),
    NOMBRE_CITA = document.getElementById('nombreCita'),
    FECHA_CITA = document.getElementById('fechaCita'),
    ESTADO_CITA = document.getElementById('estadoCita'),
    NUMERO_SECIONES = document.getElementById('sesionesCita');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoBarras();
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
});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_CITA.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(CITA_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

DATE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(DATE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(CITA_API, 'graficoCitasfechas', FORM);
    console.log(DATA)
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let servicios = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            servicios.push(row.tipo_servicio);
            citas.push(row.cantidad_veces_realizado);
        });
        // Se agrega la etiqueta canvas al contenedor de la modal.
        document.getElementById('chartContainer').innerHTML = `<canvas id="chart"></canvas>`;
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart', servicios, citas, 'Cantidad de citas', 'citas realizadas por cliente');
        // Se cierra la caja de diálogo.
        MODAL_GRAFIC.hide();
        CHART_MODAL.show();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

// Obtener la fecha y hora actual en formato ISO sin segundos
const fechaActual = new Date().toISOString().slice(0, 16);

// Establecer el atributo "min" en el input para que solo acepte fechas y horas futuras
FECHA_CITA.setAttribute('min', fechaActual);

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
    const DATA = await fetchData(CITA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
            <tr>
                <td>${row.nombre_cita}</td>
                <td>${row.fecha_creacion_cita}</td>
                <td>${row.fecha_asignacion_cita}</td>
                <td>${row.estado_cita}</td>
                <td>${row.numero_seciones}</td>
                <td>${row.nombre_cliente}</td>
                <td>${row.tipo_servicio}</td>
                <td>
                <button class="btn btn-danger" onclick="openDelete(${row.id_cita})">
                    <i class="bi bi-trash3-fill"></i>
                </button>
                <button class="btn btn-primary" onclick="openUpdate(${row.id_cita})">
                    <i class="bi bi-pen-fill"></i>
                </button>
                <button class="btn btn-info" onclick="openReport(${row.id_cliente})">
                    <i class="bi bi-file-earmark-code-fill"></i>
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
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'AGREGAR CITA';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    fillSelect(EMPLEADO_API, 'readAll', 'empleadoCita');
    fillSelect(CLIENTE_API, 'readAll', 'clienteCita');
    fillSelect(SERVICIO_API, 'readAll', 'servicioCita');
}

// método para mostrar gráfica entre dos fechas futuras
const openGraf = () => {
    MODAL_GRAFIC.show();
    MODAL_G_TITLE.textContent = 'CREAR GRÁFICA ENTRE FECHAS';

}

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idCita', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(CITA_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'ACTUALIZAR CITA';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        const ROW = DATA.dataset;
        ID_CITA.value = ROW.id_cita;
        NOMBRE_CITA.value = ROW.nombre_cita;
        FECHA_CITA.value = ROW.fecha_asignacion_cita;
        ESTADO_CITA.value = ROW.estado_cita;
        NUMERO_SECIONES.value = ROW.numero_seciones;
        fillSelect(EMPLEADO_API, 'readAll', 'empleadoCita', ROW.id_empleado);
        fillSelect(SERVICIO_API, 'readAll', 'servicioCita', ROW.id_servicio);
        fillSelect(CLIENTE_API, 'readAll', 'clienteCita', ROW.id_cliente);

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
    const RESPONSE = await confirmAction('¿Desea eliminar la cita de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idCita', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(CITA_API, 'deleteRow', FORM);
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
*   Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const graficoBarras = async () => {
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
            estados.push(row.estado_cita);
            clientes.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', estados, clientes, 'Cantidades de citas', 'Cantidad de citas por estados');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

/*
*   Función para abrir un reporte parametrizado de cita general por cliente.
*   Parámetros: nombre_cliente (nombre del cliente en la tabla de citas).
*   Retorno: ninguno.
*/
const openReport = (id) => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/citas_clientes.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('id_cliente', id);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}

const reporteCitasMesActual = (id) => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/citas_general_clientes.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('idCita', id); // Asegúrate de que 'idCita' es el nombre correcto aquí.
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}