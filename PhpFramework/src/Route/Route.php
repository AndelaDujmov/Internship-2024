<?php

namespace App\Route;

class Route {

    public $url;
    public $httpMethod;
    public $callback;
    
    private function __construct(string $url, string $httpMethod, $callback)
    {
        $this->url = $url;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
    }

}