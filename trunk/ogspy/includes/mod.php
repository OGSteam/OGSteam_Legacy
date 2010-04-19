<?php
/** $Id$ **/
/**
* Fonctions relatives aux mod d'OGSpy
* @package OGSpy
* @subpackage mods
* @author Kyser (inspiré des sources d'Aéris) - http://ogsteam.fr/
* @created 21/07/2006
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 3.04b ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

/**
* on récupère le titre du mod celon la langue
**/
function mod_info_title($mod){
	global $user_data, $server_config;
	
	if (file_exists("mod/{$mod}/lang/lang_".$server_config['language']."/infos.php")) include("mod/{$mod}/lang/lang_".$server_config['language']."/infos.php");
	if (file_exists("mod/{$mod}/lang/lang_".$user_data['user_language']."/infos.php")) include("mod/{$mod}/lang/lang_".$user_data['user_language']."/infos.php");
	$title = (isset($lang['mod_title']) ? $lang['mod_title'] : 'undefined');
	
	return $title;
}

/**
* on récupère le menu du mod celon la langue
**/
function mod_info_menu($mod){
	global $user_data, $server_config;
	
	if (file_exists("mod/{$mod}/lang/lang_".$server_config['language']."/infos.php")) include("mod/{$mod}/lang/lang_".$server_config['language']."/infos.php");
	if (file_exists("mod/{$mod}/lang/lang_".$user_data['user_language']."/infos.php")) include("mod/{$mod}/lang/lang_".$user_data['user_language']."/infos.php");
	$menu = (isset($lang['mod_menu']) ? $lang['mod_menu'] : 'undefined');
	
	return $menu;
}

/**
* on sort la liste des noms des mods et des categories...
**/
function mod_menu(){
	global $db, $user_auth, $user_data, $server_config;
	
	$cats = $mods = Array();
	$request = "select id, title, menu, mods from ".TABLE_MOD_CAT." where active = 1 order by position, title";
	$result = $db->sql_query($request);
	while ($tmp = $db->sql_fetch_assoc($result)){
		$tmp['members'] = explode(' ',$tmp['mods']);
		$cats[] = $tmp;
	}
	// Et la liste des mods		
	$request = "select id, root, action from ".TABLE_MOD." where active = 1 order by position";
	$result = $db->sql_query($request);
	if ($db->sql_numrows($result)) 
		while ($val = $db->sql_fetch_assoc($result))
			if(!in_array($val['id'],$user_auth['mod_restrict'])){
				$val['title'] = mod_info_title($val['root']);
				$val['menu'] = mod_info_menu($val['root']);
				$mods[] = $val;
			}
	return Array($cats, $mods);
}

/**
* Récupération de la liste des mods - 
* @comment Pour les users loggés en admin uniquement
* 
*/
function mod_list() {
	global $db, $user_data, $server_config, $info;
	
	user_check_auth("usergroup_manage");

	if(@fopen(XML_file, 'r')){
		$mods_found = new SimpleXMLElement(XML_file, LIBXML_NOCDATA, true, null);
		$modAupdate = Array();
		//recherche de la liste des mods à update sur le svn
		foreach($mods_found->mod as $mod)
			//die($mod->name);
			$modAupdate[(string)$mod->name] = Array((string)$mod->version, (string)$mod->description);
	} else {
		$info[] = Array('text'=>L_('adminmod_ErrorWhileReadingXML'));
		$info[] = Array('text'=>'');
		$modAupdate = Array();
	}
		
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
		if ( sizeof ( $directories[$d] ) == 0 ) unset ( $directories[$d] );
	}

	$mod_list = array("disabled" => array(), "actived" => array(), "wrong" => array(), "unknown" => array(), "install" => array());

	$request = "SELECT id, position, position, root, link, version, active, admin_only FROM ".TABLE_MOD." ORDER BY position";
	$result = $db->sql_query($request);
	while (list($id, $position, $position, $root, $link, $version, $active, $admin_only) = $db->sql_fetch_row($result)) {
		$title = mod_info_title($root);
		$menu = mod_info_menu($root);
		
		if (isset($directories[$root])) { //Mod présent du répertoire "mod"
			if (in_array($link, $directories[$root]) && in_array("version.txt", $directories[$root])) {
				if ($admin_only == 1 || $admin_only == 0) $admin_only = "";
					//Vérification disponibilité mise à jour de version
					$UpdateSvn = true;
					$UpdateOgs = true;
					$new_version = false;
					$line = file("mod/".$root."/version.txt");
					//on verifie le svn
					if(isset($modAupdate[$root]) && mustUpdate(trim($version),$modAupdate[$root][0])){
						$UpdateSvn = false;
						$new_version = $modAupdate[$root][0];
					}
					//on verifie le ftp
					if (isset($line[1]))
						if (file_exists("mod/".$root."/update.php"))
							if(mustUpdate($version, trim($line[1]))){
								$UpdateOgs = false;
								$new_version = isset($line[1]) ? $line[1] : '?.?';
							}
					if($new_version && !isset($info))
						$info[] = Array('text'=>L_('adminmod_NewUpdateFound'));
						
				$tmp = array(
					"id" => $id, 
					"title" => trim($title), 
					"menu" => $menu, "position" => $position, 
					"version" => trim($version), 
					"root" => $root,
					"up_to_date_ogs" => $UpdateOgs, 
					"up_to_date_svn" => $UpdateSvn,
					"new_version" => $new_version,
					"cat" => false,
					"admin_only" => $admin_only
				);
				if ($active == 0) // Mod désactivé
					$mod_list["disabled"][$position] = $tmp;
				else //Mod activé
					$mod_list["actived"][$position] = $tmp;
			}
			else //Mod invalide
				$mod_list["wrong"][] = array("id" => $id, "title" => trim($title));

			unset($directories[$root]);
		}
		else //Mod absent du répertoire "mod"
			$mod_list["wrong"][] = array("id" => $id, "title" => trim($title));
	}
	
	if(!isset($info))
		$info[] = Array('text'=>L_('adminmod_NoUpdateFound'));

	while ($files = @current($directories)) {
		if (in_array("version.txt", $files) && in_array("install.php", $files)) {
			$line = file("mod/".key($directories)."/version.txt");
			if (isset($line[0])) {
				$title = mod_info_title(key($directories));
				$mod_list["install"][] = array("title" => $title, "directory" => key($directories), "version" => trim(isset($line[1])?$line[1]:'0'));
			}
		}
		next ($directories);
	}
	
	foreach($modAupdate as $name => $value){
		foreach($mod_list["actived"] as $mod)
			if($mod["title"] == $name)
				continue;
		foreach($mod_list["disabled"] as $mod)
			if($mod["title"] == $name)
				continue;
		$mod_list["svn"][] = Array("title" => $name, "version" => $value[0], "description" => $value[1]);
	}
	
	ksort($mod_list["actived"]);
	return $mod_list;
}

/**
 * Analyse de la version (une sorte de version_compare adapté aux versions des modules OGSpy
 */
function mustUpdate($curver,$xmlver) {
	$itis=2; // Non défini
	$xml=str_split(str_replace('.','',$xmlver));//explode(".",$xmlver);
	$current=str_split(str_replace('.','',$curver));//explode(".",$curver);
	$test = $xmlver;
	for ($i=0;(($i<sizeof($current))&&($i<sizeof($xml)));$i++) {
		if ($current[$i]>$xml[$i]) return false; // A jour
		if ($current[$i]<$xml[$i]) return true; // Pas a jour
	}
	
	if (sizeof($current)>=sizeof($xml))
		return false; //$current est une sous version de $xml
	else
		for ($i=sizeof($current)-1;$i<sizeof($xml);$i++)
			if ($xml[$i]) return true; // La version XML est une sous version de $current
		
	return false; // égalité totale : A jour
}

/**
* Renomme un mod en changeant le menu
*
*/
function mod_rename() {
	global $user_data, $pub_mod_id, $db, $pub_new_mod_name;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	
	if(isset($pub_mod_id) && isset($pub_new_mod_name)){
		$request = "update ".TABLE_MOD." set `menu` = '".($pub_new_mod_name)."' where id = '".$pub_mod_id."'";
		$db->sql_query($request);
	}
	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("mod_rename",$title);
}

/**
* Change le lien vers le panneau admin d'un mod
*
*/
function mod_change_admin_link() {
	global $user_data, $pub_mod_id, $db, $pub_new_mod_admin_link;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	
	if(isset($pub_mod_id) && isset($pub_new_mod_admin_link)){
		$request = "update ".TABLE_MOD." set `admin_only` = '".($pub_new_mod_admin_link)."' where id = '".$pub_mod_id."'";
		$db->sql_query($request);
	}
	$request = "select title from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("mod_admin_link",$title);
}

/**
* Renomme une catégorie en changeant le menu
*
*/
function cat_rename() {
	global $user_data, $pub_cat_id, $db, $pub_new_cat_name, $pub_new_cat_title;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	
	if(isset($pub_cat_id) && isset($pub_new_cat_name) && isset($pub_new_cat_title)){
		$request = "update ".TABLE_MOD_CAT." set `menu` = '".($pub_new_cat_name)."', `title` = '".($pub_new_cat_title)."' where id = '".$pub_cat_id."'";
		$db->sql_query($request);
	}
	$request = "select title from ".TABLE_MOD_CAT." where id = ".$pub_cat_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("cat_rename",$title);
}

/**
* Creation d'une catégorie
*
*/
function cat_create() {
	global $user_data, $pub_cat_name, $db;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");

	if(isset($pub_cat_name)){
		$request = "insert ignore ".TABLE_MOD_CAT." (title,menu,active) value ('{$pub_cat_name}','<u>{$pub_cat_name}</u>',1)";
		$db->sql_query($request);
	}
	log_("cat_create",$pub_cat_name);
}
/**
* Récupération de la liste des Catégories - 
* @comment Pour les users loggés en admin uniquement
* 
*/
function cat_list() {
	global $db, $user_data;

	user_check_auth("usergroup_manage");


	$cat_list = array("disabled" => array(), "actived" => array());

	$request = "SELECT id, title, menu, position, mods, active FROM ".TABLE_MOD_CAT." ORDER BY position";
	$result = $db->sql_query($request);
	while (list($id, $title, $menu, $position, $mods, $active) = $db->sql_fetch_row($result)) {
				$id_array = explode(' ',$mods);
				$cat_id = Array				
				("id" => $id, "title" => $title, "menu" => $menu, "position" => $position, "members" => $id_array,
				 "version" => "", "up_to_date" => true );
				if ($active == 0) // Cat désactivé
					$cat_list["disabled"][] = $cat_id;
				else //Cat activé
					$cat_list["actived"][] = $cat_id;
	}
	
	return $cat_list;
}
/**
* Test de la validité d'un mod en fonction de son répertoire, ou de son mod_id
* @param : Le type de données ($check) 'mod_id' ou 'directory'. Test de $pub_mod_id dans le 1er cas, et de $pub_directory dans le 2nd
* @param : Doit-on retourner un booléen ($java) ou faire une redirection. Car si la fonction est appellé par l'ajax, la redirection ne fonctionnera pas.
* @return : Booléen si $java est vrai, sinon une simple redirection en cas d'erreur.
*/
function mod_check($check) {
	global $user_data;
	global $pub_mod_id, $pub_directory;

	
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");

	switch ($check) {
		case "mod_id" :
		if (!check_var($pub_mod_id, "Num")) redirection("?action=message&id_message=errordata&info");
		if (!isset($pub_mod_id)) redirection("?action=message&id_message=errorfatal&info");
		break;

		case "directory" :
		if (!check_var($pub_directory, "Text")) redirection("?action=message&id_message=errordata&info");
		if (!isset($pub_directory)) redirection("?action=message&id_message=errorfatal&info");
		break;
	}
}

/**
* Installation d'un module OGSpy à partir de son nom de repertoire
* @global $pub_directory
*/
function mod_install () {
	global $db, $pub_directory, $user_data, $server_config, $lang_loaded, $table_prefix;
	
	$install = false;
	mod_check("directory");

	$root = $pub_directory;
	if (file_exists("mod/".$pub_directory."/install.php")) {
		$filename = "mod/{$root}/version.txt";
		if (file_exists($filename)) $file = file($filename);
		$version = (isset($file) ? trim($file[1]) : '?.?');
		
		require_once("mod/".$pub_directory."/install.php");

		$request = "select id from ".TABLE_MOD." where root = '$pub_directory'";
		$result = $db->sql_query($request);
		list($mod_id) = $db->sql_fetch_row($result);

		$request = "select max(position) from ".TABLE_MOD;
		$result = $db->sql_query($request);
		list($position) = $db->sql_fetch_row($result);

		$request = "update ".TABLE_MOD." set position = ".($position+1)." where root = '".$pub_directory."'";
		$db->sql_query($request);

		$title = mod_info_title($pub_directory);
		$install = true;
		log_("mod_install", $title);
	}
	
	return $install;
}

/**
* Mise à jour d'un mod
*/
function mod_update () {
	global $db, $pub_mod_id, $pub_version, $table_prefix;
	
	$update = false;
	mod_check("mod_id");

	$mod_id = $pub_mod_id;
	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);

	if (file_exists("mod/".$root."/update.php")) {
		$filename = "mod/{$root}/version.txt";
		if (file_exists($filename)) $file = file($filename);
		$version = (isset($file) ? trim($file[1]) : '?.?');
		
		require_once("mod/".$root."/update.php");

		$title = mod_info_title($root);
		$update = true;
		log_("mod_update", $title);
	}

	return $update;
}

/**
* Suppression d'un mod
*/
function mod_uninstall() {
	global $db, $table_prefix;
	global $pub_mod_id;

	mod_check("mod_id");

	$mod_id = $pub_mod_id;
	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);
	if (file_exists("mod/".$root."/uninstall.php")) {
		require_once("mod/".$root."/uninstall.php");
	}

	$request = "delete from ".TABLE_MOD." where id = ".$pub_mod_id;
	$db->sql_query($request);

	$title = mod_info_title($root);
	log_("mod_uninstall", $title);
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

	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);
	$title = mod_info_title($root);
	
	log_("mod_active", $title);
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

	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);
	$title = mod_info_title($root);
	
	log_("mod_disable", $title);
}

/**
* Ordonnancement des mods
*/
function mod_sort ($order) {
	global $db;
	global $pub_mod_id;

	mod_check("mod_id");

	//Prise en compte des catégories
	$request = "select mods, id from ".TABLE_MOD_CAT." order by id";
	$result = $db->sql_query($request);
	while ($row = mysql_fetch_assoc($result)) {
		$mods_id = explode(" ",$row["mods"]);
		for ($i=1;$i<=6;$i++) $a = array_shift($mods_id);
		foreach ($mods_id as $value) $cats_mods[$value] = $row["id"];
	}

	$mods = array();
	$request = "select id from ".TABLE_MOD." order by position";
	$result = $db->sql_query($request);
	$i=1;
	while (list($id) = $db->sql_fetch_row($result)) {
		$mods[$id] = $i;
		$i++;
		if (!isset($cats_mods[$id])) $cats_mods[$id] = "0";
	}

	$n = 0;
	while ((is_numeric($cats_mods[array_search($mods[$pub_mod_id]+$n,$mods)])) && (($cats_mods[array_search($mods[$pub_mod_id]+$n,$mods)] != $cats_mods[$pub_mod_id]) || ($n == 0))) {
		if ($order == "up") $n--;
		else $n++;
	}

	//Parade pour éviter les mods qui aurait la même position
	switch ($order) {
		case "up" : $mods[$pub_mod_id] += $n - 0.5;break;
		case "down" : $mods[$pub_mod_id] += $n + 0.5;break;
	}

	asort($mods);
	$i=1;
	while (current($mods)) {
		$request = "update ".TABLE_MOD." set position = ".$i." where id = ".key($mods);
		$db->sql_query($request);
		$i++;
		next($mods);
	}
	
	$request = "select root from ".TABLE_MOD." where id = ".$pub_mod_id;
	$result = $db->sql_query($request);
	list($root) = $db->sql_fetch_row($result);
	$title = mod_info_title($root);
	
	log_("mod_order", $title);
}

/**
* Ordonnancement des catégorie
*/
function cat_sort ($order) {
	global $db,$pub_cat_id,$user_data;

	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	if (!check_var($pub_cat_id, "Num"))
		redirection("?action=message&id_message=errordata&info");

	$cats = array();
	$request = "select id from ".TABLE_MOD_CAT." order by position, title";
	$result = $db->sql_query($request);
	$i=1;
	while (list($id) = $db->sql_fetch_row($result)) {
		$cats[$id] = $i;
		$i++;
	}

	//Parade pour éviter les catégories qui aurait la même position
	switch ($order) {
		case "up" : $cats[$pub_cat_id] -= 1.5;break;
		case "down" : $cats[$pub_cat_id] += 1.5;break;
	}

	asort($cats);
	$i=1;
	while (current($cats)) {
		$request = "update ".TABLE_MOD_CAT." set position = ".$i." where id = ".key($cats);
		$db->sql_query($request);
		$i++;
		next($cats);
	}
	
	$request = "select title from ".TABLE_MOD_CAT." where id = ".$pub_cat_id;
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);
	log_("cat_order", $title);
}
/**
* Ajoute un module dans une catégorie
*
*/
function cat_add_mod($cat_id=NULL) {
global $db,$pub_mod_id,$pub_cat_id,$user_data;
	if(isset($cat_id)) $pub_cat_id = $cat_id;
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	if (!check_var($pub_cat_id, "Num")||!check_var($pub_mod_id, "Num")) 
		redirection("?action=message&id_message=errordata&info");
	
	// On regarde si le mod n'est pas deja dans une cotégorie, si c'est le cas, on le note pour mettre à jour
	$cats = cat_list(); $cat_to_edit = array();
	$found = 0;
	foreach($cats['actived'] as $cat){
		$temp = Array();
		foreach($cat['members'] as $member)
			if((string) $member === (string) $pub_mod_id ){
				//
			} else
				if(check_var($cat['id'],"Num"))
					$temp[] = (string) $member;
					
		if(count($temp)!=count($cat['members'])) { // Le tableau a changé, faut éditer
			$mods = implode(' ',$temp);
			if($mods=="") $mods = "0";
			$request = "UPDATE ".TABLE_MOD_CAT." set mods = '{$mods}' WHERE `id`='{$cat['id']}'";
			$result = $db->sql_query($request);
		}
	}
	
	if($pub_cat_id !== 0){ 
		$request = "SELECT mods FROM ".TABLE_MOD_CAT." WHERE `id`='{$pub_cat_id}'";
		$result = $db->sql_query($request);
		$members_str = $db->sql_fetch_row($result);
		$members = Array();
		$members = explode(' ',$members_str[0]);
		if(!in_array($pub_mod_id,$members)) {
			if(count($members)>0){
				$members[] = $pub_mod_id;
				$mods = implode(' ',$members);
			} else
				$mods = $pub_mod_id;
			$request = "UPDATE ".TABLE_MOD_CAT." set mods = '{$mods}' WHERE `id`='{$pub_cat_id}'";
			$result = $db->sql_query($request);
		}
		$request = "select a.root, b.title from ".TABLE_MOD." a, ".TABLE_MOD_CAT." b where a.id = {$pub_mod_id} and b.id={$pub_cat_id}";
		$result = $db->sql_query($request);
		$option = $db->sql_fetch_row($result);
		$option[0] = mod_info_title($option[0]);
		log_("cat_add_mod", $option); 
	}
	else {
		$request = "select root from ".TABLE_MOD." where id = {$pub_mod_id}";
		$result = $db->sql_query($request);
		list($root) = $db->sql_fetch_row($result);
		$title = mod_info_title($root);
		log_("cat_rem_mod", $title);
	}
}
/**
* Efface une catégorie
*
*/
function cat_remove(){

	global $db,$pub_mod_id,$pub_cat_id,$user_data;
	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
		redirection("?action=message&id_message=forbidden&info");
	if (!check_var($pub_cat_id, "Num")||!check_var($pub_mod_id, "Num")) 
		redirection("?action=message&id_message=errordata&info");

	$request = "select title from ".TABLE_MOD_CAT." where id = {$pub_cat_id}";
	$result = $db->sql_query($request);
	list($title) = $db->sql_fetch_row($result);

	if($title=="Admin")
		redirection("?action=message&id_message=errordata&info");
	
	$request = "DELETE FROM ".TABLE_MOD_CAT." WHERE `id`='{$pub_cat_id}'";
	$result = $db->sql_query($request);

	log_("cat_remove", $title);
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

?>
