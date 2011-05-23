<?php

/***************************************************************************
*	filename	: ogsplugin_cmdsman.php
*	desc.		:  script de prise en charge des commandes d'éxécution de la barre d'outils
*	Author		: Naqdazar
*	created		: 8/12/2006
*	modified	: 8/12/2006 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

  global $pub_getcommand, $server_config, $db;
  global $pub_user;


  if (defined("OGS_PLUGIN_DEBUG")) $fp_plgcmds = fopen("mod/naq_ogsplugin/debug/ogsplugin_commands.txt","a+"); // fichier log commande plugin

	///////////////////////////////////////////////////////
	// COMMANDES SPÉCIALES, récupération version serveur //
	///////////////////////////////////////////////////////
        //
        if (isset($pub_getcommand)) {
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Réception commande plugin: ".$pub_getcommand."\n");
            if ($pub_getcommand=="ogspyversion") {
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Version serveur: ".$server_config["version"]."\n");
              if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
               SendHttpStatusCode("771", true, true, $server_config["version"]) ;
            }
            elseif ($pub_getcommand=="getservername") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Nom serveur: ".$server_config["servername"]."\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, $server_config["servername"]) ;
            }
            elseif ($pub_getcommand=="probenotifymode") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande recherche du mode de notification...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771") ;
            }
            elseif ($pub_getcommand=="getscriptversion") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande version script...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, OGSPY_scriptversion) ;
            }
            elseif ($pub_getcommand=="getfriendlyallys") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste alliance amies...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, $server_config['allied']) ;
            }
            elseif ($pub_getcommand=="getcatallieslists") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste alliance amies, enemies, commerciales...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, $server_config['allied']."<|>".$server_config['naq_ogspnaalliesnames']."<|>".$server_config['naq_ogsenemyallies']."<|>".$server_config['naq_ogstradingallies']) ;
            }
            elseif ($pub_getcommand=="gettop100playerslist") {
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste top 100 joueurs...\n");
                   //-------------
                  $tmpgc_timerankdata = To_Std_Update_Time(time()) ; 
                	$request = "select player from ".TABLE_RANK_PLAYER_POINTS." where rank<101 and datadate='".$tmpgc_timerankdata."'";
                	$result = $db->sql_query($request);
                  $topplayerslist="";
                  $tpllst_sep="";
                	while (list($player) = $db->sql_fetch_row($result)) {
                		$toppalyerslist.=$tpllst_sep.$player;
                		$tpllst_sep=",";
                	}
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "liste top 100 joueurs:".$toppalyerslist."\n");
                  if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);                   
                   //--------------
                   SendHttpStatusCode("771", true, true, $toppalyerslist) ;
            }
            elseif ($pub_getcommand=="getogspyadminnames") { // synchrone 
                    // à terminer
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste des noms administrateurs...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, 'admins indeterminé') ;
            }
            elseif ($pub_getcommand=="getcatallieslistsasync") { // doit retourner id serveur pour identification
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande liste alliance amies, enemies, commerciales en mode asynchrone...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, $server_config['allied']."<|>".$server_config['naq_ogspnaalliesnames']."<|>".$server_config['naq_ogsenemyallies']."<|>".$server_config['naq_ogstradingallies']) ;
            }
            elseif ($pub_getcommand=="getuserrights") { // synchrone 
                   // à terminer
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande droits utilisateurs $pub_user ".$user_data['user_name']."...\n");
                   
                   // retournera un nombre ou chaque chiffre représente une autorisation
                   
              		$request = "select ".TABLE_USER.".user_admin, ".TABLE_USER.".user_coadmin, ".TABLE_USER.".management_user, ".TABLE_USER.".management_ranking, "
                            ."MAX(".TABLE_GROUP.".ogs_connection), MAX(".TABLE_GROUP.".ogs_get_system), MAX(".TABLE_GROUP.".ogs_set_system), "
                            ."MAX(".TABLE_GROUP.".ogs_get_spy), MAX(".TABLE_GROUP.".ogs_set_spy), "
                            ."MAX(".TABLE_GROUP.".ogs_get_ranking), MAX(".TABLE_GROUP.".ogs_set_ranking), ".TABLE_USER.".user_active "
                  					."from ".TABLE_GROUP.", ".TABLE_USER_GROUP.", ".TABLE_USER." "
                  					."where ".TABLE_USER.".user_name = '".mysql_escape_string( $pub_user)."' "
                  					."and ".TABLE_USER.".user_id=".TABLE_USER_GROUP.".user_id "
                  					."and ".TABLE_USER_GROUP.".group_id=".TABLE_GROUP.".group_id "
                  					."group by ".TABLE_USER.".user_id, ".TABLE_USER.".user_active;";


                  $res = $db->sql_query($request, false, $log_sql_errors);
                  list($user_admin, $user_coadmin, $management_user, $management_ranking,
                  $ogs_connection, $ogs_get_system, $ogs_set_system, $ogs_get_spy, $ogs_set_spy,
                  $ogs_get_ranking, $ogs_set_ranking , $user_active) =  $db->sql_fetch_row($res);
                  
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Requète droits: $pub_user $request\n");
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "$user_admin : $user_admin, $user_coadmin \n");
                  
                  if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   
                   SendHttpStatusCode("771", true, true, "$user_admin,$user_coadmin,$management_user,$management_ranking,$ogs_connection,$ogs_set_system,$ogs_get_system,$ogs_set_spy,$ogs_get_spy,$ogs_set_ranking,$ogs_get_ranking,$user_active") ;
            }
            elseif ($pub_getcommand=="getogameserver") { // doit retourner id serveur pour identification
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "demande nom serveur univers Ogame...\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   SendHttpStatusCode("771", true, true, $server_config['naq_ogsplugin_numuniv']."|".$server_config['naq_ogsplugin_nameuniv']) ;
            }
            elseif ($pub_getcommand=="getogspluginmodversion") { // doit retourner id serveur pour identification
                    // retourne version script et version du module!!
                   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "version script ".OGSPY_SCRIPTVERSION." - module: ".OGP_MODULE_VERSION.".....\n");
                   if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                   // define("OGP_MODULE_VERSION","1.5.2");
                   SendHttpStatusCode("771", true, true,  OGSPY_SCRIPTVERSION.'|'.OGP_MODULE_VERSION) ;
            }
            else {
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "Commande plugin non reconnue\n");
                 if (defined("OGS_PLUGIN_DEBUG")) fclose($fp_plgcmds);
                 SendHttpStatusCode("779", true, true, "!779");
            }
        }
        
        // les résultat de commande asynchrone seront renvoyées avec le code 710 !
        
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp_plgcmds, "---------------------------------------------------------\n");

