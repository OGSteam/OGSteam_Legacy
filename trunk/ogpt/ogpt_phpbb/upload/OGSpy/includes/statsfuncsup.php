<?php
/***************************************************************************
*	filename	:
*	desc.		:
*	Author		:
*	created		: 08/12/2005
*	modified	: 22/06/2006 00:13:20

***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}


//function Get_Player_Ratio() {
 global $db, $user_data, $user_auth, $server_config;
 global $user_ratio;
  $user_statistic = user_statistic();
  
         $user_ratio = 0;
         //Statistiques participation des membres actifs
         $request = "select sum(planet_added_web + planet_added_ogs), ";
         $request .= "sum(spy_added_web + spy_added_ogs), ";
         $request .= "sum(rank_added_web + rank_added_ogs), ";
         $request .= "sum(search) ";
         $request .= "from ".TABLE_USER.";"; // where user_id='".$user_data['user_id']."';";  /// \" where username ='\".$user_data["username"]."';";
         $result = $db->sql_query($request);
         list($planetimport, $spyimport, $rankimport, $search) = $db->sql_fetch_row($result);
         if ($planetimport == 0) $planetimport = 1;
         if ($spyimport == 0) $spyimport = 1;
         if ($rankimport == 0) $rankimport = 1;
         if ($search == 0) $search = 1;

         /* $user_ind_part =  ($spyimport -$search*7)+
                                    (($planetimport-$search*15)/15)+
                                    ($rank_added_web -$search*5);  */

         foreach ($user_statistic as $v) {
                  if ($v["username"]== $user_data["username"]) {


      	          $ratio_planet = ($v["planet_added_web"] + $v["planet_added_ogs"]) / $planetimport;
      	          $ratio_spy = ($v["spy_added_web"] + $v["spy_added_ogs"]) / $spyimport;
      	          $ratio_rank = ($v["rank_added_web"] + $v["rank_added_ogs"]) / $rankimport;
      	          $ratio = ($ratio_planet * 4 + $ratio_spy * 2 + $ratio_rank) / (3 + 2 + 1);

      	          $ratio_planet_penality = ($v["planet_added_web"] + $v["planet_added_ogs"] - $v["planet_exported"]) / $planetimport;
      	          $ratio_spy_penality = (($v["spy_added_web"] + $v["spy_added_ogs"]) - $v["spy_exported"]) / $spyimport;
      	          $ratio_rank_penality = (($v["rank_added_web"] + $v["rank_added_ogs"]) - $v["rank_exported"]) / $rankimport;
      	          $ratio_penality = ($ratio_planet_penality * 4 + $ratio_spy_penality * 2 + $ratio_rank_penality) / (3 + 2 + 1);

      	          $ratio_search = $v["search"] / $search;
      	          $ratio_searchpenality = ($ratio - $ratio_search);

      	          $couleur = $ratio_penality > 0 ? "lime" : "red";




      	          $user_ratio =  (($ratio + $ratio_penality + $ratio_searchpenality) * 1000);
      	          break;
      	           } else continue;
         }
         $balise_ratio_open="";
         $balise_ratio_close="";
         if ($user_ratio < 0) {
           $ratio_color = "red";
           $balise_ratio_open="<blink>";
           $balise_ratio_close="</blink>";
         }
         elseif ($user_ratio == 0) $ratio_color = "white";
         elseif ($user_ratio < 100) {
           $ratio_color = "orange";
           $balise_ratio_open="<u>";
           $balise_ratio_close="</u>";
         }
         else $ratio_color = "lime";
         //----------------------
         $ratiolegend = "<table width=\"330\">";
         $ratiolegend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\" width=\"200\">Légende : indice de participation</td></tr>";
         $ratiolegend .= "<tr><td class=\"c\" align=\"left\">Ratio sur fond</td><th><font color=\"Lime\">Vert</font> : participation suffisante</th></tr>";
         $ratiolegend .= "<tr><td class=\"c\">Ratio sur fond</td><th><font color=\"orange\"><b>Orange</b></font> : participation moyenne</th></tr>";
         $ratiolegend .= "<tr><td class=\"c\">Ratio sur fond</td><th><font color=\"red\"><blink><b>Rouge</blink></font> : participation insuffisante (*). </th></tr>";
         $ratiolegend .= "</table>";
         $ratiolegend .= "(*) Vous risquez une suspension temporaire du mode recherche en deçà d\'une valeur de ratio plancher définie par l\'administrateur.";
         $ratiolegend .= "<br><br>Détails sur la page Statistiques";

         $ratiolegend = htmlentities($ratiolegend);
         //-----------------------


?>