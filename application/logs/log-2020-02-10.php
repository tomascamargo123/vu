<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-02-10 08:47:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Archivos_adjuntos/listar
ERROR - 2020-02-10 08:47:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Archivos_adjuntos/plugins
ERROR - 2020-02-10 08:47:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Archivos_adjuntos/apple-touch-icon.png
ERROR - 2020-02-10 08:47:49 --> Severity: Warning --> Missing argument 1 for Archivos_adjuntos::listar_data() C:\wamp\www\vu\application\modules\expedientes\controllers\Archivos_adjuntos.php 24
ERROR - 2020-02-10 09:04:46 --> Query error: Table 'expedientes.firmas_circuitos' doesn't exist - Invalid query: SELECT `id`, `descripcion`
FROM `cargos`
WHERE `id` NOT IN (SELECT cargo_id FROM firmas_circuitos fc JOIN circuitos c ON fc.circuito_id=c.id WHERE c.plantilla_id=21)
ORDER BY `id`
ERROR - 2020-02-10 09:04:58 --> Query error: Table 'expedientes.firmas_circuitos' doesn't exist - Invalid query: SELECT `cargos`.`descripcion`, `users`.`first_name`, `users`.`last_name`, `users`.`username`, `firmas_circuitos`.`orden`, `firmas_circuitos`.`id`
FROM `firmas_circuitos`
JOIN `circuitos` ON `circuitos`.`id`=`firmas_circuitos`.`circuito_id`
JOIN `cargos` ON `cargos`.`id`=`firmas_circuitos`.`cargo_id`
LEFT JOIN `cargos_usuarios` ON `cargos_usuarios`.`cargo_id`=`cargos`.`id`
LEFT JOIN `users` ON `cargos_usuarios`.`user_id`=`users`.`id`
WHERE `plantilla_id` = '21'
AND `cargos_usuarios`.`hasta` IS NULL
ERROR - 2020-02-10 11:56:07 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\views\oficinas\oficinas_abm.php 52
ERROR - 2020-02-10 11:56:41 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\views\oficinas\oficinas_abm.php 52
ERROR - 2020-02-10 12:03:34 --> Severity: Warning --> Invalid argument supplied for foreach() C:\wamp\www\vu\application\modules\expedientes\views\oficinas\oficinas_abm.php 52
