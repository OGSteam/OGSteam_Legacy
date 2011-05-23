<?php
/**
* index.php 
 * @package QuiMobserve
 * @author Santory
 * @link http://www.ogsteam.fr
 * @version : 0.1d
 */

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//On vérifie que le mod est activé
$query = "SELECT `active` FROM `".TABLE_MOD."` WHERE `action`='QuiMobserve' AND `active`='1' LIMIT 1";
if (!$db->sql_numrows($db->sql_query($query))) die("Hacking attempt");

$info_planet = split(":", $pub_planete);
$galaxy = intval($info_planet[0]);
$system = intval($info_planet[1]);
$row = intval($info_planet[2]);


//protection des joueur
$ally_protection = $allied = array();
if ($server_config["ally_protection"] != "") $ally_protection = explode(",", $server_config["ally_protection"]);
if ($server_config["allied"] != "") $allied = explode(",", $server_config["allied"]);

$request = "FROM ".TABLE_UNIVERSE." WHERE `galaxy` = $galaxy AND `system` = $system AND `row` = $row";
if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
	foreach ($ally_protection as $v) {
		$request = " and ally <> '".mysql_real_escape_string($v)."'";
	}
}

$query = "SELECT `name`, `player`, `ally` ".$request;
$result=$db->sql_query($query);
if ($db->sql_numrows($result)){
	list($name,$player,$ally) = $db->sql_fetch_row($result);

	$name = ($name != '' )  ? $name : "Inconnu";
	$player2 = ($player != '' )  ? $player : "Inconnu";

	$hided = $friend = false;
	if (in_array($ally, $ally_protection)) $hided = true;
	if (in_array($ally, $allied)) $friend = true;

	$begin_hided = "";
	$end_hided = "";
	if ($hided) {
		$begin_hided = "<font color='lime'>";
		$end_hided = "</font>";
	}
	$begin_allied = "";
	$end_allied = "";
	if ($friend) {
		$begin_allied = "<blink>";
		$end_allied = "</blink>";
	}




	echo "<fieldset><legend><b><font color='#0080FF'>Information sur la planète ".$pub_planete."</font></b></legend>";	
	echo "<font size=\"2\">";
	echo "Nom de la planète : <b>".	$name."</b><br />\n";
	echo "Nom du joueur : <b>".$begin_allied.$begin_hided.$player2.$end_hided.$end_allied."</b><br />\n";
	echo "Nom de l'alliance : <b>".$begin_allied.$begin_hided.$player2.$end_hided.$end_allied."</b><br />\n";
	echo "</font>";	
	
	echo "</fieldset>"; 
	if($player != ''){
		$select = "select count(*)";
		$request = " from ".TABLE_UNIVERSE." left join ".TABLE_USER;
		$request .= " on last_update_user_id = user_id";
		$request .= " where player like '".mysql_real_escape_string($player)."'";
		if ($user_auth["server_show_positionhided"] != 1 && $user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1) {
			foreach ($ally_protection as $v) {
				$request .= " and ally <> '".mysql_real_escape_string($v)."'";
			}
		}
		$result = $db->sql_query($select.$request);
		list($total_row) = $db->sql_fetch_row($result);
	
		$select = "select galaxy, system, row, moon, phalanx, gate, last_update_moon, ally, player, status, last_update, user_name";
		$order = " order by galaxy, system, row";
		$request = $select.$request.$order;
		$result = $db->sql_query($request);
		$search_result = array();
		while ($row = $db->sql_fetch_assoc($result)) {
			$hided = $friend = false;
			if (in_array($row["ally"], $ally_protection)) $hided = true;
			if (in_array($row["ally"], $allied)) $friend = true;

			$request = "select * from ".TABLE_SPY." where active = '1' and spy_galaxy = ".$row["galaxy"]." and spy_system = ".$row["system"]." and spy_row = ".$row["row"];
			$result_2 = $db->sql_query($request);
			$report_spy = $db->sql_numrows($result_2);
			$search_result[] = array("galaxy" => $row["galaxy"], "system" => $row["system"], "row" => $row["row"], "phalanx" => $row["phalanx"], "gate" => $row["gate"], "last_update_moon" => $row["last_update_moon"], "moon" => $row["moon"], "ally" => $row["ally"], "player" => $row["player"], "report_spy" => $report_spy, "status" => $row["status"], "timestamp" => $row["last_update"], "poster" => $row["user_name"], "hided" => $hided, "allied" => $friend);
		}
		echo "<br /><fieldset><legend><b><font color='#0080FF'>Information sur le joueur ".$player."</font></b></legend>";			
		echo "<table>\n";
		echo '<tr>
			<td class="c" width="175">Coordonnées</td>
			<td class="c" width="175">Alliances</td>
			<td class="c" width="175">Joueurs</td>
			<td class="c" width="40">&nbsp;</td>
			<td class="c" width="20">&nbsp;</td>
			<td class="c" width="20">&nbsp;</td>
			<td class="c" width="200">&nbsp;</td>
		</tr>';
		foreach ($search_result as $v) {
			$begin_hided = "";
			$end_hided = "";
			if ($v["hided"]) {
				$begin_hided = "<font color='lime'>";
				$end_hided = "</font>";
			}
			$begin_allied = "";
			$end_allied = "";
			if ($v["allied"]) {
				$begin_allied = "<blink>";
				$end_allied = "</blink>";
			}
		
			$coordinates = $v["galaxy"].":".$v["system"].":".$v["row"];
			$coordinates = "<a href='index.php?action=galaxy&galaxy=".$v["galaxy"]."&system=".$v["system"]."'>".$coordinates."</a>";
		
			if ($v["ally"] == "") $ally = "&nbsp;";
			else {
				$tooltip[$v["ally"]] = "<table width=\"250\">";
				$tooltip[$v["ally"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$v["ally"]."</td></tr>";
				$individual_ranking_ally = galaxy_show_ranking_unique_ally($v["ally"]);
				while ($ranking = current($individual_ranking_ally)) {
					$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_ally));
					$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
					$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) . " <i>( ". formate_number($ranking["general"]["points_per_member"]) ." )</i>" : "&nbsp;";
					$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
					$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) . " <i>( ". formate_number($ranking["fleet"]["points_per_member"]) ." )</i>" : "&nbsp;";
					$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
					$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) . " <i>( ". formate_number($ranking["research"]["points_per_member"]) ." )</i>" : "&nbsp;";
		
					$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
					$tooltip[$v["ally"]] .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
					$tooltip[$v["ally"]] .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
					$tooltip[$v["ally"]] .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
					$tooltip[$v["ally"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".formate_number($ranking["number_member"])." membre(s)</td></tr>";
					break;
				}
				$tooltip[$v["ally"]] .= "</table>";
				$tooltip[$v["ally"]] = htmlentities($tooltip[$v["ally"]]);
		
				$ally = "<a href='#' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip[$v["ally"]]."')\">".$begin_allied.$begin_hided.$v["ally"].$end_hided.$end_allied."</a>";
			}
		
			if ($v["player"] == "") $player = "&nbsp;";
			else {
				if (!isset($tooltip[$v["player"]])) {
					$tooltip[$v["player"]] = "<table width=\"250\">";
					$tooltip[$v["player"]] .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Joueur ".$v["player"]."</td></tr>";
					$individual_ranking_player = galaxy_show_ranking_unique_player($v["player"]);
					while ($ranking = current($individual_ranking_player)) {
						$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking_player));
						$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
						$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
						$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
						$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
						$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
						$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) : "&nbsp;";
		
						$tooltip[$v["player"]] .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
						$tooltip[$v["player"]] .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
						$tooltip[$v["player"]] .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
						$tooltip[$v["player"]] .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_rank."</th></tr>";
						break;
					}
					$tooltip[$v["player"]] .= "</table>";
					$tooltip[$v["player"]] = htmlentities($tooltip[$v["player"]]);
				}
		
				$player = "<a href='#' onmouseover=\"this.T_WIDTH=260;return escape('".$tooltip[$v["player"]]."')\">".$begin_allied.$begin_hided.$v["player"].$end_hided.$end_allied."</a>";
			}
		
			if ($v["status"] == "") $status = " &nbsp;";
			else $status = $v["status"];
		
			if ($v["moon"] == 1) {
				$moon = "M";
				$detail = "";
				if ($v["last_update_moon"] > 0) {
					$detail .= $v["phalanx"];
				}
				if ($v["gate"] == 1) {
					$detail .= "P";
				}
				if ($detail != "") $moon .= " - ".$detail;
			}
			else $moon = "&nbsp;";
		
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
			echo "\t\t\t"."<th>".$ally."</th>"."\n";
			echo "\t\t\t"."<th>".$player."</th>"."\n";
			echo "\t\t\t"."<th>".$moon."</th>"."\n";
			echo "\t\t\t"."<th>".$status."</th>"."\n";
			echo "\t\t\t"."<th>".$report_spy."</th>"."\n";
			echo "\t\t\t"."<th>".$poster."</th>"."\n";
			echo "\t\t"."</tr>"."\n";
		}
		echo "\t\t"."<tr>";
		$legend = "<table width=\"225\">";
		$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\" width=\"150\">Légende</td></tr>";
		$legend .= "<tr><td class=\"c\">Inactif 7 jours</td><th>i</th></tr>";
		$legend .= "<tr><td class=\"c\">Inactif 28 jours</td><th>I</th></tr>";
		$legend .= "<tr><td class=\"c\">Joueur faible</td><th>d</th></tr>";
		$legend .= "<tr><td class=\"c\">Lune<br><i>phalange 4 avec porte spatial</i></td><th>M - 4P</th></tr>";
		$legend .= "<tr><td class=\"c\">Rapport d\'espionnage</td><th>xE</th></tr>";
		$legend .= "<tr><td class=\"c\">Joueur / Alliance allié</td><th><a>abc</a></th></tr>";
		$legend .= "<tr><td class=\"c\">Joueur / Alliance masqué</td><th><blink><font color=\"lime\">abc</font></blink></th></tr>";
		$legend .= "</table>";
		$legend = htmlentities($legend);
		echo "<tr align='center'><td class='c' colspan='7'><a href='#' onmouseover=\"this.T_WIDTH=210;this.T_TEMP=0;return escape('".$legend."')\">Légende</a></td></tr>";		
		echo "</table>";
		echo '<script language="JavaScript" src="js/wz_tooltip.js"></script>';
		echo "</fieldset>"; 
	}
}else{
	echo "<fieldset><legend><b><font color='#0080FF'>Information sur la planete ".$pub_planete."</font></b></legend>";	
	echo "<font size=\"2\">";
	echo "Aucune information disponible pour cette planète.";
	echo "</font>";	
	
	echo "</fieldset>"; 
}
?>