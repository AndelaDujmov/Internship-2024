<?php

namespace App\Controller;

use App\config\TwigConfig;
use App\Http\HttpMethod;
use App\Http\HttpStatusCode;
use App\Model\User;
use App\Response\JsonResponse\JsonResponse;
use App\Response\Response;
use Dotenv\Dotenv;

require 'vendor/autoload.php';

class UserController extends IndexController {
    
    public function showAll() : Response {
        $users = User::findAll();
        
        if (count($users) > 0) {
            return $this->indexAction('allUsers.html.twig', ['users' => $users], HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('allUsers.html.twig', ['users' => null], HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

    public function addNewUser() : Response {
        $response = Response::getInstance();
        $twig = new TwigConfig();

        $response->renderTwig($twig, 'createUser.html.twig');

        return $response;
    }

    public function editUser($id) : Response  {
        $user = User::find(intval($id));
        
        if ($user){
            return $this->indexAction('editUser.html.twig', ['fname' => $user->fname, 'lname' => $user->lname], HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('editUser.html.twig', ['fname' => null, 'lname' => null], HttpStatusCode::OK->name, HttpStatusCode::OK->value);

    }

    public function findUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            return $this->indexAction("findUser.html.twig", ['firstName' => $user->fname, 'lastName' => $user->lname], HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction("findUser.html.twig", ['user' => null], HttpStatusCode::NOT_FOUND->name, HttpStatusCode::NOT_FOUND->value);
    }


    public function softDeleteUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            $user->softDelete();
            return $this->indexAction("httpResponse.html.twig", ['message' => 'Successfully soft deleted!'], HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction("httpResponse.html.twig", ['message' => 'Unable to find data!'], HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

    
    public function deleteUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            $user->delete();
            return $this->indexAction("httpResponse.html.twig", ['message' => 'Successfully deleted!'], HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction("httpResponse.html.twig", ['message' => 'Unable to find data!'], HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

}