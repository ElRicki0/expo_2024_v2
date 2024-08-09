// Constantes para completar la ruta de la API.
const SERVICIO_API = 'services/public/servicio.php';
const BENEFICIO_API = 'services/public/beneficio.php';
const CITA_API = 'services/public/cita.php';


const BENEFICIOS = document.getElementById('beneficiosServicio');
const ID_SERVICIO = document.getElementById('idServicio');

// Constante tipo objeto para obtener los parámetros disponibles en la URL.
const PARAMS = new URLSearchParams(location.search);

// OBTENIENDO EL ID DEL PRODUCTO
const ID_BENEFICIO = PARAMS.get('id');
// Constante para establecer el formulario de agregar un producto al carrito de compras.
const SHOPPING_FORM = document.getElementById('shoppingForm');


// Método del eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para mostrar el encabezado y pie del documento.
    loadTemplate();
    // Se establece el título del contenido principal.
    MAIN_TITLE.textContent = 'Detalles servicio';
    // Constante tipo objeto con los datos del producto seleccionado.
    const FORM = new FormData();
    FORM.append('idServicio', PARAMS.get('id'));
    // Petición para solicitar los datos del producto seleccionado.
    const DATA = await fetchData(SERVICIO_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se colocan los datos en la página web de acuerdo con el producto seleccionado previamente.
        document.getElementById('imagenServicio').src = SERVER_URL.concat('images/servicios/', DATA.dataset.imagen_servicio);
        document.getElementById('tipoServicio').textContent = DATA.dataset.tipo_servicio;
        document.getElementById('descripcionServicio').textContent = DATA.dataset.descripcion_servicio;
        document.getElementById('idServicio').value = DATA.dataset.id_servicio;
    } else {
        // Se presenta un mensaje de error cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
        // Se limpia el contenido cuando no hay datos para mostrar.
        document.getElementById('detalle').innerHTML = '';
    }
});

// Método del evento para cuando se envía el formulario de agregar un producto al carrito.
SHOPPING_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SHOPPING_FORM);
    // Petición para guardar los datos del formulario.
    const DATA = await fetchData(CITA_API, 'createRowCliente', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se constata si el cliente ha iniciado sesión.
    if (DATA.status) {
        sweetAlert(1, DATA.message, false, 'index.html');
    } else if (DATA.session) {
        sweetAlert(2, DATA.error, false);
    } else {
        sweetAlert(3, DATA.error, true, 'login.html');
    }
});


// Método del evento para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {

    const FORM = new FormData();
    FORM.append('id_servicio', ID_SERVICIO);
    // Petición para obtener las categorías disponibles.
    const DATA = await fetchData(BENEFICIO_API, 'readAllOne');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (DATA.status) {
        // Se inicializa el contenedor de categorías.
        BENEFICIOS.innerHTML = `
        <div class="carousel-item active">
        <div class="d-flex justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Este es uno de los mejores servicios</h5>
                    <p class="">La mejor decision de mi vida fue escoger este servicio
                    </p>
                </a>
                </div>
            </div>
        </div>
    </div>`;
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {

            BENEFICIOS.innerHTML += `
        <div class="carousel-item">
        <div class="d-flex justify-content-center">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">${row.titulo_beneficio}</h5>
                    <p class="">${row.contenido_beneficio}
                    </p>
                </a>
                </div>
            </div>
        </div>
    </div>
`;
        });
    } else {
        // Se asigna al título del contenido de la excepción cuando no existen datos para mostrar.
        document.getElementById('mainTitle').textContent = DATA.error;
    }
});
