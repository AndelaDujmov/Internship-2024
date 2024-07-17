<?php

namespace App\Route;

use App\HttpMethod\HttpMethod;

class Route{

    public $url;
    public $baseUrl;
    public $httpMethod;
    public $parameter;
    public $callback;
    public $action;
    
    public function __construct(string $url, string|array|object|int|null $parameter, string $httpMethod, mixed $callback)
    {

        $this->baseUrl = $url;
        $this->parameter = $parameter;
        $this->url = $url .= "/" . $this->parameter;
        $this->httpMethod = $httpMethod;
        $this->callback = $callback;
        
    }

    public static function get(string $url, string|array|object|int|null $parameter, mixed $callback){
        return new self($url, $parameter, HttpMethod::GET->value, $callback );
    }

    public static function post(string $url, string|array|object|int|null $parameter, string $httpMethod, mixed $callback){

    }

}