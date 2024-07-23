<?php
namespace App\Controller;

use App\config\TwigConfig;
use App\Connection\Connection;
use App\Http\HttpStatusCode;
use App\Model\User;
use App\Request\Request;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;
use Dotenv\Dotenv;
use Exception;

require 'vendor/autoload.php';

class IndexController {

    public function __construct() {
        Dotenv::createImmutable(__DIR__ . '/../../')->load();
    }

    public function indexAction(string $template, mixed $data, string $message, int $code) : Response {
        $response =  Response::getInstance();
        $twig = new TwigConfig();
        $response->setHeaders('Content-Type: text/html');
        $response->setResponseCode($message, $code);
        $response->renderTwig($twig, $template, $data);
       
        return $response;
    }

    public function indexJsonAction(?string $content = null, string $message, int $code) : JsonResponse {
        $response =  JsonResponse::getInstance();
        $response->setHeaders('Content-Type: application/json');
        $response->setContent($content);
        $response->setResponseCode($message, $code);
       
        return $response;
    }

 }