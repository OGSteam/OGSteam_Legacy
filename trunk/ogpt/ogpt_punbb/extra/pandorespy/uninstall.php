<?php
/**
* uninstall.php
* @package <nom du mod>
* @author <votre pseudo>
* @version 1.0
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @description Fichier de désinstallation du mod
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
define("TABLE_PANDORE_SPY",	$table_prefix."pandorespy");


$query = "DELETE FROM ".TABLE_MOD." WHERE title='pandorespy'";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_PANDORE_SPY."";
$db->sql_query($query);


// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='pandorspy'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);


// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
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
		echo("<script> alert('La compatibilité du mod avec le mod Xtense2 a été désinstallée !') </script>");
	}
}



?>
<title>Désinstallation</title>
<script>alert("Merci d\'avoir utilisé pandorepy pour pun_ogpt\nA bientot\n")</script>