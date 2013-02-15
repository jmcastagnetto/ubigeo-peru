<?php
$service_doc['codigo|code'] =  array(
    'en' => array (
        'pattern' => '/ubigeo/code/NNNNNN[/source] (N=0..9; source=reniec|inei|any)',
        'description' => 'Searches for the place with ubigeo code NNNNNN, from the source requested. '
                         .'Valid sources: reniec (default), inei, any',
    ),
    'es' => array(
        'patron' => '/ubigeo/codigo/NNNNNN[/fuente] (N=0..9; fuente=reniec|inei|cualquiera)',
        'descripción' => 'Busca el lugar con código de ubigeo NNNNNN, en la fuente indicada. '
                        .'Fuentes posibles: reniec (usada por defecto), inei, cualquiera',
    )
);

$fcode = function ($ucode, $source='reniec') use ($app, $db)  {
    if (in_array($source, array('reniec', 'inei', 'cualquiera', 'any'))) {
        $res = get_from_cache($ucode.$source);
        if ( $res === false ) {
            $sql = 'select * from ubigeo where ';
            switch ($source) {
                case 'reniec' :
                    $sql .= ' reniec = :codigo';
                    break;
                case 'inei' :
                    $sql .= ' inei = :codigo';
                    break;
                case 'cualquiera' :
                case 'any' :
                    $sql .= ' inei = :codigo or reniec = :codigo';
                    break;
            }
            $stm = $db->prepare($sql);
            $stm->bindValue(':codigo', $ucode, PDO::PARAM_STR);
            $stm->execute();
            $res = $stm->fetchAll();
            save_to_cache( $ucode.$source, $res );
        }
        if (empty($res)) {
            $app->getLog()->error('1:badcode:'.$ucode.':'.$source);
            $res = array('error'=>1, 'msg'=>'no existe el código de ubigeo que ha indicado');
        }
    } else {
        $app->getLog()->error('2:badsource:'.$ucode.':'.$source);
        $res = array('error'=>2,'msg'=>'fuente de código no permitida, usar: reniec, inei, cualquiera');
    }
    echo json_encode(array(
                    $app->request()->getResourceUri() => $res
                ));
};

$app->get('/ubigeo/codigo/:ucode(/:source)', $fcode)->conditions(array('ucode' => '\d{6}'))->name('codigo');
$app->get('/ubigeo/code/:ucode(/:source)', $fcode)->conditions(array('ucode' => '\d{6}'))->name('code');
