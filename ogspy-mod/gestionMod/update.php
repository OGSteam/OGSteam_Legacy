<?php

/**
* update.php Fichier de mise à jour du MOD Gestion MOD
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query  = $db->sql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `title` = \'Gestion MOD\'');
$result = $db->sql_fetch_assoc($query);
$version = $result['version'];

if ($version < 0.8) {
	$query2 = "ALTER TABLE ".TABLE_MOD." CHANGE `menu` `menu` VARCHAR( 254 )";
	$db->sql_query($query2);
	$query3  = 'UPDATE `'.TABLE_MOD.'` SET `root`=\'MODGestion_MOD\' WHERE `title` = \'Gestion MOD\'';
	$db->sql_query($query3);
	//renomemr le dossier
	if (rename('mod/gestion','mod/MODGestion_MOD')!==TRUE) {
		echo '<script type="text/javascript">';
		echo 'alert("Renommez le repertoite gestion en MODGestion_MOD")';
		echo '</script>';
	}
}

// mise à jour du numéro de version
$query  = 'UPDATE `'.TABLE_MOD.'` SET `version` = \'0.9f\' WHERE `title` = \'Gestion MOD\'';
$db->sql_query($query);

?>
