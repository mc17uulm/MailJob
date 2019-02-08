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
    private static $data;
    private static $data_type;

    public static function init(string $data)
    {
        $file = require (__DIR__ . "/ConfigFile.php");
        
        self::$host = $file["host"];
        self::$user = $file["user"];
        self::$password = $file["password"];
        self::$port = $file["port"];
        self::$tls = $file["tls"];
        self::$from_mail = $file["from_mail"];
        self::$from_name = $file["from_name"];

        self::parse_data($data);

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

    public static function get_data() : array
    {
        return self::$data;
    }

    public static function get_data_type() : string
    {
        return self::$data_type;
    }

    private static function parse_data(string $data) : void
    {
        echo "- Load data file\r\n";

        $info = pathinfo($data);
        if(isset($info["extension"]))
        {
            self::$data_type = pathinfo($data)["extension"];
            switch (self::$data_type)
            {
                case "csv":
                    self::$data = self::parse_csv(file_get_contents($data));
                    break;
                case "json":
                    self::$data = self::parse_json(file_get_contents($data));
                    break;
                default:
                    App::print_help("ERROR: invalid file type " . self::$data_type . ". Only .csv and .json allowed");
            }
        }
        else
        {
            App::print_help("ERROR: invalid file type. Only .csv and .json allowed");
        }

    }

    private static function parse_csv(string $data) : array
    {
        $d = explode("\r\n", $data);
        $body = array();
        if(count($d) > 1) {

            echo "- Found " . (count($d) - 1) . " data sets in .csv file\r\n";

            $header = explode(";", array_shift($d));
            foreach ($d as $line) {
                $parts = explode(";", $line);
                $tmp = array();
                for ($i = 0; $i < count($parts); $i++) {
                    $tmp[$header[$i]] = $parts[$i];
                }
                array_push($body, $tmp);
            }

            return $body;
        }
        App::print_help("ERROR: Found no data in .csv file");
    }

    private static function parse_json(string $data) : array
    {
        return json_decode($data, true);
    }
    
    

}