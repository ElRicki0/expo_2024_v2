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

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    tablaServicios();
    tablaComentarios();
})

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const tablaServicios = async (form = null) => {

    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(SERVICIO_API, 'readAll8', form);
    SERVICIOS.innerHTML = ``;

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach((row) => {

            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            SERVICIOS.innerHTML += `
                <div class="col">
                    <div class="card traspante text-bg-dark">
                        <img src="${SERVER_URL}images/servicios/${row.imagen_servicio}" class="card-img" alt="...">
                        <div class="card-img-overlay">
                            <p class="card-title fs-4 fw-medium" id="TipoServicio">${row.tipo_servicio}</p>
                            <p class="card-text" id="DescripcionServicio">${row.descripcion_servicio}</p>
                        </div>
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
        sweetAlert(4, DATA.error, true);
    }
}