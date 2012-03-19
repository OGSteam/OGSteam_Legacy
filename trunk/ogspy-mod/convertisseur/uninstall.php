<?php
/**
* uninstall.php
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')){ die('Hacking attempt'); }

//Définitions
global $db;
global $table_prefix;

define("TABLE_COMMERCE", $table_prefix."convertisseur_commerce");

// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='convertisseur'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

$mod_uninstall_name = "convertisseur";
$mod_uninstall_table = TABLE_COMMERCE;
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);

// On regarde si la table xtense_callbacks existe :
$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{
	//Le mod xtense 2 est installé !
	
	//Maintenant on regarde si eXchange est dedans normalement oui mais on est jamais trop prudent...
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) != 0)
	{
		// Il est  dedans alors on l'enlève :
		$query = 'DELETE FROM '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
		$db->sql_query($query);
		echo("<script> alert('La compatibilité du mod Commerce avec le mod Xtense2 a été désinstallée !') </script>");
	}
}

?>
