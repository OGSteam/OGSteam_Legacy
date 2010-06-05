<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) die("Hacking Attemp!");
global $table_prefix;

list($version, $root) = $db->sql_fetch_row($db->sql_query("SELECT version, root FROM ".TABLE_MOD." WHERE action = 'xtense'"));

require_once("mod/{$root}/includes/config.php");

?>