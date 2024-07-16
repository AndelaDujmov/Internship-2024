<?php

namespace App\Response;

class Response implements ResponseInterface{

    public $content;
    public $statusCode;

    public function __construct()
    {
        
    }

    public function send()
    {
        
    }

    public function status(){
        return $this->statusCode;
    }

    public function content(){
        return $this->content;
    }

    public function setContent(string|array|null $content){
        $this->content = $content;
    }

}