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
                    !$administrador->setCorreo($_POST['correo_admin2']) ||
                    !$administrador->setContrasenia($_POST['contra_admin2']) ||     
                    !$administrador->setNombre($_POST['nombre_admin2'])       
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->createRow()) {
                    // Si se crea correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Administrador agregado correctamente';
                } else {
                    // Si hay un problema al crear, se registra un error.
                    $result['error'] = 'Ocurrió un problema al crear al Administrador';
                }
                break;
            case 'readAll':
                // Lectura de todos los administradores registrados.
                if ($result['dataset'] = $administrador->readAll()) {
                    // Si hay registros, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    // Si no hay registros, se registra un error.
                    $result['error'] = 'No existen administradores registrados';
                }
                break;
            case 'readOne':
                // Lectura de un administrador específico por su ID.
                if (!$administrador->setId($_POST['id_empleado'])) {
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
                    !$administrador->setId($_POST['idAdministrador']) ||
                    !$administrador->setCorreo($_POST['correo_admin']) ||
                    !$administrador->setContrasenia($_POST['contra_admin']) ||
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
                if (!$administrador->setId($_POST['idAdministrador'])) {
                    // Si el ID es incorrecto, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->deleteRow()) {
                    // Si se elimina correctamente, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Adminitrador eliminado correctamente';
                } else {
                    // Si hay un problema al eliminar, se registra un error.
                    $result['error'] = 'Ocurrió un problema al eliminar al administrador';
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
            case 'signUp':
                // Registro de un nuevo administrador (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correo_admin2']) ||
                    !$administrador->setContrasenia($_POST['contra_admin2']) ||     
                    !$administrador->setNombre($_POST['nombre_admin2'])
                ) {
                    // Si los datos no son válidos, se registra un error.
                    $result['error'] = $administrador->getDataError();
                } elseif ($_POST['contra_admin2'] != $_POST['confirmar_admin2']) {
                    // Si las contraseñas no coinciden, se registra un error.
                    $result['error'] = 'Contraseñas diferentes';
                } elseif ($administrador->createRow()) {
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
                if ($administrador->checkUser($_POST['correoAdmin'], $_POST['contraAdmin'])) {
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
