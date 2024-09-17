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
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
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
                    !$administrador->setCorreo($_POST['correoAdmin']) or
                    !$administrador->setContrasenia($_POST['contraAdmin']) or
                    !$administrador->setNombre($_POST['nombreAdmin']) or
                    !$administrador->setEmpleado($_POST['empleadoAdmin'])
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->createRow()) {
                    // Si se crea correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador agregado correctamente';
                } else {
                    // Si hay un problema al crear, se registra un error.
                    $result['error'] = 'Este administrador ya existe';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $administrador->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen administradores registrados';
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
                if (!$administrador->setId($_POST['idAdmin'])) {
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
            case 'readEmployed':
                // Lectura de un empleado específico por su ID.
                if (!$administrador->setId($_POST['idAdmin'])) {
                    // Si el ID es incorrecto, se registra un error.
                    $result['error'] = 'Empleado incorrecto';
                } elseif ($result['dataset'] = $administrador->readEmployed()) {
                    // Si se encuentra el empleado, se actualiza el estado.
                    $result['status'] = 1;
                } else {
                    // Si no se encuentra el empleado, se registra un error.
                    $result['error'] = 'Empleado inexistente';
                }
                break;
            case 'updateRow':
                // Actualización de datos de un administrador.
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correoAdmin']) or
                    !$administrador->setNombre($_POST['nombreAdmin'])
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
                if (!$administrador->setId($_POST['idAdmin'])) {
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
            case 'readProfileRecuperacion':
                if ($result['dataset'] = $administrador->readProfileRecuperacion()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Ocurrió un problema al leer el perfil';
                }
                break;
            case 'editProfile':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setNombre($_POST['nombreAdminPerfil']) or
                    !$administrador->setCorreo($_POST['correoAdminPerfil'])
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->editProfile()) {
                    $result['status'] = 1;
                    $result['message'] = 'Perfil modificado correctamente';
                    $_SESSION['nombre_admin'] = $_POST['nombreAdminPerfil'];
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el perfil';
                }
                break;
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$administrador->checkPassword($_POST['contraseñaActual'])) {
                    $result['error'] = 'Contraseña actual incorrecta';
                } elseif (!$administrador->setContrasenia($_POST['contraseñaNueva'])) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña actualizada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cambiar la contraseña';
                }
                break;
            case 'changeNewPassword':
                // Actualización de datos de un administrador.
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setcontrasenia($_POST['claveAdmin'])
                ) {
                    // Si los datos no son válidos, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->changePassword()) {
                    // Si se actualiza correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Clave actualizada correctamente';
                } else {
                    // Si hay un problema al actualizar, se registra un error.
                    $result['error'] = 'Ocurrió un problema al modificar el administrador';
                }
                break;
            case 'checkPassword':
                $_POST = Validator::validateForm($_POST);
                if (!$administrador->checkPassword($_POST['contraseñaAdmin'])) {
                    $result['error'] = 'Contraseña incorrecta';
                } else {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña correcta';
                }
                break;
            case 'DeleteProfile':
                $_POST = Validator::validateForm($_POST);
                if ($administrador->DeleteProfile()) {
                    $result['status'] = 1;
                    if (session_destroy()) {
                        $result['message'] = 'Perfil eliminado correctamente';
                    }
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el perfil';
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
                    !$administrador->setCorreo($_POST['correoAdmin2']) ||
                    !$administrador->setContrasenia($_POST['contraAdmin2']) ||
                    !$administrador->setNombre($_POST['nombreAdmin2'])
                ) {
                    // Si los datos no son válidos, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($_POST['contraAdmin2'] != $_POST['confirmarAdmin2']) {
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
                if ($administrador->checkUser($_POST['contraAdmin'], $_POST['contraAdmin'])) {
                    // Si las credenciales son correctas, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    // Si las credenciales son incorrectas, se registra un error.
                    $result['error'] = 'Credenciales incorrectas';
                }
                break;
                // método para recuperar contraseña mediante correo electrónico
            case 'readOneRecuperacion':
                // Lectura de un administrador específico por su ID.
                if (!$administrador->setCorreo($_POST['correoUsuario'])) {
                    // Si el correo es incorrecto, se registra un error.
                    $result['error'] = 'correo incorrecto';
                } elseif ($result['dataset'] = $administrador->readOneRecuperacion()) {
                    // Si se encuentra el administrador, se actualiza el estado.
                    $result['status'] = 1;
                } else {
                    // Si no se encuentra el administrador, se registra un error.
                    $result['error'] = 'Administrador inexistente';
                }
                break;

            case 'checkUserCodigo':
                // Inicio de sesión de un administrador (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if ($administrador->checkUserCodigo($_POST['codigoUsuario'])) {
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
