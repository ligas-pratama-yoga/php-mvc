<?php

namespace App\Core;

use Exception;

class Validator
{
	public static array $errors;
	public static function validate(array $values)
	{
		$names = array_keys($values);

		static::findOrException($names);
		static::handle($values);
		if (static::$errors !== []) {
			dd(static::$errors);
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

		foreach ($values as $name => $value) {
			if ($value == "required") {
				if (Request::body()[$name] == "") {
					static::$errors[$name] = "Field {$name} is required";
				}
			}
		}
	}
}
