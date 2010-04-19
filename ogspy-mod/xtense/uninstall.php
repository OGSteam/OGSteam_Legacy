<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 * @licence GNU
 */

error_reporting(E_ALL);

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
    die("Hacking attempt");
}

global $table_prefix;

$db->sql_query('DROP TABLE IF EXISTS `'.$table_prefix.'xtense_groups`');
$db->sql_query('DROP TABLE IF EXISTS `'.$table_prefix.'xtense_callbacks`');
$db->sql_query('DELETE FROM '.TABLE_CONFIG.' WHERE config_name LIKE "xtense2%"');


?>