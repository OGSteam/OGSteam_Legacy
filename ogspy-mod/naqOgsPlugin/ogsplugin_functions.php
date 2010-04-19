<?php

/***************************************************************************
*	filename	: ogsplugin_functions.php
*	desc.		:  fonctions pour ogsplugin.php
*	Author		: Naqdazar
*	created		: 01/09/2005
*	modified	: 10/11/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Appel direct non autorisé!");
}


function Get_OGServer_Version(){
  global $server_config;
  //preg_match("","",$serverversion);
  if (defined("OGS_PLUGIN_DEBUG")) global $fp;
  if (preg_match("#^3\.1.*?$#",$server_config["version"],$serverversion)==1) { 
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Version serveur 3.1 détectée!\n");
      $result=OGSPY_031_VERCONST; }
  elseif (preg_match("#^1\.0.*?$#",$server_config["version"],$serverversion)==1) {
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Version Unispy 1.0+ détectée!\n");
      $result=UNISPY_010_VERCONST; }
  elseif (function_exists('galaxy_ImportRanking_player') and function_exists('galaxy_ImportRanking_ally')) { $result=OGSPY_0302_VERCONST; }
  elseif (function_exists('galaxy_ImportRanking')) { $result=OGSPY_0301B_VERCONST; }
  else	$result="indéterminée";
  return $result;
}

// Vérifie si la verison de la barre d'outils cliente est correcte
// ou demande une mise à jour si nécessaire
function ApproveOGSToolbarVersion() {
 // obsolète
}


/**
 * adapte une heure de capture au créneau correspondant par type de jeu
 * ou retourne faux si le créenau n'est pas pris en charge
 **/
function To_Std_Update_Time($timetoadjust) {
    global $fp, $pub_gametype, $server_config;
    
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Début To_Std_Update_Time: timetoadjust $timetoadjust(".$server_config['naq_statshoursaccept'].")\n");
    $LStd_Update_Time = false;
    
   	$ltime = $timetoadjust;
   	if (is_numeric($server_config['timeshift'])) {
   	    $ltime += 60*60*(int)$server_config['timeshift'];
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"**>> Ajout décalage horaire: ".$server_config['timeshift']."($ltime/".time().")\n");
   	}
   	
   	$statshoursaccept_tab = preg_split("/[|\,;]/", $server_config['naq_statshoursaccept']);
   	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"To_Std_Update_Time, statshoursaccept_tab a ".count($statshoursaccept_tab)." élements\n");
   	
   	
   	if ($pub_gametype == 'ogame') {
      	if ($ltime > mktime(0,0,0) && $ltime < mktime(8,0,0)) $LStd_Update_Time = (in_array('00', $statshoursaccept_tab) || in_array('0', $statshoursaccept_tab) ? mktime(0,0,0) : false);
      	if ($ltime > mktime(8,0,0) && $ltime < mktime(16,0,0)) $LStd_Update_Time = (in_array('08', $statshoursaccept_tab) || in_array('8', $statshoursaccept_tab) ? mktime(8,0,0) : false);
      	if ($ltime > mktime(16,0,0) && $ltime < (mktime(0,0,0)+60*60*24)) $LStd_Update_Time = (in_array('16', $statshoursaccept_tab) ? mktime(16,0,0) : false);
    } elseif ($pub_gametype == 'eunivers') {
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Test créneau E-Univers\n");
        if ($ltime > mktime(0,0,0) && $ltime < mktime(6,0,0)) $LStd_Update_Time = (in_array('00', $statshoursaccept_tab) || in_array('0', $statshoursaccept_tab) ? mktime(0,0,0) : false);
      	if ($ltime > mktime(6,0,0) && $ltime < mktime(12,0,0)) $LStd_Update_Time = (in_array('06', $statshoursaccept_tab) || in_array('6', $statshoursaccept_tab) ? mktime(6,0,0) : false);
      	if ($ltime > mktime(12,0,0) && $ltime < mktime(18,0,0)) $LStd_Update_Time = (in_array('12', $statshoursaccept_tab) ? mktime(12,0,0) : false);
      	if ($ltime > mktime(18,0,0) && $ltime < (mktime(0,0,0)+60*60*24)) $LStd_Update_Time = (in_array('18', $statshoursaccept_tab) ? mktime(18,0,0) : false);
      	//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Echec\n");
    }
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Fin To_Std_Update_Time: ".date('l dS \of F Y h:i:s A', $ltime)."/ ".(int)$LStd_Update_Time."($pub_gametype)\n");
   return $LStd_Update_Time;
}


/**
 *  Vérifie si le créneau horaire est pris en charbe suivant les options
 **/
/* function IsHandledHourStats($timetocheck)
{


} */
//

// prévoir moditication pour recevoir tableau en unique paramètre, sinon premier par string de 3 chars
function SendHttpStatusCode($StatusCode, $Ob_clean=true, $exit_on_return=true, $responsetext="", $is_error_msg=true) {
    	// $ogspy_error_codes
    	global $is_ogsplugin, $db, $server_config, $pub_serverrank;
      if (defined("OGS_PLUGIN_DEBUG")) global $fp; // pour fermeture finale
    	//
    	/* if ($Ob_clean == true) */ ob_end_clean(); // d'office
      //
      /* if ($is_ogsplugin == true)  */ header("HTTP/1.0 ".$StatusCode." ogsplugmod");
      //
      // Modification réponse sortie pour notification mise à jour éventuelle
      if (defined('TOOLBAR_NEEDS_UPDATE')) {
          $responsetext = $StatusCode ."<|===/-!-\===|>toolbar_needs_update";
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Inscription finale: TOOLBAR_NEEDS_UPDATE\n");
      }
      //

      if (defined("OGS_PLUGIN_DEBUG")) $sqlcodefile= fopen("mod/naq_ogsplugin/debug/sqlerrorcodes.txt","a+"); // ligne débug , commentaire si pas utile
    	if (defined("OGS_PLUGIN_DEBUG")) fwrite($sqlcodefile,"header: ".$StatusCode." / message: ".$responsetext."\n");

      // pb crochets à revoir
      //if (defined("OGS_PLUGIN_DEBUG") && isset($db->$dbselect)) fwrite($sqlcodefile," / code erreur slq(fin script): ".$db->sql_error()["code"]."-".$db->sql_error()["message"]."\n");

    	if (defined("OGS_PLUGIN_DEBUG")) fclose($sqlcodefile); // ligne débug , commentaire si pas utile
    	//
      //
    	if ($exit_on_return ==true) {
    	    $db->sql_close(); // libération du serveur sql
    		if (defined("OGS_PLUGIN_DEBUG")) fclose($fp);
        if (trim($responsetext)!="") {
            if ($StatusCode=="797") // cas $StatusCode==797
                $exit_string = utf8_encode("797<|===/-!-\===|>".$responsetext);
            else if ($StatusCode=="757") // cas $StatusCode==757, données non prises en charge
                $exit_string = "757<|===/-!-\===|>resp_message=".utf8_encode($responsetext);
            else $exit_string = utf8_encode($responsetext); // code les espaces et autres pour eviter les etats de requète <>4
        }
    		else $exit_string = utf8_encode($StatusCode); // maj galaxie, stats...succès, erreur...
    		/* on ajoute le nom du serveur et le paramètre serverrank transmis par le plugin firefox
    		   sauf en réponse de commande et serveur sql indisponible */
      	if ($StatusCode != '771' ) $exit_string .= ($StatusCode != '750' ? "<|===/-!-\===|>resp_servername=".utf8_encode($server_config['servername']):"").(isset($pub_serverrank) ? "<|===/-!-\===|>resp_serverrank=".$pub_serverrank : "");
      	exit($exit_string );
    	}
}


function plg_ImportRanking_player( $ranktable, $timestamp, $rank, $player, $ally, $points){ // enregistre ligne par ligne
	  global $db, $user_data, $server_config, $log_sql_errors;
		$request = "insert into ".$ranktable;
		$request .= " (datadate, rank, player, ally, points, sender_id)";
		$request .= " values (".$timestamp.", ".$rank." , '".mysql_real_escape_string($player)."', '".mysql_real_escape_string($ally)."', ".$points.", ".$user_data["user_id"].")";
		$db->sql_query($request, false, $log_sql_errors);
		return $db; // utiles ???
}
//
function plg_ImportRanking_ally( $ranktable, $timestamp, $rank, $allytag, $number_member, $points, $points_per_member){ // enregistre ligne par ligne
	global $db, $user_data, $server_config, $log_sql_errors;
	global $fp;
		$request = "insert into ".$ranktable;
    if ((int)$number_member==-1 && (int)$points_per_member==-1) {
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "plg_ImportRanking_ally, champs 'number_member', 'points_per_member' absents.\n");
        $request .= " (datadate, rank, ally, points, sender_id)";
    } else $request .= " (datadate, rank, ally, number_member, points, points_per_member, sender_id)";
		$request .= " values (".$timestamp.", ".$rank.", '".mysql_real_escape_string($allytag)."', ".($number_member!=-1 ? $number_member.", ":"").$points.", ".($points_per_member!=-1 ? $points_per_member.", ":"").$user_data["user_id"].")";
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, $request."\n");
		$db->sql_query($request, false, $log_sql_errors);
		return $db;
}
//
//
function plg_stats_update($par_actiontyp, $par_whoseranking, $par_ranktype, $par_countlines) {  // fonction de base 0.301b
	// A revoir -	pour version 0.302 // à revoir pour globalisation galaxie, rapports et stats
	// code 0.301b
	global $fp;
	global $db, $user_data, $server_config , $log_sql_errors;

        //
	/*if ($server_config["debug_log"] == "1") {
		//Sauvegarde données tranmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_ranking_".$par_ranktype.".txt";
		write_file($nomfichier, "w", $files);
	}*/
	$timestamp = To_Std_Update_Time(time());
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "plg_stats_update: num countrank: ".$par_countlines." - par_whoseranking: ".$par_whoseranking." - par_actiontyp: $par_actiontyp\n");
        //
        if ($par_countlines > 0)
        $stat_field_name="";
        switch($par_actiontyp) {
                 case "stats":
                               	  user_set_stat(0, 0, 0, 0, 0, 0, $par_countlines, 0, 0, 0);
                                  $stat_field_name = 'rankimport_ogs';
                 break;
                 case "reports":
                                  user_set_stat(0, 0, 0, 0, $par_countlines, 0, 0, 0, 0, 0);
                                  $stat_field_name = "spyimport_ogs";
                 break;
                 case "allyhistory":
                                      user_set_stat(0, 0, 0, 0, 0, 0, $par_countlines, 0, 0, 0);
                                      $stat_field_name = "rankimport_ogs";
                 break;
                 default:
                     if ( $par_actiontyp=="galaxy" ||  $par_actiontyp=="galaxyraw") {
                                              user_set_stat(null, $par_countlines, null, null, null, null, null, null, null, null);
                                              $stat_field_name = "planetexport_ogs";
                     }
                 break;
        }
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "log->".$stat_field_name."\n");
	//
        //
        //Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$par_countlines;
	$request .= " where statistic_name = '".$stat_field_name."';";
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "requète fin fonction plg_statsranking_update -> ".$request."\n");
	$db->sql_query($request, false, $log_sql_errors);
  $sql_errorcode = $db->sql_error();
  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "nb lignes requète: ".$db->sql_affectedrows()." sqlerror: ".$sql_errorcode["code"]."\n");
	if ($db->sql_affectedrows() == 0) {
		$request = "insert into ".TABLE_STATISTIC." values ('".$stat_field_name."', '".$par_countlines."')";
		$db->sql_query($request, false, $log_sql_errors);
	}
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "fin fonction plg_statsranking_update -> ".TABLE_STATISTIC."\n");
	return $db; // utilité à revoir
}


/**
 * Fonction de journalisation : inscription d'actions dans le journal du serveur
 **/
function log_plugin_ ($parameter, $option=0) {
	 global $db, $user_data, $pub_user, $pub_pluginversion, $pub_gametype;
   global $fp;
   
	 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Entrée log_plugin_\n");
	 setlocale(LC_TIME, 'fr_FR.ISO-8859-1');

    switch($pub_gametype) {
    case 'eunivers': $gamename = " E-Univers" ; break;
    case 'ogame': $gamename = " Ogame" ; break;
    default : $gamename = ""; break;
    }

    switch ($parameter) {
		/* ----------- Gestion systèmes solaire et rapports ----------- */
		case 'load_system_OGS' :
		     list($lsystem, $num_plan  ) = $option;
         $line = $pub_user." charge ".$num_plan." planètes du système$gamename ".$lsystem." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
		case 'load_system_OGS_cdr' :
		     list($lsystem, $num_plan  ) = $option;
         $line = $pub_user." charge ".$num_plan." planètes du système$gamename ".$lsystem." via l'extension FireSpy ($pub_pluginversion)".($parameter=='load_system_OGS_cdr' ? " avec mise à jour des champs de ruines.":"");
		break;
		//
		case 'load_spy_OGS' :
		     $line = $pub_user." charge ".($option>0 ? $option:'aucun')." rapport".($option>0 ? 's':'')." d'espionnage$gamename via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		/* ----------- Gestion des membres ----------- */
		case 'login_ogsplugin_new' :
		     $line = "Connexion de ".$pub_user." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		case 'login_ogsplugin_upd' :
		     $line = "Connexion de ".$pub_user." via l'extension FireSpy (".$pub_pluginversion.")[renouvellement de session]";
		break;
		/* ----------- Classement ----------- */
		case 'load_allyhistory_OGS':
		     list($par_allytag, $timestamp, $lcountlines) = $option;
         $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $pub_user." envoie le classement alliance$gamename ".$par_allytag." du ".$date." via l'extension FireSpy (".$pub_pluginversion.") [".$lcountlines." membres]";
		break;
                //
    case 'load_rank_OGS' :
		     list( $par_whoseranking, $typerank, $intervranking, $timestamp, $countrank) = $option;
		     //
		     switch($par_whoseranking) {
               case 0: $par_whoseranking = "joueurs";break;
		           case 1: $par_whoseranking = "alliances";break;
		           default: $par_whoseranking = "indéterminé(a/j)";
         }
         switch ($typerank) {
    			    case "general": $typerank = "général";break;
    			    case "fleet": $typerank = "flotte";break;
    			    case "research": $typerank = "recherche";break;
    			    default: $typerank = "indéterminé(g/f/r/a)";
		     }
         $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $pub_user." envoie le classement$gamename ".$par_whoseranking."[$intervranking]($typerank) du ".$date." via l'extension FireSpy (".$pub_pluginversion.") [".$countrank." lignes]";
		break;
		/* ----------------------------------------- */
		//  user_load_building, user_load_technos, user_load_shipyard, user_load_fleet, user_load_defense, user_load_planet_empire, user_load_moon_empire
    case 'user_load_buildings' :
		     // $pub_planetsource
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $pub_user." met à jour sa page bâtiments$gamename pour ".$option." via l'extension FireSpy (".$pub_pluginversion.")";
		break;

    case 'user_load_technos' :
		     $line = $pub_user." met à jour sa page technologie$gamename via l'extension FireSpy (".$pub_pluginversion.")";
		break;

    case 'user_load_shipyard' :
		     $line = $pub_user." met à jour sa page chantier$gamename spatial pour ".$option." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
                
    case 'user_load_fleet' :
		     $line = $pub_user." met à jour sa page flotte$gamename pour ".$option." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
                
    case 'user_load_defense' :
		     $line = $pub_user." met à jour sa page défense$gamename pour ".$option." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
                
    case 'user_load_planet_empire' :
		     $line = $pub_user." met à jour sa page empire$gamename pour l'ensemble de ses planètes via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
		//user_load_eunivglobalview
    case 'user_load_eunivglobalview' :
		     $line = $pub_user." met à jour sa Vue Globale Empire($gamename) via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
    case 'user_load_moon_empire' :
		     $line = $pub_user." met à jour sa page empire$gamename pour l'ensemble de ses lunes via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
    case 'update_planet_overview' :
		     $line = $pub_user." met à jour ses caractéristiques de planète/lune$gamename pour ".$option." via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
		case 'unallowedconnattempt_OGS' :
		     list( $par_user_name, $par_user_password, $par_user_ip) = $option;
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $par_user_name." (".$par_user_ip.") a tenté de se connecter sans autorisation via l'extension FireSpy (".$pub_pluginversion.")";
		break;
		
		case 'unattendedgameserver_OGS' :
		     list( $par_user_name, $par_user_ip) = $option;
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $par_user_name." (".$par_user_ip.") a tenté d'envoyer des données d'un autre univers via l'extension FireSpy (".$pub_pluginversion.")!";
		break;
		
		case 'unattendedgametype_OGS' :
		     list( $par_user_name, $par_user_ip) = $option;
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $par_user_name." (".$par_user_ip.") a tenté d'envoyer des données d'un autre jeu en ligne via l'extension FireSpy (".$pub_pluginversion.")!";
		break;

		case 'debug' :
		    $line = 'DEBUG : '.$option;
		break;
		//
		default:
		    $line = 'Erreur appel fichier log depuis script plugin OGSPY ('.$pub_pluginversion.') - '.$parameter.' - '.print_r($option);
		break;
	}
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line; //  11/06/07 -> addslashes retiré
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}

/**
 * Détermine si un contenu est celui d'une planète ou celui d'une lune ensuite analyse
 * le nom pour trouver (Lune) en cas d'analyse non concluante
 * retourne 0 si analyse non concluante, 1 si planète, 2 si lune.
 **/
function DetermineIfPlanetOrMoon($par_content, $par_nameNcoord) {
        global $fp;
        $l_colotype = 0; // type "colonie"

          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Début fonction 'DetermineIfPlanetOrMoon'\n");

          // test bâtiment de planète
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n=> Recherche de Base lunaire dans pub_content\n");
          // pas au point
          if (strpos($par_content, 'Base lunaire')===false) { // test sur faux, cf manuel php, si pas lune est planète!
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une planète! \n");
                $l_colotype = 1; // ne pas fixer pour l'instant
          } else if (strpos($par_content, 'Mine de métal')===false) {
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une lune!\n");
              $l_colotype = 2; // ne pas fixer pour l'instant
          } else $l_colotype = 0;
          
          if ($l_colotype==0) {
              if (strpos($par_nameNcoord, '(Lune)')!==false || strpos($par_nameNcoord, 'lune') == 0) {
                  $l_colotype = 2;
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Motif '(Lune)' trouvé dans étiquette colonie!\n");
              }
          }
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Valeur retour 'DetermineIfPlanetOrMoon': $l_colotype\n");
        return $l_colotype;

}

//
// Détermine l'id d'une colonie/lune pour l'insertion des données
/* Depuis la version 0.76 d'Ogame: l'étiquette "(Lune)" est ajoutée au nom de lune qui vient d'être renommée
   @param $strict_search booleen: la rechercher se fera simultanément sur le nom et les coordonnées avec un seul résultat attendu
*/
function plg_getplanetidbycoord($planetname, $planetcoords, $seemsaplanet, $strict_search=false) { // A REVOIR!!!!
         global $db, $user_id, $user_planetsource_vars, $log_sql_errors;
         if (defined("OGS_PLUGIN_DEBUG")) global $fp;
         
         // test existence planète de même nom ou coord dans la base(coordonnées de préférence)
         if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"---------------------------------------------------------------------------\n");
         if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"début plg_getplanetidbycoord, planetcoords: $planetcoords \n");

          // $seemsaplanet: variable supplémentaire d'aide la la distinction planète/lune
          if (defined("OGS_PLUGIN_DEBUG") && (isset($seemsaplanet) || $seemsaplanet!=null ) ) fwrite($fp,"\$seemsaplanet défini: ".(int)$seemsaplanet."\n");

         // test bâtiments de planète -- 
         //------
         // recherche d'une planète déjà enregistréer avec ces coordonnées
         $query = "SELECT planet_name, planet_id FROM ".TABLE_USER_BUILDING." WHERE user_id=".(int)$user_id." ".($strict_search===true ? " and planet_name='$planetname'":"")."and coordinates='".$planetcoords."'".($strict_search===false ? " and planet_id<=10 ":"").($strict_search===true ? " LIMIT 1":"").";";
         $res = $db->sql_query($query, true, $log_sql_errors);
          
          // faire boucle foreach, projection par coordonnées!!
          $request_numrows = $db->sql_numrows($res);
          
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n=>requète : ".$query."\n==> ".$request_numrows." ligne(s) obtenue(s)\n\n");
          
          if ($request_numrows>0) {  // au moins une planète avec ces coordonnées existe
               // listing de toutes les planète de la base dans un tableau

               //foreach( $db->sql_fetch_row($res)) {
               list($usr_planet_name, $usr_planet_id) = $db->sql_fetch_row($res);
               //$user_planets[$usr_planet_name] = $usr_planet_id;
               if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,$usr_planet_name."( à insérer".$planetname.") --> usr_planet_id: $usr_planet_id\n");
               //
               // nom de planète récupéré

               if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"Résultat comparaison avec 'lune':".(int)($planetname===$planetname)."\n");

                if ($seemsaplanet===false) $usr_planet_id += 9; // --> intervalle id lune

               if (// est-ce que c'est une planète: test de l'intervale planet_id
                  $seemsaplanet) { // nom planète déterminé
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planète: ".$user_planetsource_vars[1]." de coordonnées ".$user_planetsource_vars[3]."($usr_planet_id) existe dans la base\n");
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"----------------fin plg_getplanetidbycoord, retour code planète: $usr_planet_id-----------------------------------------------------------\n");
               } else  { // pas de planet_id trouvée pour lune
                  if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"insertion lune en ".$user_planetsource_vars[3]." (".($usr_planet_id).")\n");
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"----------------fin plg_getplanetidbycoord, retour code lune $usr_planet_id-----------------------------------------------------------\n");
               }

          } else { // la requète de recherche planète n'a rien retournée: aucune planète existante
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"aucune planète de même coordonnées trouvée\n");
                  $usr_planet_id = 0; // aucune planète de même coordonnées trouvée
          }
           if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"---------------------------------------------------------------------------\n");
           return $usr_planet_id; // aucun emplacement correspondant trouvé
}
//
function html2text($document, $pagetype="") {
 	  
     $text = html_entity_decode(utf8_decode($document));
    
    $text = str_replace("\n","",$text); // on retire les retour chariot
 	$text = str_replace("\t","",$text); // on retire les tabulations
 	///////////////$empire_precontent = str_replace("\t","",$empire_precontent);
	$text = str_replace("    ","",$text);
	$text = str_replace("   ","",$text);
	$text = str_replace("  ","",$text);
 	$text = str_replace("</th>","</th> \t",$text);
    $text = str_replace("</tr>","</tr>\n",$text);
    //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"buildings HTML: ".$buildings_precontent."\n");
	//////////////////$empire_precontent = strip_tags($empire_precontent);
	$text = stripslashes($text);
	return $text;
}

function spyreports_html2text($document) { // à revoir, prototype
 	  

return $text;

}

function IsHTMLData($html_content) {
 // recherche successive de tags pour déterminer si contenu html ou pas: <br>/<table>/</table>/<b>/<tr>/<td>
 
  $ishtml=false;
  $br_found = false;
  $tr_found = false;  
  $td_found=false;
  $th_found=false;
  $table_found=false;
  // -----------------------------------------------   
  $pos = strpos($html_content, '<br>');
  if ($pos !== false) $br_found=true; // === ou !== obligatoire 
  //------------------------------------------------
  $pos = strpos($html_content, '<tr>');
  if ($pos !== false) $gr_found=true; // === ou !== obligatoire   
  //------------------------------------------------
  $pos = strpos($html_content, '<td>');
  if ($pos !== false) $td_found=true; // === ou !== obligatoire   
  //------------------------------------------------
  $pos = strpos($html_content, '<th>');
  if ($pos !== false) $th_found=true; // === ou !== obligatoire   
  //------------------------------------------------
  $pos = strpos($html_content, '<table');
  if ($pos !== false) $table_found=true; // === ou !== obligatoire     
  //------------------------------------------------
  return ($br_found || $tr_found || $tr_found || $th_found || $table_found); 
}
// plg_set_user_building($data, $planet_id, $planet_name, $fields="", $coordinates="", $temperature=0, $satellite=0) {
//

/**
 * Vérification de l'existence du dossier debug et des droits en écriture
 **/
function OGSPlugin_CheckDebugDir() {
        // vérification que le dossier debug existe sinon création
        if (!is_dir("mod/naq_ogsplugin/debug")) {
            mkdir("mod/naq_ogsplugin/debug", 0766);
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Préparatçion de la journalisation: le dossier /debug a été (re)crée!\n"); // ligne débug , commentaire si pas utile
        }
        if (!is_writable('mod/naq_ogsplugin/debug')) {
            chmod('mod/naq_ogsplugin/debug', 0755);
                        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Préparatçion de la journalisation: les droits du dossier /debug ont été ajustés pour écriture!\n"); // ligne débug , commentaire si pas utile
        }

}

function OGSPlugin_CreateDebugLog() {

        global $server_config, $fp, $pub_user, $pub_content;
        //
        /////////////////////////
      	// JOURNAL DE DEBOGAGE //
      	/////////////////////////
        // initialisation fichier journal debug
        //



        if (defined("OGS_PLUGIN_DEBUG")) {
            $fp = fopen("mod/naq_ogsplugin/debug/ogsplugin_".mysql_escape_string($pub_user).".txt","w"); // ligne dÚbug , commentaire si pas utile
            fwrite($fp, "Création journal déboggage.\n");
            //
            $rawdata_file = fopen("mod/naq_ogsplugin/debug/rawdata.txt","w"); // ligne dÚbug , commentaire si pas utile
            fwrite($rawdata_file, "contenu brut données-------------------------------------------------------------------------\n$pub_content\n--------------------------------------------------------------------------------");
        }
}

function OGSPlugin_InitDB() {
global $db, $db_host, $db_user, $db_password, $db_database;
  /////////////////////////////////////////////////////////////
  // Connection au serveur SQL et vÚrification disponibilitÚ //
  /////////////////////////////////////////////////////////////
  //
  $db = false;
	if (is_array($db_host)) {
		for ($i=0 ; $i<sizeof($db_host) ; $i++) {
			$db = new sql_db($db_host[$i], $db_user[$i], $db_password[$i], $db_database[$i]);
			if ($db->db_connect_id) {
				break;
			}
		}
	}
	else {
	     $db = new sql_db($db_host, $db_user, $db_password, $db_database);
	}
        if (!$db->db_connect_id) return false;
        else return true;
        //
}

/**
 * teste l'existence d'une colonne dans une table de la base de données
 * @param $tablename chaîne: nom de la table à interroger
 * @param $parcolname chaîne: correspond au nom de colonne dont on veut tester l'existence
 * @return booléen: retourne vrai si la colonne existe, sinon retourne faux
 **/
function OGSPlugin_DoDBColumnExists($tablename, $parcolname) {
          global $db, $fp;
          

    			$request_testcol = "DESCRIBE `".$tablename."` `".mysql_escape_string($parcolname)."`;";
    			$db->sql_query($request_testcol);
    			if  ($db->sql_affectedrows() > 0) $test_result = true; // la requète a t elle retourné des lignes??
    			else $test_result = false;

          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>Verification de l'existence de la colonne $parcolname dans $tablename: $test_result\n");
    			return $test_result;
}

/**
 * lecture des droits utilisateurs
 **/
function OGSPlugin_UserAuth() {

  global $db, $fp, $ogspy_server_version, $is_ogsplugin, $user_active;
  global $pub_user, $motdepasse, $pub_password, $pub_crypted;
  global $log_logunallowedconnattempt, $log_sql_errors;
  global $user_id, $user_active, $user_lastvisit, $ogs_connection, $ogs_set_system, $ogs_set_spy, $ogs_set_ranking;
  
  // if (defined("OGS_PLUGIN_DEBUG")) echo "OGSPlugin_UserAuth\n";
  //////////////////////////////////////////////////////
	// VERIFICATION CHAMPS LOGIN - MOT DE PASSE PRESENT //
	//////////////////////////////////////////////////////
	//
	// $name variable ogs / $pub_user; variable galaxytool
	//
	if ((!isset($pub_user) or !isset($pub_password) or empty($pub_user) or empty($pub_password)) && count($_POST)>2) {
  		// autre case, identifiant/mot de passe non présent
  		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> Nom utilisateur/mot de passes vide(s) ou non défini(s)\n"); // ligne débug , commentaire si pas utile
  		SendHttpStatusCode("753") ;
	} //  utilisateur existe, on continue
  //
	//////////////////////
	// AUTHENTIFICATION //
	//////////////////////
	//
	$user_name = $pub_user;
	/* type requète authentification variable suivant version serveur ogspy
	lecture comme pour authentification user_ogs_login() */
	// suppression code test 0.301

  // test sur $pub_password: suite de 32 caractères hexadécimaux?
  $semble_crypte = preg_match("#^[a-h]{32}$#", $pub_password); //, $passteststring);
  if ($semble_crypte) {
    	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Le mot de passe est composé de 32 caractères hexadécimaux. \n");
	}

  // détermination cryptage mot de passe
  if (isset($pub_crypted) && $pub_crypted=='ogspy' && $semble_crypte==0) {
      $motdepasse = $pub_password;
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"mot de passe crypté...\n");
  }
  else {
      $motdepasse=md5(sha1($pub_password)); // si pas crypté dans les prorpriétés de la barre d'outils
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"mot de passe en clair...\n");
  }


	//////////////////////////////////////////////
	// récupération infos utilisateur et droits //
	//////////////////////////////////////////////
  

  if (/*($ogspy_server_version==OGSPY_0302_VERCONST ) && */ $is_ogsplugin) {
		$request = "select ".TABLE_USER.".user_id, ".TABLE_USER.".user_active, ".TABLE_USER.".user_lastvisit, MAX(".TABLE_GROUP.".ogs_connection), MAX(".TABLE_GROUP.".ogs_set_system), MAX(".TABLE_GROUP.".ogs_set_spy), MAX(".TABLE_GROUP.".ogs_set_ranking) "
    					."from ".TABLE_GROUP.", ".TABLE_USER_GROUP.", ".TABLE_USER." "
    					."where ".TABLE_USER.".user_name = '".mysql_escape_string($pub_user)."' and ".TABLE_USER.".user_password = '".$motdepasse."' "
    					."and ".TABLE_USER.".user_id=".TABLE_USER_GROUP.".user_id "
    					."and ".TABLE_USER_GROUP.".group_id=".TABLE_GROUP.".group_id "
    					."group by ".TABLE_USER.".user_id, ".TABLE_USER.".user_active;";


    $res = $db->sql_query($request, false, $log_sql_errors);
    	if (preg_match("#\.user_password\s*=\s*'(\w+)'#" ,$request, $pass_match_tab)) {
         if ($pub_crypted=='ogspy' || $semble_crypte==0) $pass_replace="<crypted>";
         elseif (empty($motdepasse)) $pass_replace="<vide>";
         else $pass_replace="<mot_de_pass>";

         //$request = preg_replace("#\.user_password\s*=\s*'\w+'#" ,".user_password = '". $pass_replace."'" , $request);
         
         if ($request) {
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Mot de passe masqué dans la requète!\n");
         }
      } else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Mot de passe non détecté!\n");

    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "requète authentification 0.302 :".$request."\n");
    if ( $db->sql_numrows($res)==0) SendHttpStatusCode("752"); // si mot de passe ou login incorrect
    // si résultat requête vide!
    if (list($user_id, $user_active, $user_lastvisit, $ogs_connection, $ogs_set_system, $ogs_set_spy, $ogs_set_ranking) = $db->sql_fetch_row($res)) { // action!
		    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"variables lues ok 0.302 - user_id: ".$user_id."\n");
		} else {
		       if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Echec d'authenfitication, erreur sql no:".mysql_error($db->$dbselect)."\n");
	 	       if ($log_logunallowedconnattempt) log_plugin_("unallowedconnattempt_OGS", array( mysql_escape_string($pub_user), $pub_password, $_SERVER['REMOTE_ADDR']));
		       SendHttpStatusCode("752"); // échec authentification!
		}
	}
}

/**
 * détermine si un mod de tag donné est actif ou pas
 * si inactif ou inexistant retourne false
 * @param $parmodtag chaîne: indique le tag du module à vérifier
 * @return booléen: indique si le module désigné est actif ou pas
 **/
function OGSPlugin_IsTargetModActive($parmodtag){
  global $db;
  $query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='".mysql_escape_string($parmodtag)."' LIMIT 1";
  $result = $db->sql_query($query);
  if (list($state_active) = $db->sql_fetch_row($result)) {
      if($state_active=='1') return true;
      else false;
  } else return false;
}

function OGSPlugin_VerifSessionValide(){
	## VERIFICATION COMPTE ACTIF ##
  global $db, $fp, $user_active, $log_sql_errors, $user_id, $now;

  if ($user_active == 0) { // compte inactif
		  SendHttpStatusCode("755") ; // on quitte
	} else { // maj stats connections ogs
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"signalement connection ogs: session expirée\n");
    		//log_plugin_('login_ogsplugin');
    		// requète doit toujours retourner un résultat: toujours var user_lastvisite même nulle
    		$request = "update ".TABLE_USER." set user_lastvisit = ".$now." where user_id = ".$user_id;
    		$db->sql_query($request, false, $log_sql_errors);
    		$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
    		$request .= " where statistic_name = 'connection_ogs'";
    		$res = $db->sql_query($request, false, $log_sql_errors);
    		if ($res==0) { //($db->sql_affectedrows() == 0)
      			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"erreur update stats connection ogs: ".$user_id."\n");
      			$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_ogs', '1')";
      			$db->sql_query($request, false, $log_sql_errors);
        }
  }
}

function OGSPlugin_session(){ // fonction écrite par chapodepay, non utilisée pour l'instant
	global $fp, $db, $user_id, $user_active, $user_lastvisit, $ogs_connection, $ogs_set_system, $ogs_set_spy, $ogs_set_ranking;
  global $ogspy_server_version, $pub_user, $pub_password, $motdepasse, $pub_crypted, $user_data, $group_data;
	$user_ip = encode_ip(USER_IP);
	
  // if (defined("OGS_PLUGIN_DEBUG")) echo "OGSPlugin_session\n";
  if (isset($pub_crypted) && $pub_crypted='ogspy') {
		$motdepasse = $pub_password;
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"mot de passe crypté...\n");
	}else $motdepasse=md5(sha1($pub_password)); // si pas crypté dans les prorpriétés de la barre d'outils
	
	//session(); // => provoque déconnexion
	
	if (!isset($user_data["user_id"])) {
		$request = "select ".TABLE_USER.".user_id, ".TABLE_USER.".user_active, ".TABLE_USER.".user_lastvisit "
    			."from  ".TABLE_USER." "
    			."where ".TABLE_USER.".user_name = '".mysql_escape_string($pub_user)."' and ".TABLE_USER.".user_password = '".$motdepasse."' "
    			."LIMIT 1;";
		    $result = $db->sql_query($request);
		    if (list($user_id, $user_active, $user_lastvisit) = $db->sql_fetch_row($result)) {
			if ($user_active == 1) {
    				$request = "select user_lastvisit from ".TABLE_USER." where user_id = ".$user_id;
    				$result = $db->sql_query($request);
    				list($lastvisit) = $db->sql_fetch_row($result);

    				$request = "update ".TABLE_USER." set user_lastvisit = ".time()." where user_id = ".$user_id;
    				$db->sql_query($request);
    				$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + 1";
    				$request .= " where statistic_name = 'connection_server'";
    				$db->sql_query($request);
    				if ($db->sql_affectedrows() == 0) {
    					$request = "insert ignore into ".TABLE_STATISTIC." values ('connection_server', '1')";
    					$db->sql_query($request);
    				}

            ## Initialisation session utilisateur ## // à revoir
            session_set_user_id($user_id, $lastvisit);
    				log_plugin_('login_ogsplugin_new');
    				/*
    				// on affiche dans l'etat de la barre que la session a été créée
    				SendHttpStatusCode("xxx",false,false,"xxxcreation session") ;
    				sleep(2); // sleep pour kon ai le temps de le voir avant de passer a la suite
    				*/
    				// loggué
    			}else{
    				SendHttpStatusCode("755",true,true,"755non actif") ;
    			}
		}else{
			if (defined("CHAPO") || defined("OGS_PLUGIN_DEBUG"))fwrite($fp,"-------------------\nidentification échouée : \n".$request."\"---------------------");
			 SendHttpStatusCode("752",true,true,"752identification raté");
		}
	}
	if(table_exists(TABLE_GROUP)){
    // requète mal définie, provoque erreurs droit si l'utilisateur est dans un groupe n'ayant aucun droit
    $requete_1='SELECT MAX(`group_id`) as group_id  FROM '.TABLE_USER_GROUP.' WHERE `user_id`="'.$user_data['user_id'].'" LIMIT 1';
		$result_1 = $db->sql_query($requete_1);
		if($result_1 && $db->sql_numrows($result_1)>0){
			$donnees_1= $db->sql_fetch_assoc($result_1);
			$requete_2='SELECT `ogs_connection`,`ogs_set_system`,`ogs_set_spy`,`ogs_set_ranking` FROM '.TABLE_GROUP.' WHERE `group_id`='.$donnees_1['group_id'].' LIMIT 1';
			$result_2 = $db->sql_query($requete_2);
			if($result_2 && $db->sql_numrows($result_2)>0){
				$donnees_2= $db->sql_fetch_assoc($result_2);
				foreach($donnees_2 as $key => $value)$temp.=$key.'=>'.$value.'<br>';
				if($donnees_2['ogs_connection']!=1)
					SendHttpStatusCode("756",true,true,"connection ogs interdite!\n<br>");
				foreach($donnees_2 as $key => $value)$group_data[$key]=($value==1?true:false);
			}
		}else SendHttpStatusCode("752",true,true,"752probleme de groupe 2");
	}else SendHttpStatusCode("752",true,true,"752probleme de groupe 1");
	//die($user_data["user_id"]);
	return true;
}

function OGSPlugin_AllowDataFromUniverse(){
      global $fp, $server_config, $pub_gametype, $user_ip;

    	global $naq_forcestricnameuniv, $pub_realogameserver, $pub_user, $pub_password;
    	global $plug_ogsplugin_nameuniv, $log_ogsplugin_nameuniv; // naq_ogsplugin_nameuniv

      $pub_realogameserver = utf8_decode($pub_realogameserver);
      if (empty($plug_ogsplugin_nameuniv)) $plug_ogsplugin_nameuniv = $server_config['naq_ogsplugin_nameuniv'];
      if (empty($plug_forcestricnameuniv)) $plug_forcestricnameuniv = $server_config['naq_forcestricnameuniv'];

      // le type de jeu correspond-il à celui du serveur?
      if ($plug_forcestricnameuniv == true && strcasecmp($pub_gametype, $server_config['naq_gametype']) != 0) {
        	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Incohérence de type de jeu: ".$pub_gametype."/".$server_config['naq_gametype']."\n");
        	log_plugin_("unattendedgametype_OGS", array( mysql_escape_string($pub_user), $user_ip));
          SendHttpStatusCode("793");
      }

      // // le serveur de jeu correspond-il à celui du serveur?
      if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Test variable nom de serveur attendu, pub_realogameserver($naq_forcestricnameuniv) =>  $pub_realogameserver , plug_ogsplugin_nameuniv:  $plug_ogsplugin_nameuniv / log_ogsplugin_nameuniv: $log_ogsplugin_nameuniv / naq_ogsplugin_nameuniv $naq_ogsplugin_nameuniv / server_config['naq_ogsplugin_nameuniv']: ".$server_config['naq_ogsplugin_nameuniv']." \n");
      if ($plug_forcestricnameuniv == true && !empty($pub_realogameserver)  && strcasecmp($pub_realogameserver,$plug_ogsplugin_nameuniv) !=0 ) {
      		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Incohérence de nom de serveur: ".$pub_realogameserver."/".$plug_ogsplugin_nameuniv."\n");
      		log_plugin_("unattendedgameserver_OGS", array( mysql_escape_string($pub_user), $user_ip));
      		SendHttpStatusCode("795");
    	}

}

function OGSPlugin_ShouldRedirect() {
  //  option "déménagement express"
  global $plug_notifyplugredirect, $plug_plugredirectmsg, $log_plugredirectmsg , $server_config;
  
  if ($plug_notifyplugredirect==true) {// décommenter pour signifier redirection manuelle
      //$newurlstring=$plug_plugredirectmsg; // $plug_plugredirectmsg vide!!
      $newurlstring=$server_config['naq_plugredirectmsg'];
      $baliseserverdown="<|===/-!-\===|>"; // idem dans ogsplugin.js
      SendHttpStatusCode("798", true, true, "798".$baliseserverdown.$newurlstring);
  } 
}

function OGSPlugin_CompareStringVersions($parstring1, $parstring2) {

    global $fp;

    $stringversion1 = str_replace('.', '', $parstring1);
    $stringversion2 = str_replace('.', '', $parstring2);



    while(strlen($stringversion1)<strlen($stringversion2)) $stringversion1 .= '0';
    while(strlen($stringversion2)<strlen($stringversion1)) $stringversion2 .= '0';



    if ($stringversion1<$stringversion2) $comp_code =  -1;
    else if ($stringversion1>$stringversion2) $comp_code =  1;
    else if ($stringversion1==$stringversion2) $comp_code =  0;
    
    // $comp_code = strcasecmp($stringversion1, $stringversion2);
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "OGSPlugin_CompareStringVersions: $stringversion1($parstring1) ? $stringversion2($parstring2) / resultat: $comp_code \n");

    return $comp_code;
};

function OGSPlugin_ShouldBlockFrxPlugin() {
  /* l'extension firefox et le module php fonctionnent ensemble - il s'agit de 
     demande une mise à jour pour assurer la cohérence de mise à jour de code de
     part et d'autre: limiter le support "ça ne marche plus..." */
     
  global $pub_pluginversion, $OGSPY_toolbarminver1, $OGSPY_toolbarminver2, $fp, $server_config;

	// Vérification version Barre d'outils -> demande mise à jour si nécessaire

  if ((OGSPlugin_CompareStringVersions($pub_pluginversion, $OGSPY_toolbarminver1)<0) || (OGSPlugin_CompareStringVersions($pub_pluginversion, $OGSPY_toolbarminver2)<0) || count($_POST)<3) {
		  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "version toolbar incompatible: ".$pub_pluginversion."/".$OGSPY_toolbarminver1."\n");
			define("TOOLBAR_NEEDS_UPDATE", true); // -> permet d'ajouter un message dans les code text de sortie 
      if ($server_config["naq_forceupdate_outdatedext"]==1) { // désormais action contrôlée sur le panneau admin d'OGS Plugin
          // si $server_config["naq_forceupdate_outdatedext"] non définie, l'appel du plugin firefox est acceptée
          SendHttpStatusCode("791") ;
      }
            
  } else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "version toolbarre compatible => ".$pub_pluginversion."/".$OGSPY_toolbarminver1." -> ".(int)($pub_pluginversion>=$OGSPY_toolbarminver1)." -> ".(int)($pub_pluginversion>=$OGSPY_toolbarminver2)."\n");
}

function OGSPlugin_IsOGSPYServerDown() {
  if (isset($server_config) && (int)$server_config['server_active']==0 && $is_ogsplugin) {
     //$serverdownresponse = array("794", $server_config["reason"]);
     if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "serveur à l'arrêt: ".$server_config["reason"]."\n");
     if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "ob_content: ".ob_get_contents()."\n");
     /* if (($pub_pluginversion>='1.0.956') or ($pub_pluginversion>='1.0.95.6'))
     baliseserverdown=">|===/-!-\===|<";
     else*/ $baliseserverdown="<|===/-!-\===|>"; // idem dans ogsplugin.js
     SendHttpStatusCode("794", true, true, "794".$baliseserverdown.$server_config["reason"]);
  }
}

/**
 * vérifie qu'une table existe dans la base de données
 **/
function table_exists($table){
	global $db;
	$list_table=array();
	$mysql_result = $db->sql_query("SHOW TABLES;");
	if($mysql_result && $db->sql_numrows($mysql_result)>0){
	   while ($ligne = $db->sql_fetch_row($mysql_result))$list_table[]=$ligne[0];
	   if(in_array($table,$list_table))return true;
	 }
   return false;
}

// charge les paramètres du module/plugin dans un tableau
function OGSplugin_load_config(){
	global $server_config, $fp;
	$return_array_for_extract=array();
	$plug=array('handlegalaxyviews','handleplayerstats','handleallystats','handleespioreports','notifyplugredirect','plugredirectmsg');
	$special_key=array('logogssqlfailure' => 'sql_errors');
	$special_value=array('ogsplugin_nameuniv' => '','plugredirectmsg' => '?');
	foreach($server_config as $cle => $value)
		if(substr($cle,0,4)=='naq_'){
			$key_tronk=substr($cle,4);
			$return_array_for_extract[(in_array($key_tronk,$plug)?'plug_':'log_').(array_key_exists($key_tronk,$special_key)?$special_key[$key_tronk]:$key_tronk)]=(array_key_exists($key_tronk,$special_value)?$special_value[$key_tronk]:(!empty($value)?true:false));
		}
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"============================= OGSplugin_load_config ============================\n"); // ligne débug , commentaire si pas utile
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "\n".print_r($return_array_for_extract."\n")); // ligne débug , commentaire si pas utile
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"1===============================================================================\n"); // ligne débug , commentaire si pas utile
	return $return_array_for_extract;
}

// retourne les autorisations suivant le type d'opération voulu
function OGSplugin_controle_droit($type){
	//type ( stats, system, connexion, spy)
	global $group_data; //, $ogs_connection, $ogs_set_system, $ogs_set_spy, $ogs_set_ranking;
	$array_type=array('connexion' => 'ogs_connection', 'system' => 'ogs_set_system', 'spy' => 'ogs_set_spy', 'stats' => 'ogs_set_ranking');
	if(!is_array($group_data))return false;
	if(!array_key_exists($type,$array_type)){
      //die('erreur de parametre fonction OGSplugin_controle_droit');
      SendHttpStatusCode("797", true, true, "erreur de parametre fonction OGSplugin_controle_droit");
      return false;
  }
	return $group_data[$array_type[$type]];
}

function OGSPlugin_Traitement_Stats(){
	  global $db, $fp, $server, $is_ogsplugin, $pub_content, $pub_who,  $pub_what, $ogspy_server_version, $timerankdata;
    global $playerranktables301, $playerranktables302, $playerranktables301, $allyranktables302, $statsranktypestrings, $ranktable;
	  global $plug_handleplayerstats, $plug_handleallystats, $log_logogsplayerstats, $log_logogsallystats;
	  global $ogs_set_ranking;
		
    ##### OGS 0.302, VERIFICATION DROIT IMPORTER STATS #####
    // condition OGSplugin_controle_droit('stats') remplacée par $ogs_set_ranking
    if (!$ogs_set_ranking) { // accès interdit
			if ($is_ogsplugin == true) {
				if($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST
        || $ogspy_server_version==UNISPY_010_VERCONST){
					SendHttpStatusCode("724");
				} else SendHttpStatusCode("403");
			} else SendHttpStatusCode("403");
		}
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"stats...\n"); // ligne débug , commentaire si pas utile

		$statstext = stripslashes(utf8_decode($pub_content));
		$who = (int)$pub_who;
		$what = (int)$pub_what;
		
    // Les indices de catégorie sont-ils corrects?
		if ($who == -1 || $what == -1) SendHttpStatusCode("797", true, true, "Erreur de réception des paramètres de catégorie stats!");
		//
		// identique 0.301b et 0.302
		//
		$type_classement = array('points','flotte','research');
		// commun stats alliance et joueur
		//$timerankdata = To_Std_Update_Time(time()) ; // $datedonnees = date("H:i:s"); 00h00/8h00/16h00
		//  $timerankdata mise en commun (claas players, alliances, alliance perso début de structure test $pub_typ

		$stats_array = explode("<==||==>",$statstext);
		if (defined("OGS_PLUGIN_DEBUG"))
			fwrite($fp,"splitting tableau stats en ".count($stats_array)." élements\n");
		$numbuffer_iter = 0;
		
		// DEBUT BOUCLE BUFFER STATS
		$num_stattabs_updated=0;
		$num_stattabs_notupdated=0;
		$num_stattabs_partialyupdated=0;
		$num_stattabs_alreadyupdated=0;
		foreach($stats_array as $curr_statstext) {
			$countrank = 0; // initialisation nombre de lignes insérées
			$already_update = 0; // init nb ligne déjà à jour
			if ($who == 0) { // stats joueurs	- possibilité de mélanger les deux codes player / alliance -> structure identique
				if (defined("OGS_PLUGIN_DEBUG"))
					fwrite($fp,"playerstats...\n");// ligne débug , commentaire si pas utile

				// test prise en charge sur le serveur
				if (!$plug_handleplayerstats) SendHttpStatusCode("781");

				// Playerstats
				$newarray = preg_split("/&\w+=/",$curr_statstext);
				//
				$stats_array['rank']	   = explode("|",$newarray[1]);
				$stats_array['playername'] = explode("|",$newarray[2]);
				$stats_array['pID'] 	   = explode("|",$newarray[3]);
				$stats_array['alliance']   = explode("|",$newarray[4]);
				$stats_array['points']	   = explode("|",$newarray[5]);
				unset($newarray);
				//
				if ($ogspy_server_version==OGSPY_0301B_VERCONST)
					$ranktable = $playerranktables301[$what];
				elseif (($ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST
              || $ogspy_server_version==UNISPY_010_VERCONST))
					$ranktable = $playerranktables302 [$what];
				//
				if (defined("OGS_PLUGIN_DEBUG"))
					fwrite($fp,"player rank table: ".$ranktable."\n**Début boucle analyse ligne classement\n");
				
				$max_count_statsrows = count($stats_array['playername']);
				// détermination de l'intervale pour les stats
				$intervranking = $stats_array['rank'][0].'-'.($stats_array['rank'][0]+$max_count_statsrows-1);
				for ($i=0; $i < $max_count_statsrows; $i++) {
					//
					/////////////////////////////
					// PREPARATION DES DONNEES //
					/////////////////////////////
					/*
					//add by chapodepay (compatibilité 74d)
					$stats_array['player'][$i]=ereg_replace("(.*)allytag=([a-zA-Z0-9 \.\-\+_]{0,})\" target=\"_ally\">(.*)$","\\2",$stats_array['alliance'][$i]);
					$stats_array['player'][$i]=ereg_replace("(.*)<a href=\"allianzen.php\?session=[a-zA-Z0-9]{0,}\"> \n   		 \n        ([a-zA-Z0-9 \.\-\+_]{1,})</a>$","\\2",$stats_array['alliance'][$i]);
					//
					*/
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"what: ".$what.", ".$ranktable.", ".$timerankdata.", ".$stats_array['rank'][$i].", ".$stats_array['playername'][$i].", ".$stats_array['alliance'][$i].", ".$stats_array['points'][$i]."\n__".$entry."\n");
					// adaptation tranche horaire
					//
					// tests nature variables à faire au niveau du plugin
					if (isset($stats_array['rank'][$i]) && isset($stats_array['playername'][$i]) && isset($stats_array['alliance'][$i]) && isset($stats_array['points'][$i])){

  						if ($timerankdata !== false) {
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Créneau horaire stats OK($timerankdata)\n");
                  plg_ImportRanking_player( $ranktable, $timerankdata, $stats_array['rank'][$i], $stats_array['playername'][$i], $stats_array['alliance'][$i], $stats_array['points'][$i]);
              } else SendHttpStatusCode("785");

  						// gestions codes retour sql, cas enregiustrement déjà à jour
  						$res_sql_error = $db->sql_error();
  						if ($res_sql_error["code"]==1062)
  							$already_update++;
  						elseif ($res_sql_error["code"]==0)
  							$countrank++;
					}
					if (defined("OGS_PLUGIN_DEBUG"))
						fwrite($fp,"résult requète stats player: ".$res_sql_error.", déjà à jour: ".$already_update.", countrank: ".$countrank."\n");

				}// FIN boucle FOR()
				
				if (defined("OGS_PLUGIN_DEBUG"))
					fwrite($fp,"**Fin boucle analyse ligne classement\n");
				//
				// Maj stats sur insertion stats joueurs
				//user_set_stat($user_id, null, null, null, null, null, null, null, null, $countrank);
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"plg_statsranking_update who: ".$who." , ".$statsranktypestrings[$what].", countrank: ".$countrank." \n");
				//
				// toutes les lignes de stats déjà à jour -> notifier et quitter

				// Maj stats sur insertion stats players -> retiré et mise en commun

			}elseif($who == 1){ // STATS ALLIANCES
				if(defined("OGS_PLUGIN_DEBUG"))
					fwrite($fp,"allystats...\n");// ligne débug , commentaire si pas utile
				// test handle ally stats on mod server
				if (!$plug_handleallystats) return SendHttpStatusCode("782");
        
				// Allystats -	// non	implémenté dans ogspy 0.301b
				$newarray = preg_split("/&\w+=/",$curr_statstext);
				//
				$stats_array['rank']	   = explode("|",$newarray[1]);
				$stats_array['alliance'] = explode("|",$newarray[2]);
				$stats_array['member']	 = explode("|",$newarray[3]);
				$stats_array['points']	 = explode("|",$newarray[4]);
				//
				unset($newarray);
				//--------- inutile de faire test version, seul 0.302 gère classement alliance ------------------
				$ranktable = $allyranktables302[$what];
				//---------------------------------
				if (defined("OGS_PLUGIN_DEBUG"))
					fwrite($fp,"début boucle (->".count($stats_array['alliance']).")\n");
				//
				$max_count_statsrows = count($stats_array['alliance']);
				// détermination de l'intervale pour les stats
				$intervranking = $stats_array['rank'][0].'-'.($stats_array['rank'][0]+$max_count_statsrows-1);
				for ($i=0; $i < $max_count_statsrows; $i++) {
					/////////////////////////////
					// PREPARATION DES DONNEES //
					/////////////////////////////
					
					//add by chapodepay (compatibilité 74d)					
          //$stats_array['alliance'][$i]=ereg_replace("(.*)allytag=([a-zA-Z0-9 \.\-\+_]{0,})\" target=\"_ally\">(.*)$","\\2",$stats_array['alliance'][$i]);
					//$stats_array['alliance'][$i]=ereg_replace("(.*)<a href=\"allianzen.php\?session=[a-zA-Z0-9]{0,}\"> \n   		 \n        ([a-zA-Z0-9 \.\-\+_]{1,})</a>$","\\2",$stats_array['alliance'][$i]);
					//
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"what: ".$what.", ranktable:". $ranktable.",". $timerankdata.", rank:".$stats_array['rank'][$i].", alliance: ". $stats_array['alliance'][$i].", member:". $stats_array['member'][$i].", points: ". $stats_array['points'][$i].", mbp: ". /*$per_member_points.*/" \n");
					// insertion ligne de données

					// tests nature variables à faire au niveau du plugin
	        if (isset($stats_array['rank'][$i]) && isset($stats_array['alliance'][$i]) && isset($stats_array['points'][$i])){
	        
	        
      			// Test existence champs utile pour Ogame - qui n'existe pas dans la table unispy
      			$result_testcol1 = OGSPlugin_DoDBColumnExists($ranktable, 'number_member'); // "DESCRIBE `$ranktable` `number_member`;";
            $result_testcol2 = OGSPlugin_DoDBColumnExists($ranktable, 'points_per_member'); // "DESCRIBE `$ranktable` `points_per_member`;";

            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,">>>>> affected rows:".$result_testcol1.",  $result_testcol2\n");

  						if ($timerankdata !== false) {
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Créneau horaire stats OK($timerankdata)\n");

            if ($result_testcol1==true && $result_testcol2==true) {
    						$per_member_points = round($stats_array['points'][$i] / $stats_array['member'][$i]);
    						if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Stats ogspy v3.02.\n");
    						    plg_ImportRanking_ally( $allyranktables302[$what], $timerankdata, $stats_array['rank'][$i], $stats_array['alliance'][$i], $stats_array['member'][$i], $stats_array['points'][$i], $per_member_points);
						    } elseif(isset($stats_array['member'][$i])) // -1 pour les paramètres qui ne devront pas être pris en compte
                    plg_ImportRanking_ally( $allyranktables302[$what], $timerankdata, $stats_array['rank'][$i], $stats_array['alliance'][$i], -1, $stats_array['points'][$i], -1);

              } else SendHttpStatusCode("785");


						$res_sql_error = $db->sql_error();
						if ($res_sql_error["code"]==1062)
							$already_update++;
						elseif ($res_sql_error["code"]==0)
							$countrank++;
						if(defined("OGS_PLUGIN_DEBUG"))
              $res_sql_error = $db->sql_error(); // mysql_errno($db->$dbselect /*$db*/
							fwrite($fp,"résult requète stats ally: ".$res_sql_error["code"].", countrank: ".$countrank."\n");
					} else if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"hors isset\n");
				}
				 //
				 // Maj stats sur insertion stats alliance -> retiré et mise en commun
	                         //
			} else SendHttpStatusCode("722"); // valeur code $who incohérente > 1
			
      // actions gestion classement généraux players/alliances communes
			
      ############# Code temporaire - vars $log_logogsplayerstats / $$log_logogsallystats pas dispo ################
      /* if ($log_logogsplayerstats=='') $log_logogsplayerstats = $server['naq_logogsplayerstats'];
      if ($log_logogsallystats=='') $log_logogsallystats = $server['naq_logogsallystats']; */
      ##############################################################################################################
      // JOURNALISATION
      if ($countrank>0) {
          if (($who==0 && $log_logogsplayerstats=='1' ) || ($who==1 && ($log_logogsallystats=='1' )))
    					 log_plugin_("load_rank_OGS", array( $who, $statsranktypestrings[$what], $intervranking, $timerankdata, $countrank));
				  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"enr journal stats joueur ok: who $who, statsranktypestrings[what] $statsranktypestrings[$what], timerankdata $timerankdata, countrank $countrank, log_logogsplayerstats $log_logogsplayerstats\n");

    			plg_stats_update('stats', $who, $statsranktypestrings[$what], $countrank);
    	}
      
			//
			/* $num_stattabs_updated=0;
			$num_stattabs_notupdated=0;
			$num_stattabs_partialyupdated=0;
			$num_stattabs_alreadyupdated */
			if ($already_update==$max_count_statsrows) {
				$num_stattabs_alreadyupdated++;
				$http_statsreturncode = "726";
			} elseif ( $countrank == $max_count_statsrows) {
	  				$num_stattabs_updated++;
	  				$http_statsreturncode = "721";
			} elseif ( $countrank < 0 ) {// sinon maj stats partielle -> notifier
	  				$num_stattabs_partialyupdated++;
	  				$http_statsreturncode = "725";
			} elseif ( $countrank ==0 ) {
	  				$num_stattabs_notupdated++;
	  				$http_statsreturncode = "722";
			}
			$numbuffer_iter++;
		} // fin boucle buffering
		
		
		// purge des classment suivants les paramètres serveur
		galaxy_purge_ranking();
		
    //
	if ($numbuffer_iter>1) {
		if (defined("OGS_PLUGIN_DEBUG"))
			fwrite($fp,"Valeur indices tampons: num_stattabs_updated: $num_stattabs_updated-num_stattabs_partialyupdated:$num_stattabs_partialyupdated-num_stattabs_notupdated:$num_stattabs_notupdated-num_stattabs_alreadyupdated:$num_stattabs_alreadyupdated\n");
		if ($num_stattabs_alreadyupdated == $numbuffer_iter) {
			SendHttpStatusCode("730");
		}elseif($num_stattabs_updated == $numbuffer_iter){
			SendHttpStatusCode("727");
		}elseif($num_stattabs_updated < $numbuffer_iter ){// sinon maj stats partielle -> notifier
			SendHttpStatusCode("729");
		}else
			SendHttpStatusCode("728");
	}else{
		SendHttpStatusCode($http_statsreturncode);
	}
}

// Fonction de traitement des vue galaxie
function OGSPlugin_Traitement_Galaxie(){
	global $db, $fp, $is_ogsplugin, $pub_galaxy, $pub_system, $pub_content, $pub_who, $who, $pub_what, $what, $plug_handlegalaxyviews, $ogspy_server_version, $log_logogsgalview, $system, $galaxy;
	global $ogs_set_system;
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"galaxyview...\n"); // ligne débug , commentaire si pas utile
		//
		/////////////////////////////////////////
		// VERIFICATION DROIT IMPORTER GALAXIE //
		/////////////////////////////////////////
		//
		//if (!OGSplugin_controle_droit('system'))  SendHttpStatusCode("704"); // ligne chapodepay
		if (!$ogs_set_system)  SendHttpStatusCode("704");
		// test handle galaxy view on server - mod option
		if (!$plug_handlegalaxyviews) SendHttpStatusCode("780");
		//
		/////////////////
		// GALAXY VIEW //
		/////////////////
		//
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"données de galaxy en traitement\n");
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"données brutes: ".$pub_content."\n");
		//
		$galaxy = (int)$pub_galaxy;
		$system = (int)$pub_system;
		$galaxies_array = explode("<==||==>",utf8_decode($pub_content));
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n______________________________________________________________________________\n");
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n==>Split tampon galaxies en ".count($galaxies_array)." éléments\n");
		$numbuffer_iter = 0;
		foreach($galaxies_array as $curr_gal_buf) { // découpage du tampon
			//
			$gv_source = str_replace("&nbsp;"," ",stripslashes($curr_gal_buf));
			$gv_array = explode("\n",$gv_source);
			$solarstring = $gv_array[0];
			if (defined("OGS_PLUGIN_DEBUG"))
				fwrite($fp,"\n=>chaîne brute système solaire: ".$solarstring."\n");
			if (preg_match("#.*?\s([0-9]):([0-9]{1,3})#", $solarstring, $solarstring_array)){
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"parse ss: ".$solarstring_array[1]."-".$solarstring_array[2]."\n");
			    $galaxy = (int)$solarstring_array[1];
			    $system = (int)$solarstring_array[2];
			}
			unset ($gv_array[1]);
			unset ($gv_array[0]);
			//
			if (defined("OGS_PLUGIN_DEBUG"))
				fwrite($fp,"array count: ".count($gv_array)."...\n"); // ligne débug , commentaire si pas utile
			//
			//===========================================================================================
			// Enregistrement des données de champ de ruine - test de l'existence des champs cible
			$ruincols_exist = OGSPlugin_DoDBColumnExists(TABLE_UNIVERSE, 'ruin_metal');
			$res_sql_error = $db->sql_error();

			if ($ruincols_exist) {

			   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Res test colone `ruin_metal` TABLE_UNIVERSE OK! (".$res_sql_error["code"].")\n");
			} else {
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Res test colone `ruin_metal`  TABLE_UNIVERSE échoué! (".$res_sql_error["code"].")\n");
			}
			//===========================================================================================
			//
			$totalinserted = 0;
			$totalupdated = 0;
			$galcdr_num = $galcdr_added = 0; // vars champs de ruine
			foreach ($gv_array as $gv_row) {
				$gv_entries = explode("|",$gv_row);
				// determine moonsize
				$moon = ($gv_entries[2] > 0) ? 1 : 0;
				//
				$playerstatus = $gv_entries[6];
				//
				if ($gv_entries[0] > 0 && $gv_entries[0] < 16)	{
					//
					/////////////////////////////
					// PREPARATION DES DONNEES //
					/////////////////////////////
					//
          $position = (int)$gv_entries[0];

          // préparation données pour envoie vers ogs::galaxy_add_system(includes...)
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,$galaxy.":".$system.":".$position."||".date("Y-m-d")." ".date("H:i:s")."||".$planetname."||".$moon."||".$playername."||".$allyname."<|>"."\n");
					//
					// CONCATENATION SOUS FORME DE BLOC
					// vérification ligne / pb conflit foxgame
					if ((trim($playername)!='') && (trim($planetname)=='')) {
						// send http header -> partial update
						if (defined("OGS_PLUGIN_DEBUG"))	fwrite($fp,"foxgame conflict...\n"); // ligne débug , commentaire si pas utile
						SendHttpStatusCode("792");
					}
					//
					$timestamp = mktime(); // utilisation date et heure en cours // fonction ogs
					//
					//////////////////////////////////////////
					// INSERTION LIGNE DANS BASE DE DONNEES //
					//////////////////////////////////////////
					//
					if (defined("OGS_PLUGIN_DEBUG"))  fwrite($fp,"juste avant galaxy_add_system...\n");
					if (defined("OGS_PLUGIN_DEBUG"))  fwrite($fp,"=> vars galaxy_add_system: gal:".$galaxy."-sys:".$system."-pos:".$position."-moon:". $moon."-planetname:". $planetname."-". $allyname."-". $playername."-stats". $playerstats."-". $timestamp."\n");
					// au cas où
					// SendHttpStatusCode("702", true, false);
					//
					
    			// test existence champ moon dans table universe : si non -> unispy
    			$testcolmoon = OGSPlugin_DoDBColumnExists(TABLE_UNIVERSE, 'moon');
					
					if ($testcolmoon) {
    					// utf8_decode des champs $gv_entries[1] mis en début de fonction sur $pub_content
    					$result = galaxy_add_system ($galaxy, $system, $gv_entries[0], $moon, trim($gv_entries[1]), trim($gv_entries[7]),trim($gv_entries[5]), $playerstatus, $timestamp, true);
					} else { // unispy
					   $result = galaxy_add_system ($galaxy, $system, $gv_entries[0], trim($gv_entries[1]), trim($gv_entries[7]),trim($gv_entries[5]), $playerstatus, $timestamp, true);
					}
					//
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"retour func galaxy_add_system \n");
					if (isset($result)) { // pas forcément que des insertions, sinon des mises à jour !!!
						list($inserted, $updated, $canceled) = $result; // $result -> gas_result test
						if ($inserted) $totalinserted++;
						if ($updated) $totalupdated++;
						if ($canceled) $totalcanceled++;
						if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"-> ajout ligne réussie :  totalinserted: ".$totalinserted."(inserted: ".$inserted."-updated: ".$updated."- canceled".$canceled."\n");
					} else {
						$totalfailed++;
						if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"-> ajout ligner annulé\n");
					}
					
          // on vérifie que le module champ de ruine existe
          $ruin_metal = ($gv_entries[3] != '' ? intval($gv_entries[3]): 0); // 0 par défaut si champ vide (pas de champ de ruine)
          $ruin_cristal = ($gv_entries[4] != '' ? intval($gv_entries[4]): 0); // 0 par défaut si champ vide (pas de champ de ruine)

          if ($ruincols_exist) {
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> Demande de mise à jour des champs de ruine\n");
              if (OGSPlugin_MajChampdeRuine($galaxy, $system, $gv_entries[0], $ruin_metal, $ruin_cristal)==false) {
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"-> mise à jour des champs de ruine réussie\n");
              }
              
          }

					
				} // fin test valeur position
			}// FIn foreach()
			//log_plugin_("load_system_OGS", array($totalplanet, $totalinserted, $totalupdated, $totalcanceled, $totalfailed, $totaltime));

      // mise à jour des alliances et des status joueurs
      galaxy_add_system_ally();

      // Enregistrement dans le journal
      if ($log_logogsgalview=='1')
				 log_plugin_("load_system_OGS".($cdr_maj==true? "_cdr":""), array($galaxy.":".$system, ($totalinserted+$totalupdated)));
			   $numbuffer_iter++;
  		} // fin foreach
		//
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"all entries finished... ->".$totalinserted."+".$totalupdated."\n");
		if (($totalinserted+$updated) > 0) {
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"numinserted+updated: ".$totalinserted."+".$totalupdated."\n");
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"gv updated...\n"); // ligne débug , commentaire si pas utile
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"______________________________________________________\n");
			//
			// send http header
			if ($numbuffer_iter>1) SendHttpStatusCode("705");
			else SendHttpStatusCode("701");
		} else {
			if ($numbuffer_iter>1) SendHttpStatusCode("706");
			   SendHttpStatusCode("702");
		}
		/* if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"positions wrong...\n");
		ob_end_clean();
		// send http header
		header("HTTP/1.0 602 no update");
		exit(); */
}

function OGSPlugin_Traitement_Galaxyraw(){

  // revoir gestion des droits

	global $db, $fp, $is_ogsplugin, $pub_galaxy, $pub_system, $pub_content, $pub_who, $who, $pub_what, $what, $ogspy_server_version, $log_ogsgalview, $system, $galaxy;
	$lines = stripslashes(utf8_decode($pub_content));
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"galaxyraw: ".$lines."\n");
	$lines = explode(chr(10), $lines);
	$system_added = galaxy_system($lines);
	// voir majs stats galaxy
	//log_("load_system", array($galaxy, $system));
	//log_plugin_("load_system",$num_spyadded);
	if (isset($system_added[0]) && $system_added[0]!="" && isset($system_added[1]) && $system_added[1]!="") {
		if ($log_ogsgalview==true)
			log_plugin_("load_system_OGS", array($galaxy.":".$system. "(".$system_added[0].":".$system_added[1].")", /*$system_added[0].":".$system_added[1]*/(((int)$system_added[0]==$galaxy && (int)$system_added[1]==$system)? 15:0 ) ));
		SendHttpStatusCode("701");
	}
	SendHttpStatusCode("702");
}


// Fonction modifiée le 24/11/2007 par Altharn
/* Modifié le 04/12/07 par Sylar :
	- Identation. J'aime bien quand les tabulations veulent dire quelque chose.
*/ 
function OGSPlugin_Traitement_Messages(){
	global $db, $fp, $ogspy_server_version, $is_ogsplugin, $plug_handleespioreports, $pub_content, $log_logogsspyadd;
	global $ogs_set_spy, $server_config;
	//
	//
	//////////////////////////////////////////
	// VERIFICATION DROIT IMPORTER RAPPORTS //
	//////////////////////////////////////////
	//
	//
	if (isset($ogs_set_spy) && ($ogs_set_spy==0)) { // accès interdit
		if ($is_ogsplugin == true) {
			if (( $ogspy_server_version==OGSPY_0302_VERCONST || $ogspy_server_version==OGSPY_031_VERCONST || $ogspy_server_version==UNISPY_010_VERCONST)) {
				SendHttpStatusCode("714");
			}
		} // else SendHttpStatusCode("403");
	}
	//
	// test prise en charge acceptée sur le serveur - option mod
	if (!$plug_handleespioreports) SendHttpStatusCode("783");
	//
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"données de rapports espio\n");
	//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"données brutes: ".$pub_content."\n");
	//
	/////////////////////////////
	// SPY REPORTS / RAPPORTS  //
	/////////////////////////////
	//
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spy reports...\n"); // ligne débug , commentaire si pas utile	
	//
	// vérification si les données reçues du plugin sont au format HTML
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"pub_content".$pub_content."\n"); // ligne débug , commentaire si pas utile	
	$spyreports_areHTMLData = IsHTMLData($pub_content);
	//============================================================================
	if (strpos($pub_content,"Surowce na") === false) {
		$reportstring = str_replace("&nbsp;"," ",utf8_decode(stripslashes($pub_content)));
	} else {
		if ($spyreports_areHTMLData == true) 
			$reportstring = str_replace("&nbsp;"," ",stripslashes($pub_content));
	}
	//============================================================================
	// Préparation du déformatage HTML
	if ($spyreports_areHTMLData==true) {
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=> données brutes rapport espionnage sont html...\n");
		//
		$reportstring = str_replace("</td>"," </td>",$reportstring);  // " </td>"
		$reportstring = str_replace("\n","",$reportstring);    // "\n"
		$reportstring = str_replace("</th>","</th> \t",$reportstring);
		$reportstring = str_replace("</tr>","</tr>\n",$reportstring);	
    	//	$reportstring = str_replace(" Probabilité de destruction de la flotte d'espionnage","Probabilité de destruction de la flotte d'espionnage",$reportstring);
	} 
	//==========================================================================
	// séparation des rapports
	/* $pos_report_separateur = strpos($reportstring, "<|-|-|>");
	// $reportarray = explode("<td colspan=\"3\" class=\"b\">",$reportstring);
	if ($pos_report_separateur===false) { // séparateur classique non trouvé
		// séparateur HTML
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Motif séparateur rapports <td colspan=\"3\" class=\"b\"> trouvé dans contenu reçu\n");
		$reportarray = explode("<td colspan=\"3\" class=\"b\">",$reportstring); // obsolète
	} else */
		// séparateur texte
	
	// Ajout de la chaine d'éclatement, juste avant chaque date.
	// (ATTENTION) Cela est du vite fait, car cela peut créer un bug si un joueur envoi une date au format ogame (mm:jj hh:mm:ss) dans un message
	// Pour les espionnages, cela devrait etre transparent, mais pour un mod de capture des messages il faudra changer de methode.
	
	// On enlève les codages déjà présent (visiblement ils n'y en pas autant qu'il faudrait)
	$reportstring = str_replace("<|-|-|>"," ",$reportstring);	
	// On rajoute les codes avant chaque date
	$reportstring=preg_replace("/(\d+\-\d+\s\d+\:\d+\:\d+)/", "<|-|-|>$0", $reportstring);
	// On enlève le code dans les rapports d'espionnages que l'on a fait.
	$reportstring=preg_replace("/le \<\|\-\|\-\|\>(\d+\-\d+\s\d+\:\d+\:\d+)/", "le $1", $reportstring);
	// Debug ?!
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"<---------reportstring----------->\n".$reportstring."\n<----------------------------------------------------------->\n");
	// Explosion du tableau maintenant possible.
	$reportarray = explode("<|-|-|>",$reportstring);
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Motif séparateur rapports <|-|-|> trouvé dans contenu reçu\n");
    //}
    //==========================================================================    
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Nombre de lignes dans Reportarray: ".count($reportarray)."\n"); // ligne débug , commentaire si pas utile		
	// Initialisation des variables
	$error = false;
	$newreport = $spy_tabresult = array();
	//
	$spyreport_num = $spy_added = $spy_notadded = $spy_existing = 0;
	$recyclreport_num = $recyclreport_added = $recyclreport_existing = 0;
	$enemyspy_num = $enemyspy_added = $enemyspy_existing = 0;
	// Détermination des modules tiers actifs
	$is_mod_attaque_active = OGSPlugin_IsTargetModActive('attaques');
	// $is_mod_quimobserve_active = OGSPlugin_IsTargetModActive('QuiMobserve'); <-------- Déplacé à l'endroit où il sert, càd avant l'utilisation du mod
	//==========================================================================
	// PARCOURS DU TABLEAU DE MESSAGES SEPARES
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Parcours tableaux des messges séparés\n");
	foreach ($reportarray as $row) { // pour chaque message séparé précédemment
		// déformatage HTML
		if ($spyreports_areHTMLData == true) {
			$row = html_entity_decode($row);
			$html_row = $row;
			$row = strip_tags($row); // retire tags html
			$row = stripslashes($row); // retire les \ de protection
		}
		//
		///////////////////////////////////////////////////////////////////////////			
		/* if (preg_match("#\d{1,2}-\d{1,2}\s\d{1,2}:\d{1,2}:\d{1,2}\s+\tQuartier\sG.n.ral\s+\t\sRetour\sde\sflotte#", $line, $arr)) {
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Message retour de flotte détecté\n");
		} */			
		////////////////////////////////////////////////////////////////////////////////
		$spyreport_found = true;
		if ((strpos($row,"Matières premières sur") !== false)) {				
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport espionnage détecté!\n");
		} else {
			$spyreport_found = false;
		}
		//============================================================================
		$enemyspyreport_found = true;
		if ((strpos($row,"Une flotte ennemie de la ") !== false)) {				
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Espionnage ennemi détecté!\n$row\n");
		} else {
			$enemyspyreport_found = false;
		}															
		//============================================================================
		$recyclreport_found = true;
		if ((strpos($row,"sont dispersées dans ce champ. Vous avez collecté") !== false)) {
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Rapport de recyclage détecté!\n$row\n");
		} else {
			$recyclreport_found = false;
		}
		//============================================================================
		//
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "séparation reportarray -----------------------------------------\n");
		//
		//
		//============================================================================
		### DEBUT DES TRAITEMENTS A PROPREMENT PARLER
		//============================================================================
		if ($spyreport_found==true) {
			// les rapports sont comptabilisés en web dans galaxy_spy(OGSPY)
			//$tmp_report_array = split( chr(10), $row);
			$spy_tabresult = plg_user_galaxy_spy(trim($row));
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Retour plg_user_galaxy_spy\n");
			$spy_added += $spy_tabresult["spy_added"];
			$spy_notadded += $spy_tabresult["spy_notadded"];
			$spy_existing += $spy_tabresult["spy_existing"];
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "Resultat plg_user_galaxy_spy: spy_added $spy_added spy_notadded $spy_notadded spy_existing $spy_existing\n");
			if (!isset($spy_added) or $spy_added<1 /*$spy_added[2]=1*/) $error = true;
			// rapport d'espionnage détecté, inséré, ignoré ou déjà existant
			$spyreport_num++;			
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "spy_added: ".$spy_added."\n ");
			//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp, "$tmp = $parser->parseEntry: ".$tmp."\n");
		} // cas espionnages ennemis
		//============================================================================       
		else if ($enemyspyreport_found==true) {
			$enemyspy_num++;
			//
			SendHttpStatusCode("797", true, false, "L'importation de données du module d'espionnage subit n'a pas abouti!"); // <<--- ?!
			// Recherche du module QuiMObserve
			$quimobserve_mod_exists = file_exists("mod/QuiMObserve/ImportSondageRecu.php"); ///Ogame/OGSpy/mod/allyRanking
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"fichier QuiMObserve ".(($quimobserve_mod_exists==true)?'existe!':'n\'existe pas!')."\n");
			$is_mod_quimobserve_active = OGSPlugin_IsTargetModActive('QuiMobserve');
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Module QuiMObserve ".(($is_mod_quimobserve_active==true)?'actif!':'inactif!')."\n");
			// Recherche du mod QuiMSonde
			$quimsonde_plugin_file = "mod/QuiMSonde/qms_plugin.php";
			$quimsonde_exists = file_exists($quimsonde_plugin_file);
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"fichier QuiMSonde ".(($quimsonde_exists==true)?'existe!':'n\'existe pas!')."\n");
			$quimsonde_actif = OGSPlugin_IsTargetModActive('QuiMSonde'); // Ainsi l'import ne fonctionne pas si le mod est installé mais désactivé ...?
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"fichier QuiMSonde ".(($quimsonde_actif==true)?'actif!':'inactif!')."\n");
			// Si les modules existent, on charge leur fichiers.
			if($quimobserve_mod_exists==true) include_once("mod/QuiMObserve/ImportSondageRecu.php");
			if($quimsonde_exists==true) include_once($quimsonde_plugin_file);
			// Enfin, on teste s'ils sont fonctionnels
			$is_quimobserve_ok = function_exists('import_espionages') && $is_mod_quimobserve_active;
			$is_quimsonde_ok = function_exists('add_espionnage') && $quimsonde_actif;
			// S'il au moins l'un des deux est fonctionnel, on lance la routine
			if ( $is_quimobserve_ok || $is_quimsonde_ok ) { // execution code ssi fonction existe
				// gestion module incorporée avec rapports standards, pas de notification directe
				/* if ( $quimobserve_mod_exists==false) {
					SendHttpStatusCode("799"); // non implémenté
				} */
				// filtrage supplémentaire, au cas où
				$preg_result = preg_replace ( '/(\s+Une flotte\sennemie)/', chr(13).'Une flotte ennemie', $row);
				$preg_result = preg_replace ( '/]\s+a\sété/', '] a été', $preg_result);
				// $enemyspy_num = $enemyspy_added = $enemyspy_existing = 0;
				SendHttpStatusCode("810", true, false);
				if($is_quimobserve_ok) {
					$result_quimobs = import_espionages($preg_result);
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement espionnage ennemi QuiMObserve:".$result_quimobs."\n");
				}
				if($is_quimsonde_ok) {
					$result_quimsonde = add_espionnage($preg_result);
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement espionnage ennemi QuiMSonde:".$result_quimsonde."\n");
				}
				switch($result_quimobs) {
					case 1:
						$enemyspy_added++;
						break;
					case 2: 
						$enemyspy_existing++;
						break;
                    default:
						SendHttpStatusCode("797", true, false, "L'importation de rapports d'espionnage ennemi depuis le module «Qui m'Observe» a échoué.");
						break;
				}
				switch($result_quimsonde) {
					case 1:
						$enemyspy_added++;
						break;
					case 2: 
						$enemyspy_existing++;
						break;
                    default:
						SendHttpStatusCode("797", true, false, "L'importation de rapports d'espionnage ennemi depuis le module «Qui m'Sonde» a échoué.");
						break;
				}
			}
		} else if($recyclreport_found==true) { // rapports de recyclage
			$recyclreport_num++; // incrémentation des rapports de recyclage détecté
			$attaques_mod_exists = file_exists("mod/Attaques/import_rc.php"); ///Ogame/OGSpy/mod/allyRanking
			if ($attaques_mod_exists) {
				include_once "mod/Attaques/import_rc.php";
				if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"fichier import_rc existe(recyclage)!\n"); 
				if (function_exists('import_recycl') && $is_mod_attaque_active) { // execution code ssi fonction existe
					//$rapport_content = stripslashes(utf8_decode($pub_content));
					//if (defined("OGS_PLUGIN_DEBUG") && !isset($pub_sendernick)) fwrite($fp,"sendernick non défini\n!");
					//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"rapport de combat posté par ".$pub_sendernick." :\n".$rapport_content."...\n");
					//$tab_row = explode(chr(13).chr(10), $row);
					SendHttpStatusCode("810", true, false);
					$result_rc = import_recycl($row);
					// $recyclreport_num = $recyclreport_added = $recyclreport_existing = 0;
					switch($result_rc) {
						case 1: 
							$recyclreport_added++;
							break;
						case 3: 
							$recyclreport_existing++;
							break;
						default:
							SendHttpStatusCode("797", true, false, "L'importation de rapports de recyclage depuis le module «Gestion des Attaques» a échoué.»");
							break;
					}
					if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement rapport recyclage:".$result_rc."\n");
				}
			}
		}
	} // fin boucle foreach
	if ((!isset($server_config["naq_logogsspyadd"]) || $server_config["naq_logogsspyadd"]=='1') && $spyreport_num>0)  log_plugin_("load_spy_OGS",$spyreport_num);

    // Est-ce que des rapports autres ont été pris en charge
    $no_ennemyspy_handled = $enemyspy_num>0 && ($enemyspy_added+$enemyspy_existing)>0;
    $no_recyclreport_handled =  $recyclreport_num>0 && ($recyclreport_added+$recyclreport_existing) > 0;

    // préparation des contenu de réponse additionnels
    /*if ($enemyspy_num>0)*/ $resp_enemyspy  = "resp_enemyspy=$enemyspy_num/$enemyspy_added/$enemyspy_existing";
    /* else $resp_enemyspy = ""; */
    
    /*if ($recyclreport_num>0)*/ $resp_recyreport = "resp_recyreport=$recyclreport_num/$recyclreport_added/$recyclreport_existing";
    /*else $recyclreport_num = ""; */
    
    $thirdparty_reports_msg = $resp_enemyspy.'<|===/-!-\===|>'.$resp_recyreport;
    // sinon créer tableau de contenu additionnel où seront rassemblés en chaine avec séparateur dans Sendhttpstatuscode

    $total_reportsfound = $spyreport_num + $recyclreport_num + $enemyspy_num;
	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spyreport_num: $spyreport_num - recyclreport_num: $recyclreport_num - enemyspy_num: $enemyspy_num / total_reportsfound: $total_reportsfound\n");
    if ($spy_added == $total_reportsfound || $spy_added == $spyreport_num /*count($reportarray ) */) { // tous rapports espionnage traités
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"okay ".$spyreport_num."\n"); // ligne débug , commentaire si pas utile
		SendHttpStatusCode("711", true, true, $thirdparty_reports_msg);
	} else if ($spy_added>0 && ($spy_notadded>0 || $spy_existing>0) ) { // traitement partiels des rapports d'espionnage
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"pas okay(partiel) ".$spyreport_num."\n"); // ligne débug , commentaire si pas utile
		SendHttpStatusCode("712", true, true, $thirdparty_reports_msg);
	} else if ($spy_added /* $spyreport_num */ == 0 && $spy_notadded == $total_reportsfound /*count($reportarray ) */) { // aucun rapport ajouté
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"pas okay! ".$spyreport_num."\n"); // ligne débug , commentaire si pas utile
		SendHttpStatusCode("713", true, true, $thirdparty_reports_msg);
	} else if ($spyreport_num>0 && ($spy_existing+1) >= $spyreport_num /*count($reportarray ) */ /* || ($spy_existing>0 && $spyreport_num==0)*/) { // 2e condition à revoir // tous les rapports existaient déjà
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Pas OKAY, Rapports déjà inséré\n"); // ligne débug , commentaire si pas utile
		SendHttpStatusCode("715", true, true, $thirdparty_reports_msg);
    } else if ($spyreport_num==0) {
		if (($enemyspy_added+$enemyspy_existing)>0 || ($recyclreport_added+$recyclreport_existing)>0 ) {
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"rapport de recyclage non traité!");
			//SendHttpStatusCode("797", true, true, ($recyclreport_num==0 ? 'Aucun rapport':$recyclreport_num.' rapports')." de recyclage ".($recyclreport_num==0 ? 'ne peut être':'a été')." traité".($recyclreport_num==0 ? '':'s')." sur le serveur ".$server_config['servername']);
			SendHttpStatusCode("716", true, true, $thirdparty_reports_msg);
		} else {
			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Aucun module installé/actif n'a pu prendre en charge d'espionnage ennemi/recyclage");
			SendHttpStatusCode("797", true, true, "Aucun module installé/actif n'a pu prendre en charge d'espionnage ennemi/recyclage");
		}
	}else {
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"spy_added: $spy_added ? total:".count($reportarray )." spy_existing: $spy_existing, num_spyadded: $spyreport_num / recyclreport_existing: $recyclreport_existing, recyclreport_added: $recyclreport_added");
		SendHttpStatusCode("797", true, true, "Le code de sortie OGSPlugin_Traitement_Messages n'a pu être déterminé!");
	}
}

function OGSPlugin_Traitement_RCombat(){
	global  $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $pub_sendernick, $timerankdata;
    /////////////////////////////////////////
		// COMBAT REPORTS - RAPPORTS DE COMBAT //
		/////////////////////////////////////////
		//
		$attaques_mod_exists = file_exists("mod/Attaques/import_rc.php"); ///Ogame/OGSpy/mod/allyRanking
    if ($attaques_mod_exists==true) {
        include_once "mod/Attaques/import_rc.php";
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"fichier import_rc existe!\n");
    }  
    if ( $attaques_mod_exists==false) {
       SendHttpStatusCode("799"); // non implémenté		
    }
		$rapport_content = stripslashes(utf8_decode($pub_content));
		if (defined("OGS_PLUGIN_DEBUG") && !isset($pub_sendernick)) fwrite($fp,"sendernick non défini\n!");
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"rapport de combat posté par ".$pub_sendernick." :\n".$rapport_content."...\n");            
    SendHttpStatusCode("810", true, false);
		$result_rc = import_rc($rapport_content, $pub_sendernick);           
  	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résultat traitement rapport:".$result_rc."\n");
  	if ($result_rc==0) SendHttpStatusCode("800"); 
  	elseif($result_rc==1) SendHttpStatusCode("801"); 
  	elseif($result_rc==2) SendHttpStatusCode("802"); 
  	elseif($result_rc==3) SendHttpStatusCode("803"); 
  	elseif($result_rc==4) SendHttpStatusCode("804");      	
}


function OGSPlugin_Traitement_Allyhistory(){
		global $db, $fp, $ogspy_server_version, $is_ogsplugin;
    global $pub_content, $timerankdata, $pub_alliance, $log_logogsallyhistory, $user_id, $server_config;
    global $ogs_set_ranking;
    
    // ok droit historique alliance perso == droits classemente généraux
    if (!$ogs_set_ranking)// accès interdit
			SendHttpStatusCode("724");
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"allyhistory : ".$pub_alliance."...\n"); // ligne débug , commentaire si pas utile
		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"history content: ".$pub_content."\n");
		//
		//////////////////
		// ALLY HISTORY //
		//////////////////
		$is_mod_allyranking_active = OGSPlugin_IsTargetModActive('allyRanking');
		if (!$is_mod_allyranking_active) SendHttpStatusCode("797", true, true, "Le module AllyRanking n'est pas actif sur ".$server_config['servername']);
		//
		if (@file_exists("mod/allyRanking/ARinclude.php"))
			include "mod/allyRanking/ARinclude.php";
		else
			SendHttpStatusCode("799");
		if (!defined("TABLE_RANK_MEMBERS"))
			SendHttpStatusCode("799");
		if (!isset($pub_alliance) || $pub_alliance=='undefined' || trim($pub_alliance)=='')
			SendHttpStatusCode("732");
			//
      //if (file_exists("mod/allyRanking/ARinclude.php")) include_once("mod/allyRanking/ARinclude.php");
      ///////////////////////////////////////////////////////////////////////////
      // traitement code html classement alliance perso //
  		////////////////////////////////////////////////////
      $tr_array = explode("<tr>",utf8_decode($pub_content));
    	// remove first three rows - less memory wasted
    	unset($pub_content); // libération contenu variable $pub_content
    	unset($tr_array[0]);
    	unset($tr_array[1]);
    	unset($tr_array[2]);
    	// modifié pour util params ogsspy
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"allyparse db select ok\n");
    	$failed_inserts = 0;
    	$already_update = 0;
		//
		$total_ally_members = count($tr_array);
        foreach ($tr_array as $row) {
          	$th_array = explode("<th>",$row);
          	// extract data
          	$playername  = strip_tags($th_array[2]);
          	$playerscore = (int)strip_tags($th_array[5]);
          	$th_array[3] = substr($th_array[3],strpos($th_array[3],"messageziel=")+strlen("messageziel="));
          	$th_array[3] = substr($th_array[3],0,strpos($th_array[3],"\""));
          	$ogame_playerid = $th_array[3];
			      //
          	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"là insérer dans ".TABLE_RANK_MEMBERS." ".$playername." ".$playerscore."\n");
            // insert entry and ignore error message (appears if entry for this day exists)
      			if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"date ally: ".$timerankdata."\n");
      			$query = "INSERT INTO ".TABLE_RANK_MEMBERS." (datadate, player, points, ally, sender_id) ". // date("Y-m-d")." ".date("H:i:s")
                			 "VALUES ( $timerankdata, '$playername', $playerscore, '$pub_alliance', $user_id)";
      			$res = $db->sql_query($query, false, $log_sql_errors);
          	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"requete : ".$query." - ".$res."\n");
            $res_sql_error = $db->sql_error();
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"code res sql : ". $res_sql_error["code"]."\n");
          	//if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"la requete d'insertion a échoué: ".$db->mysql_errno($res)."\n");
          	//if ($db->mysql_errno($res)==1062) SendHttpStatusCode("733");
          	if (!res) $failed_inserts++;
          	$res_sql_error = $db->sql_error();
			if ($res_sql_error["code"]==1062) $already_update++;
        }//FIN foreach()
		if ($already_update==$total_ally_members)
			SendHttpStatusCode("733");
      
       ///////////////////////////////////////////////////////////////////////////
	     //--------------------------------------------------------------------------
       //
		if($failed_inserts>0) // certaines lignes non mises à jour
			SendHttpStatusCode("732");
		if($log_logogsallyhistory)
			log_plugin_("load_allyhistory_OGS", array($pub_alliance,  $timerankdata, ($total_ally_members-$failed_inserts)));
			// list($support, $par_allytag, $timestamp, $count_lines) = $option;
		SendHttpStatusCode("731");
}

function OGSPlugin_Traitement_EmpirePlanetes(){
		global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $timerankdata, $pub_alliance, $log_ogsallyhistory;
		global $pub_view, $pub_xp_mineur, $pub_xp_raideur;
    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire lunes: ".$pub_content."\n");	  
    
     $empire_precontent = str_replace("Somme","",$pub_content);   // modif pour version 0.78 ( Syrus )
     $empire_precontent = preg_replace('/\(.*?\)/', ' ', $empire_precontent);   // modif pour version 0.78 ( Syrus )
	// $empire_precontent = str_replace("(*)","",$empire_precontent);   // modif pour version 0.78 ( Syrus )
	$empire_precontent = str_replace("\x0A","\r\n",$empire_precontent);       // modif pour version 0.78 ( Syrus )
    
// $empire_precontent = str_replace("\n","",$pub_content);
 	  //$empire_precontent = str_replace("\t","",$empire_precontent);

	  //preg_replace('/^\s\s+/|/\n/|/\t/|/\s*$/','',$pub_content);
	  //$empire_precontent = str_replace("</td>"," </td>",$empire_precontent);
    //$empire_precontent = $pub_content;    
	  //$countoccur = count(preg_replace('\s\s+|\n|\t','',$empire_precontent));
	  //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,$countoccur." ont été traitées\n");

	  //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire dégraissé".$empire_precontent."\n");
	  //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"===========================================================\n");
    //$empire_precontent = str_replace("  ","",$empire_precontent);
	  //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire revidé espaces:".$empire_precontent."\n");
	  //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"===========================================================\n");

    //$empire_precontent = str_replace("   ","",$empire_precontent);
    //$empire_precontent = str_replace("  ","",$empire_precontent);
 	  //$empire_precontent = str_replace("</th>","</th> \t",$empire_precontent); 
 	  //$empire_precontent = str_replace("</tr>","</tr>\n",$empire_precontent);


    $empire_precontent = html_entity_decode(utf8_decode($empire_precontent));
	  //$empire_precontent = strip_tags($empire_precontent);
	  // si detection balise html, déformater...
	  $empire_precontent = stripslashes($empire_precontent);
	 // $empire_precontent = str_replace("  ","",$empire_precontent);
	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire planètes: ".$empire_precontent."\n");

    // ce test en premier dû à version inférieure aux tests suivants: 1.0 < 3.02
    if($ogspy_server_version==UNISPY_010_VERCONST && defined("SERVER_IS_UNISPY")) {
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Appel fonction traitement vue globale eunivers\n");
          SendHttpStatusCode("810", true, false, "Le traitement de la vue globale a échoué");

          $pub_xp_mineur = 0; // 0 pour l'instant sinon lire depuis db
          $pub_xp_raideur = 0;

          $res_user_empire=user_set_all_empire($empire_precontent, true);
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Retour fonction traitement vue globale eunivers: $res_user_empire\n");
    }else if ($ogspy_server_version==OGSPY_0302_VERCONST && defined("SERVER_IS_OGSPY")) $res_user_empire=plg_user_set_all_empire($empire_precontent, "planets");
    elseif($ogspy_server_version==OGSPY_031_VERCONST && defined("SERVER_IS_OGSPY")) $res_user_empire=user_set_all_empire($empire_precontent, "planets", true);


	  if ($res_user_empire !== false) {
         if ($pub_gametype == 'eunivers' || ($ogspy_server_version==UNISPY_010_VERCONST && defined("SERVER_IS_UNISPY"))) log_plugin_('user_load_eunivglobalview');
         else log_plugin_('user_load_planet_empire');
	       if($ogspy_server_version==UNISPY_010_VERCONST && defined("SERVER_IS_UNISPY")) SendHttpStatusCode("773");
	       else SendHttpStatusCode("770");
     } else
        if($ogspy_server_version==UNISPY_010_VERCONST && defined("SERVER_IS_UNISPY")) SendHttpStatusCode("774");
        else SendHttpStatusCode("771");

}

function OGSPlugin_Traitement_EmpireLunes(){
		global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $timerankdata, $pub_alliance, $log_ogsallyhistory;
   if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire lunes: ".$pub_content."\n");	  
    
    $empire_precontent = str_replace("Somme","",$pub_content);                // modif pour version 0.78 ( Syrus )
     $empire_precontent = preg_replace("/Moyenne.*?\x0A/", "\r\n", $empire_precontent);   // modif pour version 0.78 ( Syrus )
	$empire_precontent = str_replace("\x0A","\r\n",$empire_precontent);       // modif pour version 0.78 ( Syrus )
    $empire_precontent = html_entity_decode(utf8_decode($empire_precontent)); // modif pour version 0.78 ( Syrus )
	
	  //////////////////$empire_precontent = strip_tags($empire_precontent);
	  // if (preg_match('<\/?[^>]+>') // à re voir pour test présence balise html->texte html sinon plain text
    // $empire_precontent = html2text($empire_precontent);
    $empire_precontent = stripslashes($empire_precontent);
    $empire_precontent = str_replace("\xA0","\x20",$empire_precontent); // modif pour version 0.78 ( Syrus )
	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"empire lunes: ".$empire_precontent."\n");	  
    
 $res_user_empire=plg_user_set_all_empire($empire_precontent, "moons");
    // if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_user_empire=plg_user_set_all_empire($empire_precontent, "moons");
    // else if($ogspy_server_version==OGSPY_031_VERCONST) $res_user_empire=user_set_all_empire($empire_precontent, "moons", true);
    //
    if ($res_user_empire==true) {
         log_plugin_('user_load_moon_empire');
  	     SendHttpStatusCode("775");
    } else SendHttpStatusCode("776");
}


function OGSPlugin_Traitement_Batiments() {
		      global $db, $fp, $ogspy_server_version, $user_id, $log_sql_errors, $is_ogsplugin, $pub_content, $timerankdata, $pub_planetsource;
		      

          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>Etiquette planète reçue :\{".utf8_decode($pub_planetsource)."\}\n");
          //$user_planetsource_vars = array();
          //if (preg_match('#(\S[\w\d\séèçàù]+\S)\s(\(\w+\))?\s?\[(\d:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
          if (preg_match(PLANETLABELREGEXP, utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
          { // resultat positif
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>planetsource found\{$pub_planetsource\}: ".$user_planetsource_vars[1]."(".$user_planetsource_vars[2].") - [".$user_planetsource_vars[3]."]\n\n");
          }

          $buildings_content = html_entity_decode(utf8_decode($pub_content));
          //if (preg_match('#<\/?[^>]+>#',$buildings_content)>0) {
          if (preg_match(HTMLTAGREGEXP,$buildings_content)>0) {
              if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
              $buildings_content = html2text($buildings_content);
          } 
      	  $buildings_content = stripslashes($buildings_content);
      	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>buildings: \n".$buildings_content."\n\n");
      	  //
          //----------------------------------------------------------------------------------------------------------
          //
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Nom planètes reçu: ".$user_planetsource_vars[1]."\n");
          //

          //Planète ou Lune?
          $func_result = DetermineIfPlanetOrMoon($buildings_content, $pub_planetsource);
          if ($func_result==0) $seemsaplanet = null;
          else $seemsaplanet = ($func_result==1 ? true:false);
    
         // recherche de l'emplacement d'insertion dans l'espace personnal empire
         $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[3], $seemsaplanet);
         if ($target_planet_id!=0) {
		         //---------------------------------
             // fields entre `` et pas '' sinon ça marche pas
             $query = "SELECT planet_id, `fields`, temperature, Sat FROM ".TABLE_USER_BUILDING." WHERE user_id=".$user_id." and planet_id=".$target_planet_id.";";
             if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\nrequète recherche valeur à récupérer : ".$query."\n");
             $res = $db->sql_query($query, true, $log_sql_errors);
             list($prev_planetid, $prev_fields, $prev_temperature, $prev_satellite) = $db->sql_fetch_row($res);
            //------------------------------------------------
            //                
            if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_set_building=plg_set_user_building($buildings_content, $target_planet_id,$user_planetsource_vars[1], $prev_fields,  $user_planetsource_vars[3], $prev_temperature, $prev_satellite);
            elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_set_building=user_set_building($buildings_content, $target_planet_id,$user_planetsource_vars[1], $prev_fields,  $user_planetsource_vars[3], $prev_temperature, $prev_satellite, true);
            //                
            if ($res_set_building==true) {
               if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résultat insert building ok\n");
               SendHttpStatusCode("740");
            }
            else SendHttpStatusCode("741");
	       }
             else { // résultat requète vide -pas de colo correcpondate coord trouvée
                 // cas bâtiments, obligé de l'insérer
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"la planète/lune dont les batiments sont reçus n'existe pas dans la base!\n");
                 //
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"substr($user_planetsource_vars[1],0,4): ".substr($user_planetsource_vars[1],0,4)."\n");
                 if (substr($user_planetsource_vars[1],0,6)=='lune' || $func_result==2) {
                     if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"cas lune, necessaire inserer planète avant!!");
                     SendHttpStatusCode("743");
                 //--------------------
                 }
                 /*else*/ $free_planet_id = ($func_result==1 ? 1:10);
                 // récupération toutes id planet max pour déterminer emplacements libres
                 $query = "SELECT planet_id FROM ".TABLE_USER_BUILDING." WHERE user_id=".$user_id." and planet_id>=".$free_planet_id." and planet_id<=".($free_planet_id+8).";";
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\nrequète recherche id planet libres : ".$query."\n");
                 $res = $db->sql_query($query, true, $log_sql_errors);
                 //--------------------
                 $set_planet_id_start=$free_planet_id;
                 if ( $db->sql_numrows($res)>0) // des résultat?
                    while (list($set_planet_id) = $db->sql_fetch_row($res)) {
                          //
                          if ($set_planet_id<=$free_planet_id) $free_planet_id++;
                          else if ($set_planet_id>$free_planet_id) break;
                          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planet_id utilisé: ".$set_planet_id."\n");
                          //$user_planets[$usr_planet_name] = $usr_planet_id;
                          //
                    }
                 // fin examen planet ids, aucun emplacement dispo!
                 if ($free_planet_id==$set_planet_id_start+9) {
                    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"aucun id de planète libre set_planet_id".$set_planet_id." / ".$set_planet_id_start."\n");
                    SendHttpStatusCode("745"); // nombres colos max déjà sur ogspy
                 }
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planet id libre: ".$free_planet_id."\n");
                 //--------------------------------------------------------------------------------

                 //--------------------------------------------------------------------------------
                 if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"insertion planète en position: ".$free_planet_id." de la planète: ".$user_planetsource_vars[1]." de coordonnées: ".$user_planetsource_vars[3]."\n");
                 if (plg_set_user_building($buildings_content, $free_planet_id,$user_planetsource_vars[1], null,  $user_planetsource_vars[3], null, null)==true) {
                    if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"résulat insert building ok\n");
                    SendHttpStatusCode("740");
                 }
                 else SendHttpStatusCode("741");
          }
          //
          if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"si non trouvé en test: ".$user_planets[$user_planetsource_vars[1]]."\n");
}

function OGSPlugin_Traitement_Ressources() { // non utilisée, prototype à terminer
          global $db, $fp, $ogspy_server_version, $user_id, $log_sql_errors, $is_ogsplugin, $pub_content, $timerankdata, $pub_planetsource;
          
          $recources_content = utf8_decode($pub_content);

          // test bâtiment de planète
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"\n=> Recherche de Base lunaire dans pub_content\n");
          // pas au point
          if (strpos($buildings_content, 'Base lunaire')===false) { // test sur faux, cf manuel php, si pas lune est planète!
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une planète! \n");
                $seemsaplanet = true; // ne pas fixer pour l'instant
          } else if (strpos($buildings_content, 'Mine de métal')===false) {
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"=>la composition des bâtiments semble celle d'une lune!\n");
              $seemsaplanet = false; // ne pas fixer pour l'instant
          } else $seemsaplanet = null;


         // recherche de l'emplacement d'insertion dans l'espace personnal empire
         $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[2], $seemsaplanet);
          
          SendHttpStatusCode("757", true, true, "message");

}

function OGSPlugin_Traitement_Laboratoire(){
          global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $timerankdata, $pub_planetsource, $user_id;
          
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Page technos...\n");
          if (empty($pub_content)) {
              if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"pub_content vide..\n");
              SendHttpStatusCode("747");
              } 
          
          $technos_content = html_entity_decode(utf8_decode($pub_content));
            // decode utf8
          if (preg_match('#<\/?[^>]+>#',$technos_content)>0) {
              if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
              $technos_content = html2text($technos_content);
          }    
          // stripslashes
          $technos_content = stripslashes($technos_content);
	       //
          if ($ogspy_server_version==OGSPY_0302_VERCONST) $res_set_technology =plg_user_set_technology($technos_content);
          elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_set_technology =user_set_technology($technos_content, true);         
                  
         if ($res_set_technology==true) {
      	     if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"retour settechnology\n");
      	     SendHttpStatusCode("746");
	       } else SendHttpStatusCode("747");
}

function OGSPlugin_Traitement_Defense(){
		      global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $timerankdata, $pub_planetsource, $user_id;

          //SendHttpStatusCode("799");
          //$user_planetsource_vars = array();
          
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>Etiquette planète reçue :\{$pub_planetsource\}\n");
          //$user_planetsource_vars = array();

          //capture du nom de planète/lune et coordonnées
          if (preg_match('#(\S[\w\d\séèçàù]+\S)\s(\(\w+\))?\s?\[(\d:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
          { // resultat positif
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>planetsource found\{$pub_planetsource\}: ".$user_planetsource_vars[1]."(".$user_planetsource_vars[2].") - [".$user_planetsource_vars[3]."]\n\n");
          }

          $defence_content = html_entity_decode(utf8_decode($pub_content));
          if (preg_match('#<\/?[^>]+>#',$defence_content)>0) {
              if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
              $defence_content = html2text($defence_content);
          }
      	  $defence_content = stripslashes($defence_content);
      	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"==>buildings: \n".$defence_content."\n\n");
      	  //
          //----------------------------------------------------------------------------------------------------------
          //
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Nom planètes reçu: ".$user_planetsource_vars[1]."\n");
          //

          //Planète ou Lune?
          $func_result = DetermineIfPlanetOrMoon($defence_content, $pub_planetsource);
          if ($func_result==0) $seemsaplanet = null;
          else $seemsaplanet = ($func_result==1 ? true:false);

      	  $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[3], $seemsaplanet);
      		if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"get defense planet id pour ".$user_planetsource_vars[1]."(".$user_planetsource_vars[3].") -> (".$target_planet_id.")\n");

      	  if ($target_planet_id!=0) {
      	  	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"insertion defense en ".$target_planet_id."\n");
      		
      		// partie de code suivant commenté: la fonction embarquée avec le module suffit puisque la table ne change pas
          /* if ($ogspy_server_version==OGSPY_0302_VERCONST) */ $res_user_defence=plg_user_set_defence($defence_content, $target_planet_id,$user_planetsource_vars[1], null,  $user_planetsource_vars[3], null, null);
          // elseif($ogspy_server_version==OGSPY_031_VERCONST) $res_user_defence=user_set_defence($defence_content, $target_planet_id,$user_planetsource_vars[1], null,  $user_planetsource_vars[2], null, null, true);
          
          if ($res_user_defence==true)
      	  	   SendHttpStatusCode("765");
      	  	else SendHttpStatusCode("766");
      	  } else {
      	  	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"inserer planete avant\n");
      		  SendHttpStatusCode("743");
      		}
      	  if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"retour setdefence\n");
      	  SendHttpStatusCode("766");
}

function OGSPlugin_Traitement_ChantierSpatial(){
		      global $db, $fp, $is_ogsplugin, $pub_content, $pub_planetsource, $user_id;
		
          SendHttpStatusCode("799"); // pas de fonction d'importation des données chantier spatial
          // decode utf8
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"traitement chantier spatial...\n");
          $flotten_precontent = html_entity_decode(utf8_decode($pub_content));
          if (preg_match('#<\/?[^>]+>#',$flotten_precontent)>0) {
              if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
              $flotten_precontent = html2text($flotten_precontent);
          }
          $flotten_precontent = stripslashes($flotten_precontent);           
          // pas d'appel de fonction
}

function OGSPlugin_Traitement_Flotte(){
		      global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $timerankdata, $pub_alliance, $log_ogsallyhistory, $user_id;
		      global $pub_planetsource;
          //
          // données déjà brutes
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"traitement flotte...\n");
          //
          $flotten_precontent = utf8_decode($pub_content); // décodage des données du plugin
          //
          $fleetdata_areHTMLData = IsHTMLData($flotten_precontent);
          //
          if ($fleetdata_areHTMLData==true) {
              $flotten_precontent = html_entity_decode($flotten_precontent);
              if (preg_match(HTMLTAGREGEXP,$flotten_precontent)>0 ||
                  $fleetdata_areHTMLData==true) {
                  if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"déformatage html...\n");
                  $flotten_precontent = html2text($flotten_precontent);
              }
          }
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"flotte déformaté:\n".$flotten_precontent."\n");

          $flotten_precontent = stripslashes($flotten_precontent); // (*1)
          //====================================================================
          if (preg_match(PLANETLABELREGEXP, utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
          { // resultat positif
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planetsource found: ".$user_planetsource_vars[1]." - ".$user_planetsource_vars[3]."\n");
          }
          
          // recherche stricte: planète/lune doit obligatoirement exister à l'identique
          $target_planet_id = plg_getplanetidbycoord($user_planetsource_vars[1] , $user_planetsource_vars[3], null, true);
          if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"=> id planète: ".$target_planet_id."\n");
          // ===================================================================

          if (preg_match('#Satellite\ssolaire[\s\t]+(\d+)#', $flotten_precontent, $sat_parsingtab)==1)
          { // resultat positif
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"nb sats parsed: ".$sat_parsingtab[1]."\n\n");
          }

          // /Ogame/OGSpy/mod/flottes/flottes_plugin.php
		      // vérification si mod flotte existe
          $flottes_mod_exists = file_exists("mod/flottes/flottes_plugin.php"); ///Ogame/OGSpy/mod/allyRanking
          $is_mod_flotte_active = OGSPlugin_IsTargetModActive('flotte');

          // Mise à jour du nombre de satellites de la planète/lune
             $query = "UPDATE ".TABLE_USER_BUILDING." SET `sat`=".(int)$sat_parsingtab[1]."  WHERE user_id=".$user_id." and planet_id=".$target_planet_id.";";
             $res_update = $db->sql_query($query, true, $log_sql_errors);
             if ($res_update) log_plugin_('update_planet_overview', $user_planetsource_vars[1]);
             if (!$flottes_mod_exists && !$is_mod_flotte_active) {
                if ($res_update) SendHttpStatusCode("777");
                else SendHttpStatusCode("778");
             }
          //=====================================================================
          if ($target_planet_id ==0) SendHttpStatusCode("743"); // aucune planète correspondate trouvée
          //=====================================================================
          
          if ($flottes_mod_exists==true) {
            if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"==> fichier mod flotte détecté\n");
             require_once ("mod/flottes/flottes_plugin.php");
          }
          // décodage Nom planète et coordonnées;
          //$user_planetsource_vars = array();
          if (preg_match('#([a-z,A-Z,0-9,\040,é,à,è]{2,20})\040\[(\d:\d{1,3}:\d{1,2})\]#', utf8_decode($pub_planetsource), $user_planetsource_vars)==1)
          { // resultat positif
            if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"planetsource found: ".$user_planetsource_vars[1]." - ".$user_planetsource_vars[2]."\n");
          }
          
  	      //
          //if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"flotte:|".$flotten_precontent."\n");
          // appel fonction        
	        if ($flottes_mod_exists==true && function_exists('mod_flottes_plugin_shipbyid')) {
	            if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp," appel fonction mod_flottes_plugin_ship(pub_planetsource: $pub_planetsource, target_planet_id: $target_planet_id)\n");

              $resflotten = mod_flottes_plugin_shipbyid($target_planet_id,$flotten_precontent);
              //$resflotten = mod_flottes_plugin_shipbyname($pub_planetsource,$flotten_precontent);
              
              if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"=> code retour fonction flotte: ".$resflotten."\n");              
              
              if ($resflotten==0)  SendHttpStatusCode("736");
              else  SendHttpStatusCode("735");
          }        
          
          SendHttpStatusCode("799");		
}

// traitement des données de planète sup: temp, diam, nb case / nb case max / nb sats
function OGSPlugin_Traitement_DetailsPlanete() {
          global $db, $fp, $ogspy_server_version, $is_ogsplugin, $pub_content, $pub_planetsource, $timerankdata, $user_id;
          
          if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"Entrée fonction 'OGSPlugin_Traitement_DetailsPlanete pour $pub_planetsource'\n");
          $planet_details = utf8_decode($pub_content);
          if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"=> Détails planète(formaté): $planet_details\n");

          $planet_details_tab = explode('|', $planet_details); // moon/planet | name | coords | diam | max temp | curr fields | max fields
          
          $seemsaplanet = ($planet_details_tab[0] =='moon'? false:true);
      	  $target_planet_id = plg_getplanetidbycoord($planet_details_tab[1] , $planet_details_tab[2], $seemsaplanet);

      	  if ($target_planet_id!=0) {
        	  	if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"insertion détails en ".$target_planet_id.": $planet_details\n");

              $res_user_details = OGSPlugin_SetPlanetDetails($target_planet_id, $planet_details_tab); // tableau entier en entrée
              switch($res_user_details) {
              case -1: SendHttpStatusCode("743"); break;
              case 0: SendHttpStatusCode("778"); break;
              case 1:  log_plugin_('update_planet_overview', $user_planetsource_vars[1]);
        	  	         SendHttpStatusCode("777");
                     break;

        	  	}
      	  } else {
      	  	  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"inserer planète avant\n");
      		    SendHttpStatusCode("743");
      		}
      	  if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"retour set planet details\n");
      	  SendHttpStatusCode("778");
}

/* insertion des détails de planète/lune dans la base de données
   -1: la planète/lune n'existe pas
   0: la mise à jour a échoué
   1: la mise jour a réussi
*/
function OGSPlugin_SetPlanetDetails($par_planetid, $par_tabdetails) {
         global $db, $fp, $log_sql_errors, $user_id;
         

         $res = false;
         if (!empty($par_tabdetails[4]) && !empty($par_tabdetails[6])) {
             $curr_field = (int)$par_tabdetails[5];
             $max_field = (int)$par_tabdetails[6];
             
             $temp = (int)$par_tabdetails[4];

             
             $query = "SELECT `Ter`, `BaLu` FROM ".TABLE_USER_BUILDING."  WHERE user_id=".$user_id." and planet_id=".$par_planetid.";";
             $res = $db->sql_query($query); //, true, $log_sql_errors);
             $res_sql_error1 = $db->sql_error($res);
             if (list($terr_decr, $baselun_decr) = $db->sql_fetch_row($res)) {
                 if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"=> Recherche niveau terrafomeur:\n$query\nres sql: ".$res_sql_error1["code"]."\nterr_decr: $terr_decr, baselun_decr: $baselun_decr\n");

                  // afin de s'afficher correctement dans la page empire, le nombre de cases maximum doit être corrigé pour les planètes/lunes
                 if ($par_planetid<10) $max_decr = $terr_decr*5;
                 else $max_decr = $baselun_decr*3;

                 $max_field_corr =($max_field - $max_decr);

                 if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"=> Insertion détails planète dans ".TABLE_USER_BUILDING." : $curr_field/$max_field_corr\n");
                 $query = "UPDATE ".TABLE_USER_BUILDING." SET `fields` = ".$max_field_corr.", `temperature` = ".$temp." WHERE user_id=".$user_id." and planet_id=".$par_planetid.";";
                 $res = $db->sql_query($query); // , true, $log_sql_errors);
                 $res_return = $db->sql_affectedrows();
                 if ($res_return===false) $return_code = -1; // === pour pas confondre avec == 0
                 else if ($res_return==0) $return_code = 1; // pas de mise à jour == données identiques
                 else $return_code = 1;
                 $res_sql_error = $db->sql_error();
                 $error_code = @mysql_errno($res);
                 if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp, $query."\nresult: ".$res_sql_error['code']."/$error_code\n\n");
             } else $return_code = -1;
         } else {
            if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"var field, temp vides\n");
            $return_code = -2;
         }
          if (defined("OGS_PLUGIN_DEBUG") ) fwrite($fp,"OGSPlugin_SetPlanetDetails, code retour: $return_code, resreturn: $res_return / error_code: $error_code\n");
         return $return_code;
}

/**
 * Fonction de mise à jour des colonnes champs de ruine de la table Univers
 * @return false si échec sinon vrai
 **/
function OGSPlugin_MajChampdeRuine($par_gal, $par_sys, $par_pos, $par_ruinemetal, $par_ruinecristal) {
          global $db, $fp, $result_testcol;
          
          if (@file_exists("mod/champ_ruine/champ_ruine.php") /* && $result_testcol */ && $par_ruinemetal>-1 && $par_ruinecristal>-1) {
              // Mise à jour directe des infos champ de ruine, les champs db doivent avoir préalablement été
              $request = "update ".TABLE_UNIVERSE." set ruin_metal = '$par_ruinemetal', ruin_cristal = '$par_ruinecristal'";
              $request .= " where galaxy = '$par_gal' and system = '$par_sys' and row = '$par_pos'";
              $result_cdr = $db->sql_query($request);

              if (!$result_cdr) {
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"===>> maj cdr incorrecte!\n");

              } else {
                  $cdr_maj = true; // maj données champ de ruine ok
                  if (defined("OGS_PLUGIN_DEBUG")) fwrite($fp,"===>> maj cdr correcte: ".$gv_entries[3]."/".$gv_entries[4]."!\n");
              }
					} else $cdr_maj = false;
					return $cdr_maj;
}

/**
 * Fonction de fin de script ogsplugin.php: fermeture des fichiers
 * et cloture de descripteur base de données.
 **/
function OGSPlugin_Terminate(){
        global $db, $fp, $fp_plgcmds, $sqlcodefile;

        $res_sql_error = $db->sql_error();
       
        if (defined("OGS_PLUGIN_DEBUG"))  fclose($fp); // ligne dÚbug , commentaire si pas utile
        if (defined("OGS_PLUGIN_DEBUG"))  fclose($fp_plgcmds); // ligne dÚbug , commentaire si pas utile
        //mysql_close($db);
        if (defined("OGS_PLUGIN_DEBUG"))  $sqlcodefile= fopen("mod/naq_ogsplugin/debug/sqlerrorcodes.txt","w"); // ligne dÚbug , commentaire si pas utile
        if (defined("OGS_PLUGIN_DEBUG")) fwrite($sqlcodefile,"code erreur slq(fin script): ".$res_sql_error["code"]."-".$res_sql_error["message"]."\n");
        if (defined("OGS_PLUGIN_DEBUG"))  fclose($sqlcodefile); // ligne dÚbug , commentaire si pas utile
        //session_close(); // force dÚconnection ogspy si loguÚ :s
        @ob_end_clean(); // vidage tampon;
        $db->sql_close(); // libération du serveur sql
}



?>
