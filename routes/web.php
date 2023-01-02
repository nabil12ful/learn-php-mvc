<?php

use App\Controllers\HomeController;
use Nopel\Http\Route;

// Route::get('/', function(){
//     echo 'hello';
// });

Route::get('/', [HomeController::class, 'index']);