<?php
/*
 * missiles upbase.php
 */

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Définitions
global $db;
global $table_prefix;


//On récupère la version actuel du mod	
$query = "SELECT version FROM ".TABLE_MOD." WHERE `id` = '".$pub_mod_id."' AND `active` = '1' LIMIT 1";

$result = $db->sql_query($query);

list($version) = $db->sql_fetch_row($result);

switch ($version)
{
	case "0.1" :
		// on change le fichier de référence
		$query  = "UPDATE ".TABLE_MOD." SET menu='Portée MIP', link='index.php' WHERE `id` = '".$pub_mod_id."'";
		$db->sql_query($query);
	
	case "0.2" :
		// correction mineur dans le code.
		
	case "0.2a" :
		// on normalise le champ action
		$query  = "UPDATE ".TABLE_MOD." SET action='missiles' WHERE `id` = '".$pub_mod_id."'";
		$db->sql_query($query);
		
	case "0.2b" :
	case "0.2c" :

}

// MAJ du numéro de version automatique
if (file_exists('mod/'.$root.'/version.txt')) 
{
	$file = file('mod/'.$root.'/version.txt');
	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}

?>