<?php
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Graviton','Graviton','graviton','graviton','graviton.php','0.5','1')";
$db->sql_query($query);
?>
