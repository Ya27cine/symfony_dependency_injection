<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

 return function(ContainerConfigurator $containerConfigurator){

    $parameters = $containerConfigurator->parameters();
    $parameters
        ->set('mailer.gmail_user', "lior@gmail.com")
        ->set('mailer.gmail_password', "123456");

    $services = $containerConfigurator->services();
    $services
        ->set('oreder_controller', OrderController::class)
        ->autowire(true)
        ->public()

        ->set('mailer.gmail', GmailMailer::class)
        ->args([ "%mailer.gmail_user%", "%mailer.gmail_password%"])
        ->autowire(true)

        ->set('texter.sms', SmsTexter::class)
        ->args([ "service.sms.com", "apikey123"])
        ->autowire(true)

        ->set('texter.fax', FaxTexter::class)
        ->autowire(true)

        ->set('mailer.smtp', SmtpMailer::class)
        ->args(['smtp://localhost', 'root', '123'])
        ->autowire(true)

        ->set('logger', Logger::class)
        ->autowire(true)

        ->set('database', Database::class)
        ->autowire(true);
       
    

 };

?>