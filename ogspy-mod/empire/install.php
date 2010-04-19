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
	" PT int(11) NOT NULL default '0',".
	" GT int(11) NOT NULL default '0',".
	" CLE int(11) NOT NULL default '0',".
	" CLO int(11) NOT NULL default '0',".
	" CR int(11) NOT NULL default '0',".
	" VB int(11) NOT NULL default '0',".
	" VC int(11) NOT NULL default '0',".
	" REC int(11) NOT NULL default '0',".
	" SE int(11) NOT NULL default '0',".
	" BMD int(11) NOT NULL default '0',".
	" DST int(11) NOT NULL default '0',".
	" EDLM int(11) NOT NULL default '0',".
	" TR int(11) NOT NULL default '0',".
	" primary key (user_id))";
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Empire','Empire','mod_empire','Empire','empire.php','0.1c','1')";
$db->sql_query($query);
?>
