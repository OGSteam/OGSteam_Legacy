<?php
/**
* update.php Fichier de mise à jour du module modREstyler
* @package modREstyler
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created : 03/10/2006 22:35:11
*/


if (!defined('IN_SPYOGAME')) die('Hacking attempt');

// MAJ du numéro de version automatique
if (file_exists('mod/'.$root.'/version.txt')) {
	$file = file('mod/'.$root.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}

?>
