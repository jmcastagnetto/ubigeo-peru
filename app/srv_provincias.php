<?php
$service_doc['provincias|provinces'] =  array(
    'en' => array (
        'pattern' => '/ubigeo/provinces/DEPARTMENT',
        'description' => 'Lists the ubigeo codes for all provinces in DEPARTMENT',
    ),
    'es' => array(
        'patron' => '/ubigeo/provincias/DEPARTAMENTO',
        'descripción' => 'Lista los códigos de ubigeo de las provincias en DEPARTAMENTO',
    )
);

$fprovs = function ($dpt) use ($app, $db)  {
    $dpto = strtoupper($dpt);
    $res = get_from_cache($dpto.'/provincias');
    if ($res === false) {
        $rows = $db->query("select reniec from ubigeo where nombreCompleto = '${dpto}//'");
        $dptores = $rows->fetchAll();
        if (count($dptores) > 0) {;
            $dptocode = $dptores[0]['reniec'];
            preg_match('/(\d\d)\d{4}/', $dptocode, $reg);
            $prefix = $reg[1];
            $stmt = $db->query("select * from ubigeo where reniec like '${prefix}%00' and reniec <> '${dptocode}'");
            $res = $stmt->fetchAll();
            save_to_cache( $dpto.'/provincias', $res);
        } else {
            $app->getLog()->error('5:baddpto:'.$dpto);
            $res = array('error'=>5, 'msg'=>'no existe un departamento con nombre '.$dpto);
        }
    }
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/provincias/:dpt', $fprovs)->name('provincias');
$app->get('/ubigeo/provinces/:dpt', $fprovs)->name('provinces');
