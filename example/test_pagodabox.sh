#! /bin/bash
host="ubigeo-peru.pagodabox.com";
service_base="http://$host/ubigeo";

function dotest {
	echo "************************";
	echo curl --noproxy 127.0.0.1 -i -H 'Accept: application/json' -X GET $1
	echo
	curl --noproxy 127.0.0.1 -i -H 'Accept: application/json' -X GET $1
	echo
	echo "************************";
	echo
}

# test 1
echo "** (1) Ask for the base URL";
dotest $service_base

# test 2
echo "** (2) Ask for all departments";
dotest "$service_base/departamentos"

# test 3
echo "** (3) Ask for all provinces in a department";
dotest "$service_base/provinces/arequipa"

# test 4
echo "** (4) Ask for all districts in a province";
dotest "$service_base/districts/callao/callao"

# test 5
echo "** (5) Ask for the ubigeo of a department";
dotest "$service_base/place/ancash"

# test 6
echo "** (6) Ask for the ubigeo of a province";
dotest "$service_base/place/amazonas/RODRIGUEZ%20DE%20MENDOZA"

# test 7
echo "** (7) Ask for the ubigeo of a district";
dotest "$service_base/place/Lima/lima/LINCE"

# test 8
echo "** (8) Find the location for the given UBIGEO (RENIEC code)"
dotest "$service_base/code/140133"

# test 9
echo "** (9) Find the location for the given UBIGEO (INEI code)"
dotest "$service_base/code/010102/inei"

# test 10
echo "** (10) Find the location for the given UBIGEO (any code)"
dotest "$service_base/code/150101/any"

# test 11
echo "** (11) Find all places that contain the fragment"
dotest "$service_base/like/calla"

# test 12
echo "** (12) Try an HTTP method that is not allowed"
echo "************************";
echo curl --noproxy 127.0.0.1 -i -H 'Accept: application/json' -X PUT $service_base
echo 
curl --noproxy 127.0.0.1 -i -H 'Accept: application/json' -X PUT $service_base
echo
echo "************************";
echo
