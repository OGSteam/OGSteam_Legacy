<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

error_reporting(E_ALL);

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) exit;
/*if(defined('IN_SPYOGAME'))
	define('CARTO', 'OGSpy');
else if(defined('IN_UNISPY2'))
	define('CARTO', 'UniSpy');*/
if (version_compare(phpversion(), '5.1') == -1) {
	header('Content-Type: text/html; charset=utf-8');
	
	echo '<p>FR: Votre hébergement doit disposer de PHP 5.1 pour pouvoir faire fonctionner Xtense. Vous avez actuellement la version "'.phpversion().'"</p>';
	echo '<p>EN: Your server must have PHP 5.1 to run Xtense. You currently have the version "'.phpversion().'"</p>';
	
	exit;
}
global $server_config, $table_prefix;
///list($mod_name, $mod_version, $ogspy_min_version, $unispy_min_version, $toolbar_min_version) = file('mod/xtense/version.txt');
require_once('mod/xtense/includes/config.php');
if(CARTO == 'OGSpy') {
	$universe_regexp = '/^http:\/\/[a-z0-9]+\.ogame\.[a-z.]+$/gi';
	$action_parameter = 'mod_install';
	$mod_parameter = 'directory';
}
else if(CARTO == 'UniSpy') {
	$universe_regexp = '/^http:\/\/(bt|testing|(beta[0-9]+)|b1)\.e-univers\.[a-z.]+$/gi';
	$action_parameter = 'admin_install_mod';
	$mod_parameter = 'root';
}

require_once('mod/xtense/class/tpl.php');
require_once('mod/xtense/class/Md5checksum.php');
require_once('mod/xtense/class/Callback.php');
require_once('mod/xtense/includes/functions.php');

require_once('mod/xtense/class/Check.php');

lang_module_page('install');
global $lang_loaded;

$mysqlVersion = mysql_get_client_info();
$ogspyVersion = $server_config['version'];
$phpVersion = phpversion();
$logWritable = is_writable('mod/xtense/log/');

$mysqlVersionOk = version_compare(str_replace('mysqlnd ', '', $mysqlVersion), '4.1', '>=');
$phpVersionOk = true; // puisque testé plus haut
$ogspyVersionOk = version_compare($ogspyVersion, CARTO_MIN_VERSION, '>=');

$cs = new Md5checksum('mod/xtense/');
$checksumFiles = $cs->check('checksum.md5');
$checksumOk = $checksumFiles === true;

// Verification d'erreurs HTTP pour le plugin (500, 403...)
//$pluginOk = !!@file_get_contents('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/mod/xtense/xtense.php');//TODO trouver une autre solution, plus efficace
$pluginOk = false;

$pluginMoveable = file_exists('xtense.php') ? is_writable('./') && is_writable('xtense.php') : is_writable('./');

$directoryOld = file_exists('mod/xtense/xtense_plugin.php');

$OldXtenseFolder = file_exists('mod/Xtense2/version.txt');
if($OldXtenseFolder) list($useless,$OldXtenseVersion) = file('mod/Xtense2/version.txt');
$request = "select id from ".TABLE_MOD." where root = 'Xtense2'";
$result = $db->sql_query($request);		
list($OldXtenseID) = $db->sql_fetch_row($result);

$tpl = new tpl('mod/xtense/tpl/');

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
	'version' => $mod_version,
	'OldXtenseID' => $OldXtenseID,
	'OldXtenseFolder' => $OldXtenseFolder,
	'OldXtenseVersion' => isset($OldXtenseVersion)?trim($OldXtenseVersion):0,
	'carto_min_version' => CARTO_MIN_VERSION,
	'universe_regexp' => $universe_regexp,
	'action_parameter' => $action_parameter,
	'mod_parameter' => $mod_parameter,
	'lang' => $lang_loaded
));

$validForm = false;
if (isset($_GET['install'], $_GET['universe'])) {
	if(Check::universe($_GET['universe'])) $validForm = true;
}
if ($validForm && $mysqlVersionOk && $ogspyVersionOk && $checksumOk) {
	$pluginCopy = false;
	
	if ($pluginMoveable && isset($_GET['copy_plugin'])) {
		if (file_exists('xtense.php')) unlink('xtense.php');
		if (copy('mod/xtense/xtense.php', 'xtense.php')) $pluginCopy = true;
	}
	
	if($OldXtenseID && isset($_GET['uninstall_old_xtense2'])) {
		// Désinstallation de l'ancienne version beta du module Xtense (l'ancienne version etait Xtense2, alors que maintenant c'est Xtense tout court)
		$request = "select id from ".TABLE_MOD." where root = 'Xtense2'";
		$result = $db->sql_query($request);		
		list($OldModID) = $db->sql_fetch_row($result);
		if (file_exists("mod/Xtense2/uninstall.php")) {
			require_once("mod/Xtense2/uninstall.php");
		}
		$request = "select title from ".TABLE_MOD." where id = ".$OldModID;
		$result = $db->sql_query($request);
		list($title) = $db->sql_fetch_row($result);
		$request = "delete from ".TABLE_MOD." where id = ".$OldModID;
		$db->sql_query($request);
		if(CARTO == 'OGSpy')
			log_("mod_uninstall", $title);
	}

	if($OldXtenseFolder && isset($_GET['delete_old_xtense2'])) {
		// Liste des fichiers de l'ancien modules.
		$files = Array ('mod/Xtense2/.htaccess','mod/Xtense2/callbacks.html','mod/Xtense2/doc.php','mod/Xtense2/index.php','mod/Xtense2/install.php','mod/Xtense2/logo_doc.png','mod/Xtense2/uninstall.php','mod/Xtense2/update.php','mod/Xtense2/version.txt','mod/Xtense2/xtense.php','mod/Xtense2/class/callback.php','mod/Xtense2/class/check.php','mod/Xtense2/class/io.php','mod/Xtense2/class/mysql.php','mod/Xtense2/class/tpl.php','mod/Xtense2/includes/config.php','mod/Xtense2/includes/functions.php','mod/Xtense2/includes/public.php','mod/Xtense2/js/config.js','mod/Xtense2/js/calendar/calendar-en.js','mod/Xtense2/js/calendar/calendar-fr.js','mod/Xtense2/js/calendar/calendar-setup.js','mod/Xtense2/js/calendar/calendar.js','mod/Xtense2/js/calendar/img.gif','mod/Xtense2/js/calendar/menuarrow.gif','mod/Xtense2/js/calendar/menuarrow2.gif','mod/Xtense2/js/calendar/theme.css','mod/Xtense2/tpl/index.tpl','mod/Xtense2/tpl/install.tpl','mod/Xtense2/tpl/style.css','mod/Xtense2/tpl/icons/alert.png','mod/Xtense2/tpl/icons/calendar.png','mod/Xtense2/tpl/icons/config.png','mod/Xtense2/tpl/icons/go.png','mod/Xtense2/tpl/icons/help.png','mod/Xtense2/tpl/icons/infos.png','mod/Xtense2/tpl/icons/log.png','mod/Xtense2/tpl/icons/mods.png','mod/Xtense2/tpl/icons/reset.png','mod/Xtense2/tpl/icons/user.png','mod/Xtense2/tpl/icons/valid.png','mod/Xtense2/tpl/img/menu_left.png','mod/Xtense2/tpl/img/menu_right.png','mod/Xtense2/log/index.html');
		// Liste des anciens dossiers.
		$dirs = Array('mod/Xtense2/tpl/img','mod/Xtense2/tpl/icons','mod/Xtense2/tpl','mod/Xtense2/js/calendar','mod/Xtense2/js','mod/Xtense2/includes','mod/Xtense2/class','mod/Xtense2/log','mod/Xtense2');
		// Suppression des fichiers s'ils existent.
		foreach($files as $file)
			if(file_exists($file))
				unlink($file);
		// Suppression des dossiers s'ils sont vide: Les logs seront conservés.
		foreach($dirs as $dir)
			if(($files = @scandir($dir)) && count($files) <= 2)
				rmdir($dir);

	}
	if(CARTO == 'OGSpy') {
		//????
		$db->sql_query('ALTER TABLE `'.TABLE_MOD.'` CHANGE `version` `version` VARCHAR( 15 ) NOT NULL');
		$db->sql_query('ALTER TABLE `'.TABLE_UNIVERSE.'` CHANGE `phalanx` `phalanx` TINYINT( 1 ) NOT NULL DEFAULT "0"');
	}
	
	//---- Creation de la table des Callbacks
	$db->sql_query('DROP TABLE IF EXISTS `'.$table_prefix.'xtense_callbacks`');
	$db->sql_query("CREATE TABLE IF NOT EXISTS `".$table_prefix."xtense_callbacks` (
	  `id` int(3) NOT NULL auto_increment,
	  `mod_id` int(3) NOT NULL,
	  `function` varchar(30) NOT NULL,
	  `type` enum('overview','system','ally_list','buildings','research','fleet','fleetSending','defense','spy','ennemy_spy','rc','rc_cdr', 'msg', 'ally_msg', 'expedition','ranking_player_fleet','ranking_player_points','ranking_player_research','ranking_ally_fleet','ranking_ally_points','ranking_ally_research') NOT NULL,
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
	
	if(version_compare($server_config['version'], '3.99', '<'))
		$db->sql_query('REPLACE INTO '.TABLE_MOD.' (title, menu, action, root, link, version, active, admin_only) VALUES ("Xtense", '
			.'"<span onclick=\\"window.open(this.parentNode.href, \'Xtense\', \'width=720, height=500, menubar=no, resizable=yes, '
			.'scrollbars=yes, status=no, toolbar=no\'); return false;\\">Xtense</span>", "xtense", "Xtense", "index.php", "'
			.$mod_version.'", "1", " ")');
	else
		$db->sql_query('REPLACE INTO '.TABLE_MOD.' (action, root, link, version, active, admin_only) VALUES ("xtense", "Xtense", "index.php", "'.$mod_version.'", "1", "1")');
	
	list($newPos) = mysql_fetch_row($db->sql_query('SELECT MAX(position)+1 FROM '.TABLE_MOD));
	
	$db->sql_query('UPDATE '.TABLE_MOD.' SET position = '.$newPos.' WHERE action = "xtense"');
	
	// Passage en revue des appels à installer
	require_once('mod/xtense/includes/check_callbacks.php');
	if(CARTO == 'OGSpy')
		$returnLink = '?action=administration&subaction=mod';
	else if(CARTO == 'UniSpy')
		$returnLink = '?action=admin_mods';
	
	$tpl->assign( array('install' => 1,
								'returnLink' => $returnLink));
	if(CARTO == 'OGSpy')
		log_('mod_install', 'Xtense '.$mod_version); 
	else if(CARTO == 'UniSpy')
		log_('mod_install', Array('Xtense ',$mod_version)); 
}
$tpl->display('install');
exit;

