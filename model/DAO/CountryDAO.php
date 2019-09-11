<?php

include_once "model/Connection.php";
class CountryDAO{
    private $connection;
    public function __construct(){
        $this->connection =  Connection::getConnection();
    }
    // País

    public function getAllCountry($id_continent){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from country where id_continent=?");
            $parametros = array($id_continent);
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getAllContinents(){
        if(!$this->connection) return null;
        try{
            $sentencia = $this->connection->prepare("select * from continent ");
            $parametros = array();
            $sentencia->execute($parametros);
            $resultSet = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function geData(){
        $dataC=$this->getAllContinents();
        $continents=array();
        foreach($dataC as $c){
            $data=array($c);
            $countries=$this->getAllCountry($c->id_continent);

            array_push($data, $countries);
            array_push($continents,$data);
        }
        return $continents;
    }
}