<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_RC_SAVE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."rc_save");

$query = "CREATE TABLE ".TABLE_RC_SAVE." (".
	" user_id int(11) NOT NULL default '0',".
	" rc_id int(11) NOT NULL default '0',".
	" rc_comment varchar(255) NOT NULL ,".
	" time int(11) NOT NULL default '0',".
	" public enum('0','1') NOT NULL default '0',".
	" primary key ( rc_id ) )";
$db->sql_query($query);

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','RC Save','RC Save','rc_save','RC_save','RC_Save.php','0.4c','1')";
$db->sql_query($query);


?>
