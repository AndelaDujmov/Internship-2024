<?php

namespace App\Request;

class Request implements RequestInterface{

    public $headers;
    public $messageBody;
    public $parameters;
    public $requestBody;
    public $route;

    public function __construct(string|array|null $headers, string|array|null $messageBody, string|array|null $parameters, 
                                string|array|null $requestBody, string $route)
    {
        $this->headers = $headers;
        $this->messageBody = $messageBody;
        $this->parameters = $parameters;
        $this->requestBody = $requestBody;
        $this->route = $route;
    }
    
    public function retrieveItem(string $source, string $key, string|array|null $default){

    }


    public function route(string|null $param = null, $default = null){

    }

}