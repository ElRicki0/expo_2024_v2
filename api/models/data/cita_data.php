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