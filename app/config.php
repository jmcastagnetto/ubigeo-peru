<?php
$service_doc = array();
$db = new PDO("sqlite:../data/ubigeos-pe.sqlite");
$db->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
$active_services = array (
        'codigo',
        'lugar',
        'parecido',
        'departamentos',
        'provincias',
        'distritos',
        );

include 'result_cache.php';
