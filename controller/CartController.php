<?php
include_once 'config/config.php';
class CartController {
    public function __construct() {}
    public function addItem(){
        // $_SESSION['items']=array(); 
        // echo $_REQUEST['item'];
        if(isset($_REQUEST['item'])){
            if(!isset($_SESSION['items']))$_SESSION['items']=array();
            $items=$_SESSION['items'];
            $band=true;
            $i=0;
            foreach($items as $item){
                if( $item["id_item"] == $_REQUEST['item'] ){
                    $item["cant"]=$item["cant"]+1;
                    $band=false;
                }
                $items[$i]= $item;
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
    public function count(){
        if(!isset($_SESSION['items']))$_SESSION['items']=array();
        $items=$_SESSION['items'];

        echo count($items);
    }  
}
