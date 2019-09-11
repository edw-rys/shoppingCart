<?php
class User{
    private $id_user;
    private $name_user;
    private $username;
    private $password;
    private $last_name;
    private $bithday;
    private $mail;
    private $id_gener;
    private $id_country;
    private $id_typeuser;
    public function __construct(){}
    
        function getId_user() {
            return $this->id_user;
        }
    
        function getName_user() {
            return $this->name_user;
        }
    
        function getUsername() {
            return $this->username;
        }
    
        function getPassword() {
            return $this->password;
        }
    
        function getLast_name() {
            return $this->last_name;
        }
    
        function getBithday() {
            return $this->bithday;
        }
    
        function getMail() {
            return $this->mail;
        }
    
        function getId_gener() {
            return $this->id_gener;
        }
    
        function getId_country() {
            return $this->id_country;
        }
    
        function getId_typeuser() {
            return $this->id_typeuser;
        }
    
        function setId_user($id_user) {
            $this->id_user = $id_user;
        }
    
        function setName_user($name_user) {
            $this->name_user = $name_user;
        }
    
        function setUsername($username) {
            $this->username = $username;
        }
    
        function setPassword($password) {
            $this->password = $password;
        }
    
        function setLast_name($last_name) {
            $this->last_name = $last_name;
        }
    
        function setBithday($bithday) {
            $this->bithday = $bithday;
        }
    
        function setMail($mail) {
            $this->mail = $mail;
        }
    
        function setId_gener($id_gener) {
            $this->id_gener = $id_gener;
        }
    
        function setId_country($id_country) {
            $this->id_country = $id_country;
        }
    
        function setId_typeuser($id_typeuser) {
            $this->id_typeuser = $id_typeuser;
        }
}