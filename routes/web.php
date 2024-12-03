<?php

use App\Core\Route;
use App\Core\Validator;

Route::get("/", fn() => view('index'));
Route::get("/some", fn() => view('some'));
Route::post("/method", function(){
  Validator::validate([
    "id" => "required"
  ]);

  dd(Validator::$errors);
});
Route::run();
