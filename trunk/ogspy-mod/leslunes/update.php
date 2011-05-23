<?php
define("IN_SPYOGAME", true);
require_once("common.php");
$query = "UPDATE ".TABLE_MOD." SET version='0.3b' WHERE title='leslunes' LIMIT 1";
$db->sql_query($query);
?>