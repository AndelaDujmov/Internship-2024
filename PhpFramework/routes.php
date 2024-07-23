<?php

use App\Controller\IndexController;
use App\Controller\UserController;
use App\Router\Router as Route;

require 'vendor/autoload.php';

Route::get('/get/data/{params}', [IndexController::class, 'indexAction']);
Route::post("/get/json/{params}", [IndexController::class, 'indexJsonAction']);
Route::post('/add/user', [UserController::class,'addNewUser']);
Route::get('/find/user/{param}', [UserController::class,'findUser']);
Route::get('/delet  e/user/{param}', [UserController::class,'deleteUser']);
Route::get('/softdlt/user/{param}', [UserController::class,'softDeleteUser']);
Route::post('/edit/user/{param}', [UserController::class,'editUser']);
