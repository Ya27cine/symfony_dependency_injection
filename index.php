<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

//$controller = new OrderController($database, $mailer, $texter);
// $controllerDef = new Definition(OrderController::class, [
//     new Reference('database'),
//     new Reference('mailer.gmail'),
//     new Reference('texter.sms')
// ]);
// $container->setDefinition('oreder_controller', $controllerDef);
// $controllerDef->addMethodCall('sayHello');

$container->register('oreder_controller', OrderController::class)
   ->setArguments([ new Reference('database'), 
                    new Reference('mailer.gmail'), 
                    new Reference('texter.sms')])
    ->addMethodCall('sayHello');

//$database = new Database();
// $databaseDef = new Definition(Database::class);
// $container->setDefinition('database', $databaseDef);
// $database = $container->get('database');
$container->register('database', Database::class);

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
->setArguments([ "lior@gmail.com", "123456"]);


$controller = $container->get('oreder_controller');


$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
