// constante de api de empleado
const EMPLEADO_API = "services/admin/empleado.php";

// Constante para establecer el formulario de registro del primer usuario.
const SIGNUP_FORM = document.getElementById("signupForm");
// Constante para establecer el formulario de registro del primer usuario.
const CONTENEDOR_SIGNUP_FORM = document.getElementById("contenedorSignUp");

// Método del evento para cuando el documento ha cargado.
document.addEventListener("DOMContentLoaded", async () => {
    // Petición para consultar los usuarios registrados.
    const DATA = await fetchData(USER_API, "readUsers");
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (DATA.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = "inicio.html";
    } else if (DATA.status) {
        sweetAlert(1, DATA.message, false, 'index.html');
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        location.href = "signUpEmployee.html";
    }

    // // Petición para consultar los usuarios registrados.
    // const DATA = await fetchData(USER_API, "readUsers");
    // // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    // if (DATA.session) {
    //     // Se direcciona a la página web de bienvenida.
    //     location.href = "inicio.html";
    // } else if (DATA.status) {
    //     // Se muestra el formulario para iniciar sesión.
    //     location.href = "index.html";
    // } else {
    //     sweetAlert(2, DATA.error, false);
    // }

});

// Método del evento para cuando se envía el formulario de registro del primer usuario.
SIGNUP_FORM.addEventListener("submit", async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SIGNUP_FORM);
    // Petición para registrar el primer usuario del sitio privado.
    const DATA = await fetchData(USER_API, "signUp", FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        sweetAlert(1, DATA.message, true, "index.html");
    } else {
        sweetAlert(2, DATA.error, false);
    }
});
