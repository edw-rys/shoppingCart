<?php
include_once 'config/config.php';
include_once "model/DAO/UserDAO.php";
include_once "model/DAO/CountryDAO.php";
include_once "model/DTO/User/User.php";
include_once "model/DTO/User/Encrypt.php";
class UserController{
    private $userDao;
    private $encrypt;
    public function __construct(){
        $this->userDao=new UserDAO();
        $this->encrypt=new Encrypt();
    }
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function login(){
        $this->sessionStart();
        $username=(isset($_POST["username"]))?$_POST["username"]:'';
        $password=(isset($_POST["password"]))?$_POST["password"]:'';
        $password=$this->encrypt->encryption($_POST["password"]);
        $user=$this->userDao->checkUser($username , $password);
        if(empty($user)){
            $_SESSION['message']="Usuario o contrañesa incorrectos";
            $_SESSION['typeMessage']="error";
            $this->view();
        }else{
            $_SESSION['ID_USER']=$user->getId_user();
            $_SESSION['USER']=$user;
            header("Location:index.php");
        }
    }
    public function save(){
        $this->sessionStart();
        if(!(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["birthday"])
            && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])
            && isset($_POST["county"]) && isset($_POST["gender"]))){
                $_SESSION["message"]="Complete todos los campos";
                $_SESSION["typeMessage"]="error"; 
                $this->viewSignup();         
        }
        $newUser=new User();
        $newUser->setName_user($_POST["name"]);
        $newUser->setLast_name($_POST["lastname"]);
        $newUser->setBithday($_POST["birthday"]);
        $newUser->setMail($_POST["email"]);
        $newUser->setUsername(strtolower($_POST["username"]));

        $encryptPassword=$this->encrypt->encryption($_POST["password"]);

        $newUser->setPassword($encryptPassword);
        $newUser->setId_country($_POST["county"]);
        $newUser->setId_gener($_POST["gender"]);
        if(empty($this->userDao->checkUserName($newUser->getUsername()))){
            $numRows=$this->userDao->insert($newUser);

            $_SESSION['message']=($numRows>0)?"Guardado exitosamente":"Error al guardar";
            $_SESSION['typeMessage']=($numRows>0)?"info":"error";
            $this->view();
        }else{
            $_SESSION['message']="Usuario existente";
            $_SESSION['typeMessage']="error";
            $this->viewSignup();         
        }   
    }
    public function view(){
        $pageName="login";
        require_once HEADER;
        require_once 'view/static/login.php';
        require_once FOOTER;
    }
    public function viewSignup(){
        $continents=new CountryDAO();
        $continents=$continents->geData();
        // print_r($continents);
        $pageName="Registrase";
        require_once HEADER;
        require_once 'view/static/signup.php';
        require_once FOOTER;
    }
    public function profile(){
        $pageName="Perfil";
        require_once HEADER;
        require_once 'view/User/profile.php';
        require_once FOOTER;
    }
}