<?php
/**
 */

if (!defined('IN_SPYOGAME')) exit;
include("mod/{$root}/common.php");

//-------------
$db->sql_query("UPDATE ".TABLE_MOD." set version = '{$mod_version}' WHERE root = '{$root}';");


?>