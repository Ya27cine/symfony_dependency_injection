<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\HasLoggerInterface;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\MailerInterface;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

 return function(ContainerConfigurator $containerConfigurator){

    $parameters = $containerConfigurator->parameters();
    $parameters
        ->set('mailer.gmail_user', "lior@gmail.com")
        ->set('mailer.gmail_password', "123456");


    $services = $containerConfigurator->services();
    $services->defaults()->autowire(true);

    # add tag #with_logger for all classes imp  i: HasLoggerInterface
    $services->instanceof(HasLoggerInterface::class)->tag('with_logger');

    $services
    
        ->set('oreder_controller', OrderController::class)
        ->public()
        ->call('sayHello', ['Khelifa Yassine', 28])
        //->call('setSecondaryMailer', [ ref('mailer.gmail') ])


        ->set('mailer.gmail', GmailMailer::class)
        ->args([ "%mailer.gmail_user%", "%mailer.gmail_password%"])
 
        ->set('texter.sms', SmsTexter::class)
        ->args([ "service.sms.com", "apikey123"])
 
        ->set('texter.fax', FaxTexter::class)
 
        ->set('mailer.smtp', SmtpMailer::class)
        ->args(['smtp://localhost', 'root', '123'])
 
        ->set('logger', Logger::class)
 
        ->set('database', Database::class)
 
        ->alias(OrderController::class, 'oreder_controller')->public()
        ->alias(Database::class, 'database')

        ->alias(GmailMailer::class, 'mailer.gmail')
        ->alias(SmtpMailer::class, 'mailer.smtp')
        // dym
        ->alias(MailerInterface::class, 'mailer.gmail')

        ->alias(SmsTexter::class, 'texter.sms')
        ->alias(SmtpMailer::class, 'mailer.smtp')
        ->alias(FaxTexter::class, 'texter.fax')
        // dynamic 
        ->alias(TexterInterface::class, 'texter.sms')
        ->alias(Logger::class, 'logger');
 };

?>