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
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
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
                    !$empleado->setNombre($_POST['nombreEmpleado']) or
                    !$empleado->setApelldo($_POST['apellidoEmpleado']) or
                    !$empleado->setCorreo($_POST['correoEmpleado']) or
                    !$empleado->setDui($_POST['duiEmpleado']) or
                    !$empleado->setFecha($_POST['fechaEmpleado']) or
                    !$empleado->setEstado(isset($_POST['estadoEmpleado']) ? 1 : 0) or
                    !$empleado->setImagen($_FILES['imagenEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->createRow()) {
                    $result['status'] = 1;

                    $fileStatuses['imagenEmpleado'] = Validator::saveFile($_FILES['imagenEmpleado'], $empleado::RUTA_IMAGEN, $_FILES['imagenEmpleado']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenEmpleado']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }

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
            case 'readAllOne':
                if ($result['dataset'] = $empleado->readAllOne()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                } else {
                    $result['error'] = 'No existen Empleados registrados';
                }
                break;
            case 'readOne':
                if (!$empleado->setId($_POST['idEmpleado'])) {
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
                    !$empleado->setId($_POST['idEmpleado']) or
                    !$empleado->setNombre($_POST['nombreEmpleado']) or
                    !$empleado->setApelldo($_POST['apellidoEmpleado']) or
                    !$empleado->setCorreo($_POST['correoEmpleado']) or
                    !$empleado->setDui($_POST['duiEmpleado']) or
                    !$empleado->setFecha($_POST['fechaEmpleado']) or
                    !$empleado->setEstado(isset($_POST['estadoEmpleado']) ? 1 : 0) or
                    !$empleado->setImagen($_FILES['imagenEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->updateRow()) {
                    $result['status'] = 1;
                    // Se asigna el estado del archivo después de insertar.

                    $fileStatuses['imagenEmpleado'] = Validator::saveFile($_FILES['imagenEmpleado'], $empleado::RUTA_IMAGEN, $_FILES['imagenEmpleado']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenEmpleado']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }

                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Empleado';
                }
                break;
            case 'updateRowPerfil':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setId($_POST['idEmpleado']) or
                    !$empleado->setNombre($_POST['nombreEmpleado']) or
                    !$empleado->setApelldo($_POST['apellidoEmpleado']) or
                    !$empleado->setCorreo($_POST['correoEmpleado']) or
                    !$empleado->setDui($_POST['duiEmpleado']) or
                    !$empleado->setFecha($_POST['fechaEmpleado']) or
                    !$empleado->setEstado(isset($_POST['estadoEmpleado']) ? 1 : 0) or
                    !$empleado->setImagen($_FILES['imagenEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->updateRow()) {
                    $result['status'] = 1;
                    // Se asigna el estado del archivo después de insertar.

                    $fileStatuses['imagenEmpleado'] = Validator::saveFile($_FILES['imagenEmpleado'], $empleado::RUTA_IMAGEN, $_FILES['imagenEmpleado']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenEmpleado']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }
                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Empleado';
                }
                break;
            case 'updateRowImagen':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setId($_POST['empleadoID']) or
                    !$empleado->setImagen($_FILES['imagenEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->updateRowImagen()) {
                    $result['status'] = 1;
                    // Se asigna el estado del archivo después de insertar.

                    $fileStatuses['imagenEmpleado'] = Validator::saveFile($_FILES['imagenEmpleado'], $empleado::RUTA_IMAGEN, $_FILES['imagenEmpleado']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenEmpleado']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }

                    $result['message'] = 'Empleado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el Empleado';
                }
                break;
            case 'deleteRow':
                if (!$empleado->setId($_POST['idEmpleado'])) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Empleado eliminado correctamente';
                } else {
                    $result['error'] = "Ocurrió un problema al eliminar al Empleado /// Existen citas o administradores con este empleado";
                }
                break;
            case 'readEstadoEmpleado':
                if ($result['dataset'] = $empleado->readEstadoEmpleado()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No existen datos registrados';
                }
                break;
            case 'readCantidadServiciosEmpleado':
                if (!$empleado->setId($_POST['idEmpleado'])) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($result['dataset'] = $empleado->readCantidadServiciosEmpleado()) {
                    $result['status'] = 1;
                } else {
                    $result['error'] = 'No existen servicios asignados por el momento';
                }
                break;
            case 'updateRowEstado':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setId($_POST['idEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->updateRowEstado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Estado modificado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al modificar el estado';
                }
                break;
            case 'readEmployee':
                // Lectura de todos los empleado (puede ser una acción pública).
                if ($empleado->readAll()) {
                    // Si hay empleado registrados, se devuelve un mensaje de autenticación requerida.
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    // Si no hay empleado registrados, se muestra un mensaje de creación requerida.
                    $result['error'] = 'Debe crear un empleado para comenzar';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        switch ($_GET['action']) {
            case 'signUp':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$empleado->setNombre($_POST['nombreEmpleado']) or
                    !$empleado->setApelldo($_POST['apellidoEmpleado']) or
                    !$empleado->setCorreo($_POST['correoEmpleado']) or
                    !$empleado->setDui($_POST['duiEmpleado']) or
                    !$empleado->setImagen($_FILES['imagenEmpleado']) or
                    !$empleado->setFecha($_POST['fechaEmpleado'])
                ) {
                    $result['error'] = $empleado->getDataError();
                } elseif ($empleado->createNewRow()) {
                    $result['status'] = 1;
                    // Se asigna el estado del archivo después de insertar.

                    $fileStatuses['imagenEmpleado'] = Validator::saveFile($_FILES['imagenEmpleado'], $empleado::RUTA_IMAGEN, $_FILES['imagenEmpleado']['name']);

                    // Verifica que se guardaron todas las imágenes
                    if ($fileStatuses['imagenEmpleado']) {
                        $result['fileStatus'] = $fileStatuses; // Almacena el estado de los archivos
                    } else {
                        $result['error'] = 'Ocurrió un problema al guardar algunas imágenes';
                    }

                    $result['message'] = 'Empleado creado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear al Empleado';
                }
                break;
            case 'readEmployee':
                // Lectura de todos los empleado (puede ser una acción pública).
                if ($empleado->readAll()) {
                    // Si hay empleado registrados, se devuelve un mensaje de autenticación requerida.
                    $result['status'] = 1;
                    $result['message'] = 'Debe autenticarse para ingresar';
                } else {
                    // Si no hay empleado registrados, se muestra un mensaje de creación requerida.
                    $result['error'] = 'Debe crear un empleado para comenzar';
                }
                break;
            case 'checkUserCodigoSesion':
                // Inicio de sesión de un empleado (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if ($cliente->checkUserCodigoSesion($_POST['codigoUsuario'])) {
                    // Si las credenciales son correctas, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    // Si las credenciales son incorrectas, se registra un error.
                    $result['error'] = 'Credenciales incorrectas';
                }
                break;
            case 'checkUserCodigoSesion':
                // Inicio de sesión de un empleado (puede ser una acción pública).
                $_POST = Validator::validateForm($_POST);
                if ($cliente->checkUserCodigoSesion($_POST['codigoUsuario'])) {
                    // Si las credenciales son correctas, se actualiza el estado y mensaje.
                    $result['status'] = 1;
                    $result['message'] = 'Autenticación correcta';
                } else {
                    // Si las credenciales son incorrectas, se registra un error.
                    $result['error'] = 'Credenciales incorrectas';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
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
