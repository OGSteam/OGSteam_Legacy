<?php
define("IN_SPYOGAME", true);
require_once("common.php");

global $db;

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','REFinder', 'RE Finder', 'refinder', 'REFinder', 'finder.php', '0.4', '1')";
$db->sql_query($query);
?>
