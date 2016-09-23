<?php

class Database {
    public $connecting_link = null;
    
    private $mysql_host = MYSQL_HOST;
    private $mysql_username = MYSQL_USERNAME;
    private $mysql_password = MYSQL_PASSWORD;
    private $mysql_db = MYSQL_DB;
    
    public function __construct(){
        $connect_string = mysqli_connect($this->mysql_host, $this->mysql_username, $this->mysql_password, $this->mysql_db) or die(mysqli_connect_error());
        $this->connecting_link = $connect_string;
    }
    
    public function setConnect($mysql_host,$mysql_username,$mysql_password,$mysql_db){
        $connect_string = mysqli_connect($mysql_host, $mysql_username, $mysql_password, $mysql_db) or die(mysqli_connect_error());
        $this->connecting_link = $connect_string;
    }
    
    public function getConnect(){
        return $this->connecting_link;
    }
    
    public function __destruct() {
        if($this->connecting_link != NULL){
            mysqli_close($this->connecting_link);
        }
    }
}