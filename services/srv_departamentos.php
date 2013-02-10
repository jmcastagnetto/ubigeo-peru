<?php
$service_doc['departamentos|departments'] =  array(
    'en' => array (
        'pattern' => '/ubigeo/departments',
        'description' => 'Lists the ubigeo codes for all departments',
    ),
    'es' => array(
        'patron' => '/ubigeo/departamentos',
        'descripción' => 'Lista los códigos de ubigeo de todos los departamentos',
    )
);

$fdepas = function () use ($app, $db) {
    $stmt = $db->query("select * from ubigeo_equiv where nombre_completo like '%//'");
    $res = $stmt->fetchAll();
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/departamentos', $fdepas)->name('departamentos');
$app->get('/ubigeo/departments', $fdepas)->name('departments');
