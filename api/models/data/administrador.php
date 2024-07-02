<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/administrador_handler.php'); // Ajusta la ruta según la ubicación del archivo handler

/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla EMPLEADOS.
 */

class AdministradorData extends AdministradorHandler
{
    // Atributo genérico para manejo de errores.
    private $data_error = null;

    /*
     *  Métodos para validar y asignar valores de los atributos.
     */

    // Método setId: valida y asigna el identificador del cliente.
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

    // Método setNombre: valida y asigna el nombre del administrador.
    public function setNombre($value, $min = 2, $max = 250)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El formato del nombre es incorrecto';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setCorreo: valida y asigna el correo electrónico del administrador.
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

    // Método setNivel: valida y asigna el nivel del administrador.
    public function setNivel($value, $min = 2, $max = 250)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El formato del nivel es incorrecto';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nivel = $value;
            return true;
        } else {
            $this->data_error = 'El nivel debe tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    // Método setcontrasenia: valida y asigna la contraseña del administrador.
    public function setcontrasenia($value, $min = 8, $max = 250)
    {
        if (!Validator::validatePassword($value)) {
            $this->data_error = 'El formato de la contraseña es incorrecto';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->nivel = $value;
            return true;
        } else {
            $this->data_error = 'La contraseña es menor a 8 carácteres' . $min . ' y ' . $max;
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
