<?php
/**
* uninstall.php 
 * @package Attaques
 * @author Verité modifié par ericc
 * @link http://www.ogsteam.fr
 * @version : 0.8a
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
	global $db;
	global $table_prefix;
	define("TABLE_ATTAQUES_ATTAQUES", $table_prefix."attaques_attaques");
	define("TABLE_ATTAQUES_RECYCLAGES", $table_prefix."attaques_recyclages");
	define("TABLE_ATTAQUES_ARCHIVES", $table_prefix."attaques_archives");
	
	//Suppression de la table attaques_attaques
	$query = "DROP TABLE IF EXISTS ".TABLE_ATTAQUES_ATTAQUES.";";
	$db->sql_query($query);
	
	//Suppression de la table attaques_recyclages
	$query = "DROP TABLE IF EXISTS ".TABLE_ATTAQUES_RECYCLAGES.";";
	$db->sql_query($query);
	
	//Suppression de la table attaques_archives
	$query="DROP TABLE IF EXISTS ".TABLE_ATTAQUES_ARCHIVES."";
	$db->sql_query($query);
	
	//Suppression des paramètres de configuration et bbcodes
	$query="DELETE FROM ".TABLE_MOD_CFG." WHERE `mod`='Attaques'";
	$db->sql_query($query);

	$mod_uninstall_name = "attaques";
	$mod_uninstall_table = $table_prefix."attaques_archives".', '.$table_prefix."attaques_recyclages".', '$table_prefix."attaques_attaques";
	uninstall_mod($mod_uninstall_name,$mod_uninstall_table);
?>
