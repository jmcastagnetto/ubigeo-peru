<?php
$service_doc['codigo'] =  array(
            'patron' => '/ubigeo/codigo/NNNNNN[/fuente] (N=0..9)',
            'descripción' => 'Busca el lugar con código de ubigeo NNNNNN, en la fuente indicada. '
                            .'Fuentes posibles: reniec (usada por defecto), inei, cualquiera',
            );

$app->get('/ubigeo/codigo/:code(/:source)', function ($code, $source='reniec') use ($app, $db)  {
            if (in_array($source, array('reniec', 'inei', 'cualquiera'))) {
                $sql = 'select * from ubigeo_equiv where ';
                switch ($source) {
                    case 'reniec' :
                        $sql .= ' codigo_reniec = :codigo';
                        break;
                    case 'inei' :
                        $sql .= ' codigo_inei = :codigo';
                        break;
                    case 'cualquiera' :
                        $sql .= ' codigo_inei = :codigo or codigo_reniec = :codigo';
                        break;
                }
                $stm = $db->prepare($sql);
                $stm->bindValue(':codigo', $code, PDO::PARAM_STR);
                $stm->execute();
                $rows = $stm->fetchAll();
                if (empty($rows)) {
                    $app->getLog()->error('1:badcode:'.$code.':'.$source);
                    $res = array('error'=>1, 'msg'=>'no existe el código de ubigeo que ha indicado');
                } else {
                    $res = $rows;
                }
            } else {
                $app->getLog()->error('2:badsource:'.$code.':'.$source);
                $res = array('error'=>2,'msg'=>'fuente de código no permitida, usar: reniec, inei, cualquiera');
            }
            echo json_encode(array(
                        'ubigeo/codigo'=>array(
                            'ruta' => '/ubigeo/codigo/'.$code.'/'.$source,
                            'resultado' => $res
                            )
                        ));
        })->conditions(array('code' => '\d{6}'))->name('codigo');
