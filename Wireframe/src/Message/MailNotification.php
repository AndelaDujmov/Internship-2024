<?php

namespace App\Message;

class MailNotification {

    private string $to;
    private string $subject;
    private string $content;
    private array $attachments = [];

    public function __construct(string $to, string $subject, string $content, ?array $attachments = []) {
        $this->to = $to;
        $this->subject = $subject;
        $this->content = $content;
        $this->attachments = $attachments;
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
    
    public function getAttachments(): array
    {
        return $this->attachments;
    }
    
}