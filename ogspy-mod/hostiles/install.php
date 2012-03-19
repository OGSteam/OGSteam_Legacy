<?php
/**
* install.php 
* @package hostiles
* @author Jedinight
* @link http://www.ogsteam.fr
*/

//Ce fichier installe la version 1 du module hostiles


if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//Définitions
global $db;
global $table_prefix;

define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

define("TABLE_HOSTILES", $table_prefix."hostiles");
define("TABLE_HOSTILES_ATTACKS", $table_prefix."hostiles_attacks");
define("TABLE_HOSTILES_COMPOSITION", $table_prefix."hostiles_composition");

if (file_exists('mod/hostiles/version.txt')) {
	$version_txt = file('mod/hostiles/version.txt');
}

//Si les tables hostiles existe déjà on la supprime
$query="DROP TABLE IF EXISTS ".TABLE_HOSTILES."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_HOSTILES_ATTACKS."";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS ".TABLE_HOSTILES_COMPOSITION."";
$db->sql_query($query);

//$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'Commerce', 'Convertisseur <br> de ressources', 'convertisseur', 'convertisseur', 'index.php', '".trim($version_txt[1])."', '1')";
//$db->sql_query($query);

$is_ok = false;
$mod_folder = "hostiles";
$is_ok = install_mod ($mod_folder);

if ($is_ok == true){
		//Ensuite, on crée la table commerce
		$query = "CREATE TABLE ".TABLE_HOSTILES." ("
			. " id_attack VARCHAR(50) NOT NULL, "
			. " user_id INT NOT NULL, "			
			. " player_id INT NOT NULL, "
			. " ally_id INT NOT NULL, "
			. " arrival_time VARCHAR(8) NOT NULL, "
			. " primary key ( id_attack )"
			. " )";
		$db->sql_query($query);
		
		$query = "CREATE TABLE ".TABLE_HOSTILES_ATTACKS." ("
		. " id_attack VARCHAR(50) NOT NULL, "
		. " id_vague INT NOT NULL default 0, "
		. " attacker VARCHAR(50) NOT NULL, "
		. " origin_planet VARCHAR(50) NOT NULL, "
		. " origin_coords VARCHAR(8) NOT NULL, "
		. " cible_planet VARCHAR(50) NOT NULL, "
		. " cible_coords VARCHAR(8) NOT NULL, "
		. " primary key ( id_attack,id_vague )"
		. " )";
		$db->sql_query($query);
		
		$query = "CREATE TABLE ".TABLE_HOSTILES_COMPOSITION." ("
		. " id_attack VARCHAR(50) NOT NULL, "
		. " id_vague INT NOT NULL default 0, "
		. " type_ship VARCHAR(50) NOT NULL, "
		. " nb_ship VARCHAR(50) NOT NULL, "
		. " primary key ( id_attack,id_vague,type_ship )"
		. " )";
		$db->sql_query($query);
		
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
		$result = $db->sql_query($query);
		
		// On récupère le n° d'id du mod
		$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='hostiles' AND `active`='1' LIMIT 1";
		$result = $db->sql_query($query);
		$mod_id = $db->sql_fetch_row($result);
		$mod_id = $mod_id[0];

		if($db->sql_numrows($result) != 0){
				//Bonne nouvelle le mod xtense 2 est installé !
				//Maintenant on regarde si convertisseur est dedans normalement il devrait pas mais on est jamais trop prudent...
				$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
				$result = $db->sql_query($query);
				$nresult = $db->sql_numrows($result);
				if($nresult == 0) {
					// Il est pas dedans alors on l'ajoute :
					$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES ('.$mod_id.', "hostiles", "hostiles", 1)';
					$db->sql_query($query);
					echo("<script> alert('La compatibilité du mod Hostile avec le mod Xtense2 est installée !') </script>");
				}
		} else {
			//On averti qu'Xtense 2 n'est pas installé :
			echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod Hostile ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
		}	
	} else {
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>
