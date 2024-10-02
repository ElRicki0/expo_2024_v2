// constantes de el uso de la api
const SERVICIO_API = 'services/admin/servicio.php';
const CITA_API = 'services/admin/cita.php';
const IMAGENES_API = 'services/admin/imagen.php';

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');

// Constantes para establecer el contenido de la tabla.
const TABLE_BODY = document.getElementById('tableBody'),
    ROWS_FOUND = document.getElementById('rowsFound');

// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle'),
    CHART_MODAL = new bootstrap.Modal('#chartModal');

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_SERVICIO = document.getElementById('idServicio'),
    TIPO_SERVICIO = document.getElementById('tipoServicio'),
    DESCRIPCION_SERVICIO = document.getElementById('descripcionServicio');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    graficoPastelServicio();
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
    (ID_SERVICIO.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(SERVICIO_API, action, FORM);
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

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND.textContent = '';
    TABLE_BODY.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(SERVICIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
<div class="col-12 card mt-2 inicioIndex" id="searchForm">
    <div class="row  ">
        <div class="col-sm-12 col-md-12 col-lg-3 mt-3 d-flex align-items-center justify-content-center "
            style="height: 300px; width: 300px;">
            <div clas="ml-5">
            <img src="${SERVER_URL}images/imagenes/${row.imagen_1}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 card-body d-flex flex-column align-items-center text-center">
            <h5 class="text-white">Nombre servicio</h5>
            <p class="card-title text-white">${row.tipo_servicio}</p>
            <h5 class="text-white">Descripción</h5>
            <p class="card-text text-white">${row.descripcion_servicio}</p>
            <h5 class="text-white">Nombre Galeria</h5>
            <p class="card-text text-white">${row.nombre_imagen}</p>
            <h5 class="text-white">Nombre Empleado</h5>
            <p class="card-text text-white">${row.nombre_empleado} ${row.apellido_empleado}</p>
        </div>3
        <div class="col-sm-12 col-md-12 col-lg-3 text-center my-5">
            <div class=" ">
                <div class="d-flex flex-column">
                    <button class="btn btn-outline-light mb-2" onclick="openDelete(${row.id_servicio})">
                        <i class="bi bi-trash3-fill"></i> Eliminar
                    </button>
                    <button class="btn btn-outline-light mb-2" onclick="openUpdate(${row.id_servicio})">
                        <i class="bi bi-pencil-fill"></i>Actualizar
                    </button>
                    <button type="button" class="btn btn-outline-light mb-2" onclick="openChart(${row.id_servicio})">
                        <i class="bi bi-bar-chart-line-fill"></i> Ver Gráfico
                    </button>
                    <button type="button" class="btn btn-outline-light mb-2"
                        onclick="openReportCliente(${row.id_servicio})">
                        <i class="bi bi-file-earmark-code-fill"></i> Reporte de clientes
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
`;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función para preparar el formulario al momento de insertar un registro.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'AGREGAR SERVICIO';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    fillSelect(IMAGENES_API, 'readAll', 'imagenServicio');
}

/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idServicio', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(SERVICIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'ACTUALIZAR SERVICIO';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_SERVICIO.value = ROW.id_servicio;
        TIPO_SERVICIO.value = ROW.tipo_servicio;
        DESCRIPCION_SERVICIO.value = ROW.descripcion_servicio;
        fillSelect(IMAGENES_API, 'readAll', 'imagenServicio', parseInt(ROW.id_imagen));
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
* Función asíncrona para eliminar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el servicio de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idServicio', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(SERVICIO_API, 'deleteRow', FORM);
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

const graficoPastelServicio = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(SERVICIO_API, 'graficoPastelServicio');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let servicios = [];
        let predicciones = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            servicios.push(row.tipo_servicio);
            predicciones.push(row.prediccion_citas_siguiente_semana);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras.
        // Asegúrate de que la función barGraph esté definida en components.js
        donaGraph('ChartP2S', servicios, predicciones, 'CITAS PREDICHAS', 'SERVICIOS');
    } else {
        document.getElementById('ChartP2S').remove();
        console.log(DATA.error);
    }

};

/*
* Función asíncrona para mostrar un gráfico parametrizado.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openChart = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idServicio', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(CITA_API, 'readClientesServicio', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con el error.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        CHART_MODAL.show();
        // Se declaran los arreglos para guardar los datos a graficar.
        let Clientes = [];
        let Citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            Clientes.push(row.nombre_cliente);
            Citas.push(row.cantidad_veces_solicitado);
        });
        // Se agrega la etiqueta canvas al contenedor de la modal.
        document.getElementById('chartContainer').innerHTML = `<canvas id="chart"></canvas>`;
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        pieGraph('chart', Clientes, Citas, 'Cantidad de citas', 'citas realizadas por clientes');
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función para abrir un reporte automático de productos por categoría.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}Reports/Admin/servicios.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}

/*
* Función para abrir un reporte parametrizado.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openReportCliente = (id) => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/servicios_clientes.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('idServicio', id);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}