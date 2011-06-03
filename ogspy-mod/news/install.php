<?php
/**
* install.php : Installation du Module de news
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @Update by Itori <itori@ogsteam.fr>
* @copyright OGSteam 2006 
* @version 1.1
* @package News
*/
define("IN_SPYOGAME", true);
require_once("common.php");

global $db, $table_prefix;

$is_ok = false;
$mod_folder = "news";
$is_ok = install_mod ($mod_folder);
if ($is_ok == true)
	{
		/**	
		* Création de la table des news si neccessaire
		*/
		function CreateTable()
			{
				global $db, $table_prefix;
				// Suppresion de la table si elle existe
				$query="DROP TABLE IF EXISTS `".$table_prefix."news`;";
				$db->sql_query($query);
				// Creation de la table proprement dites
				$query="CREATE TABLE `".$table_prefix."news` (
					`id` int(11) NOT NULL auto_increment,
					`news_time` int(11) NOT NULL,
					`title` varchar(250) NOT NULL default '' COMMENT 'Titre de la News',
					`body` blob COMMENT 'Le texte de la news',
					`idcat` int(11) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM;";
				$db->sql_query($query);	

				// Suppresion de la table si elle existe
				$query="DROP TABLE IF EXISTS `".$table_prefix."news_cat`;";
				$db->sql_query($query);
				// Creation de la table proprement dites
				$query="CREATE TABLE `".$table_prefix."news_cat` (
					`id` int(11) NOT NULL auto_increment,
					`categorie` varchar(250) NOT NULL,
					`souscat` varchar(250) NOT NULL,
					PRIMARY KEY  (`id`)
					) ENGINE=MyISAM;";
				$db->sql_query($query);

				$query = "ALTER TABLE `".TABLE_GROUP."` ADD `news_post` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
					ADD `news_edit` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
					ADD `news_del` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
					ADD `news_admin` ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
				$db -> sql_query($query);	
			}

		function addmod() 
			{
				global $db;
				global $table_prefix;
		
				$query = "INSERT INTO `".$table_prefix."news_cat` (`categorie`, `souscat`) SELECT 'Tutoriels', `menu` FROM `".TABLE_MOD."` WHERE `title` not like 'Group.%'";
				$db->sql_query($query);
			}

		/* 
		* Fonction d'insertion d'une valeur de configuration dans la TABLE_CONFIG
		*/

		function SetConfig($key,$value)
			{
				global $db;

				$query="REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('$key','$value') ";
				$db->sql_query($query);
			}

		/*** Insertion/Reinitialisation des valeurs de configuration par défaut ***/
		function CreateConfig()
			{
				global $db;
				SetConfig("news_BlinkHourDuration","24");
			}

		// Execution de l'installation
		CreateTable();
		CreateConfig();
		addmod();
	}
else
	{
		echo  "<script>alert('Désolé, un problème a eu lieu pendant l'installation, corrigez les problèmes survenue et réessayez.');</script>";
	}
?>

