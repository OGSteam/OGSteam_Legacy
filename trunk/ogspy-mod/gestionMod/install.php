<?php
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Gestion MOD','Gestion MOD','gestion','MODGestion_MOD','gestion.php','0.9f','1')";
$db->sql_query($query);
$query2 = "ALTER TABLE ".TABLE_MOD." CHANGE `menu` `menu` VARCHAR( 254 )";
$db->sql_query($query2);
?>
