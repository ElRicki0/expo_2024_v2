// Constantes para establecer los elementos del formulario de editar perfil.
const NOMBRE_ADMINISTRADOR = document.getElementById('nombreAdmin');
const CORREO_ADMINISTRADOR = document.getElementById('correoAdmin');

// Constante para establecer la modal de cambiar contraseña.
const PASSWORD_MODAL = new bootstrap.Modal('#passwordModal');

// Constante para establecer el formulario de cambiar contraseña.
const PASSWORD_FORM = document.getElementById('passwordForm');

// Constante para establecer la modal de cambiar perfil.
const PERFIL_MODAL = new bootstrap.Modal('#PerfilModal');

// Constante para establecer el formulario de cambiar perfil.
const PROFILE_FORM = document.getElementById('editForm'),
    NOMBRE_ADMINISTRADOR_PERFIL = document.getElementById('nombreAdminPerfil'),
    CORREO_ADMINISTRADOR_PERFIL = document.getElementById('correoAdminPerfil');

// Constante para establecer la modal de eliminar perfil
const DELETE_MODAL = new bootstrap.Modal('#deleteModal');

// Constante para establecer el formulario de eliminar perfil
const DELETE_FORM = document.getElementById('deleteForm');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Petición para obtener los datos del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'readProfile');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        const ROW = DATA.dataset;
        NOMBRE_ADMINISTRADOR.textContent = ROW.nombre_admin;
        CORREO_ADMINISTRADOR.textContent = ROW.correo_admin;
    } else {
        sweetAlert(2, DATA.error, null);
    }
});

// Mètodo del evento para cuando se envía el formulario de cambiar contraseña.
PASSWORD_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(PASSWORD_FORM);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(USER_API, 'changePassword', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        PASSWORD_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

// Mètodo del evento para cuando se envía el formulario de cambiar contraseña.
PROFILE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(PROFILE_FORM);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(USER_API, 'editProfile', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        PERFIL_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        setTimeout(() => {
            location.href = "perfil.html";
        }, 2000); // Espera 3 segundos antes de redirigir
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

// Mètodo del evento para cuando se envía el formulario de cambiar contraseña.
DELETE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(DELETE_FORM);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(USER_API, 'checkPassword', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra un mensaje de confirmación y se captura la respuesta en una constante.
        const RESPONSE = await confirmAction('¿Está seguro de eliminar el perfil?');
        // Se verifica la respuesta del mensaje.
        if (RESPONSE) {
            // Se define un objeto con los datos del registro seleccionado.
            const FORM = new FormData();

            // Petición para cambiar el estado del cliente
            const DATA = await fetchData(USER_API, 'DeleteProfile', FORM);

            // Se comprueba si la respuesta es satisfactoria
            if (DATA.status) {
                sweetAlert(1, DATA.message, true); // Mensaje de éxito
                setTimeout(() => {
                    location.href = "index.html";
                }, 3000); // Espera 3 segundos antes de redirigir
            } else {
                sweetAlert(2, DATA.error, false); // Mensaje de error
            }
        }
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función para preparar el formulario al momento de cambiar la constraseña.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openPassword = () => {
    // Se abre la caja de diálogo que contiene el formulario.
    PASSWORD_MODAL.show();
    // Se restauran los elementos del formulario.
    PASSWORD_FORM.reset();
}

/*
*   Función para preparar el formulario al momento de editar el perfil
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openProfile = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idAdministrador', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(USER_API, 'readProfile', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        PERFIL_MODAL.show();
        // Se prepara el formulario.
        PROFILE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        NOMBRE_ADMINISTRADOR_PERFIL.value = ROW.nombre_admin;
        CORREO_ADMINISTRADOR_PERFIL.value = ROW.correo_admin;
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
*   Función para preparar el formulario al momento de eliminar el perfil
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const openDelete = () => {
    // Se abre la caja de diálogo que contiene el formulario.
    DELETE_MODAL.show();
    // Se restauran los elementos del formulario.
    DELETE_FORM.reset();
}