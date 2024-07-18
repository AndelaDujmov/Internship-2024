<?php

namespace App\config;

require 'vendor/autoload.php';

class TwigConfig{

    public $twig;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('src/templates/');
        $this->twig = new \Twig\Environment($loader);
    }

    public function render(string $template, array|null $data) : string {
        return $this->twig->render($template, $data);
    }
    
}