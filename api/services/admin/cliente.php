<?php
// Se incluye la clase del modelo.
require_once('../../models/data/cliente_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cliente = new ClienteData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createAdminRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cliente->setNombre($_POST['nombreCliente']) or
                    !$cliente->setApellido($_POST['apellidoCliente']) or
                    !$cliente->setCorreo($_POST['correoCliente']) or
                    !$cliente->setDui($_POST['duiCliente']) or
                    !$cliente->setTelefono($_POST['telefonoCliente']) or
                    !$cliente->setNacimiento($_POST['fechaCliente']) or
                    !$cliente->setImagen($_FILES['imagenCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->createAdminRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente registrado correctamente';
                    $fileStatuses['imagenCliente'] = Validator::saveFile($_FILES['imagenCliente'], $cliente::RUTA_IMAGEN, $_FILES['imagenCliente']['name']);
                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenCliente']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }
                } else {
                    $result['error'] = 'Ocurrió un problema al registrar el cliente';
                }
                break;
            case 'deleteRow':
                if (
                    !$cliente->setId($_POST['idCliente']) or
                    !$cliente->setFilename()
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente eliminado correctamente';
                    // Se asigna el estado del archivo después de eliminar.
                    $result['fileStatus'] = Validator::deleteFile($cliente::RUTA_IMAGEN, $cliente->getFilename());
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar el cliente';
                }
                break;
            case 'searchRows':
                if (!Validator::validateSearch($_POST['search'])) {
                    $result['error'] = Validator::getSearchError();
                } elseif ($result['dataset'] = $cliente->searchRows()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' coincidencias';
                } else {
                    $result['error'] = 'No hay coincidencias';
                }
                break;
            case 'updateRow':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cliente->setId($_POST['idCliente']) or
                    !$cliente->setFilename() or
                    !$cliente->setNombre($_POST['nombreCliente']) or
                    !$cliente->setApellido($_POST['apellidoCliente']) or
                    !$cliente->setCorreo($_POST['correoCliente']) or
                    !$cliente->setDui($_POST['duiCliente']) or
                    !$cliente->setTelefono($_POST['telefonoCliente']) or
                    !$cliente->setNacimiento($_POST['fechaCliente']) or
                    !$cliente->setImagen($_FILES['imagenCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->updateRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cliente modificado correctamente';
                    
                    $fileStatuses['imagenCliente'] = Validator::saveFile($_FILES['imagenCliente'], $cliente::RUTA_IMAGEN, $_FILES['imagenCliente']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenCliente']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el cliente';
                }
                break;
            case 'updateRowEstado':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cliente->setId($_POST['idCliente'])
                ) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($cliente->updateRowEstado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el estado';
                }
                break;
            case 'readAll':
                if ($result['dataset'] = $cliente->readAll()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registros(s)';
                } else {
                    $result['error'] = 'No existen clientes registrados';
                }
                break;
            case 'readOne':
                if (!$cliente->setId($_POST['idCliente'])) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($result['dataset'] = $cliente->readOne()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'Cliente inexistente';
                }
                break;
            case 'readClienteCitas':
                if (!$cliente->setId($_POST['idCliente'])) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($result['dataset'] = $cliente->readClienteCitas()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No existen registros por el momento';
                }
                break;
            case 'reporteCitasMesActual':
                if (!$cliente->setId($_POST['idCliente'])) {
                    $result['error'] = $cliente->getDataError();
                } elseif ($result['dataset'] = $cliente->reporteCitasMesActual()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No existen registros por el momento';
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
