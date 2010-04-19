<?php
/**
* Fonctions concernant les modules unispy
* @author Kyser et OGSteam
* @version 1.0 Beta
* @package UniSpy
* @link http://www.ogsteam.fr
* @licence GPL
*/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

/**
* Récupération de la liste des modules
* Utilise les variables $pub_
* @return array $mod_list = array("disabled" => array(), "actived" => array(), "wrong" => array(), "unknown" => array(), "install" => array());
*/
function mod_list() {
	global $db, $user_data;
	global $pub_orderasc; //  modifs pour fonctions Nqz

/*	if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1)
	redirection("index.php?action=message&id_message=forbidden&info");
*/
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
	// ajout Naqdazar, choix ordre de tri
    if (isset($pub_orderasc)) {
       if ($pub_orderasc=="menupos") $orderasc_token = "menupos, position";
       elseif ($pub_orderasc=="title") $orderasc_token = "title";
       else $orderasc_token = "position"; // par défaut
    }  else $orderasc_token = "position";

	$request = "select id, title, menupos, noticeifnew, catuser, root, link, version, active, position from ".TABLE_MOD." order by ".$orderasc_token;
	$result = $db->sql_query($request);
	while (list($id, $title, $menupos, $noticeifnew, $catuser, $root, $link, $version, $active, $position) = $db->sql_fetch_row($result)) {
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
					$mod_list["disabled"][] = array("id" => $id, "title" => $title, "version" => $version, "up_to_date" => $up_to_date,
                                                                        "menupos" => $menupos, "noticeifnew" => $noticeifnew,  "catuser" => $catuser, "position" => $position);
				}
				else { //Mod activé
					$mod_list["actived"][] = array("id" => $id, "title" => $title, "version" => $version, "up_to_date" => $up_to_date,
                                                                       "menupos" => $menupos, "noticeifnew" => $noticeifnew, "catuser" => $catuser, "position" => $position, "root" => $root);
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
				$mod_list["install"][] = array("title" => $line[0],"directory" => key($directories),
				                               "menupos" => $menupos, "noticeifnew" => $noticeifnew,  "catuser" => $catuser, "position" => $position);
			}
		}
		next ($directories);
	}

	return $mod_list;
}

/**
* admin: Verification de la validité d'un module
* Utilise les variables $pub_
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
* Ajout/Installation d'un mod
* Utilise la variable $pub_directory
*/
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
		if($position == '-1') $position = '8';
		
		$request = "update ".TABLE_MOD." set root = '".$pub_directory."', position = ".($position+1)." where id = ".$mod_id;
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
* Utilise la variable $pub_mod_id;
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
* Utilise la variable $pub_mod_id
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
* Utilise la variable $pub_mod_id
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
* Utilise la variable $pub_mod_id
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

/**
* Ordonnancement des mod
* Reagencement des mods
* @param string $order 'up','down' deplacement vers le haut/bas
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
*Récupère le paramètre action du mod actif et renvoi la version de ce mod prise sur la BDD
*/
function versionmod() {
    global $db, $pub_action;
    $query = "SELECT version FROM ".TABLE_MOD." WHERE action = '".mysql_real_escape_string($pub_action)."' LIMIT 1";
    $result = $db->sql_query($query);
    $fetch = $db->sql_fetch_assoc($result);
    return $fetch['version'];
}


/**
* Modification des propriétés d'un mod
* Utilise les variables $pub_
* @return 
*/
function mod_modify_props() {
  	global $db;
	  global $pub_mod_id, $pub_noticeifnew, $pub_orderpos, $pub_orderasc, $pub_menupos; //, $pub_posmove;
	
    $request = "select MAX(position) from ".TABLE_MOD;
	  $result = $db->sql_query($request);
	  list($maxpos) = $db->sql_fetch_row($result);
    $maxpos ++;
	$maxpos += 16;

    $target_orderpos = $pub_orderpos; // + $step_orderid;

    
    // récupération position du mod à déplacer
    $request = "select position from ".TABLE_MOD." where id=".$pub_mod_id;
	  $result = $db->sql_query($request);
	  list($startpos) = $db->sql_fetch_row($result);    
    
    if (isset($pub_mod_id) and isset($pub_orderpos)) {
        // recherche d'un module à la position de déplacement voulu(conflit?)
        $request = "select id from ".TABLE_MOD." where id=".$target_orderpos;
        $conflict_module_pos = $db->sql_query($request);
        
        
        // l'élement existant à la position $target_orderpos est déplacé en position $maxpos pour échange
        if ($db->sql_numrows($result) >0) {  // Axel, test si module préexistant avec le rang voulu pour mod_id
           // mise en variable id du module intermédiaire
           list($interm_mod) = $db->sql_fetch_row($result); 
           
           // déplacement du module intermédiaire en position extrème(dernière)
           $request = "update ".TABLE_MOD." set position=".$maxpos." where position=".$target_orderpos;
           $conflictual_mod_moved = $db->sql_query($request);
        }
        
        // déplacement du module à la position voulu ($pub_orderpos)
   	    if ($result || !$conflict_module_pos) { // tests à valider
           $request = "update ".TABLE_MOD." set position=".$target_orderpos
                      .(isset($pub_noticeifnew) ? " ,noticeifnew=".$pub_noticeifnew : "")
					  .(isset($pub_menupos) ? " , menupos=".$pub_menupos : "")
                      .((isset($pub_noticeifnew) && $pub_noticeifnew==1) ? " , dateinstall=".time() : "")
                      ." where id=".$pub_mod_id;
           $result = $db->sql_query($request);
        }
        
        
        if ($result || $conflictual_mod_moved) { // tests à valider
   	       $request = "update ".TABLE_MOD." set position=".$startpos." where position=".$maxpos;
        $result = $db->sql_query($request);
        }
    }
    //echo "<a href=\"index.php?action=administration&subaction=mod&orderasc=".$pub_orderasc."\">retour</a>";
    redirection("index.php?action=administration&subaction=mod&orderasc=".$pub_orderasc);
}




/**
* fonction tri des menus de module alphabtique/croisant
*/
function mod_dbsort_bytitle() {
         global $db;

         //-------------------------------------------------

         $request = "select id, menu from ".TABLE_MOD." where menupos>0 order by menu ASC";
	       $result = $db->sql_query($request, true, false);

         $mod_sorting_tab[] = array("title" , "oldid" );
         $cpt=1;

         // lecture éléments table mod dans l'ordre et déplacement
         while (list($id, $title, $position ) = $db->sql_fetch_row($result)) {
            $sort_request="UPDATE ".TABLE_MOD." SET position=".$cpt." WHERE id=".$id;
            $sort_result = $db->sql_query($sort_request, true, false);
            $cpt++;
          }
          redirection("index.php?action=administration&subaction=mod");
}

/**
* Affichage du menu des mods par catégories
* Note Rica: il ne devrait pas y avoir de code html dans cette fonction... c'est dans views/ que ca devrait se faire
* A deplacer
*/
function mod_show_menupos($menupos,$sep_before=true, $sep_after=false, $width_sep=110) {
         global $db, $link_css, $user_data;
         // fonction seulement appelable depuis menu.php

         $request = "select id, action, menu, tooltip, dateinstall, updated, noticeifnew, root, link from ".TABLE_MOD." where active = 1 and menupos=".$menupos." ORDER BY position";
         $result = $db->sql_query($request);
         if ($db->sql_numrows($result)) {
		if ($sep_before) echo "<tr>\n\t<td class=\"c\" height=\"20\">&nbsp;</td>\n</tr>";
	    while ($val = $db->sql_fetch_assoc($result)) {
		if (user_as_perms($user_data['user_id'],$val['id']) || $user_data['user_admin'] == 1){
		$menuitem  = '<tr><th><div align="center"';
		
                       $menuitem .= '><a href="index.php?action='.$val['action'].'"';

                       if ($val['tooltip']!="") {
                          $menutooltip = htmlentities($val['tooltip']);
                          $menuitem .= ' onmouseover="this.T_WIDTH=210;this.T_STICKY=true;this.T_TEMP=0;return escape(\''.$menutooltip.'\');";';
                       }
                       // affichage libellé menu perso suivant date install et options

                       if (($val['updated']==1) || ($val['noticeifnew']==1)) { // hors menu header
                          if ((date('d')-date('d', $val['dateinstall']))<1) {
                             $menuitem .=  '><b><i><font color="green">'.$val['menu'].'</font></i></b>'; }
                          elseif ((date('d')-date('d', $val['dateinstall']))<3) {
                                 $menuitem .=  '><b><i>'.$val['menu'].'</i></b>'; }
                          else $menuitem .= '>'.$val['menu']; // au delà de huit jour après l'install->libellé normal
                          
                          if ($val['updated']==1) $mod_event_caption = 'MAJ!';
                          elseif ($val['noticeifnew']==1) $mod_event_caption = 'NOUVEAU!';

                          if ((date('d')-date('d', $val['dateinstall']))<2) {$menuitem .=  '<blink><br>(<i>'.$mod_event_caption.'</i>)</blink>';}
                          elseif  ((date('d')-date('d', $val['dateinstall']))<5) {$menuitem .=  '<blink><br>('.$mod_event_caption.')</blink>'; }
                          elseif  ((date('d')-date('d', $val['dateinstall']))<8) {$menuitem .=  '<br>('.$mod_event_caption.')'; };


                       }  else $menuitem .= '>'.$val['menu'];

                       // fermeture de la balise de lien
                       $menuitem .= '</a>'; // fermeture balise href/lien si menu non header

                // fermeture des balises
                $menuitem .= '</div></th></tr>';
                
                // finalement, affichage élément menu
                echo $menuitem."\n";

	        }}
	        if ($sep_after) echo '<tr>\n\t<td class="c" height="20">&nbsp;</td>\n</tr>';
         }
         //<!-- Fin des mods /-->
}
?>
