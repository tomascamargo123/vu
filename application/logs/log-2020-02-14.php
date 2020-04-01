<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-02-14 08:36:31 --> Query error: Table 'expedientes.persona' doesn't exist - Invalid query: SELECT * FROM persona WHERE CucuPers LIKE '%2342509171%'
ERROR - 2020-02-14 08:39:24 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`sigmu`.`campos`, CONSTRAINT `FK_campos` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`id`)) - Invalid query: INSERT INTO `sigmu`.`campos` (`alias`, `campo`, `consulta_id`, `where`) VALUES ('','CucuPers',0,0), ('','CcokPers',0,0), ('','CuitReal',0,0), ('','DetaPers',0,0), ('','JuriPers',0,0), ('','CeluPers',0,0)
ERROR - 2020-02-14 09:13:55 --> Query error: Cannot add or update a child row: a foreign key constraint fails (`sigmu`.`campos`, CONSTRAINT `FK_campos` FOREIGN KEY (`consulta_id`) REFERENCES `consulta` (`id`)) - Invalid query: INSERT INTO `sigmu`.`campos` (`alias`, `campo`, `consulta_id`, `where`) VALUES ('p_cuit','CucuPers',0,'1'), ('p_verif','CcokPers',0,0), ('p_real','CuitReal',0,0), ('p_nombre','DetaPers',0,0), ('p_estado','JuriPers',0,0), ('p_celular','CeluPers',0,0)
ERROR - 2020-02-14 13:04:03 --> 404 Page Not Found: 
