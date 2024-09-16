// se usa la api del administrador
const USER_API = 'services/admin/administrador.php';
const CORREO = 'libraries/PHPMailer/enviar.php';

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm'),
    CORREO_USUARIO = document.getElementById('correoUsuario');

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA2 = await fetchData(USER_API, 'logInRecuperacion', FORM);
    const DATA = await fetchData(CORREO, 'logInRecuperacion', FORM);
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
    const formData = new FormData(document.forms.enviar);

    // Enviar los datos usando fetch()
    fetch('libraries/PHPMailer/enviar.php', {
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

