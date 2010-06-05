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

global $table_prefix;

list($version, $root) = $db->sql_fetch_row($db->sql_query("SELECT version, root FROM ".TABLE_MOD." WHERE action = 'xtense'"));

require_once("mod/{$root}/includes/config.php");

$db->sql_query('DROP TABLE IF EXISTS `'.TABLE_XTENSE_GROUPS.'`');
$db->sql_query('DROP TABLE IF EXISTS `'.TABLE_XTENSE_CALLBACKS.'`');
$db->sql_query('DELETE FROM '.TABLE_CONFIG.' WHERE config_name LIKE "xtense_%"');


?>