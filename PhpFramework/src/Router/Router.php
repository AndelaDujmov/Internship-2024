<?php

namespace App\Router;

use App\Request\Request;
use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public array $routes;
    private static $instance;

    private function __construct(){
        $this->routes = [];
    }

    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function createRoute(string $url, string $httpMethod, $callback){
        $this->routes[] = new Route($url, $httpMethod, $callback);
    }

    public function resolver(Request $request){
        if (count($this->routes) > 0){
            foreach ($this->routes as $route){
                if (strpos($route->url, $request->route) && $route->httpMethod == $request->method){
                    call_user_func($route->callback);
                    return;
                }
            }
        }
        else
            return "Route not found";
    }
    
}