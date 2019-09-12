<?php
include_once "model/DTO/User/User.php";
include_once "model/DTO/User/TypeUser.php";
include_once "model/Connection.php";
class UserDAO{
    private $connection;
    public function __construct(){
        $this->connection =  Connection::getConnection();
    }
    public function checkUserName(User $user ){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from user where username=? and not (id_user=?)");
            // print_r($user);
            
            $parametros = array($user->getUsername(),$user->getId_user());
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"User");
            // print_r($resultSet);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function checkUser($username , $password){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from user where username=? and password=?");
            $parametros = array($username, $password);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"User");
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    
    public function getGenderUser($idUser){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select name_gender , gender.id_gender from user inner join gender on gender.id_gender = user.id_gender where id_user=?");
            $parametros = array($idUser);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function insert(User $user){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare(
                "insert into user(username,password,name_user, last_name,birthdate, mail,id_gender,id_country)".
                " values (?,?,?,?,?,?,?,?);");

            $parametros = array(
                $user->getUsername(),$user->getPassword(),$user->getName_user(),
                $user->getLast_name(),$user->getBirthdate(),$user->getMail(),
                $user->getId_gender(),$user->getId_country());

            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function update(User $user){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare(
                "update user set username=? , password=? , name_user=? ,last_name=?,birthdate=?,".
                "mail=?, id_gender=? , id_country=? where id_user=?");

            $parametros = array(
                $user->getUsername(),$user->getPassword(),$user->getName_user(),
                $user->getLast_name(),$user->getBirthdate(),$user->getMail(),
                $user->getId_gender(),$user->getId_country(), $user->getId_user());

            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
}