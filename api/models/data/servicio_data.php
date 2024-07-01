<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/servicio_handler.php'); // Ajusta la ruta según la ubicación del archivo handler

class ServicioData extends ServicioHandler
{
// Atributo genérico para manejo de errores.
private $data_error = null;

/*
 *  Métodos para validar y asignar valores de los atributos.
 */

 public function setId($value)
 {
     if (Validator::validateNaturalNumber($value)) {
         $this->id = $value;
         return true;
     } else {
         $this->data_error = 'El identificador del servicio es incorrecto';
         return false;
     }
 }


 public function getDataError()
    {
        return $this->data_error;
    }

}
