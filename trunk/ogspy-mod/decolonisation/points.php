<?php
/***************************************************************************
*	filename	: points.php
*	package		: Mod Decolonisation
*	version		: 0.7c
*	desc.			: Calcul des points par planète.
*	Authors		: Jojo.lam44 & Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 01:50 01/06/2009
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

require_once('includes/config.php');

$user_empire = user_get_empire();
$user_building = $user_empire['building'];
$user_defence = $user_empire['defence'];
$sep_mille = $lang['decolo_thousands_separator'];
$virgule = $lang['decolo_decimal_separator'];

$user_name = "'".$user_data['user_stat_name']."'";
$quet = mysql_query('SELECT max(datadate) as d FROM '.TABLE_RANK_PLAYER_POINTS.' WHERE player = '.$user_name);
$result = mysql_fetch_array($quet,MYSQL_ASSOC);
$derniere_point_stats = $result['d'];
if ($derniere_point_stats) {
	$quet = mysql_query('SELECT points FROM '.TABLE_RANK_PLAYER_POINTS.' WHERE player = '.$user_name.' and datadate = '.$derniere_point_stats.' LIMIT 1');
	$result = mysql_fetch_array($quet,MYSQL_ASSOC);
	$points = $result['points'];
}
$nbre_planete=0;
$lune=0;
for ($i=100; $i<=200; $i++) {
	if (isset ($user_building[$i][0])) {
		$nbre_planete += 1;
		$planete[$nbre_planete] = $i;
		if ($user_building[$i+100]['planet_name']) $lune = 1;
	}
}

$quet = mysql_query('SELECT config_value as ddr FROM '.TABLE_CONFIG.' WHERE config_name = "ddr"');
$result = mysql_fetch_array($quet,MYSQL_ASSOC);
$ddr = $result['ddr'];

// Affichage de l'en-tête de tableau
echo "\n<table width='100%'>\n<tr>\n\t<td class='c' colspan='".($nbre_planete + 1)."'>".$lang['decolo_nization_mod']."</td>\n</tr>\n<tr>\n\t<th><a>".$lang['decolo_name']."</a></th>\n";
for ($i=1; $i<=$nbre_planete; $i++) {
	$name[$planete[$i]] = $user_building[$planete[$i]]['planet_name'];
	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";
	echo "\t<th><a>".$name[$planete[$i]]."</a></th>\n";
}
echo "</tr>\n<tr>\n\t<th><a>".$lang['decolo_coord']."</a></th>\n";
for ($i=1; $i<=$nbre_planete; $i++) {
	$coordinates = $user_building[$planete[$i]]['coordinates'];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
	echo "\t<th>".$coordinates."</th>\n";
}
echo "</tr>\n<tr>\n\t<th><a>".$lang['decolo_temp']."</a></th>\n";
for ($i=1; $i<=$nbre_planete; $i++) {
	$temperature[$planete[$i]] = ($user_building[$planete[$i]]['temperature_min'] + $user_building[$planete[$i]]['temperature_max'])/2;
	if ($temperature[$planete[$i]] == "") $temperature[$planete[$i]] = "&nbsp;";
	echo "\t<th>".$temperature[$planete[$i]]."</th>\n";
}
echo "</tr>\n<tr>\n\t<td class='c' colspan='".($nbre_planete + 1)."'>".$lang['decolo_buildings_points']."</td><td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n</tr>\n";

// Affichage des bâtiments
$buildings = array();
$buildings["M"] = array("nom" => "M", "prix" => 75, "facteur" => 1.5);
$buildings["C"] = array("nom" => "C", "prix" => 72, "facteur" => 1.6);
$buildings["D"] = array("nom" => "D", "prix" => 300, "facteur" => 1.5);
$buildings["CES"] = array("nom" => "SoP", "prix" => 105, "facteur" => 1.5);
$buildings["CEF"] = array("nom" => "FR", "prix" => 1440, "facteur" => 1.8);
$buildings["UdR"] = array("nom" => "RF", "prix" => 720, "facteur" => 2);
$buildings["UdN"] = array("nom" => "NF", "prix" => 1600000, "facteur" => 2);
$buildings["CSp"] = array("nom" => "S", "prix" => 700, "facteur" => 2);
$buildings["HM"] = array("nom" => "MS", "prix" => 2000, "facteur" => 2);
$buildings["HC"] = array("nom" => "CS", "prix" => 3000, "facteur" => 2);
$buildings["HD"] = array("nom" => "DT", "prix" => 4000, "facteur" => 2);
$buildings["Lab"] = array("nom" => "RL", "prix" => 800, "facteur" => 2);
$buildings["Ter"] = array("nom" => "T", "prix" => 150000, "facteur" => 2);
$buildings["Silo"] = array("nom" => "ML", "prix" => 41000, "facteur" => 2);
$buildings["DdR"] = array("nom" => "AD", "prix" => 60000, "facteur" => 2);
$building_cumulate_tot = array();
$building_cumulate = array();

foreach ($buildings as $key => $value) {
	if ($key != "DdR" || $ddr == 1) {
		echo "<tr>\n\t<th><a>".$lang["decolo_building_".$value["nom"]]."</a></th>\n";
		$building_cumulate_tot[$key] = 0;
		for ($i=1; $i<=$nbre_planete; $i++) {
			$building_cumulate[$planete[$i]][$key] = 0;
			$building_cumulate[$planete[$i]][$key] = intval($value["prix"] * (1 - pow($value["facteur"] , $user_building[$planete[$i]][$key])) / ((1 - $value["facteur"]) * 1000));
			if ($building_cumulate[$planete[$i]][$key] < "1") $affich = "&nbsp;";
			else $affich = number_format($building_cumulate[$planete[$i]][$key], 0, $virgule, $sep_mille);
			echo "\t<th><font color='lime'>".$affich."</font></th>\n";
			$building_cumulate_tot[$key] += $building_cumulate[$planete[$i]][$key];
		}
		if ($building_cumulate_tot[$key] < "1") $affich = "&nbsp;";
		else $affich = number_format($building_cumulate_tot[$key], 0, $virgule, $sep_mille);
		echo "\t<th>".$affich."</th>\n</tr>\n";
	} else $building_cumulate[$key] = array(0,0,0,0,0,0,0,0,0,0);
}

echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
$building_cumulate_tot["Sat"] = 0;
for ($i=1; $i<=$nbre_planete; $i++) {
	$building_cumulate[$planete[$i]]["Sat"] = 2.5 * $user_building[$planete[$i]]["Sat"];
	if ($building_cumulate[$planete[$i]]["Sat"] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_cumulate[$planete[$i]]["Sat"], 0, $virgule, $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$building_cumulate_tot["Sat"] += $building_cumulate[$planete[$i]]["Sat"];
}
if ($building_cumulate_tot["Sat"] < "1") $affich = "&nbsp;";
else $affich = number_format($building_cumulate_tot["Sat"], 0, $virgule, $sep_mille);
echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage du total des bâtiments
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
$total_batiments_tot = 0;
for ($i=1; $i<=$nbre_planete; $i++) {
	$total_batiments[$planete[$i]] = $building_cumulate[$planete[$i]]["M"] + $building_cumulate[$planete[$i]]["C"] + $building_cumulate[$planete[$i]]["D"] + $building_cumulate[$planete[$i]]["CES"] + $building_cumulate[$planete[$i]]["CEF"] + $building_cumulate[$planete[$i]]["UdR"] + $building_cumulate[$planete[$i]]["UdN"] + $building_cumulate[$planete[$i]]["CSp"] + $building_cumulate[$planete[$i]]["HM"] + $building_cumulate[$planete[$i]]["HC"] + $building_cumulate[$planete[$i]]["HD"] + $building_cumulate[$planete[$i]]["Lab"] + $building_cumulate[$planete[$i]]["Ter"] + $building_cumulate[$planete[$i]]["Silo"] + $building_cumulate[$planete[$i]]["DdR"] + $building_cumulate[$planete[$i]]["Sat"];
	if ($total_batiments[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_batiments[$planete[$i]], 0, $virgule, $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_batiments_tot += $total_batiments[$planete[$i]];
}
if ($total_batiments_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_batiments_tot, 0, $virgule, $sep_mille);
echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage des défenses
$defenses = array();
$defenses["LM"] = array("nom" => "ML", "prix" => 2);
$defenses["LLE"] = array("nom" => "LL", "prix" => 2);
$defenses["LLO"] = array("nom" => "HL", "prix" => 8);
$defenses["CG"] = array("nom" => "GC", "prix" => 37);
$defenses["AI"] = array("nom" => "IC", "prix" => 8);
$defenses["LP"] = array("nom" => "PC", "prix" => 130);
$defenses["PB"] = array("nom" => "SSD", "prix" => 20);
$defenses["GB"] = array("nom" => "LSD", "prix" => 100);
$defenses["MIC"] = array("nom" => "ABM", "prix" => 10);
$defenses["MIP"] = array("nom" => "IM", "prix" => 25);
$user_defence_tot = array();

echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_defense_points']."</td>\n</tr>\n";
foreach ($defenses as $key => $value) {
	echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
	$user_defence_tot[$key] = 0;
	for ($i=1; $i<=$nbre_planete; $i++) {
		$user_defence[$planete[$i]][$key] = $defenses[$key]["prix"] * $user_defence[$planete[$i]][$key];
		if ($user_defence[$planete[$i]][$key] < "1") $affich = "&nbsp;";
		else $affich = number_format($user_defence[$planete[$i]][$key], 0, $virgule, $sep_mille);
		echo "\t<th><font color='lime'>".$affich."</font></th>\n";
		$user_defence_tot[$key] += $user_defence[$planete[$i]][$key];
	}
	if ($user_defence_tot[$key] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence_tot[$key], 0, $virgule, $sep_mille);
	echo "\t<th>".$affich."</th>\n</tr>\n";
}

// Affichage du total des défenses
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
$total_defence_tot = 0;
for ($i=1; $i<=$nbre_planete; $i++) {
	$total_defence[$planete[$i]] = $user_defence[$planete[$i]]["LM"] + $user_defence[$planete[$i]]["LLE"] + $user_defence[$planete[$i]]["LLO"] + $user_defence[$planete[$i]]["CG"] + $user_defence[$planete[$i]]["AI"] + $user_defence[$planete[$i]]["LP"] + $user_defence[$planete[$i]]["PB"] + $user_defence[$planete[$i]]["GB"] + $user_defence[$planete[$i]]["MIC"] + $user_defence[$planete[$i]]["MIP"];
	if ($total_defence[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_defence[$planete[$i]], 0, $virgule, $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_defence_tot += $total_defence[$planete[$i]];
}
if ($total_defence_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_defence_tot, 0, $virgule, $sep_mille);
echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage des bâtiments des lunes
if ($lune==1) {
	echo "<tr>\n\t<td class='c'>".$lang['decolo_moon_buildings_points']."</td>\n";
	for ($i=1; $i<=$nbre_planete; $i++) {
		$name[$planete[$i]+9] = $user_building[$planete[$i]+100]['planet_name'];
		if ($name[$planete[$i]+9] == "") $name[$planete[$i]+9] = "&nbsp;";
		echo "\t<td class='c' style='text-align:center'><a>".$name[$planete[$i]+9]."</a></td>\n";
	}
	echo "\t<td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n</tr>\n";
	
	$buildings_L["UdR"] = array("nom" => "RF", "prix" => 720, "facteur" => 2);
	$buildings_L["CSp"] = array("nom" => "S", "prix" => 700, "facteur" => 2);
	$buildings_L["HM"] = array("nom" => "MS", "prix" => 2000, "facteur" => 2);
	$buildings_L["HC"] = array("nom" => "CS", "prix" => 3000, "facteur" => 2);
	$buildings_L["HD"] = array("nom" => "DT", "prix" => 4000, "facteur" => 2);
	$buildings_L["DdR"] = array("nom" => "AD", "prix" => 60000, "facteur" => 2);
	$buildings_L["BaLu"] = array("nom" => "LB", "prix" => 80000, "facteur" => 2);
	$buildings_L["Pha"] = array("nom" => "SPh", "prix" => 80000, "facteur" => 2);
	$buildings_L["PoSa"] = array("nom" => "JG", "prix" => 8000000, "facteur" => 2);
	
	foreach ($buildings_L as $key => $value) {
		if ($key != "DdR" || $ddr == 1) {
			echo "<tr>\n\t<th><a>".$lang["decolo_building_".$value["nom"]]."</a></th>\n";
			$building_L_cumulate_tot[$key] = 0;
			for ($i=1; $i<=$nbre_planete; $i++) {
				$building_L_cumulate[$planete[$i]+9][$key] = 0;
				$building_L_cumulate[$planete[$i]+9][$key] = intval($value["prix"] * (1 - pow($value["facteur"] , $user_building[$planete[$i]+100][$key])) / ((1 - $value["facteur"]) * 1000));
				if ($building_L_cumulate[$planete[$i]+9][$key] < "1") $affich = "&nbsp;";
				else $affich = number_format($building_L_cumulate[$planete[$i]+9][$key], 0, $virgule, $sep_mille);
				echo "\t<th><font color='lime'>".$affich."</font></th>\n";
				$building_L_cumulate_tot[$key] += $building_L_cumulate[$planete[$i]+9][$key];
			}
			if ($building_L_cumulate_tot[$key] < "1") $affich = "&nbsp;";
			else $affich = number_format($building_L_cumulate_tot[$key], 0, $virgule, $sep_mille);
			echo "\t<th>".$affich."</th>\n</tr>\n";
		} else $building_L_cumulate[$key] = array(0,0,0,0,0,0,0,0,0,0);
	}

	echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
	$building_L_cumulate_tot["SatL"] = 0;
	for ($i=1; $i<=$nbre_planete; $i++) {
		$building_L_cumulate[$planete[$i]+9]["SatL"] = 2.5 * $user_building[$planete[$i]+100]["Sat"];
		if ($building_L_cumulate[$planete[$i]+9]["SatL"] < "1") $affich = "&nbsp;";
		else $affich = number_format($building_L_cumulate[$planete[$i]+9]["SatL"], 0, $virgule, $sep_mille);
		echo "\t<th><font color='lime'>".$affich."</font></th>\n";
		$building_L_cumulate_tot["SatL"] += $building_L_cumulate[$planete[$i]+9]["SatL"];
	}
	if ($building_L_cumulate_tot["SatL"] < "1") $affich = "&nbsp;";
	else $affich = number_format($building_L_cumulate_tot["SatL"], 0, $virgule, $sep_mille);
	echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage du total des bâtiments des lunes
	echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
	$total_batimentsL_tot = 0;
	for ($i=1; $i<=$nbre_planete; $i++) {
		$total_batiments[$planete[$i]+9] = $building_L_cumulate[$planete[$i]+9]["UdR"] + $building_L_cumulate[$planete[$i]+9]["CSp"] + $building_L_cumulate[$planete[$i]+9]["HM"] + $building_L_cumulate[$planete[$i]+9]["HC"] + $building_L_cumulate[$planete[$i]+9]["HD"] + $building_L_cumulate[$planete[$i]+9]["DdR"] + $building_L_cumulate[$planete[$i]+9]["BaLu"] + $building_L_cumulate[$planete[$i]+9]["Pha"] + $building_L_cumulate[$planete[$i]+9]["PoSa"] + $building_L_cumulate[$planete[$i]+9]["SatL"];
		if ($total_batiments[$planete[$i]+9] < "1") $affich = "&nbsp;";
		else $affich = number_format($total_batiments[$planete[$i]+9], 0, $virgule, $sep_mille);
		echo "\t<th><font color='lime'>".$affich."</font></th>\n";
		$total_batimentsL_tot += $total_batiments[$planete[$i]+9];
	}
	if ($total_batimentsL_tot < "1") $affich = "&nbsp;";
	else $affich = number_format($total_batimentsL_tot, 0, $virgule, $sep_mille);
	echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage des défenses des lunes
$defenses_L = array();
$defenses_L["LM"] = array("nom" => "ML", "prix" => 2);
$defenses_L["LLE"] = array("nom" => "LL", "prix" => 2);
$defenses_L["LLO"] = array("nom" => "HL", "prix" => 8);
$defenses_L["CG"] = array("nom" => "GC", "prix" => 37);
$defenses_L["AI"] = array("nom" => "IC", "prix" => 8);
$defenses_L["LP"] = array("nom" => "PC", "prix" => 130);
$defenses_L["PB"] = array("nom" => "SSD", "prix" => 20);
$defenses_L["GB"] = array("nom" => "LSD", "prix" => 100);
$user_defence_L_tot = array();

echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_moon_defense_points']."</td>\n</tr>\n";
foreach ($defenses_L as $key => $value) {
	echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
	$user_defence_L_tot[$key] = 0;
	for ($i=1; $i<=$nbre_planete; $i++) {
		$user_defence[$planete[$i]+100][$key] = $defenses_L[$key]["prix"] * $user_defence[$planete[$i]+100][$key];
		if ($user_defence[$planete[$i]+100][$key] < "1") $affich = "&nbsp;";
		else $affich = number_format($user_defence[$planete[$i]+100][$key], 0, $virgule, $sep_mille);
		echo "\t<th><font color='lime'>".$affich."</font></th>\n";
		$user_defence_L_tot[$key] += $user_defence[$planete[$i]+100][$key];
	}
	if ($user_defence_L_tot[$key] < "1") $affich = "&nbsp;";
	else $affich = number_format($user_defence_L_tot[$key], 0, $virgule, $sep_mille);
	echo "\t<th>".$affich."</th>\n</tr>\n";
}

// Affichage du total des défenses des lunes
	echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
	$total_defence_L_tot = 0;
	for ($i=1; $i<=$nbre_planete; $i++) {
		$total_defence[$planete[$i]+9] = $user_defence[$planete[$i]+100]["LM"] + $user_defence[$planete[$i]+100]["LLE"] + $user_defence[$planete[$i]+100]["LLO"] + $user_defence[$planete[$i]+100]["CG"] + $user_defence[$planete[$i]+100]["AI"] + $user_defence[$planete[$i]+100]["LP"] + $user_defence[$planete[$i]+100]["PB"] + $user_defence[$planete[$i]+100]["GB"];
		if ($total_defence[$planete[$i]+9] < "1") $affich = "&nbsp;";
		else $affich = number_format($total_defence[$planete[$i]+9], 0, $virgule, $sep_mille);
		echo "\t<th><font color='lime'>".$affich."</font></th>\n";
		$total_defence_L_tot += $total_defence[$planete[$i]+9];
	}
	if ($total_defence_L_tot < "1") $affich = "&nbsp;";
	else $affich = number_format($total_defence_L_tot, 0, $virgule, $sep_mille);
	echo "\t<th>".$affich."</th>\n</tr>\n";
}

// Affichage du pied de tableau
echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_total']."</td></tr>\n<tr>\n\t<th><a>".$lang['decolo_total']."</a></th>\n";
$total_general_tot = 0;
for ($i=1; $i<=$nbre_planete; $i++) {
	$total_general[$planete[$i]] = $total_batiments[$planete[$i]] + $total_defence[$planete[$i]] + $total_batiments[$planete[$i]+9] + $total_defence[$planete[$i]+9];
	if ($total_general[$planete[$i]] < "1") $affich = "&nbsp;";
	else $affich = number_format($total_general[$planete[$i]], 0, $virgule, $sep_mille);
	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
	$total_general_tot += $total_general[$planete[$i]];
}
if ($total_general_tot < "1") $affich = "&nbsp;";
else $affich = number_format($total_general_tot, 0, $virgule, $sep_mille);
echo "\t<th>".$affich."</th>\n".
	"</tr>\n<tr>\n\t<th><a>".$lang['decolo_percent']."</a></th>\n";
if (!isset($points)) $points = $total_general_tot;
for ($i=1; $i<=$nbre_planete; $i++) {
	$pourcentage[$planete[$i]] = 100 * $total_general[$planete[$i]] / $points;
	if ($pourcentage[$planete[$i]] < "0.1") $affich = "&nbsp;";
	else $affich = number_format($pourcentage[$planete[$i]], 1, $virgule, $sep_mille);
	echo "\t<th><font color='lime'>".$affich." %</font></th>\n";
}
if ($points != 0) $pourcentage_tot = 100 * $total_general_tot / $points;
else $pourcentage_tot = 100;
if ($pourcentage_tot < "0.1") $affich = "&nbsp;";
else $affich = number_format($pourcentage_tot, 1, $virgule, $sep_mille);
echo "\t<th>".$affich." %</th>\n</tr>\n<tr>\n\t<td></td>\n";
$graph_values = '';
$graph_legend = '';
for ($i=1; $i<=$nbre_planete; $i++) {
	if ($graph_values != '') {
		$graph_values .= '_x_';
		$graph_legend .= '_x_';
	}
	$graph_values .= intval($total_general[$planete[$i]]);
	$graph_legend .= $name[$planete[$i]];
	$name[$planete[$i]] = $user_building[$planete[$i+100]]['planet_name'];
	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";
	echo "\t<td class='c' style='text-align:center'><a>".$name[$planete[$i]]."</a></td>\n";
}
echo "\t<td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n".
	"</tr>\n</table>\n<br />\n";
if ($total_general_tot < $points) {
	$graph_values .= '_x_'.intval($points - $total_general_tot);
	$graph_legend .= '_x_'.$lang['decolo_other'];
}
if ($graph_values != '') echo "<div align='center'><img src='index.php?action=graphic_pie&values=".$graph_values."&legend=".$graph_legend."&title=".$lang['decolo_graph']."' title='".$lang['decolo_graph']."' alt='".$lang['decolo_graph_alt']."' width='400' height='200' /></div>";
?>
<br />
<br />
