<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/empleado_handler.php'); // Ajusta la ruta según la ubicación del archivo handler

/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla EMPLEADOS.
 */

class EmpleadoData extends EmpleadoHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */

    // Método setId: valida y asigna el identificador del empleado.
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del cliente es incorrecto';
            return false;
        }
    }

    // Método setNombre: valida y asigna el nombre del empleado.
    public function setNombre($value, $min = 2, $max = 50)
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

    // Método setApellido: valida y asigna el nombre del empleado.
    public function setApelldo($value, $min = 2, $max = 50)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El apellido debe ser un valor alfabético';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->apellido = $value;
            return true;
        } else {
            $this->data_error = 'El apellido debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setFecha: valida y asigna la fecha de nacimiento del empleado.
    public function setFecha($value)
    {
        if (Validator::validateDate($value)) {
            $this->fecha = $value;
            return true;
        } else {
            $this->data_error = 'La fecha de nacimiento es incorrecta';
            return false;
        }
    }

    // Método setDui: valida y asigna el DUI del empleado.
    public function setDui($value)
    {
        if (Validator::validateDui($value)) {
            $this->dui = $value;
            return true;
        } else {
            $this->data_error = 'El DUI no es válido';
            return false;
        }
    }

    // Método setCorreo: valida y asigna el correo electrónico del empleado.
    public function setCorreo($value, $min = 8, $max = 100)
    {
        if (!Validator::validateEmail($value)) {
            $this->data_error = 'El correo no es válido';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->correo = $value;
            return true;
        } else {
            $this->data_error = 'El correo debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setEstado: valida y asigna el estado del empleado.
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

    // Método getDataError: retorna el error actual de los datos.
    public function getDataError()
    {
        return $this->data_error;
    }
}
?>