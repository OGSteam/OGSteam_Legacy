<?php
/***************************************************************************
*	filename	: galaxy.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 09/12/2005
*	modified	: 28/11/2006 21:14:38
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$user_auth = user_get_auth($user_data["user_id"]);


$info_system = galaxy_show();
$population = $info_system["population"];

$galaxy = $info_system["galaxy"];
$system = $info_system["system"];

require_once("views/page_header.php");

// ajout ligne Axel / affichage portée missiles interplanétaires
$missiles_list = galaxy_get_interplanetary($galaxy, $system);

$galaxy_down = (($galaxy-1) < 1) ? 1 : $galaxy - 1;
$galaxy_up = (($galaxy-1) > $server_config["nb_galaxy"]) ? $server_config["nb_galaxy"] : $galaxy + 1;

$system_down = (($system-1) < 1) ? 1 : $system - 1;
$system_up = (($system-1) > $server_config["nb_system"]) ? $server_config["nb_system"] : $system + 1;

$favorites = galaxy_getfavorites();

?>

<table border="0">
<form>
<input name="action" value="galaxy" type="hidden">
<tr>
	<td>
		<table align="center">
			<tr>
			<td class="c" colspan="3"><?php echo $LANG["univers_Galaxy"];?></td>
			</tr>
			<tr>
				<td class="l"><input type="button" value="<<<" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy_down;?>&system=<?php echo $system;?>';"></td>
				<td class="l"><input type="text" name="galaxy" maxlength="2" size="5" value="<?php echo $galaxy;?>" tabindex="1"></th>
				<td class="l"><input type="button" value=">>>" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy_up;?>&system=<?php echo $system;?>';"></td>
			</tr>
		</table>
	</td>
	<td>
		<table align="center">
			<tr>
			<td class="c" colspan="3"><?php echo $LANG["search_SolarSystem"];?></td>
			</tr>
			<tr>
				<td class="l"><input type="button" value="<<<" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy;?>&system=<?php echo $system_down;?>';"></td>
				<td class="l"><input type="text" name="system" maxlength="3" size="5" value="<?php echo $system;?>" tabindex="2"></td>
				<td class="l"><input type="button" value=">>>" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy;?>&system=<?php echo $system_up;?>';"></td>
			</tr>
		</table>
	</td>
</tr>
<tr align="center">
<td colspan="3"><input type="submit" value="<?php echo $LANG["search_Show"];?>"></td>
</tr>
</form>
</table>
<table width="860">
<tr>
	<form method="POST" action="index.php?action=galaxy">
	<td colspan="3" align="left">
		<select name="coordinates" onchange="this.form.submit();" onkeyup="this.form.submit();">
		<option><?php echo $LANG["search_FavoritesList"];?></option>
<?php
foreach ($favorites as $v) {
	$coordinate = $v["galaxy"].":".$v["system"];
	echo "\t\t\t"."<option value='".$coordinate."'>".$coordinate."</option>";
}
?>
		</select>
	</td>
	</form>
	<td colspan="5" align="right">
<?php
if (sizeof($favorites) < $server_config['max_favorites'])
$string_addfavorites = "window.location = 'index.php?action=add_favorite&galaxy=".$galaxy."&system=".$system."';";
else
$string_addfavorites = "alert('".sprintf($LANG["message_MaxFavorites"],$server_config['max_favorites'])."')";

if (sizeof($favorites) > 0)
$string_delfavorites = "window.location = 'index.php?action=del_favorite&galaxy=".$galaxy."&system=".$system."';";
else
$string_delfavorites = "alert('".$LANG["search_NoFavorites"]."')";
?>
		<input type="button" value="<?php echo $LANG["search_AddFavorites"];?>" onclick="<?php echo $string_addfavorites;?>">
		<input type="button" value="<?php echo $LANG["search_DelFavorites"];?>" onclick="<?php echo $string_delfavorites;?>">
	</td>
</tr>
<tr>
<td class="c" colspan="8"><?php echo $LANG["search_SolarSystem"];?> </td>
</tr>
<tr>
	<td class="c" width="25">&nbsp;</td>
	<td class="c" width="175"><?php echo $LANG["univers_Planets"];?></td>
	<td class="c" width="175"><?php echo $LANG["univers_Players"];?></td>
	<td class="c" width="175"><?php echo $LANG["univers_Allys"];?></td>
	<td class="c" width="20">&nbsp;</td>
	<td class="c" width="20">&nbsp;</td>
	<td class="c" width="250"><?php echo $LANG["search_Update"];?></td>
	
	
</tr>
<?php
$i=1;
foreach ($population as $v) {
	$begin_hided = "";
	$end_hided = "";
	if ($v["hided"]) {
		$begin_hided = "<blink><font color='".$server_config["color_ally_hided"]."'>";
		$end_hided = "</font></blink>";
	}
	$begin_allied = "";
	$end_allied = "";
	if ($v["allied"]) {
		$begin_allied = "<font color='".$server_config["color_ally_friend"]."'>";
		$end_allied = "</font>";
	}

	$id = $i;
	$planet = $v["planet"];
	$ally = $v["ally"];
	$player = $v["player"];
	$status = $v["status"];
	$timestamp = $v["timestamp"];
	$poster = "&nbsp;";
	if ($timestamp != 0) {
		$timestamp = strftime("%d %b %Y %H:%M", $timestamp);
		$poster = $timestamp." - ".$v["poster"];
	}

	if ($planet == "") $planet = "&nbsp;";
	else 
	{
		if ($v["hided"] && $user_auth["server_show_positionhided"] == 1 || !$v["hided"]) $planet = "<a href='index.php?action=search&type_search=planet&string_search=".urlencode($planet)."&strict=on'>".$begin_allied.$begin_hided.$planet.$end_hided.$end_allied."</a>";
		else $planet = "&nbsp;";
	}
	if ($ally == "") $ally = "&nbsp;";
	
	else
	{
		if ($v["hided"] && $user_auth["server_show_positionhided"] == 1 || !$v["hided"])
		{
			$tooltip = "<table width=\"250\">";
			$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">".$LANG["univers_Ally"]." ".$ally."</td></tr>";
			
			$individual_ranking = galaxy_show_ranking_unique_ally($ally);
			while ($ranking = current($individual_ranking)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
				
				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".sprintf($LANG["search_StatFrom"],$datadate)."</td></tr>";
				$tooltip .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				break;
			}
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".urlencode($ally)."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
			$tooltip .= "</table>";
			$tooltip = addslashes(htmlentities($tooltip));
			
			$ally = "<a href='index.php?action=search&type_search=ally&string_search=".urlencode($ally)."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$begin_allied.$begin_hided.$ally.$end_hided.$end_allied."</a>";
		}
		else $ally = "&nbsp;";
	}

	if ($player == "") $player = "&nbsp;";
	{
		if ($v["hided"] && $user_auth["server_show_positionhided"] == 1 || !$v["hided"])
		{
			$tooltip = "<table width=\"250\">";
			$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">".$LANG["univers_Player"]." ".$player."</td></tr>";
			
			$individual_ranking = galaxy_show_ranking_unique_player($player);
			while ($ranking = current($individual_ranking)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
				
				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".sprintf($LANG["search_StatFrom"],$datadate)."</td></tr>";
				$tooltip .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				break;
			}
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".urlencode($player)."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
			$tooltip .= "</table>";
			$tooltip = addslashes(htmlentities($tooltip));
			
			$player = "<a href='index.php?action=search&type_search=player&string_search=".urlencode($player)."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$begin_allied.$begin_hided.$player.$end_hided.$end_allied."</a>";
		}
		else $player = "&nbsp;";
	}

	if ($status == "") $status = "&nbsp;";

	if ($v["report_spy"] > 0) $spy = "<A HREF='#' onClick=\"window.open('index.php?action=show_reportspy&galaxy=$galaxy&system=$system&row=$i','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">".$v["report_spy"]."E</A>";
	else $spy = "&nbsp;";


	echo "<tr>"."\n";
	echo "\t"."<th>".$id."</th>"."\n";
	echo "\t"."<th>".$planet."</th>"."\n";
	echo "\t"."<th>".$player."</th>"."\n";
	echo "\t"."<th>".$ally."</th>"."\n";
	echo "\t"."<th>".$status."</th>"."\n";
	echo "\t"."<th>".$spy."</th>"."\n";
	echo "\t"."<th>".$poster."</th>"."\n";
	echo "</tr>"."\n";

	$i++;
}
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\"e width=\"150\">".$LANG["search_Legend"]."</td></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_Inactive7Day"]."</td><th>i</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_Inactive28Day"]."</td><th>I</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_SpyReport"]."</td><th>xE</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_FriendAlly"]."</td><th><a><font color=\"".$server_config["color_ally_friend"]."\">abc</font></a></th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_HidenAlly"]."</td><th><blink><font color=\"".$server_config["color_ally_hided"]."\">abc</font></blink></th></tr>";
$legend .= "</table>";
$legend = addslashes(htmlentities($legend));

echo "<tr align='center'><td class='c' colspan='8'><a style='cursor:pointer' onmouseover=\"this.T_WIDTH=210;this.T_TEMP=0;return escape('".$legend."')\">Légende</a></td></tr>";
echo "</table>";

// portée des missiles interplanétaires - ajout Naqdazar
echo "<br><table width='860' border='1'>";
echo "<tr><td class='c' align='center'>".$LANG["galaxy_Planet_Launching_Coords"]."&nbsp;".help("galaxy_missiles")."</td></tr>";
if (sizeof($missiles_list) > 0) {
	foreach ($missiles_list as $value) {
		$range_down = $value["system"] - (2*$value["impulsion"]- 1);
		if ($range_down < 1) $range_down = 1;
		$range_up =  $value["system"] + (2*$value["impulsion"]- 1);
		if ($range_up > $server_config["nb_system"]) $range_up = $server_config["nb_system"];

		echo "<tr align='left'><th>";

		if ($value["ally"] != "") {
			$individual_ranking = galaxy_show_ranking_unique_ally($value["ally"]);
			$tooltip = "<table width=\"250\">";
			$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$value["ally"]."</td></tr>";
			while ($ranking = current($individual_ranking)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".$LANG["search_StatFrom"].$datadate."</td></tr>";
				$tooltip .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				break;
			}
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".$value["ally"]."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
			$tooltip .= "</table>";
			$tooltip = addslashes(htmlentities($tooltip));

			echo "[<a href='index.php?action=search&type_search=ally&string_search=".$value["ally"]."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$value["ally"]."</a>]"." ";
		}

		$individual_ranking = galaxy_show_ranking_unique_player($value["player"]);
		$tooltip = "<table width=\"250\">";
		$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Joueur ".$value["player"]."</td></tr>";
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".$LANG["search_StatFrom"].$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			break;
		}
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".$value["player"]."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
		$tooltip .= "</table>";
		$tooltip = addslashes(htmlentities($tooltip));
		echo "<a href=\"index.php?action=search&type_search=player&string_search=".$value["player"]."&strict=on\" onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$value["player"]."</a>".$LANG["galaxy_playerimpulsionlevel"].$value["impulsion"];
		echo " en <a href='index.php?action=galaxy&galaxy=".$value["galaxy"]."&system=".$value["system"]."'>".$value["galaxy"].":".$value["system"].":".$value["row"]."</a> [<font color='orange'>".$value["galaxy"].":".$range_down." <-> ".$value["galaxy"].":".$range_up."</font>]";

		if ($value["silo"] > "0") echo $LANG["galaxy_witha"]."<font color='red'>".$LANG["galaxy_silolevel"].$value["silo"]."</font>";
		echo ".</th></tr>";
	}
}
else echo "<tr><th>".$LANG["galaxy_noplanetcanlaunch"]."</th></tr>";
echo "</table>";


//Raccourci recherche
$tooltip_begin = "<table width=\"200\">";
$tooltip_end = "</table>";

$tooltip_colonization = $tooltip_away = $tooltip_spy = "";
for ($i=10 ; $i<=50 ; $i=$i+10) {
	if ($system - $i >= 1) $down = $system-$i;
	else $down = 1;

	if ($system + $i <= $server_config["nb_system"]) $up = $system+$i;
	else $up = $server_config["nb_system"];

	$tooltip_colonization .= "<tr><th><a href=\"index.php?action=search&type_search=colonization&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." ".$LANG["search_SystemAround"]."</a></th></tr>";
	$tooltip_away .= "<tr><th><a href=\"index.php?action=search&type_search=away&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." ".$LANG["search_SystemAround"]."</a></th></tr>";
	$tooltip_spy .= "<tr><th><a href=\"index.php?action=search&type_search=spy&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." ".$LANG["search_SystemAround"]."</a></th></tr>";
}

$tooltip_colonization = addslashes(htmlentities($tooltip_begin.$tooltip_colonization.$tooltip_end));
$tooltip_away = addslashes(htmlentities($tooltip_begin.$tooltip_away.$tooltip_end));
$tooltip_spy = addslashes(htmlentities($tooltip_begin.$tooltip_spy.$tooltip_end));

echo "<br /><table width='860' border='1'>";
echo "<tr><td class='c' align='center' colspan='3'>".$LANG["search_Research"]."</td></tr>";
echo "<tr align='center'>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_colonization."')\">".$LANG["search_Colonization"]."</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_away."')\">".$LANG["search_InactivePlayers"]."</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_spy."')\">".$LANG["search_SpyReport"]."</th>";
echo "</tr>";
echo "</table>";


require_once("views/page_tail.php");
?>
