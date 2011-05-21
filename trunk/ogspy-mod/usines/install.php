<?php
define("IN_SPYOGAME", true);
require_once("common.php");
$filename = 'mod/usines/version.txt';
if (file_exists($filename)) $file = file($filename);
$query = "INSERT INTO ".TABLE_MOD." (id, title, menu, action, root, link, version, active) VALUES ('','Usines','Usines','usines','usines','usines.php','".trim($file[1])."','1')";
$db->sql_query($query);
?>
