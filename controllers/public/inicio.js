document.addEventListener('DOMContentLoaded', function() {
    fetchServiciosYComentarios();

    async function fetchServiciosYComentarios() {
        // Obtener el ID de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');

        if (!id) {
            console.error('ID de servicio no proporcionado.');
            return;
        }

        // Ruta base para los endpoints
        const BASE_URL = 'ruta_al_endpoint_php_que_retorna_los_servicios_y_comentarios';
        
        // Fetch servicios
        try {
            const serviciosResponse = await fetch(`${BASE_URL}/servicios.php?id=${id}`);
            const serviciosData = await serviciosResponse.json();

            const serviciosContainer = document.getElementById('servicios-container');
            serviciosContainer.innerHTML = ''; // Limpia el contenedor antes de insertar nuevos servicios

            if (serviciosData.status) {
                serviciosData.dataset.forEach(servicio => {
                    const servicioCard = `
                        <div class="card">
                            <img src="${BASE_URL}/images/${servicio.imagen_servicio}" class="card-img-top" alt="${servicio.tipo_servicio}">
                            <div class="card-body">
                                <h5 class="card-title">${servicio.tipo_servicio}</h5>
                                <p class="card-text">${servicio.descripcion_servicio}</p>
                            </div>
                        </div>
                    `;
                    serviciosContainer.innerHTML += servicioCard;
                });
            } else {
                console.error('No se encontraron servicios.');
            }
        } catch (error) {
            console.error('Error al cargar los servicios:', error);
        }

        // Fetch comentarios
        try {
            const comentariosResponse = await fetch(`${BASE_URL}/comentarios.php?id=${id}`);
            const comentariosData = await comentariosResponse.json();

            const comentariosContainer = document.getElementById('comentarios-container');
            comentariosContainer.innerHTML = ''; // Limpia el contenedor antes de insertar nuevos comentarios

            if (comentariosData.status) {
                comentariosData.dataset.forEach(comentario => {
                    const comentarioItem = `
                        <div class="comentario-item">
                            <p>${comentario.contenido_comentario}</p>
                            <small>- Cliente: ${comentario.nombre_cliente}</small>
                        </div>
                    `;
                    comentariosContainer.innerHTML += comentarioItem;
                });
            } else {
                console.error('No se encontraron comentarios.');
            }
        } catch (error) {
            console.error('Error al cargar los comentarios:', error);
        }
    }
});