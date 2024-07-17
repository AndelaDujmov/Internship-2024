<?php

namespace App\Response\JsonResponse;

use App\Response\Response;

class JsonResponse{
    public $responseContent;

    public function __construct(array $response) {
        $this->responseContent = json_encode($response);
    }
}