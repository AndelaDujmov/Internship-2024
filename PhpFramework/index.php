<?php

use App\Http\HttpMethod;
use App\Request\Request;
use App\Router\Router;

require 'vendor/autoload.php';
include 'routes.php';

$requestGet = new Request(HttpMethod::GET->value ,"/get/data/1");
$requestPost = new Request(HttpMethod::POST->value ,"/get/json/");
$requestPost->setBody(["name" => "Adnjela"]);
$responseGet = Router::resolver($requestGet);
print_r($responseGet);
$responsePost = Router::resolver($requestPost);
print_r($responsePost);
