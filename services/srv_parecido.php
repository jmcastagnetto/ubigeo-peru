<?php
$service_doc['parecido'] = array(
            'patron' => '/ubigeo/parecido/NOMBREPARCIAL',
            'descripción' => 'Busca los códigos de ubigeo (reniec, inei) para el lugar con un nombre '
                            .'similar a NOMBREPARCIAL',

            );

$app->get('/ubigeo/parecido/:name', function ($name) use ($app, $db) {
            $stm = $db->prepare('select * from ubigeo_equiv where nombre like :name');
            $stm->bindValue(':name', strtoupper("%${name}%"), PDO::PARAM_STR);
            $rows = $stm->execute();
            $res = array();
            while ($row = $rows->fetchAll()){
                $res[] = $row;
            }
            if (empty($res)) {
                $app->getLog()->error('4:badsimilar:'.$name);
                $res = array('error'=>4, 'msg'=>'no existe un lugar con nombre parecido a '.$name);
            }
            echo json_encode(array(
                    'ubigeo/parecido'=> array(
                        'ruta' => '/ubigeo/parecido/'.$name,
                        'resultado' => $res
                        )
                    ));
        })->name('parecido');
