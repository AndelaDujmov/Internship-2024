<?php

use App\Controller\IndexController;
use App\HttpMethod\HttpMethod;
use App\Router\Router;

require 'vendor/autoload.php';

$router = new Router();
$controller = new IndexController();

$router->createRoute("/get/data/{params}", HttpMethod::GET->value, [$controller, 'indexAction']);
$router->createRoute("/get/data/{params}", HttpMethod::POST->value, [$controller, 'indexJsonAction']);
