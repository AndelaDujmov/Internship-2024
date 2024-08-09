<?php

namespace App\Message;

class MailNotification {

    private string $to;
    private string $subject;
    private string $content;

    public function __construct(string $to, string $subject, string $content) {
        $this->to = $to;
        $this->subject = $subject;
        $this->content = $content;
    }

    public function getTo(): string {
        return $this->to;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function getSubject(): string {
        return $this->subject;
    }
    
}