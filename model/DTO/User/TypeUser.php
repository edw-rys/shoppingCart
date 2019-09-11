<?php
class CategoryProduct{
    private $id_typeuser;
    private $name;
    public function __construct(){}
        function getId_typeuser() {
            return $this->id_typeuser;
        }
    
        function getName() {
            return $this->name;
        }
    
        function setId_typeuser($id_typeuser) {
            $this->id_typeuser = $id_typeuser;
        }
    
        function setName($name) {
            $this->name = $name;
        }
}