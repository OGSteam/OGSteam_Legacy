<?php
// renomme le titre de la shoutbox
define("IN_SPYOGAME", true);
require_once("common.php");

$query = "UPDATE ".TABLE_MOD." SET menu='Shoutbox', version='3.01c' WHERE action='myspeach'";
$db->sql_query($query);
?>