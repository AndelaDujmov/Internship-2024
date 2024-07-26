<?php
namespace App\Enum;

enum Status : string {
    case PENDING = 'Pending';
    case COMPLETED = 'Approved';
    case CANCELLED = 'Rejected';
}