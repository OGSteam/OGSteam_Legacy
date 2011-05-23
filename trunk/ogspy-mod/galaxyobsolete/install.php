<?php
/**
 */

if (!defined('IN_SPYOGAME')) exit;
include("mod/{$root}/common.php");

//-------------
$db->sql_query('REPLACE INTO '.TABLE_MOD.' (title, menu, action, root, link, version, active) '.
"VALUES ('{$mod_name}', '{$mod_menu}', '{$root}', '{$root}', 'index.php', '{$mod_version}', 1)");


?>