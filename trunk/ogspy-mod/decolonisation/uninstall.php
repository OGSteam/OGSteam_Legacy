<?php
if (!defined('IN_SPYOGAME')) die("Hacking Attempt!");
 
global $db, $table_prefix;
$mod_uninstall_name = "decolonisation";

uninstall_mod($mod_uninstall_name);
?>