<?php
/**
 *	update.php Fichier de mise à jour du module allyRanking
 *	@package	allyRanking
 *	@author		Jibus 
 *	@version	0.4
 */

	if (!defined('IN_SPYOGAME')) {
	    die("Hacking attempt");
	}

	global $db;

	/**
	 * Fichier de fonctions du module allyRanking
	 */
	require_once("mod/allyRanking/ARinclude.php");
	
	// Enlever l'interclassement présent sur les versions précédentes si besoin.
	$sql = 'ALTER TABLE '.TABLE_RANK_MEMBERS.' CHANGE `player` `player` VARCHAR(30) NOT NULL, CHANGE `ally` `ally` VARCHAR(30) NULL DEFAULT NULL'; 
	$db->sql_query($sql,DEBUG,true);
	
	// Mettre à jour la version
	$query  = "UPDATE ".TABLE_MOD." SET menu='".MENU_ICON."&nbsp;".MODULE_NAME."', version='".MODULE_VERSION."' where title='allyRanking'";
	$db->sql_query($query,DEBUG,true);
	
 //On vérifie que la table xtense_callbacks existe (Xtense2)
if( mysql_num_rows( mysql_query("SHOW TABLES LIKE '".$table_prefix."xtense_callbacks"."'")))
  {
  // Si oui, on récupère le n° d'id du mod
  $query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='allyRanking' AND `active`='1' LIMIT 1";
  $result = $db->sql_query($query);
  $ally_id = $db->sql_fetch_row($result);
  $ally_id = $ally_id[0];
  // on fait du nettoyage au cas ou
  $query = "DELETE FROM `".$table_prefix."xtense_callbacks"."` WHERE `mod_id`=".$ally_id;
  $db->sql_query($query);
  // Insert les données pour récuperer les informations de la page Alliance
  $query = "INSERT INTO ".$table_prefix."xtense_callbacks"." ( `mod_id` , `function` , `type` )
				VALUES ( '".$ally_id."', 'ally_list', 'ally_list')";
  $db->sql_query($query);
  }

	?>