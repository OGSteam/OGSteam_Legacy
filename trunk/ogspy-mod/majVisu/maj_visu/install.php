<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "INSERT INTO ".TABLE_MOD." (title, menu, action, root, link, version, active) VALUES ( 'visu_maj', 'maj_visu', 'maj_visu', 'maj_visu', 'maj.php', '1.0', '1')";

$db->sql_query($query);
?>


