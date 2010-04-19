<?php
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "INSERT INTO ".TABLE_MOD." ( title, menu, action, root, link, version, active) VALUES ( 'leslunes', 'Tout sur<br>les lunes', 'leslunes', 'leslunes', 'leslunes.php', '0.3b', '1')";

$db->sql_query($query);
?>