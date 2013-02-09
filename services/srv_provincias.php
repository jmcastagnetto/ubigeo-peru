<?php
$service_doc['provincias'] =  array(
            'patron' => '/ubigeo/provincias/DEPARTAMENTO',
            'descripción' => 'Lista los códigos de ubigeo de las provincias en DEPARTAMENTO',
            );

$app->get('/ubigeo/provincias/:dpto', function ($dpto) use ($app, $db)  {
            $dpto = strtoupper($dpto);
            $rows = $db->query("select codigo_reniec from ubigeo_equiv where nombre_completo = '${dpto}//'");
            $dptores = $rows->fetchAll();
            if (size($dptores) > 0) {
                $dptocode = $dptores['codigo_reniec'];
                preg_match('/(\d\d)\d{4}/', $dptocode, $reg);
                $prefix = $reg[1];
                $rows = $db->query("select * from ubigeo_equiv where codigo_reniec like '${prefix}%00' and codigo_reniec <> '${dptocode}'");
                $res = array();
                while ($row = $rows->fetchAll()){
                    $res[] = $row;
                }
            } else {
                $app->getLog()->error('5:baddpto:'.$dpto);
                $res = array('error'=>5, 'msg'=>'no existe un departamento con nombre '.$dpto);
            }
            echo json_encode(array(
                    'ubigeo/provincias'=> array(
                        'ruta' => '/ubigeo/provincias/'.$dpto,
                        'resultado' => $res
                        )
                    ));
        })->name('provincias');
