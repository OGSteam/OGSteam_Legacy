<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "DELETE FROM ".TABLE_MOD." WHERE root='recycleurs'";
$db->sql_query($query);

define("table_recycleurs", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."recycleurs");

$query = "DROP TABLE ".table_recycleurs;
$db->sql_query($query);
$query = "DROP TABLE ".table_phalanges;
$db->sql_query($query);
?>