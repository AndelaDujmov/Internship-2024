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

    public function match(string $requestRoute, string $httpMethod) : bool {
        $routeUrl = $this->getUrlParts($this->url);
        $requestUrl = $this->getUrlParts($requestRoute);

        if ($this->httpMethod !== $httpMethod)
            return false;

        if (count($requestUrl) > count($routeUrl)) {
            return false;
        }

        for ($i=0;$i<count($routeUrl);$i++){
            $str = $routeUrl[$i];

            if ($this->checkPatternMatch($str))
                continue;

            if (!isset($requestUrl[$i])) {
                return false;
            }

            if ($str !== $requestUrl[$i])
                return false;
        }

        return true;
    }

    public function getParameters($url) : array {
        $routeUrl = $this->getUrlParts($this->url);   
        $requestUrl = $this->getUrlParts($url);       
        $params = [];
    
        $routeUrlCount = count($routeUrl);
        $requestUrlCount = count($requestUrl);
    
        for ($i = 0; $i < $routeUrlCount; $i++) {
            if ($i < $requestUrlCount) {
                $str = $routeUrl[$i]; 
    
                if ($this->checkPatternMatch($str)) {
                    $params[] = $requestUrl[$i];     
                }
            }
        }
        return $params;
    }

    private function getUrlParts($url) : array {
        return explode('/', trim($url, '/'));
    }

    private function checkPatternMatch(string $string) : bool|int {
        return preg_match('/^{\w+}$/', $string);
    }

}