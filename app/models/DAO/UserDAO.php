<?php
include_once "app/models/DTO/User/User.php";
include_once "app/models/DTO/User/TypeUser.php";
class UserDAO{
    public function __construct(){
    }
    
    public function checkUserName(User $user ){
        try{
            return Model::queryByClass("select * from user where username=? and not (id_user=?)",
                                        array($user->getUsername(),$user->getId_user()),"User");
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function checkUser($username , $password){
            try{
            $resultSet = Model::queryByClass("select * from user where username=? and password=?",
                                        array($username , $password),"User");
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    
    public function getGenderUser($idUser){
        try{
            $resultSet = Model::query("SELECT name_gender , gender.id_gender from user inner join gender on gender.id_gender = user.id_gender where id_user=?",array($idUser));
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function insert(User $user){
        try{
            $parametros = array(
                $user->getUsername(),$user->getPassword(),$user->getName_user(),
                $user->getLast_name(),$user->getBirthdate(),$user->getMail(),
                $user->getId_gender(),$user->getId_country());
            return Model::query(
                "INSERT into user(username,password,name_user, last_name,birthdate, mail,id_gender,id_country)".
                " values (?,?,?,?,?,?,?,?);",
                $parametros
            );
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function update(User $user){
        try{
            $parametros = array(
                $user->getUsername(),$user->getPassword(),$user->getName_user(),
                $user->getLast_name(),$user->getBirthdate(),$user->getMail(),
                $user->getId_gender(),$user->getId_country(), $user->getId_user());
            return Model::query(
                "UPDATE user set username=? , password=? , name_user=? ,last_name=?,birthdate=?,".
                "mail=?, id_gender=? , id_country=? where id_user=?",
                $parametros
            );
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    // dar like producto deseado o eliminarlo
    public function like_product_by_user($idUser, $id_product){
        try{
            $parametros = array($idUser, $id_product);
            return Model::query("SELECT * from i_like where id_user=? and id_product=?",$parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function addLike($idUser, $id_product){
        try{
            $parametros = array($idUser, $id_product);
            return Model::query("INSERT into i_like(id_user,id_product) values(?,?)",$parametros );
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function removeLike($idUser, $id_product){
        try{
            $parametros = array($idUser, $id_product);
            return Model::query("delete from i_like where id_user=? and id_product=?",$parametros);
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
}