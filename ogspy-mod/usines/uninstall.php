<?php
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $db;
$mod_uninstall_name="usines";
uninstall_mod($mod_uninstall_name,$mod_uninstall_table);
?>