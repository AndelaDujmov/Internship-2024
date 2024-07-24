<?php

namespace App\Request;

interface RequestInterface{
    
    public function setBody(mixed $body) : void;

}