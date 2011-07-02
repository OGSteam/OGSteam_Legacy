<?php
/***************************************************************************
*	filename	: home_stat.php
*	desc.		: 1.03
*	Author		: 
*	created		: 
*	modified	: 
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if (!defined('IN_MOD_FLOTTES')) {
	die("Hacking attempt");
}

require_once("./mod/flottes/flottes_lang.php");
require_once("./includes/".$phpfonc.".php");

if (!isset($pub_zoom)) $pub_zoom = "true";

if (!check_var($pub_zoom, "Char")) {
	redirection("index.php?action=message&id_message=errordata&info");
}

$zoom = $pub_zoom;

if(isset($pub_zoom_change_y) && isset($pub_zoom_change_x)) $zoom = ($zoom=="true" ? "false" : "true");

$quet = mysql_query("SELECT coordinates FROM ".TABLE_USER_BUILDING." WHERE coordinates<>'' and user_id =".$user_data['user_id']." LIMIT 1 ;");
if($result = mysql_fetch_array($quet));
else {
	echo "<center>Statistiques indisponibe</center>";
		exit();
}
$coords = $result['coordinates'];

$coords = explode(":",$coords);

// enfin, d'après ces coords, on trouve le nom ingame du joueur
$quet = mysql_query("SELECT player FROM ".TABLE_UNIVERSE." WHERE galaxy = ".$coords[0]." and system = ".$coords[1]." and row = ".$coords[2]);
$result = mysql_fetch_array($quet);
$nom_player = $result['player'];

$individual_ranking = galaxy_show_ranking_unique_player($nom_player);
ksort($individual_ranking);

$dates = array_keys($individual_ranking);

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
<input type="hidden" name="action" value="flottes" />
<input type="hidden" name="subaction2" value="stat" />
<input type="hidden" name="flottes_user_id" value=<?php echo $user_data['user_id']; ?> />
<input type="hidden" name="zoom" value="<?php echo $zoom; ?>" />
<table><tr><td class='c' colspan='2'>Options:</td></tr>
<tr>
<th><U>intervalle d'étude</U>: du <input type="text" size="10"  maxlength="10" name="start_date" value="<?php echo strftime("%d/%m/%Y", $min_date+60*60*2); ?>" /> au <input type="text" size="10" maxlength="10" name="end_date" value="<?php echo strftime("%d/%m/%Y", $max_date); ?>" /> <input type="submit" value="envoyer" /></th>
<th>zoom: <input type="image" align="absmiddle" name="zoom_change" src="images/<?php echo ($zoom=="true" ? "zoom_in.png" : "zoom_out.png"); ?>" alt="zoom" /></th>
</tr>
</table>
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

echo "<p><b><u style='font-size:14px;'>Les statistiques de ".$nom_player."</u></b></p>";

echo "<table width='800'><tr><td class='c' colspan='2'>Général</td></tr>";

echo "<tr><td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=points_rank&titre=Classement par points&zoom=".$zoom."' alt='pas de graphique disponible' /></td> \n";

echo "<td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=points_points&titre=Points total&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Flotte</td></tr>";

echo "<tr><td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=fleet_rank&titre=Classement par flotte&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";

echo "<td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=fleet_points&titre=Points de flotte&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

echo "<tr><td class='c' colspan='2'>Technologies</td></tr>";

echo "<tr><td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=research_rank&titre=Classement par recherche&zoom=".$zoom."' alt='pas de graphique disponible' /></td>\n";

echo "<td><img src='index.php?action=graphic_curve&player=".$nom_player."&start=".$min_date."&end=".$max_date."&graph=research_points&titre=Points de recherche&zoom=".$zoom."' alt='pas de graphique disponible' /></td></tr>\n";

$title = "Basé sur vos données dans \"Empire\" et les stats de ".$nom_player." du ".strftime("%d %b %Y %H:%M", $last_date["general"]);
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

if($b==0 && $d==0 && $l==0 && $t==0) echo "<tr><th align='center'>Pas de données dans empire</th>";
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

if($b==0 && $d==0 && $l==0 && $t==0) echo "<th align='center'>Pas de données dans empire</th></tr></table>";
else echo "<td align='center' width='400'><img src='index.php?action=graphic_pie&values=".implode($planet,"_x_")."&legend=".implode($planet_name,"_x_")."&title=Proportion des planetes - lunes comprises' alt='pas de graphique disponible'/></td></tr></table>\n";
?>
<br />


		<table>
		<tr>
			<td class="c" colspan="7">Classement de <a><?php echo $nom_player;?></a></td>
		</tr>
		<tr>
			<td class="c" width="175">Date</td>
			<td class="c" colspan="2">Pts Général</td>
			<td class="c" colspan="2">Pts Flotte</td>
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
echo "\t\t\t"."<th width='70' style='border-color:#FF0000'>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_pts"]-$first["research_pts"])*60*60*24/($last_date["research"]-$first_date["research"]),2))."</th>"."\n";
echo "\t\t\t"."<th width='40' style='border-color:#FF0000'><font color='lime'><i>".(($first["research_pts"] == -1 || $last_date["research"] == $first_date["research"]) ? "-" : round(($last["research_rank"]-$first["research_rank"])*60*60*24/($last_date["research"]-$first_date["research"]),2) * (-1))."</i></font></th>"."\n</tr>";
?>

</table>
</center>