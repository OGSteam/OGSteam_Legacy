<?php
/**
* uninstall.php Desinstallation du module modSQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 10:08:19
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');
global $db;
$mod_uninstall_name = "modSQL";
$mod_uninstall_table = "";
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);

// suppression du param�tre modSQL_coadmin
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'modSQL_coadmin\'';
// suppression de l'option fullscreen
$queries[] = 'DELETE FROM `'.TABLE_CONFIG.'` WHERE `config_name` = \'modSQL_fullscreen\'';

// ex�cution de toutes les requ�tes
foreach ($queries as $query) {
	$db->sql_query($query, false);
}

?>
