<?php

namespace App\Response;

class Response implements ResponseInterface{

    public $content;
    public $responseCode;
    public $responseText;
    public $headers = [];

    public static function getInstance() : ResponseInterface {
        return new self();
    }

    public function send() : array {
        if (is_array($this->content)){
            return ["headers" => $this->headers, "statusCode" => $this->responseCode,"message"=> $this->responseText, "content" => json_encode($this->content)];;
        }
        else
            return ["headers" => $this->headers, "statusCode" => $this->responseCode,"message"=> $this->responseText, "content" => $this->content];;
    }

    public function setContent(string|array|null $content) : void {
        $this->content = $content;
    }
    
    public function setResponseCode(string $message, int $code) : void {
        $this->responseCode = $code;
        $this->responseText = $message;
    }

    public function getArray() : array{
        return ["statusCode" => $this->responseCode,"message"=> $this->responseText, "content" => $this->content];
    }

    public function setHeaders(string $contentType) : void {
        $this->headers[] = $contentType;
    }

}