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
    MAIN_TITLE.textContent = 'Citas ';
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
                <div class="col-md-12 col-lg-6 mb-5">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h2 class="card-title">${row.tipo_servicio}</h2>
                            <h5 class="card-text text-warning">${row.estado_cita}</h5>
                            <h3 class="card-text text-info-emphasis">${fecha}</h3>
                            <a href="#" class="btn btn-primary">ver detalles</a>
                        </div>
                    </div>
                </div>
            `;
        });
    } else {
        sweetAlert(4, DATA.error, true);
    }
}
