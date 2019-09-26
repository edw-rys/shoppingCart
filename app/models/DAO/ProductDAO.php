<?php
require_once "app/models/DTO/Product/Bill.php";
class ProductDAO{
    public function __construct(){}
    // Obtener las categorías
    public function queryCtg(){
        $query="SELECT * from category_p";
        try{
            return Model::query($query,[]);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // Obtener los productos
    public function query($query){
        $consulta="";
        $parametros=array();
        if(empty($query))
            $consulta="SELECT * from product WHERE status=1";
        else{
            $consulta="SELECT * from product where like CONCAT(%,?,%) and status=1";
            array_push($parametros,$query);
        }
        try{
            return Model::query($consulta,$parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // Obtener la información de la lista de deseos
    public function wishList($id_user){
        try{
            return Model::query("SELECT * from product inner join i_like on id_product=id_prod where status=1 and id_user=?", array($id_user));
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function isWishList($id_user, $id_prod){
        try{
            return Model::query("SELECT * from i_like where id_user=? and  id_product=? ", array($id_user, $id_prod));
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function AllCtgProduct(){
        try{            
            return Model::queryByClass( "SELECT * from category_p ", array() , "CategoryProduct_");
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getCtgProduct($id){
        try{
            $resultSet = Model::queryByClass( "SELECT * from category_p where id_ctg=?", array($id) , "CategoryProduct_");
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
        $consulta="";
        $parametros=array();
        if(empty($query)){
            $consulta="SELECT ".
            "id_prod , p.name_prod, p.description, p.url_img, p.price,p.discount,p.id_ctg_p,p.quantity ".
            "from i_like as il ".
            "inner join product as p on p.id_prod=il.id_product ".
            "where id_user=?;";
            $parametros=array($id_user);
        }else{
            $consulta="SELECT ".
            "id_prod , p.name_prod, p.description, p.url_img, p.price,p.discount,p.id_ctg_p ,p.quantity".
            "from i_like as il ".
            "inner join product as p on p.id_prod=il.id_product ".
            "where id_user=? and like CONCAT(%,?,%);";
            $parametros=array($id_user,$query);
        }
        try{
            return Model::query($consulta, $parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // productos que le gustaron al usuario
    public function queryForBuyout($id_user,$query){
        $consulta="";
        $parametros=array();
        if(empty($query)){
            $consulta="SELECT ".
            "id_product , p.name_prod, p.url_img, s.price as price_sale ,p.id_ctg_p ".
            "from sales as s ".
            "inner join product as p on p.id_prod=s.id_product ".
            "where id_user=?;";
            $parametros=array($id_user);
        }else{
            $consulta="SELECT ".
            "id_product , p.name_prod, p.url_img, s.price as price_sale ,p.id_ctg_p ".
            "from sales as s ".
            "inner join product as p on p.id_prod=s.id_product ".
            "where id_user=? and  p.name_prod like CONCAT(%,?,%);";
            $parametros=array($id_user,$query);
        }
        try{
            return Model::query($consulta, $parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }

    public function getBills($consulta){
        try{
            return Model::queryByClass($consulta, [],"Bill");
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
                $sentencia="SELECT * from bill";
                break;
            case 1:
                $sentencia="SELECT * from bill where date_sale like concat(%,?,%)";
                $parametros=array($query);
                break;
            case 2:
                // query by username, name or last name
                $sentencia="SELECT * from bill INNER JOIN user on user.id_user=bill.id_user where user.username like concat(%,?,%) or user.name_user like concat(%,?,%) or user.last_name like concat(%,?,%)";
                $parametros=array($query,$query,$query);
                break;
            default:
                $sentencia="SELECT * from bill";
                break;
        }
        
        $bills=$this->getBills($sentencia);
        foreach($bills as $bill){
            $sales=$this->querySalesByBill(
                "SELECT  B.id_bill, b.id_user, b.price as price_tot, b.date_sale, ".
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
        $sentencia="SELECT * from bill where id_user=?";
        $bills=$this->getBills($sentencia);
        foreach($bills as $bill){
            $sales=$this->querySalesByBill(
                "SELECT * from sales as s INNER join product as p on p.id_prod=s.id_product INNER JOIN category_p as ctg on ctg.id_ctg=p.id_ctg_p WHERE s.id_bill=?",
                array($bill->getId_bill())
            );
            if(!empty($sales))
            $bill->addSales($sales);
        }
        return $bills;
    }
    // 
    public function querySalesByBill($consulta, $parametros){
        try{
            return Model::query($consulta,$parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // Obtener producto por id
    public function queryById($id_product){
        try{
            $resultSet = Model::query("SELECT * from product as p inner join category_p as ctg on ctg.id_ctg = p.id_ctg_p where id_prod=? ", array($id_product));
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // Agregar producto
    public function insert(Product $product){
        try{
            $parametros = array(
                $product->getName(),$product->getDescription(),$product->getUrl_img(),
                $product->getQuantity(),$product->getPrice(),$product->getDiscount(),
                $product->getCategory());
            return Model::query("INSERT into product(name_prod, description, url_img, quantity , price,discount,id_ctg_p)".
                                " values (?,?,?,?,?,?,?)",$parametros );
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function update(Product $product){
        try{
            $parametros = array(
                $product->getName(),$product->getDescription(),$product->getUrl_img(),
                $product->getQuantity(),$product->getPrice(),$product->getDiscount(),
                $product->getCategory(), $product->getId());
            return Model::query(
                "UPDATE product set name_prod=? , description=? , url_img=? ,quantiy=?,price=?,".
                "discount=?, id_ctg_p=?  where id_prod=?;",$parametros
            );
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function changeStatus($id_product,$status){
        try{
            return Model::query("UPDATE product set status=?  where id_prod=?;",array($id_product,$status));
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
}