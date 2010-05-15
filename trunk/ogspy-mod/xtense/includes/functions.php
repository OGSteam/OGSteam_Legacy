<?php
/**
 * @package Xtense 2
 * @author Unibozu
 * @licence GNU
 */

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) exit;
define('MAGIC_QUOTES', get_magic_quotes_gpc() == 1 ? true : false);

/**
* on récupère le titre du mod celon la langue
**/
if(!function_exists('mod_info_title')){
	function mod_info_title($mod){
		global $config;
		
		if (file_exists("../../mod/{$mod}/lang/lang_".$config['language']."/infos.php")) include("../../mod/{$mod}/lang/lang_".$config['language']."/infos.php");
		if (file_exists("mod/{$mod}/lang/lang_".$config['language']."/infos.php")) include("mod/{$mod}/lang/lang_".$config['language']."/infos.php");
		$title = (isset($lang['mod_title']) ? $lang['mod_title'] : 'undefined');
		
		return $title;
	}
}

function js_compatibility($string){
	return str_replace('<br>','\n',(htmlspecialchars_decode($string)));
}

function parseOgameDate($date) {
	preg_match('!([0-9]+)-([0-9]+) ([0-9]+):([0-9]+):([0-9]+)!i', $date, $parts);
	return mktime($parts[3], $parts[4], $parts[5], $parts[1], $parts[2], date('Y') - ($parts[1] == 12 && date('n') == 1 ? 1 : 0));
}

function clean_nb($str) {
	return (int)str_replace('.', '', $str);
}

function error_handler($no, $str, $file, $line) {
	global $call;
	
	if ($call->currentCallback !== false) {
		global $io;
		
		throw new Exception('Erreur PHP lors de l\'execution'."\n".' '.$file.' @ '.$line.' : "'.$str.'"');
		//$io->append_call_error($call->currentCallback, 'Erreur PHP lors de l\'execution'."\n".' '.$file.':'.$line.' : "'.$str.'"');
		return !DEBUG;
	}
	
	return false;
}

/**
 * Amélioration de var_dump()
 *
 */
function dump() {
	$n = func_num_args();
	ob_start();
	for ($i = 0; $i < $n; $i++)
		var_dump(func_get_arg($i));
	$content = ob_get_clean()."\n";
	//echo str_replace(array('<', '>'), array('&lt;', '&gt;'), $content)."\n";
	echo $content."\n";
}

function move_plugin () {
	global $tpl;
	
	if (file_exists('./xtense.php') && !is_writable('./xtense.php')) {
		$tpl->assign('move_error', 'file_access'); return false;
	}
	
	if (!is_writable('./')) {
		$tpl->assign('move_error', 'dir_access'); return false;
	}
	
	@unlink('./xtense.php');
	if (file_exists('./xtense.php')) {
		$tpl->assign('move_error', 'file_unlink'); return false;
	}
	
	@copy('mod/xtense/xtense.php', './xtense.php');
	if (!file_exists('./xtense.php')) {
		$tpl->assign('move_error', 'copy'); return false;
	}
	
	@chmod('./xtense.php', 0777);
	return true;
}

/**
 * Echappement forcé pour la syntaxe Json
 *
 * @param string $str
 * @return string
 */
function json_quote($str) {
	return str_replace('"', '\\"', $str);
}

/**
 * Addslashes en fonction des magic_quotes
 *
 * @param string $str
 * @return string
 */
function quote($str) {
	return (MAGIC_QUOTES ? $str : addslashes($str));
}

/**
 * Verification de l'empire (Mise à jour, rajout, empire plein)
 *
 * @param int $type
 * @param string $coords
 * @return mixed(bool/int)
 */

function home_check($type, $coords) {
	global $sql, $user;
	
	$empty_planets 	= array(1=>1,2,3,4,5,6,7,8,9);
	$empty_moons 	= array(10=>10,11,12,13,14,15,16,17,18);
	$planets = $moons = array();
	$offset = ($type == TYPE_PLANET ? 0 : 9);
	
	$query = $sql->query('SELECT planet_id, coordinates FROM '.TABLE_USER_BUILDING.' WHERE user_id = '.$user['id'].' ORDER BY planet_id ASC');
	while ($data = mysql_fetch_assoc($query)) {
		if ($data['planet_id'] < 10) {
			$planets[$data['planet_id']] = $data['coordinates'];
			unset($empty_planets[$data['planet_id']], $empty_moons[$data['planet_id']+9]);
		}
		else {
			$moons[$data['planet_id']] = $data['coordinates'];
			unset($empty_moons[$data['planet_id']], $empty_planets[$data['planet_id']-9]);
		}
	}
	foreach ($planets as $id => $p) {
		if ($p == $coords || $coords == "unknown") {
			// Si c'est une lune on check si une lune existe déjà
			if ($type == TYPE_MOON) {
				if (isset($moons[$id+$offset])) return array('update', 'id' => $id+$offset);
				else return array('add', 'id' => $id+$offset);
			}
			
			return array('update', 'id' => $id);
		}
	}
	
	// Si une lune correspond a la planete, on place la planete sous la lune
	foreach ($moons as $id => $m) {
		if ($m == $coords) {
			return array($type == TYPE_PLANET ? 'add' : 'update', 'id' => $id-9+$offset);
		}
	}
	
	if ($type == TYPE_PLANET) {
		if (count($empty_planets) == 0) return array('full');
		foreach ($empty_planets as $p) return array('add', 'id' => $p);
	}
	else {
		if (count($empty_moons) == 0) return array('full');
		foreach ($empty_moons as $p) return array('add', 'id' => $p);
	}
}

function check_coords($coords, $exp = 0) {
	global $config;
	if (!preg_match('!^([0-9]{1,2}):([0-9]{1,3}):([0-9]{1,2})$!Usi', $coords, $match)) return false;
	//$row_error = ($exp ? ($match[3] != 16) : ($match[3] > 15) );
	//if ($match[1] < 1 || $match[2] < 1 || $match[3] < 1 || $match[1] > $config['num_of_galaxies'] || $match[2] > $config['num_of_systems'] || ($exp ? ($match[3] != 16) : ($match[3] > 15))) return false;
	return !($match[1] < 1 || $match[2] < 1 || $match[3] < 1 || $match[1] > $config['num_of_galaxies'] || $match[2] > $config['num_of_systems'] || ($exp ? ($match[3] != 16) : ($match[3] > 15)));
	//return true;
}

function icon($name) {
	echo '<img src="mod/xtense/tpl/icons/'.$name.'.png" class="icon" align="absmiddle" />';
}

function get_microtime() {
	$t = explode(' ', microtime());
	return ((float)$t[1] + (float)$t[0]);
}

function loadLocales($requiredLang, $page) {
/*	global $Xlocales, $config, $user, $user_data;
	if(!isset($Xlocales)) $Xlocales = array('loaded' => array(), 'data' => array());
	
	require_once('mod/xtense/lang/lang_FR/'.$page.'.php');
	$Xlocales['data'] = array_merge($Xlocales['data'], $lang);
	$Xlocales['loaded'][] = 'fr';
	unset($lang);
	
	if ($requiredLang !== null && strtolower($requiredLang != 'fr')){
		// Parade anti erreur de case
		$path = opendir($link='mod/xtense/lang/');
		while (($file = readdir($path)) !== false) 
			if(preg_match('/lang_([a-zA-Z0-9]{1,5})/',$file,$out)) $langs[strtolower($out[1])]=$out[1];
		if($i=array_keys($langs,strtolower($requiredLang))) $requiredLang=$langs[$i];
		$link=$link.'/lang_'.$requiredLang.'/'.$page.'.php';
		//if(file_exists($link=$link.'/lang_'.$requiredLang.'/'.$page.'.php')) {
		if (!file_exists($link)) throw new Exception('Can\'t load lang file "'.$link.'"');
		require_once($link);
		$Xlocales['data'] = array_merge($Xlocales['data'], $lang);
		$Xlocales['loaded'][] = $requiredLang;
	}*/
	
}

function __($name) {
/*	global $Xlocales;
	if (!isset($Xlocales['data'][$name])) throw new Exception('Unknow locale "'.$name.'" ; loaded langs: '.implode(', ', $Xlocales['loaded']));
	
	$str = $Xlocales['data'][$name];
	for ($i = 1, $len = func_num_args(); $i < $len; $i++) {
		$v = func_get_arg($i);
		$str = str_replace('$'.$i, $v, $str);
	}
	
	return $str;*/
	$args = ''; $a = Array();
	$n = func_num_args();
	for ($i=1; $i<$n; $i++){
		$a[$i] = func_get_arg($i);
		$args = ($args==''?'':$args.",").'$a['.$i.']';
	}
	if($args!='') $args = ','.$args;
	eval('$str = T_($name'.$args.');');
	return $str;
}

function ___($name) {
	echo __($name);
}

function add_log($type, $data = null) {
	global $config, $user;
	$message = '';
	
	if ($type == 'buildings' || $type == 'overview' || $type == 'defense' || $type == 'research' || $type == 'fleet') {
		if (!$config['xtense_log_empire']) return;
		
		if ($type == 'buildings') 	$message = __('log buildings', $data['planet_name'], $data['coords']);
		if ($type == 'overview') 	$message = __('log overview', $data['planet_name'], $data['coords']);
		if ($type == 'defense') 	$message = __('log defense', $data['planet_name'], $data['coords']);
		if ($type == 'research') 	$message = __('log research');
		if ($type == 'fleet') 		$message = __('log fleet', $data['planet_name'], $data['coords']);
	}
	
	if ($type == 'system') {
		if (!$config['xtense_log_system']) return;
		
		$message = __('log system', $data['coords']);
	}
	
	if ($type == 'ranking') {
		if (!$config['xtense_log_ranking']) return;
		
		$message = __('log ranking', __('log ranking '.$data['type2']), __('log ranking '.$data['type1']), $data['offset'], $data['offset']+99, date('H', $data['time']));
	}
	
	if ($type == 'ally_list') {
		$message = __('log ally_list', $data['tag']);
	}
	
	if ($type == 'rc') {
		$message = __('log rc');
	}
	
	if ($type == 'messages') {
		$message = __('log messages');
		
		$extra = array();
		if ($data['msg']) $extra[] = __('log messages msg', $data['msg']);
		if ($data['ally_msg']) $extra[] = __('log messages ally_msg', $data['ally_msg']);
		if ($data['ennemy_spy']) $extra[] = __('log messages ennemy_spy', $data['ennemy_spy']);
		if ($data['rc_cdr']) $extra[] = __('log messages rc_cdr', $data['rc_cdr']);
		if ($data['expedition']) $extra[] = __('log messages expedition', $data['expedition']);
		if ($data['added_spy']) $extra[] = __('log messages added_spy', $data['added_spy'], implode(', ', $data['added_spy_coords']));
		if ($data['ignored_spy']) $extra[] = __('log messages ignored_spy', $data['ignored_spy']);
		
		if (!empty($extra)) $message .= ' ('.implode(', ', $extra).')';
	}
	if (!empty($message)) {
		$dir = version_compare($config['version'], '3.6', '>') ? date('y-m'): date('ymd');
		
		if ($config['xtense_log_ogspy']) {
			$file = 'log_'.date('ymd').'.log';
			if (!file_exists('journal/'.$dir)) @mkdir('journal/'.$dir);
			if (file_exists('journal/'.$dir)) {
				@chmod('journal/'.$date, 0777);
				$fp = @fopen('journal/'.$dir.'/'.$file, 'a+');
				if ($fp) {
					fwrite($fp, '/*'.date('d/m/Y H:i:s').'*/'.'[Xtense] '.$user['pseudo'].' '.$message."\n");
					fclose($fp);
					@chmod('journal/'.$dir.'/'.$file, 0777);
				}
			}
		} else {
			$file = date('ymd').'log';
			$fp = @fopen('mod/xtense/log/'.$file, 'a+');
			if ($fp) {
				fwrite($fp, date('H:i:s').' | '.$user['pseudo'].' '.$message."\n");
				fclose($fp);
				@chmod('mod/xtense/log/'.$file, 0777);
			}
		}
	}
	
	// Verif de la date des fichiers logs
	if ($config['xtense_keep_log'] == 0 || $config['xtense_log_ogspy']) return;
	
	$since = strtotime('-'.$config['xtense_keep_log'].' days');
	$fp = @opendir('mod/xtense/log/');
	while (($file = @readdir($fp)) !== false) {
		if ($file != '.' && $file != '..' && preg_match('!^([0-9]{2})([0-9]{2})([0-9]{2})\.log$!', $file, $matches)) {
			if (mktime(0, 0, 1, $matches[3], $matches[2], $matches[1]) < $since) @unlink('mod/xtense/log/'.$file);
		}
	}
}

function format_size ($size) {
	if ($size < 1024) $size .= ' octets';
	elseif ($size < 1024*1024) $size = round($size/1024, 2).' Ko';
	else $size = round($size/1024/1024, 2).'Mo';
	return $size;
}

function update_statistic($stats,$value){
	global $sql;
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + {$value}";
	$request .= " where statistic_name = '{$stats}'";
	$sql->query($request);
	if (mysql_affected_rows() == 0) {
		$request = "insert ignore into ".TABLE_STATISTIC." values ('{$stats}', '{$value}')";
		$sql->query($request);
	}	
}