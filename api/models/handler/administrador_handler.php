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
     protected $contrasenia = null;
     protected $foto = null;
     protected $empleado = null;

     /*
     *  Métodos para gestionar la cuenta del administrador.
     */
    public function checkUser($username, $password)
    {
        $sql = 'SELECT id_admin, nombre_admin, contrasenia_admin
                FROM tb_admin
                WHERE nombre_admin = ?';
        $params = array($username);
        if (!($data = Database::getRow($sql, $params))) {
            return false;
        } elseif (password_verify($password, $data['contrasenia_admin'])) {
            $_SESSION['idAdmin'] = $data['id_admin'];
            $_SESSION['nombreAdmin'] = $data['nombre_admin'];
            return true;
        } else {
            return false;
        }
    }
    
    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdmin']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia_admin'])) {
            return true;
        } else {
            return false;
        }
    }

    public function changePassword()
    {
        $sql = 'UPDATE tb_admin
                SET contrasenia_admin = ?
                WHERE id_admin = ?';
        $params = array($this->contrasenia, $_SESSION['idAdmin']);
        return Database::executeRow($sql, $params);
    }

    public function readProfile()
    {
        $sql = 'SELECT id_admin, nombre_admin, foto_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdmin']);
        return Database::getRow($sql, $params);
    }

    public function editProfile()
    {
        $sql = 'UPDATE tb_admin
                SET nombre_admin = ?, foto_admin = ?, id_empleado = ?
                WHERE id_admin = ?';
        $params = array($this->nombre, $this->foto, $this->empleado, $_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }
 }