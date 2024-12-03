<?php

session_start();

require __DIR__ . "/../helper/functions.php";
require base_path("vendor/autoload.php");
/*require base_path("routes/web.php");*/

$string = "@define(title, 'Hello')";

preg_match("/@define\([\w\s,\']+\)/", $string, $match);
preg_match("/\([\w\s,\']+\)/", $match[0], $match2);
dd($match2);
