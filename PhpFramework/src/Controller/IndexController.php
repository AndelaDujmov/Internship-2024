<?php

use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction(Request $request) : array {
        $response =  Response::getInstance();

        return $response->send();
    }

    public function index(Request $request) : JsonResponse {
        $response = Response::getInstance();
        
        return new JsonResponse($response->send());
    }

 }