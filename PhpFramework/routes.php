<?php

use App\Controller\IndexController;
use App\Controller\UserController;
use App\Router\Router as Route;

require 'vendor/autoload.php';

Route::get('/get/data/{params}', [IndexController::class, 'indexAction']);
Route::get('/find/user/{param}', [UserController::class,'findUser']);
Route::get('/delete/user/{param}', [UserController::class,'deleteUser']);
Route::get('/softdlt/user/{param}', [UserController::class,'softDeleteUser']);
Route::get('/show/all', [UserController::class,'showAll']);
Route::post("/get/json/{params}", [IndexController::class, 'indexJsonAction']);
Route::post('/add/user', [UserController::class,'addNewUser']);
Route::post('/edit/user/{param}', [UserController::class,'editUser']);