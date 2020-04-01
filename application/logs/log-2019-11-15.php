<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<<<<<<< .mine
ERROR - 2019-11-15 08:44:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Consultas/crear
ERROR - 2019-11-15 08:44:03 --> 404 Page Not Found: ../modules/expedientes/controllers/Consultas/crear
ERROR - 2019-11-15 09:36:46 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:30:30 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:30:36 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:31:25 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:32:02 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:33:18 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:33:55 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:35:04 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:35:32 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:35:49 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:36:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:36:46 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:38:04 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:38:07 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:38:21 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:38:25 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:38:49 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:38:52 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:39:35 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:39:39 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:40:09 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:40:26 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:40:58 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 10:41:49 --> 404 Page Not Found: /index
ERROR - 2019-11-15 10:42:52 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:13:26 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:13:39 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'Si","No") AS DeudCome  FROM recaudacion.comercio c  INNER JOIN infogov.calle cll' at line 1 - Invalid query: UPDATE `sigmu`.`consulta` SET consulta = "SELECT c.CodiInmu AS col1, c.CodiCome AS col2, p.DetaPers AS col3, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS col4,c.RazoCome AS col5, c.CodiCome, IF(c.CodiBarr = 0,CONCAT(cll.DetaCall,' N° ',c.NucaCome), CONCAT('B° ',b.DetaBarr,' M-',c.MansCome,' C-',c.CasaCome)) AS DireCome, c.DelpCome AS DistCome, p.TelePers AS TeleCome, c.ObseCome ObseCome,c.CucuPers,IF((SUM(cc.DebeCtct)- SUM(cc.CredCtct)) > 0,"Si","No") AS DeudCome  FROM recaudacion.comercio c  INNER JOIN infogov.calle cll ON cll.CodiCall = c.CodiCall INNER JOIN infogov.persona p ON p.CucuPers = c.CucuPers INNER JOIN recaudacion.relacion  r ON r.CucuPers = c.CucuPers AND r.CucuPers = p.CucuPers AND r.CuenCtct = c.CodiCome LEFT JOIN infogov.barrio b ON b.CodiBarr = c.CodiBarr LEFT JOIN recaudacion.ctacte cc ON cc.CodiOfic = r.CodiOfic AND cc.CuenCtct = r.CuenCtct WHERE (p.CucuPers like '#{comercio_cuit}%' OR DetaPers like '%#{comercio_cuit}%' OR c.CodiCome = '#{comercio_cuit}') AND c.FebaCome IS NULL;", `titulo` = 'Busqueda de comercio relacionado (comerciante)', `alias` = 'comerciante', `colums_table` = 'padrón municipal,codigo comercio,propietario,direccion,nombre negocio', `placeholder` = 'Cuit, Apellido y nombre o Numero de cuenta'
WHERE `id` = '2'
ERROR - 2019-11-15 11:15:38 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 11:16:16 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:50:26 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:51:01 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 11:56:31 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:58:10 --> 404 Page Not Found: /index
ERROR - 2019-11-15 11:58:32 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 12:00:47 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:01:01 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 12:01:44 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:02:07 --> Could not find the language line "insert_batch() called with no data"
ERROR - 2019-11-15 12:03:41 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:08:06 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:31:17 --> 404 Page Not Found: /index
||||||| .r36
ERROR - 2019-11-15 10:26:53 --> Severity: Compile Error --> Cannot use isset() on the result of an expression (you can use "null !== expression" instead) C:\wamp\www\vu\application\modules\expedientes\views\plantillas\plantillas_abm.php 73
ERROR - 2019-11-15 10:33:35 --> Severity: Notice --> Undefined property: stdClass::$digital C:\wamp\www\vu\application\modules\expedientes\views\plantillas\plantillas_abm.php 73
ERROR - 2019-11-15 10:37:21 --> Severity: Parsing Error --> syntax error, unexpected ')' C:\wamp\www\vu\application\modules\expedientes\controllers\Plantillas.php 121
=======
ERROR - 2019-11-15 07:33:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:34:22 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:34:43 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:35:08 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:35:29 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:35:51 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:36:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:36:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:37:09 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:37:35 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:38:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:38:25 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:38:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:39:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:41:54 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:42:28 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:42:54 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:43:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:43:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:44:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:44:31 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:44:50 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:45:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:45:34 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:45:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:47:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:50:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:51:09 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 07:51:36 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:04:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:04:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:04:27 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:04:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:05:27 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:05:45 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:07:18 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:07:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:08:00 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:08:28 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:08:54 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:09:09 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:09:38 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:09:56 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:10:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:10:33 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:10:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:10:59 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:11:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:11:43 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:12:08 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:12:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:17:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:18:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:18:06 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:18:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:27:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:27:51 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:27:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:28:33 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:28:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:29:05 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:29:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:29:27 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:43:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:44:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:45:34 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:46:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:47:18 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:48:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:49:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:49:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:50:27 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:51:22 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:52:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:54:37 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:54:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:54:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:55:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:55:45 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:56:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:56:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:56:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 08:56:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:57:04 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 08:57:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:07:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:07:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:07:49 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:08:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:09:25 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:10:34 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:10:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:11:54 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:12:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:12:31 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:14:55 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:29 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:29 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:15:29 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:16:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:22:05 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:22:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:22:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:22:28 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:22:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:22:38 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:22:50 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:28:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:28:33 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:28:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:29:27 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:30:06 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:30:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:31:38 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:32:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:33:59 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:34:12 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-15 09:34:57 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:35:33 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:36:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:23 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:37:59 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:38:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:39:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:39:49 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:40:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:41:03 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:41:50 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:41:56 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:42:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:43:07 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:07 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:08 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:12 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:12 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:12 --> 404 Page Not Found: /index
ERROR - 2019-11-15 09:43:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:45:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:45:37 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:45:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:47:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:47:38 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:48:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:48:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:49:04 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:49:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:49:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:49:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:50:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:51:05 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:51:19 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-15 09:51:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:51:54 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\database\drivers\mysqli\mysqli_driver.php 305
ERROR - 2019-11-15 09:51:54 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-15 09:51:54 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-15 09:51:54 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-15 09:51:54 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-15 09:51:54 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php:178) C:\wamp\www\vu\system\core\Common.php 578
ERROR - 2019-11-15 09:51:54 --> Severity: Error --> Maximum execution time of 120 seconds exceeded C:\wamp\www\vu\system\libraries\Session\drivers\Session_files_driver.php 178
ERROR - 2019-11-15 09:52:23 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:52:43 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:53:01 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:56:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:56:14 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 09:56:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:56:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:57:08 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:57:31 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:57:53 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:58:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:58:35 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:58:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 09:59:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:07:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:08:25 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:09:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:10:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:10:25 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:10:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:10:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:11:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:11:44 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:12:01 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:12:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:12:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:13:19 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:13:29 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:13:38 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:13:53 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:14:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:14:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:16:28 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:17:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:17:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:17:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:17:49 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:18:01 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:18:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:18:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:18:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:18:53 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:19:17 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:19:35 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:19:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:19:56 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:20:35 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:48:58 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-15 10:57:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:57:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 10:57:50 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:58:54 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 10:59:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:00:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Expedientes/favicon.ico
ERROR - 2019-11-15 11:00:29 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:00:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:00:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:01:24 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:01:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:01:45 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:02:32 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:03:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:04:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:05:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:05:26 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:05:34 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:05:36 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:06:18 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:07:02 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:08:10 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:24:51 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:25:01 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:32:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:32:26 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:32:29 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:32:46 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:43:48 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:44:20 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:44:22 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:44:41 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:45:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:46:01 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:46:45 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:47:36 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:48:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:48:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:49:34 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:49:42 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:49:58 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:50:05 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:50:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 11:50:13 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:50:21 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:54:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:54:26 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 11:58:05 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:07:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:07:12 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:07:31 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:07:50 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:10:20 --> Severity: Notice --> Undefined property: stdClass::$idgital C:\wamp\www\vu\application\modules\expedientes\controllers\Expedientes.php 1357
ERROR - 2019-11-15 12:18:36 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:18:44 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:18:47 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:19:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:26:07 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:26:15 --> 404 Page Not Found: ../modules/expedientes/controllers/Escritorio/favicon.ico
ERROR - 2019-11-15 12:26:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:26:30 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:26:39 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:26:55 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:33:11 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:33:59 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:34:49 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:35:32 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:36:16 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:36:53 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:37:40 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:37:45 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:37:52 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:38:09 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:38:32 --> 404 Page Not Found: ../modules/expedientes/controllers/Pases/favicon.ico
ERROR - 2019-11-15 12:51:15 --> Query error: Table 'sigmu.datos_elements_form' doesn't exist - Invalid query: SELECT  e.element, fe.name,fe.label, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen FROM sigmu.formulario f  INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id INNER JOIN sigmu.elements e ON e.id = fe.element_id LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = 1000 WHERE f.id = 10 ORDER BY fe.id ASC;
ERROR - 2019-11-15 12:52:13 --> Query error: Table 'sigmu.datos_elements_form' doesn't exist - Invalid query: SELECT  e.id, e.element, fe.name,fe.label, fe.id as form_element_id ,fe.formulario_id, fe.element_id, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen,'' as alias_list FROM sigmu.formulario f
        INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id
        INNER JOIN sigmu.elements e ON e.id = fe.element_id
        LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = 1000
        WHERE f.id = 10 ORDER BY fe.id ASC;
        
ERROR - 2019-11-15 12:52:18 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:52:18 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:52:29 --> Query error: Table 'sigmu.datos_elements_form' doesn't exist - Invalid query: SELECT  e.id, e.element, fe.name,fe.label, fe.id as form_element_id ,fe.formulario_id, fe.element_id, e.class, e.type, e.options, e.value, fe.isrequired, fe.disable, def.plantilla_origen, def.alias_origen,'' as alias_list FROM sigmu.formulario f
        INNER JOIN sigmu.formulario_elements fe ON fe.formulario_id = f.id
        INNER JOIN sigmu.elements e ON e.id = fe.element_id
        LEFT JOIN sigmu.datos_elements_form def ON def.form_element_id = fe.id AND def.formulario_id = fe.formulario_id AND def.element_id = fe.element_id AND def.tramite_id = 1000
        WHERE f.id = 10 ORDER BY fe.id ASC;
        
ERROR - 2019-11-15 12:52:30 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:56:28 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:57:10 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:57:15 --> 404 Page Not Found: /index
ERROR - 2019-11-15 12:58:20 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:01:24 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:01:34 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:01:45 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:08:47 --> 404 Page Not Found: /index
ERROR - 2019-11-15 13:08:50 --> Severity: Warning --> Missing argument 3 for Circuitos::cargar_formularios() C:\wamp\www\vu\application\modules\expedientes\controllers\Circuitos.php 476
ERROR - 2019-11-15 13:08:50 --> Severity: Notice --> Undefined variable: id_tram C:\wamp\www\vu\application\modules\expedientes\controllers\Circuitos.php 479
ERROR - 2019-11-15 13:08:51 --> 404 Page Not Found: /index
>>>>>>> .r41
