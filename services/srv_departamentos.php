<?php
$service_doc['departamentos'] =  array(
            'patron' => '/ubigeo/departamentos',
            'descripción' => 'Lista los códigos de ubigeo de todos los departamentos',
            );

$app->get('/ubigeo/departamentos', function () use ($db) {
            $rows = $db->query("select * from ubigeo_equiv where nombre_completo like '%//'");
            $res = array();
            while ($row = $rows->fetchAll()){
                $res[] = $row;
            }
            echo json_encode(array(
                    'ubigeo/departamentos'=> array(
                        'ruta' => '/ubigeo/departamentos',
                        'resultado' => $res
                        )
                    ));
        })->name('departamentos');
