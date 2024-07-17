<?php

use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;

require 'vendor/autoload.php';

class IndexController {

    public function indexAction() : Response {
        return Response::getInstance();
    }

    public function index() : JsonResponse {
        $response = Response::getInstance();

        return new JsonResponse($response->getArray());
    }
 }