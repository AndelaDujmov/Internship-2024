<?php

namespace App\Router;

class Router{
    public $url;
    public $httpMethod;
    public $callback;

    private function __construct($url, $httpMethod, $callback)
    {
        $this->url = $url;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
    }

    public static function createRoute($url, $httpMethod, $callback){
        return new static($url, $httpMethod, $callback);
    }

    public function resolver(){
        return call_user_func($this->callback);
    }
}