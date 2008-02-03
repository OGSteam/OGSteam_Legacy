<?php
/***************************************************************************
*	filename	: galaxy.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 09/12/2005
*	modified	: 03/04/2007 01:26:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

$info_system = galaxy_show(intval($server_config['num_of_galaxies']),intval($server_config['num_of_systems']));
$population = $info_system["population"];

$galaxy = $info_system["galaxy"];
$system = $info_system["system"];

$phalanx_list = galaxy_get_phalanx($galaxy, $system);

$galaxy_down = (($galaxy-1) < 1) ? 1 : $galaxy - 1;
$galaxy_up = (($galaxy-1) > intval($server_config['num_of_galaxies'])) ? intval($server_config['num_of_galaxies']) : $galaxy + 1;

$system_down = (($system-1) < 1) ? 1 : $system - 1;
$system_up = (($system-1) > intval($server_config['num_of_systems'])) ? intval($server_config['num_of_systems']) : $system + 1;

$favorites = galaxy_getfavorites();

require_once("views/page_header.php");
?>

<table border="0">
<form>
<input name="action" value="galaxy" type="hidden">
<tr>
	<td>
		<table align="center">
			<tr>
				<td class="c" colspan="3">Galaxie</td>
			</tr>
			<tr>
				<td class="l"><input type="button" value="<<<" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy_down;?>&system=<?php echo $system;?>';"></td>
				<td class="l"><input type="text" name="galaxy" maxlength="3" size="5" value="<?php echo $galaxy;?>" tabindex="1"></th>
				<td class="l"><input type="button" value=">>>" onclick="window.location = 'index.php?action=galaxy&galaxy=<?php echo $galaxy_up;?>&system=<?php echo $system;?>';"></td>
			</tr>
		</table>
	</td>
	<td>
		<table align="center">
			<tr>
				<td class="c" colspan="3">Système solaire</td>
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
	<td colspan="3"><input type="submit" value="Afficher"></td>
</tr>
</form>
</table>
<table width="860">
<tr>
	<form method="POST" action="index.php?action=galaxy">
	<td colspan="3" align="left">
		<select name="coordinates" onchange="this.form.submit();" onkeyup="this.form.submit();">
			<option>Liste des systèmes favoris</option>
<?php
foreach ($favorites as $v) {
	$coordinate = $v["galaxy"].":".$v["system"];
	echo "\t\t\t"."<option value='".$coordinate."'>".$coordinate."</option>";
}
?>
		</select>
	</td>
	</form>
	<td colspan="6" align="right">
<?php
if (sizeof($favorites) < $server_config['max_favorites'])
$string_addfavorites = "window.location = 'index.php?action=add_favorite&galaxy=".$galaxy."&system=".$system."';";
else
$string_addfavorites = "alert('Vous avez atteint le nombre maximal de favoris permis (".$server_config['max_favorites'].")')";

if (sizeof($favorites) > 0)
$string_delfavorites = "window.location = 'index.php?action=del_favorite&galaxy=".$galaxy."&system=".$system."';";
else
$string_delfavorites = "alert('Vous n\'avez pas de favoris')";
?>
		<input type="button" value="Ajouter aux favoris" onclick="<?php echo $string_addfavorites;?>">
		<input type="button" value="Supprimer des favoris" onclick="<?php echo $string_delfavorites;?>">
	</td>
</tr>
<tr>
	<td class="c" colspan="9">Système solaire </td>
</tr>
<tr>
	<td class="c" width="25">&nbsp;</td>
	<td class="c" width="175">Planètes</td>
	<td class="c" width="175">Alliances</td>
	<td class="c" width="175">Joueurs</td>
	<td class="c" width="40">&nbsp;</td>
	<td class="c" width="20">&nbsp;</td>
	<td class="c" width="20">&nbsp;</td>
	<td class="c" width="20">&nbsp;</td>
	<td class="c" width="250">Mises à jour</td>
</tr>
<?php
$i=1;
foreach ($population as $v) {
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

	$id = $i;
	$planet = $v["planet"];
	$ally = $v["ally"];
	$player = $v["player"];
	$moon = $v["moon"];
	$last_update_moon = $v["last_update_moon"];
	$phalanx = $v["phalanx"];
	$gate = $v["gate"] == 1;
	$status = $v["status"];
	$timestamp = $v["timestamp"];
	$poster = "&nbsp;";
	if ($timestamp != 0) {
		$timestamp = strftime("%d %b %Y %H:%M", $timestamp);
		$poster = $timestamp." - ".$v["poster"];
	}

	if ($planet == "") $planet = "&nbsp;";
	else $planet = "<a href='index.php?action=search&type_search=planet&string_search=".$planet."&strict=on'>".$begin_allied.$begin_hided.$planet.$end_hided.$end_allied."</a>";

	if ($ally == "") $ally = "&nbsp;";
	else {
		$tooltip = "<table width=\"250\">";
		$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$ally."</td></tr>";

		$individual_ranking = galaxy_show_ranking_unique_ally($ally);
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) . " <i>( ". formate_number($ranking["general"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) . " <i>( ". formate_number($ranking["fleet"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
			$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) . " <i>( ". formate_number($ranking["research"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$mines_rank = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["rank"]) : "&nbsp;";
			$mines_points = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["points"]) . " <i>( ". formate_number($ranking["mines"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$recherches_rank = isset($ranking["recherches"]) ?  formate_number($ranking["recherches"]["rank"]) : "&nbsp;";
			$recherches_points = isset($ranking["recherches"]) ?  formate_number($ranking["recherches"]["points"]) . " <i>( ". formate_number($ranking["recherches"]["points_per_member"]) ." )</i>" : "&nbsp;";
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".formate_number($ranking["number_member"])." membre(s)</td></tr>";
			break;
		}
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".$ally."&strict=on\">Voir détail</a></td></tr>";
		$tooltip .= "</table>";
		$tooltip = htmlentities($tooltip);

		$ally = "<a href='index.php?action=search&type_search=ally&string_search=".$ally."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$begin_allied.$begin_hided.$ally.$end_hided.$end_allied."</a>";
	}

	if ($player == "") $player = "&nbsp;";
	else {
		$tooltip = "<table width=\"250\">";
		$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Joueur ".$player."</td></tr>";

		$individual_ranking = galaxy_show_ranking_unique_player($player);
		while ($ranking = current($individual_ranking)) {
			$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
			$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
			$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) : "&nbsp;";
			$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
			$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) : "&nbsp;";
			$defenses_rank = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["rank"]) : "&nbsp;";
			$defenses_points = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["points"]) : "&nbsp;";

			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Mines</td><th>".$mines_rank."</th><th>".$mines_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Défenses</td><th>".$defenses_rank."</th><th>".$defenses_points."</th></tr>";		
			break;
		}
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".$player."&strict=on\">Voir détail</a></td></tr>";
		$tooltip .= "</table>";
		$tooltip = htmlentities($tooltip);

		$player = "<a href='index.php?action=search&type_search=player&string_search=".$player."&strict=on' onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$begin_allied.$begin_hided.$player.$end_hided.$end_allied."</a>";
	}

	if ($status == "") $status = "&nbsp;";

	if ($moon == 1) {
		$moon = "M";
		$detail = "";
		if ($last_update_moon > 0) {
			$detail .= $phalanx;
		}
		if ($gate == 1) {
			$detail .= "P";
		}
		if ($detail != "") $moon .= " - ".$detail;
	}
	else $moon = "&nbsp;";

	if ($v["report_spy"] > 0) $spy = "<A HREF='#' onClick=\"window.open('index.php?action=show_reportspy&galaxy=$galaxy&system=$system&row=$i','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">".$v["report_spy"]."E</A>";
	else $spy = "&nbsp;";

	if ($v["report_rc"] > 0) $rc = "<A HREF='#' onClick=\"window.open('index.php?action=show_reportrc&galaxy=$galaxy&system=$system&row=$i','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)\">".$v["report_rc"]." RC</A>";
	else $rc = "&nbsp;";

	echo "<tr>"."\n";
	echo "\t"."<th>".$id."</th>"."\n";
	echo "\t"."<th>".$planet."</th>"."\n";
	echo "\t"."<th>".$ally."</th>"."\n";
	echo "\t"."<th>".$player."</th>"."\n";
	echo "\t"."<th>".$moon."</th>"."\n";
	echo "\t"."<th>".$status."</th>"."\n";
	echo "\t"."<th>".$spy."</th>"."\n";
	echo "\t"."<th>".$rc."</th>"."\n";
	echo "\t"."<th>".$poster."</th>"."\n";
	echo "</tr>"."\n";

	$i++;
}
$legend = "<table width=\"225\">";
$legend .= "<tr><td class=\"c\" colspan=\"2\" align=\"center\"e width=\"150\">Légende</td></tr>";
$legend .= "<tr><td class=\"c\">Inactif 7 jours</td><th>i</th></tr>";
$legend .= "<tr><td class=\"c\">Inactif 28 jours</td><th>I</th></tr>";
$legend .= "<tr><td class=\"c\">Mode vacance</td><th>v</th></tr>";
$legend .= "<tr><td class=\"c\">Joueur faible</td><th>d</th></tr>";
$legend .= "<tr><td class=\"c\">Lune<br><i>phalange 4 avec porte spatial</i></td><th>M - 4P</th></tr>";
$legend .= "<tr><td class=\"c\">Rapport d\'espionnage</td><th>xE</th></tr>";
$legend .= "<tr><td class=\"c\">Joueur / Alliance allié</td><th><blink><a>abc</a></blink></th></tr>";
$legend .= "<tr><td class=\"c\">Joueur / Alliance masqué</td><th><font color=\"lime\">abc</font></th></tr>";
$legend .= "</table>";
$legend = htmlentities($legend);

echo "<tr align='center'><td class='c' colspan='9'><a style='cursor:pointer' onmouseover=\"this.T_WIDTH=210;this.T_TEMP=0;return escape('".$legend."')\">Légende</a></td></tr>";
echo "</table>";


//Phalange
echo "<br><table width='860' border='1'>";
echo "<tr><td class='c' align='center'>Liste des phalanges hostiles dans le secteur&nbsp;".help("galaxy_phalanx")."</td></tr>";
if (sizeof($phalanx_list) > 0) {
	foreach ($phalanx_list as $value) {
		$range_down = $value["system"] - (pow($value["phalanx"], 2) - 1);
		if ($range_down < 1) $range_down = 1;
		$range_up =  $value["system"] + (pow($value["phalanx"], 2) - 1);
		if ($range_up > intval($server_config['num_of_systems'])) $range_up = intval($server_config['num_of_systems']);

		echo "<tr align='left'><th>";

		if ($value["ally"] != "") {
			$individual_ranking = galaxy_show_ranking_unique_ally($value["ally"]);
			$tooltip = "<table width=\"250\">";
			$tooltip .= "<tr><td colspan=\"3\" class=\"c\" align=\"center\">Alliance ".$value["ally"]."</td></tr>";
			while ($ranking = current($individual_ranking)) {
				$datadate = strftime("%d %b %Y à %Hh", key($individual_ranking));
				$general_rank = isset($ranking["general"]) ?  formate_number($ranking["general"]["rank"]) : "&nbsp;";
				$general_points = isset($ranking["general"]) ? formate_number($ranking["general"]["points"]) . " <i>( ". formate_number($ranking["general"]["points_per_member"]) ." )</i>" : "&nbsp;";
				$fleet_rank = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["rank"]) : "&nbsp;";
				$fleet_points = isset($ranking["fleet"]) ?  formate_number($ranking["fleet"]["points"]) . " <i>( ". formate_number($ranking["fleet"]["points_per_member"]) ." )</i>" : "&nbsp;";
				$research_rank = isset($ranking["research"]) ?  formate_number($ranking["research"]["rank"]) : "&nbsp;";
				$research_points = isset($ranking["research"]) ?  formate_number($ranking["research"]["points"]) . " <i>( ". formate_number($ranking["research"]["points_per_member"]) ." )</i>" : "&nbsp;";
				$mines_rank = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["rank"]) : "&nbsp;";
				$mines_points = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["points"]) . " <i>( ". formate_number($ranking["mines"]["points_per_member"]) ." )</i>" : "&nbsp;";
				$defenses_rank = isset($ranking["defenses"]) ?  formate_number($ranking["mines"]["rank"]) : "&nbsp;";
				$defenses_points = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["points"]) . " <i>( ". formate_number($ranking["defenses"]["points_per_member"]) ." )</i>" : "&nbsp;";
				
				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
				$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$mines_rank."</th><th>".$mines_points."</th></tr>";
				$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$defenses_rank."</th><th>".$defenses_points."</th></tr>";	
				$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">".formate_number($ranking["number_member"])." membre(s)</td></tr>";
				break;
			}
			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=ally&string_search=".$value["ally"]."&strict=on\">Voir détail</a></td></tr>";
			$tooltip .= "</table>";
			$tooltip = htmlentities($tooltip);

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
			$mines_rank = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["rank"]) : "&nbsp;";
			$mines_points = isset($ranking["mines"]) ?  formate_number($ranking["mines"]["points"]) : "&nbsp;";		
			$defenses_rank = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["rank"]) : "&nbsp;";
			$defenses_points = isset($ranking["defenses"]) ?  formate_number($ranking["defenses"]["points"]) : "&nbsp;";
				

			$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\">Classement du ".$datadate."</td></tr>";
			$tooltip .= "<tr><td class=\"c\" width=\"75\">Général</td><th width=\"30\">".$general_rank."</th><th>".$general_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$fleet_rank."</th><th>".$fleet_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$research_rank."</th><th>".$research_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Flotte</td><th>".$mines_rank."</th><th>".$mines_points."</th></tr>";
			$tooltip .= "<tr><td class=\"c\">Recherche</td><th>".$defenses_rank."</th><th>".$defenses_points."</th></tr>";		
			break;
		}
		$tooltip .= "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><a href=\"index.php?action=search&type_search=player&string_search=".$value["player"]."&strict=on\">Voir détail</a></td></tr>";
		$tooltip .= "</table>";
		$tooltip = htmlentities($tooltip);
		echo "<a href=\"index.php?action=search&type_search=player&string_search=".$value["player"]."&strict=on\" onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$tooltip."')\">".$value["player"]."</a> possède une lune avec phalange de niveau ".$value["phalanx"];
		echo " en <a href='index.php?action=galaxy&galaxy=".$value["galaxy"]."&system=".$value["system"]."'>".$value["galaxy"].":".$value["system"].":".$value["row"]."</a> [<font color='orange'>".$value["galaxy"].":".$range_down." <-> ".$value["galaxy"].":".$range_up."</font>]";

		if ($value["gate"] == "1") echo " avec une <font color='red'>porte spatiale</font>";
		echo ".</th></tr>";
	}
}
else echo "<tr><th>Aucune phalange répertoriée n'a une portée suffisante pour phalanger les planètes de ce système</th></tr>";
echo "</table>";


//Raccourci recherche
$tooltip_begin = "<table width=\"200\">";
$tooltip_end = "</table>";

$tooltip_colonization = $tooltip_moon = $tooltip_away = $tooltip_spy = "";
for ($i=10 ; $i<=50 ; $i=$i+10) {
	if ($system - $i >= 1) $down = $system-$i;
	else $down = 1;

	if ($system + $i <= intval($server_config['num_of_systems'])) $up = $system+$i;
	else $up = intval($server_config['num_of_systems']);

	$tooltip_colonization .= "<tr><th><a href=\"index.php?action=search&type_search=colonization&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." systèmes environnants</a></th></tr>";
	$tooltip_moon .= "<tr><th><a href=\"index.php?action=search&type_search=moon&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." systèmes environnants</a></th></tr>";
	$tooltip_away .= "<tr><th><a href=\"index.php?action=search&type_search=away&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." systèmes environnants</a></th></tr>";
	$tooltip_spy .= "<tr><th><a href=\"index.php?action=search&type_search=spy&galaxy_down=".$galaxy."&galaxy_up=".$galaxy."&system_down=".$down."&system_up=".$up."&row_down=&row_up=\">".$i." systèmes environnants</a></th></tr>";
}

$tooltip_colonization = htmlentities($tooltip_begin.$tooltip_colonization.$tooltip_end);
$tooltip_moon = htmlentities($tooltip_begin.$tooltip_moon.$tooltip_end);
$tooltip_away = htmlentities($tooltip_begin.$tooltip_away.$tooltip_end);
$tooltip_spy = htmlentities($tooltip_begin.$tooltip_spy.$tooltip_end);

echo "<br /><table width='860' border='1'>";
echo "<tr><td class='c' align='center' colspan='4'>Recherches</td></tr>";
echo "<tr align='center'>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_colonization."')\">Planètes colonisables</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_moon."')\">Lunes</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_away."')\">Joueurs inactifs</th>";
echo "<th width='25%' onmouseover=\"this.T_WIDTH=210;return escape('".$tooltip_spy."')\">Rapports d'espionnage</th>";
echo "</tr>";
echo "</table>";


require_once("views/page_tail.php");
?>
