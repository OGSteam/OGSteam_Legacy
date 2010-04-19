<?php
/** $Id$ **/ 
/**
* Functions de gestion des langues
* @package OGSpy
* @subpackage Main
* @copyright Copyright &copy; 2008, http://ogsteam.fr/
* @modified $Date$
* @author Sylar
* @link $HeadURL$
* @version 3.10 ( $Rev$ ) 
*/
/********************************************************************
Les modules peuvent maintenant utiliser ces fonctions, voici le principe :

// Tout commence par une initialisation:
lang_init_module('nom du module (pour les logs)','/mod/Module/DossierLang/');

// Chargement du fichier langue voulu. OGspy va aller chercher le fichier dans le dossier défini plus haut comme ceci :
// /mod/Module/DossierLang/mapage.php
lang_module_page('mapage');  

// Affichage d'une chaine traduite :
T_('index de ma chaine');

Les fichiers de langues doivent etre de la forme
$lang['index'] = 'chaine';


********************************************************************/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
define('LOG_LOCAL_ERROR',isset($server_config['log_langerror'])&&$server_config['log_langerror']==1);

/**
* Recherche des langues disponibles et créé 2 tableaux en fonction
* L'un contenant la liste des langues dans leur format simple (2 lettres)
* L'autre contenant les versions et nom long de chaque langue, indéxé par les noms long.
*/
$ogspy_langue = get_langpack(PATH_LANG);
$ogspy_langue['name'] = 'OGSpy';
$ogspy_langue['indexes'] = Array();
 

/**
*  Initialisation des langues. 
*  On charge la langue du parsing
*/
// chargement des langues par défaut :  aide et communes
lang_load_page("help");
lang_load_page("common");
lang_load_page("lang_parsing");
lang_load_page("log");



/**
* Charge un fichier de langue, dans le language correspondant
*/
function lang_load_page($page,$lang_install=NULL,$module=false){
	global $ogspy_langue, $module_langue, $user_data, $server_config, $help,$pub_ajax, $lang_loaded, $page_loaded;
	$page_loaded = $page;
	$lang=Array();
	
	if(!$module){ 
		// Un dossier n'est pas défini, alors il sagit de OGSpy
		$pack = $ogspy_langue;
		$folder = PATH_LANG;
	}else{
		// Un dossier est défini, alors il sagit d'un module
		$pack = $module_langue;
		$folder = $module_langue['folder'];
	}
	
	if(isset($lang_install))
		// Si $lang_install est défini, on cherche même pas : on l'utilise (OGSpy n'est probablement pas installé, donc y'a rien a trouver en fait)
		$lang_loaded = strtolower($lang_install);
	else
		// Une lang_install n'est pas défini, alors on cherche la langue approprié
		if($page=="lang_parsing")
			// S'il sagit du chargement des langues de parsing, alors on utilise la langue parsing configurée
			$lang_loaded = $server_config['language_parsing'];
		elseif($page=="log")
			// S'il sagit de la page de log, alors on utilise la langue défini par le serveur et non pas celle de l'utilisateur qui génére le log
			// Si La langue défini n'est pas ou plus installé, on retourne sur le FR
			if(!in_array($server_config['language'],$pack['list'])){
				$lang_loaded = 'fr';
				if(LOG_LOCAL_ERROR) 
					log_('local lang missing',$server_config['language'],$module?$module_langue['name']:'OGSpy');
			} else
				$lang_loaded = $server_config['language'];
		else
			// C'est une autre page, alors on cherche la langue que l'utilisateur a choisi
			if(!in_array($user_data['user_language'],$pack['list'])){
				if(LOG_LOCAL_ERROR) 
					log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
				// La langue choisie par l'utilisateur n'est pas installé, alors on se rabat sur la langue générale du serveur
				if(!in_array($server_config['language'],$pack['list'])){
					$lang_loaded = "fr";
					if(LOG_LOCAL_ERROR) 
						log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
				}else
					$lang_loaded = $server_config['language'];
			}else
				// Sinon, on prends la langue choisie par l'utilisateur
				$lang_loaded = $user_data['user_language'];

	// formatage du chemin vers le fichier de langue
	if(isset($lang_install)||!isset($pack['data'][$lang_loaded]['folder']))
		$lang_file = PATH_LANG.'lang_'.$lang_install."/".$page.".php";
	else
		$lang_file = $folder.$pack['data'][$lang_loaded]['folder']."/".$page.".php";
	
	if ($found=file_exists($lang_file))
		// S'il existe on le charge
		require_once($lang_file);
	elseif(LOG_LOCAL_ERROR)
		// Sinon, si l'option est activé : on log une erreur
		log_("local file error",$lang_file);
	$pack['indexes'] = array_merge($pack['indexes'],$lang);
	
	if(!$module)
		$ogspy_langue = $pack;
	else
		$module_langue = $pack;
	return $found;
}
/**
 * Chargement d'un fichier de langue pour un module (doit avoir initialisé sa langue avant)
 */
function lang_module_page($page){
	global $module_langue;
	return lang_load_page($page,NULL,$module_langue['folder']);
}

/**
* Charge le fichier langue correspondant au nom "$file".
* Renvoi le nom du fichier donné en argument, pour permettre de faire "include(translated($fichier));'...
*/
function translated($file){
	if(!preg_match("`.*/(.*)\.php`",$file,$match))
		if(!preg_match("`(.*)\.php`",$file,$match))
			$match[1] = "";
	lang_load_page($match[1]);	
	return $file;
}

/**
* Créé une liste "option" des langues disponible
*/
function make_lang_list($selected=""){
	global $server_config,$ogspy_langue;
	$exist_lang = "";
	foreach($ogspy_langue['list'] as $langue)
		$exist_lang .= "<option value=\"".$langue."\"".($selected==$langue?' selected="selected"':'').">".htmlentities($ogspy_langue['data'][$langue]['name'],ENT_QUOTES,'UTF-8')."</option>";
	return $exist_lang;
}

/** 
* Créé une list e d'image de drapeaux correspondant aux langues installées.
* Argument, lien, witdh, et height des images.
*/
function make_lang_pic($link,$width,$height,$path="../images/flags/"){
	global $ogspy_langue;
	$return = "";
	foreach($ogspy_langue['list'] as $langue){
		$return .= '<a href="'.$link.$langue.'">';
        $pic = $path.$langue.'.png';
		if(!file_exists($pic)) $pic = PATH_LANG.$ogspy_langue['data'][$langue]['folder']."/".$langue.'.png';
        $return .= '<img src="'.$pic.'" alt="'.$ogspy_langue['data'][$langue]['name'].'" style="width: '.$width.'; height: '.$height.';" />';
        $return .= '</a>&nbsp;';
    }
	return $return;
}
/** 
 * Appel de la fonction de traduction d'une chaine depuis OGSpy
 */
function L_($index){
	global $ogspy_langue,$lang_loaded,$page_loaded;
	$args = ''; $a = Array();
	$n = func_num_args();
	for ($i=1; $i<$n; $i++){
		$a[$i] = func_get_arg($i);
		$args = ($args==''?'':$args.",").'$a['.$i.']';
	}
	if($args!='') $args = ','.$args;
	eval('$str = lang_print_index($ogspy_langue,$index'.$args.');');
	return $str;
}
/** 
 * Appel de la fonction de traduction d'une chaine depuis un module
 */
function T_($index){
	global $module_langue,$lang_loaded,$page_loaded;
	$args = ''; $a = Array();
	$n = func_num_args();
	for ($i=1; $i<$n; $i++){
		$a[$i] = func_get_arg($i);
		$args = ($args==''?'':$args.",").'$a['.$i.']';
	}
	if($args!='') $args = ','.$args;
	eval('$str = lang_print_index($module_langue,$index'.$args.');');
	return $str;
}
/** 
 * Affichage d'une chaine $index en fonctin de la langue définie
 * renvoi l'index si la chaine n'existe pas
 */
function lang_print_index($pack,$index){
	global $lang_loaded,$page_loaded,$ogspy_langue,$server_config;
	$args = ''; $a = Array();
	$n = func_num_args();
	for ($i=2; $i<$n; $i++){
		$a[$i] = func_get_arg($i);
		$args = ($args==''?'':$args.",").'$a['.$i.']';
	}
	if(isset($pack['indexes'][$index])&&$pack['indexes'][$index]!='')
		$str = is_array($pack['indexes'][$index])?$pack['indexes'][$index]:($pack['indexes'][$index]);
	elseif($pack!=$ogspy_langue&&isset($ogspy_langue['indexes'][$index])&&$ogspy_langue['indexes'][$index]!=''){
		// L'index n'existe pas dans les langues du module, mais dans les langues de OGSpy
		$str = is_array($ogspy_langue['indexes'][$index])?$ogspy_langue['indexes'][$index]:($ogspy_langue['indexes'][$index]);
	}else{
		if(LOG_LOCAL_ERROR && (!isset($a[2])||$a[2]!==false))
			if(isset($a[2])&&$a[2]=='parsing')
				log_("local error",Array($index,$pack['name'],$server_config['language_parsing'],"lang_parsing"));
			else
				log_("local error",Array($index,$pack['name'],$lang_loaded,$page_loaded));
		return $index;
	}
	if($args!='') eval('$str = sprintf($str,'.$args.');');
	return $str;//is_array($str)?$str:htmlspecialchars_decode($str,ENT_NOQUOTES  );
}

/**
 * recherche les langues installé dans le dossier fourni (utilisé par les modules ou par OGSpy)
/**
* Recherche des langues disponibles et créé 2 tableaux en fonction
* L'un contenant la liste des langues dans leur format simple (2 lettres)
* L'autre contenant les versions et nom long de chaque langue, indéxé par les noms long.
*/
function get_langpack($folder){
	$lang_data = $lang_list = Array();
	if ($dirlink = @opendir($folder)) {
		while (($file = readdir($dirlink)) !== false) {
			// Si c'est pas un dossier on passe
			if(!is_dir($folder.$file)) continue;
			// Si c'est pas de la forme lang_* on passe
			if(!preg_match('/lang_(.*)/',$file,$langue)) continue;
			//il contient le fichier version.txt ?
			if(file_exists(PATH_LANG.$file."/version.txt"))
				list($version,$nom) = file(PATH_LANG.$file."/version.txt");
			else 
				list($version,$nom) = Array("1.0",$langue[1]);
			$lang_data[strtolower($langue[1])] = Array('version'=>trim($version),'name'=>trim($nom),'folder'=>'lang_'.$langue[1]);
			$lang_list[] = strtolower($langue[1]);
		}	
	}
	return Array('data'=>$lang_data,'list'=>$lang_list);
}

/**
 * Initialisation des langues pour un module
 */
function lang_init_module($name,$folder=NULL){
	global $module_langue, $val;
	if(!isset($folder)&&isset($val['root'])) $folder = "mod/{$val['root']}/lang/";
	if(!isset($folder)) die("LANG FOLDER MISSING");
	
	$module_langue = get_langpack($folder);
	$module_langue['folder'] = $folder;
	$module_langue['name'] = $name;
	$module_langue['indexes'] = Array();

	if(isset($val['link'])) lang_module_page(str_replace('.php','',$val['link']));
}

/**
 * Retourne la langue a utiliser pour un membre
 */
function get_user_language($pack = NULL,$module=false){
	global $user_data,$server_config,$ogspy_langue;
	if(!isset($pack)) $pack = $ogspy_langue;
	// C'est une autre page, alors on cherche la langue que l'utilisateur a choisi
	if(!in_array($user_data['user_language'],$pack['list'])){
		if(LOG_LOCAL_ERROR) 
			log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
		// La langue choisie par l'utilisateur n'est pas installé, alors on se rabat sur la langue générale du serveur
		if(!in_array($server_config['language'],$pack['list'])){
			$lang_loaded = "fr";
			if(LOG_LOCAL_ERROR) 
				log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
		}else
			$lang_loaded = $server_config['language'];
	}else
		// Sinon, on prends la langue choisie par l'utilisateur
		$lang_loaded = $user_data['user_language'];	
	return $lang_loaded;
}
?>
