<?php

namespace App\Request;

class Request implements RequestInterface{

    public $headers;
    public $messageBody;
    public $parameters;
    public $requestBody;
    public $route;

    public function __construct(string|array|null $headers, string|array|null $messageBody, string $route){
        $this->headers = $headers;
        $this->messageBody = $messageBody;
        $this->route = $route;
    }
    
    public function retrieveItem(string $source, string $key, string|array|null $default){
        if(isset($source[$key])){    
            return $source[$key];
        }
        return $default;
    }


    public function route(string|null $param = null, $default = null){

    }

    public function setParameters($parameters){
        $this->parameters = $parameters;
    }

    public function getParameters(){
        return $this->parameters;
    }

    public function setRequestBody(string|array|null $body){
        $this->requestBody = $body;
    }

    public function getRequestBody(){
        return $this->requestBody;
    }

}