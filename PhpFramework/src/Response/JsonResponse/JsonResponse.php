<?php

namespace App\Response\JsonResponse;

use App\Response\Response;

class JsonResponse extends Response{

    private function __construct() {
    }

    public static function getInstance() : JsonResponse {
        return new self();
    }

    public function send(): string
    {
        $response = [
            "headers" => $this->headers,
            "statusCode" => $this->responseCode,
            "message" => $this->responseText,
            "content" => is_array($this->content) ? json_encode($this->content) : $this->content
        ];
  
        return json_encode($response);
    }
    
}