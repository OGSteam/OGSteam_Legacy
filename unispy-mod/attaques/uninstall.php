<?php
/**
* uninstall.php 
 * @package Attaques
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version : 0.8e
 */

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

function DeleteTable()
{
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
}

//Exécution de la déinstallation
DeleteTable();
?>
