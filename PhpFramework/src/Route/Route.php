<?php

namespace App\Route;

class Route{

    public $url;
    public $baseUrl;
    public $httpMethod;
    public $parameter;
    public $callback;
    
    public function __construct(string $url, string|array|object|int|null $parameter, string $httpMethod, mixed $callback)
    {

        $this->baseUrl = $url;
        $this->parameter = $parameter;
        $this->url = $url .= "/" . $this->parameter;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
    }

}