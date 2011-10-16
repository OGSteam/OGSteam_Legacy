<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
$mod_uninstall_name = "recycleurs";
$mod_uninstall_table = $table_prefix."recycleurs".','.$table_prefix."phalanges";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>