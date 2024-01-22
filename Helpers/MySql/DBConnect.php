<?php
namespace MySql;
use PDO;
use PDOException;

class DBConnect 
{

private $db;
private $dbhost;
private $dbname;
private $dbuser;
private $dbpass;

public function __construct(
    $db=null,$dbhost = "localhost", $dbname = "basic_registration_form", $dbuser = "root", $dbpass = "",
) {
    $this->db = $db;
    $this->dbhost = $dbhost;
    $this->dbname = $dbname;
    $this->dbuser = $dbuser;
    $this->dbpass = $dbpass;
}

public function connect(){
    try{
        $db = new PDO("mysql:host=$this->dbhost; dbname=$this->dbname", $this->dbuser, $this->dbpass, [
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
            //PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_OBJ,
        ]);
        return $db;
    }catch(PDOException $e){
        return $e->getMessage(); 
    }
}
}
