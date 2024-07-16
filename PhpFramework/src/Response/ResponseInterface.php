<?php

namespace App\Response;

interface ResponseInterface{

    public function send();
    public function setContent(string|array|null $content);
    public function setResponseCode(string $message, int $code);

}