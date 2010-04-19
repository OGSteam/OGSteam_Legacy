<?php
/**
* uninstall.php : Désinstallation du module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.4
* @package Sogsrov
*/

// vérification de sécurité
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

define("IN_SOGSROV", true);

require_once('./mod/sogsrov/sog_inc.php');

$queries = array();
$queries[] = "DELETE FROM `" . TABLE_CONFIG . "` WHERE `config_name` LIKE 'sogsrov_%'";
$queries[] = "DROP TABLE IF EXISTS `" . TABLE_SOGSROV . "`";
$queries[] = "DROP TABLE IF EXISTS `" . TABLE_SOGSROV_CONF . "`";
foreach ($queries as $query)
	$db->sql_query($query);

?>