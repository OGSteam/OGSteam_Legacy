<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$filename = 'mod/Ressources/version.txt';
if (file_exists($filename)) $file = file($filename);

global $table_prefix;

$query = "CREATE TABLE IF NOT EXISTS `".$table_prefix."user_ressources` (
	`user_id` INT(11) NOT NULL,
	`planet_id` INT(11) NOT NULL,
	`metal` INT(12) NOT NULL DEFAULT '0',
	`crystal` INT(12) NOT NULL DEFAULT '0',
	`deuterium` INT(12) NOT NULL DEFAULT '0',
	`timestamp` INT(12) NOT NULL DEFAULT '0',
	PRIMARY KEY (`user_id`, `planet_id`))";
$db->sql_query($query);

$query = "CREATE TABLE IF NOT EXISTS `".$table_prefix."mod_ressources_hide` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT(11) NOT NULL,
	`type` INT(2) NOT NULL,
	`level` INT(2) NOT NULL DEFAULT '1')";
$db->sql_query($query);

$query = "CREATE TABLE IF NOT EXISTS `".$table_prefix."mod_ressources_trade` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT(11) NOT NULL,
	`type` INT(2) NOT NULL,
	`metal` INT(12) NOT NULL DEFAULT '0',
	`crystal` INT(12) NOT NULL DEFAULT '0',
	`deuterium` INT(12) NOT NULL DEFAULT '0',
	`metal_rate` INT(3) NOT NULL DEFAULT '300',
	`crystal_rate` INT(3) NOT NULL DEFAULT '200',
	`deuterium_rate` INT(3) NOT NULL DEFAULT '100')";
$db->sql_query($query);

$query = "CREATE TABLE IF NOT EXISTS `".$table_prefix."mod_ressources_construction` (
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT(11) NOT NULL,
	`type` INT(2) NOT NULL,
	`level` INT(12) NOT NULL DEFAULT '1')";
$db->sql_query($query);

$query = "UPDATE ".TABLE_MOD." SET version = '".trim($file[1])."' WHERE action = 'ressources' ";
$db->sql_query($query);
?>
