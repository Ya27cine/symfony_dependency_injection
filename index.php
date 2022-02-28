<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Mailer\MailerInterface;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

$container->setParameter('mailer.gmail_user', "lior@gmail.com");
$container->setParameter('mailer.gmail_password', "123456");

$container->autowire('oreder_controller', OrderController::class)
   ->setPublic(true);

$container->autowire('database', Database::class);

$container->autowire('mailer.smtp', SmtpMailer::class)
->setArguments(['smtp://localhost', 'root', '123']);

$container->register('texter.fax', FaxTexter::class)  // register <=> autowire + setAutowired 
->setAutowired(true);

$container->autowire('texter.sms', SmsTexter::class)
->setArguments([ "service.sms.com", "apikey123"]);

$container->autowire('mailer.gmail', GmailMailer::class)
->setArguments([ "%mailer.gmail_user%", "%mailer.gmail_password%"]);


$container->setAlias(OrderController::class, 'oreder_controller')->setPublic(true);
$container->setAlias(Database::class, 'database');

$container->setAlias(GmailMailer::class, 'mailer.gmail');
$container->setAlias(SmtpMailer::class, 'mailer.smtp');
// dym
$container->setAlias(MailerInterface::class, 'mailer.gmail');

$container->setAlias(SmsTexter::class, 'texter.sms');
$container->setAlias(SmtpMailer::class, 'mailer.smtp');
$container->setAlias(FaxTexter::class, 'texter.fax');
// dynamic 
$container->setAlias(TexterInterface::class, 'texter.sms');


$container->compile();



$controller = $container->get(OrderController::class);


$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
