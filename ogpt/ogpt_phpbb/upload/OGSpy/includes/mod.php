<?php
/***************************************************************************
*	filename	: mod.php
*	desc.		:
*	Author		: Kyser (inspiré des sources d'Aéris) - http://www.ogsteam.fr/
*	created		: 21/07/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


//Récupération des mods
function mod_list() {
	global $db, $user_data;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
	redirection("index.php?action=message&id_message=forbidden&info");

	//Listing des mod présents dans le répertoire "mod"
	$path = opendir("mod/");

	//Récupération de la liste des répertoires correspondant à cette date
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

	$request = "select id, title, root, link, version, active from ".TABLE_MOD." order by position, title";
	$result = $db->sql_query($request);
	while (list($id, $title, $root, $link, $version, $active) = $db->sql_fetch_row($result)) {
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
					$mod_list["actived"][] = array("id" => $id, "title" => $title, "version" => $version, "up_to_date" => $up_to_date);
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

//Ajout d'un mod
function mod_install () {
	global $db;
	global $pub_directory;

	mod_check("directory");

	if (file_exists("mod/".$pub_directory."/install.php")) {
		require_once("mod/".$pub_directory."/install.php");

		$request = "select id from ".TABLE_MOD." where position = -1";
		$result = $db->sql_query($request);
		list($mod_id) = $db->sql_fetch_row($result);

		$request = "select max(position) from ".TABLE_MOD;
		$result = $db->sql_query($request);
		list($position) = $db->sql_fetch_row($result);

		$request = "update ".TABLE_MOD." set root = '".$pub_directory."', position = ".($position+1)." where id = ".$mod_id;
		$db->sql_query($request);

		$request = "select title from ".TABLE_MOD." where id = ".$mod_id;
		$result = $db->sql_query($request);
		list($title) = $db->sql_fetch_row($result);
		log_("mod_install", $title);
	}
	redirection("index.php?action=administration&subaction=mod");
}

//Mise à jour d'un mod
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

//Suppression d'un mod
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

//Activation d'un mod
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

//Désactivation d'un mod
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

//Ordonnancement des mod
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
?>