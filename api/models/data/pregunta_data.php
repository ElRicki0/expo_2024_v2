<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/pregunta_handler.php');

/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class PreguntaData extends PreguntasHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;
    private $filename = null;

    /*
     *   Métodos para validar y establecer los datos.
     */

    // Método setId: valida y asigna el identificador de la pregunta.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la pregunta es incorrecto';
            return false;
        }
    }

    // Método setFilename: verifica y asigna el nombre de archivo de imagen de la pregunta.
    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['imagen_pregunta'];
            return true;
        } else {
            $this->data_error = 'Pregunta inexistente';
            return false;
        }
    }

    // Método setPregunta: valida y asigna la pregunta.
    public function setPregunta($value, $min = 2, $max = 250)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'La pregunta debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->pregunta = $value;
            return true;
        } else {
            $this->data_error = 'La pregunta debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setContenido: valida y asigna el contenido de la pregunta.
    public function setContenido($value, $min = 2, $max = 250)
    {
        if (!Validator::validateString($value)) {
            $this->data_error = 'El contenido contiene caracteres prohibidos';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->contenido = $value;
            return true;
        } else {
            $this->data_error = 'El contenido debe de tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setEmpleado: valida y asigna el identificador del empleado relacionado con la pregunta.
    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->empleado = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del empleado es incorrecto';
            return false;
        }
    }

    // Método setImagen: valida y asigna la imagen relacionada con la pregunta.
    public function setImagen($file, $filename = null)
    {
        if (Validator::validateImageFile($file, 1000)) {
            $this->imagen = Validator::getFilename();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen = $filename;
            return true;
        } else {
            $this->imagen = 'default.png';
            return true;
        }
    }

    /*
     *  Métodos para obtener el valor de los atributos adicionales.
     */

    // Método getDataError: retorna el error actual de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }

    // Método getFilename: retorna el nombre del archivo de imagen relacionado con la pregunta.
    public function getFilename()
    {
        return $this->filename;
    }
}
?>
