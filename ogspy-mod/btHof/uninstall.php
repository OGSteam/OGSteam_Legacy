<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "DELETE FROM ".TABLE_MOD." WHERE root='bt_hof'";
$db->sql_query($query);

define("table_bthof_conf", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."bthof_conf");
define("table_bthof_flottes", substr(TABLE_USER, 0, strlen(TABLE_USER)-4)."bthof_flottes");

$query = "DROP TABLE ".table_bthof_conf;
$db->sql_query($query);

$query = "DROP TABLE ".table_bthof_flottes;
$db->sql_query($query);


?>