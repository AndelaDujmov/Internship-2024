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

    /*
    public function addNewUser() : Response {
        $content = ['fname' => 'Mario', 'lname' => 'Maric'];
        $user = new User($content);
        $user->save();

        if ($user){
            return $this->indexAction('Created', HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('Unable to create.', HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

    public function editUser($id) : Response  {
        $user = User::find(intval($id));
        $user->fname = "Marko";
        $user->lname = "Icic";
        $user->update();

        if ($user){
            return $this->indexAction('Edited', HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('Unable to edit.', HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

    public function findUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            return $this->indexAction($user->fname . ' ' . $user->lname, HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction(null, HttpStatusCode::NOT_FOUND->name, HttpStatusCode::NOT_FOUND->value);
    }

    public function softDeleteUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            $user->softDelete();
            return $this->indexAction('Succesfully soft deleted', HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('Unable to find data', HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }

    public function deleteUser($id) : Response {
        $user = User::find(intval($id));
        
        if ($user != null){
            $user->delete();
            return $this->indexAction('Succesfully deleted', HttpStatusCode::OK->name, HttpStatusCode::OK->value);
        }
        return $this->indexAction('Unable to find data', HttpStatusCode::BAD_REQUEST->name, HttpStatusCode::BAD_REQUEST->value);
    }*/

}