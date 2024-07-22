<?php
namespace App\Controller;

use App\Connection\Connection;
use App\Http\HttpStatusCode;
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

    public function indexAction(?string $params = null) : Response {
        $result = $this->loadDb();
        $response =  Response::getInstance();
        $response->setHeaders('Content-Type: text/html');

        if ($this){
            $content = ["name" => "Andjela", "params" => $params];
            try{
                $result->insert('user', ['fname' => 'Iva', 'lname' => 'Ivic']);
                $response->setContent($content);
                $response->setResponseCode(HttpStatusCode::OK->name, HttpStatusCode::OK->value);
            }catch(Exception $e){
                $response->setContent(null);
                $response->setResponseCode(HttpStatusCode::NOT_FOUND->name, HttpStatusCode::NOT_FOUND->value);
                echo $e->getMessage();
            }
        } else{
            $response->setContent([]);
            $response->setResponseCode(HttpStatusCode::INTERNAL_SERVER_ERROR->name, HttpStatusCode::INTERNAL_SERVER_ERROR->value);
        }
    
        return $response;
    }

    public function indexJsonAction(?string $params = null) : JsonResponse {
        $content = ["name" => "Andjela", "params" => $params];
        
        return new JsonResponse($content, HttpStatusCode::OK->value, HttpStatusCode::OK->name);
    }

    private function loadDb() : Connection|null {
        try{
            $connection = Connection::getInstance($_ENV['DB_URL'], $_ENV['DB_USER'], $_ENV['DB_PASSWD']);
            echo $_ENV['DB_URL'];
            echo "Succesfully connected";
            return $connection;
        } catch (Exception $e){
            log($e->getMessage());
            return null;
        }
    }

 }