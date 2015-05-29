---
title: ubigeo-peru
author: Jesus M. Castagnetto
date: 2013,2014
---

# ubigeo-peru: REST service for UBIGEO code search 

REST services to query for Peru's [UBIGEO][ubigeo-en-wiki] (Peru's
geographical location code)

Built using PHP closures with the [Slim Framework][slim-url]. 

Officially, the UBIGEO codes are assigned by INEI, but in practice the codes
given by RENIEC are used (the codes do not match). I have matched the codes
and normalize the names, so this web app gives both codes whenever possible.

Demo deployed at [Pagodabox][pagodabox-url] at the base URL:

http://ubigeo-peru.gopagoda.io/

If you go to the base URL, you will see the documentation of the services.

All the output is in JSON with utf-8 character encoding

## Services

* code:
  * /ubigeo/code/NNNNNN{/source} (N=0..9; source=reniec|inei|any)
  * Searches for the place with ubigeo code NNNNNN, from the source requested. 
    Valid sources: reniec (default), inei, any

* place:
  * /ubigeo/place/DEPARTMENT{/PROVINCE{/DISTRICT}}
  * Searches for the ubigeo codes (reniec, inei) for the place given as 
    /DEPARTMENT{/PROVINCE{/DISTRICT}} (the last 2 parameters are optional)

* like:
  * /ubigeo/like/PARTIALNAME
  * Searches for ubigeo codes (reniec, inei) for places that match PARTIALNAME

* departments:
  * /ubigeo/departments
  * Lists the ubigeo codes for all departments

* provinces:
  * /ubigeo/provinces/DEPARTMENT
  * Lists the ubigeo codes for all provinces in DEPARTMENT

* districts:
  * /ubigeo/districts/DEPARTMENT/PROVINCE
  * Lists the ubigeo codes for all districts for a PROVINCE in a DEPARTMENT


## Examples of use:

* Find the location for the given UBIGEO (RENIEC code)
  * http://example.com/ubigeo/code/140133

* Find the location for the given UBIGEO (INEI code)
  * http://example.com/ubigeo/code/010102/inei

* Find the location for the given UBIGEO (any code)
  * http://example.com/ubigeo/code/020601/cualquiera

* Show the ubigeo for the given department
  * http://example.com/ubigeo/place/ancash

* Show the ubigeo for the given province
  * http://example.com/ubigeo/place/amazonas/RODRIGUEZ%20DE%20MENDOZA

* Show the ubigeo for the given district
  * http://example.com/ubigeo/place/Lima/LIMA/lince

* Show all departments
  * http://example.com/ubigeo/departments

* Show all provinces in a department
  * http://example.com/ubigeo/provinces/arequipa

* Show all districts in a department's province
  * http://example.com/ubigeo/districts/callao/callao

* Show all places that contain the fragment
  * http://example.com/ubigeo/like/rosa


# ubigeo-peru: Servicios REST para la búsqueda de UBIGEO

Servicios REST para buscar los códigos de [UBIGEO][ubigeo-es-wiki] Peruanos.

Construido empleando closures en PHP con [Slim Framework][slim-url].

Oficialmente, los códigos de UBIGEO son asignados por INEI, pero en la práctica
todos usan los asignados por RENIEC (las codificaciones son distintas). He
emparejado los códigos de ambas fuentes y normalizados los nombres, de manera
que este aplicativo web produce ambos códigos cuando esto es posible.

El aplicativo se encuentra funcionando en [Pagodabox][pagodabox-url] en la URL
de base:

http://ubigeo-peru.gopagoda.io/

Si navegas a la URL base, podrás ver la documentación de los servicios

Todas las salidas estan en JSON con codificación de caracteres utf-8

## Servicios

* código:
  * /ubigeo/codigo/NNNNNN{/fuente} (N=0..9; fuente=reniec|inei|cualquiera)
  * Busca el lugar con código de ubigeo NNNNNN, en la fuente indicada. 
    Fuentes posibles: reniec (usada por defecto), inei, cualquiera

* lugar:
  * /ubigeo/lugar/DEPARTAMENTO{/PROVINCIA{/DISTRITO}}
  * Busca los códigos de ubigeo (reniec, inei) para el lugar indicado por el
    /DEPARTAMENTO/PROVINCIA/DISTRITO (los últimos dos parámetros son opcionales)

* parecido:
  * /ubigeo/parecido/NOMBREPARCIAL
  * Busca los códigos de ubigeo (reniec, inei) para el lugar con un nombre 
    similar a NOMBREPARCIAL

* departamentos:
  * /ubigeo/departamentos
  * Lista los códigos de ubigeo de todos los departamentos

* provincias:
  * /ubigeo/provincias/DEPARTAMENTO
  * Lista los códigos de ubigeo de las provincias en DEPARTAMENTO

* distritos:
  * /ubigeo/distritos/DEPARTAMENTO/PROVINCIA
  * Lista los códigos de ubigeo de los distritos en la PROVINCIA del DEPARTAMENTO

## Ejemplos de uso:

* Locación dado un ubigeo, asume por defecto que es el UBIGEO de reniec
  * http://example.com/ubigeo/codigo/140133

* Locación dado un ubigeo, indicando que es el de inei
  * http://example.com/ubigeo/codigo/010102/inei

* Locación dado un ubigeo, indicando que puede ser cualquiera
  * http://example.com/ubigeo/codigo/020601/cualquiera

* Mostrar ubigeo del departamento
  * http://example.com/ubigeo/lugar/ancash

* Mostrar ubigeo de la provincia
  * http://example.com/ubigeo/lugar/amazonas/RODRIGUEZ%20DE%20MENDOZA

* Mostrar ubigeo del distrito
  * http://example.com/ubigeo/lugar/Lima/LIMA/lince

* Mostrar todos los departamentos
  * http://example.com/ubigeo/departamentos

* Mostrar todos las provincias en un departamento
  * http://example.com/ubigeo/provincias/arequipa

* Mostrar todos los distritos en una provincia de un departamento
  * http://example.com/ubigeo/distritos/callao/callao

* Mostrar los lugares con nombres parecidos a un fragmento
  * http://example.com/ubigeo/parecido/rosa


[ubigeo-en-wiki]: http://en.wikipedia.org/wiki/UBIGEO
[ubigeo-es-wiki]: http://es.wikipedia.org/wiki/UBIGEO
[slim-url]: http://slimframework.com/
[pagodabox-url]: https://pagodabox.com/

## License and Copyright

**BSD 2-clause license**

Copyright (c) 2013, Jesus M. Castagnetto
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

- Redistributions of source code must retain the above copyright notice, this
  list of conditions and the following disclaimer.
- Redistributions in binary form must reproduce the above copyright notice,
  this list of conditions and the following disclaimer in the documentation
  and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
