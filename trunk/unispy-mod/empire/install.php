<?php
/**
* install.php du Mod Empire
* @package Empire
* @author ben.12
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_MOD_EMPIRE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."mod_empire");

$query = "CREATE TABLE ".TABLE_MOD_EMPIRE." (".
	" user_id int(11) NOT NULL default '0',".
	" activate enum('0','1') NOT NULL default '0',".
	" users_permits text NOT NULL,".
	" PT5 int(11) NOT NULL default '0',".
	" GT50 int(11) NOT NULL default '0',".
	" CLEG int(11) NOT NULL default '0',".
	" CLAN int(11) NOT NULL default '0',".
	" FREG int(11) NOT NULL default '0',".
	" DEST int(11) NOT NULL default '0',".
	" OVER int(11) NOT NULL default '0',".
	" FORT int(11) NOT NULL default '0',".
	" HYPE int(11) NOT NULL default '0',".
	" COLL int(11) NOT NULL default '0',".
	" SOND int(11) NOT NULL default '0',".
	" COLO int(11) NOT NULL default '0',".
	" VE int(11) NOT NULL default '0',".
	" primary key (user_id))";
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Empire','Empire','mod_empire','Empire','empire.php','1.0','1')";
$db->sql_query($query);
?>
