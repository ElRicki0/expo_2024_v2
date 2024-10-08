// se usa la api del administrador
const CORREO = 'libraries/PHPMailer/enviar.php';

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
})

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm');
const CORREO_USUARIO = document.getElementById('correoUsuario');

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);

    // Petición para obtener los datos del administrador.
    const DATA = await fetchData(USER_API, 'readOneRecuperacion', FORM);
    
    // Verificamos si la respuesta es satisfactoria.
    if (DATA.status) {
        const ROW = DATA.dataset;
        
        // Llamar directamente a la función para enviar el correo.
        sweetAlert(1, 'Codigo enviado correctamente a su correo electrónico', false, 'confirmacion.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});