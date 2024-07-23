<?php

namespace App\Response;
use App\config\TwigConfig;

interface ResponseInterface{

    public function send() : string;
    public function setContent(string|array|null $content) : void;
    public function setResponseCode(string $message, int $code) : void;
    public function setHeaders(string $contentType) : void;
    public function getResponse() : array;
    public function renderTwig(TwigConfig $twig, string $template, array $data = []) : void;

}