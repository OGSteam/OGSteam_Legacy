<?php
/**
* install.php Installation du module modSQL
* @package modSQL
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 11/03/2007 10:08:10
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

$queries = array();

// ajout du choix d'accès pour les coadmins
$queries[] = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'modSQL_coadmin\', \'0\')';
// ajout de l'option fullscreen
$queries[] = 'INSERT INTO `'.TABLE_CONFIG.'` (`config_name`, `config_value`) VALUES (\'modSQL_fullscreen\', \'0\')';

// insertion du mod (numéro de version automatique)
if (file_exists('mod/modSQL/version.txt')) {
	$version_txt = file('mod/modSQL/version.txt');

	$queries[] = 'INSERT INTO '.TABLE_MOD.' (title, menu, action, root, link, version, active) VALUES'
		." ( 'modSQL', 'modSQL', 'modSQL', 'modSQL', 'index.php', '".trim($version_txt[1])."', '1')";
}


// exécution de toutes les requêtes
foreach ($queries as $query) {
	$db->sql_query($query, false);
}

?>
