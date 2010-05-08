<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) die('hack');

/**
 * Fonctions commune d'installation des callbacks des mods
 *
 * @param string $action - Action du mod
 * @param array $data - Appels à installer
 * @param string $version - Optionnel, version miniale requise de xtense
 * @return false/int - Retourne false si il y a une erreur ou le nombre d'appels ajoutés
 */
function install_callbacks ($action, $data, $version = null) {
	global $db, $table_prefix;
	
	define('XTENSE_LITE_CONFIG', 1);
	require_once('mod/Xtense2/includes/config.php');
	
	if ($version != null && version_compare($version, MOD_VERSION) == 1) return false;
	
	$query = $db->sql_query('SELECT id FROM '.TABLE_MOD.' WHERE action = "'.$action.'"');
	list($mod_id) = mysql_fetch_row($query);
	
	$replace = array();
	foreach ($data as $k => $call) {
		if (!isset($call['function'], $call['type'])) return false;
		if (!isset($call['active'])) $call['active'] = 1; 
		$replace[] = '('.$mod_id.', "'.$call['function'].'", "'.$call['type'].'", '.$call['active'].')';
	}
	
	$db->sql_query('INSERT IGNORE INTO '.TABLE_XTENSE_CALLBACKS.' (mod_id, function, type, active) VALUES '.implode(',', $replace));
	return $db->sql_affectedrows();
}

?>