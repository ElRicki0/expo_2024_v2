/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');

// Se establece el título de la página web.
document.querySelector('title').textContent = 'Quiropráctica Especifica';

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin',
                `<nav class="navbar navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.html">
                            <img src="../../resources/img/icons/icon.jpg" alt="" height="50px" class="d-inline-block align-text-top">
                            Quiropractica Especifica
                        </a>
                        <div class="dropdown ms-auto">
                            <button class="btn btn-black dropdown-toggle fs-7 text-white" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <b>${DATA.username}</b>
                            </button>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="perfil.html">Ver perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="logOut()">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </nav>`
            );                        
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin',
            `<nav class="navbar navbar-dark bg-black fixed-top rounded-bottom">
                <div class="row container-fluid">
                    <div class="col-10">
                        <!-- boton del logo en la izquierda -->
                        <a class="navbar-brand fw-bold d-flex align-items-center" href="inicio.html">
                            <img src="../../resources/img/icons/icon.jpg" alt="" height="50px"
                                class="d-inline-block align-text-top">
                            Quiropractica Especifica
                        </a>
                    </div>
                    <div class="col-2 justify-content-end">
                        <!-- boton del logo de acciones en la derecha -->
                        <a class="sinLink" href="buscador.html">
                            <button type="button" class="btn btn-info text-white">
                                <i class="bi bi-search"></i>
                            </button>
                        </a>
                        <a href="login.html" class="btn btn-dark" role="button">Iniciar sesión</a>
                    </div>
                </div>
            </nav>`
        );
    }
    // Se agrega el pie de la página web después del contenido principal.
    MAIN.insertAdjacentHTML('afterend', `
        <footer>
            <nav class="navbar">
                <div class="container">
                    <p><a class="nav-link" href="https://github.com/ElRicki0/expo_2024_v2" target="_blank"><i class="bi bi-github"></i> Quiropractica Especifica</a></p>
                    <p><i class="bi bi-envelope-fill"></i> Quiropractica@gmail.com</p>
                </div>
            </nav>
        </footer>
    `);
}