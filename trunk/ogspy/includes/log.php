<?php
/** $Id$ **/ 
/** 
*  Fichier de log
* @package OGSpy 
* @subpackage main 
* @author Kyser 
* @copyright Copyright &copy; 2007, http://ogsteam.fr/ 
* @version 4.00 ($Rev$) 
* @modified $Date$ 
* @link $HeadURL$ 
*/ 
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

global $ogspy_phperror;
$ogspy_phperror=Array();
/**
* Entrée dans le journal d'une ligne d'information
* @param string $parameter type d'information
* @param mixed $option Données optionnelles
*/
function log_ ($parameter, $option=0) {
	global $db, $user_data, $server_config,$pub_action,$ogspy_langue;

	$member = "Inconnu";
	if (isset($user_data)) {
		$member = $user_data["user_name"];
	}

	switch ($parameter) {
		/* ----------- Entrée Journal générique de Mod ----------- */		
		case 'mod':
		$line = "[$pub_action] ".$member." ";
		if (is_array($option)) {
			$line .= print_r($option,true);
		}else {
			$line .= $option;
		}
		break;

		/* ----------- Administration ----------- */		
		case 'set_serverconfig' :
		$line = L_("inclog_paramserv", $member );
		break;
		
		case 'set_server_view' :
		$line = L_("inclog_paramdisplayserv", $member );
		break;
    
		case 'set_db_size' :
		$line = L_("inclog_changesizegala", $member, $server_config['num_of_galaxies'], $server_config['num_of_systems'] );
		break;
		
		case 'mod_install' :
		$line = L_("inclog_InstallMod", $member , $option );
		break;
		
		case 'mod_update' :
		$line = L_("inclog_UpdateMod", $member , $option );
		break;
		
		case 'mod_uninstall' :
		$line = L_("inclog_RemoveMod", $member , $option );
		break;
		
		case 'mod_active' :
		$line = L_("inclog_OnMod", $member , $option );
		break;
		
		case 'mod_disable' :
		$line = L_("inclog_OffMod", $member , $option );
		break;
		
		case 'mod_order' :
		$line = L_("inclog_RepoMod", $member , $option );
		break;

		case 'mod_normal' :
		$line = L_("inclog_DisplayMod", $member , $option );
		break;

		case 'mod_admin' :
		$line = L_("inclog_HideMod", $member , $option );
		break;
		
		case "mod_rename" :
		$line = L_("inclog_Mod_Rename" , $member, $option );
		break;

		case "mod_admin_link" :
		$line = L_("inclog_Mod_admin_link" , $member, $option );
		break;

		case "cat_add_mod" :
		$line = L_("inclog_Cat_AddMod" , $member, $option[0], $option[1] );
		break;

		case "cat_rem_mod" :
		$line = L_("inclog_Cat_RemMod" , $member, $option );
		break;

		case "cat_remove" :
		$line = L_("inclog_Cat_Delete" , $member, $option );
		break;

		case "cat_order" :
		$line = L_("inclog_Cat_Order" , $member, $option );
		break;

		case "cat_create" :
		$line = L_("inclog_Cat_Create" , $member, $option );
		break;

		case "cat_rename" :
		$line = L_("inclog_Cat_Rename" , $member, $option );
		break;


		/* ----------- Gestion systèmes solaires et rapports ----------- */
		case 'load_system' :
		$line = L_("inclog_LoadSysSol", $member , $option[0].":".$option[1] );
		break;

		case 'load_system_OGS' :
		$line = L_("inclog_load_system_OGS", $member, $option[0], $option[1], $option[2], $option[3], $option[4], $option[5] );
		break;

		case 'get_system_OGS' :
		if ($option != 0) $line = L_("inclog_get_galaxy_OGS", $member, $option );
		else $line = L_("inclog_get_universe_OGS", $member );
		break;

		case 'load_spy' :
		$line = L_("inclog_load_spy", $member, $option );
		break;

		case 'load_rc' :
		$line = L_("inclog_load_rc", $member, $option );
		break;

		case 'delete_rc' :
		$line = L_("inclog_delete_rc", $member, $option );
		break;

		case 'load_spy_OGS' :
		$line = L_("inclog_load_spy_OGS", $member, $option );
		break;

		case 'export_spy_sector' :
		$line = L_("inclog_export_spy_sector", $member, $option[0], $option[1].":".$option[2] );
		break;

		case 'export_spy_date' :
		$line = L_("inclog_export_spy_date", $member, $option[0], L_("date_strftime_1", $option[1] ) );
		break;

		/* ----------- Gestion des erreurs ----------- */
		case 'mysql_error' :
		$line = L_("inclog_mysql_error", $option[0], $option[1], $option[2] );
		$i=0;
		foreach ($option[3] as $l) {
			$line .= "\n";
			$line .= "\t".'['.$i.']'."\n";
			$line .= "\t\t".'file => '.$l['file']."\n";
			$line .= "\t\t".'line => '.$l['line']."\n";
			$line .= "\t\t".'function => '.$l['function'];
			$j=0;
			if (isset($l['args'])) {
				foreach ($l['args'] as $arg) {
					$line .= "\n";
					$line .= "\t\t\t".'['.$j.'] => '.$arg;
					$j++;

				}
			}
			$i++;
		}
		break;

		/* ----------- Gestion des membres ----------- */
		case 'login' :
		$line = L_("inclog_login", $member );
		break;

		case 'login_ogs' :
		$line = L_("inclog_login_ogs", $member );
		break;

		case 'logout' :
		$line = L_("inclog_logout", $member );
		break;

		case 'modify_account' :
		$line = L_("inclog_modify_account", $member );
		break;

		case 'modify_account_admin' :
		$user_info = user_get($option);
		$line = L_("inclog_modify_account_admin", $member, $user_info[0]['user_name'] );
		break;

		case 'create_account' :
		$user_info = user_get($option);
		$line = L_("inclog_create_account", $member, $user_info[0]['user_name'] );
		break;

		case 'regeneratepwd' :
		$user_info = user_get($option);
		$line = L_("inclog_regeneratepwd", $member, $user_info[0]['user_name'] );
		break;

		case 'delete_account' :
		$user_info = user_get($option);
		$line = L_("inclog_delete_account", $member, $user_info[0]['user_name'] );
		break;

		case 'create_usergroup' :
		$line = L_("inclog_create_usergroup", $member, $option );
		break;

		case 'modify_usergroup' :
		$usergroup_info = usergroup_get($option);
		$line = L_("inclog_modify_usergroup", $member, $usergroup_info["group_name"] );
		break;

		case 'delete_usergroup' :
		$usergroup_info = usergroup_get($option);
		$line = L_("inclog_delete_usergroup", $member, $usergroup_info["group_name"] );
		break;

		case 'add_usergroup' :
		list($group_id, $user_id) = $option;
		$usergroup_info = usergroup_get($group_id);
		$user_info = user_get($user_id);
		$line = L_("inclog_add_usergroup", $member, $user_info[0]["user_name"], $usergroup_info["group_name"] );
		break;

		case 'del_usergroup' :
		list($group_id, $user_id) = $option;
		$usergroup_info = usergroup_get($group_id);
		$user_info = user_get($user_id);
		$line = L_("inclog_del_usergroup", $member, $user_info[0]["user_name"], $usergroup_info["group_name"] );
		break;

		/* ----------- Classement ----------- */
		case 'load_rank' :
		list($support, $typerank, $typerank2, $timestamp, $countrank) = $option;
		switch ($support) {
			case "OGS": 
			$support = "OGS";
			break;
			
			case "WEB": 
			$support = L_("inclog_WebServ");
			break;
		}
		switch ($typerank) {
			case "general": $typerank = L_("search_General");break;
			case "fleet": $typerank = L_("search_Flotte");break;
			case "research": $typerank = L_("search_Research");break;
		}
		switch($typerank2) {
			case "player": $typerank2 = L_("common_Player");
			case "ally": $typerank2 = L_("common_Ally");
		}
		$line = L_("inclog_sendHighscore", $member, $typerank." ".$typerank2, strftime(L_("date_strftime_2"), $timestamp), $support, $countrank );
		break;

		case 'get_rank' :
		list($typerank, $timestamp) = $option;
		switch ($typerank) {
			case "points": $typerank = L_("search_General");break;
			case "flotte": $typerank = L_("search_Flotte");break;
			case "research": $typerank = L_("search_Research");break;
		}
		$line = L_("inclog_recoverHighscore", $member, $typerank, strftime(L_("date_strftime_2"), $timestamp) );
		break;

		/* ----------------------------------------- */

		case 'check_var' :
		$line = L_("inclog_check_var", $member, $option[0]." - ".$option[1] );
		break;

		case 'debug' :
		$line = 'DEBUG : '.$option;
		break;
		case 'php_error' :
		$line = "[PHP-ERROR] ".$option[0]." - ".$option[1];
		if (isset($option[2])) $line .= "; file => ".$option[2];
		if (isset($option[3])) $line .= "; line => ".$option[3];
		break;
		
		case 'local lang missing' :
		$line = L_('inclog_local_pack_missing',strtoupper($option[0]),$option[1]);
		break;
		
		case 'local file error' :
		$line = L_('inclog_local_file_missing',$option);
		break;
		
		case 'local error' : // Chaine traduite non trouvée. Impossible d'utiliser la fonction L_() car c'est elle qui appel
		if(!isset($ogspy_langue['indexes']["inclog_local_undefined"])||$ogspy_langue['indexes']["inclog_local_undefined"]=="")
			$ogspy_langue['indexes']["inclog_local_undefined"] = "Undefined '%1\$s'. ([%2\$s] [%3\$s] - '%4\$s.php').";
		$line = "[LOCAL ERROR] ".sprintf($ogspy_langue['indexes']["inclog_local_undefined"],$option[0],$option[1],strtoupper($option[2]),$option[3]);
		break;

		default:
		$line = L_("inclog_Err_LogFile").$parameter." - ".print_r($option);
		break;
	}
	
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.htmlentities(html_entity_decode(html_entity_decode($line,ENT_QUOTES),ENT_QUOTES),ENT_QUOTES);
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}
/**
* Error handler PHP : log des erreurs PHP dans la journalisation d'OGSpy
* Optionnellement mise en place dans common.php , si $server_config["no_phperror"] n'est pas flaggé à 1
*/
function ogspy_error_handler($code, $message, $file, $line) {
	global $ogspy_phperror;
	$option=Array($code,$message,$file,$line);
	log_("php_error",Array($code,$message,$file,$line));
	global $user_data;
	if ($user_data["user_admin"]==1) {
		$line = "[PHP-ERROR] ".$option[0]." - ".$option[1];
		if (isset($option[2])) $line .= "; file => ".$option[2];
		if (isset($option[3])) $line .= "; line => ".$option[3];
	if ($option[0]!=8)	$ogspy_phperror[] = $line;
	}
}

/**
 * Renvoi une liste des jours pour lesquels il existe des logs
 */
function get_logs(){
	// Ouverture du dossier de log
	$path = opendir(PATH_LOG);
	
	// Masque des log (nouvelle version et ancienne version)
	$new_folder = "/([0-9]{2})-([0-9]{2})/";
	$old_folder = "/([0-9]{2})([0-9]{2})([0-9]{2})/";
	$file_mask = "/([a-z]{3})_([0-9]{2})([0-9]{2})([0-9]{2}).([a-z]{3})/";
	
	// Lecture du contenu
	while($file = readdir($path)) {
		// recherche d'un nom qui correspond au masque du nouveau type de dossier, et qui est bien un dossier
		if((preg_match($new_folder, $file, $m)||preg_match($old_folder, $file, $m)) && is_dir(PATH_LOG.$file)){
			// On a trouvé un dossier dans le nouveau format.
			$path2 = opendir(PATH_LOG.$file);
			while($file2 = readdir($path2)) {
				$f = PATH_LOG.$file."/".$file2;
				// Recherche d'un nom qui correspond au masque, et qui n'est pas un dossier
				if(preg_match($file_mask, $file2, $m) && !is_dir($f))
					$log_found[] = Array(
						'date' => mktime(0,0,0,$m[3],$m[4],$m[2]),
						'file' => $f,
						'type' => $m[1]
					);
			}
			closedir($path2);
		}
	}
	closedir($path);	
	if(isset($log_found)){
		foreach ($log_found as $key => $row) 
			$date[$key]  = $row['date'];
		array_multisort($date, SORT_ASC, $log_found);
		return $log_found;
	}else
		return false;
}

/**
 * Renvoi le chemin d'un fichier de log pour une date donnée
 */
 function get_log_path($date){

	 $type_log = Array('log','sql');
	 foreach($type_log as $t){
		$new = PATH_LOG.date('y-m',$date)."/".$t."_".date('ymd',$date).".".$t;
		$old = PATH_LOG.date('ymd',$date)."/".$t."_".date('ymd',$date).".".$t;
		if(file_exists($new)) $return[$t][] = $new;
		if(file_exists($old)) $return[$t][] = $old;
	 }
	 return isset($return)?$return:false;	 
 }

 
/*************************************************************************/
 /**
 * Verifie l'existence de log à une date donné
 * @param int $date Date demandé
 * @return boolean 
 * @internal Bien trop compliqué pour une simple vérification d'existence... 
 */
function log_check_exist($date) {
	if (!isset($date))
	redirection("?action=message&id_message=errorfatal&info");

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

/**
 * Envoi d'une archive ZIP au browser d'un log pour une date donné
 * @global array $user_data
 */
function log_extractor($files,$date) {

	require('library/zip.lib.php');
	
	// création d'un objet 'zipfile'
	$zip = new zipfile();
	foreach ($files as $filename) {
		// contenu du fichier
		$fp = fopen ($filename, 'r');
		$content = @fread($fp, @filesize($root.$filename));
		fclose ($fp);
		// Parade contre les noms identique (dans le cas où ils sont dans des dossiers différents
		$f = explode('/',$filename);
		$f = end($f);
		$i = 1;
		while(in_array($f,$f_done)){
			$f = explode('/',$filename);
			$f = end($f);
			$g = explode(".",$f);
			if(sizeOf($g)>1){
				$g[sizeOf($g)-2] .= "_".$i;
				$f = implode('.',$g);
			}else{
				$f .= "_".$i;
			}
			$i++;
		}
		$f_done[] = $f;
		// ajout du fichier dans cet objet
		$zip->addfile($content, $f);
		// production de l'archive Zip
		$archive = $zip->file();
	}

	// entêtes HTTP
	header('Content-Type: application/x-zip');
	// force le téléchargement
	header('Content-Disposition: inline; filename=log_'.$date.'.zip');

	// envoi du fichier au navigateur
	echo $archive;
}

function get_log_files($date,$type) {
	
	if($type=='select_day'){ 
		// Effacement d'un jour
		$new_path = PATH_LOG.date('y-m',$date).'/';
		$old_path = PATH_LOG.date('ymd',$date).'/';
		$mask = '`^[a-z]{3}_'.date('ymd',$date).'\.[a-z]{3}$`';
		$tab = Array($new_path,$old_path);
		foreach($tab as $dir){
			if(!is_dir($dir)) continue;
			$path = opendir($dir);
			while($file = readdir($path))
				if(preg_match($mask,$file)) $delete[] = $dir.$file;
			closedir($path);
		}
	}else{
		// Effacement d'un mois
		$path = opendir(PATH_LOG);
		while($file=readdir($path))
			if(preg_match('`^'.date('ym',$date).'[0-9]{2}$`',$file,$m) || preg_match('`^'.date('y-m',$date).'$`',$file,$m))
				$delete_folder[] = PATH_LOG.$file.'/';
		closedir($path);
		if(isset($delete_folder))
		foreach($delete_folder as $folder){
			$path = opendir($folder);
			while($file=readdir($path))
				if(preg_match('`^[a-z]{3}_'.date('ym',$date).'[0-9]{2}\.[a-z]{3}$`',$file,$m))
					$delete[] = $folder.$file;
			closedir($path);
		}
	}
	return isset($delete)?$delete:false;
}
