<?php

namespace App\Response;
use App\config\TwigConfig;

class Response implements ResponseInterface{

    public $content;
    public $responseCode;
    public $responseText;
    public $headers = [];

    public static function getInstance() : ResponseInterface {
        return new self();
    }

    public function send() : string {
        return $this->content;
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

    public function getResponse() : array {
        return [$this->headers, $this->responseCode, $this->responseText, $this->content];
    }

    public function renderTwig(TwigConfig $twig, string $template, array $data = []) : void {
        $this->content = $twig->render($template, $data);
    }

}