<?php
/** $Id$ **/
/**
* 
* @package OGSpy
* @subpackage main
* @author Ben.12
* @copyright Copyright &copy; 2007, http://ogsteam.fr/
* @version 4.00 ($Rev$)
* @modified $Date$
* @link $HeadURL$
*/
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require "includes/ogame.php";

if (!isset($pub_user_stat_name) || !isset($pub_player_comp) || !isset($pub_user_stat_name)) {
	$pub_user_stat_name = "";
	$pub_player_comp = "";
	$pub_user_stat_name = "";
}
if (!check_var($pub_player_comp, "Text") || !check_var($pub_user_stat_name, "Text")) {
	redirection("?action=message&id_message=errordata&info");
}

$player_comp = $pub_player_comp;
$user_stat_name = $pub_user_stat_name;

if(!isset($player_comp)) $player_comp = "";
if(isset($user_stat_name) && $user_stat_name != "" && $user_stat_name != $user_data["user_stat_name"]) {
	user_set_stat_name($user_stat_name);
	redirection("?action=home&subaction=stat&player_comp=".$player_comp);
}

$individual_ranking = galaxy_show_ranking_unique_player($user_data["user_stat_name"]);
$individual_ranking_2 = galaxy_show_ranking_unique_player($player_comp);

$dates = array_keys($individual_ranking);
$dates2 = array_keys($individual_ranking_2);
$dates = sizeof($dates) > sizeof($dates2) ? $dates : $dates2;

if (file_exists($user_data['user_skin'].'\templates\home_stat.tpl'))
{
    $tpl = new template($user_data['user_skin'].'\templates\home_stat.tpl');
}
elseif (file_exists($server_config['default_skin'].'\templates\home_stat.tpl'))
{
    $tpl = new template($server_config['default_skin'].'\templates\home_stat.tpl');
}
else
{
    $tpl = new template('home_stat.tpl');
}
if($player_comp != "")
	$tpl->checkIf('is_player_comp',true);

$tpl->SimpleVar(Array(
	"homestat_StatisticOf" => L_("homestat_StatisticOf"),
	"homestat_Options" => L_("homestat_Options"),
	"user_stat_name" => $user_data["user_stat_name"],
	"player_comp" => $player_comp,
	"homestat_GetStat" => L_("homestat_GetStat"),
	"homestat_Range" => L_("homestat_Range"),
	"homestat_RangeStart" => L_("homestat_RangeStart"),
	"homestat_RangeEnd" => L_("homestat_RangeEnd"),
	"homestat_Send" => L_("homestat_Send"),
	"homestat_CompareWith" => L_("homestat_CompareWith"),
));

$first = array("general_pts" => -1, "fleet_pts" => -1, "research_pts" => -1);
$last = array("general_pts" => 0, "fleet_pts" => 0, "research_pts" => 0, "general_rank" => 0, "fleet_rank" => 0, "research_rank" => 0);
$last_points = 0;
ksort($individual_ranking);
end($individual_ranking);
$ranking = current($individual_ranking);
if (isset($ranking["general"]))
{
	$last_points = $ranking["general"]["points"];
}
while ($ranking = current($individual_ranking)) {
	$v = key($individual_ranking);

	if($first["general_pts"] == -1 && isset($ranking["general"])) {
		$first["general_pts"] = $ranking["general"]["points"];
		$first["general_rank"] = $ranking["general"]["rank"];
		$first_date["general"] = $v;
	}

	if($first["fleet_pts"] == -1 && isset($ranking["fleet"])) {
		$first["fleet_pts"] = $ranking["fleet"]["points"];
		$first["fleet_rank"] = $ranking["fleet"]["rank"];
		$first_date["fleet"] = $v;
	}

	if($first["research_pts"] == -1 && isset($ranking["research"])) {
		$first["research_pts"] = $ranking["research"]["points"];
		$first["research_rank"] = $ranking["research"]["rank"];
		$first_date["research"] = $v;
	}

	if(isset($ranking["general"])) {
		$last["general_pts"] = $ranking["general"]["points"];
		$last["general_rank"] = $ranking["general"]["rank"];
		$last_date["general"] = $v;
		$rank_array_general[] = Array(
			"points" => $ranking["general"]["points"],
			"rank" => $ranking["general"]["rank"],
			"time" => $v*1000
		);
	}

	if(isset($ranking["fleet"])) {
		$last["fleet_pts"] = $ranking["fleet"]["points"];
		$last["fleet_rank"] = $ranking["fleet"]["rank"];
		$last_date["fleet"] = $v;
		$rank_array_fleet[] = Array(
			"points" => $ranking["fleet"]["points"],
			"rank" => $ranking["fleet"]["rank"],
			"time" => $v*1000
		);
	}

	if(isset($ranking["research"])) {
		$last["research_pts"] = $ranking["research"]["points"];
		$last["research_rank"] = $ranking["research"]["rank"];
		$last_date["research"] = $v;
		$rank_array_research[] = Array(
			"points" => $ranking["research"]["points"],
			"rank" => $ranking["research"]["rank"],
			"time" => $v*1000
		);
	}
	
	$rank_array[] = Array(
		"general_points" => isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;",
		"general_rank" => isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;",
		"fleet_points" => isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;",
		"fleet_rank" => isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;",
		"research_points" => isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;",
		"research_rank" => isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;",
		"time" => strftime("%d %b %Y %H:%M", $v),
	);
	prev($individual_ranking);
}

ksort($individual_ranking_2);
end($individual_ranking_2);
while ($ranking = current($individual_ranking_2)) {
	$v = key($individual_ranking_2);

	if(isset($ranking["general"])) {
		$rank2_array_general[] = Array(
			"points" => $ranking["general"]["points"],
			"rank" => $ranking["general"]["rank"],
			"time" => $v*1000
		);
	}

	if(isset($ranking["fleet"])) {
		$rank2_array_fleet[] = Array(
			"points" => $ranking["fleet"]["points"],
			"rank" => $ranking["fleet"]["rank"],
			"time" => $v*1000
		);
	}

	if(isset($ranking["research"])) {
		$rank2_array_research[] = Array(
			"points" => $ranking["research"]["points"],
			"rank" => $ranking["research"]["rank"],
			"time" => $v*1000
		);
	}

	prev($individual_ranking_2);
}


if (!isset($last_date)) $last_date = Array("general" => time());
$tpl->SimpleVar(Array(
	"homestat_StatisticOf2" => L_("homestat_StatisticOf2", $user_data["user_stat_name"]),
	"homestat_General" => L_("homestat_General"),
	"homestat_GraphTitleGeneralRanking" => L_("homestat_GraphTitleGeneralRanking"),
	"homestat_NoDataRanking" => L_("homestat_NoDataRanking"),
	"homestat_GraphTitleGeneralPoints" => L_("homestat_GraphTitleGeneralPoints"),
	"homestat_Fleet" => L_("homestat_Fleet"),
	"homestat_GraphTitleFleetRanking" => L_("homestat_GraphTitleFleetRanking"),
	"homestat_GraphTitleFleetPoints" => L_("homestat_GraphTitleFleetPoints"),
	"homestat_Technology" => L_("homestat_Technology"),
	"homestat_GraphTitleResearchRanking" => L_("homestat_GraphTitleResearchRanking"),
	"homestat_GraphTitleResearchPoints" => L_("homestat_GraphTitleResearchPoints"),
	"homestat_Various" => L_("homestat_Various")." ".help(null, L_("homestat_Notice", $user_data["user_stat_name"], strftime("%d %b %Y %H:%M", $last_date["general"]))),
));

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

$b = round(all_building_cumulate(array_slice($user_building,0,9))/1000);
$d = round(all_defence_cumulate(array_slice($user_defence,0,9))/1000);
$l = round(all_lune_cumulate(array_slice($user_building,9,9), array_slice($user_defence,9,9))/1000);
$t = round(all_technology_cumulate($user_technology)/1000);
//$f = $last["general_pts"] - $b - $d - $l - $t;
$f = $last_points - $b - $d - $l - $t;
if($f < 0) $f = 0;
$tpl->SimpleVar(Array(
	"homestat_NoDataEmpire" => L_("homestat_NoDataEmpire"),
	"homestat_NoDataRanking" => L_("homestat_NoDataRanking"),
	"implode_repartition" => "['".L_('homestat_Buildings')."', ".$b."], 
								['".L_('homestat_Defense')."', ".$d."],
								['".L_('homestat_Moons')."', ".$l."],
								['".L_('homestat_Fleet')."', ".$f."],
								['".L_('homestat_Technology')."', ".$t."]"
));



if($b!=0 || $d!=0 || $l!=0 || $t!=0)
	$tpl->checkIf('is_empire',true);
if($last["general_pts"] != 0)
	$tpl->CheckIf('is_repartition',true);

$planet = array();
for($i=1; $i<=9; $i++)
{
	$b = round(all_building_cumulate(array_slice($user_building,$i-1,1))/1000);
	$d = round(all_defence_cumulate(array_slice($user_defence,$i-1,1))/1000);
	$l = round(all_lune_cumulate(array_slice($user_building,$i+8,1), array_slice($user_defence,$i+8,1))/1000);
	if($b!=0 || $d!=0 || $l!=0) {
		$planet[] = "['".$user_building[$i]['planet_name']."', ".($b + $d + $l)."]";
	}
}

$tpl->SimpleVar(Array(
	"implode_planet" => implode(',', $planet),
	"homestat_GraphTitleDistributionPlanets" => L_("homestat_GraphTitleDistributionPlanets"),
	"homestat_GraphTitleDistributionPoints" => L_("homestat_GraphTitleDistributionPoints"),
	"homestat_RankingOf" => L_("homestat_RankingOf", $user_data["user_stat_name"]),
	"homestat_Date" => L_("homestat_Date"),
	"homestat_GeneralPoints" => L_("homestat_GeneralPoints"),
	"homestat_FleetPoints" => L_("homestat_FleetPoints"),
	"homestat_FleetResearch" => L_("homestat_FleetResearch"),
));

if(isset($rank_array)){
	$tpl->CheckIf('is_rank',true);
	foreach($rank_array as $rank)
		$tpl->loopVar('rank',$rank);
}
if(isset($rank_array_general)){
	$tpl->CheckIf('is_rank_general',true);
	foreach($rank_array_general as $rank)
		$tpl->loopVar('rank_general',$rank);
}
if(isset($rank_array_fleet)){
	$tpl->CheckIf('is_rank_fleet',true);
	foreach($rank_array_fleet as $rank)
		$tpl->loopVar('rank_fleet',$rank);
}
if(isset($rank_array_research)){
	$tpl->CheckIf('is_rank_research',true);
	foreach($rank_array_research as $rank)
		$tpl->loopVar('rank_research',$rank);
}
if(isset($rank2_array_general)){
	$tpl->CheckIf('is_rank2_general',true);
	foreach($rank2_array_general as $rank)
		$tpl->loopVar('rank2_general',$rank);
}
if(isset($rank2_array_fleet)){
	$tpl->CheckIf('is_rank2_fleet',true);
	foreach($rank2_array_fleet as $rank)
		$tpl->loopVar('rank2_fleet',$rank);
}
if(isset($rank2_array_research)){
	$tpl->CheckIf('is_rank2_research',true);
	foreach($rank2_array_research as $rank)
		$tpl->loopVar('rank2_research',$rank);
}

$tpl->SimpleVar(Array(
	"homestat_AverageProgressionPerDay" => L_("homestat_AverageProgressionPerDay"),
	"general_points" => (($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_pts"]-$first["general_pts"])*60*60*24/($last_date["general"]-$first_date["general"]),2)),
	"general_rank" => (($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_rank"]-$first["general_rank"])*60*60*24/($last_date["general"]-$first_date["general"]),2) * (-1)),
	"fleet_points" => (($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_pts"]-$first["fleet_pts"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2)),
	"fleet_rank" => (($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_rank"]-$first["fleet_rank"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2) * (-1)),
	"research_points" => (($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_pts"]-$first["research_pts"])*60*60*24/($last_date["research"]-$first_date["research"]),2)),
	"research_rank" => (($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_rank"]-$first["research_rank"])*60*60*24/($last_date["research"]-$first_date["research"]),2) * (-1)),
));

$tpl->parse();
