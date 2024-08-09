<?php

namespace App\Message;

class MailNotification {

    public function __construct(private string $content) {
        
    }

    public function getContent(): string {
        return $this->content;
    }
    
}