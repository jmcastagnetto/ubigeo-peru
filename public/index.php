<?php
require '../vendor/autoload.php';
require_once '../services/services_config.php';

$app = new \Slim\Slim(
    array(
        'log.level' => 4,
        'log.enabled' => true,
        'log.writer' => new \Slim\Extras\Log\DateTimeFileWriter(
            array(
                'path' => '../var/logs',
                'name_format' => 'y-m-d'
            )
        )
    )
);
$app->contentType('application/json');

foreach ($active_services as $service) {
    include_once '../services/srv_'.$service.'.php';
}

$app->notFound(function () use ($service_doc) {
            echo json_encode(array('services'=>$service_doc));
        });

try {
    $app->run();
} catch (Slim_Exception_Stop $e) {
    // do nothing
}

