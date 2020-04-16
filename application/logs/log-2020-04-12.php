<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-04-12 14:00:53 --> Query error: Unknown column 'DetaUsua' in 'order clause' - Invalid query: SELECT `CodiUsua`, `id`
FROM `users`
WHERE `CodiUsua` IS NOT NULL
AND `firma_digital` = 1
ORDER BY `DetaUsua` ASC
 LIMIT 10
ERROR - 2020-04-12 14:01:10 --> Query error: Unknown column 'DetaUsua' in 'order clause' - Invalid query: SELECT `CodiUsua`, `id`
FROM `users`
WHERE `CodiUsua` IS NOT NULL
AND `firma_digital` = 1
ORDER BY `DetaUsua` ASC
 LIMIT 10
ERROR - 2020-04-12 14:02:52 --> Query error: Unknown column 'select' in 'order clause' - Invalid query: SELECT `CodiUsua`, `id`
FROM `users`
WHERE `CodiUsua` IS NOT NULL
AND `firma_digital` = 1
ORDER BY `select` ASC
 LIMIT 10
ERROR - 2020-04-12 14:05:09 --> Query error: Unknown column 'DetaUsusa' in 'field list' - Invalid query: SELECT `CodiUsua`, `DetaUsusa`, `id`
FROM `users`
WHERE `CodiUsua` IS NOT NULL
AND `firma_digital` = 1
ORDER BY `CodiUsua` ASC
 LIMIT 10
ERROR - 2020-04-12 14:05:40 --> Query error: Unknown column 'DetaUsua' in 'field list' - Invalid query: SELECT `CodiUsua`, `DetaUsua`, `id`
FROM `users`
WHERE `CodiUsua` IS NOT NULL
AND `firma_digital` = 1
ORDER BY `CodiUsua` ASC
 LIMIT 10
ERROR - 2020-04-12 14:10:00 --> Severity: Parsing Error --> syntax error, unexpected '', last_name) AS DetaUsua, id'' (T_CONSTANT_ENCAPSED_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Usuarios.php 44
ERROR - 2020-04-12 20:10:28 --> Query error: Unknown column 'faa.solicistante_id' in 'where clause' - Invalid query: SELECT COUNT(1) as cantidad
FROM `firmas_archivos_adjuntos` `faa`
WHERE `faa`.`solicistante_id` = '39'
AND `faa`.`estado` = 'Realizada'
AND `faa`.`estado_lectura` = 1
ERROR - 2020-04-12 20:15:24 --> Query error: Table 'expedientes.firmas_archivsos_adjuntos' doesn't exist - Invalid query: SELECT COUNT(1) as cantidad
FROM `firmas_archivsos_adjuntos` `faa`
WHERE `faa`.`usuario_id` = '39'
AND `faa`.`firma` is null
AND `faa`.`estado` = 'Solicitada'
ERROR - 2020-04-12 20:18:26 --> 404 Page Not Found: /index
ERROR - 2020-04-12 20:18:35 --> 404 Page Not Found: /index
