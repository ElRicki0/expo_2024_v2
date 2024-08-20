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
    graficoBarrasPrediccionCitas();
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
                <button class="btn btn-danger"><i class="bi bi-trash3-fill" onclick="openDelete(${row.id_cita})"></i></button>
                <button class="btn btn-primary"><i class="bi bi-pen-fill" onclick="openUpdate(${row.id_cita})"></i></button>
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
        MODAL_TITLE.textContent = 'Actualizar Cita';
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

const graficoBarrasPrediccionCitas = async () => {
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
        lineGraph('chartP2', servicio, citas, 'Prediccion de citas proxima semana', 'Prediccion de servicios cotizados por semana futura');
    } else {
        document.getElementById('chartP2').remove();
        console.log(DATA.error);
    }

}


