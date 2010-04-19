<?php
/***************************************************************************
*	filename	: search.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 08/12/2005
*	modified	: 28/11/2006 22:36:18
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

$search_result = array();
list($search_result, $total_page) = galaxy_search();
$user_auth = user_get_auth($user_data["user_id"]);

@$string_search = $pub_string_search;
@$type_search = $pub_type_search;
@$strict = $pub_strict;
@$sort = $pub_sort;
@$sort2 = $pub_sort2;
@$galaxy_down = $pub_galaxy_down;
@$galaxy_up = $pub_galaxy_up;
@$system_down = $pub_system_down;
@$system_up = $pub_system_up;
@$row_down = $pub_row_down;
@$row_up = $pub_row_up;
@$row_active = $pub_row_active;
@$page = $pub_page;

$link_order_coordinates = "";
$link_order_ally = "";
$link_order_player = "";
$end_link = "";

$individual_ranking_player = array();
$individual_ranking_ally = array();

$strict_on = "";
if ($search_result) {

	if (isset($strict)) $strict_on = "&strict";
	$new_sort2 = 0;
	if (isset($sort2)) {
		if ($sort2 == 0) $new_sort2 = 1;
		else $new_sort2 = 0;
	}

	if ($type_search != "colonization") {
		$link_order_coordinates = "<a href='index.php?action=search&sort=1&sort2=".$new_sort2."&type_search=".$type_search."&page=".$page."&string_search=".$string_search.$strict_on."'>".$LANG["univers_Coordinates"];
		$link_order_ally = "<a href='index.php?action=search&sort=2&sort2=".$new_sort2."&type_search=".$type_search."&page=".$page."&string_search=".$string_search.$strict_on."'>".$LANG["univers_Allys"] ;
		$link_order_player = "<a href='index.php?action=search&sort=3&sort2=".$new_sort2."&type_search=".$type_search."&page=".$page."&string_search=".$string_search.$strict_on."'>".$LANG["univers_Players"];

		if ($sort2 == 0) {
			switch ($sort) {
				case "1" : $link_order_coordinates = "<img src='images/asc.png'>&nbsp;".$link_order_coordinates."&nbsp;<img src='images/asc.png'>";break;
				case "2" : $link_order_ally = "<img src='images/asc.png'>&nbsp;".$link_order_ally."&nbsp;<img src='images/asc.png'>";break;
				case "3" : $link_order_player = "<img src='images/asc.png'>&nbsp;".$link_order_player."&nbsp;<img src='images/asc.png'>";break;
			}
		}
		else {
			switch ($sort) {
				case "1" : $link_order_coordinates = "<img src='images/desc.png'>&nbsp;".$link_order_coordinates."&nbsp;<img src='images/desc.png'>";break;
				case "2" : $link_order_ally = "<img src='images/desc.png'>&nbsp;".$link_order_ally."&nbsp;<img src='images/desc.png'>";break;
				case "3" : $link_order_player = "<img src='images/desc.png'>&nbsp;".$link_order_player."&nbsp;<img src='images/desc.png'>";break;
			}
		}

		$link_order_coordinates .= "</a>";
		$link_order_ally .= "</a>";
		$link_order_player .= "</a>";
	}
}


//Données recherches joueurs
if (!isset($string_search)) {
	$string_search = "";
}
if (!isset($type_search) && !isset($strict) || isset($strict)) {
	$strict = " checked";
}
else {
	$strict = "";
}
$type_player = " checked";
$type_ally = "";
$type_planet = "";
if (isset($type_search)) {
	switch ($type_search) {
		case "player":
		$type_player = " checked";
		break;
		case "ally":
		$type_ally = " checked";
		break;
		case "planet":
		$type_planet = " checked";
		break;
	}
}

//Données recherche coordonnées colonisables
$galaxy_down = isset($galaxy_down) ? $galaxy_down : "";
$galaxy_up = isset($galaxy_up) ? $galaxy_up : "";
$system_down = isset($system_down) ? $system_down : "";
$system_up = isset($system_up) ? $system_up : "";
$row_down = isset($row_down) ? $row_down : "";
$row_up = isset($row_up) ? $row_up : "";
$row_active = isset($row_active) ? " checked" : "";

require_once("views/page_header.php");
$resultat = ratio_calc($user_data["user_id"]);
$ratio = $resultat[0];
if (!ratio_is_unlimited() && $ratio < 0) {
    echo ($LANG["your_ratio_is"].'<font color="red">'.formate_number($ratio).'</font>'.$LANG["can_t_search"]);
}
else{
?>

<table>
<tr>
	<td width="400" valign="top">
		<table width="100%">
		<form method="POSt" action="index.php">
		<input type="hidden" name="action" value="search">
		<tr>
			<td class="c" colspan="3">Recherche globale</td>
		</tr>
		<tr>
			<th><input name="type_search" value="player" type="radio"<?php echo $type_player;?>></th>
			<th><?php echo $LANG["univers_Players"];?></th>
			<th rowspan="3"><input name="string_search" type="text" maxlength="25" size="25" value="<?php echo $string_search;?>"></th>
		</tr>
		<tr>
			<th><input name="type_search" value="ally" type="radio"<?php echo $type_ally;?>></th>
			<th><?php echo $LANG["univers_Allys"];?></th>
		</tr>
		<tr>
			<th><input name="type_search" value="planet" type="radio"<?php echo $type_planet;?>></th>
			<th><?php echo $LANG["univers_Planets"];?></th>
		</tr>
		<tr>
			<th><input name="strict" value="true" type="checkbox"<?php echo $strict;?>></th>
			<th colspan="2"><? echo $LANG["search_OptionStrict"];?>&nbsp;<?php echo help("search_strict");?></th>
		</tr>
		<tr>
		<th colspan="3"><input type="submit" value="<?php echo $LANG["search_Search"];?>"></th>
		</tr>
		</form>
		</table>
	</td>
	<td width="400" valign="top">
		<table width="100%">
		<form method="POST" action="index.php">
		<input type="hidden" name="action" value="search">
		<tr>
		<td class="c" colspan="4"><?php echo $LANG["search_SpecialSearch"];?></td>
		</tr>
		<tr>
			<th colspan="2">
				<select name="type_search">
<?php
if (isset($type_search) && $type_search == "colonization") echo "\t\t\t\t\t"."<option value='colonization' selected>".$LANG["search_Colonization"]."</option>";
else echo "\t\t\t\t\t"."<option value='colonization'>".$LANG["search_Colonization"]."</option>";
if (isset($type_search) && $type_search == "away") echo "\t\t\t\t\t"."<option value='away' selected>".$LANG["search_Away"]."</option>";
else echo "\t\t\t\t\t"."<option value='away'>".$LANG["search_Away"]."</option>";
if (isset($type_search) && $type_search == "spy") echo "\t\t\t\t\t"."<option value='spy' selected>".$LANG["search_Spyed"]."</option>";
else echo "\t\t\t\t\t"."<option value='spy'>".$LANG["search_Spyed"]."</option>";
?>
				</select>
				</th>
				<th><?php echo $LANG["search_Minimum"];?></th>
			<th>Maximum</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th><?php echo $LANG["search_Maximum"];?></th>
			<th><input name="galaxy_down" type="text" maxlength="<?php echo strlen($server_config["nb_galaxy"]);?>" size="3" value="<?php echo $galaxy_down;?>"></th>
			<th><input name="galaxy_up" type="text" maxlength="<?php echo strlen($server_config["nb_galaxy"]);?>" size="3" value="<?php echo $galaxy_up;?>"></th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th><?php echo $LANG["search_SolarSystem"];?></th>
			<th><input name="system_down" type="text" maxlength="<?php echo strlen($server_config["nb_system"]);?>" size="3" value="<?php echo $system_down;?>"></th>
			<th><input name="system_up" type="text" maxlength="<?php echo strlen($server_config["nb_system"]);?>" size="3" value="<?php echo $system_up;?>"></th>
		</tr>
		<tr>
			<th><input name="row_active" type="checkbox"<?php echo $row_active;?>></th>
			<th>Rang</th>
			<th><input name="row_down" type="text" maxlength="<?php echo strlen($server_config["nb_row"]);?>" size="3" value="<?php echo $row_down;?>"></th>
			<th><input name="row_up" type="text" maxlength="<?php echo strlen($server_config["nb_row"]);?>" size="3" value="<?php echo $row_up;?>"></th>
		</tr>
		<tr>
		<th colspan="4"><input type="submit" value="<?php echo $LANG["search_Search"];?>"></th>
		</tr>
		</form>
		</table>
	</td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
	<td colspan="3" align="center">
		<table>
<?php
echo "\t\t"."<tr>";

echo "\t\t\t"."<td colspan='3' align='left' width='50%'>"."\n";
if ($total_page > 1) {
	if ($type_search == "planet" || $type_search == "ally" || $type_search == "player") {
		$option = "&string_search=".urlencode($string_search);
		if ($strict_on != "") $option .= "&strict=on";
	}
	if ($type_search == "colonization" || $type_search == "away" || $type_search == "spy") {
		$option = "&galaxy_down=".$galaxy_down;
		$option .= "&galaxy_up=".$galaxy_up;
		$option .= "&system_down=".$system_down;
		$option .= "&system_up=".$system_up;
		$option .= "&row_down=".$row_down;
		$option .= "&row_up=".$row_up;
		if ($row_active != "") $option .= "&row_active=on";
	}

	echo "\t\t\t"."<input type='button' value='<<' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=1".$option."';\">&nbsp;";
	echo "<input type='button' value='<' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($page-1).$option."';\">&nbsp;";

	echo "<input type='button' value='>' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($page+1).$option."';\">&nbsp;";
	echo "<input type='button' value='>>' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($total_page).$option."';\">"."\n";
}
echo "\t\t\t"."</td>"."\n";

echo "\t\t\t"."<form method='GET' action='index.php'>"."\n";
echo "\t\t\t"."<td colspan='4' align='right' width='50%'>"."\n";
echo "\t\t\t"."<input type='hidden' name='type_search' value='".$type_search."'>"."\n";
echo "\t\t\t"."<input type='hidden' name='action' value='search'>"."\n";
if (isset($sort) && isset($sort2)) {
	echo "\t\t\t"."<input type='hidden' name='sort' value='".$sort."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='sort2' value='".$sort2."'>"."\n";
}
if ($type_search == "planet" || $type_search == "ally" || $type_search == "player") {
	echo "\t\t\t"."<input type='hidden' name='string_search' value='".urlencode($string_search)."'>"."\n";
	if ($strict_on != "") echo "\t\t\t"."<input type='hidden' name='strict'>";
}
if ($type_search == "colonization" || $type_search == "away" || $type_search == "spy") {
	echo "\t\t\t"."<input type='hidden' name='galaxy_down' value='".$galaxy_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_up' value='".$galaxy_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_down' value='".$system_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_up' value='".$system_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_down' value='".$row_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_up' value='".$row_up."'>"."\n";
	if ($row_active != "") echo "\t\t\t"."<input type='hidden' name='row_active' value='on'>";
}

if ($total_page > 1) {
	echo "\t\t\t"."<select name='page' onchange='this.form.submit();' onkeyup='this.form.submit();'>"."\n";
	for ($i=1 ; $i<=$total_page ; $i++) {
		$selected = "";
		if ($i == $page) $selected = "selected";
		echo "\t\t\t"."<option value='".$i."' ".$selected.">Page ".$i."</option>"."\n";
	}
	echo "\t\t\t"."</select>";
}

echo "\t\t\t"."</td>"."\n";
echo "\t\t\t"."</form>"."\n";

echo "\t\t"."</tr>";
?>
		<tr>
			<td class="c" width="175"><?php echo $link_order_coordinates;?></td>
			<td class="c" width="175"><?php echo $link_order_player;?></td>
			<td class="c" width="175"><?php echo $link_order_ally;?></td>
			<!--<td class="c" width="40">&nbsp;</td>-->
			<td class="c" width="20">&nbsp;</td>
			<td class="c" width="20">&nbsp;</td>
			<td class="c" width="200"><?php echo $LANG["search_Update"];?></td>
		</tr>
<?php
foreach ($search_result as $v) {
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
	
	if ($v["hided"] && $user_auth["server_show_positionhided"] == 1 || !$v["hided"]) 
	{
		$coordinates = $v["galaxy"].":".$v["system"].":".$v["row"];
		$coordinates = "<a href='index.php?action=galaxy&galaxy=".$v["galaxy"]."&system=".$v["system"]."'>".$coordinates."</a>";
	}
	else $coordinates = "";
	
	if ($v["ally"] == "") $ally = "&nbsp;";
	else
	{
		if ($v["hided"] && $user_auth["server_show_positionhided"] == 1 || !$v["hided"])
		{
			$tooltip[$v["ally"]] = "<table width=\"250\">";
			$tooltip[$v["ally"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$v["ally"]."</td></tr>";
			$individual_ranking_ally = galaxy_show_ranking_unique_ally($v["ally"]);
			while ($ranking = current($individual_ranking_ally)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_ally));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
				
				$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".sprintf($LANG["search_StatFrom"],$datadate)."</td></tr>";
				$tooltip[$v["ally"]] .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip[$v["ally"]] .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip[$v["ally"]] .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				break;
			}
			$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".urlencode($v["ally"])."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
			$tooltip[$v["ally"]] .= "</table>";
			$tooltip[$v["ally"]] = htmlentities($tooltip[$v["ally"]]);
			
			$ally = "<a href='index.php?action=search&type_search=ally&string_search=".urlencode($v["ally"])."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip[$v["ally"]]."')\">".$begin_allied.$begin_hided.$v["ally"].$end_hided.$end_allied."</a>";
		}
		else $ally = "";
	}

	if ($v["player"] == "") $player = "&nbsp;";
	else {
		if (!isset($tooltip[$v["player"]])) {
			$tooltip[$v["player"]] = "<table width=\"250\">";
			$tooltip[$v["player"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">".$LANG["univers_Player"]." ".$v["player"]."</td></tr>";
			$individual_ranking_player = galaxy_show_ranking_unique_player($v["player"]);
			while ($ranking = current($individual_ranking_player)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_player));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

				$tooltip[$v["player"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".sprintf($LANG["search_StatFrom"],$datadate)."</td></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\" width=\"75\">".$LANG["search_General"]."</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\">".$LANG["search_Flotte"]."</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip[$v["player"]] .= "<tr><td class=\"c\">".$LANG["search_Research"]."</td><th>".$research_rank."</th><th>".$research_rank."</th></tr>";
				break;
			}
			$tooltip[$v["player"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".urlencode($v["player"])."&strict=on\">".$LANG["search_DetailsView"]."</a></td></tr>";
			$tooltip[$v["player"]] .= "</table>";
			$tooltip[$v["player"]] = htmlentities($tooltip[$v["player"]]);
		}

		$player = "<a href='index.php?action=search&type_search=player&string_search=".urlencode($v["player"])."'&strict=on onmouseover=\"this.T_WIDTH=260;return escape('".$tooltip[$v["player"]]."')\">".$begin_allied.$begin_hided.$v["player"].$end_hided.$end_allied."</a>";
	}

	if ($v["status"] == "") $status = " &nbsp;";
	else $status = $v["status"];

	if ($v["report_spy"] > 0) $report_spy = "<A HREF=\"#\" onClick=\"window.open('index.php?action=show_reportspy&galaxy=".$v["galaxy"]."&system=".$v["system"]."&row=".$v["row"]."','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">".$v["report_spy"]."E</A>";
	else $report_spy = "&nbsp;";

	$timestamp = $v["timestamp"];

	$poster = "&nbsp;";
	if ($timestamp != 0) {
		$timestamp = strftime("%d %b %Y %H:%M", $timestamp);
		$poster = $timestamp." - ".$v["poster"];
	}

	echo "\t\t"."<tr>"."\n";
	echo "\t\t\t"."<th>".$coordinates."</th>"."\n";
	echo "\t\t\t"."<th>".$player."</th>"."\n";
	echo "\t\t\t"."<th>".$ally."</th>"."\n";
	echo "\t\t\t"."<th>".$status."</th>"."\n";
	echo "\t\t\t"."<th>".$report_spy."</th>"."\n";
	echo "\t\t\t"."<th>".$poster."</th>"."\n";
	echo "\t\t"."</tr>"."\n";
}
echo "\t\t"."<tr>";
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\"e width=\"150\">".$LANG["search_Legend"]."</td></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_Inactive7Day"]."</td><th>i</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_Inactive28Day"]."</td><th>I</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_SpyReport"]."</td><th>xE</th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_FriendAlly"]."</td><th><a><font color=\"".$server_config["color_ally_friend"]."\">abc</font></a></th></tr>";
$legend .= "<tr><td class=\"c\">".$LANG["search_HidenAlly"]."</td><th><blink><font color=\"".$server_config["color_ally_hided"]."\">abc</font></blink></th></tr>";
$legend .= "</table>";
$legend = addslashes(htmlentities($legend));
echo "<tr align='center'><td class='c' colspan='7'><a href='' onmouseover=\"this.T_WIDTH=210;this.T_TEMP=0;return escape('".$legend."')\">".$LANG["search_Legend"]."</a></td></tr>";

echo "\t\t\t"."<td colspan='3' align='left' width='50%'>"."\n";
if ($total_page > 1) {
	if ($type_search == "planet" || $type_search == "ally" || $type_search == "player") {
		$option = "&string_search=".$string_search;
		if ($strict_on != "") $option .= "&strict=on";
	}
	if ($type_search == "colonization" || $type_search == "away" || $type_search == "spy") {
		$option = "&galaxy_down=".$galaxy_down;
		$option .= "&galaxy_up=".$galaxy_up;
		$option .= "&system_down=".$system_down;
		$option .= "&system_up=".$system_up;
		$option .= "&row_down=".$row_down;
		$option .= "&row_up=".$row_up;
		if ($row_active != "") $option .= "&row_active=on";
	}

	echo "\t\t\t"."<input type='button' value='<<' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=1".$option."';\">&nbsp;";
	echo "<input type='button' value='<' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($page-1).$option."';\">&nbsp;";

	echo "<input type='button' value='>' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($page+1).$option."';\">&nbsp;";
	echo "<input type='button' value='>>' onclick=\"window.location = 'index.php?action=search&sort=".$sort."&sort2=".$sort2."&type_search=".$type_search."&page=".($total_page).$option."';\">"."\n";
}
echo "\t\t\t"."</td>"."\n";

echo "\t\t\t"."<form method='GET' action='index.php'>"."\n";
echo "\t\t\t"."<td colspan='4' align='right' width='50%'>"."\n";
echo "\t\t\t"."<input type='hidden' name='type_search' value='".$type_search."'>"."\n";
echo "\t\t\t"."<input type='hidden' name='action' value='search'>"."\n";
if (isset($sort) && isset($sort2)) {
	echo "\t\t\t"."<input type='hidden' name='sort' value='".$sort."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='sort2' value='".$sort2."'>"."\n";
}
if ($type_search == "planet" || $type_search == "ally" || $type_search == "player") {
	echo "\t\t\t"."<input type='hidden' name='string_search' value='".$string_search."'>"."\n";
	if ($strict_on != "") echo "\t\t\t"."<input type='hidden' name='strict'>";
}
if ($type_search == "colonization" || $type_search == "away" || $type_search == "spy") {
	echo "\t\t\t"."<input type='hidden' name='galaxy_down' value='".$galaxy_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='galaxy_up' value='".$galaxy_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_down' value='".$system_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='system_up' value='".$system_up."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_down' value='".$row_down."'>"."\n";
	echo "\t\t\t"."<input type='hidden' name='row_up' value='".$row_up."'>"."\n";
}
if ($total_page > 1) {
	echo "\t\t\t"."<select name='page' onchange='this.form.submit();' onkeyup='this.form.submit();'>"."\n";
	for ($i=1 ; $i<=$total_page ; $i++) {
		$selected = "";
		if ($i == $page) $selected = "selected";
		echo "\t\t\t"."<option value='".$i."' ".$selected.">Page ".$i."</option>"."\n";
	}
	echo "\t\t\t"."</select>";
}
echo "\t\t\t"."</td>"."\n";
echo "\t\t\t"."</form>"."\n";

echo "\t\t"."</tr>";

?>
		</table>
	</td>
</tr>
<tr><td colspan="3">&nbsp;</td></tr>
<tr>
	<td colspan="3" align="center">
		<table>
		<tr>
			<td class="c" colspan="8"><? echo sprintf($LANG["search_StatsFor"], $string_search);?></a></td>
		</tr>
		<tr>
			<td class="c">Date</td>
			<td class="c" colspan="2"><?php echo $LANG["search_GeneralPoints"];?></td>
			<td class="c" colspan="2"><?php echo $LANG["search_FlottePoints"];?></td>
			<td class="c" colspan="2"><?php echo $LANG["search_ResearchPoints"];?></td>
			<?php if ($type_search == "ally") echo '<td class="c">'.$LANG["search_MemberCount"].'</td>';?>
		</tr>
<?php
if ($type_search == "ally") $individual_ranking = galaxy_show_ranking_unique_ally($string_search);
else $individual_ranking = galaxy_show_ranking_unique_player($string_search);
while ($ranking = current($individual_ranking)) {
	$datadate = strftime("%d %b %Y %H:%M", key($individual_ranking));
	$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
	$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
	$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
	$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
	$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
	$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";

	echo "\t\t"."<tr>"."\n";
	echo "\t\t\t"."<th width='150'>".$datadate."</th>"."\n";
	echo "\t\t\t"."<th width='70'>".$general_points."</th>"."\n";
	echo "\t\t\t"."<th width='40'><font color='lime'><i>".$general_rank."</i></font></th>"."\n";
	echo "\t\t\t"."<th width='70'>".$fleet_points."</th>"."\n";
	echo "\t\t\t"."<th width='40'><font color='lime'><i>".$fleet_rank."</i></font></th>"."\n";
	echo "\t\t\t"."<th width='70'>".$research_points."</th>"."\n";
	echo "\t\t\t"."<th width='40'><font color='lime'><i>".$research_rank."</i></font></th>"."\n";
	if ($type_search == "ally") echo "<th width='70'>".formate_number($ranking["number_member"])."</th>";

	next($individual_ranking);
}
?>
		</table>
	</td>
</tr>
</table>

<?php
}
require_once("views/page_tail.php");
?>
