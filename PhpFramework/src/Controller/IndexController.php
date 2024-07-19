<?php
namespace App\Controller;

use App\config\TwigConfig;
use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction(?string $params) : Response {
        $twig = new TwigConfig();
        $response =  Response::getInstance();
        $content = $twig->render('httpResponse.html.twig', ["params" => $params]);
        $response->setContent($content);
        $response->setResponseCode("OK", 200);
        $response->setHeaders('Content-Type: text/html');
    
        return $response;
    }

    public function indexJsonAction(?string $params) : JsonResponse {
        $content = ["param" => $params ?? null];
        
        return new JsonResponse($content, 200, "OK");
    }

 }