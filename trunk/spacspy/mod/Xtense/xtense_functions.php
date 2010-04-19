<?php
/**
* xtense_functions.php
* @package Xtense
*  @author Naqdazar, then modified by OGSteam
*  @link http://www.ogsteam.fr
*  @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}


function Get_OGServer_Version(){
  global $server_config;
  //preg_match("","",$serverversion);
  if (defined("XTENSE_PLUGIN_DEBUG")) global $fp;
  if (preg_match("#^3\.1.*?$#",$server_config["version"],$serverversion)==1) { 
      if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"Version serveur 3.1 détectée!\n");
      $result=OGSPY_031_VERCONST; }
  elseif (function_exists('galaxy_ImportRanking_player') and function_exists('galaxy_ImportRanking_ally')) { $result=OGSPY_0302_VERCONST; }
  elseif (function_exists('galaxy_ImportRanking')) { $result=OGSPY_0301B_VERCONST; }
  else	$result="indéterminée";
  return $result;
}
//
function To_Std_Update_Time($timetoadjust) {
   	$ltime = $timetoadjust-60*4;
	if ($ltime > mktime(0,0,0) && $ltime < mktime(8,0,0)) $LStd_Update_Time = mktime(0,0,0);
	if ($ltime > mktime(8,0,0) && $ltime < mktime(16,0,0)) $LStd_Update_Time = mktime(8,0,0);
	if ($ltime > mktime(16,0,0) && $ltime < (mktime(0,0,0)+60*60*24)) $LStd_Update_Time = mktime(16,0,0);
   return $LStd_Update_Time;
}
//
function SendHttpStatusCode($StatusCode, $Ob_clean=true, $exit_on_return=true, $responsetext="") {
	// $ogspy_error_codes
	global $is_ogsplugin, $db;
	//	
  if (defined("XTENSE_PLUGIN_DEBUG")) global $fp; // pour fermeture finale
  if (defined("XTENSE_PLUGIN_DEBUG")){
		$sqlcodefile= fopen("Xtense_debug/sqlerrorcodes.txt","a+"); // ligne débug , commentaire si pas utile
		fwrite($sqlcodefile,"header: ".$StatusCode." / message: ".$responsetext."\n");
		if (isset($db->$dbselect)){
			fwrite($sqlcodefile," / code erreur slq(fin script): ".mysql_errno($db->$dbselect)."-".mysql_error($db->$dbselect)."\n");
		}
		fclose($sqlcodefile); // ligne débug , commentaire si pas utile
	}
	//
	if ($Ob_clean == true) ob_end_clean();
  //
  if ($is_ogsplugin == true)  header("HTTP/1.0 ".$StatusCode);
  //
  //$httpresponsetext = array($StatusCode, utf8_encode($responsetext));
  //
	if ($exit_on_return ==true) {
		if (defined("XTENSE_PLUGIN_DEBUG"))  fclose($fp);
    if (trim($responsetext)!="") exit(utf8_encode($responsetext)); // code les espaces et autres pour eviter les etats de requète <>4
		else exit($StatusCode); // maj galaxie
	}
}

function plg_user_ogs_login() {
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
		$request = "insert into ".$ranktable;
		$request .= " (datadate, rank, ally, number_member, points, points_per_member, sender_id)";
		$request .= " values (".$timestamp.", ".$rank.", '".mysql_real_escape_string($allytag)."', ".$number_member.", ".$points.", ".$points_per_member.", ".$user_data["user_id"].")";
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
	global $log_ogsplayerstats, $log_ogsallystats;
        //
	/*if ($server_config["debug_log"] == "1") {
		//Sauvegarde données tranmises
		$nomfichier = PATH_LOG_TODAY.date("ymd_His")."_ID".$user_data["user_id"]."_ranking_".$par_ranktype.".txt";
		write_file($nomfichier, "w", $files);
	}*/
	$timestamp = To_Std_Update_Time(time());
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "num countrank: ".$par_countlines." - par_whoseranking: ".$par_whoseranking."\n");
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
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "log->".$stat_field_name."\n");
	//
        //
        //Statistiques serveur
	$request = "update ".TABLE_STATISTIC." set statistic_value = statistic_value + ".$par_countlines;
	$request .= " where statistic_name = '".$stat_field_name."';";
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "requète fin fonction plg_statsranking_update -> ".$request."\n");
	$db->sql_query($request, false, $log_sql_errors);
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "nb lignes requète: ".$db->sql_affectedrows()." sqlerror: ".mysql_errno()."\n");
	if ($db->sql_affectedrows() == 0) {
		$request = "insert into ".TABLE_STATISTIC." values ('".$stat_field_name."', '".$par_countlines."')";
		$db->sql_query($request, false, $log_sql_errors);
	}
	if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp, "fin fonction plg_statsranking_update -> ".TABLE_STATISTIC."\n");
	return $db; // utilité à revoir
}
//
function log_plugin_ ($parameter, $option=0) {
	global $db, $user_data, $user_name, $pub_pluginversion;
	$member = $user_name;
        switch ($parameter) {
		/* ----------- Gestion systèmes solaire et rapports ----------- */
		case 'load_system_OGS' :
		     list($lsystem, $num_plan  ) = $option;
         $line = $member." charge ".$num_plan." planètes du système ".$lsystem." via le plugin Xtense (".$pub_pluginversion.")";
		break;
		//
		case 'load_spy_OGS' :
		     $line = $member." charge ".$option." rapport(s) d'espionnage via le plugin Xtense (".$pub_pluginversion.")";
		break;
		/* ----------- Gestion des membres ----------- */
		case 'login_ogsplugin_new' :
		     $line = "Connexion de ".$member." via le plugin Xtense (".$pub_pluginversion.")";
		break;
		case 'login_ogsplugin_upd' :
		     $line = "Connexion de ".$member." via le plugin Xtense (".$pub_pluginversion.")[renouvellement de session]";
		break;
		/* ----------- Classement ----------- */
		case 'load_allyhistory_OGS':
		     list($par_allytag, $timestamp, $lcountlines) = $option;
                     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." envoie le classement alliance ".$par_allytag." du ".$date." via le plugin Xtense (".$pub_pluginversion.") [".$lcountlines." membres]";
		break;
                //
    case 'load_rank_OGS' :
		     list( $par_whoseranking, $typerank, $timestamp, $countrank) = $option;
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
		     $line = $member." envoie le classement ".$par_whoseranking."(".$typerank.") du ".$date." via le plugin Xtense (".$pub_pluginversion.") [".$countrank." lignes]";
		break;
		/* ----------------------------------------- */
		//  user_load_building, user_load_technos, user_load_shipyard, user_load_fleet, user_load_defense, user_load_planet_empire, user_load_moon_empire
    case 'user_load_buildings' :
		     // $pub_planetsource
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page bâtiments pour ".$option;
		break;

    case 'user_load_technos' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page technologie";
		break;

    case 'user_load_shipyard' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page chantier spatial pour ".$option;
		break;
                
    case 'user_load_fleet' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page flotte pour ".$option;
		break;
                
    case 'user_load_defense' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page défense pour ".$option;
		break;
                
    case 'user_load_planet_empire' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page empire pour l'ensemble de ses planètes";
		break;
		
    case 'user_load_moon_empire' :
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $member." met à jour sa page empire pour l'ensemble de ses lunes";
		break;
		
		case 'unallowedconnattempt_OGS' :
		     list( $par_user_name, $par_user_password, $par_user_ip) = $option;
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $par_user_name." (".$par_user_ip.") a tenté de se connecter sans autorisation";
		break;
		
		case 'unattendedogameserver_OGS' :
		     list( $par_user_name, $par_user_password, $par_user_ip) = $option;
		     $date = strftime("%d %b %Y %Hh", $timestamp);
		     $line = $par_user_name." (".$par_user_ip.") a tenté d'envoyer des données d'un autre univers!";
		break;

		case 'debug' :
		    $line = 'DEBUG : '.$option;
		break;
		//
		default:
		    $line = 'Erreur appel fichier log depuis script le plugin Xtense ('.$pub_pluginversion.') - '.$parameter.' - '.print_r($option);
		break;
	}
	$fichier = "log_".date("ymd").'.log';
	$line = "/*".date("d/m/Y H:i:s").'*/ '.$line;
	write_file(PATH_LOG_TODAY.$fichier, "a", $line);
}
//
//
function plg_getplanetidbycoord($planetname, $planetcoords="", $seemsaplanet=null) { // A REVOIR!!!!
        global $db, $user_id, $user_planetsource_vars, $log_sql_errors;
         
        $nom_lune = "lune"; 
         
         if (defined("XTENSE_PLUGIN_DEBUG")) global $fp;
         
         // test existence planète de même nom ou coord dans la base(coordonnées de préférence)
         if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"---------------------------------------------------------------------------\n");
         if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"début plg_getplanetidbycoord, planetcoords: $planetcoords \n");
         // test bâtiments de planète -- 
         
         //------
         if ($planetcoords!="") { // est-ce que les coordonnées planète sont bien définies?
             // recherche d'une planète déjà enregistréer avec ces coordonnées
             $query = "SELECT planet_name, planet_id FROM ".TABLE_USER_BUILDING." WHERE user_id=".$user_id." and coordinates='".$planetcoords."' and planet_id<10;";
             if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"\n=>requète : ".$query."\n");
             $res = $db->sql_query($query, true, $log_sql_errors);
          } // else coord planète inconnues// 746? nom et coord colo inconnue
          //
          // $seemsaplanet: variable supplémentaire d'aide la la distinction planète/lune
          if (defined("XTENSE_PLUGIN_DEBUG") && (isset($seemsaplanet) || $seemsaplanet!=null ) ) fwrite($fp,"\$seemsaplanet défini\n");
          
          // faire boucle foreach, projection par coordonnées!!
          $request_numrows = $db->sql_numrows($res);
          if ($request_numrows>0) {  // au moins une planète avec ses coordonnées existe
               // listing de toutes les planète de la base dans un tableau
               list($usr_planet_name, $usr_planet_id) = $db->sql_fetch_row($res);// {
               
               //$user_planets[$usr_planet_name] = $usr_planet_id;
               if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,$usr_planet_name."(".$planetname.") --> ".$usr_planet_id."\n");
               //
               if (defined("XTENSE_PLUGIN_DEBUG") && (!isset($usr_planet_name))) fwrite($fp,"usr_planet_name non défini!!\n");
               //
               // nom de planète récupéré
               // test isset($usr_planet_name) inutile si list() ok
               
              if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"Résultat comparaison avec 'lune':".(int)($planetname===$nom_lune)."\n");               
               
               if (// est-ce que c'est une planète: n'a pas le nom "lune"
                  ( /*strcasecmp($usr_planet_name, 'lune')!=0 */ $planetname!==$nom_lune xor // motif chaîne française
                  // nom de planète est "lune" mais déterminé avant appel comme planète
                   ( $seemsaplanet===true)  && $planetname===$nom_lune /*strcasecmp($usr_planet_name, 'lune')==0 */)) { // nom planète déterminé
                  
                  if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"planète: ".$user_planetsource_vars[1]." de coordonnées ".$user_planetsource_vars[2]." existe dans la base\n");
                  if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"----------------fin plg_getplanetidbycoord, retour code planète-----------------------------------------------------------\n");
                  
                  return $usr_planet_id; // renvoie id planète trouvée si correspondance
                  
               } else  { // pas de planet_id trouvée pour lune
               
                  if (defined("XTENSE_PLUGIN_DEBUG") ) fwrite($fp,"insertion lune en ".$user_planetsource_vars[2]." (".($usr_planet_id+9).")\n");
                  if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"----------------fin plg_getplanetidbycoord, retour code lune-----------------------------------------------------------\n");
                  return $usr_planet_id+9;
               }
          } else { // la requète de recherche planète n'a rien retournée: aucune planète existante
                  if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"aucune planète de même coordonnées trouvée\n");
                  return 0; // aucune planète de même coordonnées trouvée
          }
           if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"---------------------------------------------------------------------------\n");
           return 0; // aucun emplacement correspondant trouvé
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
    	  //if (defined("XTENSE_PLUGIN_DEBUG")) fwrite($fp,"buildings HTML: ".$buildings_precontent."\n");
	  //////////////////$empire_precontent = strip_tags($empire_precontent);
	  $text = stripslashes($text);
return $text;

}

function spyreports_html2text($document) {
 	  

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

?>
