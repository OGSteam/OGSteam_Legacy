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
 /*
	* Status Codes returned to firefox plugin(complete list in ogsplugin.js):
	- 701: OGS galaxy updated
	- 702: OGplg_getplanetidbycoord(plg_ImportRanking_ally())S problem with inserting galaxy view
	- 711: OGS report inserted
	- 712: OGS at least one report was wrong
	- 713: no ogs report inserted
	- 721: OGS stats updated
	- 722: OGS stats not updated
	- 723: OGS stats sent  // issue traitement indéterminée
	- 724: OGS - can't export rankink stats to server - forbidden
	- 725: OGS all stats not updated");
	- 731: OGS allyhistory updated
	- 732: OGS allyhistory not updated
	- 750: OGS serveur sql indisponible - mysqldb not available
	- 752: échec d'authentification - authentification failed
	- 753: login / mot de passe absent - login / password missing
	- 754: pas la permissson d'importer
	- 755: compte inactif
	- 771: getcommand ok
	- 773: getcommand failed
	- 790: script de de liaison OGS en maintenance
	- 799: non implementée
	*/ // attention dans les tests d'égalité =(affectation)<>==(comparaison)
	//

// contribution de Chapodepay à la restructuration du module OGS Plugin

  ###################################################################################
	## chargement du script d'initialisation, définitions des variables et fonctions ##
	###################################################################################
  // echo "entrée\n";
global $fp;
	
include_once ("mod/naq_ogsplugin/ogsplugin_init.php"); // require_once
	###################################################################################
  // if (defined("OGS_PLUGIN_DEBUG")) echo "retour ogsplugin_init\n";



  /****************************************
  ** EXTRACTION DES PARAMÈTREs DU PLUGIN **
  *****************************************/

if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "init_serverconfig ok?: ".isset($server_config)." \n");
$naq_config=OGSplugin_load_config();
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, print_r($naq_config));
extract($naq_config);
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "\nInitialisation variable plugin terminée: retour OGSplugin_load_config \n");
//

/* gestion des commandes toolbar */
require("mod/naq_ogsplugin/ogsplugin_cmdsman.php");
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "=> Éxecution des commandes toolbar terminée\n");

/****************************************
** CONTROLE PROVENANCE DONNÉES SERVEUR **
****************************************/
//

/* contrôle que le serveur signalé est attendu par le module */
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "=> Appel OGSPlugin_AllowDataFromUniverse\n");
OGSPlugin_AllowDataFromUniverse();
//
	

//
## REDIRECTION MANUELLE? ##
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "=>Appel OGSPlugin_ShouldRedirect\n");
OGSPlugin_ShouldRedirect();
//
## test serveur ogspy ok ou down ##
OGSPlugin_IsOGSPYServerDown();
//
//global $rows;
// if ($pub_webagent=="ogsplugin") $_SERVER['HTTP_USER_AGENT']="OGSClient";
//
$session_time = $server_config['session_time'];
// Définition variable identification plugin ogs
  
//============================================================================
############################################
## VERROUILLAGE VERSION EXTENSION FIREFOX ##
############################################
//
OGSPlugin_ShouldBlockFrxPlugin();
//
//============================================================================
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "server web browser: ".$_SERVER['HTTP_USER_AGENT'].", IP client:".$_SERVER['REMOTE_ADDR']."\n");
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Univers d'origine: ".$pub_realogameserver."\n");
//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "typ:" .$_POST['typ']."-".$pub_content."\n");
//
$ogspy_server_version = Get_OGServer_Version(); // détection version serveur
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Version serveur détectée: ($ogspy_server_version) server_config[version]:".$server_config["version"]." | Version plugin détectée: ".$pub_pluginversion."\n");
//
//if (isset($pub_typ)) // revoir code suivant
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Type d'action requise: ".$pub_typ."...\n"); // ligne débug , commentaire si pas utile// ligne débug , commentaire si pas utile
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"POST[webagent]: ".$pub_webagent." - webbrowser: ".$pub_webbrowser." count _post: ".count($_POST)."-".count($SESSION)."\n");
//
## AUTHENTIFICATION UTILISATEUR ##
OGSPlugin_UserAuth();
global $user_id;
//session_set_user_id($user_id); // ajout comme dans user_ogs_login
//
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"définition user_data user_id\n");
$user_data["user_id"] =	$user_id;
$user_data["user_name"] = $pub_user;
//
// pour les dates de connection en 1970 c'est ici que ça se passe mais est-ce que le serveur php foire?
//session_set_user_id($user_id, $user_lastvisit);
$now = time();
if ($now==0) {
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"réinitialisation de la variable now!!!\n");
	$now = time();
}
//
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Appel OGSPlugin_VerifSessionValide");
OGSPlugin_VerifSessionValide();
//
///////////////////////////////////////////////////
// VERIFICATION AUTORISATION CONNEXION OGS 0.302 //
///////////////////////////////////////////////////
// test variable spécifique ogspy 0.302
global $ogs_connection;
if (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST)) {
	if (!$ogs_connection) {
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"connection ogs interdite!\n");
		SendHttpStatusCode("756") ;
	}
	// liste vars ogspy 0.302 : ogs_connection /	ogs_set_system / ogs_set_spy / ogs_set_ranking
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,($ogs_set_system ? 'ogs_set_system ok ' : 'ogs_set_system interdit')+"\n");
}
//
//================================== GESTION SESSIONS===================================
// OGSPlugin_session(); // fonction chapodepay non utilisée: provoque erreur droit si user dans plusieurs groupes
//======================================================================================
//	
// TEST TYPE OPERATION REQUISE -  DEBUT TRAITEMENT DONNEES  //	
//
$timerankdata = To_Std_Update_Time(time()) ; // $datedonnees = date("H:i:s"); 00h00/8h00/16h00 ou 00/08/12/18 (E-Univers)
//
if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> typ: ".$pub_typ.", who: ".$pub_who.",	what: ".$pub_what." allowed insert:".$user_auth_import_web."\n");// ligne débug , commentaire si pas utile
// Début boucle traitements
// les commandes perminentes à traiter ici sont $pub_typ==
// les autres test seront intégrées dans les fonctions concernées
	
#################################"##############################################
/**
 * $pub_gametype == 'ogame'|'eunivers' - paralmètres envoyé par l'extension Firespy
 * permet d'appeller une fonction de traitement spécifique si nécessaires.
 * les fonctions de traitement galaxies, classements et rapports sont identiques pour Ogame et E-Univers eg
 * permettent de traiter par une même fonction des données différentes
 * $pub_typ indique le type de traitement à effectuer sur les données $pub_content
 *
 * SendHttpStatusCode("799") signifie au client que la fonction demandée
 * n'est pas prise en charge par le module OGS Plugin
 *
 **/
global $pub_gametype;
if(isset($pub_typ))
	switch($pub_typ){
		case 'stats':
			OGSPlugin_Traitement_Stats();
			break;

		case 'galaxy':
			OGSPlugin_Traitement_Galaxie();
			break;

		case 'galaxyraw':
			if ($pub_gametype == 'ogame')
			OGSPlugin_Traitement_Galaxyraw();
			break;

		case 'reports':
			OGSPlugin_Traitement_Messages();
			break;

		case 'combreports':
			if ($pub_gametype == 'ogame') 
				OGSPlugin_Traitement_RCombat();
			else 
				SendHttpStatusCode("799");
			break;
  
		case 'allyhistory':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Allyhistory();
			else 
				SendHttpStatusCode("799");
			break;
      
		case 'buildings':	
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Batiments();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'resources':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Ressources();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'technos':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Laboratoire();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'shipyard':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_ChantierSpatial();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'flotten':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Flotte();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'defence':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_Defense();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'planetempire':
			if ($pub_gametype == 'ogame' || $pub_gametype == 'eunivers')
				OGSPlugin_Traitement_EmpirePlanetes();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'moonempire':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_EmpireLunes();
			else
				SendHttpStatusCode("799");
			break;
      
		case 'planetdetails':
			if ($pub_gametype == 'ogame')
				OGSPlugin_Traitement_DetailsPlanete();
			else
				SendHttpStatusCode("799");
			break;
      
		default:
			SendHttpStatusCode("799");
			break;
	} 
else { // aucun param exploitable trouvé
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"nothing found...\n"); // ligne débug , commentaire si pas utile
	if (defined("OGS_PLUGIN_DEBUG") && !isset($pub_content)) fwrite($fp,"pub_content non défini...\n");
	if (defined("OGS_PLUGIN_DEBUG") && !$pub_content=="") fwrite($fp,"pub_content vide...\n");
	if (defined("OGS_PLUGIN_DEBUG") && !isset($pub_planetsource)) fwrite($fp,"pub_planetsource non défini ...\n");
	if (defined("OGS_PLUGIN_DEBUG") && $pub_planetsource=="") fwrite($fp,"pub_planetsource vide ...\n");
	SendHttpStatusCode("757", true, true); // commande de traitement inconnue
}
################
## FIN SCRIPT ##
###################################################################################
## chargement du script de fin                                                  ###
###################################################################################
OGSPlugin_Terminate();
###################################################################################

?>
