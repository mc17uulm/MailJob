<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 17.01.2019
 * Time: 13:38
 */

namespace app;

class App
{

    public static function run(string $subject, string $data, array $files) : void
    {

        Config::init($data);

        $mailer = new Mail($subject, $files);

        echo "\r\nStart sending mails...\r\n";
        $i = 1;
        $failures = 0;
        foreach(Config::get_data() as $recv)
        {
            echo "Sending mail no. $i to " . $recv["email"] . " : " . $recv["ansprache"] . "\r\n";
            $i++;
            ob_start();
            include ('Layout.php');
            $result = ob_get_contents();
            ob_end_clean();
            if(!$mailer->send($recv["email"], $recv["vorname"] . " " . $recv["nachname"], $result))
            {
                $failures++;
            }
        }

        echo "\r\n";
        echo $failures === 0 ? "\r\nSUCCESS: " . count(Config::get_data()) . " Jobs finished" : "\r\nFAILURE: $failures/" . count(Config::get_data()) . " jobs failed";
        
        die("\r\n\r\nProgram executed!");


    }

    public static function print_help(string $msg = null) : void
    {
        echo "Usage:\r\n\r\n";
        echo "--data\t\tSpecifies data file (json or csv)\r\n";
        echo "--subject\tSpecifies mail subject\r\n";
        echo "--attachment\t(Optional) One or multiple attachment files\r\n";
        echo "--help\t\tShows this help\r\n\r\n";
        echo !is_null($msg) ? "$msg" : "Program executed!";
        die();
    }


}