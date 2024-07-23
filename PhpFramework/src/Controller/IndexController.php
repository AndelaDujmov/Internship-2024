<?php
namespace App\Controller;

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

    public function indexAction(?string $params = null) : Response {
       
        $response =  Response::getInstance();
        $response->setHeaders('Content-Type: text/html');

        $content = ["name" => "Andjela", "params" => $params];
        try{
            $model = new User(['fname' => 'Iva', 'lname' => 'Ivic']);
            $model->save();
            $user = User::find(10);
            print_r($user->attributes);
            $user->fname = "Jela";
            $user->lname = "Jelic";
            $user->update();
            $user2 = User::find(23);
            $user2->softDelete();
            $user2->delete();
            print_r($user->attributes);
            $response->setContent($content);
            $response->setResponseCode(HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }catch(Exception $e){
            $response->setContent(null);
            $response->setResponseCode(HttpStatusCode::NOT_FOUND->name, HttpStatusCode::NOT_FOUND->value);
            echo $e->getMessage();
        }
       
        return $response;
    }

    public function indexJsonAction(?string $params = null) : JsonResponse {
        $content = ["name" => "Andjela", "params" => $params];

        try{
            $model = new User(['fname' => 'Jelena', 'lname' => 'F']);
            $model->save();
            $user = User::find(50);
            return new JsonResponse($content, HttpStatusCode::OK->value, HttpStatusCode::OK->name);
        }catch(Exception $e){
            echo $e->getMessage();
            return new JsonResponse(null, HttpStatusCode::NOT_FOUND->value, HttpStatusCode::NOT_FOUND->name);
        }
    }
 }