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
    } else {
        console.log('de vuelta');
        // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión.
        if (location.pathname.endsWith('index.html')) {
            
        } else {
            sweetAlert(3, DATA.error, false, 'recuperacionCorreo.html');
        }
    }
}