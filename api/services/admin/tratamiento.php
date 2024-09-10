<?php
// Se incluye la clase del modelo.
require_once('../../models/data/tratamiento_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $tratamiento = new TratamientoData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {

        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $tratamiento->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$tratamiento->setNombre($_POST['nombreTratamiento']) or
                    !$tratamiento->setNota($_POST['notaTratamiento']) or
                    !$tratamiento->setCita($_POST['citaTratamiento'])
                ) {
                    $result['error'] = $tratamiento->getDataError();
                } elseif ($tratamiento->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tratamiento creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el tratamiento';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $tratamiento->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen tratamientos registrados';
                }
                break;
            case 'readOne':
                if (!$tratamiento->setId($_POST['idTratamiento'])) {
                    $result['error'] = $tratamiento->getDataError();
                } elseif ($result['dataset'] = $tratamiento->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Tratamiento inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$tratamiento->setId($_POST['idTratamiento']) or
                    !$tratamiento->setNombre($_POST['nombreTratamiento']) or
                    !$tratamiento->setNota($_POST['notaTratamiento']) or
                    !$tratamiento->setCita($_POST['citaTratamiento'])
                ) {
                    $result['error'] = $tratamiento->getDataError();
                } elseif ($tratamiento->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tratamiento modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el tratamiento';
                }
                break;
            case 'deleteRow':
                if (
                    !$tratamiento->setId($_POST['idTratamiento'])
                ) {
                    $result['error'] = $tratamiento->getDataError();
                } elseif ($tratamiento->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Tratamiento eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el tratamiento';
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
