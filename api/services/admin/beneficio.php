<?php
// Se incluye la clase del modelo.
require_once('../../models/data/beneficio_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $beneficio = new BeneficioData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null);
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $beneficio->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$beneficio->setTitulo($_POST['tituloBeneficio']) or
                    !$beneficio->setContenido($_POST['contenidoBeneficio']) or
                    !$beneficio->setServicio($_POST['servicioBeneficio'])
                ) {
                    $result['error'] = $beneficio->getDataError();
                } elseif ($beneficio->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Beneficio creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear el beneficio';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $beneficio->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen beneficios registrados';
                }
                break;
            case 'readOne':
                if (!$beneficio->setId($_POST['idBeneficio'])) {
                    $result['error'] = $beneficio->getDataError();
                } elseif ($result['dataset'] = $beneficio->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Beneficios inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$beneficio->setId($_POST['idBeneficio']) or
                    !$beneficio->setTitulo($_POST['tituloBeneficio']) or
                    !$beneficio->setContenido($_POST['contenidoBeneficio']) or
                    !$beneficio->setServicio($_POST['servicioBeneficio'])
                ) {
                    $result['error'] = $beneficio->getDataError();
                } elseif ($beneficio->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'beneficio modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el beneficio';
                }
                break;
            case 'deleteRow':
                if (
                    !$beneficio->setId($_POST['idBeneficio'])
                ) {
                    $result['error'] = $beneficio->getDataError();
                } elseif ($beneficio->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Beneficio eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el beneficio';
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
