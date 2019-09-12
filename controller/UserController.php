<?php
require_once 'config/config.php';
require_once "model/DAO/UserDAO.php";
require_once "model/DAO/CountryDAO.php";
require_once "model/DTO/User/User.php";
include_once "model/DTO/User/Encrypt.php";
require_once "controller/ProductController.php";
class UserController{
    private $userDao;
    private $encrypt;
    private $continentsDao;
    private $productController;
    public function __construct(){
        $this->userDao=new UserDAO();
        $this->encrypt=new Encrypt();
        $this->continentsDao=new CountryDAO();
        $this->productController = new ProductController();
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
        $password=$this->encrypt->encryption($password);
        $user=$this->userDao->checkUser($username , $password);
        // print_r($user);
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
        $newUser->setId_user(0);
        $newUser->setName_user($_POST["name"]);
        $newUser->setLast_name($_POST["lastname"]);
        $newUser->setBirthdate($_POST["birthday"]);
        $newUser->setMail($_POST["email"]);
        $newUser->setUsername(strtolower($_POST["username"]));

        $encryptPassword=$this->encrypt->encryption($_POST["password"]);

        $newUser->setPassword($encryptPassword);
        $newUser->setId_country($_POST["county"]);
        $newUser->setId_gender($_POST["gender"]);

        $action = isset($_POST["t"])?$_POST["t"]:"Registrar";
        $action=strtoupper($action);
        $numRows=0;
        if($action=="REGISTRAR"){
            if(!empty($this->userDao->checkUserName($newUser))){
                $_SESSION['message']="Usuario existente";
                $_SESSION['typeMessage']="error";
                $this->viewSignup();
                return;
            }
            $numRows=$this->userDao->insert($newUser);
            $_SESSION['message']=($numRows>0)?"Guardado exitosamente":"Error al guardar";
            $_SESSION['typeMessage']=($numRows>0)?"info":"error";
            $this->view();
        }else{
            $id=isset($_POST["idUser"])?$_POST["idUser"]:0;
            $newUser->setId_user($id);

            if(!empty($this->userDao->checkUserName($newUser))){
                $_SESSION['message']="Usuario existente";
                $_SESSION['typeMessage']="error";
                $this->viewSignup();    
                return;
            }

            $numRows=$this->userDao->update($newUser);
            $_SESSION['message']=($numRows>0)?"Editado exitosamente":"Error al editar";
            $_SESSION['typeMessage']=($numRows>0)?"info":"error";
            $user=$this->userDao->checkUser($newUser->getUsername(), $newUser->getPassword());
            $_SESSION['USER']=$user;
            header("Location:index.php?c=user&a=profile");
        }
        
          
    }
    public function view(){
        $pageName="login";
        require_once HEADER;
        require_once 'view/static/login.php';
        require_once FOOTER;
    }
    public function viewSignup(){
        $continents=$this->continentsDao->geData();
        // print_r($continents);
        $pageName="Registrase";
        require_once HEADER;
        require_once 'view/static/signup.php';
        require_once FOOTER;
    }
    public function profile(){

        if(!isset($_SESSION['USER'])) header("Location:index.php");
        $user=$_SESSION['USER'];

        $id_c=isset($user)?$user->getId_country():0;
        $myCountry = $this->continentsDao->getCountryById($id_c);
        $myGender = $this->userDao->getGenderUser($user->getId_user());
        $pageName="Perfil";

        // Productos que le gusta
        $itemsLike=$this->productController->products_like($user->getId_user(),"");
        // Productos que ha comprado
        if($user->getId_typeuser()==CLIENT)
            $itemsBuyout=$this->productController->products_buyout($user->getId_user(),"");
        else if($user->getId_typeuser()==ADMIN)
            $items_Sale=$this->productController->products_Sale("");

        require_once HEADER;
        require_once 'view/User/profile.php';
        require_once FOOTER;
    }
    public function logout(){
        $this->sessionStart();
        session_destroy();
        $pageName="Inicio";
        header("Location:index.php");
    }
    public function editprofile(){
        $this->sessionStart();
        if(!isset($_SESSION['USER'])) header("Location:index.php");
        $continents=$this->continentsDao->geData();
        $pageName="Editar perfil";
        require_once HEADER;
        require_once 'view/User/profileEdit.php';
        require_once FOOTER;
    }
}