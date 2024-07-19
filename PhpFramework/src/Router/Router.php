<?php

namespace App\Router;

use App\HttpMethod\HttpMethod;
use App\Request\Request;
use App\Response\Response;
use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public array $routes;

    public function createRoute(string $url, string $httpMethod, mixed $callback) : void {
        $this->routes[] = new Route($url, $httpMethod, $callback);
    }

    public function get(string $url, mixed $callback) : void {
        $this->routes[] = new Route($url, HttpMethod::GET->value, $callback);
    }

    public function post(string $url, mixed $callback) : void {
        $this->routes[] = new Route($url, HttpMethod::POST->value, $callback);
    }

    public function resolver(Request $request) : null|array {
        foreach ($this->routes as $route){
            if ($route->match($request->route, $request->method)){
                $parameters = $route->getParameters($request->route);

                if (count($parameters) == null)
                    $response = call_user_func($route->callback);

                $response = call_user_func_array($route->callback, $parameters);
               
                return $response->send();
            }
        }
        return null;
    }
    
}