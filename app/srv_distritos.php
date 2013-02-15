<?php
$service_doc['distritos|districts'] =  array(
    'en' => array (
        'pattern' => '/ubigeo/districts/DEPARTMENT/PROVINCE',
        'description' => 'Lists the ubigeo codes for all districts for a PROVINCE in a DEPARTMENT',
    ),
    'es' => array(
        'patron' => '/ubigeo/distritos/DEPARTAMENTO/PROVINCIA',
        'descripción' => 'Lista los códigos de ubigeo de los distritos en la PROVINCIA del DEPARTAMENTO',
    )
);

$fdist = function ($dpt, $prov) use ($app, $db)  {
    $dpto = strtoupper($dpt);
    $prov = strtoupper($prov);
    $res = get_from_cache("${dpto}/${prov}/distritos");
    if ($res === false) {
        $rows = $db->query("select reniec from ubigeo where nombreCompleto = '${dpto}/${prov}/'");
        $dpres = $rows->fetchAll();
        if (count($dpres) > 0) {
            $dpcode = $dpres[0]['reniec'];
            preg_match('/(\d{4})\d\d/', $dpcode, $reg);
            $prefix = $reg[1];
            $stmnt = $db->query("select * from ubigeo where reniec like '${prefix}%' and reniec <> '${dpcode}'");
            $res = $stmnt->fetchAll();
            save_to_cache("${dpto}/${prov}/distritos", $res);
        } else {
            $app->getLog()->error('6:badprov:'.$dpto.':'.$prov);
            $res = array('error'=>6, 'msg'=>'no existe una provincia de departamento con nombre '.$dpto.'/'.$prov);
        }
    }
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/distritos/:dpt/:prov', $fdist)->name('distritos');
$app->get('/ubigeo/districts/:dpt/:prov', $fdist)->name('districts');
