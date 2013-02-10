<?php
$service_doc['distritos'] =  array(
            'patron' => '/ubigeo/distritos/DEPARTAMENTO/PROVINCIA',
            'descripción' => 'Lista los códigos de ubigeo de los distritos en la PROVINCIA del DEPARTAMENTO',
            );

$app->get('/ubigeo/distritos/:dpto/:prov', function ($dpto, $prov) use ($app, $db)  {
            $dpto = strtoupper($dpto);
            $prov = strtoupper($prov);
            $rows = $db->query("select codigo_reniec from ubigeo_equiv where nombre_completo = '${dpto}/${prov}/'");
            $dpres = $rows->fetchAll();
            if (count($dpres) > 0) {
                $dpcode = $dpres[0]['codigo_reniec'];
                preg_match('/(\d{4})\d\d/', $dpcode, $reg);
                $prefix = $reg[1];
                $rows = $db->query("select * from ubigeo_equiv where codigo_reniec like '${prefix}%' and codigo_reniec <> '${dpcode}'");
                $res = array();
                while ($row = $rows->fetchAll()){
                    $res[] = $row;
                }
            } else {
                $app->getLog()->error('6:badprov:'.$dpto.':'.$prov);
                $res = array('error'=>6, 'msg'=>'no existe una provincia de departamento con nombre '.$dpto.'/'.$prov);
            }
            echo json_encode(array(
                    'ubigeo/distritos'=> array(
                        'ruta' => '/ubigeo/distritos/'.$dpto.'/'.$prov,
                        'resultado' => $res
                        )
                    ));
        })->name('distritos');
