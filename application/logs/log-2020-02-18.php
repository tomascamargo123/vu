<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-02-18 08:54:22 --> 404 Page Not Found: /index
ERROR - 2020-02-18 08:54:23 --> 404 Page Not Found: /index
ERROR - 2020-02-18 11:50:24 --> 404 Page Not Found: /index
ERROR - 2020-02-18 12:07:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/editar
ERROR - 2020-02-18 12:07:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2020-02-18 12:07:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/apple-touch-icon.png
ERROR - 2020-02-18 12:11:01 --> Query error: Unknown column 'expedientse.id' in 'field list' - Invalid query: SELECT pase.id, expedientse.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente", "display:none;", "") as btn_hide_btn_others, IF(pase.revision_id > 0, "", "display:none;") as btn_show_button, revision_id
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE (`expediente`.`digital` >0)
AND `pase`.`origen` = '1'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR `pase`.`respuesta` = 'firma pendiente' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-02-18 12:11:09 --> Query error: Unknown column 'expedientse.id' in 'field list' - Invalid query: SELECT pase.id, expedientse.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente", "display:none;", "") as btn_hide_btn_others, IF(pase.revision_id > 0, "", "display:none;") as btn_show_button, revision_id
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE (`expediente`.`digital` >0)
AND `pase`.`origen` = '1'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR `pase`.`respuesta` = 'firma pendiente' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-02-18 12:13:25 --> Query error: Unknown column 'expediente.sid' in 'field list' - Invalid query: SELECT pase.id, expediente.sid as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '1'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-02-18 12:15:01 --> Query error: Unknown column 'expediente.sid' in 'field list' - Invalid query: SELECT pase.id, expediente.sid as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '1'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-02-18 12:26:17 --> Query error: Unknown column 'expediente.sid' in 'field list' - Invalid query: SELECT pase.id, expediente.sid as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '1'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND (`expediente`.`digital` =0)
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
ERROR - 2020-02-18 12:28:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar
ERROR - 2020-02-18 12:28:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
