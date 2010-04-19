<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

error_reporting(E_ALL);

if (!defined('IN_SPYOGAME')) exit;
define('IN', 1);

if (version_compare(phpversion(), '5.1') == -1) {
	header('Content-Type: text/html; charset=utf-8');
	
	echo '<p>FR: Votre hébergement doit disposer de PHP 5.1 pour pouvoir faire fonctionner Xtense. Vous avez actuellement la version "'.phpversion().'"</p>';
	echo '<p>EN: </p>';
	
	exit;
}

global $server_config, $table_prefix;
require_once('mod/Xtense/class/tpl.php');
require_once('mod/Xtense/class/Md5checksum.php');
require_once('mod/Xtense/class/Callback.php');
require_once('mod/Xtense/includes/functions.php');
require_once('mod/Xtense/includes/config.php');

$lang = null;
if ($server_config['version'] == '4.0') {
	$lang = ($user_data['user_language'] == '' ?
				($server_config['language'] == '' ?
					'fr'
				: $server_config['language']) 
			: $user_data['user_language']);
}
loadLocales($lang, 'install');

list($name, $version, $ogspyRequiredVersion) = file('mod/Xtense/version.txt');

$mysqlVersion = mysql_get_client_info();
$ogspyVersion = $server_config['version'];
$phpVersion = phpversion();
$logWritable = is_writable('mod/Xtense/log/');

$mysqlVersionOk = version_compare($mysqlVersion, '4.1', '>=');
$phpVersionOk = true; // puisque testé plus haut
$ogspyVersionOk = version_compare($ogspyVersion, $ogspyRequiredVersion, '>=');

$cs = new Md5checksum('mod/Xtense/');
$checksumFiles = $cs->check('checksum.md5');
$checksumOk = $checksumFiles === true;

// Verification d'erreurs HTTP pour le plugin (500, 403...)
$pluginOk = !!@file_get_contents('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/mod/Xtense/xtense.php');
$pluginMoveable = file_exists('xtense.php') ? is_writable('./') && is_writable('xtense.php') : is_writable('./');

$directoryOld = file_exists('mod/Xtense/xtense_plugin.php');

$tpl = new tpl('mod/Xtense/tpl/');

$tpl->assign(array(
	'mysqlVersion' => $mysqlVersion,
	'mysqlVersionOk' => $mysqlVersionOk,
	'phpVersion' => $phpVersion,
	'ogspyVersion' => $ogspyVersion,
	'ogspyVersionOk' => $ogspyVersionOk,
	'logWritable' => $logWritable,
	'checksumFiles' => $checksumFiles,
	'pluginOk' => $pluginOk,
	'pluginMoveable' => $pluginMoveable,
	'checksumOk' => $checksumOk,
	'directoryOld' => $directoryOld,
	'version' => $version
));

$validForm = false;
if (isset($_GET['install'], $_GET['universe'])) {
	if (preg_match('!^http:\\/\\/uni[0-9]+\\.ogame\\.[a-z.]+$!i', $_GET['universe'])) $validForm = true;
}

if ($validForm && $mysqlVersionOk && $ogspyVersionOk && $checksumOk) {
	$pluginCopy = false;
	
	if ($pluginMoveable && isset($_GET['copy_plugin'])) {
		if (file_exists('xtense.php')) unlink('xtense.php');
		if (copy('mod/Xtense/xtense.php', 'xtense.php')) $pluginCopy = true;
	}
	
	$db->sql_query('ALTER TABLE `'.TABLE_MOD.'` CHANGE `version` `version` VARCHAR( 15 ) NOT NULL');
	$db->sql_query('ALTER TABLE `'.TABLE_UNIVERSE.'` CHANGE `phalanx` `phalanx` TINYINT( 1 ) NOT NULL DEFAULT "0"');
	
	//---- Creation de la table des Callbacks
	$db->sql_query('DROP TABLE IF EXISTS `'.$table_prefix.'xtense_callbacks`');
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".$table_prefix."xtense_callbacks` (
	  `id` int(3) NOT NULL auto_increment,
	  `mod_id` int(3) NOT NULL,
	  `function` varchar(30) NOT NULL,
	  `type` enum('overview','system','ally_list','buildings','research','fleet','defense','spy','ennemy_spy','rc','rc_cdr', 'msg', 'ally_msg', 'expedition','ranking_player_fleet','ranking_player_points','ranking_player_research','ranking_ally_fleet','ranking_ally_points','ranking_ally_research') NOT NULL,
	  `active` tinyint(1) NOT NULL default '1',
	  PRIMARY KEY (`id`),
	  UNIQUE KEY `mod_id` (`mod_id`,`type`),
	  KEY `active` (`active`)
	)");
	
	$db->sql_query('DROP TABLE IF EXISTS `'.$table_prefix.'xtense_groups`');
	$db->sql_query('CREATE TABLE IF NOT EXISTS `'.$table_prefix.'xtense_groups` (
	  `group_id` int(4) NOT NULL,
	  `system` tinyint(4) NOT NULL,
	  `ranking` tinyint(4) NOT NULL,
	  `empire` tinyint(4) NOT NULL,
	  `messages` tinyint(4) NOT NULL,
	  PRIMARY KEY  (`group_id`)
	)');
	
	//---- Creation configuration Xtense
	$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES
	("xtense_allow_connections", "1"),
	("xtense_log_empire", "0"),
	("xtense_log_ranking", "1"),
	("xtense_log_spy", "1"),
	("xtense_log_system", "1"),
	("xtense_log_ally_list", "1"),
	("xtense_log_messages", "1"),
	("xtense_log_reverse", "0"),
	("xtense_log_ogspy", "'.(isset($_GET['ogspy_log']) ? 1 : 0).'"),
	("xtense_plugin_root", "'.($pluginCopy ? 1 : 0).'"),
	("xtense_strict_admin", "0"),
	("xtense_universe", "'.strtolower($_GET['universe']).'"),
	("xtense_keep_log", "14"),
	("xtense_spy_autodelete", "1")');
	
	$db->sql_query('REPLACE INTO '.TABLE_MOD.' (title, menu, action, root, link, version, active) VALUES ("Xtense", '
		.'"<span onclick=\\"window.open(this.parentNode.href, \'Xtense\', \'width=720, height=500, menubar=no, resizable=yes, '
		.'scrollbars=yes, status=no, toolbar=no\'); return false;\\">Xtense</span>", "xtense", "Xtense", "index.php", "'
		.$version.'", "1")');
	
	list($newPos) = mysql_fetch_row($db->sql_query('SELECT MAX(position)+1 FROM '.TABLE_MOD));
	
	$db->sql_query('UPDATE '.TABLE_MOD.' SET position = '.$newPos.' WHERE action = "xtense"');
	
	// Passage en revue des appels à installer
	$insert = array();
	$callInstall = array('errors' => array(), 'success' => array());
	
	$query = $db->sql_query('SELECT action, root, id, title FROM '.TABLE_MOD.' WHERE active = 1');
	while ($data = mysql_fetch_assoc($query)) {
		if (!file_exists('mod/'.$data['root'].'/_xtense.php')) continue;
		
		try {
			$call = Callback::load($data['root']);
		} catch (Exception $e) {
			$callInstall['errors'][] = $data['title'].' ('.__('callback install load').') : '.$e->getMessage();
		}
		
		foreach ($call->getCallbacks() as $k => $c) {
			try {
				if (empty($c)) continue;
				if (!isset($c['function'], $c['type'])) throw new Exception(__('callback get invalid', $k));
				if (!in_array($c['type'], $callbackTypesNames)) throw new Exception(__('callback invalid type', __($c['type'])));
				if (!isset($c['active'])) $c['active'] = 1;
				if (!method_exists($call, $c['function'])) throw new Exception(__('callback get method', $c['function']));
				
				$insert[] = '('.$data['id'].', "'.$c['function'].'", "'.$c['type'].'", '.$c['active'].')';
				$callInstall['success'][] = $data['title'].' (#'.$k.') : '.__($c['type']);
			} catch (Exception $e) {
				$callInstall['errors'][] = $data['title'].' : '.$e->getMessage();
			}
		}
	}
	
	if (!empty($insert)) {
		$db->sql_query('REPLACE INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES '.implode(', ', $insert));
	}
	
	log_('mod_install', 'Xtense '.$version);
	
	$tpl->assign('install', 1);
	$tpl->assign('callInstall', $callInstall);
}

$tpl->display('install');
exit;

