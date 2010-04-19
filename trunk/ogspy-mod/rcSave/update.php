<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_RC_SAVE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."rc_save");

$query = "SELECT version FROM ".TABLE_MOD." WHERE action='rc_save'";
$result = $db->sql_query($query);

list($version) = $db->sql_fetch_row($result);

switch($version) {
	case '0.1':
	case '0.2':
	case '0.3':
	case '0.3b':
		$query = "ALTER TABLE ".TABLE_RC_SAVE." ADD `public` enum('0','1') NOT NULL default '0' AFTER `time`";
		$db->sql_query($query);
	case '0.4':
	case '0.4a':
	case '0.4b':
	default:
}


$query = "UPDATE ".TABLE_MOD." SET version='0.4c' WHERE action='rc_save'";
$db->sql_query($query);
?>