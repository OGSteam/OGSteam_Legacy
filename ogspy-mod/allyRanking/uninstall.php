<?php

/**
 *	uninstall.php Fichier de desinstallation du module allyRanking
 *	@package	allyRanking
 *	@author		Jibus 
 * 	@version 	0.3
 *	created	: 18/08/2006   
 *	modified	: 06/09/2006
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db,$table_prefix;

/**
 * Fichier de fonctions du module allyRanking
 */
require_once("mod/allyRanking/ARinclude.php");

//On vérifie que la table xtense_callbacks existe (Xtense2)
if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
  {
  // Si oui, on récupère le n° d'id du mod
  $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='allyRanking' AND `active`='1' LIMIT 1";
  $result = $db->sql_query($query);
  $ally_id = $db->sql_fetch_row($result);
  $ally_id = $ally_id[0];
  // on fait du nettoyage
  $query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$ally_id;
  $db->sql_query($query);
  }

$query = "DROP TABLE IF EXISTS ".TABLE_RANK_MEMBERS;
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE title='".MODULE_NAME."'";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_CONFIG." WHERE config_name='tagRanking'";
$db->sql_query($query);


?>
