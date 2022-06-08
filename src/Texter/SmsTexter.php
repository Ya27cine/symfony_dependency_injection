<?php

namespace App\Texter;

use App\HasLoggerInterface;

class SmsTexter implements TexterInterface, HasLoggerInterface
{
    protected $serviceDsn;
    protected $key;
    protected $logger;


    public function __construct(string $serviceDsn, string $key)
    {
        $this->serviceDsn = $serviceDsn;
        $this->key = $key;
    }

    public function setLogger( $logger){
        $this->logger = $logger;
        $this->logger->log("SMS , Done !");
    }

    public function send(Text $text)
    {
        dump("ENVOI DE SMS : ", $text);
    }
}
