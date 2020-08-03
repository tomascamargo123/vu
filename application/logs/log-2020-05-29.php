<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-29 12:08:47 --> Query error: Unknown column 'organigsrama' in 'where clause' - Invalid query: SELECT `tramite`.`id`, (CASE tramite.estado WHEN 0 THEN 'Deshabilitado' ELSE 'Habilitado' END) as estado, `tramite`.`nombre`, (CASE tramite.tipo WHEN 0 THEN 'Externo' ELSE 'Interno' END) as tipo, IF(tramite.digital = TRUE, '', 'display: none') as show_circuito
FROM `sigmu`.`tramite`
WHERE `organigsrama` = '20000'
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2020-05-29 12:08:47 --> Query error: Unknown column 'organigsrama' in 'where clause' - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`tramite`
WHERE `organigsrama` = '20000') SqueryAux
ERROR - 2020-05-29 12:08:47 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551
ERROR - 2020-05-29 12:10:45 --> Query error: Unknown column 'organigsrama' in 'where clause' - Invalid query: SELECT `tramite`.`id`, (CASE tramite.estado WHEN 0 THEN 'Deshabilitado' ELSE 'Habilitado' END) as estado, `tramite`.`nombre`, (CASE tramite.tipo WHEN 0 THEN 'Externo' ELSE 'Interno' END) as tipo, IF(tramite.digital = TRUE, '', 'display: none') as show_circuito
FROM `sigmu`.`tramite`
WHERE `organigsrama` = '20000'
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2020-05-29 12:10:45 --> Query error: Unknown column 'organigsrama' in 'where clause' - Invalid query: SELECT COUNT(*) FROM (SELECT 1 as `row`
FROM `sigmu`.`tramite`
WHERE `organigsrama` = '20000') SqueryAux
ERROR - 2020-05-29 12:10:45 --> Severity: Error --> Call to a member function row_array() on a non-object C:\wamp\www\vu\application\libraries\Datatables.php 551
