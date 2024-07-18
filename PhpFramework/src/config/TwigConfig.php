<?php

namespace App\config;

require 'vendor/autoload.php';

class TwigConfig{

    public $twig;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('src/templates/httpResponse.html');
        $this->twig = new \Twig\Environment($loader);
    }
    
}