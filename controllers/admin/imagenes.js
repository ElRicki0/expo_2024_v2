// Constantes para completar las rutas de la API.
const IMAGEN_API = 'services/admin/imagen.php';
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
    ID_IMAGEN = document.getElementById('idImagen'),
    IMAGEN_MUESTRA1 = document.getElementById('imagenMuestra1'),
    IMAGEN_MUESTRA2 = document.getElementById('imagenMuestra2'),
    IMAGEN_MUESTRA3 = document.getElementById('imagenMuestra3'),
    IMAGEN1 = document.getElementById('imagen1'),
    IMAGEN2 = document.getElementById('imagen2'),
    IMAGEN3 = document.getElementById('imagen3');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

IMAGEN1.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto Filereader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leido la imagen selecionada se nos devuelve un objeto de tipo blob
        // Con el metodo createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            IMAGEN_MUESTRA1.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
})

IMAGEN2.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto Filereader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leido la imagen selecionada se nos devuelve un objeto de tipo blob
        // Con el metodo createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            IMAGEN_MUESTRA2.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
})

IMAGEN3.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto Filereader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leido la imagen selecionada se nos devuelve un objeto de tipo blob
        // Con el metodo createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            IMAGEN_MUESTRA3.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
})

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
    (ID_IMAGEN.value) ? action = 'updateRow' : action = 'createRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(IMAGEN_API, action, FORM);
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
    const DATA = await fetchData(IMAGEN_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TABLE_BODY.innerHTML += `
<div class="col-12 card mt-2 inicioIndex text-center" id="searchForm">
    <h1 class="text-white">${row.nombre_imagen}</h1>
    <div class="row d-flex justify-content-center">
        <div class="col-sm-12 col-md-12 col-lg-4 d-flex justify-content-center align-items-center" style="height: 300px; width: 300px;">
            <img src="${SERVER_URL}images/imagenes/${row.imagen_1}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 d-flex justify-content-center align-items-center" style="height: 300px; width: 300px;">
            <img src="${SERVER_URL}images/imagenes/${row.imagen_2}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 d-flex justify-content-center align-items-center" style="height: 300px; width: 300px;">
            <img src="${SERVER_URL}images/imagenes/${row.imagen_3}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
    </div>

    <div class="container my-2 d-flex justify-content-center">
        <button type="button" class="btn btn-info mx-1" onclick="openUpdate(${row.id_foto})">
            <i class="bi bi-pencil-fill"></i>
        </button>
        <button type="button" class="btn btn-danger mx-1" onclick="openDelete(${row.id_foto})">
            <i class="bi bi-trash-fill"></i>
        </button>
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
    MODAL_TITLE.textContent = 'Crear galería';
    // Se prepara el formulario.
    SAVE_FORM.reset();
}


/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define un objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idFoto', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(IMAGEN_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Actualizar imagen';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_FOTO.value = ROW.id_foto;
        NOMBRE_FOTO.value = ROW.nombre_foto;
        // FOTO.value = ROW.foto;
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
    const RESPONSE = await confirmAction('¿Desea eliminar la imagen de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idFoto', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(IMAGEN_API, 'deleteRow', FORM);
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