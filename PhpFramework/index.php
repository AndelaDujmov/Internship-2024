<?php

use App\Http\HttpMethod;
use App\Request\Request;
use App\Router\Router;

require 'vendor/autoload.php';
include 'routes.php';

$findUser = new Request(HttpMethod::GET->value ,"/find/user/6");
$user = Router::resolver($findUser);
print_r($user);
$softDltUsr = new Request(HttpMethod::GET->value ,"/softdlt/user/15");
$stfdl = Router::resolver($softDltUsr);
print_r($stfdl);
$dltUser = new Request(HttpMethod::GET->value ,"/delete/user/40");
$dlt = Router::resolver($dltUser);
print_r($dlt);
$addUser = new Request(HttpMethod::POST->value ,"/add/user");
$add = Router::resolver($addUser);
print_r($add);
$updateUsr = new Request(HttpMethod::POST->value ,"/edit/user/46");
$update = Router::resolver($updateUsr);
print_r($update);
