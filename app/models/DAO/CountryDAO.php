<?php
// namespace DAO ;
class CountryDAO{
    public function __construct(){
    }
    // País
    public function getCountryById($id_country){
        try{
            $resultSet = Model::query('SELECT * from country where id_country=?',array($id_country));
            if(!empty($resultSet))
                return $resultSet[0];
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getAllCountry($id_continent){
        try{
            $resultSet = Model::query('SELECT * from country where id_continent=?',array($id_continent));
            return $resultSet;
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function getAllContinents(){
        try{
            return Model::query('SELECT * from continent',array());
        }catch(Exception $e){
            die($e->getMessage());
            die($e->getTrace()); // traza del error
        }
    }
    public function geData(){
        $dataC=$this->getAllContinents();
        $continents=array();
        // print_r($dataC);
        foreach($dataC as $c){
            $data=array($c);
            $countries=$this->getAllCountry($c->id_continent);
            
            array_push($data, $countries);
            array_push($continents,$data);
        }
        
        // echo "<pre>";
        // print_r($continents);
        // echo "</pre>";
        return $continents;
    }
}