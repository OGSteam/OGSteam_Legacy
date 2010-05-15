<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

if (!defined('OGSPY_INSTALLED') && !defined('UNISPY_INSTALLED')) exit;
if(defined('OGSPY_INSTALLED'))
	define('CARTO', 'OGSpy');
else if(defined('UNISPY_INSTALLED'))
	define('CARTO', 'UniSpy');
	
//if(!defined('IN_XTENSE')) {
if(!function_exists('lang_init_module') || !function_exists('lang_module_page') )
	require_once('mod/xtense/includes/lang.php');

lang_init_module('Xtense','mod/xtense/lang/');
lang_module_page('common');
//}

if (!defined('TABLE_XTENSE_CALLBACKS')) define('TABLE_XTENSE_CALLBACKS', $table_prefix.'xtense_callbacks');
define('TABLE_XTENSE_GROUPS', $table_prefix.'xtense_groups');

list($mod_name, $mod_version, $ogspy_min_version, $unispy_min_version, $toolbar_min_version) = file('mod/xtense/version.txt');
define('PLUGIN_VERSION', trim($mod_version));
define('TOOLBAR_MIN_VERSION', trim($toolbar_min_version));
if(CARTO == 'OGSpy')
	define('CARTO_MIN_VERSION', trim($ogspy_min_version));
else if(CARTO == 'UniSpy')
	define('CARTO_MIN_VERSION', trim($unispy_min_version));
	
	
if (!defined('XTENSE_LITE_CONFIG')) {
	if (!defined('TABLE_CONFIG')) {
		define("TABLE_ALLY", $table_prefix."ally");
		define("TABLE_CONFIG", $table_prefix."config");
		define("TABLE_HISTORY", $table_prefix."history");
		define("TABLE_GROUP", $table_prefix."group");
		define("TABLE_MP", $table_prefix."mp");
		define("TABLE_PLAYER", $table_prefix."player");
		define('TABLE_RANK_PLAYER_FLEET', $table_prefix.'rank_player_fleet');
		define('TABLE_RANK_PLAYER_POINTS', $table_prefix.'rank_player_points');
		define('TABLE_RANK_PLAYER_RESEARCH', $table_prefix.'rank_player_research');
		define('TABLE_RANK_PLAYER_BUILDINGS', $table_prefix.'rank_player_builds');
		define('TABLE_RANK_PLAYER_DEFENSE', $table_prefix.'rank_player_defense');
		define('TABLE_RANK_ALLY_FLEET', $table_prefix.'rank_ally_fleet');
		define('TABLE_RANK_ALLY_POINTS', $table_prefix.'rank_ally_points');
		define('TABLE_RANK_ALLY_RESEARCH', $table_prefix.'rank_ally_research');
		define('TABLE_RANK_ALLY_BUILDINGS', $table_prefix.'rank_ally_builds');
		define('TABLE_RANK_ALLY_DEFENSE', $table_prefix.'rank_ally_defense');
		define('TABLE_SESSIONS', $table_prefix.'sessions');
		define('TABLE_SPY', $table_prefix.'spy');
		define('TABLE_STATISTIC', $table_prefix.'statistics');
		define('TABLE_UNIVERSE', $table_prefix.'universe');
		define('TABLE_UNIVERSE_TEMPORARY', $table_prefix.'universe_temporary');
		define('TABLE_USER', $table_prefix.'user');
		define('TABLE_USER_BUILDING', $table_prefix.'user_building');
		define('TABLE_USER_DEFENCE', $table_prefix.'user_defence');
		define('TABLE_USER_FLEET', $table_prefix.'user_fleet');
		define('TABLE_USER_FAVORITE', $table_prefix.'user_favorite');
		define('TABLE_USER_GROUP', $table_prefix.'user_group');
		define('TABLE_USER_SPY', $table_prefix.'user_spy');
		define('TABLE_USER_TECHNOLOGY', $table_prefix.'user_technology');
		define('TABLE_USER_PLANET', $table_prefix.'user_planet');
		define('TABLE_MOD', $table_prefix.'mod');
		define('TABLE_MOD_CFG', $table_prefix.'mod_config');
		if(CARTO == 'OGSpy')
			define('TABLE_PARSEDSPY', $table_prefix.'parsedspy');
		else if(CARTO == 'UniSpy')
			define('TABLE_PARSEDSPY', $table_prefix.'spyreport');
		define('TABLE_PARSEDRC', $table_prefix.'parsedRC');
		define('TABLE_PARSEDRCROUND', $table_prefix.'parsedRCRound');
		define('TABLE_ROUND_ATTACK', $table_prefix.'round_attack');
		define('TABLE_ROUND_DEFENSE', $table_prefix.'round_defense');
		define('TABLE_MESSAGES', $table_prefix.'mp');
	}
	
	define('TYPE_PLANET', 0);
	define('TYPE_MOON', 1);
	
	if(CARTO == 'OGSpy')
		$database = array(
			'ressources' => array('metal','cristal','deuterium','energie','activite'),
			'buildings' => array('M', 'C', 'D', 'CES', 'CEF', 'UdR', 'UdN', 'CSp', 'SAT', 'HM', 'HC', 'HD', 'Lab', 'Ter', 'Silo', 'DdR', 'BaLu', 'Pha', 'PoSa'),
			'labo' => array('Esp', 'Ordi', 'Armes', 'Bouclier', 'Protection', 'NRJ', 'Hyp', 'RC', 'RI', 'PH', 'Laser', 'Ions', 'Plasma', 'RRI', 'Graviton', 'Expeditions'),
			'defense' => array('LM', 'LLE', 'LLO', 'CG', 'LP', 'AI', 'PB', 'GB', 'MIC', 'MIP'),
			'fleet' => array('PT', 'GT', 'CLE', 'CLO', 'CR', 'VB', 'VC', 'REC', 'SE', 'BMD', 'SAT', 'DST', 'EDLM', 'TRA')
		);
	else if(CARTO == 'UniSpy')
		$database = array(
			'ressources' => array('titanium','carbon','tritium'),
			'buildings' => array( 
				'MTi', 'MCa', 'MTr', 'PGe', 'PTr',
				'FDr', 'FAn', 'Shi', 'STi', 'SCa',
				'STr', 'TCe', 'Con', 'Terr', 'MPl'),
	'researchs'=> array(
				'Spy', 'Quan','Allo', 'Stra','Refi',
				'Weap', 'Shie', 'Shiel', 'Ther', 'Anti',
				'Subl', 'Impu', 'Warp',	'Smart', 'Ions',
				'Aere', 'Calc','Grav', 'Admi',  'Expl'	),
	'fleet'=> array('PT', 'GT', 'Fig', 'LFi', 'Freg',
				'Dest', 'Over', 'For', 'Hyp', 'Coll',
				'Spyp', 'Sat', 'Colo', 'Ext', 'Frel'),
	'defense'=> array( 
				'BFG', 'SBFG', 'PCa', 'Def', 'PIo',
				'AMD', 'SF', 'HF', 'CME', 'EMP' )
		);
}

$callbackTypesNames = array(
	'overview','system','ally_list','buildings','research','fleet','fleetSending','defense','spy','ennemy_spy','rc',
	'rc_cdr', 'msg', 'ally_msg', 'expedition','ranking_player_fleet','ranking_player_points','ranking_player_research','ranking_ally_fleet',
	'ranking_ally_points','ranking_ally_research'
);

?>