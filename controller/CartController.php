<?php
include_once 'config/config.php';
require_once "controller/ProductController.php";
class CartController {
    private $productController;
    public function __construct() {
        $this->productController = new ProductController();
    }
    /* 
    * agregar item, se guarda en una variable de sesión
    * $_SESSION['items'] [  ["cant"=>cantidad, ]  "id_item"=> id ]
    */
    public function addItem(){
        if(isset($_REQUEST['item'])){
            if(!isset($_SESSION['items']))$_SESSION['items']=array();
            $items=$_SESSION['items'];
            $band=true;
            $i=0;
            foreach($items as $item){
                if( $item["id_item"] == $_REQUEST['item'] ){
                    $cant=$item["cant"]+1;
                    if(isset($_REQUEST['act']) && $_REQUEST['act']=="change"){
                        $cant=isset($_REQUEST['v'])?$_REQUEST['v']:1;
                    }
                    $item["cant"]=$cant;
                    $band=false;
                    $items[$i]= $item;
                    break;
                }
                $i++;
            }
            if($band)
                array_push($items, array("id_item"=>$_REQUEST['item'],"cant"=>1));
            $_SESSION['items'] = $items;
            // var_dump($items);
            echo count($items);
        }else{
            echo 0;
        }
    }    
    // retorna la cantidad de items que se han agregado
    public function count(){
        if(!isset($_SESSION['items']))$_SESSION['items']=array();
        $items=$_SESSION['items'];

        echo count($items);
    }  
    // obtiene los datos del producto por cada opción agregada
    public function get()
    {
        if(!isset($_SESSION['items']))$_SESSION['items']=array();
        $items=$_SESSION['items'];
        $products=array();
        foreach($items as $item){
            $product=array(
                        "product"=>$this->productController->getProductById($item["id_item"]),
                        "cant"=> $item["cant"]);
            array_push($products,$product);
        }
        echo json_encode($products);
    }
    // comprar
    // INCOMPLETA
    public function buy(){
        if(!isset($_SESSION['USER']))
            header("Location:index.php?c=index&a=static&p=login");
        
    }
    // elimina un item del carro
    public function removeItem(){
        if(isset($_REQUEST['item'])){
            if(!isset($_SESSION['items']))return 0;
            $items=$_SESSION['items'];
            $band=false;
            $i=0;
            foreach($items as $item){
                if( $item["id_item"] == $_REQUEST['item'] ){
                    array_splice($items,$i);
                    $band=true;
                    break;
                }
                $i++;
            }
            $_SESSION['items'] = $items;
            echo $band;
        }else{
            echo 0;
        }
    }
}
