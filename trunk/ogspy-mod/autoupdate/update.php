<?php
/** $Id$ **/
/**
* update.php Met à jour le mod
* @package [MOD] AutoUpdate
* @author Bartheleway <contactbarthe@g.q-le-site.webou.net>
* @version 1.0a
* created	: 27/10/2006
* modified	: 19/01/2007
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

// MAJ du numéro de version automatique
if (file_exists('mod/'.$pub_modroot.'/version.txt')) {
	$file = file('mod/'.$pub_modroot.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}
elseif (file_exists('../mod/'.$pub_modroot.'/version.txt')) {
	$file = file('../mod/'.$pub_modroot.'/version.txt');

	$db->sql_query('UPDATE '.TABLE_MOD.' SET `version` = \''.trim($file[1]).'\' WHERE `id` = \''.$pub_mod_id.'\'');
}

if(file_exists("mod/autoupdate/modupdate.xml")) {
	unlink("mod/autoupdate/modupdate.xml");
}
?>
