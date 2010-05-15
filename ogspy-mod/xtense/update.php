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

global $table_prefix,$server_config;
require_once("mod/xtense/includes/functions.php");

$query = $db->sql_query('SELECT id, version FROM '.TABLE_MOD.' WHERE root = "Xtense"');
list($id, $version) = mysql_fetch_row($query);

if (version_compare($version, '2.0', '<')) {
	// 'Ancien module XTense installé !'
	// Désinstallation de l'ancien module Xtense
	$files = Array( "xtense_plugin.php","mod/xtense/changelog.php","mod/xtense/config.php","mod/xtense/functions.php","mod/xtense/journal.php","mod/xtense/ogp_unilist_fr.xml","mod/xtense/xtense_cmdsman.php","mod/xtense/xtense_functions.php","mod/xtense/xtense_ogsinc.php","mod/xtense/xtense_plugin.php","mod/xtense/xtense_plugin_inc.php","mod/xtense/xtense_uni_man.php");
	$requests = Array( "DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_debug'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_maintenance'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogslogon'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsspyadd'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsgalview'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsplayerstats'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsallystats'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsallyhistory'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserbuildings'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsusertechnos'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserdefence'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsuserplanetempire'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogsusermoonempire'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logunallowedconnattempt'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handlegalaxyviews'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleplayerstats'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleallystats'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_handleespioreports'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_forcestricnameuniv'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_logogssqlfailure'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_ogsplugin_numuniv'","DELETE FROM ".TABLE_CONFIG." where config_name = 'xtense_ogsplugin_nameuniv'","delete from ".TABLE_MOD." where id = ".$id);
	foreach($requests as $req)
		$db->sql_query($req);
	foreach($files as $file)
	if (file_exists($file)) 
		unlink($file);
	if(defined('IN_SPYOGAME'))
		log_("mod_uninstall", "Xtense plugin v".$version);
	redirection('index.php?action=mod_install&directory=XTense');
}

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
	$dir = 'mod/xtense/log/';
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

if (version_compare($version, '2.0.4140', '<=')) {
	$db->sql_query("ALTER TABLE `".$table_prefix."xtense_callbacks` CHANGE `type` `type` ENUM( 'rc_cdr', 'overview', 'system', 'ally_list', 'buildings', 'research', 'fleet', 'fleetSending', 'defense', 'spy', 'ennemy_spy', 'rc', 'msg', 'ally_msg', 'expedition', 'ranking_player_fleet', 'ranking_player_points', 'ranking_player_research', 'ranking_ally_fleet', 'ranking_ally_points', 'ranking_ally_research' ) NOT NULL");
}

list($mod_name, $mod_version,$toolbar_min_version, $ogspy_min_version,$unispy_min_version) = file('mod/xtense/version.txt');
$db->sql_query('UPDATE '.TABLE_MOD.' SET version = "'.$mod_version.'" WHERE action="Xtense"');


//copie de xtense.php à la racine
//echo "config:".$server_config['xtense_plugin_root'];
//print_r($server_config);
if($server_config['xtense_plugin_root']) {
	if (move_plugin()) {
		//$config['xtense_plugin_root'] = 1;
		//$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_plugin_root", "1")');
		//echo "ok";
	}
	//else echo "pas ok";
}

?>