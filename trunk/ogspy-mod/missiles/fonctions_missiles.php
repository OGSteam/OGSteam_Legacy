<?php

/*-------------------------------------------
 * FONCTION get_stats_joueur
 *-------------------------------------------
 * retourne le classement d'un joueur
 *-------------------------------------------
 * $p_nom_joueur : nom du joueur recherche
 */
function get_stats_joueur($p_nom_joueur)
{
	global $tooltip_stats;

	$out = "";

	if ( !isset($tooltip_stats[$p_nom_joueur]) )
	{
		$tooltip_stats[$p_nom_joueur] = "<table width=\'100%\'>";
		$individual_ranking_player = galaxy_show_ranking_unique_player($p_nom_joueur);
		while ($ranking = current($individual_ranking_player)) 
		{
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_player));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
			
			$tooltip_stats[$p_nom_joueur] .= "<tr><td class=\'c\' colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip_stats[$p_nom_joueur] .= "<tr><td class=\'c\' width=\"75\">Général</td><th>".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip_stats[$p_nom_joueur] .= "<tr><td class=\'c\'>Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip_stats[$p_nom_joueur] .= "<tr><td class=\'c\'>Recherche</td><th>".$research_rank."</th><th>".$research_rank."</th></tr>";
			break;
		}
		$tooltip_stats[$p_nom_joueur] .= "</table>";
	}
	$out = $tooltip_stats[$p_nom_joueur];

	return $out;
}

/*-------------------------------------------
 * FONCTION get_module_version
 *-------------------------------------------
 * retourne la version du module
 *-------------------------------------------
 */
function get_module_version()
{
	global $db;
	
	//On récupère la version actuel du mod	
	$query = "SELECT version FROM ".TABLE_MOD." WHERE action='missiles' AND `active` = '1' LIMIT 1";
	$result = $db->sql_query($query);
	list($version) = $db->sql_fetch_row($result);	
	
	return $version;
}

?>