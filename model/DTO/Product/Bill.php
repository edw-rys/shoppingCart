<?php
class Bill{
    private $id_bill;
    private $id_user;
    private $price;
    private $date_sale;
    private $Sales;
    private $User;

    public function __construct(){}
    

    public function addSlaes($sales)
    {
        array_push($this->$Sales, $sales);
    }
    function getId_bill() {
        return $this->id_bill;
    }

    function getId_user() {
        return $this->id_user;
    }

    function getPrice() {
        return $this->price;
    }

    function getDate_sale() {
        return $this->date_sale;
    }

    function setId_bill($id_bill) {
        $this->id_bill = $id_bill;
    }

    function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setDate_sale($date_sale) {
        $this->date_sale = $date_sale;
    }
}