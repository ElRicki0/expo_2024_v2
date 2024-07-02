<?php
// Se incluye la clase del modelo.
require_once('../../models/data/administrador_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $administrador = new AdministradorData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null);
    // Se verifica si existe una sesión iniciada como empleado, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un empleado ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $administrador->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setCorreo($_POST['correo_admin2']) or
                    !$administrador->setContrasenia($_POST['contra_admin2']) or     
                    !$administrador->setNombre($_POST['nombre_admin2'])       
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Administrador agregado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear al Administrador';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $administrador->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen administradores registrados';
                }
                break;
            case 'readOne':
                if (!$administrador->setId($_POST['id_empleado'])) {
                    $result['error'] = 'Administrador incorrecto';
                } elseif ($result['dataset'] = $administrador->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Administrador inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$administrador->setId($_POST['idAdministrador']) or
                    !$administrador->setCorreo($_POST['correo_admin']) or
                    !$administrador->setContrasenia($_POST['contra_admin']) or
                    !$administrador->setNombre($_POST['nombre_admin'])
                ) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Administrador modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el administrador';
                }
                break;
            case 'deleteRow':
                if (!$administrador->setId($_POST['idAdministrador'])) {
                    $result['error'] = $administrador->getDataError();
                } elseif ($administrador->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Adminitrador eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar al administrador';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
        else {
            // Se compara la acción a realizar cuando el administrador no ha iniciado sesión.
            switch ($_GET['action']) {
                case 'readUsers':
                    if ($administrador->readAll()) {
                        $result['status'] = 1;
                        $result['message'] = 'Debe autenticarse para ingresar';
                    } else {
                        $result['error'] = 'Debe crear un administrador para comenzar';
                    }
                    break;
                case 'signUp':
                    $_POST = Validator::validateForm($_POST);
                    if (
                        !$administrador->setNombre($_POST['nombreAdministrador']) or
                        !$administrador->setApellido($_POST['apellidoAdministrador']) or
                        !$administrador->setCorreo($_POST['correoAdministrador']) or
                        !$administrador->setAlias($_POST['aliasAdministrador']) or
                        !$administrador->setClave($_POST['claveAdministrador'])
                    ) {
                        $result['error'] = $administrador->getDataError();
                    } elseif ($_POST['claveAdministrador'] != $_POST['confirmarClave']) {
                        $result['error'] = 'Contraseñas diferentes';
                    } elseif ($administrador->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Administrador registrado correctamente';
                    } else {
                        $result['error'] = 'Ocurrió un problema al registrar el administrador';
                    }
                    break;
                case 'logIn':
                    $_POST = Validator::validateForm($_POST);
                    if ($administrador->checkUser($_POST['alias'], $_POST['clave'])) {
                        $result['status'] = 1;
                        $result['message'] = 'Autenticación correcta';
                    } else {
                        $result['error'] = 'Credenciales incorrectas';
                    }
                    break;
                default:
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
        print(json_encode('Acceso denegado'));
    }
} else {
    print(json_encode('Recurso no disponible'));
}