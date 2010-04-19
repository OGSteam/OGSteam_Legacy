<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) {
    die("Hacking attempt");
}

global $table_prefix;

$query = $db->sql_query('SELECT version FROM '.TABLE_MOD.' WHERE root = "Xtense"');
list($version) = mysql_fetch_row($query);

if (version_compare($version, '2.0b2', '<=')) {
//if ($version == '2.0b2') {
	$db->sql_query("ALTER TABLE `".$table_prefix."xtense_callbacks` CHANGE `type` `type` ENUM( 'rc_cdr', 'overview', 'system', 'ally_list', 'buildings', 'research', 'fleet', 'defense', 'spy', 'ennemy_spy', 'rc', 'msg', 'ally_msg', 'expedition', 'ranking_player_fleet', 'ranking_player_points', 'ranking_player_research', 'ranking_ally_fleet', 'ranking_ally_points', 'ranking_ally_research' ) NOT NULL");
	
	$version = '2.0b2';
}

if (version_compare($version, '2.0b4', '<=')) {
	$db->sql_query('ALTER TABLE `'.$table_prefix.'xtense_callbacks` DROP INDEX `mod_id`');
	$db->sql_query('ALTER TABLE `'.$table_prefix.'xtense_callbacks` ADD UNIQUE (`mod_id` ,`function` ,`type`)');
	$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_plugin_root", "0"), ("xtense_log_reverse", "0")');
	
	$version = '2.0b4';
}

if (version_compare($version, '2.0b6', '<=')) {
	$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_spy_autodelete", "1")');
	
	$version = '2.0b6';
}

if (version_compare($version, '2.0b8', '<=')) {
	$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_log_ogspy", "0")');
	
	// Mise a jour des fichiers log
	$dir = 'mod/Xtense/log/';
	$fp = opendir($dir);
	
	while (($file = readdir($fp)) !== false) {
		if ($file == '.' || $file == '..') continue;
		if (preg_match('!([0-9]+)-([0-9]+)-([0-9]+)\.log!', $file, $matches)) {
			$oldFile = $dir.$file;
			$newFile = $dir.substr($matches[3], 2).$matches[2].$matches[1].'.log';
			
			if (file_exists($newFile)) {
				$f = fopen($newFile, 'r+');
				fwrite($f, file_get_contents($oldFile));
				fclose($f);
				
				unlink($oldFile);
			} else {
				rename($dir.$file, $newFile);
			}
		}
	}
	
	closedir($fp);
	
	$version = '2.0b8';
}

list($name, $version, $required_version) = file('mod/Xtense/version.txt');
$db->sql_query('UPDATE '.TABLE_MOD.' SET version = "'.$version.'" WHERE action="Xtense"');

?>