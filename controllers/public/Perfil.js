const PROFILE_FORM = document.getElementById('profileForm'),
    ID_CLIENTE = document.getElementById('idCliente'),
    NOMBRE_CLIENTE = document.getElementById('nombreCliente'),
    APELLIDO_CLIENTE = document.getElementById('apellidoCliente'),
    CORREO_CLIENTE = document.getElementById('correoCliente'),
    DUI_CLIENTE = document.getElementById('duiCliente'),
    NACIMIENTO_CLIENTE = document.getElementById('nacimientoCliente'),
    TELEFONO_CLIENTE = document.getElementById('telefonoCliente');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();

    // Llamar a la función para limitar las fechas pasadas al cargar la página
    limitarFechasPasadas();

    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Perfil';

    // Petición para obtener los datos del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'readProfile');

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        const ROW = DATA.dataset;
        NOMBRE_CLIENTE.value = ROW.nombre_cliente;
        APELLIDO_CLIENTE.value = ROW.apellido_cliente;
        CORREO_CLIENTE.value = ROW.correo_cliente;
        DUI_CLIENTE.value = ROW.dui_cliente;
        NACIMIENTO_CLIENTE.value = ROW.nacimiento_cliente;
        TELEFONO_CLIENTE.value = ROW.telefono_cliente;
    } else {
        sweetAlert(2, DATA.error, null);
    }
});

// Método del evento para cuando se envía el formulario de editar perfil.
PROFILE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(PROFILE_FORM);
    // Petición para actualizar los datos personales del usuario.
    const DATA = await fetchData(USER_API, 'editProfile', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        sweetAlert(1, DATA.message, true);
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

// Función para limitar las fechas futuras en un campo de entrada tipo date
function limitarFechasPasadas() {
    // Obtener la fecha actual
    const fechaActual = new Date().toISOString().split('T')[0];

    // Establecer el atributo 'max' con la fecha actual para evitar fechas futuras
    NACIMIENTO_CLIENTE.setAttribute('max', fechaActual);
}

