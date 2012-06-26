<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 * @licence GNU
 */

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
    die("Hacking attempt");
}

global $de,$table_prefix;
$mod_uninstall_name = "reinette";
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table );


generate_config_cache();

?>