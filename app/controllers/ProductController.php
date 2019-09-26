<?php
// require_once 'config/config.php';
require_once "app/models/DTO/Product/Product.php";
require_once "app/models/DTO/Image.php";
require_once "app/models/DTO/Product/CategoryProduct_.php";
require_once "app/models/DAO/ProductDAO.php";
require_once "app/models/DTO/User/User.php";
class ProductController{
    private $productDao;
    public function __construct(){
        $this->productDao=new ProductDAO();
    }
    
    public function index(){
        $criterio= isset($_REQUEST['search'])?$_REQUEST['search']:"";
        $listProducts=$this->productDao->getProducts($criterio);
        $listCtgProd=$this->productDao->AllCtgProduct();


        $this->page($listProducts, $listCtgProd);
        // $this->page();
    }
    public function page($listProducts=null,$listCtgProd=null){
        $pageName="Productos";
        View::render("products",
            array(
                "catgories"=>$listCtgProd,
                "products" =>$listProducts,
                "tittle"=>"Productos"
            )
        );
    }

    public function products_like($idUser,$query){
        $products = $this->productDao->queryForLike($idUser,$query);
        return $this->productDao->getProductsClass($products);
    }



    public function getBill(){
        if(isset($_SESSION['USER'])){
            $user=unserialize($_SESSION['USER']);
            // print_r($user);
            $bills=array();
            if($user->getId_typeuser()==ADMIN){
                $query=isset($_REQUEST['search'])?$_REQUEST['search']:"";
                $filer=isset($_REQUEST['filter'])?$_REQUEST['filter']:0;
                $bills = $this->products_Sale($filer, $query);
            }
            else if($user->getId_typeuser()==CLIENT){
                $bills = $this->products_buyout( $user->getId_user(), $query);
            }
            $bills = isset($bills)?$bills:array();
            $data=[
                "tittle"=>"Ventas",
                "bills"=>$bills
            ];
            View::render("sales",$data);
        }else{
            header("Location:index.php");
        }
    }

    
    public function products_buyout($idUser,$query){
        return $this->productDao->getBillByClient($idUser,$query);
    }
    public function products_Sale($filer,$query){
        return $this->productDao->getAllBill($filer,$query);
    }
    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    public function getProductById($idP){
        return $this->productDao->queryById($idP);        
    }

    public function add(){
        if(!(isset($_SESSION["TYPE_US_C"]) && $_SESSION["TYPE_US_C"]==ADMIN)){
            $_SESSION["message"]="¡Acceso no permitido!";
            $_SESSION["typeMessage"]="error"; 
            header("Location:index.php");
            return;
        }
        echo $_POST["name_p"];
        if(!(isset($_POST["name_p"]) && isset($_POST["description_p"]) 
            && isset($_FILES['img_p']) && isset($_POST["ctg_p"]) && isset($_POST["discount"])
            && isset($_POST["quantity_p"]) && isset($_POST["price"]) )){
                $_SESSION["message"]="Complete todos los campos";
                $_SESSION["typeMessage"]="error"; 
                header("Location:index.php?c=user&a=profile");
            return;
        }else{
            $product=new Product();
            $product->setName($_POST["name_p"]);
            $product->setDescription($_POST["description_p"]);
            $product->setQuantity($_POST["quantity_p"]);
            $product->setPrice($_POST["price"]);
            $product->setDiscount($_POST["discount"]);
            $product->setCategory($_POST["ctg_p"]);
            $status=0;

            $dir=Image::getDirImg("img_p");
            if($dir=="err_size"){
                $_SESSION["message"]="Archivo muy pesado, tamaño máximo de 2mb";
                $_SESSION["typeMessage"]="error"; 
                header("Location:index.php?c=user&a=profile");
                return;
            }
            if($dir=="err_ext"){
                $_SESSION["message"]="Archivo no es válido";
                $_SESSION["typeMessage"]="error";
                header("Location:index.php?c=user&a=profile");
                return;
            }
            $product->setUrl_img($dir);
            if(isset($_REQUEST["id_p"])){
                $product->setId($_REQUEST["id_p"]);
                $status=$this->productDao->update($product);
                $_SESSION["message"]=($status>0)?"Editado exitosamente":"Error al editar";
                $_SESSION["typeMessage"]=($status>0)?"info":"error"; 
            }else{
                $status=$this->productDao->insert($product);
                $_SESSION["message"]=($status>0)?"Guardado exitosamente":"Error al guardar";
                $_SESSION["typeMessage"]=($status>0)?"info":"error"; 
            }
            header("Location:index.php?c=user&a=profile");
            return;
        }
    }
    public function view_insert(){
        $all_category=$this->productDao->queryCtg();
        $pageName="Porductos";
        $action=isset($_REQUEST["act"])?$_REQUEST["act"]:"Guardar";
        require_once COMPONENTS."formProduct.php";
    }
    public function change_status(){
    }

}