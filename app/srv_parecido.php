<?php
$service_doc['parecido|like'] =  array(
    'en' => array (
        'pattern' => '/ubigeo/like/PARTIALNAME',
        'description' => 'Searches for ubigeo codes (reniec, inei) for places that match '
                         .'PARTIALNAME',
    ),
    'es' => array(
        'patron' => '/ubigeo/parecido/NOMBREPARCIAL',
        'descripción' => 'Busca los códigos de ubigeo (reniec, inei) para el lugar con un nombre '
                        .'similar a NOMBREPARCIAL',
    )
);

$fparecido = function ($name) use ($app, $db) {
    $key = strtoupper($name);
    $res = get_from_cache($key);
    if ($res === false) {
        $stm = $db->prepare('select * from ubigeo where nombre like :name');
        $stm->bindValue(':name', strtoupper("%${name}%"), PDO::PARAM_STR);
        $stm->execute();
        $res = $stm->fetchAll();
        save_to_cache($key, $res);
    }
    if (empty($res)) {
        $app->getLog()->error('4:badsimilar:'.$name);
        $res = array('error'=>4, 'msg'=>'no existe un lugar con nombre parecido a '.$name);
    }
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/parecido/:name', $fparecido)->name('parecido');
$app->get('/ubigeo/like/:name', $fparecido)->name('like');
