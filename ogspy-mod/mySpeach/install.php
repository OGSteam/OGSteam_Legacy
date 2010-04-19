<?php
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ('Shoutbox MySpeach','Shoutbox(MS)','myspeach','myspeach','myspeach.php','3.01c','1')";
$db->sql_query($query);
?>
