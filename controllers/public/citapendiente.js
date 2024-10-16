// Constante para completar la ruta de la API.
const CITA_API = 'services/public/cita.php';
const SERVICIO_API = 'services/admin/servicio.php';

// se llama el id donde se meten las card de las citas
const CITA_BODY = document.getElementById('citas');

// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');
    
// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    ID_SERVICIO = document.getElementById('idServicio'),
    TIPO_SERVICIO = document.getElementById('tipoServicio'),
    DESCRIPCION_SERVICIO = document.getElementById('descripcionServicio');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    fillTable();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Solicitud de Citas ';
});


/*
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    CITA_BODY.innerHTML = '';
    const DATA = await fetchData(CITA_API, 'readAllCliente', form);
    if (DATA.status) {
        DATA.dataset.forEach(row => {
            const fecha = row.fecha_creacion_cita ? row.fecha_creacion_cita : 'Fecha no asignada';
            CITA_BODY.innerHTML += `
          <!-- Primera card -->
<div class="col-lg-6 col-md-12 col-sm-12 mb-4">
    <div class="conteinerInicio card card-body text-center">
        <div class="row">
            <!-- Columna 1: Imagen -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <img src="${SERVER_URL}images/imagenes/${row.imagen_1}" class="card-img-top" alt="ERROR CARGAR IMAGEN">
            </div>
            <!-- Columna 2: Tipo de servicio -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Servicio</h2>
                <h4 class="card-title text-primary">${row.tipo_servicio}</h4>
            </div>
            <!-- Columna 3: Estado de cita -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Estado de cita</h2>
                <h4 class="card-text text-warning">Esperando validación de administrador</h4>
            </div>
            <!-- Columna 4: Fecha de solicitud -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Fecha Solicitud cita</h2>
                <h4 class="card-text text-success">${fecha}</h4>
            </div>
        </div>
        <button type="button" onclick="openDelete(${row.id_cita})" class="col-2 mb-1 btn btn-danger">
            <i class="bi bi-trash3-fill"></i>
        </button>
        <button type="button" onclick="openLook(${row.id_servicio})" class="col-2 mb-1 btn btn-primary">
            Servicio
        </button>
    </div>
</div>

            `;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openLook = async (id) => {
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
        // IMAGEN_EMPLEADO.src = SERVER_URL.concat('images/empleados/', ROW.imagen_empleado);        
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de remover la petición de cita?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del producto seleccionado.
        const FORM = new FormData();
        FORM.append('idCita', id);
        // Petición para eliminar un producto del carrito de compras.
        const DATA = await fetchData(CITA_API, 'deleteRow', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}