<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
include('./parameters/id.php');

define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

global $db, $table_prefix;
// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='gameOgame'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);
var_dump($mod_id);
$mod_uninstall_name = "gameOgame";
$mod_uninstall_table = $table_prefix."game".','.$table_prefix."game_users".','.$table_prefix."game_recyclage";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
	{
		//Le mod xtense 2 est installé !
		//Maintenant on regarde si gameOgame est dedans normalement oui mais on est jamais trop prudent...
		$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
		$result = $db->sql_query($query);
		if($db->sql_numrows($result) != 0)
			{
				// Il est  dedans alors on l'enlève :
				$query = 'DELETE FROM '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
				$db->sql_query($query);
				echo("<script> alert('La compatibilité du mod gameOgame avec le mod Xtense2 a été désinstallée !') </script>");
			}
	}

$queries = array();
$queries[] = 'DELETE FROM '.TABLE_CONFIG.' WHERE `config_name`=\'gameOgame\'';
$queries[] = 'DELETE FROM '.TABLE_MOD_CFG.' WHERE `mod`=\'gameOgame\'';

foreach ($queries as $query) 
	{
		$db->sql_query($query);
	}
?>
