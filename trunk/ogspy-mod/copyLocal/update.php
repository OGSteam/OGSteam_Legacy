<?php
/***************************************************************************
*	filename	: update.php
*   package     : Copy_local
*	desc.		: script de mise à jour du module
*	Author		: ericc - http://www.ogsteam.fr/
*	created		: 03/04/2008
*	modified	: 05/04/2008
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Définitions
global $db;
global $table_prefix;

//On récupère la version actuel du mod	
$query = "SELECT version FROM ".TABLE_MOD." WHERE action='copylocal'";
$result = $db->sql_query($query);

list($version) = $db->sql_fetch_row($result);

if ($version == 0)
{
	$query = "SELECT version FROM ".TABLE_MOD." WHERE action='copylocal' LIMIT 1";
	$result = $db->sql_query($query);
	list($version) = $db->sql_fetch_row($result);
}
if ($version == "0.1")
{
	//Puis on change la version
	$query  = "UPDATE ".TABLE_MOD." SET version='0.2' WHERE action='copylocal' LIMIT 1";
	$db->sql_query($query);

	$version = "0.2";
}
if ($version == "0.2")
{
	//Puis on change la version
	$query  = "UPDATE ".TABLE_MOD." SET version='0.2a' WHERE action='copylocal' LIMIT 1";
	$db->sql_query($query);

	$version = "0.2a";
}
?>