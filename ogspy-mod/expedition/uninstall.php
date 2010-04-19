<?php

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_EXPEDITION", $table_prefix."eXpedition");
define("TABLE_EXPEDITION_TYPE_0", $table_prefix."eXpedition_Type_0");
define("TABLE_EXPEDITION_TYPE_1", $table_prefix."eXpedition_Type_1");
define("TABLE_EXPEDITION_TYPE_2", $table_prefix."eXpedition_Type_2");
define("TABLE_EXPEDITION_TYPE_3", $table_prefix."eXpedition_Type_3");
define("TABLE_EXPEDITION_OPTS", $table_prefix."eXpedition_Opts");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='eXpedition'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

//Si les tables existent, on les supprime
$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_0."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_1."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_2."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_TYPE_3."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXPEDITION_OPTS."";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='eXpedition'";
$db->sql_query($query);

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{
	//Le mod xtense 2 est installé !
	
	//Maintenant on regarde si eXpedition est dedans normalement oui mais on est jamais trop prudent...
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) != 0)
	{
		// Il est  dedans alors on l'enlève :
		$query = 'DELETE FROM '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
		$db->sql_query($query);
		echo("<script> alert('La compatibilité du mod eXpedition avec le mod Xtense2 a été désinstallée !') </script>");
	}
}

?>
