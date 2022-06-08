<?php

namespace App\Texter;

class SmsTexter implements TexterInterface
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
