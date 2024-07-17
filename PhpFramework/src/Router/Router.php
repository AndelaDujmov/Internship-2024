<?php

namespace App\Router;

use App\Request\Request;
use App\Response\Response;
use App\Route\Route;

require 'vendor/autoload.php';

class Router{

    public array $routes;


    public function createRoute(string $url, string $httpMethod, mixed $callback) : void {
        $this->routes[] = new Route($url, $httpMethod, $callback);
    }

    public function resolver(Request $request) {
        $response = new Response();
        if (count($this->routes) > 0){
            foreach ($this->routes as $route){
                if ($route->url === $request->route && $route->httpMethod == $request->method){
                    call_user_func($route->callback);
                    $response->setResponseCode("OK", 200);
                    $response->setContent(["name" => "Andjela"]);
                    break;
                }
            }
        }
        else
            $response->setResponseCode("Not Found", 404);

        $response->send();
    }
    
}