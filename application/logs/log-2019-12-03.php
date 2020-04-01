<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-12-03 09:40:23 --> Invalid query: 
ERROR - 2019-12-03 09:40:23 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-03 09:40:28 --> 404 Page Not Found: /index
ERROR - 2019-12-03 09:40:41 --> Query error: Table 'expedientes.tramite' doesn't exist - Invalid query: SELECT * FROM tramite
ERROR - 2019-12-03 09:40:41 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-03 09:42:47 --> Query error: Table 'expedientes.tramite' doesn't exist - Invalid query: SELECT * FROM tramite
ERROR - 2019-12-03 09:42:47 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-03 09:42:47 --> 404 Page Not Found: /index
ERROR - 2019-12-03 09:43:33 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near '' at line 1 - Invalid query: SELECT * FROM sigmu.tramite WHERE id = #{tramite_id}
ERROR - 2019-12-03 09:43:33 --> Severity: Error --> Call to a member function list_fields() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 99
ERROR - 2019-12-03 10:31:50 --> Query error: Unknown column 'cc.DebeCtct' in 'field list' - Invalid query: SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers, IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,'Si','No') AS DeudCome FROM recaudacion.comercio c INNER JOIN recaudacion.inmueble i ON i.CodiInmu = c.CodiInmu INNER JOIN infogov.persona p ON p.CucuPers = i.CucuPers LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall WHERE (p.CucuPers LIKE '27146149788%' OR DetaPers LIKE '%27146149788%' OR c.CodiCome = '27146149788') AND c.FebaCome IS NULL;
ERROR - 2019-12-03 10:31:50 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 133
ERROR - 2019-12-03 10:31:51 --> Query error: Unknown column 'cc.DebeCtct' in 'field list' - Invalid query: SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers, IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,'Si','No') AS DeudCome FROM recaudacion.comercio c INNER JOIN recaudacion.inmueble i ON i.CodiInmu = c.CodiInmu INNER JOIN infogov.persona p ON p.CucuPers = i.CucuPers LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall WHERE (p.CucuPers LIKE '27146149788%' OR DetaPers LIKE '%27146149788%' OR c.CodiCome = '27146149788') AND c.FebaCome IS NULL;
ERROR - 2019-12-03 10:31:51 --> Severity: Error --> Call to a member function result_array() on a non-object C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 133
ERROR - 2019-12-03 11:53:41 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:49 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:11:49 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:12:23 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:24 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:25 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:32 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:32 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:22:32 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:24:07 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:24:07 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:24:07 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:25:37 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:25:45 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:25:45 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:27:55 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:27:55 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:38 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:38 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:38 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:39 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:45 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:45 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:45 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:48 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:49 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:49 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:28:49 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:33 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:38 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:38 --> 404 Page Not Found: /index
ERROR - 2019-12-03 12:32:38 --> 404 Page Not Found: /index
