<?php
/**
 * install.php 
 
Procédure d'installation du mod.

 * @package QuiMSonde
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 1.5
 * dernière modification : 27.04.08
 * Largement inspiré du formidable mod QuiMObserve de Santory
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Include
include("qms_common.php");
include(FOLDER_INCLUDE."/qms_main.php");
define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");


$is_ok = false;
$mod_folder = "quimsonde";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		// Est-ce qu'une table existe déjà ? 
		$query = $db->sql_query('SHOW TABLES LIKE "'.TABLE_QMS.'" ');
		if($db->sql_numrows($query) != 0)
			{	// Oui, alors on regarde si y'a bien la colonne distance, ajouté à la v1.0 
				$col_distance = false;
				$query = $db->sql_query('SHOW COLUMNS FROM '.TABLE_QMS);
				while ($test = mysql_fetch_assoc($query)) 
				if ($test['Field'] == 'distance') 
					$col_distance = true;
				if($col_distance == false)
					{
						// Si elle n'y est pas, on bloque le numéro de version pour faire une mise à jour ensuite
						$version = "1.0";
						echo $lang['qms_old_database_found'];
					}
			}
		else
			{	// Sinon...
				//Création de la table des espionnages
				$query = "CREATE TABLE `".TABLE_QMS."` (
					`id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
					`sender_id` INT( 11 ) DEFAULT '0' NOT NULL ,
					`position` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
					`position_name` VARCHAR( 64 ) NULL,
					`joueur` VARCHAR( 32 ) DEFAULT '?' NOT NULL ,
					`alliance`VARCHAR( 32 ) DEFAULT '?' NOT NULL ,
					`distance` INT( 11 ) NOT NULL ,
					`cible` VARCHAR( 9 ) DEFAULT '0:0:0' NOT NULL ,
					`cible_name` VARCHAR( 64 ) NULL,
					`datadate` INT( 11 ) DEFAULT '0' NOT NULL ,
					`pourcentage` INT( 1 ) DEFAULT '0' NOT NULL,
					INDEX ( `position`),
					INDEX (  `joueur` ),
					INDEX ( `alliance` ) ,
					UNIQUE ( `id`))";
				$db->sql_query($query);
			}
		// Création de la table des configurations
		$db->sql_query('DROP TABLE IF EXISTS `'.TABLE_QMS_config.'`');
		$query = "CREATE TABLE `".TABLE_QMS_config."` (
			`user_id` INT( 11 ) NOT NULL DEFAULT '0' ,
			`config` VARCHAR( 11 ) DEFAULT '' NOT NULL ,
			`valeur` VARCHAR( 255 ) DEFAULT '' NOT NULL ,
			INDEX ( `config` ))";
		$db->sql_query($query);

		// Génération des configuration par défault
		$insert_config = "INSERT INTO ".TABLE_QMS_config." ( `user_id`, `config`, `valeur`) VALUES ";
		$db->sql_query($insert_config."( '0', 'lignes', '15' )");
		$db->sql_query($insert_config."( '0', 'jours', '365' )");
		$db->sql_query($insert_config."( '0', 'add_home', 'no' )");
		$db->sql_query($insert_config."( '0', 'banniere', 'yes' )");
		$db->sql_query($insert_config."( '0', 'imgmenu', 'no' )");
		$db->sql_query($insert_config."( '0', 'nbrapport', '2' )");
		$db->sql_query($insert_config."( '0', 'periode', '20' )");
		$db->sql_query($insert_config."( '0', 'time_end', '".($a=time())."' )");
		$db->sql_query($insert_config."( '0', 'time_start', '".($a-3600*24*30)."' )");
		$db->sql_query($insert_config."( '1', 'search', 'Recherche d\'Alliance<|>?action=ally&ally={alliance}&classement=pp&Rechercher<|>Alliance<|>0' )");
		$db->sql_query($insert_config."( '2', 'search', 'Lite Seach 							(BBCode)<|>?action=litesearch&search={joueur}&target=player&galaxie=%&limit=0&mode=3&go=Rechercher<|>Joueur<|>0' )");
		$db->sql_query($insert_config."( '3', 'search', 'Recherche+<|>?action=recherche_plus&ally_active=1&allys={alliance}&Chercher<|>Alliance<|>0' )");
		$db->sql_query($insert_config."( '0', 'searchID', '1|2|3' )");


		// Insertion de la liaison entre Xtense v2 et QuiMSonde

		
		// On regarde si la table xtense_callbacks existe :
		$query = 'show tables like "'.TABLE_XTENSE_CALLBACKS.'" ';
		$result = $db->sql_query($query);
		// On récupère le n° d'id du mod
		$query = "SELECT `id` FROM `".TABLE_MOD."` WHERE `action`='QuiMSonde' AND `active`='1' LIMIT 1";
		$result = $db->sql_query($query);
		$mod_id = $db->sql_fetch_row($result);
		$mod_id = $mod_id[0];

		if($db->sql_numrows($result) != 0)
			{
				//Bonne nouvelle le mod xtense 2 est installé !
				//Maintenant on regarde si eXchange est dedans normalement il devrait pas mais on est jamais trop prudent...
				$query = 'Select * From '.TABLE_XTENSE_CALLBACKS.' where mod_id = '.$mod_id.' ';
				$result = $db->sql_query($query);
				$nresult = $db->sql_numrows($result);
				if($nresult == 0)
				{
					// Il est pas dedans alors on l'ajoute :
					$query = 'INSERT INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES 
					('.$mod_id.', "qms_import_enemy_spy", "ennemy_spy", 1)';
					$db->sql_query($query);		
					echo("<script> alert('La compatibilité du mod Qui Me Sonde avec le mod Xtense2 est installée !') </script>");
				}
			}	
		else
			{
			//On averti qu'Xtense 2 n'est pas installé :
			echo("<script> alert('Le mod Xtense 2 n\'est pas installé. \nLa compatibilité du mod Qui Me Sonde ne sera donc pas installée !\nPensez à installer Xtense 2 c'est pratique ;)') </script>");
			}	
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>