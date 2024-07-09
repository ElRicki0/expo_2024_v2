Imformación del equipo

Integrantes:

-Juan Pablo Montes Espinoza
-Ricardo Nicolas Melara Rauda
-Jhonny Alejandro Amaya Perez
-Manuel Enrique Contreras Rivera
-Alisson Ivania Zepeda Caceres

Estandares de programacion de Java Script:

-Se utiliza snakecase, para la asignacion de variables y constantes
como en el siguiente ejemplo:

    if (DATA.status) {
        // Se inicializan los campos del formulario con los datos del usuario que ha iniciado sesión.
        const ROW = DATA.dataset;
        NOMBRE_ADMINISTRADOR.textContent = ROW.nombre_admin;
        CORREO_ADMINISTRADOR.textContent = ROW.correo_admin;
    } 

-Se utiliza camelcase, para la asignacion de ID en formularios y modals
como en el siguiente ejemplo:

// Constante para establecer la modal de cambiar contraseña.
const PASSWORD_MODAL = new bootstrap.Modal('#passwordModal');
// Constante para establecer el formulario de cambiar contraseña.
const PASSWORD_FORM = document.getElementById('passwordForm');
// Constante para establecer la modal de cambiar contraseña.
const PERFIL_MODAL = new bootstrap.Modal('#PerfilModal');
// Constante para establecer el formulario de cambiar contraseña.
const PROFILE_FORM = document.getElementById('editForm');


Estandares de programacion en PHP:

-Se utiliza snakecase, para la asignacion de parametros 
como en el siguiente ejemplo:

                if (
                    !$administrador->setCorreo($_POST['correo_admin']) or
                    !$administrador->setContraseña($_POST['contra_admin']) or
                    !$administrador->setNombre($_POST['nombre_admin'])
                )

-Se utiliza camelcase, para la asignacion de variables 
como en el ejemplo:

if (isset($_SESSION['idAdministrador'])) 
        $result['session'] = 1;


estandares de programacion:

snake_case
camelCase
PascalCase
UPPERCASE
kebab-case

