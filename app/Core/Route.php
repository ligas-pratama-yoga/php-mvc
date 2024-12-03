<?php

namespace App\Core;

use App\Middleware\Middleware;

class Route extends Router
{
	public static function add(string $method, string $path, callable|string|array $callback): array
	{
		return static::$routes[$method][$path] = [
			"callback" => $callback,
			"middleware" => null,
		];
	}
	/**
	 * @param callable(): mixed $callback
	 */
	public static function get(string $path, callable|string|array $callback): Route
	{
		static::add("get", $path, $callback);
		return (new self());
	}
	/**
	 * @param callable(): mixed $callback
	 */
	public static function post(string $path, callable|string|array $callback): Route
	{
		static::add("post", $path, $callback);
		return (new self());
	}
	/**
	 * @param callable(): mixed $callback
	 */
	public static function patch(string $path, callable|string|array $callback): Route
	{
		static::add("patch", $path, $callback);
		return (new self());
	}
	/**
	 * @param callable(): mixed $callback
	 */
	public static function delete(string $path, callable|string|array $callback): Route
	{
		static::add("delete", $path, $callback);
		return (new self());
	}

	public function only(string $key): Route
	{
		$method = array_key_last(static::$routes);
		$method_array = static::$routes[$method];
		$uri = array_key_last($method_array);
		static::$routes[$method][$uri]["middleware"] = $key;
		return $this;
	}

	public static function run(): Route|null
	{
		$class = (new self());
		[$id, $uri]  = $class->handle_path();
		$method = Request::method();
		$class->findOrAbort($uri);
		Middleware::handle($class->middleware($method, $uri));
		echo $class->handle_callback($uri, $id);

		return $class;
	}
}
