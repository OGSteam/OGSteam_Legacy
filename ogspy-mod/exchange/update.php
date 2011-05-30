<?php
  

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;

define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

//On récupère la version actuel du mod	
$mod_folder = "exchange";
$mod_name = "eXchange";
update_mod($mod_folder, $mod_name);

$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='eXchange'";
$result = $db->sql_query($query);
list($mod_id, $version) = $db->sql_fetch_row($result);
switch($version)
{
	case "0.0.0":
	break;
}

// On regarde si la table xtense_callbacks existe :
$query = 'show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ';
$result = $db->sql_query($query);
if($db->sql_numrows($result) != 0)
{
	//Bonne nouvelle le mod xtense 2 est installé !
	
	//Maintenant on regarde si eXchange est dedans :
	$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
	$result = $db->sql_query($query);
	if($db->sql_numrows($result) == 0)
	{
		// Il est pas dedans alors on l'ajoute :
		$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
				('.$mod_id.', "eXchange_xtense2_msg", "msg", 1)';
		$db->sql_query($query);		
		$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
		('.$mod_id.', "eXchange_xtense2_ally_msg", "ally_msg", 1)';
		$db->sql_query($query);		
		echo("<script> alert('La compatibilité du mod eXchange avec le mod Xtense2 est installée !') </script>");		
	}
}
else
{
	echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod eXchange ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
}


?>
