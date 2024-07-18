<?php

namespace App\Response\JsonResponse;

use App\Response\Response;

class JsonResponse extends Response{

    public function __construct(string|array|null $content, int $responseCode, string $responseText) {
        $this->content = json_encode($content);
        $this->responseCode = $responseCode;
        $this->responseText = $responseText;
        $this->setHeaders('Content-Type: application/json');
    }
    
}