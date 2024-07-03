<?php
// Se incluye la clase del modelo.
require_once('../../models/data/pregunta_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.

if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $pregunta = new PreguntaData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'session' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'username' => null);
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $pregunta->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$pregunta->setImagen($_FILES['imagenPregunta']) or
                    !$pregunta->setPregunta($_POST['nombrePregunta']) or
                    !$pregunta->setContenido($_POST['contenidoPregunta']) or
                    !$pregunta->setEmpleado($_POST['empleadoPregunta'])
                ) {
                    $result['error'] = $pregunta->getDataError();
                } elseif ($pregunta->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pregunta creada correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus'] = Validator::saveFile($_FILES['imagenPregunta'], $pregunta::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la pregunta';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $pregunta->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen preguntas registradas';
                }
                break;
            case 'readOne':
                if (!$pregunta->setId($_POST['idPregunta'])) {
                    $result['error'] = $pregunta->getDataError();
                } elseif ($result['dataset'] = $pregunta->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'preguntas inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$pregunta->setId($_POST['idPregunta']) or
                    !$pregunta->setFilename() or
                    !$pregunta->setPregunta($_POST['nombrePregunta']) or
                    !$pregunta->setContenido($_POST['contenidoPregunta']) or
                    !$pregunta->setEmpleado($_POST['empleadoPregunta']) or
                    !$pregunta->setImagen($_FILES['imagenPregunta'], $pregunta->getFilename())
                ) {
                    $result['error'] = $pregunta->getDataError();
                } elseif ($pregunta->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'pregunta modificada correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['imagenPregunta'], $pregunta::RUTA_IMAGEN, $pregunta->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la pregunta';
                }
                break;
            case 'deleteRow':
                if (
                    !$pregunta->setId($_POST['idPregunta']) or
                    !$pregunta->setFilename()
                ) {
                    $result['error'] = $pregunta->getDataError();
                } elseif ($pregunta->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Pregunta eliminada correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($pregunta::RUTA_IMAGEN, $pregunta->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la pregunta';
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
