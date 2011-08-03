<?php
/**
 * install.php 
 * @package Guerres
 * @author Verité
 * @link http://www.ogsteam.fr
 * @version 0.2f
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

//L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

//Définitions
global $db, $table_prefix;
define("TABLE_GUERRES_LISTE", $table_prefix."guerres_listes");
define("TABLE_GUERRES_ATTAQUES", $table_prefix."guerres_attaques");
define("TABLE_GUERRES_RECYCLAGES", $table_prefix."guerres_recyclages");

$is_ok = false;
$mod_folder = "guerres";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		//Si la table guerres_liste existe, on la supprime
		$query="DROP TABLE IF EXISTS ".TABLE_GUERRES_LISTE."";
		$db->sql_query($query);

		//Si la table guerres_attaques existe, on la supprime
		$query="DROP TABLE IF EXISTS ".TABLE_GUERRES_ATTAQUES."";
		$db->sql_query($query);

		//Si la table guerres_recyclages existe, on la supprime
		$query="DROP TABLE IF EXISTS ".TABLE_GUERRES_RECYCLAGES."";
		$db->sql_query($query);

		//Ensuite, on crée la table guerres_liste
		$query = "CREATE TABLE ".TABLE_GUERRES_LISTE." ("
			. " guerre_id INT NOT NULL AUTO_INCREMENT, "
			. " guerre_ally_1 VARCHAR(255) NOT NULL, "
			. " guerre_ally_2 VARCHAR(255) NOT NULL, "
			. " guerre_date_debut INT NOT NULL, "
			. " primary key ( guerre_id )"
			. " )";
		$db->sql_query($query);

		//Puis la table guerres_attaques
		$query = "CREATE TABLE ".TABLE_GUERRES_ATTAQUES." ("
			. " attack_id INT NOT NULL AUTO_INCREMENT, "
			. " guerres_id INT NOT NULL, "
			. " attack_date INT NOT NULL, "
			. " attack_name_A VARCHAR(30) NOT NULL, "
			. " attack_name_D VARCHAR(30) NOT NULL, "
			. " attack_coord VARCHAR(8) NOT NULL, "
			. " attack_metal INT NOT NULL, "
			. " attack_cristal INT NOT NULL, "
			. " attack_deut INT NOT NULL, "
			. " attack_pertes_A INT NOT NULL, "
			. " attack_pertes_D INT NOT NULL, "
			. " primary key ( attack_id )"
			. " )";
		$db->sql_query($query);

		//Ensuite, on crée la table guerres_recyclages
		$query = "CREATE TABLE ".TABLE_GUERRES_RECYCLAGES." ("
			. " recy_id INT NOT NULL AUTO_INCREMENT, "
			. " guerre_id INT NOT NULL, "
			. " recy_date INT NOT NULL, "
			. " recy_coord VARCHAR(8) NOT NULL, "
			. " recy_metal INT NOT NULL, "
			. " recy_cristal INT NOT NULL, "
			. " primary key ( recy_id )"
			. " )";
		$db->sql_query($query);
	}
else
	{
  echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}  
?>
