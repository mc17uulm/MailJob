<?php
/**
 * Created by PhpStorm.
 * User: mc17uulm
 * Date: 12.02.2019
 * Time: 19:13
 */

require_once '../../vendor/autoload.php';

$person = new \app\grammar\Person(3, true, true);
$out = \app\grammar\Grammar::beautify($person, \app\grammar\Casus::DATIV());

echo $out;