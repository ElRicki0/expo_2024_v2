/*
* Controlador de uso general en las páginas web del sitio privado.
* Sirve para manejar la plantilla del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/admin/administrador.php';
// Se establece el título de la página web.
document.querySelector('title').textContent = 'Quiropráctica Especifica';
// Constante para establecer el elemento del contenido principal.
const MAIN = document.querySelector('main');
/* Función asíncrona para cargar el encabezado y pie del documento.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
// Codigo para tener el header, para luego mandarlo a llamar

const loadTemplate = async () => {
    // Petición para obtener en nombre del usuario que ha iniciado sesión.
    const DATA = await fetchData(USER_API, 'getUser');
    // Se verifica si el usuario está autenticado, de lo contrario se envía a iniciar sesión.
    if (DATA.session) {
        // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
        if (DATA.status) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
        <header>
        <nav class="navbar navbar-dark border-bottom border-secondary ">
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
                            <a class="nav-link" href="empleados.html"><i class="bi bi-person-vcard-fill me-1"></i> Empleados</a>
                            </li>
                            <li class="nav-item ms-4">
                            <a class="nav-link" href="administradores.html"><i class="bi bi-shield-lock-fill me-1"></i> Admin</a>
                            </li>
                            <li class="nav-item ms-4">
                                <a class="nav-link" href="imagenes.html"><i class="bi bi-images"></i> Galería</a>
                            </li>
                            <li class="nav-item ms-4">
                                <a class="nav-link" href="servicios.html"><i class="bi bi-file-medical-fill me-1"></i> Servicios</a>
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
                                <a class="nav-link" href="tratamientos.html"><i class="bi bi-clipboard2-pulse-fill me-1"></i> Tratamientos</a>
                            </li>
                            <li class="nav-item ms-4">
                                <a class="nav-link" href="comentarios.html"><i class="bi bi-chat-left-text-fill me-1"></i> Comentarios</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>`);
            // Se agrega el pie de la página web después del contenido principal.
            MAIN.insertAdjacentHTML('afterend', `
    <footer class="footer-section mt-5">
        <div class="container">
            <div class="footer-cta pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-map-marker-alt"></i>
                            <div class="cta-text">
                                <h4>Ubicación</h4>
                                <span>calle ejemplo, avenida de ejemplo #7846</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="fas fa-phone"></i>
                            <div class="cta-text">
                                <h4>Teléfono</h4>
                                <span>+503 7589-9865</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-4 mb-30">
                        <div class="single-cta">
                            <i class="far fa-envelope-open"></i>
                            <div class="cta-text">
                                <h4>Correo electrónico</h4>
                                <span>mail@info.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-content pt-5 pb-5">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mb-50">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="index.html"><img src="../../resources/img/icono.png" class="img-fluid"
                                        alt="logo"></a>
                            </div>
                            <div class="footer-text">
                                <p>Lorem ipsum dolor sit amet, consec tetur adipisicing elit, sed do eiusmod tempor
                                    incididuntut consec tetur adipisicing
                                    elit,Lorem ipsum dolor sit amet.</p>
                            </div>
                            <div class="footer-social-icon">
                                <span>Redes sociales</span>
                                <a href="#"><i class="bi bi-facebook"></i></a>
                                <a href="#"><i class="bi bi-twitter"></i></a>
                                <a href="#"><i class="bi bi-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-30">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Atajos</h3>
                            </div>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">about</a></li>
                                <li><a href="#">services</a></li>
                                <li><a href="#">portfolio</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Our Services</a></li>
                                <li><a href="#">Expert Team</a></li>
                                <li><a href="#">Contact us</a></li>
                                <li><a href="#">Latest News</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                        <div class="footer-widget">
                            <div class="footer-widget-heading">
                                <h3>Preguntas?</h3>
                            </div>
                            <div class="footer-text mb-25">
                                <p>Puedes consultar los manuales para guiarte sobre el sistema</p>
                            </div>
                            <div class="container">
                                <a href="../../resources/pdf/Manual de usuario v3.pdf" download="ManualUsuario.pdf">
                                    <button type="button" class="btn btn-outline-secondary">Manual de usuario</button>
                                </a>
                                <a href="../../resources/pdf/Manuel Técnico web .pdf" download="Manual Técnico.pdf">
                                    <button type="button" class="btn btn-outline-secondary">Manual técnico</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 text-center text-lg-left">
                        <div class="copyright-text">
                            <p>Copyright &copy; 2018, All Right Reserved <a
                                    href="https://codepen.io/anupkumar92/">Anup</a></p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 d-none d-lg-block text-right">
                        <div class="footer-menu">
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Terms</a></li>
                                <li><a href="#">Privacy</a></li>
                                <li><a href="#">Policy</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
`);

        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    } else {
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname.endsWith('index.html')) {
            // Se agrega el encabezado de la página web antes del contenido principal.
            MAIN.insertAdjacentHTML('beforebegin', `
                <header>
                    <nav class="navbar bg-body-tertiary">
                        <div class="container">
                            <a class="navbar-brand" href="index.html">
                                <img src="../../resources/img/logo.png" alt="inventory" width="50">
                            </a>
                        </div>
                    </nav>
                </header>
            `);
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
        } else {
            sweetAlert(3, DATA.error, false, 'index.html');
        }
    }
}

// esto solo es para el menu lateral
{/* <li class="nav-item ms-4">
    <a class="nav-link" href="#"><i class="bi bi-fast-forward-btn-fill me-1"></i> Testimonios</a>
</li> 


                            <li class="nav-item ms-4">
                                <a class="nav-link" href="../../views/admin/imagenes.html"><i class="bi bi-images me-1"></i> Galeria</a>
                            </li>*/}