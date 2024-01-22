<?php 
namespace admin;
class HTTP
{
    static $base = "http://localhost/Login-registration-Form";
    
    static function redirect($path, $query ="")
    {
        $url = static::$base . $path;
        if($query) $url .= "?$query";

        header("location: $url");
        exit();
    }
}
