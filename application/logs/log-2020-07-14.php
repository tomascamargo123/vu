<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-07-14 11:28:27 --> Query error: Unknown column 'psase.usuario_derivado' in 'field list' - Invalid query: SELECT `pase`.`id`, IF(expediente.firma_pendiente = 1, "none", "auto") as btn_disabled, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_derivado`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") 
                as show_btn, `pase`.`motivo`, `psase`.`usuario_derivado`
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuesta` = 'resuelto'
AND `pase`.`origen` = '862'
ORDER BY `ano` DESC, `numero` DESC
 LIMIT 10
