<?php

/**
* @Page principale du module
* @package rechercheAlly
* @Créateur du script Aeris
* @link http://www.ogsteam.fr
*
* @Modifier par Kazylax
* @Site internet www.kazylax.net
* @Contact kazylax-fr@hotmail.fr
*
 */

if (file_exists('mod/'.$root.'/version.txt')) {
	$file = file('mod/'.$root.'/version.txt');
	
	$db->sql_query('UPDATE '.TABLE_MOD.' SET version = "'.trim($file[1]).'" WHERE id = "'.$pub_mod_id.'"');
}

?>