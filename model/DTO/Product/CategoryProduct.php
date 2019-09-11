<?php
class CategoryProduct{
    private $id_ctg;
    private $name_ctg;
    public function __construct(){}
    function getId() {
        return $this->id_ctg;
    }
    
    function getName() {
        return $this->name_ctg;
    }
    
    function setId($id) {
        $this->id_ctg = $id;
    }
    
    function setName($name) {
        $this->name = $name_ctg;
    }
}