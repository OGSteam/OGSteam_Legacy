<?php
/** $Id$ **/
/**
* Fonctions relatives aux mod d'OGSpy
* @package OGSpy
* @subpackage mods
* @author Kyser (inspiré des sources d'Aéris) - http://www.ogsteam.fr/
* @created 21/07/2006
* @copyright Copyright &copy; 2007, http://www.ogsteam.fr/
* @version 3.04b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

/**
* Récupération de la liste des mods - 
* @comment Pour les users loggés en admin uniquement
* 
*/
function mod_list() {
	global $db, $user_data;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
	redirection("index.php?action=message&id_message=forbidden&info");

	//Listing des mod présents dans le répertoire "mod"
	$path = opendir("mod/");

	//Récupération de la liste des répertoires correspondant 
	$directories = array();
	while($file = readdir($path)) {
		if($file != "." && $file != "..") {
			if (is_dir("mod/".$file)) $directories[$file] = array();
		}
	}
	closedir($path);

	foreach (array_keys($directories) as $d) {
		$path = opendir("mod/".$d);

		while($file = readdir($path)) {
			if($file != "." && $file != "..") {
				$directories[$d][] = $file;
			}
		}
		closedir($path);
	}


	$mod_list = array("disabled" => array(), "actived" => array(), "wrong" => array(), "unknown" => array(), "install" => array());

	$request = "select id, title, root, link, version, active, admin_only from ".TABLE_MOD." order by position, title";
	$result = $db->sql_query($request);
	while (list($id, $title, $root, $link, $version, $active, $admin_only) = $db->sql_fetch_row($result)) {
		if (isset($directories[$root])) { //Mod présent du répertoire "mod"
			if (in_array($link, $directories[$root]) && in_array("version.txt", $directories[$root])) {
				//Vérification disponibilité mise à jour de version
				$line = file("mod/".$root."/version.txt");
				$up_to_date = true;
				if (isset($line[1])) {
					if (file_exists("mod/".$root."/update.php")) {
						$up_to_date = (strcasecmp($version, trim($line[1])) >= 0) ? true : false;
					}
				}

				if ($active == 0) { // Mod désactivé
					$mod_list["disabled"][] = array("id" => $id, "title" => $title, "version" => $version, "up_to_date" => $up_to_date);
				}
				else { //Mod activé
					$mod_list["actived"][] = array("id" => $id, "title" => $title, "version" => $version, "up_to_date" => $up_to_date, "admin_only" => $admin_only);
				}
			}
			else { //Mod invalide
				$mod_list["wrong"][] = array("id" => $id, "title" => $title);
			}

			unset($directories[$root]);
		}
		else { //Mod absent du répertoire "mod"
			$mod_list["wrong"][] = array("id" => $id, "title" => $title);
		}
	}

	while ($files = @current($directories)) {
		if (in_array("version.txt", $files) && in_array("install.php", $files)) {
			$line = file("mod/".key($directories)."/version.txt");
			if (isset($line[0])) {
				$mod_list["install"][] = array("title" => $line[0],"directory" => key($directories));
			}
		}
		next ($directories);
	}

	return $mod_list;
}
/**
* Je sais pas trop ce qu'elle checke cette fonction... <-- Doc à remplacer ? :p
*/
function mod_check($check) {
	global $user_data;
	global $pub_mod_id, $pub_directory;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
	redirection("index.php?action=message&id_message=forbidden&info");

	switch ($check) {
		case "mod_id" :
		if (!check_var($pub_mod_id, "Num")) redirection("index.php?action=message&id_message=errordata&info");
		if (!isset($pub_mod_id)) redirection("index.php?action=message&id_message=errorfatal&info");
		break;

		case "directory" :
		if (!check_var($pub_directory, "Text")) redirection("index.php?action=message&id_message=errordata&info");
		if (!isset($pub_directory)) redirection("index.php?action=message&id_message=errorfatal&info");
		break;
	}
}

/**
* Installation d'un module OGSpy à partir de son nom de repertoire
* @global $pub_directory
*/
function mod_install () {
	global $db;
	global $pub_directory;

	mod_check("directory");

	if (file_exists("mod/".$pub_directory."/install.php")) {
		require_once("mod/".$pub_directory."/install.php");

		$request = "select id from ".TABLE_MOD." where root = '$pub_directory'";
		$result = $db->sql_query($request);
		list($mod_id) = $db->sql_fetch_row($result);

		$request = "select max(position) from ".TABLE_MOD;
		$result = $db->sql_query($request);
		list($position) = $db->sql_fetch_row($result);

		$request = "update ".TABLE_MOD." set position = ".($position+1)." where root = '".$pub_directory."'";
		$db->sql_query($request);

		$request = "select title from ".TABLE_MOD." where id = ".$mod_id;
		$result = $db->sql_query($request);
		list($title) = $db->sql_fetch_row($result);
		log_("mod_install", $title);
	}
	redirection("index.php?action=administration&subaction=mod");
}

/**
* Mise à jour d'un mod
*/
function mod_update () {
	global $db, $pub_mod_id;

	mod_check("mod_id");

	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);

	if (file_exists("mod/".$root."/update.php")) {
		require_once("mod/".$root."/update.php");

		$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
		$result = $db->sql_query($request);
		list($title) = $db->sql_fetch_row($result);
		log_("mod_update", $title);
	}

	redirection("index.php?action=administration&subaction=mod");
}

/**
* Suppression d'un mod
*/
function mod_uninstall () {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);
	if (file_exists("mod/".$root."/uninstall.php")) {
		require_once("mod/".$root."/uninstall.php");
	}

	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);

	$request = "delete from ".TABLE_MOD." where id = ".$pub_mod_id;
	$db->sql_query($request);

	log_("mod_uninstall", $title);
	redirection("index.php?action=administration&subaction=mod");
}

/**
* Activation d'un mod
*/
function mod_active () {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$request = "update ".TABLE_MOD." set active='1' where id = ".$pub_mod_id;
	$db->sql_query($request);

	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("mod_active", $title);

	redirection("index.php?action=administration&subaction=mod");
}

/**
* Désactivation d'un mod
*/
function mod_disable () {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$request = "update ".TABLE_MOD." set active='0' where id = ".$pub_mod_id;
	$db->sql_query($request);

	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("mod_disable", $title);

	redirection("index.php?action=administration&subaction=mod");
}

// Modifs par naruto kun

//Vue d'un mod
function mod_admin () {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$request = "update ".TABLE_MOD." set admin_only='1' where id = ".$pub_mod_id;
	$db->sql_query($request);

	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);

	log_("mod_admin", $title);

	redirection("index.php?action=administration&subaction=mod");
}

//Vue d'un mod
function mod_normal () {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$request = "update ".TABLE_MOD." set admin_only='0' where id = ".$pub_mod_id;
	$db->sql_query($request);

	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);

	log_("mod_normal", $title);

	redirection("index.php?action=administration&subaction=mod");
}

//fin des modifs

/**
* Ordonnancement des mod
*/
function mod_sort ($order) {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	$mods = array();
	$request = "select id from ".TABLE_MOD." order by position, title";
	$result = $db->sql_query($request);
	$i=1;
	while (list($id) = $db->sql_fetch_row($result)) {
		$mods[$id] = $i;
		$i++;
	}

	//Parade pour éviter les mods qui aurait les même positions
	switch ($order) {
		case "up" : $mods[$pub_mod_id] -= 1.5;break;
		case "down" : $mods[$pub_mod_id] += 1.5;break;
	}

	asort($mods);
	$i=1;
	while (current($mods)) {
		$request = "update ".TABLE_MOD." set position = ".$i." where id = ".key($mods);
		$db->sql_query($request);
		$i++;
		next($mods);
	}
	
	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("mod_order", $title);
	
	redirection("index.php?action=administration&subaction=mod");
}
/**
* Renvoi le numéro de version du mod en cours d'execution. Basé sur le paramètre $pub_action
* @global $pub_action
* @return string Numéro de version du mod en cours
*/
function mod_version () {
	global $db;
	global $pub_action;


	$request = "select `version` from ".TABLE_MOD." where root = '".$pub_action."'";
	$result = $db->sql_query($request);
	if ($result) {
		list($version) = $db->sql_fetch_row($result);
		return $version;
	}
	return "(ModInconnu:'$pub_action')";
}
/**
* Permet d'ajouter un paramétre de configuration et sa valeur pour un mod donné
* @param string $param Nom du paramètre de configuration
* @param string $value Valeur du paramètre de configuration
* @global $db
* @return boolean Retourne true/false selon le résultat de l'enregistrement en base de données
*/
function mod_set_option ( $param, $value, $nom_mod='' ) {
	global $db;

	if (!is_object($db)) {
		global $pub_sgbd_server, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_dbname;
		$db = new sql_db($pub_sgbd_server, $pub_sgbd_username, $pub_sgbd_password, $pub_sgbd_dbname);
		if (!$db->db_connect_id) error_sql("Impossible de se connecter à la base de données");
	}
	else {
    	$nom_mod = mod_get_nom();
    }
	if ( !check_var($param, "Text") ) redirection("index.php?action=message&id_message=errordata&info");
	$query = 'REPLACE INTO ' . TABLE_MOD_CFG . ' VALUES ("' . $nom_mod . '", "' . $param . '", "' . $value . '")';
	if ( !$db->sql_query($query) ) return false;
	return true;
}
/**
* Permet d'effacer un paramétre de configuration pour un mod donné
* @param string $param Nom du paramètre de configuration
* @global $db
* @return boolean Retourne true/false selon le résultat de l'enregistrement en base de données
*/
function mod_del_option ( $param ) {
	global $db;

	$nom_mod = mod_get_nom();
	if ( !check_var($param, "Text") ) redirection("index.php?action=message&id_message=errordata&info");
	$query = 'DELETE FROM ' . TABLE_MOD_CFG . ' WHERE `mod` = "' . $nom_mod . '" AND `config` = "' . $param . '"';
	if ( !$db->sql_query($query) ) return false;
	return true;
}
/**
* Permet de lire la valeur d'un paramétre de configuration pour un mod donné
* @param string $param Nom du paramètre de configuration
* @global $db
* @return string Retourne la valeur du paramètre demandé
*/
function mod_get_option ( $param ) {
	global $db;

	$nom_mod = mod_get_nom();
	if ( !check_var($param, "Text") ) redirection("index.php?action=message&id_message=errordata&info");
	$query = 'SELECT value FROM ' . TABLE_MOD_CFG . ' WHERE `mod` = "' . $nom_mod . '" AND `config` = "' . $param . '"';
	$result = $db->sql_query($query);
	if ( ! list ( $value ) = $db->sql_fetch_row ( $result ) ) return '';
	return $value;
}
/**
* Récupère le nom du mod courant
* La fonction n'admet pas de paramètre
* @global $db
* @global $pub_action
* @global $directory
* @global $mod_id
* @return string Retourne le nom du mod demandé
*/
function mod_get_nom() {
	global $db;
   	global $pub_action;

	$nom_mod = '';
	if ( $pub_action == 'mod_install' ) {
		global $pub_directory;
		$nom_mod = $pub_directory;
	}
	elseif ( $pub_action == 'mod_update' || $pub_action == 'mod_uninstall' ) {
		global $pub_mod_id;
		$query = 'SELECT `action` FROM ' . TABLE_MOD . ' WHERE id=' . $pub_mod_id;
		$result = $db->sql_query($query);
		list ( $nom_mod ) = $db->sql_fetch_row ( $result );
	}
	else {
		$nom_mod = $pub_action;
	}
	return $nom_mod;
}
/**
* Permet d'effacer un paramétre de configuration pour un mod donné
* @param string $param Nom du paramètre de configuration
* @global $db
* @return boolean Retourne true/false selon le résultat de l'enregistrement en base de données
*/
function mod_del_all_option () {
	global $db;

	$nom_mod = mod_get_nom();
	$query = 'DELETE FROM ' . TABLE_MOD_CFG . ' WHERE `mod` = "' . $nom_mod . '"';
	if ( !$db->sql_query($query) ) return false;
	return true;
}
?>
