<?php
define("IN_SPYOGAME", true);
require_once("common.php");
$filename = 'mod/gestionMod/version.txt';
if (file_exists($filename)) $file = file($filename);

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Gestion MOD','Gestion MOD','gestion','gestionMod','gestion.php', '".trim($file[1])."','1')";
$db->sql_query($query);
$query2 = "ALTER TABLE ".TABLE_MOD." CHANGE `menu` `menu` VARCHAR( 254 )";
$db->sql_query($query2);
?>