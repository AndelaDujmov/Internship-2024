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
        if (!$this->templateExists($template)){
            try {
                $templatePath = $this->twig->getLoader()->getCacheKey($template);
                return file_exists($templatePath);
            } catch (\Exception $e) {
                return false;
            }
        }

        return $this->twig->render($template, $data);
    }

    private function templateExists(string $template): bool {
        try {
            $templatePath = $this->twig->getLoader()->getCacheKey($template);
            return file_exists($templatePath);
        } catch (\Exception $e) {
            return false;
        }
    }
    
}