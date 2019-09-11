<?php
include_once "model/DTO/Product/product.php";
include_once "model/DTO/Product/CategoryProduct.php";
include_once "model/Connection.php";
class ProductDAO{
    private $connection;
    public function __construct(){
        $this->connection =  Connection::getConnection();
    }
    // Obtener los productos
    public function query($query){
        if(!$this->connection) return null;
        $consulta="";
        $parametros=array();
        if(empty($query))
            $consulta="select * from product";
        else{
            $consulta="select * from product where like CONCAT(%,?,%)";
            array_push($parametros,$query);
        }
        try{
            $sentencia = $this->connection->prepare($consulta);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // Obtener la información de la lista de deseos
    public function wishList($id_user){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from product inner join i_like on id_product=id_prod where id_user=?");
            $parametros = array($id_user);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function isWishList($id_user, $id_prod){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from i_like where id_user=? and  id_product=?");
            $parametros = array($id_user, $id_prod);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function AllCtgProduct(){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from category_p ");            
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"CategoryProduct");
            
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getCtgProduct($id){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from category_p where id_ctg=?");            
            $parametros = array($id);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"CategoryProduct");
            if(!empty($resultSet))
            return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getProducts($query){
        $products=$this->query($query);
        return $this->getProductsClass($products);
    }
    public function getProductsClass($products){
        $listProducts=array();
        if(!$products)return null;
        foreach($products as $p){
            $prod =new Product();
            $prod->setId( $p->id_prod );
            $prod->setName($p->name_prod);
            $prod->setDescription($p->description);
            $prod->setUrl_img($p->url_img);
            $prod->setQuantity($p->quantity);
            $prod->setPrice($p->price);
            $prod->setDiscount($p->discount);
            $ctg=$this->getCtgProduct($p->id_ctg_p);

            $id_user=isset($_SESSION['ID_USER'])?$_SESSION['ID_USER']:0;
            $is_list=$this->isWishList($id_user , $prod->getId() );
            $prod->setI_like(empty( $is_list)?false:true);
            $prod->setCategory($ctg);
            array_push( $listProducts,$prod);
        }
        return $listProducts;
    }
}