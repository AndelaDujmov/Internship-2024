<?php

namespace App\Router;

use App\HttpMethod\HttpMethod;

class Router{

    public $url;
    public $httpMethod;
    public $callback;

    private function __construct(string $url, string $httpMethod, $callback)
    {
        $this->url = $url;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
    }

    public static function createRoute(string $url, string $httpMethod, $callback){
        return new static($url, $httpMethod, $callback);
    }

    public function resolver(){
        return call_user_func($this->callback);
    }
    
}