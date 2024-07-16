<?php

namespace App\Response;

interface ResponseInterface{

    public function send();
    public function status();
    public function content();
    public function setContent(string|array|null $content);

}