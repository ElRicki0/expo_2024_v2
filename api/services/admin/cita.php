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
    // Se verifica si existe una sesión iniciada como administrador, de lo contrario se finaliza el script con un mensaje de error.
    if (isset($_SESSION['idAdministrador'])) {
        $result['session'] = 1;
        // Se compara la acción a realizar cuando un administrador ha iniciado sesión.
        switch ($_GET['action']) {
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
                case 'createRow':
                    $_POST = Validator::validateForm($_POST);
                    if (
                        !$cita->setId($_POST['id_cita']) or
                        !$cita->setFecha($_POST['fecha_cita']) or
                        !$cita->setEstado(isset($_POST['estado_cita']) ? 1 : 0)or
                        !$cita->setSeciones($_POST['numero_seciones']) or
                        !$cita->setIDcliente($_POST['id_cliente ']) or
                        !$cita->setIDservicio($_POST['id_servicio']) or
                        !$cita->setIDempleado($_POST['id_empleado'])
                        
                    ) {
                        $result['error'] = $empleado->getDataError();
                    } elseif ($empleado->createRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'Empleado creado correctamente';
                    } else {
                        $result['error'] = 'Ocurrió un problema al crear al Empleado';
                    }
                    break;
                case 'updateRow':
                    $_POST = Validator::validateForm($_POST);
                    if (
                        !$cita->setId($_POST['id_cita']) or
                        !$cita->setFecha($_POST['fecha_cita']) or
                        !$cita->setEstado(isset($_POST['estado_cita']) ? 1 : 0)or
                        !$cita->setSeciones($_POST['numero_seciones']) or
                        !$cita->setIDcliente($_POST['id_cliente ']) or
                        !$cita->setIDservicio($_POST['id_servicio']) or
                        !$cita->setIDempleado($_POST['id_empleado'])
                    ) {
                        $result['error'] = $cita->getDataError();
                    } elseif ($cita->updateRow()) {
                        $result['status'] = 1;
                        $result['message'] = 'cita modificado correctamente';
                    } else {
                        $result['error'] = 'Ocurrió un problema al modificar el cita';
                    }
                    break;
                    case 'readAll':
                        if ($result['dataset'] = $cita->readAll()) {
                            $result['status'] = 1;
                            $result['message'] = 'Existen ' . count($result['dataset']) . ' registro(s)';
                        } else {
                            $result['error'] = 'No existen cita registrados';
                        }
                        break;
                        case 'readOne':
                            if (!$cita->setId($_POST['id_cita'])) {
                                $result['error'] = 'cita incorrecto';
                            } elseif ($result['dataset'] = $cita->readOne()) {
                                $result['status'] = 1;
                            } else {
                                $result['error'] = 'cita inexistente';
                            }
                            break;
                            case 'deleteRow':
                                if (!$cita->setId($_POST['id_cita'])) {
                                    $result['error'] = $cita->getDataError();
                                } elseif ($cita->deleteRow()) {
                                    $result['status'] = 1;
                                    $result['message'] = 'cita eliminada correctamente';
                                } else {
                                    $result['error'] = "Ocurrió un problema al eliminar la cita ";
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
            } else 
                print(json_encode('Recurso no disponible'));