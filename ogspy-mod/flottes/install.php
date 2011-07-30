<?php
/*************************************************************************** 
*   filename    : install.php
*   desc.       : 1.07
*   Author      :
*   created     :
*   modified    : AirBAT, Zanfib
*   last modif. : added Xtense2 interaction
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db, $table_prefix;

$is_ok = false;
$mod_folder = "flottes";
$is_ok = install_mod($mod_folder);
if ($is_ok == true)
	{
		define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
		define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");
		define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
		define("TABLE_GROUP", $table_prefix."group");
		define("FLOTTES_FOLDER","mod/flottes");

		// Verification version


		$query = "CREATE TABLE ".TABLE_MOD_FLOTTES." (".
			" user_id int(11) NOT NULL default '0',".
			" activate enum('0','1') NOT NULL default '1',".
			" users_permits text NOT NULL,".
			" planet_id int(11) NOT NULL default '0',".
			"planet_name varchar(20) not null default '',".
			"coordinates varchar(8) not null default '', ".
			"date int(11) NOT NULL default '0',".
			" PT int(11) NOT NULL default '0',".
			" GT int(11) NOT NULL default '0',".
			" CLE int(11) NOT NULL default '0',".
			" CLO int(11) NOT NULL default '0',".
			" CR int(11) NOT NULL default '0',".
			" VB int(11) NOT NULL default '0',".
			" VC int(11) NOT NULL default '0',".
			" REC int(11) NOT NULL default '0',".
			" SE int(11) NOT NULL default '0',".
			" BMD int(11) NOT NULL default '0',".
			" DST int(11) NOT NULL default '0',".
			" EDLM int(11) NOT NULL default '0',".
			" TRA int(11) NOT NULL default '0',".
			" SAT int(11) NOT NULL default '0',".
			" primary key (user_id,planet_id))";
		$db->sql_query($query);

		$query = "CREATE TABLE ".TABLE_MOD_FLOTTES_ADM." (".
			" group_name varchar(20) not null default '',".
			" color_fleet varchar(8) not null default '',".
			" color_fleet_old varchar(8) not null default '',".
			" color_fleet_user varchar(8) not null default '',".
			" color_fleet_point varchar(8) not null default '',".
			"color_fleet_alli varchar(8) not null default '',".
			"color_bbc_1 varchar(8) not null default '',".
			"color_bbc_2 varchar(8) not null default '',".
			"color_bbc_3 varchar(8) not null default '',".
			"color_bbc_4 varchar(8) not null default '',".
			"color_bbc_5 varchar(8) not null default '',".
			"GAME varchar(8) not null default  'OGAME' '',".
			"nbpla TINYINT NOT NULL DEFAULT '9' '',".
			" primary key (group_name))";
		$db->sql_query($query);

		$request = "INSERT INTO ".TABLE_MOD_FLOTTES_ADM." (group_name,color_fleet,color_fleet_old,color_fleet_user, color_fleet_point, color_fleet_alli, ";
		$request .="color_bbc_1, color_bbc_2, color_bbc_3, color_bbc_4, color_bbc_5)   VALUES ('mod_flottes', 'lime', 'yellow', 'red', 'lime', 'teal', ";
		$request .="'yellow', 'red', 'green', 'cyan', 'orange')";
		$result = $db->sql_query($request);
		
		// Groupe toujours autorisé a voir:
		$request = "INSERT INTO ".TABLE_GROUP." (group_name)   VALUES ('mod_flottes')";
		$db->sql_query($request);
	
		// Insertion de la liaison entre Xtense v2 et Flottes
		// Quelle est l'ID du mod ?
		$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='flottes'";
		$resultid = $db->sql_query($query);
		list($mod_id, $version) = $db->sql_fetch_row($resultid);
	
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
		$result = $db->sql_query($query);
		if($db->sql_numrows($result) != 0)
			{
	
				//Maintenant on regarde si Flottes est dedans
				$result = $db->sql_query("Select * From ".TABLE_XTENSE_CALLBACKS." where mod_id = '$mod_id'");
				$nresult = $db->sql_numrows($result);

				// s'il n'y est pas : alors on l'ajoute!
				if($nresult == 0)
				$db->sql_query("INSERT INTO ".TABLE_XTENSE_CALLBACKS." (mod_id, function, type, active) VALUES ('$mod_id', 'flottes_import_fleet', 'fleet', 1)");
				echo("<script> alert('La compatibilité du mod Flottes avec le mod Xtense2 est installée !') </script>");	
			}
		else	    //On averti qu'Xtense 2 n'est pas installé :
			echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod Flottes ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>
