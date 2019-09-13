<?php
require_once 'config/config.php';
require_once "model/DTO/Product/Product.php";
// require_once "model/DTO/Product/CategoryProduct_.php";
require_once "model/DAO/ProductDAO.php";
class ProductController{
    private $productDao;
    public function __construct(){
        $this->productDao=new ProductDAO();
    }
    public function query(){
        $this->sessionStart();
        $criterio= isset($_REQUEST['search'])?$_REQUEST['search']:"";
        $listProducts=$this->productDao->getProducts($criterio);
        $listCtgProd=$this->productDao->AllCtgProduct();


        $this->page($listProducts, $listCtgProd);
    }
    public function page($listProducts,$listCtgProd){
        $pageName="Productos";
        require_once HEADER;
        require_once "view/Product/Product.php";
        require_once FOOTER;
    }

    public function products_like($idUser,$query){
        $products = $this->productDao->queryForLike($idUser,$query);
        return $this->productDao->getProductsClass($products);
    }



    public function getBill(){
        if(isset($_SESSION['USER'])){
            $user=$_SESSION['USER'];
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
            $pageName="Ventas";
            require_once HEADER;
            require_once "view/Product/Sales.php";
            require_once FOOTER;
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
}