<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Recherche plus','Recherche plus','recherche_plus','recherche_plus','recherche_plus.php','0.4e','1')";
$db->sql_query($query);
?>
