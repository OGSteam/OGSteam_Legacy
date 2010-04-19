<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Portee MIP', 'Portée MIP', 'missiles', 'missiles', 'index.php', '0.2c', '1')";

$db->sql_query($query);
?>