<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/cita_handler.php');
/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class CitaData extends CitaHandler{
    
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;
    private $filename = null;

    /*
     *   Métodos para validar y establecer los datos.
     */

     public function setId($value)
     {
         if (Validator::validateNaturalNumber($value)) {
             $this->id = $value;
             return true;
         } else {
             $this->data_error = 'El identificador de cita es incorrecto';
             return false;
         }
     }
     public function setFecha($value)
     {
         if (Validator::validateDate($value)) {
             $this->fecha = $value;
             return true;
         } else {
             $this->data_error = 'La fecha de la cita es incorrecta';
             return false;
         }
     }

     public function setEstado($value)
     {
         if (Validator::validateBoolean($value)) {
             $this->estado = $value;
             return true;
         } else {
             $this->data_error = 'Estado incorrecto';
             return false;
         }
     }
     
     public function setSeciones($value)
     {
         if (Validator::validateNaturalNumber($value)) {
             $this->seciones = $value;
             return true;
         } else {
             $this->data_error = 'Seciones Incorrectas';
             return false;
         }
     }

     public function setIDcliente($value, $min = 2, $max = 50)
     {
         if (!Validator::validateAlphabetic($value)) {
             $this->data_error = 'El nombre debe ser un valor alfabético';
             return false;
         } elseif (Validator::validateLength($value, $min, $max)) {
             $this->nombre = $value;
             return true;
         } else {
             $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
             return false;
         }
     }

     public function setIDservicio($value, $min = 2, $max = 50)
     {
         if (!Validator::validateAlphabetic($value)) {
             $this->data_error = 'El servicio debe ser un valor alfabético';
             return false;
         } elseif (Validator::validateLength($value, $min, $max)) {
             $this->nombre = $value;
             return true;
         } else {
             $this->data_error = 'El servicio debe tener una longitud entre ' . $min . ' y ' . $max;
             return false;
         }
     }

     public function setIDempleado($value, $min = 2, $max = 50)
     {
         if (!Validator::validateAlphabetic($value)) {
             $this->data_error = 'El empleado debe ser un valor alfabético';
             return false;
         } elseif (Validator::validateLength($value, $min, $max)) {
             $this->nombre = $value;
             return true;
         } else {
             $this->data_error = 'El empleado debe tener una longitud entre ' . $min . ' y ' . $max;
             return false;
         }
     }
 
     /*
      *  Métodos para obtener el valor de los atributos adicionales.
      */
     public function getDataError()
     {
         return $this->data_error;
     }
 
     public function getFilename()
     {
         return $this->filename;
     }

}