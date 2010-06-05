<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

define('IN_SPYOGAME', true);
define('IN_XTENSE', true);
error_reporting(E_ALL);
date_default_timezone_set(date_default_timezone_get());

if (preg_match('#mod#', getcwd())) chdir('../../');
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', preg_replace('#\/mod\/(.*)\/#', '/', $_SERVER['SCRIPT_FILENAME']));
include("common.php");
list($root, $active) = $db->sql_fetch_row($db->sql_query("SELECT root, active FROM ".TABLE_MOD." WHERE action = 'xtense'"));

define('DEBUG', isset($pub_debug) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1');
if (DEBUG) header('Content-type: text/plain');


require_once("mod/{$root}/includes/config.php");
require_once("mod/{$root}/includes/functions.php");
require_once("mod/{$root}/includes/CallbackHandler.php");
require_once("mod/{$root}/includes/Callback.php");
require_once("mod/{$root}/includes/Io.php");
require_once("mod/{$root}/includes/Check.php"); 

maintenance_action();
set_error_handler('error_handler');
$start_time = get_microtime();

$io = new Io();
$time = time()-60*4;
if ($time > mktime(0,0,0) && $time < mktime(8,0,0)) $timestamp = mktime(0,0,0);
if ($time > mktime(8,0,0) && $time < mktime(16,0,0)) $timestamp = mktime(8,0,0);
if ($time > mktime(16,0,0) && $time < (mktime(0,0,0)+60*60*24)) $timestamp = mktime(16,0,0);

Check::data(isset($pub_toolbar_version, $pub_mod_min_version, $pub_user, $pub_password, $pub_univers));

if (version_compare($pub_toolbar_version, TOOLBAR_MIN_VERSION, '<')) {
	$io->set(array(
		'type' => 'wrong version',
		'target' => 'toolbar',
		'version' => TOOLBAR_MIN_VERSION
	));
	$io->send(0, true);
}

if(version_compare($pub_mod_min_version, PLUGIN_VERSION, '>')) {
	$io->set(array(
		'type' => 'wrong version',
		'target' => 'plugin',
		'version' => PLUGIN_VERSION
	));
	$io->send(0, true);
}

if($active != 1){
	$io->set(array('type' => 'plugin config'));
	$io->send(0, true);
}

if ($server_config['server_active'] == 0) {
	$io->set(array(
		'type' => 'server active',
		'reason' => $server_config['reason']
	));
	$io->send(0, true);
}

if ($server_config['xtense_allow_connections'] == 0) {
	$io->set(array(
		'type' => 'plugin connections',
	));
	$io->send(0, true);
}

if (strtolower($server_config['xtense_universe']) != strtolower($pub_univers)) {
	$io->set(array(
		'type' => 'plugin univers',
	));
	$io->send(0, true);
}

$query = $db->sql_query('SELECT user_id, user_name, user_password, user_active, user_stat_name FROM '.TABLE_USER.' WHERE user_name = "'.quote($pub_user).'"');
if (!$db->sql_numrows($query)) {
	$io->set(array(
		'type' => 'username'
	));
	$io->send(0, true);
} else {
	$user_data = $db->sql_fetch_assoc($query);

	if ($pub_password != $user_data['user_password']) {
		$io->set(array(
			'type' => 'password'
		));
		$io->send(0, true);
	}

	if ($user_data['user_active'] == 0) {
		$io->set(array(
			'type' => 'user active'
		));
		$io->send(0, true);
	}
	
	$user_data['grant'] = array('system' => 0, 'ranking' => 0, 'empire' => 0, 'messages' => 0);
}

// Verification des droits de l'user
$query = $db->sql_query("SELECT system, ranking, empire, messages FROM ".TABLE_USER_GROUP." u LEFT JOIN ".TABLE_GROUP." g ON g.group_id = u.group_id LEFT JOIN ".TABLE_XTENSE_GROUPS." x ON x.group_id = g.group_id WHERE u.user_id = '".$user_data['user_id']."'");
$data = $db->sql_fetch_assoc($query);
foreach ($data as $type => $v)
	$user_data['grant'][$type] = $v;

// Si Xtense demande la verification du serveur, renvoi des droits de l'utilisateur
if (isset($pub_server_check)) {
	$io->set(array(
		'version' => $server_config['version'],
		'servername' => $server_config['servername'],
		'grant' => $user_data['grant']
	));
	$io->send(1, true);
}

Check::data(isset($pub_type));
$call = new CallbackHandler();

//nombre de messages
$io->set(array('new_messages' => 0));

switch ($pub_type){
	case 'overview': //PAGE OVERVIEW
		Check::data(isset($pub_coords, $pub_planet_name, $pub_planet_type, $pub_fields, $pub_temp, $pub_ressources));

		if (!$user_data['grant']['empire']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'empire'
			));
			$io->status(0);
		} else {
			Check::data(Check::coords($pub_coords));
			$planet_name = Check::filterSpecialChars($pub_planet_name);
			Check::data(Check::planet_name($planet_name));
			
			$coords 		= $pub_coords;
			$planet_type 	= ((int)$pub_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
			$fields			= (int)$pub_fields;
			$temp			= (int)$pub_temp;
			$ressources		= $pub_ressources;
			
			
			$home = home_check($planet_type, $coords);
			
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} else {
				if ($home[0] == 'update') {
					$db->sql_query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'", `fields` = '.$fields.', temperature = '.$temp.'  WHERE planet_id = '.$home['id'].' AND user_id = '.$user_data['user_id']);
				} else {
					$db->sql_query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, `fields`, temperature) VALUES ('.$user_data['user_id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'", '.$fields.', '.$pub_temp.')');
				}
				
				$io->set(array(
							'type' => 'home updated',
							'page' => 'overview'
				));
			}
			
			// Appel fonction de callback
			$call->add('overview', array(
						'coords' => explode(':', $coords),
						'planet_type' => $planet_type,
						'planet_name' => $planet_name,
						'fields' => $fields,
						'temp' => $temp,
						'ressources' => $ressources
			));
			
			add_log('overview', array('coords' => $coords, 'planet_name' => $planet_name));
		}
	break;

	case 'buildings': //PAGE BATIMENTS
		Check::data(isset($pub_coords, $pub_planet_name, $pub_planet_type));
		
		if (!$user_data['grant']['empire']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'empire'
			));
			$io->status(0);
		} else {
			Check::data(Check::coords($pub_coords));
			$planet_name = Check::filterSpecialChars($pub_planet_name);
			Check::data(Check::planet_name($planet_name));
			
			$coords 		= $pub_coords;
			$planet_type 	= ((int)$pub_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
			$planet_name 	= utf8_decode($pub_planet_name);
			
			$home = home_check($planet_type, $coords);
			
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} elseif ($home[0] == 'update') {
				$set = '';
				foreach ($database['buildings'] as $code) {
					if(isset(${'pub_'.$code}))
						$set .= ', '.$code.' = '.${'pub_'.$code};//avec la nouvelle version d'Ogame, on n'écrase que si on a vraiment 0
				}
				
				$db->sql_query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'"'.$set.' WHERE planet_id = '.$home['id'].' AND user_id = '.$user_data['user_id']);
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'buildings'
				));
			} else {
				$set = '';
		
				foreach ($database['buildings'] as $code) {
					$set .= ', '.(isset(${'pub_'.$code}) ? (int)${'pub_'.$code} : 0);
				}
				
				$db->sql_query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, '.implode(',', $database['buildings']).') VALUES ('.$user_data['user_id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'"'.$set.')');
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'buildings'
				));
			}
			
			$buildings = array();
			foreach ($database['buildings'] as $code) {
				if (isset(${'pub_'.$code})) {
					$buildings[$code] = (int)${'pub_'.$code};
				}
			}
			
			$call->add('buildings', array(
						'coords' => explode(':', $coords),
						'planet_type' => $planet_type,
						'planet_name' => $planet_name,
						'buildings' => $buildings
			));
			
			add_log('buildings', array('coords' => $coords, 'planet_name' => $planet_name));
		}
	break;

	case 'defense': //PAGE DEFENSE
		Check::data(isset($pub_coords, $pub_planet_name, $pub_planet_type));
		
		if (!$user_data['grant']['empire']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'empire'
			));
			$io->status(0);
		} else {
			Check::data(Check::coords($pub_coords));
			$planet_name = Check::filterSpecialChars($pub_planet_name);
			Check::data(Check::planet_name($planet_name));
			
			$coords 		= $pub_coords;
			$planet_type 	= ((int)$pub_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
			$planet_name 	= utf8_decode($pub_planet_name);
			
			$home = home_check($planet_type, $coords);
			
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} elseif ($home[0] == 'update') {
				$fields = '';
				$values = '';
				foreach ($database['defense'] as $code) {
					if (isset(${'pub_'.$code})) {
						$fields .= ', '.$code;
						$values .= ', '.(int)${'pub_'.$code};
					}
				}
				
				$db->sql_query('REPLACE INTO '.TABLE_USER_DEFENCE.' (user_id, planet_id'.$fields.') VALUES ('.$user_data['user_id'].', '.$home['id'].$values.')');
				$db->sql_query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'" WHERE user_id = '.$user_data['user_id'].' AND planet_id = '.$home['id']);
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'defense'
				));
			} else {
				$fields = '';
				$set = '';
				
				foreach ($database['defense'] as $code) {
					if (isset(${'pub_'.$code})) {
						$fields .= ', '.$code;
						$set .= ', '.(int)${'pub_'.$code};
					}
				}
				
				$db->sql_query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name) VALUES ('.$user_data['user_id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'")');
				$db->sql_query('INSERT INTO '.TABLE_USER_DEFENCE.' (user_id, planet_id'.$fields.') VALUES ('.$user_data['user_id'].', '.$home['id'].$set.')');
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'defense'
				));
			}
			
			$defenses = array();
			foreach ($database['defense'] as $code) {
				if (isset(${'pub_'.$code})) {
					$defenses[$code] = (int)${'pub_'.$code};
				}
			}
			
			$call->add('defense', array(
						'coords' => explode(':', $coords),
						'planet_type' => $planet_type,
						'planet_name' => $planet_name,
						'defense' => $defenses
			));
			
			add_log('defense', array('coords' => $coords, 'planet_name' => $planet_name));
		}
	break;

	case 'researchs': //PAGE RECHERCHE
		if (!$user_data['grant']['empire']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'empire'
			));
			$io->status(0);
		} else {
			if ($db->sql_numrows($db->sql_query('SELECT user_id FROM '.TABLE_USER_TECHNOLOGY.' WHERE user_id = '.$user_data['user_id']))) {
				$set = array();
				foreach ($database['labo'] as $code) {
					if (isset(${'pub_'.$code})) {
						$set[] = $code.' = '.(int)${'pub_'.$code};
					}
				}
				
				if (!empty($set))
					$db->sql_query('UPDATE '.TABLE_USER_TECHNOLOGY.' SET '.implode(', ', $set).' WHERE user_id = '.$user_data['user_id']);
			} else {
				$fields = '';
				$set = '';
				
				foreach ($database['labo'] as $code) {
					if (isset(${'pub_'.$code})) {
						$fields .= ', '.$code;
						$set .= ', "'.(int)${'pub_'.$code}.'"';
					}
				}
				
				if (!empty($fields))
					$db->sql_query('INSERT INTO '.TABLE_USER_TECHNOLOGY.' (user_id'.$fields.') VALUES ('.$user_data['user_id'].$set.')');
			}
			
			$io->set(array(
					'type' => 'home updated',
					'page' => 'labo'
			));
			
			$research = array();
			foreach ($database['labo'] as $code) {
				if (isset(${'pub_'.$code})) {
					$research[$code] = (int)${'pub_'.$code};
				}
			}
			
			$call->add('research', array(
						'research' => $research
			));
			
			add_log('research', array());
		}
	break;

	case 'fleet': //PAGE FLOTTE
		Check::data(isset($pub_coords, $pub_planet_name, $pub_planet_type));
		if (!$user_data['grant']['empire']) {
				$io->set(array(
						'type' => 'grant',
						'access' => 'empire'
				));
				$io->status(0);
		} else {
			Check::data(Check::coords($pub_coords));
			$planet_name = Check::filterSpecialChars($pub_planet_name);
			Check::data(Check::planet_name($planet_name));
			
			$coords 		= $pub_coords;
			$planet_type 	= ((int)$pub_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
			$planet_name 	= utf8_decode($pub_planet_name);
			if (isset($pub_SAT)) $ss = (int)$pub_SAT;
			
			$home = home_check($planet_type, $coords);
					
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} elseif ($home[0] == 'update') {
				$db->sql_query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'" WHERE user_id = '.$user_data['user_id'].' AND planet_id = '.$home['id']);
				
				if (isset($pub_SAT)) $db->sql_query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'", Sat = '.$ss.' WHERE planet_id = '.$home['id'].' AND user_id = '.$user_data['user_id']);
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			} else {
				if (isset($pub_SAT)) $db->sql_query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, Sat) VALUES ('.$user_data['user_id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'", '.$ss.')');
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			}
			
			$fleet = array();
			foreach ($database['fleet'] as $code) {
				if (isset(${'pub_'.$code})) {
					$fleet[$code] = (int)${'pub_'.$code};
				}
			}
			
			$call->add('fleet', array(
					'coords' => explode(':', $coords),
					'planet_type' => $planet_type,
					'planet_name' => $planet_name,
					'fleet' => $fleet
			));
			
			add_log('fleet', array('coords' => $coords, 'planet_name' => $planet_name));
		}
	break;

	case 'fleetSending': //PAGE ENVOIS FLOTTE
		$cb_send = Array();
		if(isset($pub_row)){
			foreach($pub_row as $row){
				list($i,$d) = explode('|',$row);
				$cb_send[$i] = $d;
			}
			$call->add('fleetSending', $cb_send);
		}
		$io->set(array(
			'type' => 'fleetSending'
		));
	break;

	case 'system': //PAGE SYSTEME SOLAIRE
		Check::data(isset($pub_galaxy, $pub_system));
		if (!$user_data['grant']['system']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'system'
			));
			$io->status(0);
		} else {
			
			Check::data(Check::galaxy($pub_galaxy), Check::system($pub_system));
			
			$galaxy 	= (int)$pub_galaxy;
			$system 	= (int)$pub_system;
			$rows 		= (isset($pub_row) ? $pub_row : array());
			$data 		= array();
			$delete		= array();
			$update		= array();
			
			$check = $db->sql_query('SELECT row FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$galaxy.' AND system = '.$system.'');
			while($value = $db->sql_fetch_assoc($check))
				$update[$value['row']] = true;

			// Recupération des données
			for ($i = 1; $i < 16; $i++) {
				if (isset($rows[$i])) {
					$line = $rows[$i];				
					$line['player_name'] = Check::filterSpecialChars($line['player_name']);
					$line['planet_name'] = Check::filterSpecialChars($line['planet_name']);
					$line['ally_tag'] = Check::filterSpecialChars($line['ally_tag']);
					
					if(!Check::data2(isset($line['debris']),
								Check::planet_name($line['planet_name']),
								Check::player_name($line['player_name']),
								Check::player_status($line['status']),
								Check::ally_tag($line['ally_tag'])))
						continue;	
					
					$data[$i] = $line;
				} 
				else {
					$delete[] = $i;
					$data[$i] = array(
							'planet_name' => '',
							'player_name' => '',
							'status' => '',
							'ally_tag' => '',
							'debris' =>  Array('metal' => 0, 'cristal' => 0),
							'moon' => 0,
							'activity' => ''
					);
				}
			}
		
			foreach ($data as $row => $v) {
				if(!isset($update[$row])) 
					$db->sql_query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, name, player, ally, status, last_update, last_update_user_id, moon)
						VALUES ('.$galaxy.', '.$system.', '.$row.', "'.quote($v['planet_name']).'", "'.quote($v['player_name']).'", "'.quote($v['ally_tag']).'", "'.quote($v['status']).'", '.$time.', '.$user_data['user_id'].', '.$v['moon'].')');
				else {
					$db->sql_query(
						'UPDATE '.TABLE_UNIVERSE.' SET name = "'.quote($v['planet_name']).'", player = "'.quote($v['player_name']).'", ally = "'.quote($v['ally_tag']).'", status = "'.quote($v['status']).'", moon = "'.$v['moon'].'", last_update = '.$time.', last_update_user_id = '.$user_data['user_id']
						.' WHERE galaxy = '.$galaxy.' AND system = '.$system.' AND row = '.$row
					);
				}
			}	
			
			if (!empty($delete)) {
				$toDelete = array();
				foreach ($delete as $n) {
					$toDelete[] = $galaxy.':'.$system.':'.$n;
				}
				
				$db->sql_query('UPDATE '.TABLE_PARSEDSPY.' SET active = "0" WHERE coordinates IN ("'.implode('", "', $toDelete).'")');
			}
			
			$db->sql_query('UPDATE '.TABLE_USER.' SET planet_added_ogs = planet_added_ogs + 15 WHERE user_id = '.$user_data['user_id']);
			
			$call->add('system', array(
					'data' => $data,
					'galaxy' => $galaxy,
					'system' => $system
			));
			
			$io->set(array(
					'type' => 'system',
					'galaxy' => $galaxy,
					'system' => $system
			));
			
			update_statistic('planetimport_ogs',15);
			add_log('system', array('coords' => $galaxy.':'.$system));
		}
	break;

	case 'ranking': //PAGE STATS
		Check::data(isset($pub_type1, $pub_type2, $pub_offset, $pub_n, $pub_time));
		
		if (!$user_data['grant']['ranking']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'ranking'
			));
			$io->status(0);
		} else {
			Check::data(
				Check::stats_type1($pub_type1),
				Check::stats_type2($pub_type2),
				Check::stats_offset($pub_offset)
			);
			
			$type1		= $pub_type1;
			$type2 		= $pub_type2;
			$time		= (int)$pub_time;
			$offset 	= (int)$pub_offset;
			$n 			= (array)$pub_n;
			$total		= 0;
			$count		= count($n);
			
			if ($type1 == 'player') {
				switch($type2) {
					case 'points': $table =TABLE_RANK_PLAYER_POINTS;
										break;
					case 'research': $table = TABLE_RANK_PLAYER_RESEARCH;
										break;
					case 'fleet':	$table = TABLE_RANK_PLAYER_FLEET;
										break;
					case 'defense':$table = TABLE_RANK_PLAYER_DEFENSE;
										break;
					case 'buildings':$table = TABLE_RANK_PLAYER_BUILDINGS;
										break;
					default:			$table = TABLE_RANK_PLAYER_POINTS;
										break;
				}
			} else {
				switch($type2) {
					case 'points': $table = TABLE_RANK_ALLY_POINTS;
										break;
					case 'research': $table = TABLE_RANK_ALLY_RESEARCH;
										break;
					case 'fleet':	$table = TABLE_RANK_ALLY_FLEET;
										break;
					case 'defense':$table = TABLE_RANK_ALLY_DEFENSE;
										break;
					case 'buildings':$table = TABLE_RANK_ALLY_BUILDINGS;
										break;
					default:			$table = TABLE_RANK_ALLY_POINTS;
										break;
				}
			}
			
			$query = array();
			
			if ($type1 == 'player') {
				foreach ($n as $i => $val) {//for remplacé par un foreach pour les classements erronés d'E-Univers
					$data = $n[$i];
					$data['player_name'] = Check::filterSpecialChars($data['player_name']);
					$data['ally_tag'] = Check::filterSpecialChars($data['ally_tag']);
					if(!Check::data2(isset($data['points']), Check::player_name($data['player_name']), Check::ally_tag($data['ally_tag'])))
						continue;
					$query[] = '('.$timestamp.', '.$i.', "'.quote($data['player_name']).'", "'.quote($data['ally_tag']).'", '.((int)$data['points']).', '.$user_data['user_id'].')';
					$total ++;
				}
				if (!empty($query))
					$db->sql_query('REPLACE INTO '.$table.' (datadate, rank, player, ally, points, sender_id) VALUES '.implode(',', $query));

			} else {
				$fields = 'datadate, rank, ally, points, sender_id, number_member, points_per_member';
				foreach ($n as $i => $val) {//for remplacé par un foreach pour les classements erronés d'E-Univers
					$data = $n[$i];
					
					$data['ally_tag'] = Check::filterSpecialChars($data['ally_tag']);
					if(!Check::data2(isset($data['points']),
									Check::ally_tag($data['ally_tag'])))
						continue;
					$query[] = '('.$timestamp.', '.$i.', "'.$data['ally_tag'].'", '.((int)$data['points']).', '.$user_data['user_id'].','.((int)$data['members']).', '.((int)$data['mean']).')';
					
					$total ++;
				}
				if (!empty($query)) {
					$db->sql_query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));
				}
			}
			
			$db->sql_query('UPDATE '.TABLE_USER.' SET rank_added_ogs = rank_added_ogs + '.$total.' WHERE user_id = '.$user_data['user_id']);
			
			$call->add('ranking_'.$type1.'_'.$type2, array(
					'data' => $data,
					'offset' => $offset,
					'time' => $time
			));
			
			$io->set(array(
					'type' => 'ranking',
					'type1' => $type1,
					'type2' => $type2,
					'offset' => $offset
			));
			
			update_statistic('rankimport_ogs',100);
			add_log('ranking', array('type1' => $type1, 'type2' => $type2, 'offset' => $offset, 'time' => $time));
		}
	break;

	case 'rc': //PAGE RC
		Check::data(isset($pub_date, $pub_win, $pub_count, $pub_result, $pub_moon, $pub_rounds, $pub_n));
		
		if (!$user_data['grant']['messages']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'messages'
			));
			$io->status(0);
		} else {
			$call->add('rc', array(
					'date' => $pub_date,
					'win' => $pub_win,
					'count' => $pub_count,
					'result' => $pub_result,
					'moon' => $pub_moon,
					'rounds' => $pub_rounds,
					'n' => $pub_n
			));
			
			$id_rcround = Array();
			
						
			$exist = $db->sql_fetch_row($db->sql_query("SELECT id_rc FROM ".TABLE_PARSEDRC." WHERE dateRC = '".$pub_date."'"));
			if(!$exist[0]){
				$db->sql_query("INSERT INTO ".TABLE_PARSEDRC." (
						`dateRC`, `nb_rounds`, `victoire`, `pertes_A`, `pertes_D`, `gain_M`, `gain_C`, `gain_D`, `debris_M`, `debris_C`, `lune`
					) VALUES (
					 '{$pub_date}', '{$pub_count}', '{$pub_win}', '".$pub_result['a_lost']."', '".$pub_result['d_lost']."', '".$pub_result['win_metal']."', '".$pub_result['win_cristal']."', '".$pub_result['win_deut']."', '".$pub_result['deb_metal']."', '".$pub_result['deb_cristal']."', '{$pub_moon}'
					)"
				);
				$id_rc = $db->sql_insertid();
				
				foreach($pub_rounds as $i => $round){
					$db->sql_query("INSERT INTO ".TABLE_PARSEDRCROUND." (
							`id_rc`, `numround`, `attaque_tir`, `attaque_puissance`, `defense_bouclier`, `attaque_bouclier`, `defense_tir`, `defense_puissance`
						) VALUE (
							'{$id_rc}', '{$i}', '".$round['a_nb']."', '".$round['a_shoot']."', '".$round['d_bcl']."', '".$round['a_bcl']."', '".$round['d_nb']."', '".$round['d_shoot']."'
						)"
					);
					$id_rcround[$i] = $db->sql_insertid();
				}
				
				foreach ($pub_n as $i => $n){
					$fields = '';
					$values = '';
					$j = 1;
					
					foreach ($n['content'] as $field => $value){
						$fields .= ", `{$field}`";
						$values .= ", '{$value}'";
					}
					
					$db->sql_query("INSERT INTO ".(($n['type'] == "D") ? TABLE_ROUND_DEFENSE : TABLE_ROUND_ATTACK)." (
							`id_rcround`, `player`, `coordinates`, `Armes`, `Bouclier`, `Protection`".$fields."
						) VALUE (
							'".$id_rcround[$j]."', '".$n['player']."', '".$n['coords']."', '".$n['weapons']['arm']."', '".$n['weapons']['bcl']."', '".$n['weapons']['coq']."'".$values."
						)"
					);
					
					if($n['type'] == "D"){
						if(!isset($update))
							$update = $db->sql_query("UPDATE ".TABLE_PARSEDRC." SET coordinates = '".$n['coords']."' WHERE id_rc = '{$id_rc}'");
						$j++;
					}
				}
			}
			
			$io->set(array(
					'type' => 'rc',
			));
			
			add_log('rc');
		}
	break;

	case 'ally_list': //PAGE ALLIANCE
		Check::data(isset($pub_tag, $pub_n));
		
		if (!$user_data['grant']['ranking']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'ranking'
			));
			$io->status(0);
		} else {
			$tag = Check::filterSpecialChars($pub_tag);
			Check::data(isset($tag));
			Check::data(Check::ally_tag($tag));
			
			$list = array();
			$n = (array)$pub_n;

			foreach ($n as $i => $val) {
				$data = $n[$i];
				
				if(!Check::data2(Check::player_name($data['player']), isset($data['points']), isset($data['rank']), Check::coords($data['coords'])))
					continue;
				
				$list[] = array(
						'pseudo' => Check::filterSpecialChars($data['player']),
						'points' => $data['points'],
						'coords' => explode(':', $data['coords']),
						'rang' => $data['rank']
				);
			}
			
			$call->add('ally_list', array(
					'list' => $list,
					'tag' => $tag
			));
			
			$io->set(array(
					'type' => 'ally_list',
					'tag' => $tag
			));
			
			add_log('ally_list', array(
					'tag' => $tag
			));
		}
	break;

	case 'trader': //PAGE MARCHANT
		$call->add('trader', array());
		$io->set(array(
					'type' => 'trader'
			));
	break;

	case 'messages': //PAGE MESSAGES
		Check::data(isset($pub_data));
		
		if (!$user_data['grant']['messages']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'messages'
			));
			$io->status(0);
		} else {
			$data = array_reverse((array)$pub_data); // Les plus vieux en premier
			
			$logCounts = array('msg' => 0, 'ally_msg' => 0, 'added_spy' => 0, 'added_spy_coords' => array(), 'ignored_spy' => 0, 'ennemy_spy' => 0, 'rc_cdr' => 0, 'expedition' => 0);
			$ally_msg = array();
			$msg = array();
			$spy = array();
			$ennemy_spy = array();
			$rc_cdr = array();
			$expedition = array();
			
			foreach ($data as $line) {
				
				Check::data(isset($line['type'], $line['date']));
				$time = $line['date'];// la barre envoie désormais le timestamp
				
				if ($line['type'] == 'msg') {
					Check::data(
						isset($line['coords'], $line['from'], $line['subject'], $line['message']),
						Check::coords($line['coords']),
						Check::planet_name($line['from'])
					);
					
					$msg[] = array(
							'coords' => explode(':', $line['coords']),
							'from' => $line['from'],
							'subject' => $line['subject'],
							'message' => $line['message'],
							'time' => $time
					);
					$logCounts['msg'] ++;
				}
				if ($line['type'] == 'ally_msg') {
					Check::data(
						isset($line['from'], $line['tag'], $line['message']),
						Check::player_name($line['from'])
					);
					
					$ally_msg[] = array(
							'from' => $line['from'],
							'tag' => $line['tag'],
							'message' => utf8_decode($line['message']),
							'time' => $time
					);
					$logCounts['ally_msg'] ++;
				}
				if ($line['type'] == 'spy') {
					Check::data(
						isset($line['coords'], $line['content'], $line['playerName'], $line['planetName'], $line['moon'], $line['proba'])
					);
					
					Check::data(
						Check::planet_name($line['planetName']),
						Check::player_name($line['playerName']),
						Check::coords($line['coords'])
					);
					
					$proba = (int)$line['proba'];
					$proba = $proba > 100 ? 100 : $proba;
					$spy[] = array(
							'moon' => ($line['moon'] == "true" || $line['moon'] == 1)  ? 1 : 0,
							'proba' => $proba,
							'coords' => explode(':', $line['coords']),
							'content' => $line['content'],
							'time' => $time,
							'player_name' => $line['playerName'],
							'planet_name' => $line['planetName']
					);
				}
				if ($line['type'] == 'ennemy_spy') {
					Check::data(
						isset($line['from'], $line['to'], $line['proba']),
						Check::coords($line['from']),
						Check::coords($line['to'])
					);
					
					$ennemy_spy[] = array(
							'from' => explode(':', $line['from']),
							'to' => explode(':', $line['to']),
							'data' => isset($line['rawdata'])?$line['rawdata']:"",
							'proba' => (int)$line['proba'],
							'time' => $time
					);
					$logCounts['ennemy_spy'] ++;
				}
				if ($line['type'] == 'rc_cdr') {
					Check::data(isset($line['nombre'], $line['coords'], $line['M_recovered'], $line['C_recovered'], $line['M_total'], $line['C_total']));
					Check::data(Check::coords($line['coords']));
					
					$rc_cdr[] = array(
							'nombre' => (int)$line['nombre'],
							'coords' => explode(':', $line['coords']),
							'M_reco' => (int)$line['M_recovered'],
							'C_reco' => (int)$line['C_recovered'],
							'M_total' => (int)$line['M_total'],
							'C_total' => (int)$line['C_total'],
							'time' => $time
					);
					$logCounts['rc_cdr'] ++;
				}
				if ($line['type'] == 'expedition') {
					
					Check::data(
						isset($line['coords'], $line['content']),
						Check::coords($line['coords'], 1)
					);
					
					$expedition[] = array(
							'time' => $time,
							'coords' => explode(':', $line['coords']),
							'content' => utf8_decode($line['content'])
					);
					$logCounts['expedition'] ++;
				}
			}
			
			if (!empty($spy)) {
				$nb = 0;
				
				$spyDB = array();
				foreach ($database as $arr) {
					foreach ($arr as $v) $spyDB[$v] = 1;
				}
				
				$inserted = 0;
				foreach ($spy as $k => $l) {
					$coords = $l['coords'][0].':'.$l['coords'][1].':'.$l['coords'][2];
					$moon = $l['moon'];
					$matches = array();
					$data = array();
					$values = $fields = '';
					
						$fields .= 'planet_name,coordinates,sender_id, proba, dateRE';
						$values .= '"'.trim($l['planet_name']).'", "'.$coords.'", '.$user_data['user_id'].', '.$l['proba'].', '.$l['time'].' ';
					
					foreach($l['content'] as $field => $value){
						$fields .= ', `'.$field.'`';
						$values .= ', '.$value;
					}
					
					$spy[$k]['data'] = $l['content'];
					
					$test = $db->sql_numrows($db->sql_query('SELECT id_spy FROM '.TABLE_PARSEDSPY.' WHERE coordinates = "'.$coords.'" AND dateRE = '.$l['time']));
					if (!$test) {
						$db->sql_query('INSERT INTO '.TABLE_PARSEDSPY.' ( '.$fields.') VALUES ('.$values.')');					
						$logCounts['added_spy'] ++;
						$logCounts['added_spy_coords'][] = $coords;
						$query = $db->sql_query('SELECT last_update'.($moon ? '_moon' : '').' FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
						if ($db->sql_numrows($query)) {
							$assoc = $db->sql_fetch_assoc($query);
							if ($assoc['last_update'.($moon ? '_moon' : '')] < $l['time']) {
								if ($moon)
									$db->sql_query('UPDATE '.TABLE_UNIVERSE.' SET moon = "1", phalanx = '.($l['content']['Pha'] > 0 ? $l['content']['Pha'] : 0).', gate = "'.($l['content']['PoSa'] > 0 ? 1 : 0).'", last_update_moon = '.$time.', last_update_user_id = '.$user_data['user_id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
								else//we do nothing if buildings are not in the report
									$db->sql_query('UPDATE '.TABLE_UNIVERSE.' SET name = "'.$l['planet_name'].'", last_update_user_id = '.$user_data['user_id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
							}
						}
					} else {
						$logCounts['ignored_spy'] ++;
					}
				} // foreach spy
				$inserted = count($spy) - $logCounts['ignored_spy'];
				$db->sql_query('UPDATE '.TABLE_USER.' SET spy_added_ogs = spy_added_ogs + '.$inserted.' WHERE user_id = '.$user_data['user_id']);
				update_statistic('spyimport_ogs',$inserted);

				if ($server_config['xtense_spy_autodelete']) {
					$db->sql_query('DELETE FROM '.TABLE_PARSEDSPY.' WHERE dateRE < '.strtotime('-'.$server_config['max_keepspyreport'].'days'));
				}
			} // empty spy
			
			if (!empty($msg))			$call->add('msg', $msg);
			if (!empty($ally_msg)) 		$call->add('ally_msg', $ally_msg);
			if (!empty($rc_cdr)) 		$call->add('rc_cdr', $rc_cdr);
			if (!empty($spy)) 			$call->add('spy', $spy);
			if (!empty($ennemy_spy)) 	$call->add('ennemy_spy', $ennemy_spy);
			if (!empty($expedition)) 	$call->add('expedition', $expedition);
			
			$io->set(array(
					'type' => (isset($pub_returnAs) && $pub_returnAs == 'spy' ? 'spy' : 'messages')
			));
			
			add_log('messages', $logCounts);
		}
	break;

	default:
		die('hack');
}

$call->apply();

$io->set('execution', str_replace(',', '.', round((get_microtime() - $start_time)*1000, 2)));
$io->send();
$db->sql_close();

?>