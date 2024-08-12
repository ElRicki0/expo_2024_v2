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
    MAIN_TITLE.textContent = 'Citas solicitadas';
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
            const fecha = row.fecha_asignacion_cita ? row.fecha_asignacion_cita : 'Fecha no asignada';
            CITA_BODY.innerHTML += `
                <!-- pantalla de citas -->
            <div class="col-lg-9 col-md-8 col-sm-12 ">
                <div class="row" id="citas">
                    <!-- cards de citas -->
                    <div class="card card-body text-center">
                        <div class="row">
                            <div class="col-3">
                                <img src="..." class="card-img-top" alt="ERROR CARGAR IMAGEN">
                            </div>
                            <div class="col-3">
                                <h2 class="mb-5">Servicio</h2>
                                <h4 class="card-title">${row.tipo_servicio}</h4>
                            </div>
                            <div class="col-3">
                                <h2 class="mb-5">Estado de cita</h2>
                                <h4 class="card-text text-warning">${row.estado_cita}</h4>
                            </div>
                            <div class="col-3">
                                <h2 class="mb-5">Fecha de cita</h2>
                                <h4 class="card-text text-info-emphasis">${fecha}</h4>
                            </div>
                        </div>

                        <a href="#" class="btn btn-primary col-2">Go somewhere</a>
                    </div>
                </div>
            </div>
            `;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}
