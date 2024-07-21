<?php

use App\HttpMethod\HttpMethod;
use App\Request\Request;

require 'vendor/autoload.php';
include 'routes.php';

$requestGet = new Request(HttpMethod::GET->value ,"/get/data/1");
$requestPost = new Request(HttpMethod::GET->value ,"/get/json/2");
$requestPost->setBody(["name" => "Adnjela"]);
$responseGet = $router->resolver($requestGet);
print_r($responseGet);
$responsePost = $router->resolver($requestPost);
print_r($responsePost);
