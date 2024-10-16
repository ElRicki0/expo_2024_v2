/*
*   Controlador es de uso general en las páginas web del sitio público.
*   Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/public/cliente.php';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
const MAIN_TITLE = document.getElementById('mainTitle');


// Se establece el título de la página web.
document.querySelector('title').textContent = 'Quiropráctica Especifica';

/*  Función asíncrona para cargar el encabezado y pie del documento.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se comprueba si el usuario está autenticado   para establecer el encabezado respectivo.
    if (DATA.session) {
        // Se verifica si la página web no es el inicio de sesión, de lo contrario se direcciona a la página web principal.
        if (!location.pathname.endsWith('login.html') && 
            !location.pathname.endsWith('registro.html') && 
            !location.pathname.endsWith('recuperacion.html')){
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin',
                `                
                <header>
        <nav class="navbar navbar-dark border-bottom border-secondary ">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="index.html">
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
                            <!-- boton del logo de acciones en la derecha -->
                        <a class="sinLink" href="buscador.html">
                            <button type="button" class="btn btn-info text-white">
                                <i class="bi bi-search"></i>
                            </button>
                        </a></li>
                            <li class="nav-item ms-4">
                                <a class="nav-link active" aria-current="page" href="index.html"><i class="bi bi-house-fill me-1"></i> Inicio</a>
                            </li>
                            <li class="nav-item ms-4">
                                <a class="nav-link" href="citasaprovadas.html"><i class="bi bi-people-fill me-1"></i> citas aprovadas</a>
                            </li>
                            <li class="nav-item ms-4">
                            <a class="nav-link" href="citaspendientes.html"><i class="bi bi-person-vcard-fill me-1"></i> citas pendientes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

                `
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
                        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.html">
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
        <div class="footer-container">
            <div class="footer-column">
                <h3>Quiropractica</h3>
                <p class="fw-light">En QUIROPRÁCTICA ESPECIFICA además de cuidar tu columna vertebral y tu postura, nos enfocamos específicamente en el 
                    cuidado y mantenimiento de tu sistema nervioso que determinan el buen funcionamiento de cada una de las 37.2 trillones 
                    de célula de tu cuerpo.</p>
            </div>
            <div class="footer-column">
                <p>
                    <h3>Redes Sociales</h3>
                    <a href="https://facebook.com" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank"><i class="bi bi-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank"><i class="bi bi-instagram"></i></a>
                </p>
            </div>
            <div class="footer-column">
                <h3>Company</h3>
                <p>Enfermades<br><br>
                Terapias<br><br>
                Procesos</p>
            </div>
            <div class="footer-column">
                <h3>Contact us</h3>
                <p>Visítanos en 87 Avenida Norte y Tercera calle Poniente San Salvador.<br><br>
                +503 2529 8289<br><br>
                info@quiropracticaespecificasv.com
                </p>
            </div>
        </div>
    </footer>
    <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2024, All Right Reserved <a
                                    href="https://codepen.io/anupkumar92/">Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `);
}