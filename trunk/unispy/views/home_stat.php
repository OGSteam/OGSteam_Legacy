<?php
/***************************************************************************
*	filename	: home_stat.php
*	desc.		:
*	Author		: Ben.12 - http://www.ogsteam.fr/
*	created		: 22/01/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

require "includes/univers.php";

if (!isset($pub_zoom) || !isset($pub_user_stat_name) || !isset($pub_player_comp) || !isset($pub_user_stat_name)) {
	$pub_user_stat_name = "";
	$pub_player_comp = "";
	$pub_user_stat_name = "";
	$pub_zoom = "";
}
if (!check_var($pub_zoom, "Char") || !check_var($pub_player_comp, "Text") || !check_var($pub_user_stat_name, "Text")) {
	redirection("index.php?action=message&id_message=errordata&info");
}

$zoom = $pub_zoom;
$player_comp = $pub_player_comp;
$user_stat_name = $pub_user_stat_name;

if(!isset($zoom)) $zoom = "true";
if(isset($pub_zoom_change_y) && isset($pub_zoom_change_x)) $zoom = ($zoom=="true" ? "false" : "true");
if(!isset($player_comp)) $player_comp = "";
if(isset($user_stat_name) && $user_stat_name != "" && $user_stat_name != $user_data["user_stat_name"]) {
	user_set_stat_name($user_stat_name);
	redirection("index.php?action=home&subaction=stat&zoom=".$zoom."&player_comp=".$player_comp);
}

$individual_ranking = galaxy_show_ranking_unique_player($user_data["user_stat_name"]);
ksort($individual_ranking);

$individual_ranking_2 = galaxy_show_ranking_unique_player($player_comp);

$dates = array_keys($individual_ranking);
$dates2 = array_keys($individual_ranking_2);
$dates = sizeof($dates) > sizeof($dates2) ? $dates : $dates2;

if(sizeof($dates) > 0) {
	$max_date = max($dates);
	$min_date = min($dates);
	if(isset($pub_start_date) && isset($pub_end_date) &&
	preg_match("/^(3[01]|[0-2][0-9]|[1-9])\/([1-9]|0[1-9]|1[012])\/(2[[:digit:]]{3})$/", trim($pub_start_date)) &&
	preg_match("/^(3[01]|[0-2][0-9]|[1-9])\/([1-9]|0[1-9]|1[012])\/(2[[:digit:]]{3})$/", trim($pub_end_date))) {
		

		$min = explode("/", trim($pub_start_date));
		$min = mktime(0,0,0,$min[1],$min[0]-1,$min[2]);
		$max = explode("/", trim($pub_end_date));
		$max = mktime(18,0,0,$max[1],$max[0],$max[2]);

		if($max > $min) {
			$max_date = $max;
			$min_date = $min;
		}
	}
} else {
	$max_date = time();
	$min_date = time();
}
?>
<center>
<form method="get" action="index.php">
<input type="hidden" name="action" value="home" />
<input type="hidden" name="subaction" value="stat" />
<input type="hidden" name="zoom" value="<?php echo $zoom; ?>" />
<table><tr><td class='c'><?php echo $LANG["homestat_StatisticOf"];?></td><td class='c' colspan='2'><?php echo $LANG["homestat_Options"];?></td></tr>
<tr><th>
<input type="text" name="user_stat_name" value="<?php echo $user_data["user_stat_name"]; ?>" />
<input type="submit" value="<?php echo $LANG["homestat_GetStat"];?>" />
</th>
<th rowspan="2"><U><?php echo $LANG["homestat_Range"];?></U> <?php echo $LANG["homestat_RangeStart"];?> <input type="text" size="10"  maxlength="10" name="start_date" value="<?php echo strftime("%d/%m/%Y", $min_date+60*60*2); ?>" /> <?php echo $LANG["homestat_RangeEnd"];?> <input type="text" size="10" maxlength="10" name="end_date" value="<?php echo strftime("%d/%m/%Y", $max_date); ?>" /> <input type="submit" value="<?php echo $LANG["homestat_Send"];?>" /></th>
<th rowspan="2"><?php echo $LANG["homestat_Zoom"];?><input type="image" align="absmiddle" name="zoom_change" src="images/<?php echo ($zoom=="true" ? "zoom_in.png" : "zoom_out.png"); ?>"/></th>
</tr>
<tr><th>
<input type="text" name="player_comp" value="<?php echo $player_comp; ?>" />
<input type="submit" value="<?php echo $LANG["homestat_CompareWith"];?>" /></th>
</tr></table>
</form>

<?php
$first = array("general_pts" => -1, "fleet_pts" => -1, "research_pts" => -1);
$last = array("general_pts" => 0, "fleet_pts" => 0, "research_pts" => 0, "general_rank" => 0, "fleet_rank" => 0, "research_rank" => 0);
$tab_rank = "";

while ($ranking = current($individual_ranking)) {

	$v = key($individual_ranking);

	if($v < $min_date || $v > $max_date) {
		next($individual_ranking);
		continue;
	}

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
	}

	if(isset($ranking["fleet"])) {
		$last["fleet_pts"] = $ranking["fleet"]["points"];
		$last["fleet_rank"] = $ranking["fleet"]["rank"];
		$last_date["fleet"] = $v;
	}

	if(isset($ranking["research"])) {
		$last["research_pts"] = $ranking["research"]["points"];
		$last["research_rank"] = $ranking["research"]["rank"];
		$last_date["research"] = $v;
	}

	$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
	$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
	$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
	$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
	$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
	$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>"."\n</tr>".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$research_points."</th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$fleet_points."</th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$general_points."</th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='180'>".strftime("%d %b %Y %H:%M", $v)."</th>"."\n".$tab_rank;
	$tab_rank = "\t\t"."<tr>"."\n".$tab_rank;

	next($individual_ranking);
}

echo "<p><b><u style='font-size:14px;'>".sprintf($LANG["homestat_StatisticOf2"], $user_data["user_stat_name"])."</u></b></p>";


echo "<table width='800'><tr><td class='c' colspan='2'>".$LANG["homestat_General"]."</td></tr>";


echo "<tr align='center'><th><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=points_rank&titre=".$LANG["homestat_GraphTitleGeneralRanking"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th>\n";


echo "<th align='center'><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=points_points&titre=".$LANG["homestat_GraphTitleGeneralPoints"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th></tr>\n";

echo "<tr><td class='c' colspan='2'>".$LANG["homestat_Fleet"]."</td></tr>";

echo "<tr align='center'><th><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=fleet_rank&titre=".$LANG["homestat_GraphTitleFleetRanking"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th>\n";

echo "<th align='center'><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=fleet_points&titre=".$LANG["homestat_GraphTitleFleetPoints"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th></tr>\n";

echo "<tr><td class='c' colspan='2'>".$LANG["homestat_Technology"]."</td></tr>";

echo "<tr><th align='center'><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=research_rank&titre=".$LANG["homestat_GraphTitleResearchRanking"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th>\n";

echo "<th align='center'><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=research_points&titre=".$LANG["homestat_GraphTitleResearchPoints"]."&zoom=".$zoom."' alt='".$LANG["homestat_NoDataRanking"]."' /></th></tr>\n";

if (!isset($last_date["general"])) $last_date["general"] = "0";
$title = sprintf($LANG["homestat_Notice"], $user_data["user_stat_name"], strftime("%d %b %Y %H:%M", $last_date["general"]));
echo "<tr><td class='c' colspan='2'>".$LANG["homestat_Various"]." ".help(null, $title)."</td></tr>";

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];
$nb_planet = sizeof($user_empire["building"]);
$b = (!empty($user_building) ? round(all_building_cumulate($user_building)/1000) : 0);
$d = (!empty($user_defence) ? round(all_defence_cumulate($user_defence)/1000) : 0 );
$t = (!empty($user_technology) ? round(all_technology_cumulate($user_technology)/1000) : 0);
$f = $last["general_pts"] - $b - $d - $t;

if($f < 0) $f = 0;

if($b==0 && $d==0 && $t==0) echo "<tr><th align='center'>".$LANG["homestat_NoDataEmpire"]."</th>";
elseif($last["general_pts"] == 0) echo "<tr><th align='center'>".$LANG["homestat_NoDataRanking"]."</th>";
else echo "<tr><th align='center' width='400'><img src='index.php?action=graphic_pie&values=".$b."_x_".$d."_x_".$f."_x_".$t."&legend=Batiments_x_Defenses_x_Flotte_x_Technologies&title=".$LANG["homestat_GraphTitleDistributionPoints"]."' alt='".$LANG["homestat_NoDataRanking"]."'/></td>\n";

$planet = array();
$planet_name = array();
for($i=1; $i<=$nb_planet; $i++)
{
	$b = round(all_building_cumulate(array_slice($user_building,$i-1,1))/1000);
	$d = round(all_defence_cumulate(array_slice($user_defence,$i-1,1))/1000);
	if($b!=0 || $d!=0) {
		$planet[] = $b + $d;
		$planet_name[] = $user_building[$i]['planet_name'];
	}
}

if($b==0 && $d==0 && $t==0) echo "<th align='center'>".$LANG["homestat_NoDataEmpire"]."</th></tr></table>";
else echo "<th align='center' width='400'><img src='index.php?action=graphic_pie&values=".implode($planet,"_x_")."&legend=".implode($planet_name,"_x_")."&title=".$LANG["homestat_GraphTitleDistributionPlanets"]."' alt='".$LANG["homestat_NoDataRanking"]."'/></th></tr></table>\n";
?>
<br />


		<table>
		<tr>
			<td class="c" colspan="7"><?php echo sprintf($LANG["homestat_RankingOf"], $user_data["user_stat_name"]);?></a></td>
		</tr>
		<tr>
			<td class="c" width="175"><?php echo $LANG["homestat_Date"];?></td>
			<td class="c" colspan="2"><?php echo $LANG["homestat_GeneralPoints"];?></td>
			<td class="c" colspan="2"><?php echo $LANG["homestat_FleetPoints"];?></td>
			<td class="c" colspan="2"><?php echo $LANG["homestat_FleetResearch"];?></td>
		</tr>
<?php
echo $tab_rank;
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<th width='150' style='border-color:#FF0000'><font color='yellow'>".$LANG["homestat_AverageProgressionPerDay"]."</font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_pts"]-$first["general_pts"])*60*60*24/($last_date["general"]-$first_date["general"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_rank"]-$first["general_rank"])*60*60*24/($last_date["general"]-$first_date["general"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_pts"]-$first["fleet_pts"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_rank"]-$first["fleet_rank"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_pts"]-$first["research_pts"])*60*60*24/($last_date["research"]-$first_date["research"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_rank"]-$first["research_rank"])*60*60*24/($last_date["research"]-$first_date["research"]),2) * (-1))."</i></font></th>"."\n</tr>";
?>

</table>
</center>