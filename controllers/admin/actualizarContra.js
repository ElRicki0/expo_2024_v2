const USER_API = 'services/admin/administrador.php';

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

});



// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {

    const claveAdmin = document.getElementById('claveAdmin').value;
    const repetirAdmin = document.getElementById('repetirAdmin').value;

    if (claveAdmin !== repetirAdmin) {
        event.preventDefault(); // Detiene el envío del formulario
        sweetAlert(2, 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo', false);
    }
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(USER_API, 'changeNewPassword', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra un mensaje de éxito
        sweetAlert(1, DATA.message, false, 'index.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});