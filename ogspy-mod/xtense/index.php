<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @version 1.0
 */

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) die('hack');
/*if(defined('IN_SPYOGAME'))
	define('CARTO', 'OGSPY');
else if(defined('IN_UNISPY2'))
	define('CARTO', 'UNISPY');*/
//error_reporting(E_ALL);
extract($_GET,EXTR_PREFIX_ALL,'get');//remplace import_request_variables par extract pour UniSpy
extract($_POST,EXTR_PREFIX_ALL,'post');

global $db,$table_prefix;//pour UniSpy (mais pourquoi pas besoin pour $server_config ???)

//list($mod_name, $mod_version, $ogspy_min_version, $unispy_min_version, $toolbar_min_version) = file('mod/xtense/version.txt');
require_once('mod/xtense/includes/config.php');
require_once('mod/xtense/includes/functions.php');
require_once('mod/xtense/class/tpl.php');
require_once('mod/xtense/class/Check.php');

if(version_compare($server_config['version'], '3.99', '<')) lang_module_page('index');
global $lang_loaded;

error_reporting(E_ALL);
$tpl = new tpl('mod/xtense/tpl/');
$tpl->gzip(false);
$tpl->assign('time', get_microtime());

$config = &$server_config;
$tpl->assignRef('user', $user_data);
$tpl->assignRef('config', $config);

$log_dir = 'mod/xtense/log/';

$page = 'infos';
if (isset($get_page)) {
	// Pages publiques
	if ($get_page == 'about') $page = $get_page;
	
	// Pages admin
	if ($user_data['user_admin'] == 1 || ($user_data['user_coadmin'] == 1 && $config['xtense_strict_admin'] == 0)) {
		if ($get_page == 'config' || $get_page == 'group' || $get_page == 'mods' || $get_page == 'infos' || $get_page == 'log') $page = $get_page;
	}
}

if ($page == 'infos') {
	$plugin_url = 'http://'.$_SERVER['HTTP_HOST'].substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')+1).
	($config['xtense_plugin_root'] == 1 ? '' : 'mod/xtense/') .'xtense.php';
	
	if (isset($get_toolbar)) {
		$content = @file_get_contents('http://svn.ogsteam.fr/xtense/toolbar_info.txt');
		if ($content !== false) {
			$content = explode("\n", $content);
			$toolbar_data = array();
			
			foreach ($content as $line) {
				$n = strpos($line, '=');
				$toolbar_data[trim(substr($line, 0, $n))] = trim(substr($line, $n+1));
			}
		} else $toolbar_data = false;
		
		$tpl->assign('toolbar', 1);
		$tpl->assign('toolbar_data', $toolbar_data);
	}
	$tpl->assign('universe', $config['xtense_universe']);
	$tpl->assign('url', $plugin_url);
}

if ($page == 'config') {
	$checkboxes = array(
		'allow_connections',
		'strict_admin',
		'log_reverse',
		'plugin_root',
		'log_empire',
		'log_system',
		'log_spy',
		'log_ranking',
		'log_ally_list',
		'log_messages',
		'log_ogspy',
		'spy_autodelete'
	);

	if (isset($post_universe, $post_keep_log)) {
		$universe = $post_universe;
		/*if (preg_match('!(uni[0-9]+\\.ogame\\.[A-Z.]+)(\\/|$)!Ui', $universe, $matches)) $universe = 'http://'.strtolower($matches[1]);
		else if (preg_match('!((bt|testing|(beta[0-9]+)|b1)\\.e-univers\\.[A-Z.]+)(\\/|$)!Ui', $universe, $matches)) $universe = 'http://'.strtolower($matches[1]);
		*/
		$universe = Check::universe($universe);
		if($universe===false)
			$universe = 'http://uni0.ogame.fr';
		
		$keep_log = (int)$post_keep_log;
		$keep_log = ($keep_log > 360 ? 360 : $keep_log);
		
		$replace = '';
		foreach ($checkboxes as $name) {
			$config['xtense_'.$name] = (isset($_POST[$name]) ? 1 : 0);
			$replace .= ',("xtense_'.$name.'", "'.$config['xtense_'.$name].'")';
		}
		
		$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_universe", "'.$universe.'"), ("xtense_keep_log", "'.$keep_log.'")'.$replace);
		
		$config['xtense_keep_log'] = $keep_log;
		$config['xtense_universe'] = $universe;
		
		$tpl->assign('update', 1);
	}
	
	if (isset($get_do)) {
		if ($get_do == 'move') {
			if (move_plugin()) {
				$config['xtense_plugin_root'] = 1;
				$db->sql_query('REPLACE INTO '.TABLE_CONFIG.' (config_name, config_value) VALUES ("xtense_plugin_root", "1")');
			}
			$tpl->assign('action', 'move');
		}
		
		if ($get_do == 'repair') {
			$db->sql_query('DELETE FROM '.TABLE_USER_BUILDING.' WHERE planet_id < 1');
			$db->sql_query('DELETE FROM '.TABLE_USER_DEFENCE.' WHERE planet_id < 1');
			$tpl->assign('action', 'repair');
		}
		
		if ($get_do == 'install_callbacks') {
			require_once('includes/check_callbacks.php');
			/*$installed = 0;
			$total = 0;
			$query = $db->sql_query('SELECT action, root, id, title FROM '.TABLE_MOD.' WHERE active = 1');
			while ($data = mysql_fetch_assoc($query)) {
				if (file_exists('mod/'.$data['root'].'/_xtense.php')) {
					require_once('mod/'.$data['root'].'/_xtense.php');
					
					if (isset($xtense_version) && version_compare($xtense_version, MOD_VERSION) <= 1) {
						$fn = $data['action'].'_get_callbacks';
						if (function_exists($fn)) {
							$arr = $fn();
							
							foreach ($arr as $k => $v) {
								if (!isset($v['function'], $v['type'])) continue;
								if (!isset($v['active'])) $v['active'] = 1;
								$insert[] = '('.$data['id'].', "'.$v['function'].'", "'.$v['type'].'", '.$v['active'].')';
							}
						}
					}
				}
			}
			
			if (!empty($insert)) {
				$db->sql_query('INSERT IGNORE INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES '.implode(', ', $insert));
				$total = count($insert);
				$installed = $db->sql_affectedrows();
			}
			*/
			$tpl->assign('installed_callbacks', count($callInstall['success']));
			$tpl->assign('total_callbacks', count($callInstall['success'])+count($callInstall['errors']));
			$tpl->assign('action', 'install_callbacks');
		}
	}
	
	$tpl->assign('config', $config);
}

if ($page == 'group') {
	if (isset($post_groups_id)) {
		$ids = explode('-', (string)$post_groups_id);
		$groups = array();
		
		foreach ($ids as $group_id) {
			$system = (isset($_POST['system_'.$group_id]) ? 1 : 0);
			$ranking = (isset($_POST['ranking_'.$group_id]) ? 1 : 0);
			$empire = (isset($_POST['empire_'.$group_id]) ? 1 : 0);
			$messages = (isset($_POST['messages_'.$group_id]) ? 1 : 0);
			
			$db->sql_query('REPLACE INTO '.TABLE_XTENSE_GROUPS.' (group_id,  system, ranking, empire, messages) VALUES ('.$group_id.', '.$system.', 	'.$ranking.', '.$empire.', '.$messages.')');
		}
		
		$tpl->assign('update', '1');
	}
	
	
	$query = $db->sql_query('SELECT g.group_id, group_name,  system, ranking, empire, messages FROM '.TABLE_GROUP.' g LEFT JOIN '.TABLE_XTENSE_GROUPS.' x ON x.group_id = g.group_id ORDER BY g.group_name ASC');
	$groups = array();
	$groups_id = array();
	
	while ($data = mysql_fetch_assoc($query)) {
		if ($data['system'] == NULL) {
			$data['system'] = $data['spy'] = $data['ranking'] = $data['empire'] = $data['messages'] = 0;
		}
		
		$groups[] = $data;
		$groups_id[] = $data['group_id'];
	}
	
	$tpl->assign('groups_id', $groups_id);
	$tpl->assign('group', $groups);
}

if ($page == 'mods') {
	if (isset($get_toggle, $get_state)) {
		$mod_id = (int)$get_toggle;
		$state = $get_state == 1 ? 1 : 0;
		$db->sql_query('UPDATE '.TABLE_XTENSE_CALLBACKS.' SET active = '.$state.' WHERE id = '.$mod_id);
		
		$tpl->assign('update', 1);
	}
	
	if(version_compare($config['version'], '3.99', '<'))  $query = $db->sql_query('SELECT c.id, c.type, c.active AS callback_active, m.title, m.active, m.version FROM '.TABLE_XTENSE_CALLBACKS.' c LEFT JOIN '.TABLE_MOD.' m ON m.id = c.mod_id ORDER BY m.title ASC');
	else $query = $db->sql_query('SELECT c.id, c.type, c.active AS callback_active, m.active, m.version, m.root FROM '.TABLE_XTENSE_CALLBACKS.' c LEFT JOIN '.TABLE_MOD.' m ON m.id = c.mod_id ORDER BY m.id');
	$callbacks = array();
	$calls_id  = array();
	
	$data_names = array(
		'spy' => 'Rapports d\'espionnage',
		'rc_cdr' => 'Rapports de recyclage',
		'msg' => 'Messages de joueurs',
		'ally_msg' => 'Messages d\'alliances',
		'expedition' => 'Rapports d\'expeditions',
		'overview' => 'Vue générale',
		'ennemy_spy' => 'Espionnages ennemis',
		'system' => 'Systèmes solaires',
		'ally_list' => 'Liste des joueurs d\'alliance',
		'buildings' => 'Bâtiments',
		'research' => 'Laboratoire',
		'fleet' => 'Flotte',
		'fleetSending' => 'Départ de flotte',
		'defense' => 'Défense',
		'rc' => 'Rapports de combat',
		'ranking_player_fleet' => 'Statistiques (flotte) des joueurs',
		'ranking_player_points' => 'Statistiques (points) des joueurs',
		'ranking_player_research' => 'Statistiques (recherches) des joueurs',
		'ranking_ally_fleet' => 'Statistiques (flotte) des alliances',
		'ranking_ally_points' => 'Statistiques (points) des alliances',
		'ranking_ally_research' => 'Statistiques (recherches) des alliances'
	);
	
	while ($data = mysql_fetch_assoc($query)) {
		if(!version_compare($config['version'], '3.99', '<')) $data['title'] = mod_info_title($data['root']);
		$data['type'] = $data_names[$data['type']];
		$callbacks[] = $data;
		$calls_id[] = $data['id'];
	}
	
	$tpl->assign('calls_id', $calls_id);
	$tpl->assign('callbacks', $callbacks);
}

if ($page == 'log') {
	if (!is_writable($log_dir)) $tpl->assign('unwritable', 1);
	
	if (isset($get_purge)) {
		$fp = @opendir($log_dir);
		while (($file = readdir($fp)) !== false) {
			if ($file != '.' && $file != '..' && !is_dir($log_dir.$file) && $file != 'index.html') {
				if (!@unlink($log_dir.$file)) {
					$tpl->assign('purge', 0);
					break;
				}
			}
		}
		@closedir($fp);
		
		$tpl->assign('purge', 1);
	}
	
	$size = 0;
	$nb = 0;
	$availableLogs = array();
	
	$fp = @opendir($log_dir);
	while (($file = @readdir($fp)) !== false) {
		if ($file != '.' && $file != '..' && !is_dir($log_dir.$file) && $file != 'index.html') {
			$size += @filesize($log_dir.$file);
			$availableLogs[] = substr($file, -4);
			$nb++;
		}
	}
	closedir($fp);
	
	$date = date('d/m/Y');
	if (isset($post_date) && preg_match('!^[0-3][0-9]/[01][0-9]/20[0-9]{2}$!Usi', $post_date))
		$date = $post_date;
	
	$exp = explode('/', $date);
	$file = $log_dir.substr($exp[2], 2).$exp[1].$exp[0].'.log';
	
	if (file_exists($file)) {
		if (!is_readable($file)) {
			$tpl->assign('error', 'read');
		} else {
			$content = file($file);
			if (empty($content)) {
				$tpl->assign('no_log', 1);
			} else {
				if ($config['xtense_log_reverse']) $content = array_reverse($content);
				$tpl->assign('content', implode('<br />', $content));
			}
		}
	} else {
		$tpl->assign('no_log', 1);
	}
	
	$tpl->assign('availableLogs', $availableLogs);
	$tpl->assign('log_size_moy', format_size(round($size / ($nb == 0 ? 1 : $nb), 2)));
	$tpl->assign('log_nb', $nb);
	$tpl->assign('log_size', format_size($size));
	$tpl->assign('file', $file);
	$tpl->assign('date', $date);
}


$tpl->assign(Array(
	'page'=> $page,
	'lang' => $lang_loaded,
	'version' => $mod_version,
));
$tpl->display('index');

