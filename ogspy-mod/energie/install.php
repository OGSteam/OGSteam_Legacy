<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Vérification de la présence des informations officiers et insertion si besoin (OGSpy < 3.05)
$quet = mysql_query("SELECT * FROM ".TABLE_USER." WHERE `off_amiral` = '0' OR `off_amiral` = '1' LIMIT 1");
if (!$quet) {
	$query = "ALTER TABLE ".TABLE_USER." ADD `off_amiral` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
	ADD `off_ingenieur` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
	ADD `off_geologue` ENUM( '0', '1' ) NOT NULL DEFAULT '0',
	ADD `off_technocrate` ENUM( '0', '1' ) NOT NULL DEFAULT '0'";
	$db->sql_query($query);
}

global $server_config;
require_once("mod/Energie/lang/lang_fr.php");
if (file_exists("mod/Energie/lang/lang_".$server_config['language'].".php")) require_once("mod/Energie/lang/lang_".$server_config['language'].".php");

$filename = 'mod/Energie/version.txt';
if (file_exists($filename)) $file = file($filename);

$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ('".$lang['energy_energy']."','".$lang['energy_energy']."','energie','Energie','energie.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>
