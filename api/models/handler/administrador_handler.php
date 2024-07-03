<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
class AdministradorHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $correo = null;
    protected $contrasenia = null;
    protected $foto = null;
    protected $empleado = null;
    protected $nivel = null;

    /*
     *  Métodos para gestionar la cuenta del administrador.
     */

    // Método para verificar el inicio de sesión del administrador.
    public function checkUser($username, $password)
    {
        $sql = 'SELECT id_admin, correo_admin, contrasenia_admin
                FROM tb_admin
                WHERE correo_admin = ?';
        $params = array($username);
        // Se intenta obtener el registro del administrador según el correo.
        if (!($data = Database::getRow($sql, $params))) {
            return false; // Si no se encuentra el usuario, retorna falso.
        } elseif (password_verify($password, $data['contrasenia_admin'])) {
            // Si la contraseña coincide con el hash almacenado, se inicia la sesión del administrador.
            $_SESSION['idAdministrador'] = $data['id_admin'];
            $_SESSION['correoAdmin'] = $data['correo_admin'];
            return true; // Retorna verdadero indicando que el inicio de sesión fue exitoso.
        } else {
            return false; // Si la contraseña no coincide, retorna falso.
        }
    }
    
    // Método para verificar si la contraseña actual del administrador es correcta.
    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdmin']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña actual coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia_admin'])) {
            return true; // Retorna verdadero si la contraseña es correcta.
        } else {
            return false; // Retorna falso si la contraseña no coincide.
        }
    }

    // Método para cambiar la contraseña del administrador.
    public function changePassword()
    {
        $sql = 'UPDATE tb_admin
                SET contrasenia_admin = ?
                WHERE id_admin = ?';
        $params = array($this->contrasenia, $_SESSION['idAdmin']);
        // Se ejecuta la consulta para actualizar la contraseña del administrador.
        return Database::executeRow($sql, $params);
    }

    // Método para leer el perfil del administrador actual.
    public function readProfile()
    {
        $sql = 'SELECT id_admin, nombre_admin, foto_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdmin']);
        // Se obtiene la información del perfil del administrador actual.
        return Database::getRow($sql, $params);
    }

    // Método para editar el perfil del administrador.
    public function editProfile()
    {
        $sql = 'UPDATE tb_admin
                SET nombre_admin = ?, foto_admin = ?, id_empleado = ?
                WHERE id_admin = ?';
        $params = array($this->nombre, $this->foto, $this->empleado, $_SESSION['idAdministrador']);
        // Se ejecuta la consulta para actualizar la información del perfil del administrador.
        return Database::executeRow($sql, $params);
    }

    // Método para crear un nuevo administrador.
    public function createRow()
    {
        $sql = 'INSERT INTO tb_admin(nombre_admin, contrasenia_admin, correo_admin, id_empleado)
                VALUES(?, ?, ?, 1)';
        $params = array($this->nombre, $this->contrasenia, $this->correo);
        // Se ejecuta la consulta para insertar un nuevo registro de administrador.
        return Database::executeRow($sql, $params);
    }

    // Método para leer todos los administradores registrados.
    public function readAll()
    {
        $sql = 'SELECT id_admin, nombre_admin, contrasenia_admin, correo_admin
                FROM tb_admin
                ORDER BY nombre_admin';
        // Se obtienen todos los registros de administradores ordenados por nombre.
        return Database::getRows($sql);
    }
}
