<?php

namespace App\Core;

class Router
{
	protected static array $routes;
	/**
	 * @param string $uri
	 * @return mixed
	 */
	protected function handle_callback(string $uri, ?array $vars = [])
	{
		$method = Request::method();
		$id = ($vars == []) ? [] : $vars[1];
		if (is_array($this->callback($method, $uri))) {
			return $this->call_callback($method, $uri, $id);
		}
		if (is_string($this->callback($method, $uri))) {
			return view($this->callback($method, $uri), []);
		}

		return call_user_func($this->callback($method, $uri), $id);
	}


	protected function callback(string $method, string $uri): mixed
	{
		return static::$routes[$method][$uri]["callback"];
	}
	protected function callback_class(string $method, string $uri): mixed
	{
		return static::$routes[$method][$uri]["callback"][0];
	}
	protected function callback_action(string $method, string $uri): mixed
	{
		return static::$routes[$method][$uri]["callback"][1];
	}
	/**
	 * @return mixed
	 */
	protected function call_callback(string $method, string $uri, int|array $id)
	{
		return call_user_func([(new ($this->callback_class($method, $uri))), $this->callback_action($method, $uri)], $id);
	}

  public function handle_path(){

		preg_match('@(\d+)@', Request::uri(), $id);
		$uri = idWildcard(Request::uri()) ?? Request::uri();
		return [$id, $uri];
  }
  
	protected function findOrAbort(string $key): null
	{
		if (!array_key_exists(array: static::$routes[Request::method()], key: $key)) {
			return abort();
		}
		return null;
	}
	protected function middleware(string $method, string $uri): mixed
	{
		return static::$routes[$method][$uri]["middleware"];
	}
}
