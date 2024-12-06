<?php

namespace App\Middleware;

use App\Core\Request;
use App\Models\Siswa;

class Auth
{
	public static function handle()
	{
		if (!array_key_exists("user", $_SESSION)) {
			return redirect("/login");
		}
		return;
	}
  public static function login(){
    // Cek apakah data ada
    $data = Siswa::all(condition: ["nama" => Request::body()["username"]]);
    if($data !== []): 
      $_SESSION["user"] = "Token";
      return;
    else: 
      header("Location: ". $_SERVER["HTTP_REFERER"]);
      exit;
    endif;
  }
  public static function attempts(array $credentials){
    $data = Siswa::all(condition: $credentials);
    if($data !== []): 
      $_SESSION["user"] = "Token";
      return;
    else: 
      header("Location: ". $_SERVER["HTTP_REFERER"]);
      exit;
    endif;
  }
}
