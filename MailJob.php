<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 17.01.2019
 * Time: 13:37
 */

require_once 'vendor/autoload.php';

echo "-----------\r\nMailJob 0.1\r\n-----------\r\n\r\n";

use app\App;

$subject = null;
$data = null;
$files = array();

for($j = 1; $j < count($argv); $j++)
{
    switch($argv[$j])
    {
        case "--help":
            App::print_help();
            die();
        case "--data":
            $data = $argv[$j+1];
            $j++;
            break;

        case "--subject":
            $subject = $argv[$j+1];
            $j++;
            break;

        case "--attachment":
            for($k = $j+1; $k < count($argv); $k++)
            {
                if(substr($argv[$k], 0, 2) === "--")
                {
                    $j = $k-1;
                    break;
                }
                else
                {
                    array_push($files, $argv[$k]);
                }
            }
            break;

        default:
            break;
    }
}

if(is_null($subject))
{
    App::print_help("ERROR: --subject missing");
}

if(is_null($data))
{
    App::print_help("ERROR: --data missing");
}

App::run($subject, $data, $files);