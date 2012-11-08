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

global $db,$table_prefix;
list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM " .
    TABLE_MOD . " WHERE action = 'reinette'"));

require_once ("mod/{$root}/includes/functions.php");



$mod_uninstall_name = "reinette";
$mod_uninstall_table = TABLE_TMP.','.TABLE_CFG;
uninstall_mod ($mod_uninstall_name, $mod_uninstall_table);


generate_config_cache();

?>