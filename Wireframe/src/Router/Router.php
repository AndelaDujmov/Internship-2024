<?php

namespace App\Router;

use App\Http\HttpMethod;
use App\Request\Request;
use App\Response\Response;
use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public static array $routes = [];

    public function createRoute(string $url, string $httpMethod, mixed $callback) : void {
        $this->routes[] = new Route($url, $httpMethod, $callback);
    }

    public static function get(string $url, mixed $callback) : void {
        self::$routes[] = new Route($url, HttpMethod::GET->value, $callback);
    }

    public static function post(string $url, mixed $callback) : void {
        self::$routes[] = new Route($url, HttpMethod::POST->value, $callback);
    }

    public static function resolver(Request $request) : null|array|string {
        foreach (self::$routes as $route){
            if ($route->match($request->route, $request->method)){
                $parameters = $route->getParameters($request->route);

                list($controller, $method) = $route->callback;
                $instance = new $controller();

                if (count($parameters) == null)
                    $response = call_user_func([$instance, $method]);

                $response = call_user_func_array([$instance, $method], $parameters);
               
                if ($response)
                    return $response->send();
            }
        }
        return null;
    }
    
}