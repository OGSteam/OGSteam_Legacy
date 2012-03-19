<?php
/**
* install.php 
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
*/

//Ce fichier installe la version 1 du module de aide au commerce

if (!defined('IN_SPYOGAME')) { die("Hacking attempt"); }

//Définitions
global $db;
global $table_prefix;

define("TABLE_COMMERCE", $table_prefix."convertisseur_commerce");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");

if (file_exists('mod/convertisseur/version.txt')) {
	$version_txt = file('mod/convertisseur/version.txt');
}

//Si la table commerce existe déjà on la supprime
$query="DROP TABLE IF EXISTS ".TABLE_COMMERCE."";
$db->sql_query($query);

//$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'Commerce', 'Convertisseur <br> de ressources', 'convertisseur', 'convertisseur', 'index.php', '".trim($version_txt[1])."', '1')";
//$db->sql_query($query);

$is_ok = false;
$mod_folder = "convertisseur";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true){
		//Ensuite, on crée la table commerce
		$query = "CREATE TABLE ".TABLE_COMMERCE." ("
			. " commerce_id INT NOT NULL AUTO_INCREMENT, "
			. " commerce_user_id INT NOT NULL, "
			. " commerce_planet VARCHAR(50) NOT NULL, "
			. " commerce_planet_coords VARCHAR(50) NOT NULL, "
			. " commerce_planet_dest VARCHAR(50) NOT NULL, "
			. " commerce_planet_dest_coords VARCHAR(50) NOT NULL, "				
			. " commerce_trader VARCHAR(50) NOT NULL, "
			. " commerce_trader_planet VARCHAR(50) NOT NULL, "
			. " commerce_trader_planet_coords VARCHAR(50) NOT NULL, "
			. " commerce_type VARCHAR(1) NOT NULL, "
			. " commerce_date INT NOT NULL, "
			. " commerce_metal INT NOT NULL default 0, "
			. " commerce_cristal INT NOT NULL default 0, "
			. " commerce_deut INT NOT NULL default 0, "
			. " primary key ( commerce_id )"
			. " )";
		$db->sql_query($query);
		
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
		$result = $db->sql_query($query);
		// On récupère le n° d'id du mod
		$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='convertisseur' AND `active`='1' LIMIT 1";
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
					$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES ('.$mod_id.', "livraison", "trade", 1)';
					$db->sql_query($query);		
					$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES ('.$mod_id.', "livraison_me", "trade_me", 1)';
					$db->sql_query($query);
					echo("<script> alert('La compatibilité du mod Commerce avec le mod Xtense2 est installée !') </script>");
				}
			}	
		else
			{
			//On averti qu'Xtense 2 n'est pas installé :
			echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod Commerce ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
			}	
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>
