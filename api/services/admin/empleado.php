<?php
// Se incluye la clase del modelo.
require_once('../../models/data/empleado_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $empleado = new EmpleadoData;
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
                } elseif ($result['dataset'] = $empleado->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setNombre($_POST['nombre_empleado']) or
                    !$empleado->setApelldo($_POST['apellido_empleado']) or
                    !$empleado->setCorreo($_POST['correo_empleado']) or
                    !$empleado->setDui($_POST['dui_empleado']) or
                    !$empleado->setFecha($_POST['fecha_empleado'])                   
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear al Empleado';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $empleado->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen Empleados registrados';
                }
                break;
            case 'readOne':
                if (!$empleado->setId($_POST['id_empleado'])) {
                    $result['error'] = 'Empleado incorrecto';
                } elseif ($result['dataset'] = $empleado->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Empleado inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setId($_POST['id_empleado']) or
                    !$empleado->setNombre($_POST['nombre_empleado']) or
                    !$empleado->setApelldo($_POST['apellido_empleado']) or
                    !$empleado->setCorreo($_POST['correo_empleado']) or
                    !$empleado->setDui($_POST['dui_empleado']) or
                    !$empleado->setFecha($_POST['fecha_empleado'])  
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Empleado';
                }
                break;
            case 'deleteRow':
                if (!$empleado->setId($_POST['id_empleado'])) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar al Empleado';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
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