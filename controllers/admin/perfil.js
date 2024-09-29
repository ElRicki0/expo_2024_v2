// Constante para completar la ruta de la API.
const EMPLEADO_API = 'services/admin/empleado.php';

// Constantes para establecer los elementos del formulario de editar perfil.
const NOMBRE_ADMINISTRADOR = document.getElementById('nombreAdmin');
const CORREO_ADMINISTRADOR = document.getElementById('correoAdmin');

// Constantes para establecer los elementos del componente Modal.
const EMPLEADO_MODAL = new bootstrap.Modal('#empleadoModal'),
    MODAL_TITLE = document.getElementById('modalTitle');

// constantes de para información del empleado
const NOMBRE_EMPLEADO = document.getElementById('empleadoNombre'),
    APELLIDO_EMPLEADO = document.getElementById('empleadoApellido'),
    ESPECIALIDAD_EMPLEADO = document.getElementById('empleadoEspecialidad'),
    DUI_EMPLEADO = document.getElementById('empleadoDUI'),
    CORREO_EMPLEADO = document.getElementById('empleadoCorreo'),
    FECHA_EMPLEADO = document.getElementById('empleadoFecha');

// constangtes para poder mostrar la imagen seleccionada
const FORM_IMAGEN = document.getElementById('formImagen'),
    IMAGEN_MUESTRA = document.getElementById('imagenMuestra'),
    IMAGEN_PERFIL = document.getElementById('perfil');

// Constante para establecer la modal de cambiar contraseña.
const PASSWORD_MODAL = new bootstrap.Modal('#passwordModal');

// Constante para establecer el formulario de cambiar contraseña.
const PASSWORD_FORM = document.getElementById('passwordForm');

// Constante para establecer la modal de cambiar perfil.
const PERFIL_MODAL = new bootstrap.Modal('#PerfilModal');

// Constante para establecer el formulario de cambiar datos del administrador.
const PROFILE_FORM = document.getElementById('editForm'),
    IMAGEN_ADMIN = document.getElementById('imagenAdmin'),
    NOMBRE_ADMINISTRADOR_PERFIL = document.getElementById('nombreAdminPerfil'),
    CORREO_ADMINISTRADOR_PERFIL = document.getElementById('correoAdminPerfil');

// constante para cambiar los datos del empleado asignado al administrador
const EMPLEADO_FORM = document.getElementById('empleadoForm'),
    EMPLEADO_ID = document.getElementById('idEmpleado'),
    EMPLEADO_NOMBRE = document.getElementById('nombreEmpleado'),
    EMPLEADO_APELLIDO = document.getElementById('apellidoEmpleado'),
    EMPLEADO_CORREO = document.getElementById('correoEmpleado'),
    EMPLEADO_DUI = document.getElementById('duiEmpleado'),
    EMPLEADO_FECHA = document.getElementById('fechaEmpleado'),
    EMPLEADO_ESTADO = document.getElementById('estadoEmpleado');

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
        // datos de administrador
        NOMBRE_ADMINISTRADOR.textContent = ROW.nombre_admin;
        IMAGEN_MUESTRA.src = ROW.imagen_admin;
        CORREO_ADMINISTRADOR.textContent = ROW.correo_admin;
        NOMBRE_EMPLEADO.textContent = ROW.nombre_empleado;
        APELLIDO_EMPLEADO.textContent = ROW.apellido_empleado;
        CORREO_EMPLEADO.textContent = ROW.correo_empleado;
        DUI_EMPLEADO.textContent = ROW.dui_empleado;
        FECHA_EMPLEADO.textContent = ROW.nacimiento_empleado;
        ESPECIALIDAD_EMPLEADO.textContent = ROW.especialidad_empleado;
        //datos de empleado
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
EMPLEADO_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(EMPLEADO_FORM);
    // Petición para actualizar la constraseña.
    const DATA = await fetchData(EMPLEADO_API, 'updateRow', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        EMPLEADO_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        setTimeout(() => {
            location.href = "perfil.html";
        }, 2000); // Espera 3 segundos antes de redirigir
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
const openEmpleado = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idEmpleado', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(USER_API, 'readProfile', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        EMPLEADO_MODAL.show();
        MODAL_TITLE.textContent = 'EDITAR EMPLEADO';
        // Se prepara el formulario.
        EMPLEADO_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        EMPLEADO_ID.value = ROW.id_empleado;
        EMPLEADO_NOMBRE.value = ROW.nombre_empleado;
        EMPLEADO_APELLIDO.value = ROW.apellido_empleado;
        EMPLEADO_CORREO.value = ROW.correo_empleado;
        EMPLEADO_DUI.value = ROW.dui_empleado;
        EMPLEADO_FECHA.value = ROW.nacimiento_empleado;
        EMPLEADO_ESTADO.checked = ROW.estado_empleado;
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

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