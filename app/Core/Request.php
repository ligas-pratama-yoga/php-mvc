<?php

namespace App\Core;

use Exception;

class Request
{
	/**
	 * @return array|string|int|null|bool
	 */
	public static function uri(): array|string|int|null|bool
	{
		return parse_url($_SERVER['REQUEST_URI'])['path'];
	}

	public static function is(string $path): bool
	{
		return self::uri() == $path;
	}

	public static function method(): string
	{
		return $_REQUEST["_method"] ?? strtolower($_SERVER['REQUEST_METHOD']);
	}
	public static function token(): string
	{
		return $_REQUEST["_token"] ?? null;
	}
	public static function body(): array
	{
		$data = [];
		$bodies = $_REQUEST;
		array_pop($bodies);
		foreach ($bodies as $name => $body) {
			$data[$name] = $body;
			if ($name == "_method" || $name == "_token") {
				continue;
			}
		}
		return $data;
	}

	public static function hasToken(): bool
	{
		return $_POST["_token"] ?? false;
	}

}
