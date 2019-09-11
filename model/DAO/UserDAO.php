<?php
include_once "model/DTO/User/User.php";
include_once "model/DTO/User/TypeUser.php";
include_once "model/Connection.php";
class UserDAO{
    private $connection;
    public function __construct(){
        $this->connection =  Connection::getConnection();
    }
    public function checkUserName($username ){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from user where username=? ");
            $parametros = array($username);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_CLASS,"User");
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
    public function insert(User $user){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare(
                "insert into user(username,password,name_user, last_name,birthdate, mail,id_gender,id_country)".
                " values (?,?,?,?,?,?,?,?);");

            $parametros = array(
                $user->getUsername(),$user->getPassword(),$user->getName_user(),
                $user->getLast_name(),$user->getBithday(),$user->getMail(),
                $user->getId_gener(),$user->getId_country());

            $sentencia->execute($parametros);
            $sentencia->closeCursor();
            return $sentencia->rowCount();
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
}