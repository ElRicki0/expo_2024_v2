// Constante para completar la ruta de la API.
const CITA_API = 'services/public/cita.php';

// se llama el id donde se meten las card de las citas
const CITA_BODY = document.getElementById('citas');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    fillTable();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Citas aprobadas';
});


/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    CITA_BODY.innerHTML = '';
    const DATA = await fetchData(CITA_API, 'readAllClienteAprobado', form);
    if (DATA.status) {
        DATA.dataset.forEach(row => {
            const fecha = row.fecha_asignacion_cita ? row.fecha_asignacion_cita : 'Fecha no asignada';
            CITA_BODY.innerHTML += `
<!-- Primera card -->
<div class="col-lg-12 col-md-12 col-sm-12 mb-4">
    <div class="conteinerInicio card card-body text-center">
        <div class="row">
            <!-- Columna 1: Imagen -->
            <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                <img src="${SERVER_URL}images/imagenes/${row.imagen_1}" class="card-img-top text-white  "
                    alt="ERROR CARGAR IMAGEN">
            </div>
            <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Servicio</h2>
                <h4 class="card-title text-primary">${row.tipo_servicio}</h4>
            </div>
            <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Estado de cita</h2>
                <h4 class="card-text text-success">${row.estado_cita}</h4>
            </div>
            <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Empleado asignado</h2>
                <h4 class="card-text text-white">${row.nombre_empleado} ${row.apellido_empleado}</h4>
            </div>
            <div class="col-2 d-flex flex-column justify-content-center align-items-center">
                <h2 class="mb-5 text-white">Fecha de cita</h2>
                <h4 class="card-text text-warning">${fecha}</h4>
            </div>
        </div>
    </div>
</div>
</div>
`;
        });
    } else {
        CITA_BODY.innerHTML = `
        <div class="col-5 justify-content-center align-items-center">
                <img src="../../resources/img/error/errorCitas.png" class="card-img-top" alt="ERROR CARGAR IMAGEN">
            </div>
        `
        sweetAlert(4, DATA.error, true);
    }
}