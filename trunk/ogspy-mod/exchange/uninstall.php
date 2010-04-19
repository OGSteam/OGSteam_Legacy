<?php

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
define("TABLE_EXCHANGE_USER",	$table_prefix."eXchange_User");
define("TABLE_EXCHANGE_ALLY",	$table_prefix."eXchange_Ally");
define("TABLE_EXCHANGE_OPTS",	$table_prefix."eXchange_Opts");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

// On récupère l'id du mod pour xtense...
$query = "SELECT id FROM ".TABLE_MOD." WHERE action='eXchange'";
$result = $db->sql_query($query);
list($mod_id) = $db->sql_fetch_row($result);

//Si les tables existent, on les supprime

$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_USER."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_ALLY."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_EXCHANGE_OPTS."";
$db->sql_query($query);

$query = "DELETE FROM ".TABLE_MOD." WHERE root='eXchange'";
$db->sql_query($query);

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
		echo("<script> alert('La compatibilité du mod eXchange avec le mod Xtense2 a été désinstallée !') </script>");
	}
}

?>
