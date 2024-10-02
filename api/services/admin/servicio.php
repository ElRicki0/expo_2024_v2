<?php
// Se incluye la clase del modelo.
require_once('../../models/data/servicio_data.php');
// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $servicio = new ServicioData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un empleado ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $servicio->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$servicio->setServicio($_POST['tipoServicio']) or
                    !$servicio->setDescripcion($_POST['descripcionServicio']) or
                    !$servicio->setImagen($_POST['imagenServicio'])

                ) {
                    $result['error'] = $servicio->getDataError();
                } elseif ($servicio->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Servicio creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el Servicio /// el nombre ya esta en uso';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $servicio->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen servicio registrados';
                }
                break;
            case 'readOne':
                if (!$servicio->setId($_POST['idServicio'])) {
                    $result['error'] = $servicio->getDataError();
                } elseif ($result['dataset'] = $servicio->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Servicio inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$servicio->setId($_POST['idServicio']) or
                    !$servicio->setServicio($_POST['tipoServicio']) or
                    !$servicio->setDescripcion($_POST['descripcionServicio']) or
                    !$servicio->setImagen($_POST['imagenServicio'])
                ) {
                    $result['error'] = $servicio->getDataError();
                } elseif ($servicio->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Servicio modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Servicio';
                }
                break;
            case 'deleteRow':
                if (!$servicio->setId($_POST['idServicio'])) {
                    $result['error'] = $servicio->getDataError();
                } elseif ($servicio->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Servicio eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar al Servicio';
                }
                break;

            case 'readCantidadCitas':
                if ($result['dataset'] = $servicio->readCantidadCitas()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No ha datos diponibles';
                }
                break;

            case 'graficoPastelServicio':
                if ($result['dataset'] = $servicio->graficoPastelServicio()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No hay datos disponibles';
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
