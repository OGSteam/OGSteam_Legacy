<?php
/**
 * install.php 

Script d'installation

 * @package MP_Logger
 * @author Sylar
 * @link http://www.ogsteam.fr
 * @version : 0.1
 * dernière modification : 16.10.07
 * Module de capture des messages entre joueurs
 */
// L'appel direct est interdit
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
//Définitions
global $db;
global $table_prefix;

$mod_folder = "mplogger";
install_mod($mod_folder);

define("TABLE_MPC", $table_prefix."MP_Logger");
define("TABLE_MPC_Config", $table_prefix."MP_Logger_config");
define("FOLDER_MPC","mod/MP_Logger");
//Création de la table des espionnages
$query = "CREATE TABLE IF NOT EXISTS  `".TABLE_MPC."` 
	(
	  `id` INT( 11 ) NOT NULL AUTO_INCREMENT ,
	  `sender_id` INT( 11 ) DEFAULT '0' NOT NULL ,
	  `datadate` INT( 11 ) DEFAULT '0' NOT NULL ,
	  `expediteur`VARCHAR( 64 ) DEFAULT '?' NOT NULL ,
	  `titre`VARCHAR( 32 ) DEFAULT '?' NOT NULL ,
	  `contenu` VARCHAR( 512 ) DEFAULT '?' NOT NULL ,
	  `public` INT ( 1 ) DEFAULT '0' NOT NULL ,
	  UNIQUE ( `id`)
	)
	TYPE = MYISAM ";
$db->sql_query($query);
// Création de la table des configurations
$query = "CREATE TABLE IF NOT EXISTS  `".TABLE_MPC_Config."` 
	(
	  `user_id` INT ( 11 ) DEFAULT '0' NOT NULL ,
	  `config` VARCHAR( 11 ) DEFAULT '' NOT NULL ,
	  `valeur` VARCHAR( 11 ) DEFAULT '' NOT NULL ,
	  INDEX ( `config` ) ,
	  UNIQUE ( `config` ) 
	)
	TYPE = MYISAM ";
$db->sql_query($query);
/*/ Génération des configuration par défault
$query = "INSERT INTO ".TABLE_MPC_Config." ( `config` , `valeur`) VALUES ( 'lignes' , '10' )";
$db->sql_query($query);
$query = "INSERT INTO ".TABLE_MPC_Config." ( `config` , `valeur`) VALUES ( 'jours' , '365' )";
$db->sql_query($query);*/

?>