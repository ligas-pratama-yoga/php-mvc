<?php


session_start();

require __DIR__ . "/../helper/functions.php";
require base_path("vendor/autoload.php");
require base_path("routes/web.php");

/*$string = "@define(title, 'Hello')";*/
/**/
/*preg_match("/@define\([\w\s,\']+\)/", $string, $match);*/
/*preg_match("/\([\w\s,\']+\)/", $match[0], $match2);*/
/*dd($match2);*/

/*function start()*/
/*{*/
/*	ob_start();*/
/*	echo "Starting ob...";*/
/*}*/
/**/
/*function end_get()*/
/*{*/
/*	return ob_get_clean();*/
/*}*/
/**/
/*start();*/
/*echo "Hello";*/
/*$output = end_get();*/
/*dd($output);*/

/*$content = "@error('name') @error('kuantitas')";*/
/*$result = "";*/
/*/*dd(strpos($content, "@error"));*/
/*$length = strlen("@error('name')");*/
/*$pos = strrpos($content, "@error('name')") + $length;*/
/*$arr = str_split($content, $pos);*/
/*/*dd($arr);*/
/**/
/*preg_match_all("/@error\(['\"]([\w]+)['\"]\)/", $content, $matchAll);*/
/*foreach ($matchAll[1] as $key) {*/
/*  $content = str_replace("@error('$key')", "$key", $content);*/
/*}*/
/*dd($content);*/
