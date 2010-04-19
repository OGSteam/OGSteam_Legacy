<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $table_prefix;

$query = "DROP TABLE IF EXISTS `".$table_prefix."mod_pandore`";
$db->sql_query($query);
?>
