<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 17.01.2019
 * Time: 13:37
 */

require_once 'vendor/autoload.php';

$subject = -1;
$files = array();

for($j = 1; $j < count($argv); $j++)
{
    switch($argv[$j])
    {
        case "subject":
            $subject = $argv[$j+1];
            $j++;
            break;

        case "files":
            for($k = $j+1; $k < count($argv); $k++)
            {
                if($argv[$k] === "subject")
                {
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

if(($subject === -1))
{
    die("Invalid parameters");
}

\app\App::run($subject, $files);