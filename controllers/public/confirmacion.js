// se usa la api del administrador
const CORREO = 'libraries/PHPMailer/enviar.php';

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
})

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm');

const CODIGO_ADMINISTRADOR = document.getElementById('codigoUsuario'),
    CORREO_ADMINISTRADOR = document.getElementById('correoAdmin');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(USER_API, 'checkUserCodigo', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra un mensaje de éxito
        sweetAlert(1, 'Verificacion exitosa', false, 'actualizarContra.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});