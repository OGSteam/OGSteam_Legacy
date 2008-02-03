<?php
/***************************************************************************
*	filename	: home_stat.php
*	desc.		:
*	Author		: Ben.12 - http://ogsteam.fr/
*	created		: 22/01/2006
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

require "includes/spacecon.php";

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
		$min = mktime(22,0,0,$min[1],$min[0]-1,$min[2]);
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
<table><tr><td class='c'>Les statistiques de :</td><td class='c' colspan='2'>Options :</td></tr>
<tr><th>
<input type="text" name="user_stat_name" value="<?php echo $user_data["user_stat_name"]; ?>" />
<input type="submit" value="obtenir les statistiques" />
</th>
<th rowspan="2"><U>intervalle d'étude</U> : du <input type="text" size="10"  maxlength="10" name="start_date" value="<?php echo strftime("%d/%m/%Y", $min_date+60*60*2); ?>" /> au <input type="text" size="10" maxlength="10" name="end_date" value="<?php echo strftime("%d/%m/%Y", $max_date); ?>" /> <input type="submit" value="envoyer" /></th>
<th rowspan="2">zoom : <input type="image" align="absmiddle" name="zoom_change" src="images/<?php echo ($zoom=="true" ? "zoom_in.png" : "zoom_out.png"); ?>" alt="zoom" /></th>
</tr>
<tr><th>
<input type="text" name="player_comp" value="<?php echo $player_comp; ?>" />
<input type="submit" value="comparer avec" /></th>
</tr></table>
</form>

<?php
$first = array("general_pts" => -1, "fleet_pts" => -1, "research_pts" => -1, "mines_pts" => -1, "defenses_pts" => -1);
$last = array("general_pts" => 0, "fleet_pts" => 0, "research_pts" => 0, "mines_pts" => 0, "defenses_pts" => 0, "general_rank" => 0, "fleet_rank" => 0, "research_rank" => 0, "mines_rank" => 0, "defenses_rank" => 0);
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
	
	if($first["mines_pts"] == -1 && isset($ranking["mines"])) {
		$first["mines_pts"] = $ranking["mines"]["points"];
		$first["mines_rank"] = $ranking["mines"]["rank"];
		$first_date["mines"] = $v;
	}
	
	if($first["defenses_pts"] == -1 && isset($ranking["defenses"])) {
		$first["defenses_pts"] = $ranking["defenses"]["points"];
		$first["defenses_rank"] = $ranking["defenses"]["rank"];
		$first_date["defenses"] = $v;
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

	
	if(isset($ranking["mines"])) {
		$last["mines_pts"] = $ranking["mines"]["points"];
		$last["mines_rank"] = $ranking["mines"]["rank"];
		$last_date["mines"] = $v;
	}
	if(isset($ranking["defenses"])) {
		$last["defenses_pts"] = $ranking["defenses"]["points"];
		$last["defenses_rank"] = $ranking["defenses"]["rank"];
		$last_date["defenses"] = $v;
	}
	$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
	$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
	
	$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
	$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
	
	$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
	$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
	
	$mines_rank = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["rank"]) : "&nbsp;";
	$mines_points = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["points"]) : "&nbsp;";
	
	$defenses_rank = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["rank"]) : "&nbsp;";
	$defenses_points = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["points"]) : "&nbsp;";

	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>"."\n</tr>".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$research_points."</th>"."\n".$tab_rank;
	
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$defenses_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$defenses_points."</th>"."\n".$tab_rank;
	
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$mines_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$mines_points."</th>"."\n".$tab_rank;
	
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$fleet_points."</th>"."\n".$tab_rank;
	
	$tab_rank = "\t\t\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>"."\n".$tab_rank;
	$tab_rank = "\t\t\t"."<th width='70'>".$general_points."</th>"."\n".$tab_rank;
	
	$tab_rank = "\t\t\t"."<th width='180'>".strftime("%d %b %Y %H:%M", $v)."</th>"."\n".$tab_rank;
	$tab_rank = "\t\t"."<tr>"."\n".$tab_rank;
	
	next($individual_ranking);
}

echo "<p><b><u style='font-size:14px;'>Les statistiques de ".$user_data["user_stat_name"]."</u></b></p>";

echo "<table width='800'><tr><td class='c' colspan='2'>Général</td></tr>";
echo "<tr><td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=points_rank&titre=Classement par points&zoom=".$zoom."' alt='pas de graphique disponible' /></td> \n";
echo "<td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=points_points&titre=Points total&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Flotte</td></tr>";
echo "<tr><td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=fleet_rank&titre=Classement par flotte&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";
echo "<td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=fleet_points&titre=Points de flotte&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Mines</td></tr>";
echo "<tr><td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=mines_rank&titre=Classement par mines&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";
echo "<td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=mines_points&titre=Points de mines&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Défenses</td></tr>";
echo "<tr><td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=defenses_rank&titre=Classement par defenses&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";
echo "<td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=defenses_points&titre=Points de defenses&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Technologies</td></tr>";
echo "<tr><td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=research_rank&titre=Classement par recherche&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";
echo "<td><img src='index.php?action=graphic_curve&player=".$user_data["user_stat_name"]."&player_comp=".$player_comp."&start=".$min_date."&end=".$max_date."&graph=research_points&titre=Points de recherche&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

$title = "Basé sur vos données dans \"Empire\"";
if (!empty($user_data["user_stat_name"])) {
	$title .= " et les stats de ".$user_data["user_stat_name"];
	if (!empty($last_date["general"]))
		$title .= " du ".strftime("%d %b %Y %H:%M", $last_date["general"]);
}
echo "<tr><td class='c' colspan='2'>Divers ".help(null, $title)."</td></tr>";

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_defence = $user_empire["defence"];
$user_technology = $user_empire["technology"];

$b = round(all_building_cumulate(array_slice($user_building,0,9))/1000);
$d = round(all_defence_cumulate(array_slice($user_defence,0,9))/1000);
$l = round(all_lune_cumulate(array_slice($user_building,9,9), array_slice($user_defence,9,9))/1000);
$t = round(all_technology_cumulate($user_technology)/1000);
$f = $last["general_pts"] - $b - $d - $l - $t;
if($f < 0) $f = 0;

if($b==0 && $d==0 && $l==0 && $t==0) echo "<tr><th align='center'>Pas de données dans l'empire</th>";
elseif($last["general_pts"] == 0) echo "<tr><th align='center'>Pas de données sur le total de points</th>";
else echo "<tr><td align='center' width='400'><img src='index.php?action=graphic_pie&values=".$b."_x_".$d."_x_".$l."_x_".$f."_x_".$t."&legend=Batiments_x_Défenses_x_Lunes_x_Flotte_x_Technologies&title=Dernière répartition des points connue' alt='pas de graphique disponible'/></td>\n";

$planet = array();
$planet_name = array();
for($i=1; $i<=9; $i++)
{
	$b = round(all_building_cumulate(array_slice($user_building,$i-1,1))/1000);
	$d = round(all_defence_cumulate(array_slice($user_defence,$i-1,1))/1000);
	$l = round(all_lune_cumulate(array_slice($user_building,$i+8,1), array_slice($user_defence,$i+8,1))/1000);
	if($b!=0 || $d!=0 || $l!=0) {
		$planet[] = $b + $d + $l;
		$planet_name[] = $user_building[$i]['planet_name'];
	}
}

if($b==0 && $d==0 && $l==0 && $t==0) echo "<th align='center'>Pas de données dans l'empire</th></tr></table>";
else echo "<td align='center' width='400'><img src='index.php?action=graphic_pie&values=".implode($planet,"_x_")."&legend=".implode($planet_name,"_x_")."&title=Proportion des planètes - lunes comprises' alt='pas de graphique disponible'/></td></tr></table>\n";
?>
<br />


		<table>
		<tr>
			<td class="c" colspan="11">Classement de <a><?php echo $user_data["user_stat_name"];?></a></td>
		</tr>
		<tr>
			<td class="c" width="175">Date</td>
			<td class="c" colspan="2">Pts Général</td>
			<td class="c" colspan="2">Pts Flotte</td>
			<td class="c" colspan="2">Pts Mines</td>
			<td class="c" colspan="2">Pts Défenses</td>
			<td class="c" colspan="2">Pts Recherche</td>
		</tr>
<?php
echo $tab_rank;
echo "\t\t"."<tr>"."\n";
echo "\t\t\t"."<th width='150' style='border-color:#FF0000'><font color='yellow'>Progression moyenne par jour :</font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_pts"]-$first["general_pts"])*60*60*24/($last_date["general"]-$first_date["general"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["general_pts"] == -1 || $last_date["general"] == $first_date["general"]) ? "-" : round(($last["general_rank"]-$first["general_rank"])*60*60*24/($last_date["general"]-$first_date["general"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_pts"]-$first["fleet_pts"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["fleet_pts"] == -1 || $last_date["fleet"] == $first_date["fleet"]) ? "-" : round(($last["fleet_rank"]-$first["fleet_rank"])*60*60*24/($last_date["fleet"]-$first_date["fleet"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["mines_pts"] == -1 || $last_date["mines"] == $first_date["mines"]) ? "-" : round(($last["mines_pts"]-$first["mines_pts"])*60*60*24/($last_date["mines"]-$first_date["mines"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["mines_pts"] == -1 || $last_date["mines"] == $first_date["mines"]) ? "-" : round(($last["mines_rank"]-$first["mines_rank"])*60*60*24/($last_date["mines"]-$first_date["mines"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["defenses_pts"] == -1 || $last_date["defenses"] == $first_date["defenses"]) ? "-" : round(($last["defenses_pts"]-$first["defenses_pts"])*60*60*24/($last_date["defenses"]-$first_date["defenses"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["defenses_pts"] == -1 || $last_date["defenses"] == $first_date["defenses"]) ? "-" : round(($last["defenses_rank"]-$first["defenses_rank"])*60*60*24/($last_date["defenses"]-$first_date["defenses"]),2) * (-1))."</i></font></th>"."\n";
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_pts"]-$first["research_pts"])*60*60*24/($last_date["research"]-$first_date["research"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_rank"]-$first["research_rank"])*60*60*24/($last_date["research"]-$first_date["research"]),2) * (-1))."</i></font></th>"."\n</tr>";
?>
</table>
</center>