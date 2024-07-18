<?php

use App\HttpMethod\HttpMethod;
use App\Request\Request;

require 'vendor/autoload.php';
include 'routes.php';

$requestGet = new Request(HttpMethod::GET->value ,"/get/data/1");
$requestGet = new Request(HttpMethod::GET->value ,"/get/data/2");
$requestPost = new Request(HttpMethod::POST->value, "/add/data");
$requestPost->setBody(["name" => "Adnjela"]);
$router->resolver($requestGet);
$router->resolver($requestPost);
