<?php

namespace App\Request;

class Request implements RequestInterface{

    public $queryParams;
    public $bodyParams;
    public $route;
    public $method;

    public function __construct(string $method, string $route){
        $this->method = $method;
        $cut = strpos($route, '?');
        if($cut != false){
            $this->route = substr($route, 0, $cut);
            $this->queryParams = substr($route, $cut + 1);
        }else
            $this->route = $route;
    }

    public function setBody($body){
        $this->bodyParams = $body;
    }


}