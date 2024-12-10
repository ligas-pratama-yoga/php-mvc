<?php

use App\Core\View;

function base_path($path)
{
	return __DIR__ . "/../$path";
}


function dd($param)
{
	echo "<pre>";
	var_dump($param);
	echo "</pre>";
	die();
}

function view(string $name, ?array $variables = [], ?string $template = "index")
{
	extract($variables);
	return (new View())->render($name, $variables, $template);
}

function abort(int $status = 404)
{
	http_response_code($status);
	echo "<h1>$status</h1>";
	exit;
}
function paramToRegex($string, $uri)
{
	$pattern = "@\{(.*?)\}@";
	$result = preg_replace($pattern, "(\d+)", $string);
	$result = "@" . $result . "@";
	preg_match($result, $uri, $res);
	return $res;
}

function idWildcard($string, ?string $pattern = "@(\d+)@")
{
	return preg_replace($pattern, "{id}", $string);
}


function redirect(string $path)
{
	header("location: $path");
	exit;
}
function class_basename($class)
{
	return is_object($class) ? get_class($class) : $class;
}

function csrf()
{
	$token = "Hello";
	$_SESSION["token"] = $token;
	return "<input type='hidden' name='_token' value=$token>";
}

function method($name)
{
	return "<input type='hidden' name='_method' value={$name}>";
}
