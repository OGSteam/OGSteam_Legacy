<?php
/**
* update.php Met à jour le mod
* @package [MOD] RCConv
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 0.5
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

// MAJ du numéro de version automatique
if (file_exists('mod/'.$root.'/version.txt')) {
	$file = file('mod/'.$root.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}
?>