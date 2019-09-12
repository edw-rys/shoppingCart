<?php
require_once "model/DTO/User/User.php";
class FrontController {

    public function __construct() {     
    }
    /*
    * Routeador
    * Recibe parámetros c=> contorlador y a=>acción
    * completa el nombre del contorlador que se envía mediante la URL
        * index => IndexController
    * Crea Objeto del controlador y ejecuta la acción
    */
    public function route() {
        $this->sessionStart();
        $controller = (isset($_REQUEST['c'])) ? $_REQUEST['c'] : 'Index';
        $action = (isset($_REQUEST['a'])) ? $_REQUEST['a'] : 'query';

        $controller = strtolower($controller); // strtolower Make a string lowercase
        $controller = ucwords($controller) . "Controller"; //ucwords — Uppercase the first character of each word in a string   
        require_once "controller/" . $controller . ".php"; // require de la clase del controlador
        $controller = new $controller; // creacion del objeto controlador
        $controller->$action(); //llamada a la funcion del controlador (action) que se va a ejecutar    
    }
    // Inicia sesión en caso de que no exista
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    
}
