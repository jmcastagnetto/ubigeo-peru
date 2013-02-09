<?php
$service_doc['lugar'] = array(
            'patron' => '/ubigeo/lugar/DEPARTAMENTO[/PROVINCIA][/DISTRITO]',
            'descripción' => 'Busca los códigos de ubigeo (reniec, inei) para el lugar indicado por '
                            .'el DEPARTAMENTO/PROVINCIA/DISTRITO (los últimos dos parámetros son opcionales)',
            );

$app->get('/ubigeo/lugar/:dpto(/:prov(/:dist))', function ($dpto, $prov='', $dist='') use ($app, $db) {
            $stm = $db->prepare('select * from ubigeo_equiv where nombre_completo = :lugar');
            $stm->bindValue(':lugar', strtoupper("${dpto}/${prov}/${dist}"), PDO::PARAM_STR);
            $res = $stm->execute()->fetchAll();
            if (size($res) === 0) {
                $app->getLog()->error('3:badlocation:'.$dpto.'/'.$prov.'/'.$dist);
                $res = array('error'=>3, 'msg'=>'no existe el lugar que ha indicado');
            }
            echo json_encode(array(
                    'ubigeo/lugar'=> array(
                        'ruta' => "/ubigeo/lugar/${dpto}/${prov}/${dist}",
                        'resultado' => $res
                        )
                    ));
        })->name('lugar');
