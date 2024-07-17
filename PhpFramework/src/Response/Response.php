<?php

namespace App\Response;

class Response implements ResponseInterface{

    public $content;
    public $statusCode;
    public $message;

    public function send() : void {
        if (is_array($this->content)){
            echo json_encode($this->content);
        }
        else
            echo $this->statusCode . ' ' . $this->message . ' {' . $this->content . '}';
    }

    public function setContent(string|array|null $content) : void {
        $this->content = $content;
    }
    
    public function setResponseCode(string $message, int $code) : void {
        $this->statusCode = $code;
        $this->message = $message;
    }
}