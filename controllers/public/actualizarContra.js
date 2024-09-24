const USER_API = 'services/public/cliente.php';

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

});


// Método del evento que se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {

    const claveUser = document.getElementById('claveUser').value;
    const repetirUser = document.getElementById('repetirUser').value;

    if (claveUser !== repetirUser) {
        event.preventDefault(); // Detiene el envío del formulario.
        sweetAlert(2, 'Las contraseñas no coinciden. Por favor, inténtalo de nuevo', false);
    }
    else {
        // Se evita recargar la página web después de enviar el formulario.
        event.preventDefault();
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SAVE_FORM);
        // Petición para guardar los datos del formulario.
        const DATA = await fetchData(USER_API, 'changeNewPassword', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {

            const DATA = await fetchData(USER_API, 'logOut');
            // Se comprueba si la respuesta es correcta, de lo contrario se muestra un mensaje con la excepción.
            if (DATA.status) {
                sweetAlert(1, 'Clave actualizada correctamente', true, 'index.html');
            } else {
                sweetAlert(2, DATA.exception, false);
            }
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }

});