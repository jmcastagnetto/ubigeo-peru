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
    $res = get_from_cache('departamentos');
    if ($res === false) {
        $stmt = $db->query("select * from ubigeo where nombreCompleto like '%//'");
        $res = $stmt->fetchAll();
        save_to_cache('departamentos', $res);
    }
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/departamentos', $fdepas)->name('departamentos');
$app->get('/ubigeo/departments', $fdepas)->name('departments');
