// Constantes para completar las rutas de la API.
const SERVICIO_API = 'services/public/servicio.php';
const COMENTARIO_API = 'services/public/comentario.php';
const EMPLEADO_API = 'services/public/empleado.php';
const PREGUNTA_API = 'services/public/pregunta.php';

// Constantes para establecer el contenido de la tabla.
const SERVICIOS = document.getElementById('servicio');
const COMENTARIOS = document.getElementById('comentario');
const EMPLEADO = document.getElementById('empleado');
const PREGUNTA = document.getElementById('pregunta');
const GALERIA = document.getElementById('galeria');

// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    tablaServicios();
    tablaComentarios();
    tablaGaleria();
})

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaServicios = async () => {

    // Se define un objeto con los datos de la categoría seleccionada.
    const FORM = new FormData();
    FORM.append('idServicio', PARAMS.get('id'));

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(SERVICIO_API, 'readAll8', FORM);
    SERVICIOS.innerHTML = ``;

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            SERVICIOS.innerHTML += `
                <div class="col-lg-6 col-md-12 col-sm-12 mt-3">
    <div class="card traspante text-bg-dark">
        <a href="detalles.html?id=${row.id_servicio}" class="stretched-link">
            <img src="${SERVER_URL}images/imagenes/${row.imagen_1}" class="card-img" alt="..."
                style="height: 150px; width: 100%; object-fit: cover;"
                onerror="this.onerror=null; this.src='${SERVER_URL}images/imagenes/default.jpg';">
            <div class="card-img-overlay">
                <p class="card-title fs-4 fw-medium" id="TipoServicio">${row.tipo_servicio}</p>
                <p class="card-text" id="DescripcionServicio">${row.descripcion_servicio}</p>
            </div>
        </a>
    </div>
</div>
            `;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaComentarios = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(COMENTARIO_API, 'readIndex', form);
    COMENTARIOS.innerHTML = ``;

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            COMENTARIOS.innerHTML += `
                <div class="col">
                    <div class="comment-container">
                        <div class="avatar">
                            <img src="${SERVER_URL}images/clientes/${row.imagen_cliente}" class="avatar-image"
                                height="50px">
                        </div>
                        <div class="comment-content">
                            <div class="comment-header">
                                <h3 class="username">${row.nombre_cliente} ${row.apellido_cliente}</h3>
                            </div>
                            <p class="commenting-on">
                                Comentando sobre: <span class="highlight">${row.tipo_servicio}</span>
                            </p>
                            <p class="comment-text">${row.tipo_servicio}</p>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        COMENTARIOS.innerHTML = `
        <div class="col-5 justify-content-center align-items-center">
                <img src="../../resources/img/error/errorCitas.png" class="card-img-top" alt="ERROR CARGAR IMAGEN">
            </div>
        `
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaGaleria = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(SERVICIO_API, 'readAllGaleria', form);
    GALERIA.innerHTML = ``;

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            GALERIA.innerHTML += `
                <div class="col-lg-6 col-md-12 mb-3 d-flex justify-content-center align-items-center">
                    <div class="card">
                      <img src="${SERVER_URL}images/imagenes/${row.imagen}" style="height:300" class="card-img-top" alt="..." 
                onerror="this.onerror=null; this.src='${SERVER_URL}images/imagenes/default.jpg';">
                </div>                    
            `;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}