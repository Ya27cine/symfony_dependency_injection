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
$controllerDef = new Definition(OrderController::class, [
    new Reference('database'),
    new Reference('mailer.gmail'),
    new Reference('texter.sms')
]);
$container->setDefinition('oreder_controller', $controllerDef);



//$database = new Database();
$databaseDef = new Definition(Database::class);
$container->setDefinition('database', $databaseDef);
// $database = $container->get('database');

//$texter = new SmsTexter("service.sms.com", "apikey123");
$texterDef = new Definition(SmsTexter::class,[ "service.sms.com", "apikey123"]);
$container->setDefinition('texter.sms', $texterDef);
// $texter = $container->get('texter.sms');

//$mailer = new GmailMailer("lior@gmail.com", "123456");
$mailerDef = new Definition(GmailMailer::class, [ "lior@gmail.com", "123456"]);
$container->setDefinition('mailer.gmail', $mailerDef);
// $mailer = $container->get('mailer.gmail');


$controller = $container->get('oreder_controller');


$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
