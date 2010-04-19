<?php
/***************************************************************************
*	filename	: uninstall.php
*	desc.		: Désinstaller 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 15/12/2006
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

if (!defined('IN_SPYOGAME')) { die("Passe ton chemin manant !"); }

function DeleteTable()
{
	//Définitions
	global $db;
	global $table_prefix;
	define("TABLE_DEFENCE", $table_prefix."defence");
	define("TABLE_DEFENCE_OPTION", $table_prefix."defence_option");
	define("TABLE_DEFENCE_COEF", $table_prefix."defence_coef");
	define("TABLE_DEFENCE_ATTACK", $table_prefix."defence_attack");

	//Suppression des tables
	$query = "DROP TABLE IF EXISTS ".TABLE_DEFENCE.";";
	$db->sql_query($query);
	$query = "DROP TABLE IF EXISTS ".TABLE_DEFENCE_OPTION.";";
	$db->sql_query($query);
	$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE_COEF;
	$db->sql_query($query);
	$query="DROP TABLE IF EXISTS ".TABLE_DEFENCE_ATTACK;
	$db->sql_query($query);

	//Récupération de la version du module
	$query = "SELECT version FROM ".TABLE_MOD." WHERE action='defence' LIMIT 1";
	$result = $db->sql_query($query);
	if ($db->sql_numrows($result) != 0) {
		$info_mod = $db->sql_fetch_assoc($result); }

	if ($info_mod["version"] == "0.1b") {
		//Nettoyage des champs créés par la version 0.1b
		$sql = "SELECT * FROM ".TABLE_USER;
		$result = $db->sql_query($sql);
		$row = $db->sql_fetch_assoc($result);
		if (isset($row['def_zero_active']))
		{
			$query="ALTER TABLE ".TABLE_USER." DROP def_zero_active";
			$db->sql_query($query);
		}
		if (isset($row['def_select']))
		{
			$query="ALTER TABLE ".TABLE_USER." DROP def_select";
			$db->sql_query($query);
		}
	}
}

//Exécution de la déinstallation
DeleteTable();
?>
