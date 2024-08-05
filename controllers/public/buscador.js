const SERVICIO_API = 'services/admin/servicio.php';
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
    ID_SERVICIO = document.getElementById('idServicio'),
    TIPO_SERVICIO = document.getElementById('tipoServicio'),
    DESCRIPCION_SERVICIO = document.getElementById('descripcionServicio');

// componentes del segundo buscador
const BENEFICIO_API = 'services/admin/beneficio.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM2 = document.getElementById('searchForm2');
// Constantes para establecer el contenido de la tabla.
const TABLE_BODY2 = document.getElementById('tableBody2'),
    ROWS_FOUND2 = document.getElementById('rowsFound2');
// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL2 = new bootstrap.Modal('#saveModal2'),
    MODAL_TITLE2 = document.getElementById('modalTitle2');
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM2 = document.getElementById('saveForm2'),
    ID_BENEFICIO = document.getElementById('idBeneficio'),
    TITULO_BENEFICIO = document.getElementById('tituloBeneficio'),
    CONTENIDO_BENEFICIO = document.getElementById('contenidoBeneficio'),
    SERVICIO_BENEFICIO = document.getElementById('servicioBeneficio');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    loadTemplate();
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
    fillTable2();
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

// Método del evento para cuando se envía el segundo formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM2);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable2(FORM);
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
    const DATA = await fetchData(SERVICIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros fila por fila.
        DATA.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
            <tr>
                    <td><img src="${SERVER_URL}images/servicios/${row.imagen_servicio}" height="50"></td>
                <td>${row.tipo_servicio}</td>
                <td>${row.descripcion_servicio}</td>
                <td>
                <button class="btn btn-primary"><i class="bi bi-pen-fill" onclick="openUpdate(${row.id_servicio})"></i></button>
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
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable2 = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    ROWS_FOUND2.textContent = '';
    TABLE_BODY2.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(BENEFICIO_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY2.innerHTML += `
                <tr>
                    <td>${row.titulo_beneficio}</td>
                    <td>${row.contenido_beneficio}</td>
                    <td>${row.tipo_servicio}</td>
                    <td>
                        <button type="button" class="btn btn-info" onclick="openUpdate2(${row.id_beneficio})">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND2.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}



/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
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
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

const openUpdate2 = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idBeneficio', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(BENEFICIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL2.show();
        MODAL_TITLE2.textContent = 'Actualizar beneficio';
        // Se prepara el formulario.
        SAVE_FORM2.reset();
        // Se inicializan los campos con los datos.
        const ROW2 = DATA.dataset;
        ID_BENEFICIO.value = ROW2.id_beneficio;
        TITULO_BENEFICIO.value = ROW2.titulo_beneficio;
        CONTENIDO_BENEFICIO.value = ROW2.contenido_beneficio;
        fillSelect(SERVICIO_API, 'readAll', 'servicioBeneficio', ROW2.id_servicio);
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



/* Obtener el input de carga de imagen y la imagen
var imageUpload = document.getElementById("id_foto");
var serviceImage = document.getElementById("serviceImage");

 // Cuando el usuario hace clic en la imagen, abre el input de carga de imagen
 serviceImage.onclick = function() {
    imageUpload.click();
}

// Cuando el usuario selecciona una imagen, cambia la imagen mostrada
imageUpload.onchange = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        serviceImage.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}*/