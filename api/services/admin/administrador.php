<?php
// Se incluye la clase del modelo.
require_once('../../models/data/administrador_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente para manejar los datos del administrador.
    $administrador = new AdministradorData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array(
        'status' => 0,
        'session' => 0,
        'message' => null,
        'dataset' => null,
        'error' => null,
        'exception' => null,
        'username' => null
    );

    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1; // Indica que hay una sesión activa.

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                // Validación del formulario de búsqueda.
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $administrador->searchRows()) {
                    // Si se encuentran resultados, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    // Si no hay resultados, se registra un error.
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                // Validación y creación de un nuevo administrador.
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correo_admin']) or
                    !$administrador->setContraseña($_POST['contra_admin']) or
                    !$administrador->setNombre($_POST['nombre_admin'])
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->createRow()) {
                    // Si se crea correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador agregado correctamente';
                } else {
                    // Si hay un problema al crear, se registra un error.
                    $result['error'] = 'el nombre del administrador ya existe ';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $administrador->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen beneficios registrados';
                }
                break;
            case 'readAllOne':
                // Lectura de todos los administradores registrados.
                if ($result['dataset'] = $administrador->readAllOne()) {
                    // Si hay registros, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Registros encontrados';
                } else {
                    // Si no hay registros, se registra un error.
                    $result['error'] = 'No existen administradores registrados';
                }
                break;
            case 'logOut':
                if (session_destroy()) {
                    $result['status'] = 1;
                    $result['message'] = 'Sesión eliminada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cerrar la sesión';
                }
                break;
            case 'getUser':
                if (isset($_SESSION['correo_admin'])) {
                    $result['status'] = 1;
                    $result['username'] = $_SESSION['correo_admin'];
                } else {
                    $result['error'] = 'Administrador no encontrado';
                }
                break;
            case 'readOne':
                // Lectura de un administrador específico por su ID.
                if (!$administrador->setId($_POST['id_admin'])) {
                    // Si el ID es incorrecto, se registra un error.
                    $result['error'] = 'Administrador incorrecto';
                } elseif ($result['dataset'] = $administrador->readOne()) {
                    // Si se encuentra el administrador, se actualiza el estado.
                    $result['status'] = 1;
                } else {
                    // Si no se encuentra el administrador, se registra un error.
                    $result['error'] = 'Administrador inexistente';
                }
                break;
            case 'updateRow':
                // Actualización de datos de un administrador.
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correo_admin']) or
                    !$administrador->setNombre($_POST['nombre_admin'])
                ) {
                    // Si los datos no son válidos, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->updateRow()) {
                    // Si se actualiza correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador modificado correctamente';
                } else {
                    // Si hay un problema al actualizar, se registra un error.
                    $result['error'] = 'Ocurrió un problema al modificar el administrador';
                }
                break;
            case 'deleteRow':
                // Eliminación de un administrador por su ID.
                if (!$administrador->setId($_POST['id_admin'])) {
                    // Si el ID es incorrecto, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->deleteRow()) {
                    // Si se elimina correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador eliminado correctamente';
                } else {
                    // Si hay un problema al eliminar, se registra un error.
                    $result['error'] = 'Ocurrió un problema al eliminar al administrador';
                }
                break;
            case 'readProfile':
                if ($result['dataset'] = $administrador->readProfile()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Ocurrió un problema al leer el perfil';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setNombre($_POST['nombre_admin_perfil']) or
                    !$administrador->setCorreo($_POST['correo_admin_perfil'])
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                    $_SESSION['nombre_admin'] = $_POST['nombre_admin_perfil'];
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el perfil';
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$administrador->checkPassword($_POST['contraseña_actual'])) {
                    $result['error'] = 'Contraseña actual incorrecta';
                } elseif (!$administrador->setContraseña($_POST['contraseña_nueva'])) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña actualizada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cambiar la contraseña';
                }
                break;
            default:
                // Acción no disponible dentro de la sesión.
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'readUsers':
                // Lectura de todos los administradores (puede ser una acción pública).
                if ($administrador->readAll()) {
                    // Si hay administradores registrados, se devuelve un mensaje de autenticación requerida.
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    // Si no hay administradores registrados, se muestra un mensaje de creación requerida.
                    $result['error'] = 'Debe crear un administrador para comenzar';
                }
                break;
            case 'readEmployee':
                // Lectura de todos los administradores (puede ser una acción pública).
                if ($administrador->readAllEmployee()) {
                    // Si hay administradores registrados, se devuelve un mensaje de autenticación requerida.
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    // Si no hay administradores registrados, se muestra un mensaje de creación requerida.
                    $result['error'] = 'Debe crear un empleado para comenzar';
                }
                break;
            case 'signUp':
                // Registro de un nuevo administrador (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correo_admin2']) ||
                    !$administrador->setContraseña($_POST['contra_admin2']) ||
                    !$administrador->setNombre($_POST['nombre_admin2'])
                ) {
                    // Si los datos no son válidos, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($_POST['contra_admin2'] != $_POST['confirmar_admin2']) {
                    // Si las contraseñas no coinciden, se registra un error.
                    $result['error'] = 'Contraseñas diferentes';
                } elseif ($administrador->createNewRow()) {
                    // Si se crea correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador registrado correctamente';
                } else {
                    // Si hay un problema al registrar, se registra un error.
                    $result['error'] = 'Ocurrió un problema al registrar el administrador';
                }
                break;
            case 'logIn':
                // Inicio de sesión de un administrador (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if ($administrador->checkUser($_POST['correo_admin'], $_POST['contra_admin'])) {
                    // Si las credenciales son correctas, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    // Si las credenciales son incorrectas, se registra un error.
                    $result['error'] = 'Credenciales incorrectas';
                }
                break;
            default:
                // Acción no disponible fuera de la sesión.
                $result['error'] = 'Acción no disponible fuera de la sesión';
        }
    }

    // Se obtiene la excepción del servidor de base de datos por si ocurrió un problema.
    $result['exception'] = Database::getException();

    // Se indica el tipo de contenido a mostrar y su respectivo conjunto de caracteres.
    header('Content-type: application/json; charset=utf-8');

    // Se imprime el resultado en formato JSON y se retorna al controlador.
    print(json_encode($result));
} else {
    // Si no hay acción definida, se imprime un mensaje indicando que el recurso no está disponible.
    print(json_encode('Recurso no disponible'));
}
