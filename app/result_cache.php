<?php
function get_from_cache( $key ) {
    $m = new Memcache());
    $m->connect('tunnel.pagodabox.com',11211);
    $res = $m->get($key, MEMCACHE_COMPRESSED);
    $m->close();
    return $res;
}

function save_to_cache( $key, $res ) {
    $m = new Memcache();
    $m->connect('tunnel.pagodabox.com',11211);
    $op = $m->set($key, $res, MEMCACHE_COMPRESSED);
    $m->close();
    return $op;
}
