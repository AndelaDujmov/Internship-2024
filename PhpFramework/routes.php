<?php

use App\HttpMethod\HttpMethod;
use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router();

$router->createRoute("/get/data", 2, HttpMethod::GET->value, function(){echo"This is a get request";});
$router->createRoute("/add/data", 3,  HttpMethod::POST->value, function(){echo"This is a post request";});
$router->createRoute("/add/data", 4,  HttpMethod::POST->value, function(){echo"This is a post request";});
$router->createRoute("/get/data", 2, HttpMethod::GET->value, function(){echo"This is a get request";});