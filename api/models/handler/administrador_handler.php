<?php
// Se incluye la clase para trabajar con la base de datos.
require_once ('../../helpers/database.php');

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
        $sql = 'SELECT id_admin, correo_admin, contraseña_admin
                FROM tb_admin
                WHERE correo_admin = ?';
        $params = array($username);
        // Se intenta obtener el registro del administrador según el correo.
        if (!($data = Database::getRow($sql, $params))) {
            return false; // Si no se encuentra el usuario, retorna falso.
        } elseif (password_verify($password, $data['contraseña_admin'])) {
            // Si la contraseña coincide con el hash almacenado, se inicia la sesión del administrador.
            $_SESSION['idAdministrador'] = $data['id_admin'];
            $_SESSION['correo_admin'] = $data['correo_admin'];
            return true; // Retorna verdadero indicando que el inicio de sesión fue exitoso.
        } else {
            return false; // Si la contraseña no coincide, retorna falso.
        }
    }

    // Método para verificar si la contraseña actual del administrador es correcta.
    public function checkPassword($password)
    {
        $sql = 'SELECT contraseña_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdministrador']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contraseña actual coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contraseña_admin'])) {
            return true; // Retorna verdadero si la contraseña es correcta.
        } else {
            return false; // Retorna falso si la contraseña no coincide.
        }
    }

    // Método para cambiar la contraseña del administrador.
    public function changePassword()
    {
        $sql = 'UPDATE tb_admin
                SET contraseña_admin = ?
                WHERE id_admin = ?';
        $params = array($this->contrasenia, $_SESSION['idAdministrador']);
        // Se ejecuta la consulta para actualizar la contraseña del administrador.
        return Database::executeRow($sql, $params);
    }

    // Método searchRows: busca empleados en la base de datos según un criterio de búsqueda.
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                    FROM tb_admin
                    WHERE nombre_admin LIKE ?
                    ORDER BY nombre_admin';
        $params = array($value);
        return Database::getRows($sql, $params);
    }

    // Método para leer el perfil del administrador actual.
    public function readProfile()
    {
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdministrador']);
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
        $sql = 'INSERT INTO tb_admin(nombre_admin, contraseña_admin, correo_admin, id_empleado)
                VALUES(?, ?, ?, ?)';
        $params = array($this->nombre, $this->contrasenia, $this->correo, $this->empleado);
        // Se ejecuta la consulta para insertar un nuevo registro de administrador.
        return Database::executeRow($sql, $params);
    }

    // Método updateRow: actualiza los datos de un empleado en la base de datos.
    public function updateRow()
    {
        $sql = 'UPDATE tb_admin
                SET nombre_admin = ?, correo_admin = ?
                WHERE id_admin = ?';
        $params = array($this->nombre, $this->correo, $this->id);
        return Database::executeRow($sql, $params);
    }
    
    // Método para leer todos los administradores registrados.
    public function readAll()
    {
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                FROM tb_admin
                ORDER BY nombre_admin';
        // Se obtienen todos los registros de administradores ordenados por nombre.
        return Database::getRows($sql);
    }


    // Método para leer un administrador.
    public function readOne()
    {
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Método para leer un empleado.
    public function readEmployed()
    {
        $sql = 'SELECT A.id_empleado, E.nombre_empleado
                FROM tb_admin AS A
                INNER JOIN tb_empleado AS E ON A.id_empleado = E.id_empleado
                WHERE A.id_admin = ?';
        $params = array($this->id);
        return Database::getRows($sql, $params);
    }

    // Método deleteRow: elimina un empleado de la base de datos según su ID.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_admin
                    WHERE id_admin = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
