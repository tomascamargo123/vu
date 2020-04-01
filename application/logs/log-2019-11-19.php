<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-11-19 09:18:31 --> Query error: Unknown column 'dinamica' in 'field list' - Invalid query: SELECT `id`, `nombre`, `texto`, `firmapad`, `cabecera`, `pie`, `dinamica`
FROM `sigmu`.`plantilla`
WHERE `sigmu`.`plantilla`.`id` = '21'
ERROR - 2019-11-19 10:35:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listas_pendientes_e_data
ERROR - 2019-11-19 10:35:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-19 10:35:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/apple-touch-icon.png
ERROR - 2019-11-19 10:38:40 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::exact_where_column() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 184
ERROR - 2019-11-19 10:38:49 --> Query error: Not unique table/alias: 'pase' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM (`sigmu`.`pase`, `sigmu`.`pase`)
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
AND `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ERROR - 2019-11-19 10:53:42 --> Query error: Not unique table/alias: 'pase' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM (`sigmu`.`pase`, `sigmu`.`pase`)
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
AND `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ERROR - 2019-11-19 11:09:29 --> Query error: Not unique table/alias: 'pase' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM (`sigmu`.`pase`, `sigmu`.`pase`)
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
AND `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-11-19 11:25:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar_pendientes_e_daa
ERROR - 2019-11-19 11:25:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-19 11:25:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/apple-touch-icon.png
ERROR - 2019-11-19 11:25:16 --> Query error: Unknown column 'pase.desstino' in 'where clause' - Invalid query: SELECT pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`desstino` = -2)
AND (`expediente`.`digital` =0)
ERROR - 2019-11-19 11:45:22 --> Severity: Error --> Call to undefined method CI_DB_mysqli_driver::unset_column() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 433
ERROR - 2019-11-19 11:45:29 --> Query error: Not unique table/alias: 'pase' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`fojas`, `pase`.`usuario_emisor`, `oficina`.`nombre` as `oficina_destino`, `pase`.`fecha_usuario`, `pase`.`nota_pase_id`, `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`fojas`, `pase`.`usuario_emisor`, `oficina`.`nombre` as `oficina_destino`, `pase`.`fecha_usuario`, `pase`.`nota_pase_id`
FROM (`sigmu`.`pase`, `sigmu`.`pase`)
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`destino`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente` AND `expediente`.`digital` = 0
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`destino`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente` AND `expediente`.`digital` = 0
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'pendiente'
AND `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'pendiente'
ERROR - 2019-11-19 11:46:20 --> Query error: Unknown column 'pase.resspuesta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`fojas`, `pase`.`usuario_emisor`, `oficina`.`nombre` as `oficina_destino`, `pase`.`fecha_usuario`, `pase`.`nota_pase_id`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`destino`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente` AND `expediente`.`digital` = 0
WHERE `pase`.`origen` = '862'
AND `pase`.`resspuesta` = 'pendiente'
ERROR - 2019-11-19 11:53:57 --> Query error: Unknown column 'pase.resspuesta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`fojas`, `pase`.`usuario_emisor`, `oficina`.`nombre` as `oficina_destino`, `pase`.`fecha_usuario`, `pase`.`nota_pase_id`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`destino`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente` AND `expediente`.`digital` = 0
WHERE `pase`.`origen` = '862'
AND `pase`.`resspuesta` = 'pendiente'
ORDER BY `codigo` DESC, `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2019-11-19 11:56:22 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '! '-1'
ORDER BY `codigo` DESC, `ano` DESC, `numero` DESC
 LIMIT 10' at line 7 - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`fojas`, `pase`.`usuario_emisor`, `oficina`.`nombre` as `oficina_destino`, `pase`.`fecha_usuario`, `pase`.`nota_pase_id`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`destino`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente` AND `expediente`.`digital` = 0
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'pendiente'
AND pase.destino ! '-1'
ORDER BY `codigo` DESC, `ano` DESC, `numero` DESC
 LIMIT 10
