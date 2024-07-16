<?php

use App\HttpMethod\HttpMethod;
use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router();
$router->createRoute("http:8080/localhost/get/data", HttpMethod::GET->value, function(){echo"This is a get request";});
$router->createRoute("http:8080/localhost/add/data", HttpMethod::POST->value, function(){echo"This is a post request";});
$router->createRoute("http:8080/localhost/get/data", HttpMethod::GET->value, function(){echo"This is a post request";});
$router->createRoute("http:8080/localhost/add/data", HttpMethod::POST->value, function(){echo"This is a post request";});
