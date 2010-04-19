<?php
/**
* update.php du mod empire
* @package Empire
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_MOD_EMPIRE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."mod_empire");

$query = "SELECT `version` FROM ".TABLE_MOD." WHERE `action`='mod_empire'";
$result = $db->sql_query($query);
if(list($version) = $db->sql_fetch_row($result)) {
	switch($version) {
	
	case '0.1':
		$query = "ALTER TABLE `".TABLE_MOD_EMPIRE."` CHANGE `users_permits` `users_permits` TEXT NOT NULL";
		$db->sql_query($query);
		
	case '0.1b':
		$query = "ALTER TABLE `".TABLE_MOD_EMPIRE."` ADD `TR` int(11) NOT NULL default '0'";
		$db->sql_query($query);
		
	}
}

$query = "UPDATE ".TABLE_MOD." SET `version`='0.1c' WHERE `action`='mod_empire'";
$db->sql_query($query);
?>
