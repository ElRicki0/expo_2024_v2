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
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;
    private $filename = null;

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

    // Método setcodigo: valida y asigna el nombre del administrador.
    public function setCodigoUsuario($value, $min = 2, $max = 250)
    {
        if (!Validator::validateAlphabetic($value)) {
            $this->data_error = 'El formato del nombre es incorrecto';
            return false;
        } elseif (Validator::validateLength($value, $min, $max)) {
            $this->codigoUsuario = $value;
            return true;
        } else {
            $this->data_error = 'El codigo debe tener una longitud entre ' . $min . ' y ' . $max;
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

    // Metodo setEmpleado: valida y asigna la relacion del empleado con el administrador 
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

    // Método setContrasenia: valida y asigna la contraseña del administrador.
    public function setcontrasenia($value, $min = 8, $max = 250)
    {
        if (Validator::validatePassword($value)) {
            $this->contrasenia = password_hash($value, PASSWORD_DEFAULT);
            return true;
        } else {
            $this->data_error = Validator::getPasswordError();
            return false;
        }
    }

    public function setImagen($file, $filename = null)
    {
        if (Validator::validateImageFile($file, 1000)) {
            $this->imagen = Validator::getFileName();
            return true;
        } elseif (Validator::getFileError()) {
            $this->data_error = Validator::getFileError();
            return false;
        } elseif ($filename) {
            $this->imagen = $filename;
            return true;
        } else {
            $this->imagen = 'cliente.png';
            return true;
        }
    }

    public function setFilename()
    {
        if ($data = $this->readFilename()) {
            $this->filename = $data['imagen_cliente'];
            return true;
        } else {
            $this->data_error = 'Cliente inexistente';
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
?>