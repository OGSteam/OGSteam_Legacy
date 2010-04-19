<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $server_config;
global $table_prefix;
require_once("mod/Ressources/lang/lang_en.php");
if (file_exists("mod/Ressources/lang/lang_".$server_config['language'].".php")) require_once("mod/Ressources/lang/lang_".$server_config['language'].".php");

$filename = 'mod/Ressources/version.txt';
if (file_exists($filename)) $file = file($filename);

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

$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active, admin_only) VALUES ('".$lang['ressources_name']."','".$lang['ressources_name']."','ressources','Ressources','ressources.php','".trim($file[1])."','1','')";
$db->sql_query($query);
$mod_id = $db->sql_insertid();

define("TABLE_XTENSE_CALLBACKS", $table_prefix."xtense_callbacks");
$query = "SHOW TABLES FROM ".$db->dbname." LIKE '".TABLE_XTENSE_CALLBACKS."'";
$result = $db->sql_query($query);
if ($db->sql_numrows($result) != 0) {
	$query = "SELECT * FROM ".TABLE_XTENSE_CALLBACKS." WHERE mod_id = ".$mod_id;
	$result = $db->sql_query($query);
	$nresult = $db->sql_numrows($result);
	if ($nresult == 0) {
		$query = "INSERT INTO ".TABLE_XTENSE_CALLBACKS." (mod_id, function, type, active) VALUES (".$mod_id.", 'get_overview', 'overview', 1)";
		$db->sql_query($query);
		echo "<script>alert(".$lang['ressources_xtense'].");</script>";
	}
} else {
	echo "<script>alert(".$lang['ressources_no_xtense'].");</script>";
}
?>
