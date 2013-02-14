<?php
require '../vendor/autoload.php';
require '../app/config.php';

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
$app->contentType('application/json; charset=utf-8');
$app->expires('+1 month');

foreach ($active_services as $service) {
    include_once '../app/srv_'.$service.'.php';
}

$app->notFound(function () use ($app, $service_doc) {
    $req = $app->request();
    if ($req->isGet()) {
        echo json_encode(
        array(
            'description' => array(
                'en' => "REST services to query for Peru's UBIGEO (geographical location code)",
                'es' => "Servicios REST para buscar los códigos de UBIGEO Peruanos",
            ),
            'services' => $service_doc
        ));
    } else {
        $app->halt(405);
    }
});

try {
    $app->run();
} catch (Slim_Exception_Stop $e) {
    // do nothing
}
