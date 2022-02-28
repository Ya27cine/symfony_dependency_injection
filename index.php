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



//$controller = new OrderController($database, $mailer, $texter);
// $controllerDef = new Definition(OrderController::class, [
//     new Reference('database'),
//     new Reference('mailer.gmail'),
//     new Reference('texter.sms')
// ]);
// $container->setDefinition('oreder_controller', $controllerDef);
// $controllerDef->addMethodCall('sayHello');

$container->register('oreder_controller', OrderController::class)
   ->setPublic(true)
   ->setAutowired(true)
//    ->setArguments([ new Reference(Database::class), 
//                     new Reference(GmailMailer::class), 
//                     new Reference(SmsTexter::class)])
    ->addMethodCall('sayHello');

//$database = new Database();
// $databaseDef = new Definition(Database::class);
// $container->setDefinition('database', $databaseDef);
// $database = $container->get('database');
$container->register('database', Database::class);

$container->register('mailer.smtp', SmtpMailer::class)
->setArguments(['smtp://localhost', 'root', '123']);

$container->register('texter.fax', FaxTexter::class);


//$texter = new SmsTexter("service.sms.com", "apikey123");
// $texterDef = new Definition(SmsTexter::class,[ "service.sms.com", "apikey123"]);
// $container->setDefinition('texter.sms', $texterDef);
// $texter = $container->get('texter.sms');
$container->register('texter.sms', SmsTexter::class)
->setArguments([ "service.sms.com", "apikey123"]);

//$mailer = new GmailMailer("lior@gmail.com", "123456");
// $mailerDef = new Definition(GmailMailer::class, [ "lior@gmail.com", "123456"]);
// $container->setDefinition('mailer.gmail', $mailerDef);
// $mailer = $container->get('mailer.gmail');
$container->register('mailer.gmail', GmailMailer::class)
->setArguments([ "%mailer.gmail_user%", "%mailer.gmail_password%"]);

$container->compile();



$controller = $container->get(OrderController::class);


$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
