<?php
/**
 * uninstall.php 
 * @package HofRC
 * @author Shad
 * @link http://www.ogsteam.fr
 * @version : 0.0.1
 */
if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}
global $db, $table_prefix;

$mod_uninstall_name = "HOF_RC";
$mod_uninstall_table = $table_prefix.'hofrc_config'.', '.$table_prefix."hofrc_skin".', '.$table_prefix."hofrc_attack".', '.$table_prefix."hofrc_defence".', '.$table_prefix."hofrc_info_rc".', '.$table_prefix."hofrc_rp".', '.$table_prefix."hofrc_title";
uninstall_mod($mod_uninstall_name, $mod_uninstall_table);
?>