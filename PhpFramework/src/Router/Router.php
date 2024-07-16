<?php

namespace App\Router;

use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public array $routes;

    public function __construct(){
        $this->routes = [];
    }

    public function createRoute(string $url, string $httpMethod, $callback){
        $this->routes[] = new Route($url, $httpMethod, $callback);
    }

    public function resolver(string $url, string $httpMethod){
        if (count($this->routes) > 0){
            foreach ($this->routes as $route){
                if ($route->match($url, $httpMethod)){
                    call_user_func($route->callback);
                    return;
                }
            }
        }
        else
            return "Route not found";
    }
    
}