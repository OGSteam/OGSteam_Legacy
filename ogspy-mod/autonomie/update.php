<?php
/**
* update.php 
* @package autonomie
* @author Mirtador
* @link http://www.ogsteam.fr
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

global $db;

// MAJ du numéro de version automatique
if (file_exists('mod/'.$root.'/version.txt')) {
	$file = file('mod/'.$root.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}
?>

