<?php

namespace App\Middleware;

use App\Core\Request;
use App\Core\View;
use Exception;

class Middleware
{
	public static $MAP = [
		"auth" => Auth::class,
		"guest" => Guest::class,
	];

	public static function handle(string|null $key)
	{
		if (isset($_SESSION["errors"])) {
			View::$globalVariable = [
				"errors" => $_SESSION["errors"],
			];
			unset($_SESSION["errors"]);
		} else {
			View::$globalVariable = [ "errors" => []];
		}
		static::handle_token();
		if ($key == null) {
			return;
		}
		if (!$key) {
			return;
		}
		if (!array_key_exists($key, static::$MAP)) {
			throw new Exception("Error: Not any Middleware associated with {$key}");
		}

		return (new static::$MAP[$key]())->handle();
	}

	public static function handle_token()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if (!Request::hasToken()) {
				throw new Exception("No token is given");
				exit;
			}
		}

	}
}
