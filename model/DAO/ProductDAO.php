<?php
require_once "model/DTO/Product/product.php";
require_once "model/DTO/Product/Bill.php";
require_once "model/Connection.php";
require_once "model/DTO/Product/CategoryProduct_.php";
// require_once "model/DAO/UserDAO.php";

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
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"CategoryProduct_");
            
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
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"CategoryProduct_");
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

    // productos que le gustaron al usuario
    public function queryForLike($id_user,$query){
        if(!$this->connection) return null;
        $consulta="";
        $parametros=array();
        if(empty($query)){
            $consulta="select ".
            "id_prod , p.name_prod, p.description, p.url_img, p.price,p.discount,p.id_ctg_p,p.quantity ".
            "from i_like as il ".
            "inner join product as p on p.id_prod=il.id_product ".
            "where id_user=?;";
            $parametros=array($id_user);
        }else{
            $consulta="select ".
            "id_prod , p.name_prod, p.description, p.url_img, p.price,p.discount,p.id_ctg_p ,p.quantity".
            "from i_like as il ".
            "inner join product as p on p.id_prod=il.id_product ".
            "where id_user=? and like CONCAT(%,?,%);";
            $parametros=array($id_user,$query);
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
    // productos que le gustaron al usuario
    public function queryForBuyout($id_user,$query){
        if(!$this->connection) return null;
        $consulta="";
        $parametros=array();
        if(empty($query)){
            $consulta="select ".
            "id_product , p.name_prod, p.url_img, s.price as price_sale ,p.id_ctg_p ".
            "from sales as s ".
            "inner join product as p on p.id_prod=s.id_product ".
            "where id_user=?;";
            $parametros=array($id_user);
        }else{
            $consulta="select ".
            "id_product , p.name_prod, p.url_img, s.price as price_sale ,p.id_ctg_p ".
            "from sales as s ".
            "inner join product as p on p.id_prod=s.id_product ".
            "where id_user=? and  p.name_prod like CONCAT(%,?,%);";
            $parametros=array($id_user,$query);
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

    public function getBills($consulta){
        if(!$this->connection) return null;
        
        try{
            $sentencia = $this->connection->prepare($consulta);
            $parametros=array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"Bill");
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // filtro-> 0. ni uno , 1. fecha, 2. usuario
    public function getAllBill($filter,$query){
        $parametros=array();
        switch($filter){
            case 0:
                $sentencia="select * from bill";
                break;
            case 1:
                $sentencia="select * from bill where date_sale like concat(%,?,%)";
                $parametros=array($query);
                break;
            case 2:
                // query by username, name or last name
                $sentencia="select * from bill INNER JOIN user on user.id_user=bill.id_user where user.username like concat(%,?,%) or user.name_user like concat(%,?,%) or user.last_name like concat(%,?,%)";
                $parametros=array($query,$query,$query);
                break;
            default:
                $sentencia="select * from bill";
                break;
        }
        
        $bills=$this->getBills($sentencia);
        foreach($bills as $bill){
            $sales=$this->querySalesByBill(
                "select  B.id_bill, b.id_user, b.price as price_tot, b.date_sale, ".
                "s.id_sale, s.price as price_sale, s.quantity_sale ,".
                "p.id_prod,p.name_prod, p.description , p.url_img,p.quantity, p.price as price_product, ".
                "ctg.id_ctg,ctg.name_ctg,us.id_user, us.username, us.name_user, us.last_name, us.birthdate, us.mail, ".
                "g.id_gender, g.name_gender,c.id_country, c.name_cy,cont.id_continent, cont.name_ct ".
                "from bill as b ".
                "INNER JOIN sales as s on s.id_bill = b.id_bill ".
                "INNER join product as p on p.id_prod=s.id_product ".
                "INNER JOIN category_p as ctg on ctg.id_ctg=p.id_ctg_p ".
                "INNER JOIN user as us on us.id_user=b.id_user ".
                "INNER JOIN country as c on c.id_country=us.id_country ".
                "INNER JOIN continent as cont on cont.id_continent=c.id_continent ".
                "INNER JOIN gender as g on g.id_gender=us.id_gender  ".
                "WHERE s.id_bill=?"
                ,
                array($bill->getId_bill())
            );
            // var_dump($sales);
            if(!empty($sales))
                $bill->setSales($sales);
        }
        return $bills;
    }
    public function getBillByClient($idUser){
        $sentencia="select * from bill where id_user=?";
        $bills=$this->getBills($sentencia);
        foreach($bills as $bill){
            $sales=$this->querySalesByBill(
                "select * from sales as s INNER join product as p on p.id_prod=s.id_product INNER JOIN category_p as ctg on ctg.id_ctg=p.id_ctg_p WHERE s.id_bill=?",
                array($bill->getId_bill())
            );
            if(!empty($sales))
            $bill->addSales($sales);
        }
        return $bills;
    }
    // 
    public function querySalesByBill($consulta, $parametros){
        if(!$this->connection) return null;
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
    // Obtener producto por id
    public function queryById($id_product){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from product as p inner join category_p as ctg on ctg.id_ctg = p.id_ctg_p where id_prod=? " );
            $parametros=array($id_product);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
}