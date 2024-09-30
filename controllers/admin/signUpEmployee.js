const EMPLEADO_API = 'services/admin/empleado.php';

// CONSTANTES PARA MOSTRAR IMAGEN SELECCIONADA  PARA EL PERFIL DEL EMPLEADO
const IMAGEN_MUESTRA = document.getElementById('imagenMuestra'),
    IMAGEN_EMPLEADO = document.getElementById('imagenEmpleado');


// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById('signupForm');
// Constante para establecer el formulario de registro del primer usuario.
const CONTENEDOR_SIGNUP_FORM = document.getElementById('contenedorSignUp');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Petición para consultar los usuarios registrados.
    const DATA = await fetchData(EMPLEADO_API, 'readEmployee');
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (DATA.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = 'inicio.html';
    } else if (DATA.status) {
        // Se muestra el formulario para iniciar sesión.
        location.href = "signUpAdmin.html";
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        sweetAlert(4, DATA.error, false);
    }
});

IMAGEN_EMPLEADO.addEventListener('change', function (event) {
    // Verifica si hay una imagen seleccionada
    if (event.target.files && event.target.files[0]) {
        // con el objeto Filereader lee el archivo seleccionado
        const reader = new FileReader();
        // Luego de haber leido la imagen selecionada se nos devuelve un objeto de tipo blob
        // Con el metodo createObjectUrl de fileReader crea una url temporal para la imagen
        reader.onload = function (event) {
            // finalmente la url creada se le asigna el atributo de la etiqueta img
            IMAGEN_MUESTRA.src = event.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
})

// Método del evento para cuando se envía el formulario de registro del primer usuario.
SIGNUP_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar el primer usuario del sitio privado.
    const DATA = await fetchData(EMPLEADO_API, 'signUp', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        sweetAlert(1, DATA.message, true, 'signUpAdmin.html');
    } else {
        sweetAlert(2, DATA.error, false);
    }
});