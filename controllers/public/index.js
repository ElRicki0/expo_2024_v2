// Constantes para completar las rutas de la API.
const SERVICIO_API = 'services/admin/servicio.php';

// Constantes para establecer el contenido de la tabla.
const SERVICIOS = document.getElementById('servicios');

    // Método del evento para cuando el documento ha cargado.
    document.addEventListener('DOMContentLoaded', async () => {
        // Llamada a la función para mostrar el encabezado y pie del documento.
        loadTemplate();
    })