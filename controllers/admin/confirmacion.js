// se usa la api del administrador
const CORREO = 'libraries/PHPMailer/enviar.php';
const USER_API = 'services/admin/administrador.php';
// const CORREO = 'libraries/PHPMailer/enviar.php';

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    CORREO_USUARIO = document.getElementById('correoUsuario');

const CODIGO_ADMINISTRADOR = document.getElementById('codigoAdmin'),
    CORREO_ADMINISTRADOR = document.getElementById('correoAdmin');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

    const DATA = await fetchData(USER_API, 'readProfileRecuperacion');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        const ROW = DATA.dataset;
        CODIGO_ADMINISTRADOR.textContent = ROW.codigo_admin;
        CORREO_ADMINISTRADOR.textContent = ROW.correo_admin;
        console.log(CODIGO_ADMINISTRADOR);
        console.log(CORREO_ADMINISTRADOR);
    } else {
        sweetAlert(2, DATA.error, null);
    }
});



// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(USER_API, 'logInRecuperacion', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra un mensaje de éxito
        document.forms.saveForm.addEventListener('submit', enviarFormulario);
        sweetAlert(1, 'código enviado correctamente', false, 'confirmacion.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});


// Función para manejar el envío del formulario
function enviarFormulario(event) {
    event.preventDefault(); // Evitar el envío tradicional del formulario

    // Capturamos los datos del formulario
    const formData = new FormData(SAVE_FORM);

    // Enviar los datos usando fetch()
    fetch('libraries/PHPMailer/enviar.php', {
    // fetch('libraries/PHPMailer/enviar.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text())
        .then(data => {
            alert('Correo enviado exitosamente!');
            console.log(data);  // Mostrar la respuesta del servidor
        })
        .catch(error => {
            console.error('Error al enviar el correo:', error);
            alert('Hubo un error al enviar el correo.');
        });
}

