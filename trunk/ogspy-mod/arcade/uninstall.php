<?php
/**
* uninstall.php : Desinstallation du Module Arcade
* @author ericalens <ericalens@ogsteam.fr> http://www.ogsteam.fr
* @copyright OGSteam 2006 
* @version 2.0
* @package Arcade
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
	}

// La suppression du mod dans la table de mod est faites par OGSpy
// (Donc pas besoin de la faire dans le fichier uninstall.php)

// Suppression des tables spécifiques au module

$query="DROP TABLE IF EXISTS `ogspy_arcade`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_ban`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_game`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_online`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_tourgame`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_tournament`";
$db->sql_query($query);

$query="DROP TABLE IF EXISTS `ogspy_arcade_tourscore`";
$db->sql_query($query);
// Suppression des variables de configuration du module dans la table de config

$query="DELETE FROM ".TABLE_CONFIG." WHERE config_name like 'arcade_%'";
$db->sql_query($query);

?>
