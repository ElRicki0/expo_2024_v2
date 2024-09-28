// Constantes para completar las rutas de la API.
const CITA_API = 'services/admin/cita.php';
const CLIENTE_API = 'services/admin/cliente.php';

// constangtes para poder mostrar la imagen seleccionada
const IMAGEN_MUESTRA = document.getElementById('imagenMuestra');

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('searchForm');
// Constantes para establecer el contenido de la tabla.
const CLIENTES = document.getElementById('clientes');
const ROWS_FOUND = document.getElementById('rowsFound');

// Constantes para establecer los elementos del componente Modal.
const CHART_MODAL = new bootstrap.Modal('#chartModal');

// Constantes para establecer los elementos del componente Modal.
const SAVE_MODAL = new bootstrap.Modal('#saveModal'),
    MODAL_TITLE = document.getElementById('modalTitle');

const SAVE_FORM = document.getElementById('saveForm'),
    ID_CLIENTE = document.getElementById('idCliente'),
    IMAGEN_CLIENTE = document.getElementById('imagenCliente'),
    NOMBRE_CLIENTE = document.getElementById('nombreCliente'),
    APELLIDO_CLIENTE = document.getElementById('apellidoCliente'),
    CORREO_CLIENTE = document.getElementById('correoCliente'),
    DUI_CLIENTE = document.getElementById('duiCliente'),
    TELEFONO_CLIENTE = document.getElementById('telefonoCliente'),
    FECHA_CLIENTE = document.getElementById('fechaCliente'),
    ESTADO_CLIENTE = document.getElementById('estadoCliente');

// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    graficoBarras();
    // Llamada a la función para llenar la tabla con los registros existentes.
    fillTable();
});

IMAGEN_CLIENTE.addEventListener('change', function (event) {
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
});

// Método del evento para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});

// Método del evento para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (ID_CLIENTE.value) ? action = 'updateRow' : action = 'createAdminRow';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(CLIENTE_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se cierra la caja de diálogo.
        SAVE_MODAL.hide();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, DATA.message, true);
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
    } else {
        sweetAlert(2, DATA.error, false);
    }
});

/*
* Función asíncrona para llenar la tabla con los registros disponibles.
* Parámetros: form (objeto opcional con los datos de búsqueda).
* Retorno: ninguno.
*/
const fillTable = async (form = null) => {
    // Se inicializa el contenido de la tabla.
    CLIENTES.innerHTML = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'searchRows' : action = 'readAll';
    // Petición para obtener los registros disponibles.
    const DATA = await fetchData(CLIENTE_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se recorre el conjunto de registros (dataset) fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se establece un icono para el estado del producto.
            (row.estado_cliente) ? icon = 'bi bi-eye-fill' : icon = 'bi bi-eye-slash-fill';
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            CLIENTES.innerHTML += `
<div class="col-12 card mt-2 inicioIndex" id="searchForm">
    <div class="row  ">
        <div class="col-3 mt-3 d-flex align-items-center mx-2 justify-content-center" style="height: 200px; width: 200px;">
            <!-- Ajusta la altura según sea necesario -->
            <img src="${SERVER_URL}images/clientes/${row.imagen_cliente}" class="card-img-top" alt="..."
                onerror="this.onerror=null; this.src='../../resources/img/error/cliente.jpg';"
                style="max-width: 100%; max-height: 100%;">
        </div>

        <div class="col-3 card-body">
            <h5 class="text-white" for="">Nombre cliente</h5>
            <p class="card-title text-white">${row.nombre_cliente}</p>
            <p class="card-text text-white">${row.apellido_cliente}</p>
            <h5 class="text-white" for="">Teléfono cliente</h5>
            <p class="card-text text-white">${row.telefono_cliente}</p>
            <h5 class="text-white" for="">Estado cliente</h5>
            <p class="card-text text-white">Estado: <i class="${icon} text-white"></i></p>
        </div>
        <div class="col-3 text-center my-5">
            <div class="mt-3">
                <div class="d-flex flex-column">
                    <button class="btn btn-outline-light mb-2" onclick="openDelete(${row.id_cliente})">
                        <i class="bi bi-trash3-fill"></i> Eliminar
                    </button>
                    <button class="btn btn-outline-light mb-2" onclick="openUpdate(${row.id_cliente})">
                        <i class="bi bi-pencil-fill"></i>Actualizar
                    </button>
                    <button class="btn btn-outline-light mb-2" onclick="openState(${row.id_cliente})">
                        <i class="bi bi-exclamation-octagon"></i> Cambiar Estado
                    </button>
                    <button type="button" class="btn btn-outline-light mb-2" onclick="openChart(${row.id_cliente})">
                        <i class="bi bi-bar-chart-line-fill"></i> Ver Gráfico
                    </button>
                    <button type="button" class="btn btn-outline-light" onclick="openClienteReport(${row.id_cliente})">
                        <i class="bi bi-file-earmark-code-fill"></i> Informe del Cliente
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
`;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
        ROWS_FOUND.textContent = DATA.message;
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función para preparar el formulario al momento de insertar un registro.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const openCreate = () => {
    // Se muestra la caja de diálogo con su título.
    SAVE_MODAL.show();
    MODAL_TITLE.textContent = 'Crear cliente';
    // Se prepara el formulario.
    SAVE_FORM.reset();
}

/*
* Función asíncrona para eliminar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/


/*
* Función asíncrona para preparar un modal de confirmacion para una funcion de estado
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openState = async (id) => {
    // Se muestra un mensaje de confirmación y se captura la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Está seguro de cambiar el estado del cliente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define un objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idCliente', id);

        // Petición para cambiar el estado del cliente
        const DATA = await fetchData(CLIENTE_API, 'updateRowEstado', FORM);

        // Se comprueba si la respuesta es satisfactoria
        if (DATA.status) {
            sweetAlert(1, DATA.message, true); // Mensaje de éxito
            fillTable(); // Recargar la tabla para visualizar los cambios
        } else {
            sweetAlert(2, DATA.error, false); // Mensaje de error
        }
    }
}

/*
* Función asíncrona para eliminar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openDelete = async (id) => {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar al cliente de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('idCliente', id);
        // Petición para eliminar el registro seleccionado.
        const DATA = await fetchData(CLIENTE_API, 'deleteRow', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se muestra un mensaje de éxito.
            await sweetAlert(1, DATA.message, true);
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
        } else {
            sweetAlert(2, DATA.error, false);
        }
    }
}

/*
* Función asíncrona para preparar el formulario al momento de actualizar un registro.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openUpdate = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idCliente', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(CLIENTE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        SAVE_MODAL.show();
        MODAL_TITLE.textContent = 'Editar Cliente';
        // Se prepara el formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos con los datos.
        const ROW = DATA.dataset;
        ID_CLIENTE.value = ROW.id_cliente;
        NOMBRE_CLIENTE.value = ROW.nombre_cliente;
        APELLIDO_CLIENTE.value = ROW.apellido_cliente;
        CORREO_CLIENTE.value = ROW.correo_cliente;
        DUI_CLIENTE.value = ROW.dui_cliente;
        FECHA_CLIENTE.value = ROW.nacimiento_cliente;
        TELEFONO_CLIENTE.value = ROW.telefono_cliente;
        ESTADO_CLIENTE.checked = ROW.estado_cliente;
        console.log(NOMBRE_CLIENTE);
    } else {
        sweetAlert(2, DATA.error, false);
    }
}

/*
* Función asíncrona para mostrar un gráfico de barras con la cantidad de productos por categoría.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const graficoBarras = async () => {
    // Petición para obtener los datos del gráfico.
    const DATA = await fetchData(CITA_API, 'readCantidadCliente');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let empleado = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            empleado.push(row.nombre_cliente);
            citas.push(row.cantidad_citas);
        });
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', empleado, citas, 'MAYOR CANTIDAD DE CITAS', 'CLIENTES CON MAS CITAS');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.error);
    }
}

/*
* Función asíncrona para mostrar un gráfico parametrizado.
* Parámetros: id (identificador del registro seleccionado).
* Retorno: ninguno.
*/
const openChart = async (id) => {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('idCliente', id);
    // Petición para obtener los datos del registro solicitado.
    const DATA = await fetchData(CLIENTE_API, 'readClienteCitas', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con el error.
    if (DATA.status) {
        // Se muestra la caja de diálogo con su título.
        CHART_MODAL.show();
        // Se declaran los arreglos para guardar los datos a graficar.
        let servicios = [];
        let citas = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            servicios.push(row.tipo_servicio);
            citas.push(row.cantidad_citas);
        });
        // Se agrega la etiqueta canvas al contenedor de la modal.
        document.getElementById('chartContainer').innerHTML = `<canvas id="chart"></canvas>`;
        // Llamada a la función para generar y mostrar un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart', servicios, citas, 'CANTIDAD DE CITAS', 'CITAS REALIZADAS POR EL CLIENTE');
    } else {
        sweetAlert(4, DATA.error, true);
    }
}

/*
* Función para abrir un reporte automático de productos por categoría.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
const openReport = () => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/clientes.php`);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}

// reporte parametrizado
const openClienteReport = (id) => {
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/admin/cliente_servicio.php`);
    // Se agrega un parámetro a la ruta con el valor del registro seleccionado.
    PATH.searchParams.append('idCliente', id);
    // Se abre el reporte en una nueva pestaña.
    window.open(PATH.href);
}