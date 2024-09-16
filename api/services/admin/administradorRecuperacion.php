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
            case 'changePassword':
                $_POST = Validator::validateForm($_POST);
                if (!$administrador->checkPassword($_POST['contraseña_actual'])) {
                    $result['error'] = 'Contraseña actual incorrecta';
                } elseif (!$administrador->setContrasenia($_POST['contraseña_nueva'])) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->changePassword()) {
                    $result['status'] = 1;
                    $result['message'] = 'Contraseña actualizada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al cambiar la contraseña';
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
            default:
                // Acción no disponible dentro de la sesión.
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
        switch ($_GET['action']) {
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
            case 'logIn':
                // Inicio de sesión de un administrador (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if ($administrador->checkUserRecuperacion($_POST['correoUsuario'])) {
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
