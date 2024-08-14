<?php

namespace App\Message;

use App\Message\MailNotification;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class MailNotificationHandler {

    private $mailer;

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function __invoke(MailNotification $mail)
    {
        $email = (new Email())
        ->to($mail->getTo())
        ->subject($mail->getSubject())
        ->text($mail->getContent());
    
        foreach ($mail->getAttachments() as $attachment){
            if (file_exists($attachment['path'])){
                $email->attachFromPath($attachment['path'], $attachment['name']);
            }
        }

        try{
            $this->mailer->send($email);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
           
    }
}