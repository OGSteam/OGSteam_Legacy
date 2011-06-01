<?php
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $db, $table_prefix;
$mod_uninstall_name = "Pandore";
$mod_uninstall_table = $table_prefix."mod_pandore";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>
