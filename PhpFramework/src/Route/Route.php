<?php

namespace App\Route;

use App\HttpMethod\HttpMethod;

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

    public static function get(string $url, mixed $callback) : self {
        return new self($url, HttpMethod::GET->value, $callback);
    }

    public static function post(string $url, string|array|object|int|null $parameter, mixed $callback) : self {
        return new self($url, $parameter, HttpMethod::POST->value, $callback);
    }

    public function match(string $requestRoute, string $httpMethod) : bool {
        $routeUrl = $this->getUrlParts($this->url);
        $requestUrl = $this->getUrlParts($requestRoute);

        if (($this->httpMethod !== $httpMethod) && (count($routeUrl) !== count($requestUrl))) 
            return false;

        for ($i=0;$i<count($routeUrl);$i++){
            $str = $routeUrl[$i];

            if ($this->checkPatternMatch($str))
                continue;

            if ($str !== $requestUrl[$i])
                return false;
        }

        return true;
    }

    public function getParameters($url) : array {
        $routeUrl = $this->getUrlParts($this->url);
        $requestUrl = $this->getUrlParts($url);
        $params = [];

        for ($i= 0;$i<count($routeUrl);$i++){
            $str = $routeUrl[$i];

            if ($this->checkPatternMatch($str)){
                $paramName = trim($str, "{}");
                $params[$paramName] = $requestUrl[$i];
            }
        }

        return $params;
    }

    private function getUrlParts($url) : array {
        return explode('/', trim($url, '/'));
    }

    private function checkPatternMatch(string $string) : bool|int {
        return preg_match("^{\w+}$", $string);
    }

}