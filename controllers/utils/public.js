/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
MAIN.style.paddingTop = '75px';
MAIN.style.paddingBottom = '100px';
MAIN.classList.add('container');
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Quiropráctica Especifica';
// Constante para establecer el elemento del título principal.
const MAIN_TITLE = document.getElementById('mainTitle');
MAIN_TITLE.classList.add('text-center', 'py-3');

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
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                <nav class="navbar navbar-dark border-bottom border-secondary">
                    <div class="container-fluid">
                        <a class="navbar-brand fw-bold d-flex align-items-center" href="inicio.html">
                            <img src="../../resources/img/icons/icon.jpg" alt="" height="50px"
                                class="d-inline-block align-text-top">
                            Quiropractica Especifica
                        </a>
                        <button class="navbar-toggler rounded-5" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar"
                            aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <a type="button" class="btn-close" data-bs-dismiss="offcanvas"></i></a>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item dropdown text-center">
                                        <a class="nav-link" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear-fill"></i> <b>${DATA.username}</b>
                                        </a>
                                        <hr>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="perfil.html"> Ver perfil </a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="#" onclick="logOut()"> Cerrar sesion </a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link active" aria-current="page" href="inicio.html"><i class="bi bi-house-fill me-1"></i> Inicio</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="clientes.html"><i class="bi bi-people-fill me-1"></i> Clientes</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="empleados.html"><i class="bi bi-people"></i> Empleados</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="administradores.html"><i class="bi bi-person-circle me-1"></i></i> Admin</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="../../views/admin/servicios.html"><i class="bi bi-file-medical-fill me-1"></i> Servicios</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="beneficios.html"><i class="bi bi-lungs-fill me-1"></i> Beneficios</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="preguntas.html"><i class="bi bi-question-lg me-1"></i> Preguntas</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="citas.html"><i class="bi bi-bookmark-plus-fill me-1"></i> Citas</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="tratamientos.html"><i class="bi bi-clipboard2-pulse-fill me-1"></i>Tratamientos</a>
                                    </li>
                                    <li class="nav-item ms-4">
                                        <a class="nav-link" href="comentarios.html"><i class="bi bi-chat-left-text-fill me-1"></i>Comentarios</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>`);
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }

    } else {
        // Se agrega el encabezado de la página web antes del contenido principal.
        MAIN.insertAdjacentHTML('beforebegin',
            `
            <header>
            <nav class="navbar navbar-dark border-bottom border-secondary">
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
                            <button type="button" class="btn btn-outline-info">
                                <i class="bi bi-search"></i>
                            </button>
                        </a>
                        <button type="button" class="btn btn-outline-light" ><a class="sinLink textoClaro" href="login.html">Iniciar sesión</a></button>
                    </div>
                </div>
            </nav>
        </header>
            `);
    }
    // Se agrega el pie de la página web después del contenido principal.
    MAIN.insertAdjacentHTML('afterend', `
        <footer>
            <nav class="navbar fixed-bottom bg-body-tertiary">
                <div class="container">
                    <p><a class="nav-link" href="https://github.com/ElRicki0/expo_2024_v2" target="_blank"><i class="bi bi-github"></i> Quiropractica Especifica</a></p>
                    <p><i class="bi bi-envelope-fill"></i> dacasoft@outlook.com</p>
                </div>
            </nav>
        </footer>
    `);
}