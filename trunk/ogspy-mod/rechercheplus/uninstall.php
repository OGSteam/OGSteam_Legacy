<?php
if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
 
global $db, $table_prefix;
$mod_uninstall_name = "rechercheplus";
//$mod_uninstall_table = $table_prefix.  "table1";
uninstall_mod ($mod_uninstall_name);
?>