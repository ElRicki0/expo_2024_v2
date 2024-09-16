<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla administrador.
 */
// Generar un número aleatorio de 6 dígitos
$codigo_aleatorio = rand(100000, 999999);
class AdministradorHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $correo = null;
    protected $contrasenia = null;
    protected $empleado = null;
    protected $codigo = null; // Inicialmente nulo

    public function __construct()
    {
        // Generar un código aleatorio de 6 dígitos y asignarlo a $codigo
        $this->codigo = rand(100000, 999999);
    }

    // Método para obtener el código (opcional)
    public function getCodigo()
    {
        return $this->codigo;
    }

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
            // Si la contrasenia coincide con el hash almacenado, se inicia la sesión del administrador.
            $_SESSION['idAdministrador'] = $data['id_admin'];
            $_SESSION['correo_admin'] = $data['correo_admin'];
            return true; // Retorna verdadero indicando que el inicio de sesión fue exitoso.
        } else {
            return false; // Si la contrasenia no coincide, retorna falso.
        }
    }

    // Método para verificar el inicio de sesión del administrador.
    public function checkUserRecuperacion($username)
    {
        $sql = 'SELECT id_admin, correo_admin, contrasenia_admin
            FROM tb_admin
            WHERE correo_admin = ?';
        $params = array($username);
        // Se intenta obtener el registro del administrador según el correo.
        if (!($data = Database::getRow($sql, $params))) {
            return false; // Si no se encuentra el usuario, retorna falso.
        } else{
            // Si la contrasenia coincide con el hash almacenado, se inicia la sesión del administrador.
            $_SESSION['idAdministrador'] = $data['id_admin'];
            $_SESSION['correo_admin'] = $data['correo_admin'];
            return true; // Retorna verdadero indicando que el inicio de sesión fue exitoso.
        } 
            return false; // Si la contrasenia no coincide, retorna falso.
        
    }

    // Método para verificar si la contrasenia actual del administrador es correcta.
    public function checkPassword($password)
    {
        $sql = 'SELECT contrasenia_admin
                FROM tb_admin
                WHERE id_admin = ?';
        $params = array($_SESSION['idAdministrador']);
        $data = Database::getRow($sql, $params);
        // Se verifica si la contrasenia actual coincide con el hash almacenado en la base de datos.
        if (password_verify($password, $data['contrasenia_admin'])) {
            return true; // Retorna verdadero si la contrasenia es correcta.
        } else {
            return false; // Retorna falso si la contrasenia no coincide.
        }
    }

    // Método para cambiar la contrasenia del administrador.
    public function changePassword()
    {
        $sql = 'UPDATE tb_admin
                SET contrasenia_admin = ?
                WHERE id_admin = ?';
        $params = array($this->contrasenia, $_SESSION['idAdministrador']);
        // Se ejecuta la consulta para actualizar la contrasenia del administrador.
        return Database::executeRow($sql, $params);
    }

    // Método searchRows: busca empleados en la base de datos según un criterio de búsqueda.
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                        FROM tb_admin
                        WHERE nombre_admin LIKE ?
                        AND id_admin <> ?
                        ORDER BY nombre_admin';
        $params = array($value, $_SESSION['idAdministrador']);
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
                SET nombre_admin = ?, correo_admin = ?
                WHERE id_admin = ?';
        $params = array($this->nombre, $this->correo, $_SESSION['idAdministrador']);
        // Se ejecuta la consulta para actualizar la información del perfil del administrador.
        return Database::executeRow($sql, $params);
    }

    // Método para crear un nuevo administrador.
    public function createRow()
    {
        $sql = 'INSERT INTO tb_admin(nombre_admin, contrasenia_admin, correo_admin, id_empleado, codigo_admin)
                VALUES(?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->contrasenia, $this->correo, $this->empleado, $this->codigo);
        // Se ejecuta la consulta para insertar un nuevo registro de administrador.
        return Database::executeRow($sql, $params);
    }

    // Método para crear un nuevo administrador.
    public function createNewRow()
    {
        $sql = 'INSERT INTO tb_admin(nombre_admin, contrasenia_admin, correo_admin, id_empleado, codigo_admin)
                VALUES(?, ?, ?, 1, ?)';
        $params = array($this->nombre, $this->contrasenia, $this->correo, $this->codigo);
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
        $sql = 'SELECT a.id_admin, a.nombre_admin, a.correo_admin, a.contrasenia_admin, e.nombre_empleado, a.id_empleado, e.nombre_empleado
                FROM tb_admin a
                INNER JOIN tb_empleados e ON a.id_empleado= e.id_empleado
                WHERE a.id_admin <> ?';
        $params = array($_SESSION['idAdministrador']);
        // Se obtiene la información del perfil del administrador actual.
        return Database::getRows($sql, $params);
    }

    // Método para leer todos los empleados registrados.
    public function readAllEmployee()
    {
        $sql = 'SELECT *
                FROM tb_empleados ';
        // Se ejecuta la consulta para actualizar la información del perfil del administrador.
        return Database::getRows($sql);
    }


    // Método para leer todos los administradores registrados menos el de la sesión iniciada.
    public function readAllOne()
    {
        $sql = 'SELECT id_admin, nombre_admin, correo_admin
                FROM tb_admin
                WHERE id_admin <> ?';
        $params = array($_SESSION['idAdministrador']);
        // Se ejecuta la consulta para actualizar la información del perfil del administrador.
        return Database::getRows($sql, $params);
    }

    // Método para leer un administrador.
    public function readOne()
    {
        $sql = 'SELECT A.id_admin, A.nombre_admin, A.correo_admin, A.id_empleado
                FROM tb_admin A
                WHERE A.id_admin = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Método para leer un empleado del administrador.
    public function readEmployed()
    {
        $sql = 'SELECT E.id_empleado, E.nombre_empleado
                    FROM tb_empleados E
                    INNER JOIN tb_admin A ON E.id_empleado = A.id_empleado
                    WHERE A.id_admin = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    // Método deleteRow: elimina un administrador de la base de datos según su ID.
    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_admin
                    WHERE id_admin = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }

    // Método DeleteProfile: elimina un administrador de la base de datos según su ID.
    public function DeleteProfile()
    {
        $sql = 'DELETE FROM tb_empleados 
                WHERE id_empleado = (SELECT id_empleado FROM tb_admin WHERE id_admin = ?);';
        $params = array($_SESSION['idAdministrador']);
        return Database::executeRow($sql, $params);
    }

    // Método para leer un administrador.
    public function readOneRecuperacion()
    {
        $sql = 'SELECT a.correo_admin, a.nombre_admin, a.codigo_admin
                FROM tb_admin a
                WHERE a.correo_admin = ?';
        $params = array($this->correo);
        return Database::getRow($sql, $params);
    }
}
