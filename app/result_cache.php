<?php


function get_from_cache( $key ) {
    $m = new Memcache();
    $m->connect(getenv("CACHE2_HOST"),getenv("CACHE2_PORT"));
    $res = $m->get($key);
    $m->close();
    return $res;
}

function save_to_cache( $key, $res ) {
    $m = new Memcache();
    $m->connect(getenv("CACHE2_HOST"),getenv("CACHE2_PORT"));
    $op = $m->set($key, $res);
    $m->close();
    return $op;
}
