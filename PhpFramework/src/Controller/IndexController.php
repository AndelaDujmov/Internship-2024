<?php

use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction(Request $request) : array {
        $response =  Response::getInstance();
        $response->setContent(["name" => "Andjela"]);
        $response->setResponseCode("OK", 200);


        return $response->send();
    }

    public function index(Request $request) : JsonResponse {
        $response = Response::getInstance();
        $content = ["name" => "Andjela"];
        
        return new JsonResponse($content, 200, "OK");
    }

 }