<?php
include_once 'config/config.php';
include_once "model/DAO/ProductDAO.php";
include_once "model/DTO/Product/Product.php";
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


    public function sessionStart(){
        if (!isset($_SESSION)) {
            session_start();
        }
    }
}