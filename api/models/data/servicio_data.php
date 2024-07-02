<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/servicio_handler.php'); // Ajusta la ruta según la ubicación del archivo handler

class ServicioData extends ServicioHandler
{
// Atributo genérico para manejo de errores.
private $data_error = null;
private $filename = null;

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

 public function setImagen($file, $filename = null)
 {
    if (Validator::getFileError()) {
         $this->data_error = Validator::getFileError();
         return false;
     } elseif ($filename) {
         $this->foto = $filename;
         return true;
     } else {
         $this->foto = 'default.png';
         return true;
     }
 }

 public function setDescripcion($value, $min = 2, $max = 250)
    {
        if (!$value) {
            return true;
        } elseif (!Validator::validateString($value)) {
            $this->data_error = 'La descripción contiene caracteres prohibidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->descripcion = $value;
            return true;
        } else {
            $this->data_error = 'La descripción debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setServicio($value, $min = 2, $max = 45)
    {
        if (!$value) {
            return true;
        } elseif (!Validator::validateString($value)) {
            $this->data_error = 'La descripción contiene caracteres prohibidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->servicio = $value;
            return true;
        } else {
            $this->data_error = 'La descripción debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['imagen_categoria'];
            return true;
        } else {
            $this->data_error = 'Categoría inexistente';
            return false;
        }
    }


 public function getDataError()
    {
        return $this->data_error;
    }

    public function getFilename()
    {
        return $this->filename;
    }

}
