<?php
require '../vendor/autoload.php';

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
    'log.level' => 4,
    'log.enabled' => true,
    'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(array(
        'path' => '../var/logs',
        'name_format' => 'y-m-d'
    ))
));

// Prepare view
$twigView = new \Slim\Extras\Views\Twig();
$twigView->twigOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../var/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view($twigView);

// Define routes
$app->get('/', function () use ($app) {
    $app->render('index.html');
});

// Run app
$app->run();
