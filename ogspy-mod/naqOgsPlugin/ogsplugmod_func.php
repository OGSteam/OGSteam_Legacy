<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt");


function ogsplugin_help($key, $txt_contenu="", $titre = 'Aide / Help', $largeur = 200, $prefixe = "") {

  global $help;

	// vérification de $largeur
	if (!is_numeric($largeur))
		$largeur = 400;

	if (!isset($help[$key]) || is_null($key) ) {
	   if ($txt_contenu=="") return;
	   else $value=$txt_contenu;
	}

	if (isset($help[$key])) {
		$value = $help[$key];
	}

	$text = '<table width="'.$largeur.'">';
	$text .= "<tr><td align=\"center\" class=\"c\">$titre</td></tr>";
	$text .= "<tr><th align=\"center\">".addslashes($value)."</th></tr>";
	$text .= "</table>";

	$text = htmlentities($text);
	$text = "this.T_WIDTH=$largeur;this.T_TEMP=0;return escape('".$text."')";

	return "<img style=\"cursor:pointer\" src=\"".$prefixe."images/help_2.png\" onmouseover=\"".$text."\">";
}

/**
 * Copie le fichier ogsplugin.php à la racine du serveur
 **/
function ogsmod_copyogsplugin() {
      # Copie du script de liaison à la racine du serveur OGSPY
      //chmod ("/", 700);
      //if(!is_writable("/")) chmod("/", 0755);
      
      // est-ce que le fichier cible est inscriptible et existe?
      if(!is_writable("ogsplugin.php") && file_exists("ogsplugin.php")) chmod("ogsplugin.php", 0755);
      else if(!is_writable("/")) chmod("/", 0755); // mise à jour des droits de la racine

      $res_copy = copy ( "mod/naq_ogsplugin/ogsplugin.php", "ogsplugin.php" );
      
       echo $res_copy;

      if ($res_copy==false) {?>
      <script>
        alert("La copie du fichier /mod/naq_ogsplugin/ogsplugin.php vers la racine du serveur a échoué.\n\n"+
        "Veuillez effectuer l'opération manuellement afin d'assurer la prise en compte\n"+
        "des modifications et corrections de code du module OGS Plugin.");
      </script>
      <?php }

     

    
}

/**
 * récupère les permissions d'un fichier supporté par chmod
 * (source: php.net)
 **/
function file_getmod($filename) {
   $val = 0;
   $perms = fileperms($filename);
   
   // Utilisateur / Propriétaire
   $val += (($perms & 0x0100) ? 0x0100 : 0x0000); //Lecture
   $val += (($perms & 0x0080) ? 0x0080 : 0x0000); //Écriture
   $val += (($perms & 0x0040) ? 0x0040 : 0x0000); //Éxecution

   // Groupe
   $val += (($perms & 0x0020) ? 0x0020 : 0x0000); //Lecture
   $val += (($perms & 0x0010) ? 0x0010 : 0x0000); //Écriture
   $val += (($perms & 0x0008) ? 0x0008 : 0x0000); //Éxecution

   // Tout le monde
   $val += (($perms & 0x0004) ? 0x0004 : 0x0000); //Lecture
   $val += (($perms & 0x0002) ? 0x0002 : 0x0000); //Écriture
   $val += (($perms & 0x0001) ? 0x0001 : 0x0000); //Éxecution

   // Divers
   $val += (($perms & 0x40000) ? 0x40000 : 0x0000); //temporary file (01000000)
   $val += (($perms & 0x80000) ? 0x80000 : 0x0000); //compressed file (02000000)
   $val += (($perms & 0x100000) ? 0x100000 : 0x0000); //sparse file (04000000)
   $val += (($perms & 0x0800) ? 0x0800 : 0x0000); //Hidden file (setuid bit) (04000)
   $val += (($perms & 0x0400) ? 0x0400 : 0x0000); //System file (setgid bit) (02000)
   $val += (($perms & 0x0200) ? 0x0200 : 0x0000); //Archive bit (sticky bit) (01000)

   return $val;
}

/**
 * Création du répertoire pour les fichiers débug si inexistant
 **/
function ogsmod_createdebugdir() {

      if (!is_dir("mod/naq_ogsplugin/debug")) mkdir("mod/naq_ogsplugin/debug", 0766);
      $res_chmod = chmod("mod/naq_ogsplugin/debug/", 0766); // droits d'écriture sur le répertoire debug

      if ($res_chmod==false) {?>
          <script>
          alert("La modification des droits en écriture du dossier /debug ou des ses fichiers a échoué.\n"+
          "Chez certains fournisseur d'hébergement cela n'a pas d'incidence(ex: chez Free).\n"+
          "Dans les autres cas, si vous obtenez des erreurs de gestion de fichier,\n"+
          "veuillez effectuer un chmod(0766) sur le dossier /debug et son contenu\n"+
          "afin de permettre le bon déroulement de la journalisation.");
          </script>
          <?php
      }
}

/**
 * Met à jour une valeur de la table config
 **/
function set_configvalue($valuename, $content, $escape_string=true) {
        global $db, $server_config;
        
        if(!isset($server_config[$valuename])) { // si la valeur n'existe pas
            $request = "insert ignore into ".TABLE_CONFIG." (config_name, config_value) values ('$valuename', '".(is_string($content) && $escape_string ? mysql_escape_string($content) : $content)."')";
          	$db->sql_query($request);
        
        } else  // effectue un test pour vérifier que la valeur a été modifiée avant de faire une mise à jour
        if (strcasecmp($server_config[$valuename], $content) != 0) {
          	$request = "update ".TABLE_CONFIG." set config_value = '".(is_string($content) ? mysql_escape_string($content) : $content)."' where config_name = '".mysql_escape_string($valuename)."'";
          	$db->sql_query($request);
      	}
}

/**
 * Change la position du menu du module (ogspy ver3.1dev et plus)
 **/
function OGSPlugin_set_menupos($par_menupos=3) {
        global $db;
        $request = "update ".TABLE_MOD." set menupos = '".(int)$par_menupos."' WHERE action='naq_ogsplugin';";
      	$db->sql_query($request);
}

/**
 * Enregistre toutes les variables du formulaire d'administration
 **/
function set_ogspluginconfig() {
        global $db;
        global $pub_modlanguage, $pub_newmenupos, $pub_gametype;
        global $pub_logogslogon, $pub_logogsspyadd, $pub_logogsgalview, $pub_logogsplayerstats, $pub_logogsallystats,
        $pub_logogsallyhistory, $pub_logogssqlfailure;
        global $pub_logogsuserbuildings, $pub_logogsusertechnos, $pub_logogsuserdefence;
        global $pub_logogsuserplanetempire, $pub_logogsusermoonempire;
        global $pub_forceupdate_outdatedext, $pub_ogsactivate_debuglog;
        global $pub_ogsplugin_numuniv, $pub_ogsplugin_nameuniv, $pub_ogsportailurl;
        global $pub_forcestricnameuniv, $pub_logunallowedconnattempt; // à completer
        global $pub_handlegalaxyviews, $pub_handleplayerstats, $pub_handleallystats, $pub_statshoursaccept, $pub_handleespioreports;
        global $pub_ogsalliednames, $pub_ogsenemyallies, $pub_ogstradingallies, $pub_ogspnaalliesnames;
	      global $pub_notifyplugredirect, $pub_plugredirectmsg;

         // langue interface module
      	set_configvalue('naq_modlanguage', $pub_modlanguage);
      	
         // position du menu
      	set_configvalue('naq_newmenupos', $pub_newmenupos);

        // Type Jeu Ogame ou EUnivers
        set_configvalue('naq_gametype', $pub_gametype);

        //
      	set_configvalue('naq_logogslogon', $pub_logogslogon);

        //
      	set_configvalue('naq_logogsspyadd', $pub_logogsspyadd);

        //
      	set_configvalue('naq_logogsgalview', $pub_logogsgalview);

        //
      	set_configvalue('naq_logogsplayerstats', $pub_logogsplayerstats);

        //
      	set_configvalue('naq_logogsallystats', $pub_logogsallystats);

        //
      	set_configvalue('naq_logogsallyhistory', $pub_logogsallyhistory);

      	//Pages bâtiments, technos, etc

        //logogsuserbuildings
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserbuildings."' where config_name = 'naq_logogsuserbuildings'";
      	$db->sql_query($request);

        //logogsusertechnos
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsusertechnos."' where config_name = 'naq_logogsusertechnos'";
      	$db->sql_query($request);

        //logogsuserdefence
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserdefence."' where config_name = 'naq_logogsuserdefence'";
      	$db->sql_query($request);


      	//Pages empires
      	//logogsuserplanetempire
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsuserplanetempire."' where config_name = 'naq_logogsuserplanetempire'";
      	$db->sql_query($request);

        //logogsuserplanetmoon
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogsusermoonempire."' where config_name = 'naq_logogsusermoonempire'";
      	$db->sql_query($request);

        //logunallowconnattempt
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logunallowedconnattempt."' where config_name = 'naq_logunallowedconnattempt'";
      	$db->sql_query($request);


      	// Gestion des pages

      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handlegalaxyviews."' where config_name = 'naq_handlegalaxyviews'";
      	$db->sql_query($request);

      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handleplayerstats."' where config_name = 'naq_handleplayerstats'";
      	$db->sql_query($request);

      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_handleallystats."' where config_name = 'naq_handleallystats'";
      	$db->sql_query($request);
      	
        // Créneau horaires autorisés
      	set_configvalue('naq_statshoursaccept', $pub_statshoursaccept);

      	set_configvalue('naq_handleespioreports', $pub_handleespioreports);


        // Rubrique divers // .$pub_forceupdate_outdatedext.".$pub_ogsactivate_debuglog."

      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_forceupdate_outdatedext."' where config_name = 'naq_forceupdate_outdatedext'";
      	$db->sql_query($request);

      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsactivate_debuglog."' where config_name = 'naq_ogsactivate_debuglog'";
      	$db->sql_query($request);

        // forcestricnameuniv - bloquer les données provenant de serveur ogame non associé
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_forcestricnameuniv."' where config_name = 'naq_forcestricnameuniv'";
      	$db->sql_query($request);

        //
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_logogssqlfailure."' where config_name = 'naq_logogssqlfailure'";
      	$db->sql_query($request);

      	//
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogsplugin_numuniv."' where config_name = 'naq_ogsplugin_numuniv'";
      	$db->sql_query($request);


        //
      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogsplugin_nameuniv)."' where config_name = 'naq_ogsplugin_nameuniv'";
      	$db->sql_query($request);


        //
      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogsportailurl)."' where config_name = 'naq_ogsportailurl'";
      	$db->sql_query($request);

      	// version http -

      	//$request = "update ".TABLE_CONFIG." set config_value = '".$pub_ogshttp_headerver."' where config_name = 'naq_ogshttp_headerver'";
      	//$db->sql_query($request);

      	// diplomatie

      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogsalliednames)."' where config_name = 'allied'";
      	$db->sql_query($request);
        //
        $request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogspnaalliesnames)."' where config_name = 'naq_ogspnaalliesnames'";
      	$db->sql_query($request);
      	//
      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogsenemyallies)."' where config_name = 'naq_ogsenemyallies'";
      	$db->sql_query($request);
      	//
      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_ogstradingallies)."' where config_name = 'naq_ogstradingallies'";
      	$db->sql_query($request);

        // plugin redirection
        //	      global $notifyplugredirect, $plugredirectmsg;
      	$request = "update ".TABLE_CONFIG." set config_value = '".$pub_notifyplugredirect."' where config_name = 'naq_notifyplugredirect'";
      	$db->sql_query($request);
      	//
      	$request = "update ".TABLE_CONFIG." set config_value = '".mysql_escape_string($pub_plugredirectmsg)."' where config_name = 'naq_plugredirectmsg'";
      	$db->sql_query($request);


        redirection("index.php?action=naq_ogsplugin");
}

function list_dir_files($dir) {
      $dir = "/tmp/php5";

      // Ouvre un dossier bien connu, et liste tous les fichiers
      if (is_dir($dir)) {
          if ($dh = opendir($dir)) {
              while (($file = readdir($dh)) !== false) {
                  echo "fichier : $file : type : " . filetype($dir . $file) . "\n";
              }
              closedir($dh);
          }
      }
}

?>
