<?php
namespace admin;

class Auth {
    static $loginUrl = '../index.php';

    static function check(){
        if(isset($_SESSION['user_array'])){
            return $_SESSION['user_array'];
            if($_SESSION['user_array']['role'] !== 'admin'){
               HTTP::redirect("/dashboard/user-dashboard.php");
            }
        }else{
            HTTP::redirect("login.php");
        }
    }
}