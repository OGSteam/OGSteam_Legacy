<?php
/*
* update.php
* @package [MOD] Temp de Vol
* @author Snipe <santory@websantory.net>
* @version 0.2
*	created		: 07/01/2007
*/


if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db,$table_prefix;
if (file_exists('mod/tempsvols/version.txt')) { 
	$file = file('mod/tempsvols/version.txt'); 
}

// mise � jour du num�ro de version
	$query  = 'UPDATE `'.TABLE_MOD.'` SET `version` = \''.trim($file[1]).'\' WHERE `title` = \'tempsvol\'';
	$db->sql_query($query);
?>