<?php

namespace App\Mailer;

use App\HasLoggerInterface;

class GmailMailer implements MailerInterface, HasLoggerInterface
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
