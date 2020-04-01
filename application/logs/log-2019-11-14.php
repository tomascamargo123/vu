<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<<<<<<< .mine
<<<<<<< .mine
ERROR - 2019-11-14 08:38:08 --> 404 Page Not Found: /index
ERROR - 2019-11-14 08:54:53 --> 404 Page Not Found: /index
ERROR - 2019-11-14 08:56:20 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:03:14 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:06:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:06:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'where FROM sigmu.campos WHERE consulta_id = 1' at line 1 - Invalid query: SELECT id,campo as name,alias,consulta_id,where FROM sigmu.campos WHERE consulta_id = 1;
ERROR - 2019-11-14 09:07:54 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:09:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:11:08 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:12:05 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:13:15 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:14:01 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:14:35 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:15:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:16:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:16:51 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:17:33 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:18:45 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:18:58 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:26:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:27:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:28:36 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:29:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:37:38 --> 404 Page Not Found: /index
ERROR - 2019-11-14 10:28:09 --> 404 Page Not Found: /index
ERROR - 2019-11-14 10:28:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:43:28 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:45:02 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:47:02 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:42:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:44:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:10 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:28 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:52:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:53:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:55:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:57:46 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:59:17 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:59:30 --> 404 Page Not Found: /index
ERROR - 2019-11-14 13:58:55 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:34:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:35:40 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:07 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:16 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (`consulta`, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, \'s/n\', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE \'#{concecion_baja_persona_cuil}\' OR p.DetaPers LIKE \'%#{concecion_baja_persona_cuil}%\') AND (c.FebaCome IS NULL OR c.FebaCome = \'0000-00-00\') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:42:30 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:41 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (`consulta`, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, \'s/n\', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE \'#{concecion_baja_persona_cuil}\' OR p.DetaPers LIKE \'%#{concecion_baja_persona_cuil}%\') AND (c.FebaCome IS NULL OR c.FebaCome = \'0000-00-00\') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:43:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:43:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall ' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES (SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;, 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:44:50 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:44:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:46:00 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:46:04 --> Severity: Notice --> Undefined index:  C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 45
ERROR - 2019-11-14 14:46:04 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:48:34 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:48:40 --> Severity: Notice --> Undefined offset: 1 C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 45
ERROR - 2019-11-14 14:48:40 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:49:04 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:49:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:50:19 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:51:09 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ("SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:54:55 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:55:00 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: UPDATE `consulta` SET consulta = "SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", `titulo` = 'Busqueda de datos Comercio a concecionar baja', `alias` = 'baja_concecion', `colums_table` = 'Cuil,Codigo comercio,Titular,Calle', `placeholder` = 'Cuit o Nombre'
WHERE `id` = '7'
ERROR - 2019-11-14 14:55:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:55:54 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: UPDATE `consulta` SET consulta = "SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall INNER JOIN infogov.persona p ON p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", `titulo` = 'Busqueda de datos Comercio a concecionar baja', `alias` = 'baja_concecion', `colums_table` = 'Cuil,Codigo comercio,Titular,Calle', `placeholder` = 'Cuit o Nombre'
WHERE `id` = '7'
ERROR - 2019-11-14 14:56:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:56:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:57:56 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:58:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:00 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:59:36 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 15:02:20 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 15:02:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:03:38 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:04:18 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:04:22 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 15:05:40 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:05:44 --> Could not find the language line "insert_batch() called with no data"
||||||| .r34
ERROR - 2019-11-14 09:13:17 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291212, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:13:16', '43', '2019/11/14 09:13:16', 'I')
||||||| .r36
ERROR - 2019-11-14 09:13:17 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291212, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:13:16', '43', '2019/11/14 09:13:16', 'I')
=======
<<<<<<< .mineERROR - 2019-11-14 08:38:08 --> 404 Page Not Found: /index
ERROR - 2019-11-14 08:54:53 --> 404 Page Not Found: /index
ERROR - 2019-11-14 08:56:20 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:03:14 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:06:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:06:13 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'where FROM sigmu.campos WHERE consulta_id = 1' at line 1 - Invalid query: SELECT id,campo as name,alias,consulta_id,where FROM sigmu.campos WHERE consulta_id = 1;
ERROR - 2019-11-14 09:07:54 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:09:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:11:08 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:12:05 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:13:15 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:14:01 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:14:35 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:15:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:16:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:16:51 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:17:33 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:18:45 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:18:58 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:26:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:27:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:28:36 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:29:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 09:37:38 --> 404 Page Not Found: /index
ERROR - 2019-11-14 10:28:09 --> 404 Page Not Found: /index
ERROR - 2019-11-14 10:28:29 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:43:28 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:45:02 --> 404 Page Not Found: /index
ERROR - 2019-11-14 11:47:02 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:42:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:44:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:10 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:28 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:46:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:52:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:53:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:55:13 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:57:46 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:59:17 --> 404 Page Not Found: /index
ERROR - 2019-11-14 12:59:30 --> 404 Page Not Found: /index
ERROR - 2019-11-14 13:58:55 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:34:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:35:40 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:07 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:16 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (`consulta`, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, \'s/n\', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE \'#{concecion_baja_persona_cuil}\' OR p.DetaPers LIKE \'%#{concecion_baja_persona_cuil}%\') AND (c.FebaCome IS NULL OR c.FebaCome = \'0000-00-00\') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:42:30 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:42:41 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (`consulta`, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, \'s/n\', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE \'#{concecion_baja_persona_cuil}\' OR p.DetaPers LIKE \'%#{concecion_baja_persona_cuil}%\') AND (c.FebaCome IS NULL OR c.FebaCome = \'0000-00-00\') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:43:22 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:43:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall ' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES (SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;, 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:44:50 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:44:54 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:46:00 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:46:04 --> Severity: Notice --> Undefined index:  C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 45
ERROR - 2019-11-14 14:46:04 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:48:34 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:48:40 --> Severity: Notice --> Undefined offset: 1 C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 45
ERROR - 2019-11-14 14:48:40 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:49:04 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:49:07 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN' at line 1 - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ('SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;', 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:50:19 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:51:09 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: INSERT INTO `consulta` (consulta, `titulo`, `alias`, `columns_table`, `placeholder`) VALUES ("SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", 'Busqueda de datos Comercio a concecionar baja', 'baja_concecion', 'Cuil,Codigo comercio,Titular,Calle', 'Cuit o Nombre')
ERROR - 2019-11-14 14:54:55 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:55:00 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: UPDATE `consulta` SET consulta = "SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall  INNER JOIN infogov.persona p ON  p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", `titulo` = 'Busqueda de datos Comercio a concecionar baja', `alias` = 'baja_concecion', `colums_table` = 'Cuil,Codigo comercio,Titular,Calle', `placeholder` = 'Cuit o Nombre'
WHERE `id` = '7'
ERROR - 2019-11-14 14:55:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:55:54 --> Query error: Table 'expedientes.consulta' doesn't exist - Invalid query: UPDATE `consulta` SET consulta = "SELECT p.CucuPers AS col1, c.CodiCome AS col2, p.DetaPers AS col3, cll.DetaCall AS col4, p.CucuPers, c.CodiCome, p.DetaPers, cll.DetaCall AS DecpCome, IF(c.NucaCome = 0, 's/n', c.NucaCome) AS NupoCome, c.DelpCome FROM recaudacion.comercio c INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall INNER JOIN infogov.persona p ON p.CucuPers = c.CucuPers WHERE (p.CucuPers LIKE '#{concecion_baja_persona_cuil}' OR p.DetaPers LIKE '%#{concecion_baja_persona_cuil}%') AND (c.FebaCome IS NULL OR c.FebaCome = '0000-00-00') GROUP BY c.CodiCome;", `titulo` = 'Busqueda de datos Comercio a concecionar baja', `alias` = 'baja_concecion', `colums_table` = 'Cuil,Codigo comercio,Titular,Calle', `placeholder` = 'Cuit o Nombre'
WHERE `id` = '7'
ERROR - 2019-11-14 14:56:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:56:36 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:37 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:56:37 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:56:42 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:56:50 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:56:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:57:56 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:58:00 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:58:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:58:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:00 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:05 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:05 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:24 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:24 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:59:36 --> 404 Page Not Found: /index
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 61
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 62
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 63
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 64
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 65
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 60
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 14:59:41 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 14:59:41 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 15:02:20 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'campo' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 69
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'alias' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 70
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'consulta_id' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 71
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Illegal string offset 'where' C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 72
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> array_push() expects parameter 1 to be array, null given C:\wamp\www\vu\application\modules\expedientes\models\Consulta_model.php 73
ERROR - 2019-11-14 15:02:24 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 15:02:24 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\core\Exceptions.php:271) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 15:02:57 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:03:38 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:04:18 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:04:22 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 15:05:40 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:05:44 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-14 15:23:31 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:24:00 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:24:00 --> Query error: Table 'sigmu.datos_elements_form' doesn't exist - Invalid query: SELECT  e.id, e.element, fe.name,fe.label, fe.id as form_element_id ,fe.formulario_id, fe.element_id, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen,'' as alias_list FROM sigmu.formulario f
        INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id
        INNER JOIN sigmu.elements e ON e.id = fe.element_id
        LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = 1000
        WHERE f.id = 24 ORDER BY fe.id ASC;
        
ERROR - 2019-11-14 15:28:32 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:28:51 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:29:07 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:29:12 --> 404 Page Not Found: /index
ERROR - 2019-11-14 15:37:52 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 16:54:35 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 17:03:16 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 17:11:09 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 17:13:29 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 17:16:56 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-14 17:20:43 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
=======ERROR - 2019-11-14 09:13:17 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291212, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:13:16', '43', '2019/11/14 09:13:16', 'I')
>>>>>>> .r44
ERROR - 2019-11-14 09:26:33 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291213, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:26:33', '43', '2019/11/14 09:26:33', 'I')
ERROR - 2019-11-14 09:26:44 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291214, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:26:44', '43', '2019/11/14 09:26:44', 'I')
ERROR - 2019-11-14 09:31:43 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291215, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:31:43', '43', '2019/11/14 09:31:43', 'I')
ERROR - 2019-11-14 11:46:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:46:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:01 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:02 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:19 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:19 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:22 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:22 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:37 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:37 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:39 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:40 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:48 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:48 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:35:07 --> Severity: Parsing Error --> syntax error, unexpected 'var_dump' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:25 --> Severity: Parsing Error --> syntax error, unexpected 'echo' (T_ECHO) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:49 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:59 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:38:27 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:38:54 --> Severity: Parsing Error --> syntax error, unexpected '$resp' (T_VARIABLE) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:40:37 --> Severity: Notice --> Undefined index: repuesta C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 746
=======
ERROR - 2019-11-14 09:13:17 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291212, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:13:16', '43', '2019/11/14 09:13:16', 'I')
ERROR - 2019-11-14 09:26:33 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291213, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:26:33', '43', '2019/11/14 09:26:33', 'I')
ERROR - 2019-11-14 09:26:44 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291214, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:26:44', '43', '2019/11/14 09:26:44', 'I')
ERROR - 2019-11-14 09:31:43 --> Query error: The user specified as a definer ('CIVITAS'@'%') does not exist - Invalid query: INSERT INTO `sigmu`.`pase` (`id_expediente`, `ano`, `numero`, `anexo`, `origen`, `destino`, `respuesta`, `fojas`, `usuario_emisor`, `fecha_usuario`, `audi_user`, `audi_fecha`, `audi_accion`) VALUES (291215, '2019', '12645', '0', '862', '400', 'pendiente', '1', 'vperez', '2019-11-14 09:31:43', '43', '2019/11/14 09:31:43', 'I')
ERROR - 2019-11-14 11:46:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:46:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:01 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:02 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:19 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:19 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:22 --> 404 Page Not Found: 
ERROR - 2019-11-14 11:47:22 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:37 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:37 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:39 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:40 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:47 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:48 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:05:48 --> 404 Page Not Found: 
ERROR - 2019-11-14 12:35:07 --> Severity: Parsing Error --> syntax error, unexpected 'var_dump' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:25 --> Severity: Parsing Error --> syntax error, unexpected 'echo' (T_ECHO) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:49 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:35:59 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:38:27 --> Severity: Parsing Error --> syntax error, unexpected 'print_r' (T_STRING) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:38:54 --> Severity: Parsing Error --> syntax error, unexpected '$resp' (T_VARIABLE) C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 745
ERROR - 2019-11-14 12:40:37 --> Severity: Notice --> Undefined index: repuesta C:\wamp\www\vu\application\modules\expedientes\controllers\Pases.php 746
ERROR - 2019-11-14 13:04:14 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\application\helpers\permisos_helper.php:229) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 13:04:14 --> Severity: Parsing Error --> syntax error, unexpected '/' C:\wamp\www\vu\application\helpers\permisos_helper.php 229
ERROR - 2019-11-14 13:17:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar_tickets_dat
ERROR - 2019-11-14 13:17:18 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-14 13:19:58 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/listar_tickets_dat
ERROR - 2019-11-14 13:19:58 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/plugins
ERROR - 2019-11-14 13:20:07 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-14 13:20:07 --> Query error: Not unique table/alias: 'ticket' - Invalid query: SELECT ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor, ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM (`sigmu`.`ticket`, `sigmu`.`ticket`)
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`, `sigmu`.`pase`.`ticket_id`
ERROR - 2019-11-14 13:20:07 --> Query error: Not unique table/alias: 'ticket' - Invalid query: SELECT ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor, ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM (`sigmu`.`ticket`, `sigmu`.`ticket`)
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`, `sigmu`.`pase`.`ticket_id`
ERROR - 2019-11-14 13:26:15 --> Query error: Not unique table/alias: 'ticket' - Invalid query: SELECT ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor, ticket.id, count(pase.id) as cantexpe, ticket.fecha, ticket.usuario, oficina_r.nombre as oficina_receptora, oficina_e.nombre as oficina_emisora, pase.usuario_receptor
FROM (`sigmu`.`ticket`, `sigmu`.`ticket`)
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
JOIN `sigmu`.`oficina` `oficina_r` ON `oficina_r`.`id` = `sigmu`.`ticket`.`oficina_receptora`
LEFT JOIN `sigmu`.`oficina` `oficina_e` ON `oficina_e`.`id` = `sigmu`.`ticket`.`oficina_emisora`
JOIN `sigmu`.`pase` ON `pase`.`ticket_id` = `ticket`.`id`
WHERE `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
AND `pase`.`origen` = '862'
AND `pase`.`respuesta` = 'aceptado'
AND `ticket`.`id` >0
GROUP BY `sigmu`.`pase`.`ticket_id`, `sigmu`.`pase`.`ticket_id`
ERROR - 2019-11-14 14:02:14 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-14 14:02:15 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-14 14:02:15 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
<<<<<<< .mine
>>>>>>> .r36
||||||| .r36
=======
>>>>>>> .theirs>>>>>>> .r44
