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

$filename = 'mod/production/version.txt';
if (file_exists($filename)) $file = file($filename);

// mise à jour du numéro de version
	$query  = "UPDATE `".TABLE_MOD."` SET `version` = '".trim($file[1])."' WHERE `action` = 'production'";
	$db->sql_query($query);
?>
