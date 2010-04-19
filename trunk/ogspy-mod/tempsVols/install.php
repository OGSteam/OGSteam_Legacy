<?php
/*
* install.php
* @package [MOD] Temp de Vol
* @author Snipe <santory@websantory.net>
* @version 0.2
*	created		: 07/01/2007
*/

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

if (file_exists('mod/tempsvols/version.txt')) { 
	$file = file('mod/tempsvols/version.txt'); 
}

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('', 'tempsvol', 'Temps de vol', 'tempsvols', 'tempsvols', 'tempsvols.php', '".trim($file[1])."', '1')";

$db->sql_query($query);
?>