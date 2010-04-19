<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

if (!defined('IN_SPYOGAME')) exit;

define('TABLE_XTENSE_CALLBACKS', $table_prefix.'xtense_callbacks');
define('TABLE_XTENSE_GROUPS', $table_prefix.'xtense_groups');

define('PLUGIN_VERSION', '2.0.4139');
define('TOOLBAR_MIN_VERSION', '2.0b8');

if (!defined('XTENSE_LITE_CONFIG')) {
	if (!defined('TABLE_CONFIG')) {
		define('TABLE_CONFIG', $table_prefix.'config');
		define('TABLE_GROUP', $table_prefix.'group');
		define('TABLE_RANK_PLAYER_FLEET', $table_prefix.'rank_player_fleet');
		define('TABLE_RANK_PLAYER_POINTS', $table_prefix.'rank_player_points');
		define('TABLE_RANK_PLAYER_RESEARCH', $table_prefix.'rank_player_research');
		define('TABLE_RANK_ALLY_FLEET', $table_prefix.'rank_ally_fleet');
		define('TABLE_RANK_ALLY_POINTS', $table_prefix.'rank_ally_points');
		define('TABLE_RANK_ALLY_RESEARCH', $table_prefix.'rank_ally_research');
		define('TABLE_SESSIONS', $table_prefix.'sessions');
		define('TABLE_SPY', $table_prefix.'spy');
		define('TABLE_STATISTIC', $table_prefix.'statistics');
		define('TABLE_UNIVERSE', $table_prefix.'universe');
		define('TABLE_UNIVERSE_TEMPORARY', $table_prefix.'universe_temporary');
		define('TABLE_USER', $table_prefix.'user');
		define('TABLE_USER_BUILDING', $table_prefix.'user_building');
		define('TABLE_USER_DEFENCE', $table_prefix.'user_defence');
		define('TABLE_USER_FAVORITE', $table_prefix.'user_favorite');
		define('TABLE_USER_GROUP', $table_prefix.'user_group');
		define('TABLE_USER_SPY', $table_prefix.'user_spy');
		define('TABLE_USER_TECHNOLOGY', $table_prefix.'user_technology');
		define('TABLE_USER_PLANET', $table_prefix.'user_planet');
		define('TABLE_MOD', $table_prefix.'mod');
		define('TABLE_MOD_CFG', $table_prefix.'mod_config');
		define('TABLE_PARSEDSPY', $table_prefix.'parsedspy');
		define('TABLE_PARSEDRC', $table_prefix.'parsedRC');
		define('TABLE_PARSEDRCROUND', $table_prefix.'parsedRCRound');
		define('TABLE_ROUND_ATTACK', $table_prefix.'round_attack');
		define('TABLE_ROUND_DEFENSE', $table_prefix.'round_defense');
	}
	
	define('TYPE_PLANET', 0);
	define('TYPE_MOON', 1);
	
	$database = array(
		'buildings' => array('M', 'C', 'D', 'CES', 'CEF', 'UdR', 'UdN', 'CSp', 'HM', 'HC', 'HD', 'Lab', 'Ter', 'Silo', 'DdR', 'BaLu', 'Pha', 'PoSa'),
		'labo' => array('Esp', 'Ordi', 'Armes', 'Bouclier', 'Protection', 'NRJ', 'Hyp', 'RC', 'RI', 'PH', 'Laser', 'Ions', 'Plasma', 'RRI', 'Graviton', 'Expeditions'),
		'defense' => array('LM', 'LLE', 'LLO', 'CG', 'LP', 'AI', 'PB', 'GB', 'MIC', 'MIP'),
		'fleet' => array('PT', 'GT', 'CLE', 'CLO', 'CR', 'VB', 'VC', 'REC', 'SE', 'BMD', 'SAT', 'DST', 'EDLM', 'TRA')
	);
}

$callbackTypesNames = array(
	'overview','system','ally_list','buildings','research','fleet','defense','spy','ennemy_spy','rc',
	'rc_cdr', 'msg', 'ally_msg', 'expedition','ranking_player_fleet','ranking_player_points','ranking_player_research','ranking_ally_fleet',
	'ranking_ally_points','ranking_ally_research'
);

?>