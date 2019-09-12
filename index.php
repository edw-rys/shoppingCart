<?php

require_once './controller/FrontController.php';
// Las rutas se manejan con index.php
// valores de controlador c=controlador, a=acción o método
$ruteador = new FrontController();
$ruteador->route();
?>
