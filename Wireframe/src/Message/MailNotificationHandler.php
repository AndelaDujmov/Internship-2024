<?php

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MailNotificationHandler {
    public function __invoke() {
        
    }
}