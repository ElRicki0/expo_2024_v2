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