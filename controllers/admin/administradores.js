// Constante para completar la ruta de la API.
const ADMINISTRADOR_API = 'services/admin/administrador.php';
const EMPLEADO_API = 'services/admin/empleado.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer los elementos de la tabla.
const ADMINISTRADORES = document.getElementById('administradores'),
    ROWS_FOUND = document.getElementById('rowsFound');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_ADMINISTRADOR = document.getElementById('idAdmin'),
    NOMBRE_ADMINISTRADOR = document.getElementById('nombreAdmin'),
    CORREO_ADMINISTRADOR = document.getElementById('correoAdmin'),
    CONTRASEÑA_ADMINISTRADOR = document.getElementById('contraAdmin'),
    CONTRASEÑA_TITLE = document.getElementById('TextPassword');

const SAVE_FORM_EMPLEADO = new bootstrap.Modal('#modalEmpleado'),
    MODAL_TITLE_EMPLEADO = document.getElementById('modalTitleEmpleado');
// constantes que estan adentro del formulario

const SAVE_EMPLEADO = document.getElementById('saveFormEmpleado'),
    ID_EMPLEADO = document.getElementById('idEmpleado'),
    NOMBRE_EMPLEADO = document.getElementById('nombreEmpleado'),
    APELLIDO_EMPLEADO = document.getElementById('apellidoEmpleado'),
    CORREO_EMPLEADO = document.getElementById('correoEmpleado'),
    DUI_EMPLEADO = document.getElementById('duiEmpleado'),
    FECHA_EMPLEADO = document.getElementById('fechaEmpleado');


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
    (ID_ADMINISTRADOR.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(ADMINISTRADOR_API, action, FORM);
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
    ADMINISTRADORES.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(ADMINISTRADOR_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            ADMINISTRADORES.innerHTML += `
<div class="col-12 card mt-2 inicioIndex" id="searchForm">
    <div class="row  ">
        <div class="col-sm-12 col-md-12 col-lg-3 mt-3 d-flex align-items-center justify-content-center" style="height: 200px; width: 200px;">
            <!-- Ajusta la altura según sea necesario -->
            <img src="${SERVER_URL}images/empleados/${row.imagen_empleado}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%;">
        </div> 

        <div class="col-sm-12 col-md-12 col-lg-3 card-body d-flex flex-column align-items-center text-center">
            <h5 class="text-white" for="">Nombre usuario</h5>
            <p class="card-title text-white">${row.nombre_admin}</p>
            <h5 class="text-white" for="">Correo electronico</h5>
            <p class="card-text text-white">${row.correo_admin}</p>
            <h5 class="text-white" for="">Nombre empleado</h5>
            <p class="card-text text-white">${row.nombre_empleado} ${row.apellido_empleado}</p>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-3 text-center my-5">
            <div class="mt-3">
                <div class="d-flex flex-column">
                    <button class="btn btn-outline-light mb-2 mx-3" onclick="openEmpleado(${row.id_admin})">
                        <i class="bi bi-info-circle-fill"></i> Informacion Empleado
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

        ADMINISTRADORES.innerHTML = `
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
    MODAL_TITLE.textContent = 'AGREGAR ADMINISTRADOR';
    // Se prepara el formulario.
    SAVE_FORM.reset();
    fillSelect(EMPLEADO_API, 'readAllOne', 'empleadoAdmin');

}

/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openEmpleado = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idEmpleado', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(EMPLEADO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_FORM_EMPLEADO.show();
        MODAL_TITLE_EMPLEADO.textContent = 'INFORMACIÓN EMPLEADO';
        // Se prepara el formulario.
        SAVE_EMPLEADO.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_EMPLEADO.value = ROW.id_empleado;
        NOMBRE_EMPLEADO.value = ROW.nombre_empleado;
        APELLIDO_EMPLEADO.value = ROW.apellido_empleado;
        CORREO_EMPLEADO.value = ROW.correo_empleado;
        DUI_EMPLEADO.value = ROW.dui_empleado;
        FECHA_EMPLEADO.value = ROW.nacimiento_empleado;
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
    const RESPONSE = await confirmAction('¿Desea eliminar al administrador de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idAdmin', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(ADMINISTRADOR_API, 'deleteRow', FORM);
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
* Función para abrir un reporte automático de productos por categoría.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/administradores.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}