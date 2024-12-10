<?php

namespace App\Core;

use Exception;

class Validator
{
	public static array $errors = [];
	public static function validate(array $values)
	{
		$names = array_keys($values);

		static::findOrException($names);
		static::handle($values);
		if (isset($_SESSION["errors"])) {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
			exit;
		}
	}

	public static function findOrException($names)
	{
		foreach ($names as $name) {
			if (!isset(Request::body()[$name])) {
				throw new Exception("The key {$name} is not available in Request body!");
			}
		}

	}

	public static function handle($values)
	{
		//NOTE: Open for refactoring
		foreach ($values as $name => $value) {
			if (is_array($value)) {
				foreach ($value as $part) {
					if (isset(static::$errors[$name])) {
						continue;
					}
					if ($part == "required") {
						if (Request::body()[$name] == "") {
							static::$errors[$name] = "Field {$name} is required";
							$_SESSION["errors"][$name] = static::$errors[$name];
						}
					} elseif (preg_match("/min:([\d]+)/", $part, $matched)) {
						if (strlen(Request::body()[$name]) < (int) $matched[1]) {
							static::$errors[$name] = "Field {$name} minimal is $matched[1]";
							$_SESSION["errors"][$name] = static::$errors[$name];
						}
					} elseif (preg_match("/max:([\d]+)/", $part, $matched)) {
						if (strlen(Request::body()[$name]) > (int) $matched[1]) {
							static::$errors[$name] = "Field {$name} maximal is $matched[1]";
							$_SESSION["errors"][$name] = static::$errors[$name];
						}
					}

				}
			}
		}
	}
}
