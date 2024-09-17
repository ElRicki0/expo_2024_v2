// se usa la api del administrador
const USER_API = 'services/admin/administrador.php';
const CORREO = 'libraries/PHPMailer/enviar.php';

// Constantes para establecer los elementos del formulario de guardar.
const SAVE_FORM = document.getElementById('saveForm');
const CORREO_USUARIO = document.getElementById('correoUsuario');

const CODIGO_ADMINISTRADOR = document.getElementById('codigoAdmin');
const CORREO_ADMINISTRADOR = document.getElementById('correoAdmin');

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
        CODIGO_ADMINISTRADOR.textContent = ROW.codigo_admin;
        CORREO_ADMINISTRADOR.textContent = ROW.correo_admin;
        
        // Llamar directamente a la función para enviar el correo.
        enviarFormulario(FORM);
        sweetAlert(1, 'Codigo enviado correctamente a su correo electrónico', false, 'confirmacion.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});



// Función para manejar el envío del formulario
function enviarFormulario(formData) {
    // Enviar los datos usando fetch()
    fetch('/expo_2024_v2/api/libraries/PHPMailer/enviar.php', {
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
