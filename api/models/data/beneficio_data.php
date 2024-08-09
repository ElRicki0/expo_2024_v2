<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/beneficio_handler.php');

/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class BeneficioData extends BeneficioHandler
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
            $this->data_error = 'El identificador de la pregunta es incorrecto';
            return false;
        }
    }

    public function setTitulo($value, $min = 2, $max = 30)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'La pregunta debe ser un valor alfanumérico';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->titulo = $value;
            return true;
        } else {
            $this->data_error = 'El titulo debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

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

    public function setServicio($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->servicio = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del beneficio es incorrecto';
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
