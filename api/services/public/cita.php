<?php
// Se incluye la clase del modelo.
require_once('../../models/data/cita_data.php');

// Se comprueba si existe una acción a realizar, de lo contrario se finaliza el script con un mensaje de error.
if (isset($_GET['action'])) {
    // Se crea una sesión o se reanuda la actual para poder utilizar variables de sesión en el script.
    session_start();
    // Se instancia la clase correspondiente.
    $cita = new CitaData;
    // Se declara e inicializa un arreglo para guardar el resultado que retorna la API.
    $result = array('status' => 0, 'message' => null, 'dataset' => null, 'error' => null, 'exception' => null, 'fileStatus' => null);
    // Se verifica si existe una sesión iniciada como cliente para realizar las acciones correspondientes.
    if (isset($_SESSION['idCliente'])) {
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {

            case 'createRowCliente':
                $_POST = Validator::validateForm($_POST);
                if (
                    !$cita->setServicio($_POST['idServicio'])
                ) {
                    $result['error'] = $cita->getDataError();
                } elseif ($cita->createRowCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'cita creada correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al crear la cita';
                }
                break;
            case 'readAllCliente':
                if ($result['dataset'] = $cita->readAllCliente()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' cita(s)';
                } else {
                    $result['error'] = 'No existen citas registradas';
                }
                break;
            case 'readAllClienteAprobado':
                if ($result['dataset'] = $cita->readAllClienteAprobado()) {
                    $result['status'] = 1;
                    $result['message'] = 'Existen ' . count($result['dataset']) . ' cita(s)';
                } else {
                    $result['error'] = 'No existen citas aprobadas';
                }
                break;
            case 'deleteRow':
                if (
                    !$cita->setId($_POST['idCita'])
                ) {
                    $result['error'] = $cita->getDataError();
                } elseif ($cita->deleteRow()) {
                    $result['status'] = 1;
                    $result['message'] = 'Cita eliminado correctamente';
                } else {
                    $result['error'] = 'Ocurrió un problema al eliminar la cita   ////   la cita esta siendo usada por tratamientos ';
                }
                break;
            default:
                $result['error'] = 'Acción no disponible dentro de la sesión';
        }
    } else {
        // Se compara la acción a realizar cuando un cliente no ha iniciado sesión.
        switch ($_GET['action']) {
            case 'createDetail':
                $result['error'] = 'Debe iniciar sesión para agregar el producto al carrito';
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
    print(json_encode('Recurso no disponible'));
}
