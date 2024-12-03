<?php

namespace App\Middleware;

use App\Core\Request;
use Exception;

class Middleware
{
	public static $MAP = [
		"auth" => Auth::class,
		"guest" => Guest::class,
	];

	public static function handle(string|null $key)
	{
		static::handle_token();
		if (!$key) {
			return;
		}
		if (!array_key_exists($key, static::$MAP)) {
			throw new Exception("Error: Not any Middleware associated with {$key}");
		}
		if ($key == null) {
			return;
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
