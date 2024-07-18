<?php

use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction(mixed $params) : Response {
        $response =  Response::getInstance();
        $response->setContent(["param" => $params]);
        $response->setResponseCode("OK", 200);

        return $response;
    }

    public function indexJsonAction(mixed $params) : JsonResponse {
        $response = Response::getInstance();
        $content = ["param" => $params];
        
        return new JsonResponse($content, 200, "OK");
    }

 }