<?php

namespace App\Response;

interface ResponseInterface{

    public function send() : void;
    public function setContent(string|array|null $content) : void;
    public function setResponseCode(string $message, int $code) : void;

}