<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'OCarto - Mips', 'OCarto - Mips', 'OCarto', 'OCartoMips', 'index.php', '1.1a', '1')";

$db->sql_query($query);
?>