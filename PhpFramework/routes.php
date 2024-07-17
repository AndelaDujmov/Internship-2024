<?php

use App\HttpMethod\HttpMethod;
use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router();

$router->createRoute("/get/data", HttpMethod::GET->value, function(){echo"This is a get request";});
$router->createRoute("/add/data", HttpMethod::POST->value, function(){echo"This is a post request";});