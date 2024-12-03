<?php

namespace App\Middleware;

class Auth
{
	public static function handle()
	{
		if (!array_key_exists("user", $_SESSION)) {
			return redirect("/login");
		}
		return;
	}
}
