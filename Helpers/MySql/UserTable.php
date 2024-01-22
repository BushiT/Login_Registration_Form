<?php
namespace MySql;
use PDO;
use PDOException;

class UserTable
{
 private $db;

 public function __construct(DBConnect $db) {
    $this->db = $db->connect();
 }
    public function insert($data){
        try{
            $query = "INSERT INTO users(name,email,password,address) VALUES(:name, :email, :enCrpt, :address)";

            $statement = $this->db->prepare($query);
            $statement->execute($data);
           
 
           return $this->db->lastInsertId();
         } catch(PDOException $e){
            return $e->getMessage();
        }
    }

    public function findByEmailAndpassword($email,$password) {
        $query = "SELECT * FROM users WHERE :email = email AND :password = password";
        $statement = $this->db->prepare($query);
        $statement->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        return $statement->fetch();
    }

    public function updateData($data){
        $query = "UPDATE users SET name=:update_name, email=:update_email, address=:update_address WHERE id=:update_id";
        $statement = $this->db->prepare($query);

        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function getAll(){
       //apply user data in table
        $query = "SELECT * FROM users ";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function edit(){
        $edit_User_Data = $_GET['editUserDataId'];
        $statement = $this->db->prepare("SELECT * FROM users WHERE id='$edit_User_Data'");
        $statement->execute();
        return $statement->fetch();
    }

    public function updateDataAdmin($data){
        $query = "UPDATE users SET name=:name, email=:email, address=:address,role=:role WHERE id=:id";
        $statement = $this->db->prepare($query);

        $statement->execute($data);
        return $this->db->lastInsertId();
    }

    public function deleteUser(){
        $editId = $_GET['DeleteUserDataId'];
        $statement = $this->db->prepare("DELETE FROM users WHERE id='$editId'");
        $statement->execute();
        //return $statement->fetch();
    }
    } 