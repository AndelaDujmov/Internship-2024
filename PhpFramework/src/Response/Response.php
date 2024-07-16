<?php

namespace App\Response;

class Response implements ResponseInterface{

    public $content;
    public $statusCode;
    public $message;

    public function send()
    {
        echo $this->statusCode . ' ' . $this->message . ' {' . $this->content . '}';
    }

    public function setContent(string|array|null $content){
        $this->content = $content;
    }
    
    public function setResponseCode(string $message, int $code){
        $this->statusCode = $code;
        $this->message = $message;
    }

}