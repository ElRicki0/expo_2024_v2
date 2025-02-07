// Constantes para completar las rutas de la API.
const EMPLEADO_API = 'services/admin/empleado.php';
const PREGUNTA_API = 'services/admin/pregunta.php';
const IMAGENES_API = 'services/admin/imagen.php';

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
    ID_PREGUNTA = document.getElementById('idPregunta'),
    NOMBRE_PREGUNTA = document.getElementById('nombrePregunta'),
    CONTENIDO_PREGUNTA = document.getElementById('contenidoPregunta'),
    EMPLEADO_PREGUNTA = document.getElementById('empleadoPregunta'),
    IMAGEN_PREGUNTO = document.getElementById('imagenPregunta');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
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
    (ID_PREGUNTA.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(PREGUNTA_API, action, FORM);
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
    const DATA = await fetchData(PREGUNTA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
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
                    style="max-width: 70%; max-height: 70%; object-fit: contain;">
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-3 card-body d-flex flex-column align-items-center text-center">
            <h5 class="text-white">Nombre pregunta</h5>
            <p class="card-title text-white">${row.nombre_pregunta}</p>
            <h5 class="text-white">Contenido</h5>
            <p class="card-text text-white">${row.contenido_pregunta}</p>
            <h5 class="text-white">Nombre Galeria</h5>
            <p class="card-text text-white">${row.nombre_imagen}</p>
            <h5 class="text-white">Nombre Empleado</h5>
            <p class="card-text text-white">${row.nombre_empleado} ${row.apellido_empleado}</p>
        </div>3
        <div class="col-sm-12 col-md-12 col-lg-3 text-center my-5">
            <div class=" ">
                <div class="d-flex flex-column">
                    <button class="btn btn-outline-light mb-2" onclick="openDelete(${row.id_pregunta})">
                        <i class="bi bi-trash3-fill"></i> Eliminar
                    </button>
                    <button class="btn btn-outline-light mb-2" onclick="openUpdate(${row.id_pregunta})">
                        <i class="bi bi-pencil-fill"></i>Actualizar
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
        TABLE_BODY.innerHTML = `
        <div class="col-5 justify-content-center align-items-center">
                <img src="../../resources/img/error/errorCitas.png" class="card-img-top" alt="ERROR CARGAR IMAGEN">
            </div>
        `
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
    MODAL_TITLE.textContent = 'AGREGAR PREGUNTA';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    fillSelect(EMPLEADO_API, 'readAll', 'empleadoPregunta');
    fillSelect(IMAGENES_API, 'readAll', 'imagenPregunta');
}

/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idPregunta', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(PREGUNTA_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'ACTUALIZAR PREGUNTA';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_PREGUNTA.value = ROW.id_pregunta;
        NOMBRE_PREGUNTA.value = ROW.nombre_pregunta;
        CONTENIDO_PREGUNTA.value = ROW.contenido_pregunta;
        fillSelect(EMPLEADO_API, 'readAll', 'empleadoPregunta', ROW.id_empleado);
        fillSelect(IMAGENES_API, 'readAll', 'imagenPregunta', parseInt(ROW.id_imagen));
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
    const RESPONSE = await confirmAction('¿Desea eliminar la pregunta de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idPregunta', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(PREGUNTA_API, 'deleteRow', FORM);
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