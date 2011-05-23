<?php
/*
Module de laison pour la Barre d'Outils OGSPY, extension firefox d'aide aux mise à jour de serveurs OGSPY

Linking MOD for OGSPY Toolbar, a firefox plugin for helping players in updating OGSPY servers game datas

Copyright (C) 2006 Naqdazar (ajdr@free.fr)

Ce programme est un logiciel libre ; vous pouvez le redistribuer et/ou le modifier
au titre des clauses de la Licence Publique Générale GNU, telle que publiée par la
Free Software Foundation ; soit la version 2 de la Licence.
Ce programme est distribué dans l'espoir qu'il sera utile, mais SANS AUCUNE GARANTIE ;
 sans même une garantie implicite de COMMERCIABILITE ou DE CONFORMITE A UNE UTILISATION PARTICULIERE. 
 
 Voir la Licence Publique Générale GNU pour plus de détails. 
 
 Vous devriez avoir reçu un exemplaire de la Licence Publique Générale GNU avec ce programme ;
  si ce n'est pas le cas, écrivez à la Free Software Foundation Inc.,
  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.

This program is free software; you can redistribute it and/or modify it under the
terms of the GNU General Public licence as published by the Free Software Foundation;
either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 See the GNU General Public License for more details.

You should have received a copy of the GNU General Public licence along with this program;
 if not, write to the Free Software Foundation, Inc., 
 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// contribution de Chapodepay … la restructuration du module OGS Plugin
  
  define("OGS_PLUGIN_DEBUG", true); // laisser la constante définie pour éviter erreur accès journaux
  define("IN_SPYOGAME", true);
	@import_request_variables('GP', "pub_");

	define("OGSPY_0304_VERCONST","3.04", true);
	define("OGSPY_0304B_VERCONST","3.04b", true);
	define("OGSPY_0301B_VERCONST","0.301b", true); // à retirer dès sélection code
	define("OGSPY_0302_VERCONST","3.02", true);
	define("OGSPY_0302C_VERCONST","3.02c", true);
	define("OGSPY_031_VERCONST","3.1", true);
	define("UNISPY_010_VERCONST","1.0", true); // version Unispy 1.0 (E-Univers)
	

  //
  define("OGSPY_SCRIPTVERSION","1.92", true);
  define("PLANETNAMEEXTRACHARS", "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËéèêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", true);
  //--------------
  // masques expressions régulières
  define("HTMLTAGREGEXP","#<\/?[^>]+>#", true); // masque pour détecter la présence de balises HTML dans un contenu
  define("PLANETLABELREGEXP","/(\S[\w\d\sé_èçàù]+\S)\s(?:\((\w+)\)(?:\s))?\[(\d:\d{1,3}:\d{1,2})\]/", true); // masque de capture nom + cas lune + coordonnées
  //----------------------------------------------------------------------------
  $OGSPY_toolbarminver1="1.5"; // doit être une valeur numérique sans elettre pour éviter les blocage de test de version
  $OGSPY_toolbarminver2="1.5";// doit être une valeur numérique sans elettre pour éviter les blocage de test de version
  //----------------------
	if ($_SERVER['HTTP_USER_AGENT']!='OGSClient') exit("<h1>Acces direct non autorise!</h1><br>Utilisez la Barre d'Outils OGSPY : <a href=\"http://ogsteam.fr/firespy/ogsplugin_last.xpi\">Telecharger/Download</a> | <a href=\"http://naqdazar.goldzoneweb.info/forum/index.php\">Forum</a>");


  ## VIDAGES TAMPONS - NECESSAIRE POUR DEFINITION header HTTP ##
  while (@ob_end_clean());
  ob_start(); // ignore any echos to be sure that header() works
  ##############################################################################
	// substition de require("common.php"); // test formattage paramètre pose problème
	//Appel des fonctions
	require_once("parameters/id.php");
	require_once("includes/config.php");
	require_once("includes/functions.php");
	require_once("includes/mysql.php");
	require_once("includes/log.php");
	require_once("includes/galaxy.php");
	require_once("includes/user.php");
	require_once("includes/sessions.php");
  // ----------------------------------------------------	
  require_once("mod/naq_ogsplugin/ogsplugin_ogsinc.php"); ///Ogame/OGSpy/mod/naq_ogsplugin/ogsplugin_ogsinc.php
  require_once("mod/naq_ogsplugin/ogsplugin_functions.php");           
  require_once("mod/naq_ogsplugin/ogsplugincl.php");
	##############################################################################
  //
	/////////////////////////////////////////////////////////////////////////////////////
	// initialisation variables locales //tir‚es de function user_ogs_login() user.php //
	/////////////////////////////////////////////////////////////////////////////////////

	global $fp, $db, $user_data, $user_info, $user_auth, $user_name;
	//
	$totalplanet=0;
	$totalupdated=0;
	$totalinserted=0;
	$totalfailed=0;
	$totalcanceled=0;
	//
	$playerranktables301 = array(TABLE_RANK_POINTS, TABLE_RANK_FLEET, TABLE_RANK_RESEARCH);
	$playerranktables302 = array(TABLE_RANK_PLAYER_POINTS,	TABLE_RANK_PLAYER_FLEET, TABLE_RANK_PLAYER_RESEARCH);
	$allyranktables302 = array(TABLE_RANK_ALLY_POINTS,		TABLE_RANK_ALLY_FLEET, TABLE_RANK_ALLY_RESEARCH);
	$statsranktypestrings = array ('general', 'fleet', 'research');
	//
  ///////////////////////////////
	//CONNECTION BASE DE DONNEES //
	///////////////////////////////
	//  effectué dans common.php via la classe sql_db
	//
	//
  // Vérification du dossie débug.
	OGSPlugin_CheckDebugDir();
	//
  /* CREATION JOURNAL DEBOGGAGE */
  OGSPlugin_CreateDebugLog();
  //
	/* EST-CE UN APPEL D'UN PLUGIN OGSPY */
  if (($pub_webagent=="ogsplugin") or ($_SERVER['HTTP_USER_AGENT']=='OGSClient'))
	   $is_ogsplugin = true; else $is_ogsplugin = false;
  //
  /* INITIALISATION DB */
  if (OGSPlugin_InitDB()==false) SendHttpStatusCode("750"); // serveur mysql indisponible;
  //
  /* INITIALISATION VARIABLES SERVEUR CONFIG */
  init_serverconfig(); // fonction disponible serveur
  //global $server_config;
  
  	// détermination du type de serveur hébergeant : OGSPY ou UNISPY

	if ((strcasecmp($server_config["version"],"3.10")>=0 || strcasecmp($server_config["version"],"1.0")>=0) && file_exists('includes/univers.php')) {
      define("SERVER_IS_UNISPY", true);
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "==> Le type de serveur hébergeant détecté est UNISPY!\n");
      
      // inclusion des chaînes de langue d'analyse pour les fonctions du serveur appelées
    	if (!empty($server_config['language_parsing'])) {
    		include_once("language/lang_".$server_config['language_parsing']."/lang_parsing.php");
    	} else require_once("language/lang_french/lang_parsing.php");
      
  } else if ((strcasecmp($server_config["version"],"3.10")>=0 || strcasecmp($server_config["version"],"3.02")>=0) && file_exists('includes/ogame.php')) {
      define("SERVER_IS_OGSPY", true);
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "==> Le type de serveur hébergeant détecté est OGSPY!\n");
      
      if (strcasecmp($server_config["version"],"3.10")>=0) {
      
          // inclusion des chaînes de langue d'analyse pour les fonctions du serveur appelées
        	if (!empty($server_config['language_parsing'])) {
        		include_once("language/lang_".$server_config['language_parsing']."/lang_parsing.php");
        	} else require_once("language/lang_french/lang_parsing.php");
      
      }
  }
  
  /*  Activation débogage depuis le panneau d'administration du module */
	if ($server_config["naq_ogsactivate_debuglog"]==0) define("OGS_PLUGIN_DEBUG", false);
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Initialisation des variables serveurs: ".isset($server_config)." \n");
  //

  //
  //
  /* Récupération et encodage de l'adresse ip */
	$user_ip = $_SERVER['REMOTE_ADDR'];
	//
  /* Vérifier que le module OGS Plugin n'est pas désactivé */
  if (OGSPlugin_IsTargetModActive('naq_ogsplugin')==false) SendHttpStatusCode("796"); // notification que le module est désactivé
  
  /**
   * Initiliasaiton variables spécifique E-Univers
   **/
   $pub_xp_mineur = 0; // 0 pour l'instant sinon lire depuis db
   $pub_xp_raideur = 0;

	
	?>
