<?php

namespace App\Router;

use App\Request\Request;
use App\Response\Response;
use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public array $routes;


    public function createRoute(string $url, string|array|object|int|null $parameter, string $httpMethod, mixed $callback) : void {
        $this->routes[] = new Route($url, $parameter, $httpMethod, $callback);
    }

    public function resolver(Request $request) {
        $response = new Response();
        $match = false;

        if (count($this->routes) > 0){
            foreach ($this->routes as $route){
                if ($route->baseUrl === $request->route && $route->httpMethod == $request->method){
                    call_user_func($route->callback);
                    $response->setResponseCode("OK", 200);
                    $response->setContent(["name" => "Andjela"]);
                    $match = true;   
                    break;
                }
            }
        }

        if ($match){
            $response->setResponseCode("Not Found",404);
        }

        $response->send();
    }
    
}