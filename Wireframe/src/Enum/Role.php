<?php

namespace App\Enum;

enum Role : string {
    case USER = "ROLE_USER";
    case WORKER = "ROLE_WORKER";
    case ADMIN = "ROLE_ADMIN";
    case TEAMLEADER = "ROLE_TEAMLEADER";
    case PROJECTLEADER = "ROLE_PROJECTLEADER";
}