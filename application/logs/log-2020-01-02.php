<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-01-02 08:56:22 --> Severity: Warning --> Missing argument 2 for in_groups(), called in C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php on line 2386 and defined C:\wamp\www\vu\application\helpers\permisos_helper.php 22
ERROR - 2020-01-02 08:56:22 --> Severity: Warning --> array_intersect(): Argument #2 is not an array C:\wamp\www\vu\application\helpers\permisos_helper.php 24
ERROR - 2020-01-02 09:24:06 --> Severity: Error --> Call to undefined method stdClass::where() C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 254
ERROR - 2020-01-02 09:24:44 --> Severity: Error --> Call to undefined method stdClass::where() C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 254
ERROR - 2020-01-02 09:30:04 --> Severity: Error --> Call to undefined method Oficinas_model::get_where() C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 254
ERROR - 2020-01-02 09:53:19 --> Query error: Unknown column 'proceso_unitario' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `id` >0
AND `proceso_unitario` != 'B'
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2020-01-02 09:53:20 --> Query error: Unknown column 'proceso_unitario' in 'where clause' - Invalid query: SELECT `oficina`.`id`, `oficina`.`nombre`, (CASE oficina.emisora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS emisora_pase, (CASE oficina.receptora_pase WHEN 1 THEN 'Si' ELSE 'No' END) AS receptora_pase
FROM `sigmu`.`oficina`
WHERE `id` >0
AND `proceso_unitario` != 'B'
ORDER BY `nombre` ASC
 LIMIT 10
ERROR - 2020-01-02 09:54:29 --> Severity: Error --> Call to undefined method Oficinas_model::get_where() C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 255
ERROR - 2020-01-02 09:54:52 --> Severity: Error --> Call to undefined method Oficinas_model::get_where() C:\wamp\www\vu\application\modules\expedientes\controllers\Oficinas.php 255
ERROR - 2020-01-02 13:31:05 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
