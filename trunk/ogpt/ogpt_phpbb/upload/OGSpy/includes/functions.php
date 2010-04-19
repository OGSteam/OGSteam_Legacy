<?php
/***************************************************************************
*	filename	: fonctions.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 15/11/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

function redirection($url){
	if (headers_sent()) {
		die('<meta http-equiv="refresh" content="0; URL='.$url.'">');
	} else {
		header("Location: ".$url);
		exit();
	}
}

function write_file($file, $mode, $text) {
	if ($fp = @fopen($file, $mode)) {
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

function encode_ip($ip) {
	$ip_sep = explode('.', $ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}

function decode_ip($ip_encode) {
	$hexipbang = explode('.', chunk_split($ip_encode, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

function password_generator() {
	$string = "abBDEFcdefghijkmnPQRSTUVWXYpqrst23456789";
	srand((double)microtime()*1000000);
	$password = '';
	for($i=0; $i<6; $i++) {
		$password .= $string[rand()%strlen($string)];
	}
	return $password;
}

function init_serverconfig() {
	global $db, $server_config;

	$request = "select * from ".TABLE_CONFIG;
	$result = $db->sql_query($request);

	while (list($name, $value) = $db->sql_fetch_row($result)) {
		$server_config[$name] = stripslashes($value);
	}
}

function set_serverconfig() {
	global $db, $user_data;
	global $pub_max_battlereport, $pub_max_favorites, $pub_max_favorites_spy, $pub_max_spyreport, $pub_server_active ,$pub_session_time, $pub_max_keeplog, $pub_default_skin,
	$pub_debug_log, $pub_reason, $pub_ally_protection, $pub_url_forum, $pub_max_keeprank, $pub_keeprank_criterion, $pub_max_keepspyreport, $pub_servername,
	$pub_allied, $pub_disable_ip_check;

	if (!check_var($pub_max_battlereport, "Num") || !check_var($pub_max_favorites, "Num") || !check_var($pub_max_favorites_spy, "Num") ||
	!check_var($pub_max_spyreport, "Num") || !check_var($pub_server_active, "Num") || !check_var($pub_session_time, "Num") ||
	!check_var($pub_max_keeplog, "Num") || !check_var($pub_default_skin, "URL") || !check_var($pub_debug_log, "Num") ||
	!check_var(stripslashes($pub_reason), "Text") || !check_var($pub_ally_protection, "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_url_forum, "URL") ||
	!check_var($pub_max_keeprank, "Num") || !check_var($pub_keeprank_criterion, "Char") || !check_var($pub_max_keepspyreport, "Num") ||
	!check_var(stripslashes($pub_servername), "Text") || !check_var($pub_allied, "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_disable_ip_check, "Num") ) {
		redirection("index.php?action=message&id_message=errordata&info");
	}

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
		redirection("planetindex.php?action=message&id_message=forbidden&info");
	}

	if (!isset($pub_max_battlereport) || !isset($pub_max_favorites) || !isset($pub_max_favorites_spy) || !isset($pub_max_spyreport) ||
	!isset($pub_session_time) || !isset($pub_max_keeplog) || !isset($pub_default_skin) || !isset($pub_reason) ||
	!isset($pub_ally_protection) || !isset($pub_url_forum) || !isset($pub_max_keeprank) || !isset($pub_keeprank_criterion) ||
	!isset($pub_max_keepspyreport) || !isset($pub_servername) || !isset($pub_allied)) {
		redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
	}
	
	if (is_null($pub_server_active)) $pub_server_active = 0;
	if (is_null($pub_disable_ip_check)) $pub_disable_ip_check = 0;
	if (is_null($pub_debug_log)) $pub_debug_log = 0;

	$break = false;


	if ($pub_server_active != 0 && $pub_server_active != 1) $break = true;
	if ($pub_debug_log != 0 && $pub_debug_log != 1) $break = true;
	if (!is_numeric($pub_max_favorites)) $break = true;
	if (!is_numeric($pub_max_favorites_spy)) $break = true;
	if (!is_numeric($pub_max_spyreport)) $break = true;
	if (!is_numeric($pub_max_battlereport)) $break = true;
	if (!is_numeric($pub_session_time)) $break = true;
	if (!is_numeric($pub_max_keeplog)) $break = true;
	if ($pub_disable_ip_check != 0 && $pub_disable_ip_check != 1) $break = true;

	if ($break) {
		redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
	}

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_server_active." where config_name = 'server_active'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_debug_log." where config_name = 'debug_log'";
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
	if (substr($pub_allied, strlen($pub_allied)-1) == ",") $pub_allied = substr($pub_allied, 0, strlen($pub_allied)-1);
	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_real_escape_string($pub_allied)."' where config_name = 'allied'";
	$db->sql_query($request);

	//
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_disable_ip_check." where config_name = 'disable_ip_check'";
	$db->sql_query($request);


	log_("set_serverconfig");
	redirection("index.php?action=administration&subaction=parameter");
}

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

	$bytes = array('Octets', 'Ko', 'Mo', 'Go', 'To');

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

function db_optimize($maintenance_action = false) {
	global $db;

	$dbSize_before = db_size_info();
	$dbSize_before = $dbSize_before["Total"];

	$request = "OPTIMIZE TABLE ".TABLE_CONFIG." , ".TABLE_GROUP." , ".TABLE_MOD." , ";
	$request .= TABLE_RANK_PLAYER_FLEET." , ".TABLE_RANK_PLAYER_POINTS." , ".TABLE_RANK_PLAYER_RESEARCH." , ";
	$request .= TABLE_RANK_ALLY_FLEET." , ".TABLE_RANK_ALLY_POINTS." , ".TABLE_RANK_ALLY_RESEARCH." , ";
	$request .= TABLE_SESSIONS." , ".TABLE_SPY." , ".TABLE_STATISTIC." , ".TABLE_UNIVERSE." , ";
	$request .= TABLE_USER." , ".TABLE_USER_BUILDING." , ".TABLE_USER_DEFENCE." , ".TABLE_USER_FAVORITE." , ".TABLE_USER_SPY." , ".TABLE_USER_TECHNOLOGY;
	
	$db->sql_query($request);

	$dbSize_after = db_size_info();
	$dbSize_after = $dbSize_after["Total"];

	if (!$maintenance_action) {
		redirection("index.php?action=message&id_message=db_optimize&info=".$dbSize_before."¤".$dbSize_after);
	}
}

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

	$bytes = array('Octets', 'Ko', 'Mo', 'Go', 'To');

	if ($logSize < 1024) $logSize = 1;

	for ($i = 0; $logSize > 1024; $i++)
	$logSize /= 1024;

	$log_size_info['size'] = round($logSize, 2);
	$log_size_info['type'] = $bytes[$i];

	return $log_size_info;
}

function log_check_exist($date) {
	if (!isset($date))
	redirection("index.php?action=message&id_message=errorfatal&info");

	require_once('library/zip.lib.php');

	$typelog = array("sql", "log", "txt");

	$root = PATH_LOG;
	$path = opendir("$root");

	//Récupération de la liste des répertoires correspondant à cette date
	while($file = readdir($path)) {
		if($file != "." && $file != "..") {
			if (is_dir($root.$file) && preg_match("/^".$date."/", $file)) $directories[] = $file;
		}
	}
	closedir($path);

	if (!isset($directories)) {
		return false;
	}

	foreach ($directories as $d) {
		$path = opendir($root.$d);

		while($file = readdir($path)) {
			if($file != "." && $file != "..") {
				$extension = substr($file, (strrpos($file, ".")+1));
				if (in_array($extension, $typelog)) {
					$files[] = $d."/".$file;
				}
			}
		}
		closedir($path);
	}

	if (!isset($files)) {
		return false;
	}

	return true;
}

function log_extractor() {
	global $pub_date, $user_data;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
		redirection("index.php?action=message&id_message=forbidden&info");
	}

	if (!isset($pub_date))
	redirection("index.php?action=message&id_message=errorfatal&info");

	require_once('library/zip.lib.php');

	$typelog = array("sql", "log", "txt");

	$root = PATH_LOG;
	$path = opendir("$root");

	//Récupération de la liste des répertoires correspondant à cette date
	while($file = readdir($path)) {
		if($file != "." && $file != "..") {
			if (is_dir($root.$file) && preg_match("/^".$pub_date."/", $file)) $directories[] = $file;
		}
	}
	closedir($path);

	if (!isset($directories)) {
		redirection("index.php?action=message&id_message=log_missing&info");
	}

	foreach ($directories as $d) {
		$path = opendir($root.$d);

		while($file = readdir($path)) {
			if($file != "." && $file != "..") {
				$extension = substr($file, (strrpos($file, ".")+1));
				if (in_array($extension, $typelog)) {
					$files[] = $d."/".$file;
				}
			}
		}
		closedir($path);
	}

	if (!isset($files)) {
		redirection("index.php?action=message&id_message=log_missing&info");
	}

	// création d'un objet 'zipfile'
	$zip = new zipfile();
	foreach ($files as $filename) {
		// contenu du fichier
		$fp = fopen ($root.$filename, 'r');
		$content = @fread($fp, @filesize($root.$filename));
		fclose ($fp);

		// ajout du fichier dans cet objet
		$zip->addfile($content, $filename);
		// production de l'archive Zip
		$archive = $zip->file();
	}

	// entêtes HTTP
	header('Content-Type: application/x-zip');
	// force le téléchargement
	header('Content-Disposition: inline; filename=log_'.$pub_date.'.zip');

	// envoi du fichier au navigateur
	echo $archive;
}

function log_purge() {
	global $server_config;

	$time = $server_config["max_keeplog"];
	$limit = time()-(60*60*24*$time);
	$limit = intval(date("ymd", $limit));

	$root = PATH_LOG;
	$path = opendir("$root");
	while($file = readdir($path)) {
		if($file != "." && $file != "..") {
			if (is_dir($root.$file) && intval($file) < $limit) {
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

function formate_number($number, $decimal = 0) {
	return number_format($number, $decimal, ",", " ");
}

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
		if (!preg_match("#^[\w\s\-]{6,15}$#", $value)) {
			return false;
		}
		break;

		//Chaîne de caractères avec espace
		case "Text" :
		if (!preg_match("#^[\w'\s\.\*\-]+$#", $value)) {
			log_("check_var", array("Text", $value));
			return false;
		}
		break;

		//Chaîne de caractères et chiffre
		case "CharNum" :
		if (!preg_match("#^[\w\.\*\-]+$#", $value)) {
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

		//Chiffres
		case "Num" :
		if (!preg_match("#^[[:digit:]]+$#", $value)) {
			log_("check_var", array("Num", $value));
			return false;
		}
		break;

		//Adresse internet
		case "URL":
		// suppression des espaces dans l'url, pour la regex
		// on met le résultat dans une autre variable, car on a besoin de la valeur réelle plus loin
		$tmp_test = str_replace(array(' ','%20'),'',$value);
		if (!preg_match("#^((?:https?://)?[-a-z0-9~_]{2,}[-a-z0-9~._]*[-a-z0-9~_\/&\?=.]{2,})$#i", $tmp_test)) {
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

function benchmark() {
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];

	return $mtime;
}
?>
