<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

define("TABLE_RC_SAVE", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."rc_save");

$query = "DROP TABLE ".TABLE_RC_SAVE;
$db->sql_query($query);
?>