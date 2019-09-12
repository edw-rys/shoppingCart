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
    public function products_buyout($idUser,$query){
        return $this->productDao->queryForBuyout($idUser,$query);
    }
    public function products_Sale($query){
        return $this->productDao->queryForSale($query);
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