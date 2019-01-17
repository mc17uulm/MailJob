<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 17.01.2019
 * Time: 13:38
 */

namespace app;

class Config
{

    private static $host;
    private static $user;
    private static $password;
    private static $port;
    private static $tls;
    private static $from_mail;
    private static $from_name;

    public static function init()
    {
        $file = require (__DIR__ . "/ConfigFile.php");
        
        self::$host = $file["host"];
        self::$user = $file["user"];
        self::$password = $file["password"];
        self::$port = $file["port"];
        self::$tls = $file["tls"];
        self::$from_mail = $file["from_mail"];
        self::$from_name = $file["from_name"];

        echo "- Loaded config\r\n";
        
    }

    public static function get_host() : string
    {
        return self::$host;
    }

    public static function get_user() : string
    {
        return self::$user;
    }

    public static function get_password() : string
    {
        return self::$password;
    }

    public static function get_port() : int
    {
        return self::$port;
    }

    public static function get_tls() : bool
    {
        return self::$tls;
    }

    public static function get_from_mail() : string
    {
        return self::$from_mail;
    }

   
    public static function get_from_name() : string
    {
        return self::$from_name;
    }
    
    

}