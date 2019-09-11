<?php
//rutas generales
define("SERVER", "localhost:81");
define("NAMEAPP", "AplicacionCompras");
define("ROUTEAPP","http://".SERVER."/".NAMEAPP);

// RUTA RECURSOS
define("ROUTECSS",ROUTEAPP.'/assets/css');
define("ROUTEJS",ROUTEAPP.'/assets/js');
define("ROUTEIMG",'assets/img/');


//encabezado y pie
define('HEADER', 'view/templates/header.php');
define('FOOTER', 'view/templates/footer.php');
define("PANELS","view/components/panels.php");
define("NAVIGATION","view/components/navigation.php");
define("CART","view/components/Cart.php");

// RUTAS PARA BASE DE DATOS
define("SERVERDB", "localhost");
define("PORT", "3306");
define("NAMEDB", "pasteleria");
define("USER", "root");
define("PASSWORD", "");

// ID DE TIPOS DE USUARIOS
define("ADMIN", "101");
define("CLIENT", "200");