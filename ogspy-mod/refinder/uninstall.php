<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db, $table_prefix;
$mod_uninstall_name = "refinder";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);
?>