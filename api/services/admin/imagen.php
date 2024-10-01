<?php
// Se incluye la clase del modelo.
require_once('../../models/data/imagen_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $imagen = new ImagenData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus1' => null, 'fileStatus2' => null, 'fileStatus3' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $imagen->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'createRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$imagen->setNombre($_POST['nombreImagen']) or
                    !$imagen->setImagen1($_FILES['imagen1']) or
                    !$imagen->setImagen2($_FILES['imagen2']) or
                    !$imagen->setImagen3($_FILES['imagen3']) 
                ) {
                    $result['error'] = $imagen->getDataError();
                } elseif ($imagen->createRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Galería creada correctamente';
                    // Se asigna el estado del archivo después de insertar.
                    $result['fileStatus2'] = Validator::saveFile($_FILES['imagen1'], $imagen::RUTA_IMAGEN) or
                    $result['fileStatus3'] = Validator::saveFile($_FILES['imagen2'], $imagen::RUTA_IMAGEN) or
                    $result['fileStatus1'] = Validator::saveFile($_FILES['imagen3'], $imagen::RUTA_IMAGEN);
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la imagen';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $imagen->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros';
                } else {
                    $result['error'] = 'No existen imágenes registradas';
                }
                break;
            case 'readOne':
                if (!$imagen->setId($_POST['idFoto'])) {
                    $result['error'] = $imagen->getDataError();
                } elseif ($result['dataset'] = $imagen->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Foto inexistente';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$imagen->setId($_POST['idFoto']) or
                    !$imagen->setFilename() or
                    !$imagen->setNombre($_POST['nombreFoto']) or
                    !$imagen->setImagen1($_FILES['inputFoto'], $imagen->getFilename())
                ) {
                    $result['error'] = $imagen->getDataError();
                } elseif ($imagen->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Imagen modificada correctamente';
                    // Se asigna el estado del archivo después de actualizar.
                    $result['fileStatus'] = Validator::changeFile($_FILES['inputFoto'], $imagen::RUTA_IMAGEN, $imagen->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar la imagen';
                }
                break;
            case 'deleteRow':
                if (
                    !$imagen->setId($_POST['idFoto']) or
                    !$imagen->setFilename()
                ) {
                    $result['error'] = $imagen->getDataError();
                } elseif ($imagen->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Imagen eliminada correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($imagen::RUTA_IMAGEN, $imagen->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la imagen  ///  La imagen es usada en servicios';
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
