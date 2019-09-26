<?php
require_once "app/models/DTO/User/User.php";
class HomeController {
    public function __construct() {}
    
    public function index(){
        $data=[
            "tittle"=>"Inicio"
        ];
        View::render("home", $data);
    }

    public function static($page="home"){
        echo $page;
        View::render($page);
    }
    public function notFound(){
        require_once HEADER;
        require_once 'view/static/notFound.php';
        
        require_once FOOTER;
    }
}
