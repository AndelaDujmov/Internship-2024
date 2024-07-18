<?php
namespace App\Controller;

use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction(?string $params) : Response {
        $response =  Response::getInstance();
        $response->setContent(["param" => $params ?? null]);
        $response->setResponseCode("OK", 200);
    
        return $response;
    }

    public function indexJsonAction(?string $params) : JsonResponse {
        $content = ["param" => $params ?? null];
        
        return new JsonResponse($content, 200, "OK");
    }

 }