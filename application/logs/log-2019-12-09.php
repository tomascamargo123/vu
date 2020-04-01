<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-09 10:03:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/listar_datas
ERROR - 2019-12-09 10:10:42 --> Query error: Unknown column 'esxpediente.id' in 'field list' - Invalid query: SELECT `esxpediente`.`id`, `expediente`.`id` as `codigo`, `expediente`.`ano`, `expediente`.`numero`, `expediente`.`anexo`, (CASE tramite.tipo WHEN 1 THEN "Int." ELSE "Ext." END) as tramite_tipo, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`inicio`, `expediente`.`fojas`, `expediente`.`caratula`, `expediente`.`objeto`, `expediente`.`ayuda_social_id`, (SELECT MAX(anexo)+1 FROM sigmu.expediente e WHERE e.numero=expediente.numero AND e.ano=expediente.ano) as nuevo_anexo, `expediente`.`usuario`
FROM `sigmu`.`expediente`
LEFT JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
ERROR - 2019-12-09 10:18:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= '10000')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10' at line 3 - Invalid query: SELECT *
FROM `sigmu`.`expediente_listar`
WHERE ( = '10000')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-09 10:19:04 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= '2018')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10' at line 3 - Invalid query: SELECT *
FROM `sigmu`.`expediente_listar`
WHERE ( = '2018')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-12-09 10:19:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '= '2018' AND   = '12658')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10' at line 3 - Invalid query: SELECT *
FROM `sigmu`.`expediente_listar`
WHERE ( = '2018' AND   = '12658')
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
