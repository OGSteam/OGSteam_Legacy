<?php
/**
* install.php : Installation du module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

// vérification de sécurité
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

define("IN_SOGSROV", true);

require_once('mod/sogsrov/sog_inc.php');

/**
* Préparation et nettoyage avant l'installation du module
*/
function PrepareTable()
{
	global $db;
	
	$queries = array();
	$queries[] = "DELETE FROM `" . TABLE_MOD . "` WHERE `action` = 'sogsrov'";
	$queries[] = "DROP TABLE IF EXISTS `" . TABLE_SOGSROV . "`";
	$queries[] = "DROP TABLE IF EXISTS `" . TABLE_SOGSROV_CONF . "`";
	foreach ($queries as $query)
		$db->sql_query($query);
}

/**
* Insertion et Activation dans la table des modules
*/
function ActivateMod()
{
	global $db;

	$query =	"INSERT INTO " . TABLE_MOD;
	$query .= " (id, title, menu, action, root, link, version, active)";
	$query .= " VALUES (";
	$query .=	" '',";					// l'id sera généré par MySQL
	$query .=	" 'SOGSROV',";			// <titre de votre mod>
	$query .=	" '- SOGSROV -',";	// <texte du lien pour le menu>
	$query .=	" 'sogsrov',";			// <paramètre GET => index.php?action=xxxx>
	$query .=	" 'sogsrov',";			// <nom du répertoire de votre mod>
	$query .=	" 'sogsrov.php',";	// <chemin du fichier principal>
	$query .=	" '0.4',";				// <version de votre mod>
	$query .=	" '1'";					// 1 : mod actif ; 0 : mod désactivé
	$query .= ")"; 	// Fin de la parenthèse de VALUES

	$db->sql_query($query);
}

/*
CREATE TABLE ogspy_sogsrov (
  user_id int(11) NOT NULL default '0',
  spy_id int(11) NOT NULL default '0',
  priority enum('-1','0','1') NOT NULL default '0',
  PRIMARY KEY  (user_id,spy_id)
) ;

CREATE TABLE `ogspy_sogsrov_conf` (
`user_id` INT( 11 ) DEFAULT '1' NOT NULL ,
`conf_name` VARCHAR( 255 ) NOT NULL ,
`conf_value` VARCHAR( 255 ) NOT NULL,
PRIMARY KEY ( `user_id` , `conf_name` )
) TYPE = MYISAM COMMENT = 'Table de configuration de SOGSROV';

*/

PrepareTable();
ActivateMod();
//CreateTable();

?>
