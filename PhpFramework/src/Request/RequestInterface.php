<?php

namespace App\Request;

interface RequestInterface{
    
    public function retrieveItem(string $source, string $key, string|array|null $default); 
    public function route(string|null $param = null, $default = null); 
    public function setParameters($parameters);
    public function getParameters();
    public function setRequestBody(string|array|null $body);
    public function getRequestBody();

}