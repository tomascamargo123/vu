<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-15 11:15:57 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT foja_hasta FROM expedientes.fojas_archivos_adjuntos WHERE archivo_adjunto_id = 
ERROR - 2020-07-15 11:20:23 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT foja_hasta FROM expedientes.fojas_archivos_adjuntos WHERE archivo_adjunto_id = 
ERROR - 2020-07-15 11:44:12 --> Query error: Subquery returns more than 1 row - Invalid query: SELECT * FROM expedientes.firmas_archivos_adjuntos 
        WHERE id = (SELECT id FROM sigmu.archivoadjunto WHERE pase_id = 1792790)
ERROR - 2020-07-15 12:49:59 --> Query error: Table 'expedsientes.firmas_archivos_adjuntos' doesn't exist - Invalid query: SELECT * FROM expedsientes.firmas_archivos_adjuntos 
        WHERE id IN (SELECT id FROM sigmu.archivoadjunto WHERE pase_id = 1792843)
