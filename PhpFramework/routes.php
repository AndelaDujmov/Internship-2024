<?php

use App\Controller\IndexController;
use App\Router\Router as Route;

require 'vendor/autoload.php';

Route::get('/get/data/{params}', [IndexController::class, 'indexAction']);
Route::post("/get/json/{params}", [IndexController::class, 'indexJsonAction']);

