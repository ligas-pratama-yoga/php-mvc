<?php

use App\Core\View;

session_start();

require __DIR__ . "/../helper/functions.php";
require base_path("vendor/autoload.php");
require base_path("routes/web.php");

/*echo View::render("index");*/


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






/*$_SESSION["user"] = "Ligas";*/
/*class Request*/
/*{*/
/*	// Request properties and methods*/
/*}*/
/**/
/*class Response*/
/*{*/
/*	protected $content = "Hello";*/
/**/
/*	public function setContent($content)*/
/*	{*/
/*		$this->content = $content;*/
/*		return $this;*/
/*	}*/
/**/
/*	public function send()*/
/*	{*/
/*		echo $this->content . "<br>";*/
/*	}*/
/*}*/
/**/
/*class AuthMiddleware*/
/*{*/
/*	public function handle($request, $next)*/
/*	{*/
/*		// Check authentication*/
/*		if (!isset($_SESSION['user'])) {*/
/*			return (new Response())->setContent("Unauthorized");*/
/*		}*/
/*		return $next($request);*/
/*	}*/
/*}*/
/**/
/*class LoggingMiddleware*/
/*{*/
/*	public function handle($request, $next)*/
/*	{*/
/*		// Log request details*/
/*		(new Response())->setContent("Request Received")->send();*/
/*		return $next($request);*/
/*	}*/
/*}*/
/**/
/*function handleRequest($request, $middlewares)*/
/*{*/
/*	$next = function ($request) {*/
/*		// Final response*/
/*		return (new Response())->setContent("Hello, World!")->send();*/
/*	};*/
/**/
/*	// Execute middleware in reverse order*/
/*	foreach (array_reverse($middlewares) as $middleware) {*/
/*		$currentNext = $next;*/
/*		$next = function ($request) use ($middleware, $currentNext) {*/
/*			return $middleware->handle($request, $currentNext);*/
/*		};*/
/*	}*/
/**/
/*	// Start the middleware chain*/
/*	return $next($request);*/
/*}*/
/**/
/*$request = new Request();*/
/*$middlewares = [*/
/*	new LoggingMiddleware(),*/
/*	new AuthMiddleware(),*/
/*];*/
/**/
/*// Handle the request*/
/*$response = handleRequest($request, $middlewares);*/
/*$response->send();*/
