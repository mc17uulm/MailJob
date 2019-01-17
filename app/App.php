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

    public static function run(string $subject, array $files)
    {

        echo "MailJob 0.1 started!\r\n\r\n";

        Config::init();

        echo "- Load .csv file\r\n";
        $data = explode("\r\n", file_get_contents(__DIR__ . "/../data.csv"));
        if(count($data) > 1)
        {

            echo "- Found " . (count($data)-1) . " data sets in .csv file\r\n";

            $header = explode(";", array_shift($data));
            $body = array();
            foreach($data as $line)
            {
                $parts = explode(";", $line);
                $tmp = array();
                for($i = 0; $i < count($parts); $i++)
                {
                    $tmp[$header[$i]] = $parts[$i];
                }
                array_push($body, $tmp);
            }

            $mailer = new Mail($subject, $files);

            echo "\r\nStart sending mails...\r\n";
            $i = 1;
            $failures = 0;
            foreach($body as $recv)
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
            echo $failures === 0 ? "\r\nSUCCESS: " . count($body) . " Jobs finished" : "\r\nFAILURE: $failures/" . count($body) . " jobs failed";
            die("\r\n\r\nProgram executed!");


        }

        die("ERROR: Found no data in .csv file");

    }


}