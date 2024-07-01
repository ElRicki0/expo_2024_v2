/*
* Controlador de uso general en las páginas web del sitio privado.
* Sirve para manejar la plantilla del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'services/admin/administrador.php';
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


/* Función asíncrona para cargar el encabezado y pie del documento.
* Parámetros: ninguno.
* Retorno: ninguno.
*/
// Codigo para tener el header, para luego mandarlo a llamar

const header = document.querySelector("header");

header.innerHTML = `<div class="fondo_oscuro">
<div class="row">
    <div class="col-sm-1 col-md-1 col-lg-1 text-center mt-4">
        <div class="btn-menu ">
            <label for="btn-menu"><img src="../../resources/img/menu.png" width="50px"
                    for="btn-menu"></label>
        </div>
        <input type="checkbox" id="btn-menu">
        <div class="containerzzz-menu">
            <div class="cont-menu">
                <nav>
                    <a href="../../../vistas/privada/inicio.html">Inicio</a>
                    <a href="../../../vistas/privada/cita.html">Citas</a>
                    <a href="../../../vistas/privada/notas_privada.html">Notas</a>
                    <a href="../../../vistas/privada/pacientes_privada.html">Pacientes</a>
                    <a href="../../../vistas/privada/pagina_principal.html">Sitio publico</a>
                    <a href="../../../vistas/privada/datos.html">Gráficas</a>
                    <a href="../../../vistas/privada/comentarios.html">Comentarios</a>
                </nav>
                <label for="btn-menu">✖️</label>
            </div>
        </div>
    </div>
    <div class="col-sm-9 col-md-9 col-lg-9 text-center mt-4">
        <img src="../../resources/img/icono.png" alt="">
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 text-center dropdown ">
        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <a class="boton" href="#">
                <img src="../../resources/img/admin/usuario.png" width="80px" alt="Descripción de la imagen">
            </a>
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../vistas/privada/perfil.html">perfil</a></li>
        </ul>
    </div>
</div>
</div>`

// Código para tener el footer, para luego mandarlo a llamar

const footer = document.querySelector("footer");

footer.innerHTML = `
<div class="bg-light text-center text-white">
<!-- Grid container -->
<div class="container p-4 pb-0" >
    <!-- Section: Social media -->
    <section class="mb-4">
        <!-- Facebook -->
        <a class="btn btn-primary btn-floating m-1 footer_color_boton"  href="#!"
            role="button"><img src="../../resources/img/footer/facebook_img.png"  width="30px" alt=""></a>

        <!-- Correo -->
        <a class="btn btn-primary btn-floating m-1 footer_color_boton"  href="#!"
            role="button"><img src="../../resources/img/footer/correo_img.png" width="30px" alt=""></a>

        <!-- Ubicación -->
        <a class="btn btn-primary btn-floating m-1 footer_color_boton"  href="#!"
            role="button"><img src="../../resources/img/footer/lugar_img.png" width="30px" alt=""></a>

        <!-- WhatsApp -->
        <a class="btn btn-primary btn-floating m-1 footer_color_boton"  href="#!"
            role="button"><img src="../../resources/img/footer/whatsapp_img.png" width="30px" alt=""></a>

    </section>
    <!-- Section: Social media -->
</div>
<!-- Grid container -->

<!-- Copyright -->
<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2024 Copyright:
    <a class="text-white" href="#">Quiropráctica Específica</a>
</div>
<!-- Copyright -->
</div>`
