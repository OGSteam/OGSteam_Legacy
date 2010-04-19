<?php
/** $Id$ **/
/**
* Fonctions globales d'Ogspy
* @package OGSpy
* @subpackage main
* @author Kyser
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 3.04b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

/**
 * Redirection des url
 * @param string $url Url de destination
 */
function redirection($url='?action=',$t = 0){
	global $pub_ajax;
	$url .= isset($pub_ajax)?'&amp;ajax=1':'';
	if (headers_sent()) {
		die('<meta http-equiv="refresh" content="'.$t.'; URL='.$url.'">');
	} else {
		header("Location: ".$url);
		exit();
	}
}

/**
* Verifie les droits en écriture d'ogspy sur un fichier ou repertoire 
* @param string $path le fichier ou repertoire à tester
* @return boolean True si accés en écriture
* @comment http://fr.php.net/manual/fr/function.is-writable.php#68598
*/
function is__writable($path){
	if ($path{strlen($path)-1} == '/') return is__writable($path.uniqid(mt_rand()).'.tmp');
	else if (preg_match('/.tmp/', $path)) {
		if (!($f = @fopen($path, 'w+'))) return false;
		fclose($f);
		unlink($path);
		return true;
	} else die("return 0; // Or return error - invalid path...<br />".getcwd()."<br />".$path);
}

/**
* Ecrit un texte ou un tableau de texte dans un fichier
* @param string $file Nom du fichier
* @param string $mode Mode d'ouverture du fichier
* @param string|Array $text Chaine ou tableau a écrire
* @return boolean false si échec
*/
function write_file($file, $mode, $text) {
	if ($fp = fopen($file, $mode)) {
		if (is_array($text)) {
			foreach ($text as $t) {
				fwrite($fp, rtrim($t));
				fwrite($fp, "\r\n");
			}
		}
		else {
			fwrite($fp, $text);
			fwrite($fp, "\r\n");
		}
		fclose($fp);
		return true;
	}
	else return false;
}

/**
* Ecrit un texte ou un tableau de texte dans un fichier compressé gz
* @param string $file Nom du fichier
* @param string $mode Mode d'ouverture du fichier
* @param string|Array $text Chaine ou tableau a écrire
* @return boolean false si échec
*/
function write_file_gz($file, $mode, $text) {
	if ($fp = gzopen($file.".gz", $mode)) {
		if (is_array($text)) {
			foreach ($text as $t) {
				gzwrite($fp, rtrim($t));
				gzwrite($fp, "\r\n");
			}
		}
		else {
			gzwrite($fp, $text);
			gzwrite($fp, "\r\n");
		}
		gzclose($fp);
		return true;
	}
	else return false;
}

/**
* Codage d'ip en hexadecimal
* @param string $ip sous la forme xxx.xxx.xxx.xxx en IPv4 et xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx en IPv6
* @return string IP codé en hexa : HHHHHHHH en IPv4 et HHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH en IPv6
*/
function encode_ip($ip) {
	if (substr_count($ip, ":") > 0 && substr_count($ip, ".") == 0) {
		$ip_sep = explode(":", uncompress_ipv6($ip));
		return implode($ip_sep);
	} else {
		$ip_sep = explode(".", $ip);
		return sprintf("%02x%02x%02x%02x", $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
	}
}

/**
 * Décodage d'ip d'hexadecimal à la forme xxx.xxx.xxx.xxx
 * @param string $ip_encode IP encodé
 * @return string IP sous la forme xxx.xxx.xxx.xxx
 */
function decode_ip($ip_encode) {
	if (strlen($ip_encode) > 8) return implode(":", str_split($ip_encode, 4));
	else {
		$hexipbang = str_split($ip_encode, 2);
		return hexdec($hexipbang[0]).'.'.hexdec($hexipbang[1]).'.'.hexdec($hexipbang[2]).'.'.hexdec($hexipbang[3]);
	}
}

/**
 * Décompression d'adresses IPv6
 * @param string $ip IPv6 sous la forme xx::xxxx
 * @return string IP sous la forme xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx:xxxx
 */
function uncompress_ipv6($ipv6) {
	if (strpos($ipv6, "::") == false) {
		$e = explode(":", $ipv6);
		$s = 8 - sizeof($e) + 1;
		foreach($e as $key=>$val) {
			if ($val == "") {
				for($i==0; $i<=$s; $i++) $newip[] = '0000';
			} else $newip[] = padleft($val, '0', 4);
		}
		$ip = implode(":", $newip);
	}
	return $ip;
}

/**
 * Complète une chaîne avec des caractères à gauche
 * @param string $str chaîne à compléter
 * @param string $strChar caractère de remplissage
 * @param string $strChar longeur finale
 * @return string chaîne complétée
 */
function padleft($str, $strChar, $intLength) {
	$str = $str.'';
	if (strlen($str) > 0) {
		while (strlen($str) < $intLength) $str = $strChar.$str;
	}
	return $str;
}

/**
 * Génératrice de mot de passe de 6 caractères
 */
function password_generator() {
	$string = "abBDEFcdefghijkmnPQRSTUVWXYpqrst23456789";
	srand((double)microtime()*1000000);
	$password = '';
	for($i=0; $i<6; $i++) {
		$password .= $string[rand()%strlen($string)];
	}
	return $password;
}

/**
 * Initialisation du tableau de confifuration $server_config
 */
function init_serverconfig() {
	global $db, $server_config;

	$request = "select * from ".TABLE_CONFIG;
	$result = $db->sql_query($request);

	while (list($name, $value) = $db->sql_fetch_row($result)) {
		$server_config[$name] = stripslashes($value);
	}
	
	$a = explode(",", $server_config["ally_protection"]);
	$b = Array();
	foreach($a as $c) $b[] = trim($c);
	$server_config['ally_protection_array'] = $b;
}

/**
 * Enregistrement des paramètres 'Affichage' du panneau admin
 */
function set_server_view() {
	global $db, $user_data;
	global $pub_enable_portee_missil, $pub_enable_friendly_phalanx, $pub_enable_members_view, $pub_enable_stat_view, $pub_galaxy_by_line_stat, $pub_system_by_line_stat, $pub_galaxy_by_line_ally, $pub_system_by_line_ally, $pub_nb_colonnes_ally, $pub_color_ally, $pub_enable_register_view, $pub_register_alliance, $pub_register_forum, $pub_open_user, $pub_open_admin, $pub_scolor_count, $pub_scolor_type, $pub_scolor_text, $pub_scolor_color;
	
	if (!isset($pub_galaxy_by_line_stat) || !isset($pub_system_by_line_stat) || !isset($pub_galaxy_by_line_ally) || !isset($pub_system_by_line_ally)) {
		redirection("?action=message&id_message=setting_server_view_failed&info");
	}
	if (!check_var($pub_enable_members_view,"Num") || !check_var($pub_enable_stat_view,"Num") || !check_var($pub_galaxy_by_line_stat,"Num") || !check_var($pub_system_by_line_stat,"Num") || !check_var($pub_galaxy_by_line_ally,"Num") || !check_var($pub_system_by_line_ally,"Num")) {
		redirection("?action=message&id_message=errordata&info");
	}
	foreach($pub_color_ally as $j => $test){
		$is_color = preg_match('/^\#/',$test)?"Color":"Text";
		if(!check_var($test,$is_color))
			redirection("?action=message&id_message=errordata&info");
	}
	foreach($pub_scolor_text as $test)
		if($test!="{mine}"&&$test!="[mine]")
			if(!check_var($test,"Text"))
				redirection("?action=message&id_message=errordata&info");
	foreach($pub_scolor_type as $test)
		if(!check_var($test,"Char"))
			redirection("?action=message&id_message=errordata&info");
	foreach($pub_scolor_color as $j => $test){
		$is_color = preg_match('/^\#/',$test)?"Color":"Text";
		if(!check_var($test,$is_color))
			redirection("?action=message&id_message=errordata&info");
	}
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
		redirection("?action=message&id_message=forbidden&info");
	}

	
	if (is_null($pub_enable_portee_missil)) $pub_enable_portee_missil = 0;
	if (is_null($pub_enable_friendly_phalanx)) $pub_enable_friendly_phalanx = 0;
	if (is_null($pub_enable_stat_view)) $pub_enable_stat_view = 0;
	if (is_null($pub_enable_members_view)) $pub_enable_members_view = 0;
	
	if (!is_numeric($pub_galaxy_by_line_stat) || 
	(!is_numeric($pub_system_by_line_stat)) || 
	($pub_enable_stat_view != 0 && $pub_enable_stat_view != 1) || 
	($pub_enable_members_view != 0 && $pub_enable_members_view != 1) || 
	(!is_numeric($pub_galaxy_by_line_ally)) || 
	(!is_numeric($pub_system_by_line_ally)) || 
	($pub_nb_colonnes_ally == 0 || $pub_nb_colonnes_ally > 9 || !is_numeric($pub_nb_colonnes_ally)) || 
	($pub_scolor_count == 0 || $pub_scolor_count > 9 || !is_numeric($pub_scolor_count)) ||
	($pub_enable_register_view != 0 && $pub_enable_register_view != 1) 
	)  {
		redirection("?action=message&id_message=setting_server_view_failed&info");
	}

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_enable_portee_missil." where config_name = 'portee_missil'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_enable_friendly_phalanx." where config_name = 'friendly_phalanx'";
	$db->sql_query($request);
	
	//
	if ($pub_galaxy_by_line_stat < 1) $pub_galaxy_by_line_stat = 1;
	if ($pub_galaxy_by_line_stat > 100) $pub_galaxy_by_line_stat = 100;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_galaxy_by_line_stat." where config_name = 'galaxy_by_line_stat'";
	$db->sql_query($request);
	
	//
	if ($pub_system_by_line_stat < 1) $pub_system_by_line_stat = 1;
	if ($pub_system_by_line_stat > 100) $pub_system_by_line_stat = 100;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_system_by_line_stat." where config_name = 'system_by_line_stat'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_open_user."' where config_name = 'open_user'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_open_admin."' where config_name = 'open_admin'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_enable_stat_view." where config_name = 'enable_stat_view'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_enable_members_view." where config_name = 'enable_members_view'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_nb_colonnes_ally)."' where config_name = 'nb_colonnes_ally'";
	$db->sql_query($request);

	
	$array = $pub_color_ally;//die(var_dump($pub_color_ally));
	for($i = 0; $i<$pub_nb_colonnes_ally; $i++)
		if(!isset($pub_color_ally[$i])) $array[$i] = "White";
		else $array[$i] = $pub_color_ally[$i];
	$color_ally = implode("_", $array);
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($color_ally)."' where config_name = 'color_ally'";
	$db->sql_query($request);

	// Nombre de couleur choisi
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_scolor_count)."' where config_name = 'scolor_count'";
	$db->sql_query($request);

	// Type, Text, et Couleurs choisies
	// On verifie qu'il y a bien autant de valeur que de couleur 
	$scolor_type = $scolor_color = $scolor_text = Array();
	for($i = 0; $i < $pub_scolor_count; $i++){ 
		//(si l'utilisateur n'a fait que changer le nombre de couleur, il faut entrer des valeurs par défaut pour la ou les nouvelles)
		// On recopie le tableau (ca permet d'ignorer les valeurs suivantes si l'utilisateur a reduit le nombre de couleur
		if(!isset($pub_scolor_type[$i])) $scolor_type[$i] = "J";
		else $scolor_type[$i] = $pub_scolor_type[$i];
		if(!isset($pub_scolor_color[$i])) $scolor_color[$i] = "White";
		else $scolor_color[$i] = $pub_scolor_color[$i];
		if(!isset($pub_scolor_text[$i])) $scolor_text[$i] = " -- ";
		else if($pub_scolor_text[$i]=='[mine]') $scolor_text[$i] = '{mine}';
		else $scolor_text[$i] = $pub_scolor_text[$i];
		
		
	}
	$types = implode("_",$scolor_type);
	$colors = implode("_",$scolor_color);
	$texts = implode("_|_",$scolor_text);
	$request = "update ".TABLE_CONFIG." set config_value = ('".mysql_real_escape_string($types)."') where config_name = ('scolor_type');";
	$db->sql_query($request);
	$request = "update ".TABLE_CONFIG." set config_value = ('".mysql_real_escape_string($colors)."') where config_name = ('scolor_color');";
	$db->sql_query($request);
	$request = "update ".TABLE_CONFIG." set config_value = ('".mysql_real_escape_string($texts)."') where config_name = ('scolor_text');";
	$db->sql_query($request);
	

	//
	if ($pub_galaxy_by_line_ally < 1) $pub_galaxy_by_line_ally = 1;
	if ($pub_galaxy_by_line_ally > 100) $pub_galaxy_by_line_ally = 100;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_galaxy_by_line_ally." where config_name = 'galaxy_by_line_ally'";
	$db->sql_query($request);
	
	//
	if ($pub_system_by_line_ally < 1) $pub_system_by_line_ally = 1;
	if ($pub_system_by_line_ally > 100) $pub_system_by_line_ally = 100;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_system_by_line_ally." where config_name = 'system_by_line_ally'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_enable_register_view."' where config_name = 'enable_register_view'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_register_alliance)."' where config_name = 'register_alliance'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_register_forum)."' where config_name = 'register_forum'";
	$db->sql_query($request);
	

	log_("set_server_view");
	redirection("?action=administration&subaction=affichage");
}

/**
 * Enregistrement des 'Paramètres' admin.
 */
function set_serverconfig() {
	global $db, $user_data, $server_config;
	global $pub_max_battlereport, $pub_max_favorites, $pub_max_favorites_spy, $pub_max_spyreport, $pub_server_active ,$pub_session_time, $pub_max_keeplog, $pub_default_skin, $pub_debug_log, $pub_reason, $pub_ally_protection, $pub_url_forum, $pub_max_keeprank, $pub_keeprank_criterion, $pub_max_keepspyreport, $pub_servername, $pub_ally_protection_color, $pub_disable_ip_check, $pub_num_of_galaxies, $pub_num_of_systems, $pub_log_phperror, $pub_log_langerror, $pub_block_ratio, $pub_ratio_limit, $pub_speed_uni, $pub_ddr, $pub_serverlanguage, $pub_parsinglanguage;
	
	if (!isset($pub_num_of_galaxies))
    $pub_num_of_galaxies = intval($server_config['num_of_galaxies']);
	if (!isset($pub_num_of_systems))
    $pub_num_of_systems = intval($server_config['num_of_systems']);
    $color_text = preg_match('/^\#/',$pub_ally_protection_color);
	if (!check_var($pub_max_battlereport, "Num") || !check_var($pub_max_favorites, "Num") || !check_var($pub_max_favorites_spy, "Num") || !check_var($pub_ratio_limit, "Special", "#^[\w\s,\.\-]+$#") ||
	!check_var($pub_max_spyreport, "Num") || !check_var($pub_server_active, "Num") || !check_var($pub_session_time, "Num") ||
	!check_var($pub_max_keeplog, "Num") || !check_var($pub_default_skin, "URL") || !check_var($pub_debug_log, "Num") || !check_var($pub_block_ratio, "Num") ||
	!check_var(stripslashes($pub_reason), "Text") || !check_var($pub_ally_protection, "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_url_forum, "URL") ||
	!check_var($pub_max_keeprank, "Num") || !check_var($pub_keeprank_criterion, "Char") || !check_var($pub_max_keepspyreport, "Num") ||
	!check_var(stripslashes($pub_servername), "Text") || !(check_var($pub_ally_protection_color, ($color_text?"Color":"Text"))) || !check_var($pub_disable_ip_check,"Num") || !check_var($pub_num_of_galaxies,"Galaxies") || !check_var($pub_num_of_systems,"Galaxies")) {
		redirection("?action=message&id_message=errordata&info");
	}
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
		redirection("?action=message&id_message=forbidden&info");
	}

	if (!isset($pub_max_battlereport) || !isset($pub_max_favorites) || !isset($pub_max_favorites_spy) || !isset($pub_ratio_limit) || !isset($pub_max_spyreport) ||
	!isset($pub_session_time) || !isset($pub_max_keeplog) || !isset($pub_default_skin) || !isset($pub_reason) ||
	!isset($pub_ally_protection) || !isset($pub_url_forum) || !isset($pub_max_keeprank) || !isset($pub_keeprank_criterion) ||
	!isset($pub_max_keepspyreport) || !isset($pub_servername) || !isset($pub_ally_protection_color)) {
		redirection("?action=message&id_message=setting_serverconfig_failed&info");
	}
	
	if (is_null($pub_server_active)) $pub_server_active = 0;
	if (is_null($pub_disable_ip_check)) $pub_disable_ip_check = 0;
	if (is_null($pub_log_phperror)) $pub_log_phperror = 0;
	if (is_null($pub_log_langerror)) $pub_log_langerror = 0;

	if (is_null($pub_debug_log)) $pub_debug_log = 0;
	if (is_null($pub_block_ratio)) $pub_block_ratio = 0;

	$break = false;


	if ($pub_server_active != 0 && $pub_server_active != 1) $break = true;
	if ($pub_debug_log != 0 && $pub_debug_log != 1) $break = true;
	if ($pub_block_ratio != 0 && $pub_block_ratio != 1) $break = true;
	if (!is_numeric($pub_max_favorites)) $break = true;
	if (!is_numeric($pub_max_favorites_spy)) $break = true;
	if (!is_numeric($pub_ratio_limit)) $break = true;
	if (!is_numeric($pub_max_spyreport)) $break = true;
	if (!is_numeric($pub_max_battlereport)) $break = true;
	if (!is_numeric($pub_session_time)) $break = true;
	if (!is_numeric($pub_max_keeplog)) $break = true;
	if ($pub_disable_ip_check != 0 && $pub_disable_ip_check != 1) $break = true;
	if ($pub_log_phperror != 0 && $pub_log_phperror != 1) $break = true;
	if ($pub_log_langerror != 0 && $pub_log_langerror != 1) $break = true;

	if ($break) {
	redirection("?action=message&id_message=setting_serverconfig_failed&info");
	}

  if (($pub_num_of_galaxies != intval($server_config['num_of_galaxies'])) || ($pub_num_of_systems != intval($server_config['num_of_systems']))) {
    resize_db($pub_num_of_galaxies, $pub_num_of_systems);
  }
	// Langues :
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_serverlanguage."' where config_name = 'language'";
	$db->sql_query($request);
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_parsinglanguage."' where config_name = 'language_parsing'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_server_active." where config_name = 'server_active'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_debug_log." where config_name = 'debug_log'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_block_ratio." where config_name = 'block_ratio'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_log_phperror." where config_name = 'log_phperror'";
	$db->sql_query($request);
	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_log_langerror." where config_name = 'log_langerror'";
	$db->sql_query($request);
	//
	$pub_max_favorites = intval($pub_max_favorites);
	if ($pub_max_favorites < 0) $pub_max_favorites = 0;
	if ($pub_max_favorites > 99) $pub_max_favorites = 99;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_favorites." where config_name = 'max_favorites'";
	$db->sql_query($request);

	//
	$pub_max_favorites_spy = intval($pub_max_favorites_spy);
	if ($pub_max_favorites_spy < 0) $pub_max_favorites_spy = 0;
	if ($pub_max_favorites_spy > 99) $pub_max_favorites_spy = 99;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_favorites_spy." where config_name = 'max_favorites_spy'";
	$db->sql_query($request);
	
	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_ratio_limit." where config_name = 'ratio_limit'";
	$db->sql_query($request);

	//
	$pub_max_spyreport = intval($pub_max_spyreport);
	if ($pub_max_spyreport < 1) $pub_max_spyreport = 1;
	if ($pub_max_spyreport > 10) $pub_max_spyreport = 10;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_spyreport." where config_name = 'max_spyreport'";
	$db->sql_query($request);

	//
	$pub_max_battlereport = intval($pub_max_battlereport);
	if ($pub_max_battlereport < 0) $pub_max_battlereport = 0;
	if ($pub_max_battlereport > 99) $pub_max_battlereport = 99;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_battlereport." where config_name = 'max_battlereport'";
	$db->sql_query($request);

	//
	$pub_session_time = intval($pub_session_time);
	if ($pub_session_time < 5 && $pub_session_time != 0) $pub_session_time = 5;
	if ($pub_session_time > 180) $pub_session_time = 180;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_session_time." where config_name = 'session_time'";
	$db->sql_query($request);

	//
	$pub_max_keeplog = intval($pub_max_keeplog);
	if ($pub_max_keeplog < 0) $pub_max_keeplog = 0;
	if ($pub_max_keeplog > 365) $pub_max_keeplog = 365;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_keeplog." where config_name = 'max_keeplog'";
	$db->sql_query($request);

	//
	if (substr($pub_default_skin, strlen($pub_default_skin)-1) != "/") $pub_default_skin .= "/";
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_default_skin)."' where config_name = 'default_skin'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_reason)."' where config_name = 'reason'";
	$db->sql_query($request);

	//
	if (substr($pub_ally_protection, strlen($pub_ally_protection)-1) == ",") $pub_ally_protection = substr($pub_ally_protection, 0, strlen($pub_ally_protection)-1);
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_ally_protection)."' where config_name = 'ally_protection'";
	$db->sql_query($request);
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_ally_protection_color)."' where config_name = 'ally_protection_color'";
	$db->sql_query($request);

	//
	if ($pub_url_forum != "" && !preg_match("#^http://#", $pub_url_forum)) $pub_url_forum = "http://".$pub_url_forum;
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_url_forum)."' where config_name = 'url_forum'";
	$db->sql_query($request);

	//
	$pub_max_keeprank = intval($pub_max_keeprank);
	if ($pub_max_keeprank < 1) $pub_max_keeprank = 1;
	if ($pub_max_keeprank > 50) $pub_max_keeprank = 50;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_keeprank." where config_name = 'max_keeprank'";
	$db->sql_query($request);

	//
	if ($pub_keeprank_criterion != "quantity" && $pub_keeprank_criterion != "day") $pub_keeprank_criterion = "quantity";
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_keeprank_criterion)."' where config_name = 'keeprank_criterion'";
	$db->sql_query($request);

	//
	$pub_max_keepspyreport = intval($pub_max_keepspyreport);
	if ($pub_max_keepspyreport < 1) $pub_max_keepspyreport = 1;
	if ($pub_max_keepspyreport > 90) $pub_max_keepspyreport = 90;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_max_keepspyreport." where config_name = 'max_keepspyreport'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_servername)."' where config_name = 'servername'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_disable_ip_check." where config_name = 'disable_ip_check'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_num_of_galaxies." where config_name = 'num_of_galaxies'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_num_of_systems." where config_name = 'num_of_systems'";
	$db->sql_query($request);

	//
	if (!isset($pub_ddr)||!is_numeric($pub_ddr)) $pub_ddr = 0;
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ddr."' where config_name = 'ddr'";
	$db->sql_query($request);

	//
	if ( !is_numeric($pub_speed_uni)||$pub_speed_uni < 1) $pub_speed_uni = 1;
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_speed_uni." where config_name = 'speed_uni'";
	$db->sql_query($request);

	log_("set_serverconfig");
	redirection("?action=administration&subaction=parameters");
}

/**
 * Renvoi un tableau contenant la taille de la base
 * @return Array [Server], et [Total]
 */
function db_size_info() {
	global $db;
	global $table_prefix;

	$dbSizeServer = 0;
	$dbSizeTotal = 0;

	$request = "SHOW TABLE STATUS";
	$result = $db->sql_query($request);
	while ($row = $db->sql_fetch_assoc($result)) {
		$dbSizeTotal += $row['Data_length'] + $row['Index_length'];
		if (preg_match("#^".$table_prefix.".*$#", $row['Name'])) {
			$dbSizeServer += $row['Data_length'] + $row['Index_length'];
		}
	}

	$bytes = array('Bytes', 'KB', 'MB', 'GB', 'TB');

	if ($dbSizeServer < 1024) $dbSizeServer = 1;
	for ($i = 0; $dbSizeServer > 1024; $i++)
	$dbSizeServer /= 1024;
	$dbSize_info["Server"] = round($dbSizeServer, 2)." ".$bytes[$i];

	if ($dbSizeTotal < 1024) $dbSizeTotal = 1;
	for ($i = 0; $dbSizeTotal > 1024; $i++)
	$dbSizeTotal /= 1024;
	$dbSize_info["Total"] = round($dbSizeTotal, 2)." ".$bytes[$i];

	return $dbSize_info;
}

/**
 *  Routine d'Optimisation de la base de donnée
 *  @param boolean $maintenance_action true si aucune redirection souhaité,false pour avoir une redirection sur un message de résumé
 */
function db_optimize($maintenance_action = false) {
	global $db;

	$dbSize_before = db_size_info();
	$dbSize_before = $dbSize_before["Total"];

    $request = 'SHOW TABLES';
    $res = $db->sql_query ( $request );
    while ( list ( $table ) = $db->sql_fetch_row ( $res ) )
    {
	  $request = 'OPTIMIZE TABLE ' . $table;
	  $db->sql_query($request);
	}
	$request = 'TRUNCATE ' . TABLE_UNIVERSE_TEMPORARY;
	$db->sql_query ( $request );

	$dbSize_after = db_size_info();
	$dbSize_after = $dbSize_after["Total"];

	if (!$maintenance_action) {
		redirection("?action=message&id_message=db_optimize&info=".$dbSize_before."€".$dbSize_after);
	}
}

/**
 * Adaptation de la base aux nombres de galaxies et systemes
 * @param int $new_num_of_galaxies Nombre de Galaxies
 * @param int $new_num_of_systems Nombre de systèmes
 * @return null
 */
function resize_db($new_num_of_galaxies, $new_num_of_systems) {
	global $db, $db_host, $db_user, $db_password, $db_database, $table_prefix, $server_config;
  
   // si on reduit on doit supprimez toutes les entrées qui font reference au systemes ou galaxies que l'on va enlevez
  if ($new_num_of_galaxies < intval($server_config['num_of_galaxies'])) {
    $db->sql_query("DELETE FROM ".TABLE_PARSEDSPY." WHERE galaxy > $new_num_of_galaxies");
    $db->sql_query("DELETE FROM ".TABLE_UNIVERSE." WHERE galaxy > $new_num_of_galaxies");
    $db->sql_query("UPDATE ".TABLE_USER." SET user_galaxy=1 WHERE user_galaxy > $new_num_of_galaxies");
    $db->sql_query("DELETE FROM ".TABLE_USER_FAVORITE." WHERE galaxy > $new_num_of_galaxies");
  }
  if ($new_num_of_systems < intval($server_config['num_of_systems'])) {
    $db->sql_query("DELETE FROM ".TABLE_PARSEDSPY." WHERE system > $new_num_of_systems");
    $db->sql_query("DELETE FROM ".TABLE_UNIVERSE." WHERE system > $new_num_of_systems");
    $db->sql_query("UPDATE ".TABLE_USER." SET user_system=1 WHERE user_system > $new_num_of_systems");
    $db->sql_query("DELETE FROM ".TABLE_USER_FAVORITE." WHERE system > $new_num_of_systems");
  }
  
  $request = "ALTER TABLE `".TABLE_PARSEDSPY."` CHANGE `galaxy` `galaxy` ENUM(";
	for($i=1 ; $i<$new_num_of_galaxies ; $i++)
		$request .= "'$i' , ";
  $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
  $db->sql_query($request);
  
  $request = "ALTER TABLE `".TABLE_UNIVERSE."` CHANGE `galaxy` `galaxy` ENUM(";
	for($i=1 ; $i<$new_num_of_galaxies ; $i++)
		$request .= "'$i' , ";
  $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
  $db->sql_query($request);
  
  $request = "ALTER TABLE `".TABLE_USER."` CHANGE `user_galaxy` `user_galaxy` ENUM(";
	for($i=1 ; $i<$new_num_of_galaxies ; $i++)
		$request .= "'$i' , ";
  $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
  $db->sql_query($request);
  
  $request = "ALTER TABLE `".TABLE_USER_FAVORITE."` CHANGE `galaxy` `galaxy` ENUM(";
	for($i=1 ; $i<$new_num_of_galaxies ; $i++)
		$request .= "'$i' , ";
  $request .= "'$new_num_of_galaxies') NOT NULL DEFAULT '1'";
  $db->sql_query($request);
  
  $server_config['num_of_galaxies'] = "$new_num_of_galaxies";
  $server_config['num_of_systems'] = "$new_num_of_systems";
  $requests = "REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_galaxies','$new_num_of_galaxies')";
  $db->sql_query($request);
  $requests = "REPLACE INTO ".TABLE_CONFIG." (config_name, config_value) VALUES ('num_of_systems','$new_num_of_systems')";
  $db->sql_query($request);

  log_("set_db_size");
}

/**
 * Taille des logs sur le serveur
 * @return Array tableau [type] et [size]
 */
function log_size_info() {
	$logSize = 0;
	$res = opendir(PATH_LOG);
	$directory = array();
	//Récupération de la liste des fichiers présents dans les répertoires répertoriés
	while($file = readdir($res)) {
		if($file != "." && $file != "..") {
			if (is_dir(PATH_LOG.$file)) {
				$directory[] = PATH_LOG.$file;
			}
		}
	}
	closedir($res);

	foreach ($directory as $v) {
		$res = opendir($v);
		$directory = array();
		//Récupération de la liste des fichiers présents dans les répertoires répertoriés
		while($file = readdir($res)) {
			if($file != "." && $file != "..") {
				$logSize += @filesize($v."/".$file);
			}
		}
		closedir($res);
	}

	$bytes = array('Bytes', 'KB', 'MB', 'GB', 'TB');

	if ($logSize < 1024) $logSize = 1;

	for ($i = 0; $logSize > 1024; $i++)
	$logSize /= 1024;

	$log_size_info['size'] = round($logSize, 2);
	$log_size_info['type'] = $bytes[$i];

	return $log_size_info;
}

/**
 * Purge des fichiers logs , selon configuration du serveur
 */
function log_purge() {
	global $server_config;

	$time = $server_config["max_keeplog"];
	$limit = time()-(60*60*24*$time);
	$limit = intval(date("ymd", $limit));

	$root = PATH_LOG;
	$path = opendir("$root");
	while($file = readdir($path)) {
		if($file != "." && $file != "..") {
			if (is_dir($root.$file) && intval($file) < $limit && preg_match("/[0-9]{6}/", $file)) {
				$directories[] = $file;
			}
		}
	}
	closedir($path);

	if (!isset($directories)) {
		return;
	}

	$files = array();
	foreach ($directories as $d) {
		$path = opendir($root.$d);

		while($file = readdir($path)) {
			if($file != "." && $file != "..") {
				$extension = substr($file, (strrpos($file, ".")+1));
				unlink($root.$d."/".$file);
			}
		}
		closedir($path);
		rmdir($root.$d);
	}
}

/** 
 * Formate un nombre nombre donné selon la localisation.
 *
 * @param	$number
 *			le nombre a formatter.
 * @param	$decimal
 *			le nombre de chiffres après la virgule.
 *
 * @return	Le nombre formaté avec autant de decimal que specifié.
 *			Anglais		: xxx,xxx.xx
 *			Francais	: xxx xxx,xx
 */
function formate_number($number, $decimal = 0)
{
	global $lang_loaded;
	
	if ($lang_loaded == 'fr')
		return number_format($number, $decimal, ',', ' ');
	
	return number_format($number, $decimal);
}

/**
 * Maintenance du serveur (Purge des galaxies,des rapports d'espionages,des logs, et optimisation de la base)
 */
function maintenance_action() {
	global $db, $server_config;

	$time = mktime(0,0,0);
	if (isset($server_config["last_maintenance_action"]) && $time > $server_config["last_maintenance_action"]) {
		galaxy_purge_ranking();
		log_purge();
		galaxy_purge_spy();
		db_optimize(true);

		$request = "update ".TABLE_CONFIG." set config_value = '".$time."' where config_name = 'last_maintenance_action'";
		$db->sql_query($request);
	}
}

/**
 * Controle que la variable value correspond bien au type_check
 */
function check_var($value, $type_check, $mask = "", $auth_null = true) {
	if ($auth_null && $value == "") {
		return true;
	}
	
	switch ($type_check) {
		//Pseudo des membres
		case "Pseudo_Groupname" :
		if (!preg_match("#^[\w\s\-]{3,15}$#", $value)) {
			log_("check_var", array("Pseudo_Groupname", $value));
			return false;
		}
		break;

		//Mot de passe des membres
		case "Password" :
		if (!preg_match("#^[\w\s\-]{3,15}$#", $value)) {
			return false;
		}
		break;

		//Chaîne de caractères avec espace
		case "Text" :
		if (!preg_match("#^[\w'äàçéèêëïîöôûü\s\.\,\*\-]+$#", $value)) {
			log_("check_var", array("Text", $value));
			return false;
		}
		break;

		//Chaîne de caractères et  chiffre
		case "CharNum" :
		if (!preg_match("#^[\w\.\*\-\#]+$#", $value)) {
			log_("check_var", array("CharNum", $value));
			return false;
		}
		break;

		//Caractères
		case "Char" :
		if (!preg_match("#^[[:alpha:]_\.\*\-]+$#", $value)) {
			log_("check_var", array("Char", $value));
			return false;
		}
		break;

		//Code Couleur
		case "Color" :
		if (!preg_match("#^\#[0-9a-fA-F]{6}$#", $value)) {
			log_("check_var", array("Color", $value));
			return false;
		}
		break;

		//Chiffres
		case "Num" :
		if (!preg_match("#^[-?[:digit:]]+$#", $value)) {
			log_("check_var", array("Num", $value));
			return false;
		}
		break;
		
		//Galaxies
		case "Galaxies" :
		if ($value < 1 || $value > 999) {
			log_("check_var", array("Galaxy or system", $value));
			return false;
		}
		break;

		//Adresse internet
		case "URL":
		if (!preg_match("#^(((?:http?)://)?(?(2)(www\.)?|(www\.){1})?[-a-z0-9~_]{2,}(\.[-a-z0-9~._]{2,})?[-a-z0-9~_\/&\?=.]{2,})$#i", $value)) {
			log_("check_var", array("URL", $value));
			return false;
		}
		break;

		//Planète, Joueur et alliance
		case "Galaxy":
//		if (!preg_match("#^[\w\s\.\*\-]+$#", $value)) {
//			log_("check_var", array("Galaxy", $value));
//			return false;
//		}
		break;

		//Rapport d'espionnage
		case "Spyreport":
//		if (!preg_match("#^[\w\s\[\]\:\-'%\.\*]+$#", $value)) {
//			log_("check_var", array("Spyreport", $value));
//			return false;
//		}
		break;

		//Masque paramétrable
		case "Special":
		if (!preg_match($mask, $value)) {
			log_("check_var", array("Special", $value));
			return false;
		}
		break;

		default:
		return false;
	}

	return true;
}

/**
 * Remise à zéro des ratio
 */
function admin_raz_ratio($maintenance_action = false) {
	global $db, $user_data;
		
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	die("Acces interdit");}
	
	$request = "UPDATE ".TABLE_USER." set search='0'";
	$db->sql_query($request);

	if (!$maintenance_action) {
		redirection("?action=message&id_message=raz_ratio&info");}
}

/**
 * Valeur courant de microtime() formaté pour les benchmarks et mesure de temps
 */
function benchmark() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];

	return $mtime;
}

/**
 * Verifie qu'il n'y a aucun code HTML dans la variable $secvalue.
 */
function check_getvalue($secvalue) {
	if (!is_array($secvalue)) {
		if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*object*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*iframe*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*applet*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*meta*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*form*\"?[^>]*>/i", $secvalue)) ||
		(preg_match("/<[^>]*img*\"?[^>]*>/i", $secvalue)) /*||
		(preg_match("/\([^>]*\"?[^)]*\)/i", $secvalue))  ||
		(preg_match("/\"/", $secvalue))*/) return false;
	} else {
		foreach ($secvalue as $subsecvalue) {
			if (!check_getvalue($subsecvalue)) return false;
		}
	}
	return true;
}

/**
 * Verifie qu'il n'y a aucun code HTML dans la variable $secvalue.
 */
function check_postvalue($secvalue) {
	if (!is_array($secvalue)) {
		if ((preg_match("/<[^>]*script*\"?[^>]*>/i", $secvalue)) || (preg_match("/<[^>]*style*\"?[^>]*>/i", $secvalue))) return false;
	} else {
		foreach ($secvalue as $subsecvalue) {
			if (!check_postvalue($subsecvalue)) return false;
		}
	}
	return true;
}

/**
 * Formate une chaine pour un affichage en tooltip
 */
function TipFormat($chaine){
//	$chaine=stripslashes(stripslashes($chaine));
	$chaine = CheckForTranslate($chaine);
	$chaine = str_replace("\r\n",'',$chaine);
	$chaine = str_replace("\n",'',$chaine);
//	$chaine = str_replace('"','&quot;',$chaine);
//	$chaine = str_replace('\'','\'',$chaine);
	$chaine = htmlentities($chaine, ENT_QUOTES);
	$chaine = trim($chaine);
	return $chaine;
}

/**
 * Formatage de la réponse Ajax
 */
if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}
?>
