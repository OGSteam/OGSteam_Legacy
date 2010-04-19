<?php
define("IN_SPYOGAME", true);
require_once("common.php");

global $db;

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('LiteSearch', 'Lite Search', 'litesearch', 'litesearch', 'lite.php', '1.2b', '1')";
$db->sql_query($query);
?>
