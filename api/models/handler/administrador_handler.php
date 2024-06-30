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
     protected $usuario = null;
     protected $contrasenia = null;
     protected $foto = null;
     protected $empleado = null;
 }