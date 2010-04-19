<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

error_reporting(E_ALL);
define('IN_SPYOGAME', 1);
define('IN_XTENSE', 1);
import_request_variables('PG', 'get_');

if (version_compare(phpversion(), '5.1.0') < 0) die('({status:0,type:"php version",version:"'.phpversion().'"})');

date_default_timezone_set(date_default_timezone_get());
if (preg_match('!.mod.Xtense/?$!Ui', getcwd())) chdir('../../');

define('DEBUG', isset($get_debug) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1');
if (DEBUG) header('Content-type: text/plain');

require_once('parameters/id.php');
require_once('mod/Xtense/includes/functions.php');
require_once('mod/Xtense/includes/config.php');
require_once('mod/Xtense/class/Mysql.php');
require_once('mod/Xtense/class/CallbackHandler.php');
require_once('mod/Xtense/class/Callback.php');
require_once('mod/Xtense/class/Io.php');
require_once('mod/Xtense/class/Check.php');

if (PLUGIN_VERSION != '2.0.4139') die('({status:0,type:"wrong version",target:"xtense.php"})');

set_error_handler('error_handler');
$start_time = get_microtime();

/*if ($_SERVER['HTTP_USER_AGENT'] != 'Xtense2') {
	die('Vous ne pouvez pas accéder au module Xtense avec votre navigateur');
}*/

$io = new Io();
$time = time();

Check::data(isset($get_toolbar_version, $get_mod_min_version, $get_user, $get_password, $get_univers));

if (version_compare($get_toolbar_version, TOOLBAR_MIN_VERSION) == -1) {
	$io->set(array(
		'type' => 'wrong version',
		'target' => 'toolbar',
		'version' => TOOLBAR_MIN_VERSION
	));
	$io->send(0, true);
}

if (version_compare($get_mod_min_version, PLUGIN_VERSION) == 1) {
	$io->set(array(
		'type' => 'wrong version',
		'target' => 'plugin',
		'version' => PLUGIN_VERSION
	));
	$io->send(0, true);
}

$sql = new Mysql();
$sql->connect($db_host, $db_user, $db_password, $db_database);
$sql->error_backtrace = true;

$config = array();
$query = $sql->query('SELECT config_name, config_value FROM '.TABLE_CONFIG);
while ($data = mysql_fetch_assoc($query)) {
	$config[$data['config_name']] = $data['config_value'];
}

if ($config['server_active'] == 0) {
	$io->set(array(
		'type' => 'server active',
		'reason' => $config['reason']
	));
	$io->send(0, true);
}

if ($config['xtense2_allow_connections'] == 0) {
	$io->set(array(
		'type' => 'plugin connections',
	));
	$io->send(0, true);
}

if (strtolower($config['xtense_universe']) != strtolower($get_univers)) {
	$io->set(array(
		'type' => 'plugin univers',
	));
	$io->send(0, true);
}

if (!$sql->check('SELECT user_id, user_name, user_password, user_active FROM '.TABLE_USER.' WHERE user_name = "'.quote($get_user).'"')) {
	$io->set(array(
		'type' => 'username'
	));
	$io->send(0, true);
} else {
	list($data) = $sql->assoc();

	if ($get_password != $data['user_password']) {
		$io->set(array(
			'type' => 'password'
		));
		$io->send(0, true);
	}

	if ($data['user_active'] == 0) {
		$io->set(array(
			'type' => 'user active'
		));
		$io->send(0, true);
	}
	
	$user = array();
	$user['pseudo'] = $data['user_name'];
	$user['id'] = $data['user_id'];
	$user['grant'] = array('system' => 0, 'ranking' => 0, 'empire' => 0, 'messages' => 0);
}

// Verification des droits de l'user
$data = $sql->assoc('SELECT system, ranking, empire, messages FROM '.TABLE_USER_GROUP.' u LEFT JOIN '.TABLE_GROUP.' g ON g.group_id = u.group_id LEFT JOIN '.TABLE_XTENSE_GROUPS.' x ON x.group_id = g.group_id WHERE u.user_id = '.$user['id']);
foreach ($data as $line) {
	foreach ($line as $type => $v) {
		$user['grant'][$type] |= (int)$v;
	}
}

// Si Xtense demande la verification du serveur, renvoi des droits de l'utilisateur
if (isset($get_server_check)) {
	$io->set(array(
		'version' => $config['version'],
		'servername' => $config['servername'],
		'grant' => $user['grant']
	));
	$io->send(1, true);
}


Check::data(isset($get_type));
$TYPE = $get_type;

$call = new CallbackHandler();

loadLocales($config['version'] == '4.0' ? $config['language'] : null, 'log');

/**********************[ ESPACE PERSONNEL ]******************************/

//----------------------------------------------------------
//			VUE GENERALE
if ($TYPE == 'overview') {
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type, $get_fields, $get_temp));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords), Check::planet_name($get_planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$planet_name 	= utf8_decode($get_planet_name);
		$fields			= (int)$get_fields;
		$temp			= (int)$get_temp;
		
		$home = home_check($planet_type, $coords);
		
		if ($home[0] == 'full') {
			$io->set(array(
					'type' => 'home full'
			));
			$io->status(0);
		} else {
			if ($home[0] == 'update') {
				$sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'", `fields` = '.$fields.', temperature = '.$temp.'  WHERE planet_id = '.$home['id'].' AND user_id = '.$user['id']);
			} else {
				$sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, `fields`, temperature) VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'", '.$fields.', '.$get_temp.')');
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
					'temp' => $temp
		));
		
		add_log('overview', array('coords' => $coords, 'planet_name' => $planet_name));
	}
}

//----------------------------------------------------------
//			BATIMENTS
if ($TYPE == 'buildings') {
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords), Check::planet_name($get_planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$planet_name 	= utf8_decode($get_planet_name);
		
		$home = home_check($planet_type, $coords);
		
		if ($home[0] == 'full') {
			$io->set(array(
					'type' => 'home full'
			));
			$io->status(0);
		} elseif ($home[0] == 'update') {
			$set = '';
			foreach ($database['buildings'] as $code) {
				$set .= ', '.$code.' = '.(isset($_POST[$code]) ? (int)$_POST[$code] : 0);
			}
			
			$sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'"'.$set.' WHERE planet_id = '.$home['id'].' AND user_id = '.$user['id']);
			
			$io->set(array(
					'type' => 'home updated',
					'page' => 'buildings'
			));
		} else {
			$set = '';
	
			foreach ($database['buildings'] as $code) {
				$set .= ', '.(isset($_POST[$code]) ? (int)$_POST[$code] : 0);
			}
			
			$sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, '.implode(',', $database['buildings']).') VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'"'.$set.')');
			
			$io->set(array(
					'type' => 'home updated',
					'page' => 'buildings'
			));
		}
		
		$buildings = array();
		foreach ($database['buildings'] as $code) {
			if (isset($_POST[$code])) {
				$buildings[$code] = (int)$_POST[$code];
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
}

//----------------------------------------------------------
//			DEFENSE
if ($TYPE == 'defense') {
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords), Check::planet_name($get_planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$planet_name 	= utf8_decode($get_planet_name);
		
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
				if (isset($_POST[$code])) {
					$fields .= ', '.$code;
					$values .= ', '.(int)$_POST[$code];
				}
			}
			
			$sql->query('REPLACE INTO '.TABLE_USER_DEFENCE.' (user_id, planet_id'.$fields.') VALUES ('.$user['id'].', '.$home['id'].$values.')');
			$sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'" WHERE user_id = '.$user['id'].' AND planet_id = '.$home['id']);
			
			$io->set(array(
					'type' => 'home updated',
					'page' => 'defense'
			));
		} else {
			$fields = '';
			$set = '';
			
			foreach ($database['defense'] as $code) {
				if (isset($_POST[$code])) {
					$fields .= ', '.$code;
					$set .= ', '.(int)$_POST[$code];
				}
			}
			
			$sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name) VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'")');
			$sql->query('INSERT INTO '.TABLE_USER_DEFENCE.' (user_id, planet_id'.$fields.') VALUES ('.$user['id'].', '.$home['id'].$set.')');
			
			$io->set(array(
					'type' => 'home updated',
					'page' => 'defense'
			));
		}
		
		$defenses = array();
		foreach ($database['defense'] as $code) {
			if (isset($_POST[$code])) {
				$defenses[$code] = (int)$_POST[$code];
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
}

//----------------------------------------------------------
//			LABO
if ($TYPE == 'researchs') {
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		if ($sql->check('SELECT user_id FROM '.TABLE_USER_TECHNOLOGY.' WHERE user_id = '.$user['id'])) {
			$set = array();
			foreach ($database['labo'] as $code) {
				if (isset($_POST[$code])) {
					$set[] = $code.' = '.(int)$_POST[$code];
				}
			}
			
			if (!empty($set))
				$sql->query('UPDATE '.TABLE_USER_TECHNOLOGY.' SET '.implode(', ', $set).' WHERE user_id = '.$user['id']);
		} else {
			$fields = '';
			$set = '';
			
			foreach ($database['labo'] as $code) {
				if (isset($_POST[$code])) {
					$fields .= ', '.$code;
					$set .= ', "'.(int)$_POST[$code].'"';
				}
			}
			
			if (!empty($fields))
				$sql->query('INSERT INTO '.TABLE_USER_TECHNOLOGY.' (user_id'.$fields.') VALUES ('.$user['id'].$set.')');
		}
		
		$io->set(array(
				'type' => 'home updated',
				'page' => 'labo'
		));
		
		$research = array();
		foreach ($database['labo'] as $code) {
			if (isset($_POST[$code])) {
				$research[$code] = (int)$_POST[$code];
			}
		}
		
		$call->add('research', array(
					'research' => $research
		));
		
		add_log('research', array());
	}
}

//----------------------------------------------------------
//			FLOTTE
if ($TYPE == 'fleet') {
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords), Check::planet_name($get_planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$planet_name 	= utf8_decode($get_planet_name);
		
		// Mise à jour de l'espace personnel seulement si il y a des sat. solaires
		if (isset($get_SAT)) {
			$home = home_check($planet_type, $coords);
			$ss = (int)$get_SAT;
			
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} elseif ($home[0] == 'update') {
				$sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'", Sat = '.$ss.' WHERE planet_id = '.$home['id'].' AND user_id = '.$user['id']);
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			} else {
				$sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, Sat) VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'", '.$ss.')');
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			}
		} else {
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
		}
		
		$fleet = array();
		foreach ($database['fleet'] as $code) {
			if (isset($_POST[$code])) {
				$fleet[$code] = (int)$_POST[$code];
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
}

//----------------------------------------------------------
//			SYSTEME SOLAIRE
if ($TYPE == 'system') {
	Check::data(isset($get_galaxy, $get_system));
	
	if (!$user['grant']['system']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'system'
		));
	} else {
		Check::data(Check::galaxy($get_galaxy), Check::system($get_system));
		
		$galaxy 	= (int)$get_galaxy;
		$system 	= (int)$get_system;
		$rows 		= (isset($get_row) ? $get_row : array());
		$data 		= array();
		$delete		= array();
		
		$update = $sql->check('SELECT row FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$galaxy.' AND system = '.$system.' LIMIT 1');
		
		// Recupération des données
		// "name+'|'+moon+'|'+player+'|'+status+'|'+ally;"
		for ($i = 1; $i < 16; $i++) {
			if (isset($rows[$i])) {
				$line = explode('|', $rows[$i]);
				
				Check::data(isset($line[6]));
				Check::data(
					Check::planet_name($line[0]),
					Check::player_name($line[2]),
					Check::player_status($line[3]),
					Check::ally_tag($line[4])
				);
				
				$data[$i] = array(
						'name' => utf8_decode($line[0]),
						'moon' => ((int)$line[1]) % 2,
						'player' => $line[2],
						'status' => $line[3],
						'ally' => $line[4],
						'debris_M' => (int)$line[5],
						'debris_C' => (int)$line[6]
				);
			} else {
				$delete[] = $i;
				$data[$i] = array(
						'name' => '',
						'moon' => 0,
						'player' => '',
						'status' => '',
						'ally' => '',
						'debris_M' => 0,
						'debris_C' => 0
				);
			}
		}
		
		$replace = array();
		
		if ($update) {
			foreach ($data as $row => $v) {
				if ($v['moon'] == 0) {
					$replace[] = '('.$galaxy.', '.$system.', '.$row.', "'.$v['moon'].'", "'.quote($v['name']).'", "'.quote($v['ally']).'", "'.quote($v['player']).'", "'.quote($v['status']).'", '.$time.', '.$user['id'].')';
				} else {
					$sql->query(
						'UPDATE '.TABLE_UNIVERSE.' SET name = "'.quote($v['name']).'", ally = "'.quote($v['ally']).'", player = "'.quote($v['player']).'", status = "'.quote($v['status']).'", moon = "1", last_update = '.$time.', last_update_user_id = '.$user['id']
						.' WHERE galaxy = '.$galaxy.' AND system = '.$system.' AND row = '.$row
					);
				}
			}
		} else {
			foreach ($data as $row => $v) {
				$replace[] = '('.$galaxy.', '.$system.', '.$row.', "'.$v['moon'].'", "'.quote($v['name']).'", "'.quote($v['ally']).'", "'.quote($v['player']).'", "'.quote($v['status']).'", '.$time.', '.$user['id'].')';
			}
		}
		
		if (!empty($replace))
			$sql->query(
				'REPLACE INTO '.TABLE_UNIVERSE.' (galaxy, system, row, moon, name, ally, player, status, last_update, last_update_user_id) '.
				'VALUES '.implode("\n".', ', $replace)
			);
		
		if (!empty($delete)) {
			$toDelete = array();
			foreach ($delete as $n) {
				$toDelete[] = $galaxy.':'.$system.':'.$n;
			}
			
			$sql->query('UPDATE '.TABLE_PARSEDSPY.' SET active = "0" WHERE coordinates IN ("'.implode('", "', $toDelete).'")');
		}
		
		$sql->query('UPDATE '.TABLE_USER.' SET planet_added_ogs = planet_added_ogs + 15 WHERE user_id = '.$user['id']);
		
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
		
		add_log('system', array('coords' => $galaxy.':'.$system));
	}
}

if ($TYPE == 'ranking') {
	Check::data(isset($get_type1, $get_type2, $get_offset, $get_n, $get_time));
	
	if (!$user['grant']['ranking']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'ranking'
		));
	} else {
		Check::data(
			Check::stats_type1($get_type1),
			Check::stats_type2($get_type2),
			Check::stats_offset($get_offset)
		);
		
		$type1		= $get_type1;
		$type2 		= $get_type2;
		$time		= (int)$get_time;
		$offset 	= (int)$get_offset;
		$n 			= (array)$get_n;
		$total		= 0;
		$count		= count($n);
		
		if ($type1 == 'player') {
			if ($type2 == 'points') $table = TABLE_RANK_PLAYER_POINTS;
			else if ($type2 == 'research') $table = TABLE_RANK_PLAYER_RESEARCH;
			else $table = TABLE_RANK_PLAYER_FLEET;
		} else {
			if ($type2 == 'points') $table = TABLE_RANK_ALLY_POINTS;
			else if ($type2 == 'research') $table = TABLE_RANK_ALLY_RESEARCH;
			else $table = TABLE_RANK_ALLY_FLEET;
		}
		
		// Limite du nombre de classements
		if ($config['max_keeprank'] != 0) {
			if ($config['keeprank_criterion'] == 'day') {
				$sql->query('DELETE FROM '.$table.' WHERE datadate < '.strtotime('-'.$config['max_keeprank'].' days'));
			} else {
				$list = array();
				$query = $sql->query('SELECT DISTINCT datadate FROM '.$table.' ORDER BY datadate DESC');
				while ($row = mysql_fetch_assoc($query)) $list[] = $row['datadate'];
				
				if (!empty($list)) {
					$x = ($list[0] == $time ? 0 : 1);
					
					if (isset($list[$config['max_keeprank']-$x-1])) {
						$sql->query('DELETE FROM '.$table.' WHERE datadate < '.$list[$config['max_keeprank']-$x-1]);
					} elseif ($config['max_keeprank'] == 1) {
						if ($x == 1) {
							$sql->query('DELETE FROM '.$table);
						} else {
							$sql->query('DELETE FROM '.$table.' WHERE datadate < '.$list[0]);
						}
					}
				}
			}
		}
		
		$query = array();
		
		if ($type1 == 'player') {
			for ($i = $offset; $i < ($offset+$count); $i++) {
				$data = explode('|', $n[$i]);
				
				Check::data(isset($data[2]));
				Check::data(
					Check::player_name($data[0]),
					Check::ally_tag($data[1])
				);
				
				$query[] = '('.$time.', '.$i.', "'.quote($data[0]).'", "'.quote($data[1]).'", '.((int)$data[2]).', '.$user['id'].')';
				$data[] = array(
						'player' => $data[0],
						'ally' => $data[1],
						'points' => (int)$data[2]
				);
				$total ++;
			}
			
			if (!empty($query)) {
				$sql->query('REPLACE INTO '.$table.' (datadate, rank, player, ally, points, sender_id) VALUES '.implode(',', $query));
			}
		} else {
			for ($i = $offset; $i < ($offset+$count); $i++) {
				$data = explode('|', $n[$i]);
				
				Check::data(isset($data[3]));
				Check::data(Check::ally_tag($data[0]));
				
				$query[] = '('.$time.', '.$i.', "'.quote($data[0]).'", "'.((int)$data[1]).'", '.((int)$data[2]).', '.((int)$data[3]).', '.$user['id'].')';
				$data[] = array(
						'ally' => $data[0],
						'members' => (int)$data[1],
						'points' => (int)$data[2],
						'moy' => (int)$data[3]
				);
				$total ++;
			}
			
			if (!empty($query)) {
				$sql->query('REPLACE INTO '.$table.' (datadate, rank, ally, number_member, points, points_per_member, sender_id) VALUES '.implode(',', $query));
			}
		}
		
		$sql->query('UPDATE '.TABLE_USER.' SET rank_added_ogs = rank_added_ogs + '.$total.' WHERE user_id = '.$user['id']);
		
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
		
		add_log('ranking', array('type1' => $type1, 'type2' => $type2, 'offset' => $offset, 'time' => $time));
	}
}

if ($TYPE == 'rc') {
	Check::data(isset($get_content));
	
	if (!$user['grant']['messages']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'messages'
		));
	} else {
		$call->add('rc', array(
				'content' => utf8_decode($get_content)
		));
		
		$io->set(array(
				'type' => 'rc',
		));
		
		add_log('rc');
	}
}

if ($TYPE == 'ally_list') {
	Check::data(isset($get_tag, $get_n));
	
	if (!$user['grant']['ranking']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'ranking'
		));
	} else {
		Check::data(Check::ally_tag($get_tag));
		
		$tag = $get_tag;
		$list = array();
		$n = (array)$get_n;
		
		foreach ($n as $value) {
			$data = explode('|', $value);
			
			Check::data(isset($data[3]));
			Check::data(
				Check::player_name($data[0]),
				Check::coords($data[2])
			);
			
			$list[] = array(
					'pseudo' => $data[0],
					'points' => (int)$data[1],
					'coords' => explode(':', $data[2]),
					'rang' => $data[3]
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
}


if ($TYPE == 'messages') {
	Check::data(isset($get_data));
	
	if (!$user['grant']['messages']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'messages'
		));
	} else {
		$data = array_reverse((array)$get_data); // Les plus vieux en premier
		
		$logCounts = array('msg' => 0, 'ally_msg' => 0, 'added_spy' => 0, 'added_spy_coords' => array(), 'ignored_spy' => 0, 'ennemy_spy' => 0, 'rc_cdr' => 0, 'expedition' => 0);
		$ally_msg = array();
		$msg = array();
		$spy = array();
		$ennemy_spy = array();
		$rc_cdr = array();
		$expedition = array();
		
		foreach ($data as $line) {
			Check::data(isset($line['type'], $line['date']));
			Check::data(Check::date($line['date']));
			$time = parseOgameDate($line['date']);
			
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
				
				$spy[] = array(
						'moon' => $line['moon'] == 1 ? 1 : 0,
						'proba' => $proba > 100 ? 100 : $proba,
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
			
			//if (isset($get_spy_debug))
			//	dump($spy);
			
			$inserted = 0;
			foreach ($spy as $k => $l) {
				$coords = $l['coords'][0].':'.$l['coords'][1].':'.$l['coords'][2];
				$moon = $l['moon'];
				$matches = array();
				$data = array();
				
				preg_match_all('!([A-Z]+):(-?[0-9]+)(:?:|$)!Usi', $l['content'], $matches);
				
				$values = $fields = '';
				for ($i = 0, $len = count($matches[0]); $i < $len; $i++) {
					$name = $matches[1][$i];
					$v = (int)$matches[2][$i];
					$v = ($v < -1 ? -1 : $v);
					
					if (!isset($spyDB[$name])) continue;
					
					$data[$name] = $v;
					$values .= ', '.$v;
					$fields .= ', '.$name;
				}
				
				$spy[$k]['data'] = $data;
				
				if (!$sql->check('SELECT id_spy FROM '.TABLE_PARSEDSPY.' WHERE coordinates = "'.$coords.'" AND dateRE = '.$l['time'])) {
					$sql->query('INSERT INTO '.TABLE_PARSEDSPY.' (planet_name, coordinates '.$fields.') VALUES ("'.$l['planet_name'].'", "'.$coords.'" '.$values.')');
					$logCounts['added_spy'] ++;
					$logCounts['added_spy_coords'][] = $coords;
					
					if ($sql->check('SELECT last_update'.($moon ? '_moon' : '').' FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2])) {
						$assoc = $sql->assoc();
						if ($assoc[0]['last_update'.($moon ? '_moon' : '')] < $l['time']) {
							if ($moon) $sql->query('UPDATE '.TABLE_UNIVERSE.' SET moon = "1", phalanx = '.($data['Pha'] > 0 ? $data['Pha'] : 0).', gate = "'.($data['PoSa'] > 0 ? 1 : 0).'", player = "'.$l['player_name'].'", last_update_moon = '.time().', last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
							else $sql->query('UPDATE '.TABLE_UNIVERSE.' SET player = "'.$l['player_name'].'", name = "'.$l['planet_name'].'", last_update_moon = '.time().', last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
						}
					} else {
						if ($moon) $sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, moon, phalanx, gate, player, name, status, last_update_moon, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "1", '.($data['Pha'] > 0 ? $data['Pha'] : 0).', "'.($data['PoSa'] > 0 ? 1 : 0).'", "'.$l['player_name'].'", "", "", '.time().', '.$user['id'].')');
						else $sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, player, name, status, last_update, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "'.$l['player_name'].'", "'.$l['planet_name'].'", "", '.time().', '.$user['id'].')');
					}
				} else {
					$logCounts['ignored_spy'] ++;
				}
			} // foreach spy
			
			$sql->query('UPDATE '.TABLE_USER.' SET spy_added_ogs = spy_added_ogs + '.$inserted.' WHERE user_id = '.$user['id']);
			
			if ($config['xtense_spy_autodelete']) {
				$sql->query('DELETE FROM '.TABLE_PARSEDSPY.' WHERE dateRE < '.strtotime('-'.$config['max_keepspyreport'].'days'));
			}
		} // empty spy
		
		if (!empty($msg))			$call->add('msg', $msg);
		if (!empty($ally_msg)) 		$call->add('ally_msg', $ally_msg);
		if (!empty($rc_cdr)) 		$call->add('rc_cdr', $rc_cdr);
		if (!empty($spy)) 			$call->add('spy', $spy);
		if (!empty($ennemy_spy)) 	$call->add('ennemy_spy', $ennemy_spy);
		if (!empty($expedition)) 	$call->add('expedition', $expedition);
		
		$io->set(array(
				'type' => (isset($get_returnAs) && $get_returnAs == 'spy' ? 'spy' : 'messages')
		));
		
		add_log('messages', $logCounts);
	}
}

$call->apply();

$io->set('execution', round((get_microtime() - $start_time)*1000, 2));
$io->send();

