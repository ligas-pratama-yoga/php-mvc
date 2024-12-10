<?php

use App\Core\Route;

Route::get("/", fn() => view('index'));
Route::run();
