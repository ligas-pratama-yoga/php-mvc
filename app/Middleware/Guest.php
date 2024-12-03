<?php

namespace App\Middleware;

class Guest
{
	public static function handle()
	{
		if (array_key_exists("user", $_SESSION)) {
			return redirect("/");
		}
		return;
	}
}
