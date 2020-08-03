<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-06-30 11:24:57 --> Query error: Table 'sigmu.ofsicina' doesn't exist - Invalid query: SELECT tramite.nombre as tramite_nombre, pase.id, expediente.id as codigo, pase.id_expediente as idexpediente, pase.ano, pase.numero, pase.anexo, pase.fojas, oficina.nombre as oficina_origen, expediente.caratula as caratula, expediente.objeto as objeto, pase.nota_pase_id, pase.usuario_emisor, pase.fecha_usuario, IF(expediente.firma_pendiente = 1, "display: none;", "") as btn_disabled, IF(pase.etapa_circuito > 0, "", "") as btn_salir_circuito, IF(pase.revision_id > 0 AND pase.respuesta <> "firma pendiente", "display:none;", "") as btn_hide_btn_others, IF(pase.revision_id > 0, "", "display:none;") as btn_show_button, revision_id
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`ofsicina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`origen` = '862'
AND (`pase`.`respuesta` = 'pendiente' OR `pase`.`respuesta` = 'rechazado' OR `pase`.`respuesta` = 'firma pendiente' OR (`pase`.`origen` = 1 AND pase.respuesta = 'finalizado'))
AND (`pase`.`destino` = -1 OR `pase`.`destino` = -2)
AND `expediente`.`digital` = 1
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
