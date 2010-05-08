<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

error_reporting(E_ALL);
define('IN_SPYOGAME', 1);
define('IN_UNISPY2', true);
define('IN_XTENSE', 1);

import_request_variables('PG', 'get_');

if (version_compare(phpversion(), '5.1.0') < 0) die('({status:0,type:"php version",version:"'.phpversion().'"})');

date_default_timezone_set(date_default_timezone_get());
if (preg_match('!.mod.Xtense/?$!Ui', getcwd())) chdir('../../');

define('DEBUG', isset($get_debug) && $_SERVER['REMOTE_ADDR'] == '127.0.0.1');
if (DEBUG) header('Content-type: text/plain');
global $server_config;

require_once('parameters/id.php');
require_once('mod/Xtense/includes/config.php');
require_once('mod/Xtense/includes/functions.php');
require_once('mod/Xtense/class/Mysql.php');
require_once('mod/Xtense/class/CallbackHandler.php');
require_once('mod/Xtense/class/Callback.php');
require_once('mod/Xtense/class/Io.php');
require_once('mod/Xtense/class/Check.php'); 
if(CARTO == "OGSpy") require_once('mod/Xtense/includes/ogame_id.php');

set_error_handler('error_handler');
$start_time = get_microtime();

/*if ($_SERVER['HTTP_USER_AGENT'] != 'Xtense2') {
	die('Vous ne pouvez pas accéder au module Xtense avec votre navigateur');
}*/

$io = new Io();
$time = time()-60*4;
if ($time > mktime(0,0,0) && $time < mktime(8,0,0)) $timestamp = mktime(0,0,0);
if ($time > mktime(8,0,0) && $time < mktime(16,0,0)) $timestamp = mktime(8,0,0);
if ($time > mktime(16,0,0) && $time < (mktime(0,0,0)+60*60*24)) $timestamp = mktime(16,0,0);

Check::data(isset($get_toolbar_version, $get_mod_min_version, $get_user, $get_password, $get_univers));

if (version_compare($get_toolbar_version, TOOLBAR_MIN_VERSION, '<')) {
	$io->set(array(
		'type' => 'wrong version',
		'target' => 'toolbar',
		'version' => TOOLBAR_MIN_VERSION
	));
	$io->send(0, true);
}

//if (version_compare($get_mod_min_version, PLUGIN_VERSION, '>')) {
if(strcmp($get_mod_min_version,PLUGIN_VERSION) > 0) {//utilisation de strcmp pour être compatible avec le mod autoupdate
	//echo $get_mod_min_version.' '.PLUGIN_VERSION;
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

// Module installé et actif ?
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='xtense'";
$data = mysql_fetch_assoc($sql->query($query));
if(!$sql->num($query)||$data['active']!=1){
	$io->set(array('type' => 'plugin config'));
	$io->send(0, true);
}

$config = array();
$query = $sql->query('SELECT config_name, config_value FROM '.TABLE_CONFIG);
while ($data = mysql_fetch_assoc($query)) {
	$config[$data['config_name']] = $data['config_value'];
}

//corrections pour compatibilité unispy/ogspy
if(CARTO == 'UniSpy') {
	$config['num_of_galaxies'] = $config['nb_galaxy'];
	$config['num_of_systems'] = $config['nb_system'];
}

if ($config['server_active'] == 0) {
	$io->set(array(
		'type' => 'server active',
		'reason' => $config['reason']
	));
	$io->send(0, true);
}

if ($config['xtense_allow_connections'] == 0) {
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

if(version_compare($config['version'], '3.99', '<')) $query = 'SELECT user_id, user_name, user_password, user_active, user_stat_name FROM '.TABLE_USER.' WHERE user_name = "'.quote($get_user).'"';
else $query = 'SELECT user_id, user_name, user_password, user_active, user_stat_name, ally_stat_name FROM '.TABLE_USER.' WHERE user_name = "'.quote($get_user).'"';

if (!$sql->check($query)) {
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
	$user['user_stat_name'] = $data['user_stat_name'];
	if(!version_compare($config['version'], '3.99', '<')) $user['ally_stat_name'] = $data['ally_stat_name'];
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

if(CARTO == 'UniSpy')
	$config['servername'] = $config['server_name'];
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

loadLocales(version_compare($config['version'], '3.6') > 0? $config['language'] : null, 'log');

if(CARTO == 'OGSpy' && version_compare($config['version'], '3.6', '>')) {
	$query = $sql->query('SELECT COUNT(id) FROM '.TABLE_MESSAGES.' WHERE destinataire='.$user['id'].' AND vu=\'0\' AND (efface=\'0\' OR efface=\'2\')');//
	$c = mysql_fetch_row($query);
	$io->set(array('new_messages' => $c[0]));
}
/**********************[ ESPACE PERSONNEL ]******************************/

//----------------------------------------------------------
//			VUE GENERALE
if ($TYPE == 'overview' && CARTO == 'OGSpy') {//pas actif sur Unispy pour l'instant
	// Retro compatibilité
	if(!isset($get_ressources)) $get_ressources = "0";
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type, $get_fields, $get_temp, $get_ressources));

	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords));
		$planet_name = Check::filterSpecialChars($get_planet_name);
		Check::data(Check::planet_name($planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$fields			= (int)$get_fields;
		$temp			= (int)$get_temp;
		$ressources		= $get_ressources;
		
		
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
					'temp' => $temp,
					'ressources' => $ressources
		));
		
		add_log('overview', array('coords' => $coords, 'planet_name' => $planet_name));
	}
}

//----------------------------------------------------------
//			BATIMENTS
if ($TYPE == 'buildings' && CARTO == 'OGSpy') {//pas actif sur Unispy pour l'instant
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords));
		$planet_name = Check::filterSpecialChars($get_planet_name);
		Check::data(Check::planet_name($planet_name));
		
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
				if(isset($_POST[$code]))
					$set .= ', '.$code.' = '.$_POST[$code];//avec la nouvelle version d'Ogame, on n'écrase que si on a vraiment 0
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
if ($TYPE == 'defense' && CARTO == 'OGSpy') {//pas actif sur Unispy pour l'instant
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	
	if (!$user['grant']['empire']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'empire'
		));
		$io->status(0);
	} else {
		Check::data(Check::coords($get_coords));
		$planet_name = Check::filterSpecialChars($get_planet_name);
		Check::data(Check::planet_name($planet_name));
		
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
if ($TYPE == 'researchs' && CARTO == 'OGSpy') {//pas actif sur Unispy pour l'instant
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
if ($TYPE == 'fleet' && CARTO == 'OGSpy') {//pas actif sur Unispy pour l'instant
	Check::data(isset($get_coords, $get_planet_name, $get_planet_type));
	if (!$user['grant']['empire']) {
			$io->set(array(
					'type' => 'grant',
					'access' => 'empire'
			));
			$io->status(0);
	} else {
		Check::data(Check::coords($get_coords));
		$planet_name = Check::filterSpecialChars($get_planet_name);
		Check::data(Check::planet_name($planet_name));
		
		$coords 		= $get_coords;
		$planet_type 	= ((int)$get_planet_type == TYPE_PLANET ? TYPE_PLANET : TYPE_MOON);
		$planet_name 	= utf8_decode($get_planet_name);
		if (isset($get_SAT)) $ss = (int)$get_SAT;
		
		$home = home_check($planet_type, $coords);
		
		if(version_compare($config['version'], '3.6', '>') ) {//OGSpy 4 et plus			
			if ($home[0] == 'full') {
				$io->set(array(
						'type' => 'home full'
				));
				$io->status(0);
			} elseif ($home[0] == 'update') {
				$fields = '';
				$values = '';
				foreach ($database['fleet'] as $code) {
					if (isset($_POST[$code]) && $code != 'SAT') {
						$fields .= ', '.$code;
						$values .= ', '.(int)$_POST[$code];
					}
				}
				
				$sql->query('REPLACE INTO '.TABLE_USER_FLEET.' (user_id, planet_id'.$fields.') VALUES ('.$user['id'].', '.$home['id'].$values.')');
				$sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'" WHERE user_id = '.$user['id'].' AND planet_id = '.$home['id']);
				
				if (isset($get_SAT)) $sql->query('UPDATE '.TABLE_USER_BUILDING.' SET planet_name = "'.$planet_name.'", Sat = '.$ss.' WHERE planet_id = '.$home['id'].' AND user_id = '.$user['id']);
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			} else {
				$fields = '';
				$set = '';
				
				foreach ($database['fleet'] as $code) {
					if (isset($_POST[$code]) && $code != 'SAT') {
						$fields .= ', '.$code;
						$set .= ', '.(int)$_POST[$code];
					}
				}
				
				$sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name) VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'")');
				$sql->query('INSERT INTO '.TABLE_USER_FLEET.' (user_id, planet_id'.$fields.') VALUES ('.$user['id'].', '.$home['id'].$set.')');
				
				if (isset($get_SAT)) $sql->query('INSERT INTO '.TABLE_USER_BUILDING.' (user_id, planet_id, coordinates, planet_name, Sat) VALUES ('.$user['id'].', '.$home['id'].', "'.$coords.'", "'.$planet_name.'", '.$ss.')');
				
				$io->set(array(
						'type' => 'home updated',
						'page' => 'fleet'
				));
			}
		} else {
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

if ($TYPE == 'fleetSending') {
	$cb_send = Array();
	if(isset($get_row)){
		foreach($get_row as $row){
			list($i,$d) = explode('|',$row);
			$cb_send[$i] = $d;
		}
		$call->add('fleetSending', $cb_send);
	}
	$io->set(array(
		'type' => 'fleetSending'
	));}

//----------------------------------------------------------
//			SYSTEME SOLAIRE
if ($TYPE == 'system') {
	Check::data(isset($get_galaxy, $get_system));
	if (!$user['grant']['system']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'system'
		));
		$io->status(0);
	} else {
		
		Check::data(Check::galaxy($get_galaxy), Check::system($get_system));
		
		$galaxy 	= (int)$get_galaxy;
		$system 	= (int)$get_system;
		$rows 		= (isset($get_row) ? $get_row : array());
		$data 		= array();
		$delete		= array();
		$update		= array();
		
		$check = $sql->assoc('SELECT row FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$galaxy.' AND system = '.$system.'');
		foreach ($check as $key => $value)
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
						'player_id' => '',
						'ally_id' => '',
						'planet_name' => '',
						'player_name' => '',
						'status' => '',
						'ally_tag' => '',
				);
				if(CARTO == 'OGSpy') {
					$data[$i]['debris'] = Array('metal' => 0, 'cristal' => 0);
					$data[$i]['moon'] = 0;
					$data[$i]['activity'] = '';
					}
				else if(CARTO == 'UniSpy') {
					$data[$i]['debris'] = Array('titanium' => 0, 'carbon' => 0, 'tritium' => 0);
					}
			}
		}
	
		foreach ($data as $row => $v) {
				if(CARTO == 'OGSpy') {
					if(version_compare($config['version'], '3.99', '<'))
					{
						if(!$update[$row])
							$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, name, player, ally, status, last_update, last_update_user_id, moon)
								VALUES ('.$galaxy.', '.$system.', '.$row.', "'.quote($v['planet_name']).'", "'.quote($v['player_name']).'", "'.quote($v['ally_tag']).'", "'.quote($v['status']).'", '.$time.', '.$user['id'].', '.$v['moon'].')');
						else {
							$sql->query(
								'UPDATE '.TABLE_UNIVERSE.' SET name = "'.quote($v['planet_name']).'", ally = "'.quote($v['ally_tag']).'", player = "'.quote($v['player_name']).'", status = "'.quote($v['status']).'", moon = "'.$v['moon'].'", last_update = '.$time.', last_update_user_id = '.$user['id']
								.' WHERE galaxy = '.$galaxy.' AND system = '.$system.' AND row = '.$row
							);
						}
					}
					else{
						if(!$update[$row]) 
							$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, name, id_player, status, last_update, last_update_user_id, moon)
								VALUES ('.$galaxy.', '.$system.', '.$row.', "'.quote($v['planet_name']).'", "'.quote($v['player_id']).'", "'.quote($v['status']).'", '.$time.', '.$user['id'].', '.$v['moon'].')');
						else {
							$sql->query(
								'UPDATE '.TABLE_UNIVERSE.' SET name = "'.quote($v['planet_name']).'", id_player = "'.quote($v['player_id']).'", status = "'.quote($v['status']).'", moon = "'.$v['moon'].'", last_update = '.$time.', last_update_user_id = '.$user['id']
								.' WHERE galaxy = '.$galaxy.' AND system = '.$system.' AND row = '.$row
							);
						}
						if($v['player_id'] != 0)
						{	
							$id_ally_ = ally_update($v);
							player_update($v, $id_ally_);
						}
					}
				}
				if(CARTO == 'UniSpy')
					$sql->query("REPLACE INTO ".TABLE_UNIVERSE." (galaxy, system, row, name, player, ally, status, last_update, last_update_user_id)
								VALUES ('".$galaxy."', '".$system."', '".$row."', '".quote($v['planet_name'])."', '".quote($v['player_name'])."', '".quote($v['ally_tag'])."', '".quote($v['status'])."', '".$time."', '".$user['id']."')");
		}	
		if(CARTO == 'OGSpy') {//pas de désactivation de RE dans Unispy
			if (!empty($delete)) {
				$toDelete = array();
				foreach ($delete as $n) {
					$toDelete[] = $galaxy.':'.$system.':'.$n;
				}
				
				$sql->query('UPDATE '.TABLE_PARSEDSPY.' SET active = "0" WHERE coordinates IN ("'.implode('", "', $toDelete).'")');
			}
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
		if(CARTO == 'OGSpy')
			update_statistic('planetimport_ogs',15);
		else if(CARTO == 'UniSpy')
			update_statistic('external_import_planets',15);
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
		$io->status(0);
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
		
		// Limite du nombre de classements
		if(CARTO == 'OGSpy') {//TODO voir pour UniSpy
			if(version_compare($config['version'], '3.99', '>'))
			{
				// à faire v4
			}
			else
			{
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
				if(version_compare($config['version'], '3.99', '>'))
				{
					$id_ally_ = ally_update($data);
					player_update($data, $id_ally_);
					$query[] = '('.$timestamp.', '.$i.', "'.$data['player_id'].'", '.((int)$data['points']).', '.$user['id'].')';
				}
				else
				{
					$query[] = '('.$timestamp.', '.$i.', "'.quote($data['player_name']).'", "'.quote($data['ally_tag']).'", '.((int)$data['points']).', '.$user['id'].')';
				}
				$total ++;
			}
			if (!empty($query)) {
				if(version_compare($config['version'], '3.99', '>'))
					$sql->query('REPLACE INTO '.$table.' (datadate, rank, id_player, points, sender_id) VALUES '.implode(',', $query));
				else
					$sql->query('REPLACE INTO '.$table.' (datadate, rank, player, ally, points, sender_id) VALUES '.implode(',', $query));
			}

		} else {
			if(version_compare($config['version'], '3.99', '>'))
				$fields = 'datadate, rank, id_ally, points, sender_id';
			else
				$fields = 'datadate, rank, ally, points, sender_id';
			if(CARTO == 'OGSpy') {
				$fields .= ', number_member, points_per_member';
			}
			foreach ($n as $i => $val) {//for remplacé par un foreach pour les classements erronés d'E-Univers
				$data = $n[$i];
				
				$data['ally_tag'] = Check::filterSpecialChars($data['ally_tag']);
				if(!Check::data2(isset($data['points']),
								Check::ally_tag($data['ally_tag'])))
					continue;
				if(version_compare($config['version'], '3.99', '>'))
					$values = '('.$timestamp.', '.$i.', "'.$data['ally_id'].'", '.((int)$data['points']).', '.$user['id'];
				else
					$values = '('.$timestamp.', '.$i.', "'.quote($data['ally_tag']).'", '.((int)$data['points']).', '.$user['id'];
				if(CARTO == 'OGSpy') {
					$values .= ','.((int)$data['members']).', '.((int)$data['mean']);
				}
				$values .= ')';
				$query[] = $values;
				
				$total ++;
				if(version_compare($config['version'], '3.99', '>'))
				{
					ally_update($data);
				}
			}
			if (!empty($query)) {
				$sql->query('REPLACE INTO '.$table.' ('.$fields.') VALUES '.implode(',', $query));
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
		if(CARTO == 'OGSpy')
			update_statistic('rankimport_ogs',100);
		else if(CARTO == 'UniSpy')
			update_statistic('external_import_ranks',100);
		
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
		$io->status(0);
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
		$io->status(0);
	} else {
		$tag = Check::filterSpecialChars($get_tag);
		Check::data(isset($tag));
		Check::data(Check::ally_tag($tag));
		
		$list = array();
		$n = (array)$get_n;

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
}
//----------------------------------------------------------
//			MARCHANT
if ($TYPE == 'trader' && CARTO == 'OGSpy') {//ogame uniquement
	$call->add('trader', array());
	$io->set(array(
				'type' => 'trader'
		));
}

if ($TYPE == 'messages') {
	Check::data(isset($get_data));
	
	if (!$user['grant']['messages']) {
		$io->set(array(
				'type' => 'grant',
				'access' => 'messages'
		));
		$io->status(0);
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
				
				if(CARTO == 'OGSpy') {
					$fields .= 'planet_name,coordinates,sender_id, proba, dateRE';
					$values .= '"'.trim($l['planet_name']).'", "'.$coords.'", '.$user['id'].', '.$l['proba'].', '.$l['time'].' ';
				}
				if(CARTO == 'UniSpy') {
					$fields .= 'sender_id, dateRE';
					$values .= $user['id'].', '.$l['time'].' ';
				}
				
				foreach ($l['content'] as $field => $value){
					$fields .= ', `'.$field.'`';
					$values .= ', '.$value;
				}
				
				if(version_compare($config['version'], '3.6', '>') || CARTO == 'UniSpy') {//si on est en version 4 ou sur Unispy, on sépare les coordonnées
					$fields .= ', galaxy, system, row';
					$values .= ', '.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2];
				}
				
				$spy[$k]['data'] = $data;
				if(CARTO == 'OGSpy')
					$test = $sql->check('SELECT id_spy FROM '.TABLE_PARSEDSPY.' WHERE coordinates = "'.$coords.'" AND dateRE = '.$l['time']);
				else if(CARTO == 'UniSpy')
					$test = $sql->check('SELECT id_spy FROM '.TABLE_PARSEDSPY.' WHERE galaxy = "'.$l['coords'][0].'" AND system = "'.$l['coords'][1].'" AND row = "'.$l['coords'][2].'" AND dateRE = '.$l['time']);
				if (!$test) {
					$sql->query('INSERT INTO '.TABLE_PARSEDSPY.' ( '.$fields.') VALUES ('.$values.')');					
					$logCounts['added_spy'] ++;
					$logCounts['added_spy_coords'][] = $coords;
					if(CARTO == 'OGSpy') {//pas de lune sur E-Univers
						if ($sql->check('SELECT last_update'.($moon ? '_moon' : '').' FROM '.TABLE_UNIVERSE.' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2])) {
							$assoc = $sql->assoc();
							if ($assoc[0]['last_update'.($moon ? '_moon' : '')] < $l['time']) {
								if(version_compare($config['version'], '3.99', '<')){
									if ($moon)
										$sql->query('UPDATE '.TABLE_UNIVERSE.' SET moon = "1", phalanx = '.($data['Pha'] > 0 ? $data['Pha'] : 0).', gate = "'.($data['PoSa'] > 0 ? 1 : 0).'",'.' player = "'.$l['player_name'].'", last_update_moon = '.$time.', last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
									else//we do nothing if buildings are not in the report
										$sql->query('UPDATE '.TABLE_UNIVERSE.' SET player = "'.$l['player_name'].'", name = "'.$l['planet_name'].'", last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
								} else {
									if ($moon)
										$sql->query('UPDATE '.TABLE_UNIVERSE.' SET moon = "1", phalanx = '.($data['Pha'] > 0 ? $data['Pha'] : 0).', gate = "'.($data['PoSa'] > 0 ? 1 : 0).'", last_update_moon = '.$time.', last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
									else//we do nothing if buildings are not in the report
										$sql->query('UPDATE '.TABLE_UNIVERSE.' SET name = "'.$l['planet_name'].'", last_update_user_id = '.$user['id'].' WHERE galaxy = '.$l['coords'][0].' AND system = '.$l['coords'][1].' AND row = '.$l['coords'][2]);
								}
							}
						} 
						else
						{
							if(version_compare($config['version'], '3.99', '<')){
								if ($moon) 
									$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, moon, phalanx, gate, player, name, status, last_update_moon, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "1", '.($data['Pha'] > 0 ? $data['Pha'] : 0).', "'.($data['PoSa'] > 0 ? 1 : 0).'", "'.$l['player_name'].'", "", "", '.$time.', '.$user['id'].')'); 
								else 
									$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, player, name, status, last_update, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "'.$l['player_name'].'", "'.$l['planet_name'].'", "", '.$time.', '.$user['id'].')'); 
							} else {
								if ($moon)
									$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, moon, phalanx, gate, id_player, name, status, last_update_moon, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "1", '.($data['Pha'] > 0 ? $data['Pha'] : 0).', "'.($data['PoSa'] > 0 ? 1 : 0).'", "'.$l['player_id'].'", "", "", '.$time.', '.$user['id'].')');
								else
									$sql->query('INSERT INTO '.TABLE_UNIVERSE.' (galaxy, system, row, id_player, name, status, last_update, last_update_user_id) VALUES ('.$l['coords'][0].', '.$l['coords'][1].', '.$l['coords'][2].', "'.$l['player_id'].'", "'.$l['planet_name'].'", "", '.$time.', '.$user['id'].')');
							}
						}
					}
				} else {
					$logCounts['ignored_spy'] ++;
				}
			} // foreach spy
			$inserted = count($spy) - $logCounts['ignored_spy'];
			$sql->query('UPDATE '.TABLE_USER.' SET spy_added_ogs = spy_added_ogs + '.$inserted.' WHERE user_id = '.$user['id']);
			if(CARTO == 'OGSpy')
				update_statistic('spyimport_ogs',$inserted);
			else if(CARTO == 'UniSpy')
				update_statistic('external_import_spys',$inserted);
			
			if(CARTO == 'OGSpy') {//TODO voir pour UniSpy
				if ($config['xtense_spy_autodelete']) {
					$sql->query('DELETE FROM '.TABLE_PARSEDSPY.' WHERE dateRE < '.strtotime('-'.$config['max_keepspyreport'].'days'));
				}
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

?>