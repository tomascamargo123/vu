<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-06 08:43:39 --> 404 Page Not Found: 
ERROR - 2019-12-06 08:43:40 --> 404 Page Not Found: 
ERROR - 2019-12-06 10:34:12 --> Query error: Unknown column 'cc.DebeCtct' in 'field list' - Invalid query: SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers, IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,'Si','No') AS DeudCome FROM recaudacion.comercio c INNER JOIN recaudacion.inmueble i ON i.CodiInmu = c.CodiInmu INNER JOIN infogov.persona p ON p.CucuPers = i.CucuPers LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall WHERE (p.CucuPers LIKE '20233392880%' OR DetaPers LIKE '%20233392880%' OR c.CodiCome = '20233392880') AND c.FebaCome IS NULL;
ERROR - 2019-12-06 10:34:19 --> Query error: Unknown column 'cc.DebeCtct' in 'field list' - Invalid query: SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers, IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,'Si','No') AS DeudCome FROM recaudacion.comercio c INNER JOIN recaudacion.inmueble i ON i.CodiInmu = c.CodiInmu INNER JOIN infogov.persona p ON p.CucuPers = i.CucuPers LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall WHERE (p.CucuPers LIKE '20233392880%' OR DetaPers LIKE '%20233392880%' OR c.CodiCome = '20233392880') AND c.FebaCome IS NULL;
ERROR - 2019-12-06 10:39:21 --> Query error: Unknown column 'cc.DebeCtct' in 'field list' - Invalid query: SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers, IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,'Si','No') AS DeudCome FROM recaudacion.comercio c INNER JOIN recaudacion.inmueble i ON i.CodiInmu = c.CodiInmu INNER JOIN infogov.persona p ON p.CucuPers = i.CucuPers LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall WHERE (p.CucuPers LIKE '20233392880%' OR DetaPers LIKE '%20233392880%' OR c.CodiCome = '20233392880') AND c.FebaCome IS NULL;
ERROR - 2019-12-06 10:42:38 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 117
ERROR - 2019-12-06 10:42:48 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 117
ERROR - 2019-12-06 10:46:39 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 114
ERROR - 2019-12-06 10:55:43 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = 862
ERROR - 2019-12-06 10:56:18 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 113
ERROR - 2019-12-06 10:56:20 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 113
ERROR - 2019-12-06 11:24:56 --> Severity: Error --> Call to undefined method Datatables::limit() C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 113
ERROR - 2019-12-06 12:15:46 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-06 12:15:47 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-06 12:15:47 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-06 12:15:48 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-06 12:15:48 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
ERROR - 2019-12-06 12:15:52 --> Query error: Unknown column 'pase.respuessta' in 'where clause' - Invalid query: SELECT `pase`.`id`, `expediente`.`id` as `codigo`, `pase`.`ano`, `pase`.`numero`, `pase`.`anexo`, `pase`.`fojas`, `oficina`.`nombre` as `oficina_origen`, `pase`.`fecha_usuario`, `tramite`.`nombre` as `tramite_nombre`, `expediente`.`caratula` as `caratula`, `expediente`.`objeto` as `objeto`, `pase`.`usuario_emisor`, `pase`.`nota_pase_id`, IF(expediente.firma_pendiente = 1 AND tramite.digital = 1, "none", "auto") as show_btn
FROM `sigmu`.`pase`
INNER JOIN `sigmu`.`oficina` ON `oficina`.`id` = `pase`.`origen`
INNER JOIN `sigmu`.`expediente` ON `expediente`.`id` = `pase`.`id_expediente`
INNER JOIN `sigmu`.`tramite` ON `tramite`.`id` = `expediente`.`tramite_id`
WHERE `pase`.`respuessta` = 'pendiente'
AND pase.id_expediente NOT IN (0)
AND `pase`.`destino` = '862'
ORDER BY `fecha_usuario` DESC
 LIMIT 10
