<?php
/**
* update.php Fichier de mise à jour du module modSQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 10:08:57
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

global $db;

// on récupère le numéro de version
$result = mysql_query('SELECT `version` FROM `'.TABLE_MOD.'` WHERE `id` = \''.$pub_mod_id.'\'');
$mod_version = mysql_result($result,0,'version');

// et ensuite, on fait les MAJ qui s'imposent !
switch($mod_version) {

case '0.1':
	// création des nouveaux champs (mod_fullscreen), v0.2
	$query = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'modSQL_fullscreen\', \'0\')';
	$db->sql_query($query);

}

// MAJ du numéro de version automatique
if (file_exists('mod/'.$root.'/version.txt')) {
	$file = file('mod/'.$root.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}

?>
