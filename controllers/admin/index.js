// constante de api de empleado
const EMPLEADO_API = "services/admin/empleado.php";

// Constante para establecer el formulario de inicio de sesión.
const LOGIN_FORM = document.getElementById("loginForm");
// Constante para establecer el formulario de inicio de sesión.
const CONTENEDOR_LOGIN_FORM = document.getElementById("contenedorLogIn");

// Método del evento para cuando el documento ha cargado.
document.addEventListener("DOMContentLoaded", async () => {
    // Petición para consultar los usuarios registrados.
    const DATA2 = await fetchData(EMPLEADO_API, "readEmployee");
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (DATA2.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = "signUpAdmin.html";
    } else if (DATA2.status) {
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        location.href = "signUpEmployee.html";
    }

    // Petición para consultar los usuarios registrados.
    const DATA = await fetchData(USER_API, "readUsers");
    // Se comprueba si existe una sesión, de lo contrario se sigue con el flujo normal.
    if (DATA.session) {
        // Se direcciona a la página web de bienvenida.
        location.href = "inicio.html";
    } else if (DATA.status) {
        // Se muestra el formulario para iniciar sesión.
        sweetAlert(4, DATA.message, true);
    } else {
        // Se muestra el formulario para registrar el primer usuario.
        location.href = "signUpAdmin.html";
    }
});

// Método del evento para cuando se envía el formulario de inicio de sesión.
LOGIN_FORM.addEventListener("submit", async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(LOGIN_FORM);
    // Petición para iniciar sesión.
    const DATA = await fetchData(USER_API, "logIn", FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        sweetAlert(1, DATA.message, true, "inicio.html");
    } else {
        sweetAlert(2, DATA.error, false);
    }
});
