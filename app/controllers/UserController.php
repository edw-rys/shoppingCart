<?php
require_once "app/models/DAO/UserDAO.php";
require_once "app/models/DAO/CountryDAO.php";
require_once "app/models/DTO/User/User.php";
include_once "app/models/DTO/User/Encrypt.php";
require_once "app/controllers/ProductController.php";
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
    public function index(){
        $this->profile();
    }
    public function static($page="login"){
        $continents=$this->continentsDao->geData();
        $data=[
            "tittle"=>$page,
            "continents"=>$continents
        ];
        View::render($page,$data);
    }

    public function login(){
        $username=(isset($_POST["username"]))?$_POST["username"]:'';
        $password=(isset($_POST["password"]))?$_POST["password"]:'';
        $password=$this->encrypt->encryption($password);
        $user=$this->userDao->checkUser($username , $password);
        // print_r($user);
        if(empty($user)){
            $_SESSION['message']="Usuario o contrañesa incorrectos";
            $_SESSION['typeMessage']="error";
            $this->static();
        }else{
            $_SESSION['ID_USER']=$user->getId_user();
            $_SESSION['USER']=serialize($user);
            $_SESSION["TYPE_US_C"]=$user->getId_typeuser();
            header("Location:".URL."user/profile");
        }
    }
    public function save(){
        if(!(isset($_POST["name"]) && isset($_POST["lastname"]) && isset($_POST["birthday"])
            && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"])
            && isset($_POST["county"]) && isset($_POST["gender"]))){
                $_SESSION["message"]="Complete todos los campos";
                $_SESSION["typeMessage"]="error"; 
                $this->static("signup"); 
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
                $this->static("signup");
                return;
            }
            $numRows=$this->userDao->insert($newUser);
            $_SESSION['message']=($numRows>0)?"Guardado exitosamente":"Error al guardar";
            $_SESSION['typeMessage']=($numRows>0)?"info":"error";
            $this->static();
        }else{
            $id=isset($_POST["idUser"])?$_POST["idUser"]:0;
            $newUser->setId_user($id);

            if(!empty($this->userDao->checkUserName($newUser))){
                $_SESSION['message']="Usuario existente";
                $_SESSION['typeMessage']="error";
                $this->static("signup");
                return;
            }

            $numRows=$this->userDao->update($newUser);
            $_SESSION['message']=($numRows>0)?"Editado exitosamente":"Error al editar";
            $_SESSION['typeMessage']=($numRows>0)?"info":"error";
            $user=$this->userDao->checkUser($newUser->getUsername(), $newUser->getPassword());
            $_SESSION['USER']=serialize($user);
            header("Location:".URL."user/profile");
        }
        
          
    }
    public function profile(){
        if(!isset($_SESSION['USER'])) header("Location:".URL);
        $user=unserialize($_SESSION['USER']);
        $id_c = isset($user)?$user->getId_country():0;
        $myCountry = $this->continentsDao->getCountryById($id_c);
        $myGender = $this->userDao->getGenderUser($user->getId_user());
        
        // Productos que le gusta
        $itemsLike=$this->productController->products_like($user->getId_user(),"");
        $data=[
            "tittle"=>    "Perfil",
            "myCountry"=> $myCountry,
            "myGender"=>  $myGender,
            "itemsLike"=> $itemsLike
        ];
        View::render("profile", $data);
    }
    public function logout(){
        session_destroy();
        $pageName="Inicio";
        header("Location:".URL);
    }
    public function edit(){
        if(!isset($_SESSION['USER'])) header("Location:".URL);
        $continents=$this->continentsDao->geData();
        // var_dump($continents);
        $data=[
            "tittle"=>"Editar perfil",
            "continents"=>$continents
        ];
        View::render("edit", $data);
    }
    // 
    public function i_like_product(){
        if(isset($_SESSION['USER'])){
            $idproduct=isset($_REQUEST['idp'])?$_REQUEST['idp']:"";
            $res=$this->userDao->like_product_by_user($_SESSION["ID_USER"],$idproduct);
            if(!empty($res)){
                $val=$this->userDao->removeLike($_SESSION["ID_USER"],$idproduct);
                if($val>0){echo "no-like";}
                return;
            }else{
                $val= $this->userDao->addLike($_SESSION["ID_USER"],$idproduct);
                if($val>0){echo "like";}
                return;
            }
        }

    }
}