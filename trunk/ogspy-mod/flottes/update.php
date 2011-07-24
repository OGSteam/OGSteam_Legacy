<?php
/***************************************************************************
*   filename    : update.php
*   desc.       : 1.08beta1
*   Author      : 
*   created     : 
*   modified    : AirBAT
*   last modif. : added upgrade from v1.07  
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db,$table_prefix;

//define("TABLE_MOD_FLOTTES_ADM", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."mod_flottes_admin");
define("TABLE_MOD_FLOTTES_ADM", $table_prefix."mod_flottes_admin");
define("TABLE_GROUP", $table_prefix."group");
define("TABLE_MOD_FLOTTES", $table_prefix."mod_flottes");
define("FLOTTES_FOLDER","mod/flottes");

    	
// Verification version
if (file_exists(FLOTTES_FOLDER.'/version.txt')) {
    list($mod_name,$version) = file(FLOTTES_FOLDER.'/version.txt'); 
   
	
}
else {
    die('Le fichier "version.txt" est introuvable !');
}

$query = "SELECT `id`, `version` FROM ".TABLE_MOD." WHERE `action`='flottes'";
$result = $db->sql_query($query);

		
if(list($mod_id, $version) = $db->sql_fetch_row($result)) {
	SWITCH($version) {

		CASE "0.2" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.3'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		// echo "0.20";
		// break;
		
		CASE "0.21" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.3'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.3";
		// echo "0.21";
		// break;
		
		CASE "0.3"  :
		$query = "UPDATE ".TABLE_MOD." SET version='0.6'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$query="ALTER TABLE ".TABLE_MOD_FLOTTES." ADD `TRA` INT NOT NULL DEFAULT '0'";
		$db->sql_query($query);
		$version="0.6";
		// echo "0.3";
		// break;
		
		CASE "0.4"  :
		$query = "UPDATE ".TABLE_MOD." SET version='0.6'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.6";
		// echo "0.4";
		// break;
		
		CASE "0.5"  :
		$query = "UPDATE ".TABLE_MOD." SET version='0.6'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.6";
		// echo "0.5";
		// break;
		
		CASE "0.6" :
		$query ="ALTER TABLE ".TABLE_MOD_FLOTTES." ADD `SAT` INT NOT NULL DEFAULT '0'";
		$db->sql_query($query);
		$query = "UPDATE ".TABLE_MOD." SET version='0.7'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.7";
		// echo "0.6";
		// break;
		
		CASE "0.7" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.7";
		// break;
		
		CASE "0.71" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.71";
		// break;
		
		CASE "0.72" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.72";
		// break;
		
		CASE "0.73" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.73";
		// break;
		
		CASE "0.74" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.74";
		// break;
		
		CASE "0.75" :
		$query = "UPDATE ".TABLE_MOD." SET version='0.76'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version="0.76";
		// echo "0.75";
		// break;
		
		CASE "0.76" :
		$query = "ALTER TABLE  ".TABLE_MOD_FLOTTES_ADM." ADD `GAME` VARCHAR( 8 ) NOT NULL DEFAULT 'OGAME' ";
		$db->sql_query($query);
		
		$query = "ALTER TABLE  ".TABLE_MOD_FLOTTES_ADM." ADD `nbpla` TINYINT NOT NULL DEFAULT '9' ";
		$db->sql_query($query);
		
		$query = "ALTER TABLE ".TABLE_MOD_FLOTTES." DROP PRIMARY KEY, ADD PRIMARY KEY( `user_id`,  `planet_id`,  `planet_name`,  `coordinates`)";
		$db->sql_query($query);
			
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "0.76";
		// break;
		
		CASE "1.00" :
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "1.00";
		// break;
		
		CASE "1.01" :
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "1.01";
		// break;
		
		CASE "1.02" :
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "1.02";
		// break;
		
		CASE "1.03" :
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "1.03";
		// break;

		CASE "1.04" :
		$query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
		$db->sql_query($query);
		$version=$vfinale;
		// echo "1.04";
		break;

        CASE "1.05" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.05";
        break;
        		
        CASE "1.06" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.06";
        break;
                
        CASE "1.07" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.07";
        break;
                
        CASE "1.08a" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.08a";
        break;
                
        CASE "1.08b" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.08b";
        break;
		
        CASE "1.10" :
        $query = "UPDATE ".TABLE_MOD." SET version='".$vfinale."'  WHERE action='mod_flottes' AND version='".$version."'";
        $db->sql_query($query);
        $version=$vfinale;
        // echo "1.10";
        break;
		
        default:
		$mod_folder = "flottes";
		$mod_name = "flottes";
		update_mod($mod_folder, $mod_name);

// / Nouvelle table pour la gestion des couleurs
		// $query = "CREATE TABLE ".TABLE_MOD_FLOTTES_ADM." (".
			// " group_name varchar(20) not null default '',".
			// " color_fleet varchar(8) not null default '',".
			// " color_fleet_old varchar(8) not null default '',".
			// " color_fleet_user varchar(8) not null default '',".
			// " color_fleet_point varchar(8) not null default '',".
			// "color_fleet_alli varchar(8) not null default '',".
			// "color_bbc_1 varchar(8) not null default '',".
			// "color_bbc_2 varchar(8) not null default '',".
			// "color_bbc_3 varchar(8) not null default '',".
			// "color_bbc_4 varchar(8) not null default '',".
			// "color_bbc_5 varchar(8) not null default '',".
			// " primary key (group_name))";
		// $db->sql_query($query);

		// $request = "INSERT INTO ".TABLE_MOD_FLOTTES_ADM." (group_name,color_fleet,color_fleet_old,color_fleet_user, color_fleet_point, color_fleet_alli, ";
		// $request .="color_bbc_1, color_bbc_2, color_bbc_3, color_bbc_4, color_bbc_5)   VALUES ('mod_flottes', 'lime', 'yellow', 'red', 'lime', 'teal', ";
		// $request .="'yellow', 'red', 'green', 'cyan', 'orange')";
		// $db->sql_query($request);
		
		// break;

	}

}
/*
		$request = "Select group_name from ".TABLE_GROUP." where group_name='mod_flottes'";
		$result=$db->sql_query($request);
		$group=mysql_num_rows($result);
		echo $group." - ".$version;
		
		if ($group==0) {
		
		$request = "INSERT INTO ".TABLE_GROUP." (group_id, group_name)   VALUES ('','mod_flottes')";
		$db->sql_query($request);}
*/		

// Enregistrement du Mod Flottes dans Xtense2
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

// On regarde si la table xtense_callbacks existe
$query = "SELECT id, version FROM ".TABLE_MOD." WHERE action='flottes'";
$resultid = $db->sql_query($query);
list($mod_id, $version) = $db->sql_fetch_row($resultid);
$result = $db->sql_query('show tables from '.$db->dbname.' like "'.TABLE_XTENSE_CALLBACKS.'" ');
if($db->sql_numrows($result) != 0){

	//On regarde si le mod Flottes est inscrit dans xtense2
	$result = $db->sql_query("Select * From ".TABLE_XTENSE_CALLBACKS." where mod_id = $mod_id");

	// s'il n'y est pas, on l'ajoute
	if($db->sql_numrows($result) == 0)
		$db->sql_query("INSERT INTO ".TABLE_XTENSE_CALLBACKS." (mod_id, function, type, active) VALUES ('$mod_id', 'flottes_import_fleet', 'fleet', 1)");
	echo("<script> alert('La compatibilité du mod Flottes avec le mod Xtense2 \n est installée !') </script>");		
}
else {
	echo("<script> alert('Le mod Xtense 2 n'est pas installé. La compatibilité du mod Flottes ne sera donc pas installé !\nPensez Ã  installer Xtense 2 c'est pratique ;)') </script>");
}
?>

