<?php
/**
 */

if (!defined('IN_SPYOGAME')) exit;
include("mod/{$root}/common.php");


$db->sql_query("DELETE FROM ".TABLE_MOD." WHERE root LIKE '{$mod_name}'");


?>