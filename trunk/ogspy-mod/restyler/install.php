<?php
/**
* install.php Installation du module
* @package modREstyler
* @author oXid_FoX
* @link http://www.ogsteam.fr
* created		: 03/10/2006 22:33:16
*/


define('IN_SPYOGAME', true);

// insertion du mod (numéro de version automatique)
if (file_exists('mod/modREstyler/version.txt')) {
	$version_txt = file('mod/modREstyler/version.txt');

	$query = 'INSERT INTO '.TABLE_MOD." ( title, menu, action, root, link, version, active)
		VALUES ( 'modREstyler', 'modREstyler', 'modREstyler', 'modREstyler', 'REstyler.php', '".trim($version_txt[1])."', '1')";
	$db->sql_query($query);
}

?>
