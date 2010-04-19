<?php
/**
* update.php : Mise à jour du module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

// vérification de sécurité
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

define("IN_SOGSROV", true);

require_once('./mod/sogsrov/sog_inc.php');

/**
* Actualise la table des modules avec la nouvelle version de SOGSROV
*/
function UpdateVersion()
{
	global $db;
	
	$query = "UPDATE `" . TABLE_MOD;
	$query .= "` SET `version`='0.4' WHERE `action`='sogsrov'";
	$db->sql_query($query);
}

$version = GetVersion();
//if (version_compare($version, "0.4") == -1) CreateTables();
UpdateVersion();

?>