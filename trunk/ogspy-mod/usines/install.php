<?php
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Usines','Usines','usines','usines','usines.php','0.2','1')";
$db->sql_query($query);
?>
