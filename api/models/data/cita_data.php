<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/cita_handler.php');
/*
 *	Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTO.
 */
class CitaData extends CitaHandler
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
            $this->data_error = 'El identificador de cita es incorrecto';
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

    public function setFecha($value)
    {
        $this->fechaC = $value;
        return true;
    }

    public function setFechaInicio($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaI = $value;
            return true;
        } else {
            $this->data_error = 'La fecha de inicio es incorrecta';
            return false;
        }
    }

    public function setFechaFinal($value)
    {
        if (Validator::validateDate($value)) {
            $this->fechaF = $value;
            return true;
        } else {
            $this->data_error = 'La fecha de final es incorrecta';
            return false;
        }
    }

    public function setEstado($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphanumeric($value)) {
            $this->data_error = 'error al estado';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->estado = $value;
            return true;
        } else {
            $this->data_error = 'El estado debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setSeciones($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->sesiones = $value;
            return true;
        } else {
            $this->data_error = 'Seciones Incorrectas';
            return false;
        }
    }

    public function setCliente($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cliente = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    public function setServicio($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->servicio = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del servicio es incorrecto';
            return false;
        }
    }

    public function setEmpleado($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->empleado = $value;
            return true;
        } else {
            $this->data_error = 'El identificador empleado es incorrecto';
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
}