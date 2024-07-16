<?php

use App\HttpMethod\HttpMethod;
use App\Request\Request;
use App\Router\Router;

require 'vendor/autoload.php';

$routeGET = Router::createRoute("http:8080/localhost/get/data", HttpMethod::GET->value, function(Request $request){});
$routePOST = Router::createRoute("http:8080/localhost/add/data", HttpMethod::POST->value, function(Request $request){});