<?php
if (!defined('IN_SPYOGAME')) die('Hacking attempt');
include('./parameters/id.php');

$queries = array();
$queries[] = 'DROP TABLE IF EXISTS '.$table_prefix.'game';
$queries[] = 'DROP TABLE IF EXISTS '.$table_prefix.'game_users';
$queries[] = 'DROP TABLE IF EXISTS '.$table_prefix.'game_recyclage';
$queries[] = 'DELETE FROM '.TABLE_CONFIG.' WHERE `config_name`=\'gameOgame\'';
$queries[] = 'DELETE FROM '.TABLE_MOD_CFG.' WHERE `mod`=\'gameOgame\'';

foreach ($queries as $query) {
	$db->sql_query($query);
}
?>
