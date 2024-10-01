<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/imagen_handler.php');
/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class ImagenData extends ImagenHandler
{
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
            $this->data_error = 'El identificador del producto es incorrecto';
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'El nombre debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setImagen1($file, $filename = null)
    {
        if (Validator::validateImageFile($file)) { // Validación sin tamaño especificado
            $this->imagen1 = $file['name']; // Guarda el nombre original
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen1 = $filename; // Guarda el nombre original si se pasa
            return true;
        } else {
            $this->data_error = 'La imagen no puede ser vació';
            return false;
        }
    }
    
    public function setImagen2($file, $filename = null)
    {
        if (Validator::validateImageFile($file)) {
            $this->imagen2 = $file['name']; // Guarda el nombre original
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen2 = $filename;
            return true;
        } else {
            $this->data_error = 'La imagen no puede ser vació';
            return false;
        }
    }
    
    public function setImagen3($file, $filename = null)
    {
        if (Validator::validateImageFile($file)) {
            $this->imagen3 = $file['name']; // Guarda el nombre original
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen3 = $filename;
            return true;
        } else {
            $this->data_error = 'La imagen no puede ser vació';
            return false;
        }
    }
    

    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['name'];
            return true;
        } else {
            $this->data_error = 'Imagen inexistente';
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
