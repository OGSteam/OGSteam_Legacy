<?php
/********************************************************************/
if (!defined('CARTO')) die("Hacking attempt");
define('LOG_LOCAL_ERROR',isset($server_config['log_langerror'])&&$server_config['log_langerror']==1);

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
			if(isset($user_data['user_language'])) {
				if(!in_array($user_data['user_language'],$pack['list'])){
					if(LOG_LOCAL_ERROR) 
						log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
					// La langue choisie par l'utilisateur n'est pas installé, alors on se rabat sur la langue générale du serveur
					if(isset($server_config['language'])) {
						if(!in_array($server_config['language'],$pack['list'])){
							$lang_loaded = "fr";
							if(LOG_LOCAL_ERROR) 
								log_('local lang missing',Array($server_config['language'],$module?$module_langue['name']:'OGSpy'));
						}else
							$lang_loaded = $server_config['language'];
					} else $lang_loaded = "fr";
				}else
					// Sinon, on prends la langue choisie par l'utilisateur
					$lang_loaded = $user_data['user_language'];
			} else $lang_loaded = 'fr';
	//echo "lang_loaded:$lang_loaded";
	// formatage du chemin vers le fichier de langue
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
	global $lang_loaded,$page_loaded,$ogspy_langue;
	$args = ''; $a = Array();
	$n = func_num_args();
	for ($i=2; $i<$n; $i++){
		$a[$i] = func_get_arg($i);
		$args = ($args==''?'':$args.",").'$a['.$i.']';
	}
	if(isset($pack['indexes'][$index])&&$pack['indexes'][$index]!='')
		$str = $pack['indexes'][$index];
	elseif($pack!=$ogspy_langue&&isset($ogspy_langue['indexes'][$index])&&$ogspy_langue['indexes'][$index]!=''){
		// L'index n'existe pas dans les langues du module, mais dans les langues de OGSpy
		$str = $ogspy_langue['indexes'][$index];
	}else{
		if(LOG_LOCAL_ERROR) log_("local error",Array($index,$pack['name'],$lang_loaded,$page_loaded));
		return $index;
	}
	if($args!='') eval('$str = sprintf($str,'.$args.');');
	return $str;
}

/**
 * recherche les langues installé dans le dossier fourni (utilisé par les modules ou par OGSpy)
/**
* Recherche des langues disponibles et créé 2 tableaux en fonction
* L'un contenant la liste des langues dans leur format simple (2 lettres)
* L'autre contenant les versions et nom long de chaque langue, indéxé par les noms long.
*/
function get_langpack($folder){
	if ($dirlink = @opendir($folder)) {
		while (($file = readdir($dirlink)) !== false) {
			// Si c'est pas un dossier on passe
			if(!is_dir($folder.$file)) continue;
			// Si c'est pas de la forme lang_* on passe
			if(!preg_match('/lang_(.*)/',$file,$langue)) continue;
			//il contient le fichier version.txt ?
			/*if(file_exists(PATH_LANG.$file."/version.txt"))
				list($version,$nom) = file(PATH_LANG.$file."/version.txt");
			else */
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
function lang_init_module($name,$folder){
	global $module_langue;
	$module_langue = get_langpack($folder);
	$module_langue['folder'] = $folder;
	$module_langue['name'] = $name;
	$module_langue['indexes'] = Array();
}
?>