<?php
/**
 * uninstall.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2e
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

function DeleteTable()
{
	//Définitions
	global $db;
	global $table_prefix;
	define("TABLE_GUERRES_LISTE", $table_prefix."guerres_listes");
	define("TABLE_GUERRES_ATTAQUES", $table_prefix."guerres_attaques");
	define("TABLE_GUERRES_RECYCLAGES", $table_prefix."guerres_recyclages");
	
	//Suppression de la table guerre_liste
	$query = "DROP TABLE IF EXISTS ".TABLE_GUERRES_LISTE.";";
	$db->sql_query($query);
	
	//Suppression de la table guerre_attaques
	$query = "DROP TABLE IF EXISTS ".TABLE_GUERRES_ATTAQUES.";";
	$db->sql_query($query);
	
	//Suppression de la table guerre_recyclages
	$query = "DROP TABLE IF EXISTS ".TABLE_GUERRES_RECYCLAGES.";";
	$db->sql_query($query);
}

//Exécution de la déinstallation
DeleteTable();
?>
