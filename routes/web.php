<?php

use App\Core\Request;
use App\Core\Route;
use App\Core\Validator;
use App\Middleware\Auth;
use App\Models\Siswa;

Route::get("/", fn() => view('index'));
Route::get("/some", fn() => view('some'));
Route::post("/method", function () {
	Validator::validate([
		"nama" => "required",
	]);
});
Route::get("/siswa/{id}", fn($id) => dd(Siswa::findOrFail($id)));
Route::get("/login", fn()=> view("login", template: ""))->only("guest");
Route::post("/login", function (){
  Validator::validate([
    "username" => "required",
    "password" => "required"
  ]);
  
  Auth::attempts(["nama" => Request::body()["username"]]);
  return redirect("/");
});
Route::run();
