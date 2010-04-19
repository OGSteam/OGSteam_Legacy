<?php



/**
* Ecriture de texte dans un fichier
* @param string $file Nom du fichier
* @param string $mode Mode d'ouverture
* @param mixed $text texte ou tableau de texte a �crire
* @return bool true si succ�s, false sinon
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
* Ecriture de texte dans un fichier compress�
* @param string $file Nom du fichier
* @param string $mode Mode d'ouverture
* @param mixed $text texte ou tableau de texte a �crire
* @return bool true si succ�s, false sinon
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
* Transforme une ip de la notation decimale en hexadecimale
* @param string $ip L'ip en entr�e sous la forme '192.168.0.1'
* @return string Encodage hexadecimale sous la forme 'B0AA0001'
*/

function encode_ip($ip) {
	$ip_sep = explode('.', $ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
}
/**
* Transforme une ip de la notation hexadecimale en deecimal
* @param string $ip L'ip en entr�e sous la forme 'B0AA0001'
* @return string DesEncodage decimal sous la forme '192.168.0.1'
*/

function decode_ip($ip_encode) {
	$hexipbang = explode('.', chunk_split($ip_encode, 2, '.'));
	return hexdec($hexipbang[0]). '.' . hexdec($hexipbang[1]) . '.' . hexdec($hexipbang[2]) . '.' . hexdec($hexipbang[3]);
}

/**
* G�n�ration d'un mot de passe al�atoire de 6 caract�res de long
* @return string Le mot de passe al�atoire
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
 * Verifie et met a jour la table des options � partir du formulaire admin
 * Les donn�es sont prises � partir des valeurs get/post
 */
function set_serverconfig() {
	global $db, $user_data;
	global $pub_max_battlereport, $pub_max_favorites, $pub_max_favorites_spy, $pub_max_spyreport, $pub_server_active ,$pub_session_time, $pub_max_keeplog, $pub_default_skin,
	$pub_debug_log, $pub_reason, $pub_ally_protection, $pub_url_forum, $pub_max_keeprank, $pub_keeprank_criterion, $pub_max_keepspyreport, $pub_servername,
	$pub_allied, $pub_disable_ip_check, $pub_language, $pub_timeshift,$pub_default_login_page;

	if (!check_var($pub_max_battlereport, "Num") || !check_var($pub_max_favorites, "Num") || !check_var($pub_max_favorites_spy, "Num") ||
	!check_var($pub_max_spyreport, "Num") || !check_var($pub_server_active, "Num") || !check_var($pub_session_time, "Num") ||
	!check_var($pub_max_keeplog, "Num") || !check_var($pub_default_skin, "URL") || !check_var($pub_debug_log, "Num") ||
	!check_var(stripslashes($pub_reason), "Text") || !check_var($pub_ally_protection, "Special", "#^[\w\s,\.\-]+$#") || !check_var($pub_url_forum, "URL") ||
	!check_var($pub_max_keeprank, "Num") || !check_var($pub_keeprank_criterion, "Char") || !check_var($pub_max_keepspyreport, "Num") ||
	!check_var(stripslashes($pub_servername), "Text") || !check_var($pub_allied, "Special", "#^[\w\s,\.\-]+$#") 
	|| !check_var($pub_disable_ip_check, "Num") 
	|| !check_var($pub_language,"Text")
	|| !check_var($pub_timeshift,"Text")
	|| !check_var($pub_default_login_page,"Text") )	{
		//redirection("index.php?action=message&id_message=errordata&info");
	}

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
		redirection("planetindex.php?action=message&id_message=forbidden&info");
	}

	if (!isset($pub_max_battlereport) || !isset($pub_max_favorites) || !isset($pub_max_favorites_spy) || !isset($pub_max_spyreport) ||
	!isset($pub_session_time) || !isset($pub_max_keeplog) || !isset($pub_default_skin) || !isset($pub_reason) ||
	!isset($pub_ally_protection) || !isset($pub_url_forum) || !isset($pub_max_keeprank) || !isset($pub_keeprank_criterion) ||
	!isset($pub_max_keepspyreport) || !isset($pub_servername) || !isset($pub_allied) || !isset($pub_language) || !isset($pub_timeshift)) {
		//redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
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


	if ($break) {
		redirection("index.php?action=message&id_message=setting_serverconfig_failed&info");
	}

	//Page de login par defaut
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_default_login_page."' where config_name = 'default_login_page'";
	$db->sql_query($request);

	//decalage horaire
	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_timeshift."' where config_name = 'timeshift'";
	$db->sql_query($request);
	//
	//language
		$request = "update ".TABLE_CONFIG." set config_value = '".$pub_language."' where config_name = 'language'";
	$db->sql_query($request);
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

	
	$request = "update ".TABLE_CONFIG." set config_value = ".$pub_disable_ip_check." where config_name = 'disable_ip_check'";
	$db->sql_query($request);


	log_("set_serverconfig");
	redirection("index.php?action=administration&subaction=parameter");
}

/**
* Optimisation des tables OGSpy de Mysql
* Attention : les autres tables (dont celles des mods...) ne sont pas optimis�s
* @param bool $maintenance_action apparemment non utilis�
*/
function db_optimize($maintenance_action = false) {
	global $db;

	$dbSize_before = db_size_info();
	$dbSize_before = $dbSize_before["Total"];

	$request = "OPTIMIZE TABLE ".TABLE_CONFIG." , ".TABLE_GROUP." , ".TABLE_MOD." , ";
	$request .= TABLE_RANK_PLAYER_FLEET." , ".TABLE_RANK_PLAYER_POINTS." , ".TABLE_RANK_PLAYER_RESEARCH." , ";
	$request .= TABLE_RANK_ALLY_FLEET." , ".TABLE_RANK_ALLY_POINTS." , ".TABLE_RANK_ALLY_RESEARCH." , ";
	$request .= TABLE_SESSIONS." , ".TABLE_SPY." , ".TABLE_STATISTIC." , ".TABLE_UNIVERSE." , ";
	$request .= TABLE_USER." , ".TABLE_USER_BUILDING." , ".TABLE_USER_DEFENCE." , ".TABLE_USER_FAVORITE." , ".TABLE_USER_GROUP." , ".TABLE_USER_SPY." , ".TABLE_USER_TECHNOLOGY;
	
	$db->sql_query($request);

	$dbSize_after = db_size_info();
	$dbSize_after = $dbSize_after["Total"];

	if (!$maintenance_action) {
		redirection("index.php?action=message&id_message=db_optimize&info=".$dbSize_before."�".$dbSize_after);
	}
}

/**
* Analyse de la taille des fichiers logs
* @return array Tableau a 2 entr�es avec la taille et son unit�
*/

function log_size_info() {
	$logSize = 0;
	$res = opendir(PATH_LOG);
	$directory = array();
	//R�cup�ration de la liste des fichiers pr�sents dans les r�pertoires r�pertori�s
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
		//R�cup�ration de la liste des fichiers pr�sents dans les r�pertoires r�pertori�s
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

/**
 * Verifie l'existence d'un fichier log pour une date donn�e
 * @param string Date sous forme AAMMJJ (Ann�e/Mois/Jour)
 * @return boolean
 */
function log_check_exist($date) {
	if (!isset($date))
	redirection("index.php?action=message&id_message=errorfatal&info");

	require_once('library/zip.lib.php');

	$typelog = array("sql", "log", "txt");

	$root = PATH_LOG;
	$path = opendir("$root");

	//R�cup�ration de la liste des r�pertoires correspondant � cette date
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
/**
* Recup�re les log d'une date donn�e ($pub_date)
* @return mixed Archive compress� du log de la date donn�e
*/

/**
 * Cr�e un fichier ZIP on the fly contenant les log d'un jour donn�e
 * @global $pub_date la date des logs voulu
 */
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

	//R�cup�ration de la liste des r�pertoires correspondant � cette date
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

	// cr�ation d'un objet 'zipfile'
	$zip = new zipfile();
	foreach ($files as $filename) {
		// contenu du fichier
		$fp = fopen ($root.$filename, 'r');
		$content = @fread($fp, @filesize($root.$filename));
		fclose ($fp);

		// ajout du fichier dans cet objet
		$zip->addfile($content, $filename);
		// production de l'archive' Zip
		$archive = $zip->file();
	}

	// ent�tes HTTP
	header('Content-Type: application/x-zip');
	// force le t�l�chargement
	header('Content-Disposition: inline; filename=log_'.$pub_date.'.zip');

	// envoi du fichier au navigateur
	echo $archive;
}

/**
* Suppression des logs selon la configuration
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

/**
 * formate un nombre
 * TODO: Attention... ca formate � la fran�aise cette fonction...
 */
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
/**
* Verification des donn�es envoy�s par l'utilisateur
* @return bool true si correct 
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
		if (!preg_match("#^[\w\s\-]{6,15}$#", $value)) {
			return false;
		}
		break;

		//Cha�ne de caract�res avec espace
		case "Text" :
		if (!preg_match("#^[\w'\s\.\*\-]+$#", $value)) {
			log_("check_var", array("Text", $value));
			return false;
		}
		break;

		//Cha�ne de caract�res et  chiffre
		case "CharNum" :
		if (!preg_match("#^[\w\.\*\-]+$#", $value)) {
			log_("check_var", array("CharNum", $value));
			return false;
		}
		break;

		//Caract�res
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
		if (!preg_match("#^(((?:http?)://)?(?(2)(www\.)?|(www\.){1})[-a-z0-9~_]{2,}\.[-a-z0-9~._]{2,}[-a-z0-9~_\/&\?=.]{2,})$#i", $value)) {
			log_("check_var", array("URL", $value));
			return false;
		}
		break;

		//Plan�te, Joueur et alliance
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

		//Masque param�trable
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
* Liste des repertoires/fichiers selon un pattern donn�
*/
//safe_glob() by BigueNique at yahoo dot ca
//Function glob() is prohibited on some servers for security reasons as stated on:
//http://seclists.org/fulldisclosure/2005/Sep/0001.html
//(Message "Warning: glob() has been disabled for security reasons in (script) on line (line)")
//safe_glob() intends to replace glob() for simple applications
//using readdir() & fnmatch() instead.
//Since fnmatch() is not available on Windows or other non-POSFIX, I rely
//on soywiz at php dot net fnmatch clone.
//On the final hand, safe_glob() supports basic wildcards on one directory.
//Supported flags: GLOB_MARK. GLOB_NOSORT, GLOB_ONLYDIR
//Return false if path doesn't exist, and an empty array is no file matches the pattern
function safe_glob($pattern, $flags=0) {
   $split=explode('/',$pattern);
   $match=array_pop($split);
   $path=implode('/',$split);
   if (($dir=opendir($path))!==false) {
       $glob=array();
       while(($file=readdir($dir))!==false) {
           if (fnmatch($match,$file)) {
               if ((is_dir("$path/$file"))||(!($flags&GLOB_ONLYDIR))) {
                   if ($flags&GLOB_MARK) $file.='/';
                   $glob[]=$file;
               }
           }
       }
       closedir($dir);
       if (!($flags&GLOB_NOSORT)) sort($glob);
       return $glob;
   } else {
       return false;
   }
}

//thanks to soywiz for the following function, posted on http://php.net/fnmatch
//soywiz at php dot net
//17-Jul-2006 10:12
//A better "fnmatch" alternative for windows that converts a fnmatch pattern into a preg one. It should work on PHP >= 4.0.0
if (!function_exists('fnmatch')) {
   function fnmatch($pattern, $string) {
       return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
   }
}

/**
* Liste des langages install�s
* @param string $prefix "../" quand utilis� dans install.php pour avoir les langages globaux
* @return array une entr�e par langage avec ["name"] nom du langage, ["mainfile"] path du fichier , ["flag"] drapeau langage si existe
*/

function languages_info($prefix=''){
        $retval=Array();
        $langdir=safe_glob($prefix."language/lang_*",GLOB_ONLYDIR);
        foreach($langdir as $value){
                if (ereg("lang_(.*)",$value,$regs)){
                        $retval[$value]["name"]=$regs[1];
                        $retval[$value]["mainfile"]=$prefix."language/lang_".$regs[1]."/lang_main.php";
                        if (is_readable($prefix."images/flag_".$regs[1].".gif")){
                                $retval[$value]["flag"]=$prefix."images/flag_".$regs[1].".gif";
                        }elseif (is_readable("../images/flag_".$regs[1].".gif")){
                                $retval[$value]["flag"]="../images/flag_".$regs[1].".gif";
                        }
                }
        }
        return $retval;
}

function session_begin($user_ip) {
	global $db, $cookie_id, $server_config;

	$cookie_name = COOKIE_NAME;
	$cookie_time = $server_config["session_time"];
	$cookie_id = md5(uniqid(mt_rand(), true));

	$cookie_expire = time()+$cookie_time*60;

	if (strstr($_SERVER['HTTP_USER_AGENT'],"OGSClient") === false) {
		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");
	}
	else {
		$request = "delete from ".TABLE_SESSIONS." where session_ip = '".$user_ip."' and session_ogs = '1'";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");

		$request = "insert into ".TABLE_SESSIONS." (session_id, session_user_id, session_start, session_expire, session_ip, session_ogs) values (";
		$request .="'".$cookie_id."', 0, ".time().", ".$cookie_expire.", '".$user_ip."', '1')";
		$db->sql_query($request, true, false) or die("Impossible d'initialiser la sessions");
	}

	setcookie($cookie_name, $cookie_id, 0);
}

function session() {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS, $link_css;

	$cookie_id = "";
	$cookie_name = COOKIE_NAME;
	$cookie_time = $server_config["session_time"];

	//Purge des sessions expir�e
	if ($server_config["session_time"] != 0) {
		$request = "delete from ".TABLE_SESSIONS." where session_expire < ".time();
		$db->sql_query($request, true, false);
	}

	$link_css = $server_config["default_skin"];

	//R�cup�ration de l'id de session si cookie pr�sent
	if (isset($HTTP_COOKIE_VARS[$cookie_name])) {
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		//V�rification de la validit� de le session
		$request = "select session_id from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'".
		" and session_ip = '".$user_ip."'";
		$result = $db->sql_query($request);

		if ($db->sql_numrows($result) != 1) {
			if ($server_config["disable_ip_check"] == 1) {
				//Mise � jour de l'adresse ip de session si le controle des ip est d�sactiv�
				$request = "select session_id from ".TABLE_SESSIONS." left join ".TABLE_USER.
				" on session_user_id = user_id".
				" where session_id = '".$cookie_id."'".
				" and disable_ip_check = '1'";
				$result = $db->sql_query($request);

				if ($db->sql_numrows($result) > 0) {
					$request = "update ".TABLE_SESSIONS." set session_ip = '".$user_ip."' where session_id = '".$cookie_id."'";
					$db->sql_query($request, true, false);
				}
				else {
					$cookie_id = "";
				}
			}
			else {
				$cookie_id = "";

			}
		}
	}

	if ($cookie_id == "") {
		session_begin($user_ip);
	}
	else {
		$cookie_expire = time()+$cookie_time*60;
		$request = "update ".TABLE_SESSIONS." set session_expire = ".$cookie_expire." where session_id = '".$cookie_id."'";
		$db->sql_query($request, true, false);
	}

	session_set_user_data($cookie_id);
}

function session_set_user_id($user_id, $lastvisit=0) {
	global $db, $user_ip, $cookie_id, $server_config;
	global $HTTP_COOKIE_VARS;

	//Purge des sessions expir�e
	if ($server_config["session_time"] == 0) {
		$request = "select session_ogs from ".TABLE_SESSIONS." where session_id = '".$cookie_id."'";
		$result = $db->sql_query($request);
		while (list($session_ogs) = $db->sql_fetch_row($result)) {
			$request = "delete from ".TABLE_SESSIONS." where session_user_id = ".$user_id." and session_ogs = '".$session_ogs."'";
			$db->sql_query($request);
		}
	}

	$request = "update ".TABLE_SESSIONS." set session_user_id = ".$user_id.
	", session_lastvisit = ".$lastvisit.
	" where session_id = '".$cookie_id."'".
	" and session_ip = '".$user_ip."'";
	$db->sql_query($request);

	session_set_user_data($cookie_id);
}

function session_set_user_data() {
	global $db, $user_ip, $user_data, $user_auth, $cookie_id, $server_config;
	global $link_css;

	if (preg_match("#^0.300([b-f])?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_galaxy, user_system, user_skin";
	}
	elseif (preg_match("#^0.301(b)?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_galaxy, user_system, user_skin, session_lastvisit";
	}
	elseif (preg_match("#^3.02(b)?$#", $server_config["version"])) {
		$request = "select user_id, user_name, user_admin, user_coadmin, user_galaxy, user_system, user_skin, session_lastvisit, user_stat_name, ";
		$request .= "management_user, management_ranking";
	}
	else {
		$request = "select user_id, user_name, user_admin, user_coadmin, user_galaxy, user_system, user_skin, session_lastvisit, user_stat_name, ";
		$request .= "management_user, management_ranking, disable_ip_check";
	}

	$request .= " from ".TABLE_USER." u, ".TABLE_SESSIONS." s";
	$request .= " where u.user_id = s.session_user_id";
	$request .= " and session_id = '".$cookie_id."'";
	$request .= " and session_ip = '".$user_ip."'";
	$result = $db->sql_query($request);

	if ($db->sql_numrows($result) == 1) {
		$user_data = $db->sql_fetch_assoc($result);
		if ($user_data["user_skin"] != "") $link_css = $user_data["user_skin"];
		else $link_css = $server_config["default_skin"];

		if (preg_match("#^3.02(.*)?$#", $server_config["version"])) {
			$user_auth = user_get_auth($user_data["user_id"]);
		}
	}
	else {
		unset($user_data);
		unset($user_auth);
	}
}

function session_close($user_id = false) {
	global $db, $user_ip, $cookie_id;

	if (!$user_id) {
		global $HTTP_COOKIE_VARS;

		$cookie_name = COOKIE_NAME;
		$cookie_id = $HTTP_COOKIE_VARS[$cookie_name];

		$request = "delete from ".TABLE_SESSIONS.
		" where session_id = '".$cookie_id."'".
		" and session_ip = '".$user_ip."'";
		$db->sql_query($request, true, false);
	}
	else {
		$request = "delete from ".TABLE_SESSIONS.
		" where session_user_id = ".$user_id;
		$db->sql_query($request, true, false);
	}
}

function session_whois_online() {
	global $db, $server_config;

	$cookie_time = $server_config["session_time"];

	$request = "select user_name, session_start, session_expire, session_ip, session_ogs";
	$request .= " from ".TABLE_SESSIONS." left join ".TABLE_USER;
	$request .= " on session_user_id = user_id";
	$request .= " order by user_name";
	$result = $db->sql_query($request);

	$guests = $members = array();
	while (list($user_name, $session_start, $session_expire, $session_ip, $session_ogs) = $db->sql_fetch_row($result)) {
		$time_lastactivity = $session_expire - $cookie_time*60;
		$session_ip = decode_ip($session_ip);

		if (is_null($user_name)) {
			$user_name = "Visiteur non identifi�";
			$guests[] = array("user" => $user_name, "time_start" => $session_start, "time_lastactivity" => $time_lastactivity, "ip" => $session_ip, "ogs" => 0);
		}
		else {
			$members[] = array("user" => $user_name, "time_start" => $session_start, "time_lastactivity" => $time_lastactivity, "ip" => $session_ip, "ogs" => $session_ogs);
		}
	}
	$online = array_merge($members, $guests);

	return $online;
}

?>
