<?php

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
        ->from("andeladujmov9@gmail.com")
        ->to($mail->getTo())
        ->subject($mail->getSubject())
        ->text($mail->getContent());

        try{
            $this->mailer->send($email);
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
           
    }
}