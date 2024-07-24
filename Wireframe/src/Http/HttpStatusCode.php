<?php

namespace App\Http;

enum HttpStatusCode : int {
    case OK = 200;
    case FOUND = 302;
    case BAD_REQUEST = 400;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
}