<?php

use App\HttpMethod\HttpMethod;
use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router();
$controller = new IndexController();

$router->createRoute("/get/data/{dataId}", HttpMethod::GET->value, [$controller, 'indexAction']);
$router->createRoute("/add/data", HttpMethod::POST->value, [$controller, 'indexAction']);
