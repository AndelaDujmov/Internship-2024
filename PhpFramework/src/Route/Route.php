<?php

namespace App\Route;

class Route{

    public $url;
    public $httpMethod;
    public $callback;
    
    public function __construct(string $url, string $httpMethod, mixed $callback)
    {
        $this->url = $url;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
    }

}