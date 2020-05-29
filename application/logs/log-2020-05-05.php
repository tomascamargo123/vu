<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-05 11:38:49 --> Query error: Table 'expedientes.firmas_archidvos_adjuntos' doesn't exist - Invalid query: SELECT `faa`.`id`, `faa`.`fecha_solicitud`, `faa`.`fecha_firma`, UPPER(faa.estado) AS estado, `faa`.`firma`, `u`.`CodiUsua` as `usuario`, `u`.`first_name` as `usuario_nombre`, `u`.`last_name` as `usuario_apellido`, `s`.`CodiUsua` as `solicitante`, `s`.`first_name` as `solicitante_nombre`, `s`.`last_name` as `solicitante_apellido`, `uk`.`public_key`, `c`.`descripcion` as `cargo`
FROM `firmas_archidvos_adjuntos` `faa`
JOIN `users` `u` ON `u`.`id`=`faa`.`usuario_id`
LEFT JOIN `users` `s` ON `s`.`id`=`faa`.`solicitante_id`
LEFT JOIN `users_keys` `uk` ON `uk`.`user_id`=`faa`.`usuario_id` AND `faa`.`fecha_firma` >= `uk`.`created_on` AND `faa`.`fecha_firma` <= COALESCE(uk.disabled_on, '2100-01-01')
LEFT JOIN cargos_usuarios cu ON cu.user_id=u.id AND faa.fecha_firma BETWEEN cu.desde AND COALESCE(cu.hasta, '2100-01-01')
LEFT JOIN `cargos` `c` ON `c`.`id`=`cu`.`cargo_id`
WHERE `faa`.`archivo_adjunto_id` = '317'
AND `faa`.`estado` != 'Rechazada'
ERROR - 2020-05-05 11:38:49 --> Severity: Error --> Call to a member function result() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Firmas_archivos_adjuntos_model.php 41
