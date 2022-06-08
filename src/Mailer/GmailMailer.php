<?php

namespace App\Mailer;

class GmailMailer implements MailerInterface
{

    protected $user;
    protected $password;

    protected $logger;

    public function __construct(string $user, string $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function setLogger($logger){
        $this->logger = $logger;
        $this->logger->log("Gmail , Done !");
    }

    public function send(Email $email)
    {
        dump(" >> ENVOI VIA GMAILMAILER", $email);
    }
}
