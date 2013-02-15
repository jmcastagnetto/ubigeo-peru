<?php
function get_from_cache( $key ) {
    $m = new Memcached('result_cache');
    $m->addServer('tunnel.pagodabox.com',11211);
    $res = $m->get($key);
    return $res;
}

function save_to_cache( $key, $res ) {
    $m = new Memcached('result_cache');
    $m->addServer('tunnel.pagodabox.com',11211);
    $op = $m->set($key, $res);
    return $op;
}
