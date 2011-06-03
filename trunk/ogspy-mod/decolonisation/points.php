<?php
/***************************************************************************
*	filename	: points.php
*	package		: Mod Decolonisation
*	version		: 0.7d
*	desc.			: Calcul des points par planète.
*	Authors		: Jojo.lam44 & Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 09:38 05/09/2009
***************************************************************************/

//error_reporting(E_ALL);

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

$nbre_planete=find_nb_planete_user();
$lune=0;


// Affichage de l'en-tête de tableau
echo "\n<table width='100%'>\n<tr>\n\t<td class='c' colspan='".($nbre_planete + 1)."'>".$lang['decolo_nization_mod']."</td>\n</tr>\n<tr>\n\t<th><a>".$lang['decolo_name']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
    // verif pour lune
    if ($user_building[$i+100]['planet_name'] !="") $lune +=1;
	$name = $user_building[$i]['planet_name'];
	if ($name == "") $name = "&nbsp;";
	echo "\t<th><a>".$name."</a></th>\n";
}
echo "</tr>\n<tr>\n\t<th><a>".$lang['decolo_coord']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
	$coordinates = $user_building[$i]['coordinates'];
	if ($coordinates == "") $coordinates = "&nbsp;";
	else $coordinates = "[".$coordinates."]";
	echo "\t<th>".$coordinates."</th>\n";
}
echo "</tr>\n<tr>\n\t<th><a>".$lang['decolo_temp']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
	$temperature = $user_building[$i]['temperature_min']."/".$user_building[$i]['temperature_max'];
	if ($temperature == "/") $name = "&nbsp;";
	echo "\t<th><a>".$temperature."</a></th>\n";
}


echo "</tr>\n<tr>\n\t<td class='c' colspan='".($nbre_planete + 1)."'>".$lang['decolo_buildings_points']."</td><td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n</tr>\n";

// Affichage des bâtiments
$buildings["M"] = array("nom" => "M");
$buildings["C"] = array("nom" => "C");
$buildings["D"] = array("nom" => "D");
$buildings["CES"] = array("nom" => "CES");
$buildings["CEF"] = array("nom" => "CEF");
$buildings["UdR"] = array("nom" => "UdR");
$buildings["UdN"] = array("nom" => "UdN");
$buildings["CSp"] = array("nom" => "CSp");
$buildings["HM"] = array("nom" => "HM");
$buildings["HC"] = array("nom" => "HC");
$buildings["HD"] = array("nom" => "HD");
$buildings["Lab"] = array("nom" => "Lab");
$buildings["Ter"] = array("nom" => "Ter");
$buildings["Silo"] = array("nom" => "Silo");
$buildings["DdR"] = array("nom" => "DdR");


foreach ($buildings as $key => $value) {
echo "<tr>\n\t<th><a>".$lang["decolo_building_".$value["nom"]]."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $level  = $user_building[$i][$value["nom"]];
    $price =intval(array_sum(building_cumulate($value["nom"],$level))/ 1000);
	if ($level == "") $level = "0";
	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>Total</th>\n</tr>\n";
     }
     
     ///affichage sat
echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $nombre  = $user_building[$i]['Sat'];
    if ($nombre == "") $nombre = "0";
    $price = intval(2.5 * $nombre);
		echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>Total</th>\n</tr>\n";


// Affichage du total des bâtiments
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
  for ($i=101; $i<=$nbre_planete+100; $i++) {
    echo "\t<th><font color='lime'>Total</font></th>\n";
    }
    echo "\t<th>super_total</th>\n</tr>\n";

//// Affichage du total des bâtiments
//echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
//$total_batiments_tot = 0;
//for ($i=1; $i<=$nbre_planete; $i++) {
//	$total_batiments[$planete[$i]] = $building_cumulate[$planete[$i]]["M"] + $building_cumulate[$planete[$i]]["C"] + $building_cumulate[$planete[$i]]["D"] + $building_cumulate[$planete[$i]]["CES"] + $building_cumulate[$planete[$i]]["CEF"] + $building_cumulate[$planete[$i]]["UdR"] + $building_cumulate[$planete[$i]]["UdN"] + $building_cumulate[$planete[$i]]["CSp"] + $building_cumulate[$planete[$i]]["HM"] + $building_cumulate[$planete[$i]]["HC"] + $building_cumulate[$planete[$i]]["HD"] + $building_cumulate[$planete[$i]]["Lab"] + $building_cumulate[$planete[$i]]["Ter"] + $building_cumulate[$planete[$i]]["Silo"] + $building_cumulate[$planete[$i]]["DdR"] + $building_cumulate[$planete[$i]]["Sat"];
//	if ($total_batiments[$planete[$i]] < "1") $affich = "&nbsp;";
//	else $affich = number_format($total_batiments[$planete[$i]], 0, $virgule, $sep_mille);
//	echo "\t<th><font color='lime'>".$affich."</font></th>\n";
//	$total_batiments_tot += $total_batiments[$planete[$i]];
//}
//if ($total_batiments_tot < "1") $affich = "&nbsp;";
//else $affich = number_format($total_batiments_tot, 0, $virgule, $sep_mille);
//echo "\t<th>".$affich."</th>\n</tr>\n";

// Affichage des défenses
$defenses["LM"] = array("nom" => "LM", "prix" => 2);
$defenses["LLE"] = array("nom" => "LLE", "prix" => 2);
$defenses["LLO"] = array("nom" => "LLO", "prix" => 8);
$defenses["CG"] = array("nom" => "CG", "prix" => 37);
$defenses["AI"] = array("nom" => "AI", "prix" => 8);
$defenses["LP"] = array("nom" => "LP", "prix" => 130);
$defenses["PB"] = array("nom" => "PB", "prix" => 20);
$defenses["GB"] = array("nom" => "GB", "prix" => 100);
$defenses["MIC"] = array("nom" => "MIC", "prix" => 10);
$defenses["MIP"] = array("nom" => "MIP", "prix" => 25);

echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_defense_points']."</td>\n</tr>\n";
foreach ($defenses as $key => $value) {
    echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
    for ($i=101; $i<=$nbre_planete+100; $i++) {
     $nombre  = $user_defence[$i][$value["nom"]];
     $price = $defenses[$key]["prix"] * $nombre;
  	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
        
        }
        echo "\t<th>total</th>\n</tr>\n";
    }

// Affichage du total des défenses
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
 for ($i=101; $i<=$nbre_planete+100; $i++) {
    echo "\t<th><font color='lime'>Total</font></th>\n";
    }
echo "\t<th>super_total</th>\n</tr>\n";



// Affichage des bâtiments des lunes
if ($lune!=0) {
	echo "<tr>\n\t<td class='c'>".$lang['decolo_moon_buildings_points']."</td>\n";
    for ($i=201; $i<=$nbre_planete+200; $i++) {
   	$name = $user_building[$i]['planet_name'];
	if ($name == "") $name = "-&nbsp;";
	echo "\t<th><a>".$name."</a></th>\n";
}
	echo "\t<td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n</tr>\n";
    
    
    
	$buildings_L["UdR"] = array("nom" => "UdR");
	$buildings_L["CSp"] = array("nom" => "CSp");
	$buildings_L["HM"] = array("nom" => "HM");
	$buildings_L["HC"] = array("nom" => "HC");
	$buildings_L["HD"] = array("nom" => "HD");
	$buildings_L["DdR"] = array("nom" => "DdR");
	$buildings_L["BaLu"] = array("nom" => "BaLu");
	$buildings_L["Pha"] = array("nom" => "Pha");
	$buildings_L["PoSa"] = array("nom" => "PoSa");
    
    
    foreach ($buildings_L as $key => $value) {
echo "<tr>\n\t<th><a>".$lang["decolo_building_".$value["nom"]]."</a></th>\n";
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $level  = $user_building[$i][$value["nom"]];
    $price =intval(array_sum(building_cumulate($value["nom"],$level))/ 1000);
	if ($level == "") $level = "0";
	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>Total</th>\n</tr>\n";
     }
     

///affichage sat
echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $nombre  = $user_building[$i]['Sat'];
    if ($nombre == "") $nombre = "0";
    $price = intval(2.5 * $nombre);
		echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>Total</th>\n</tr>\n";


// Affichage du total des bâtiments
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
  for ($i=201; $i<=$nbre_planete+200; $i++) {
    echo "\t<th><font color='lime'>Total</font></th>\n";
    }
    echo "\t<th>super_total</th>\n</tr>\n";


// Affichage des défenses des lunes
$defenses_L["LM"] = array("nom" => "LM", "prix" => 2);
$defenses_L["LLE"] = array("nom" => "LLE", "prix" => 2);
$defenses_L["LLO"] = array("nom" => "LLO", "prix" => 8);
$defenses_L["CG"] = array("nom" => "CG", "prix" => 37);
$defenses_L["AI"] = array("nom" => "AI", "prix" => 8);
$defenses_L["LP"] = array("nom" => "LP", "prix" => 130);
$defenses_L["PB"] = array("nom" => "PB", "prix" => 20);
$defenses_L["GB"] = array("nom" => "GB", "prix" => 100);

echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_moon_defense_points']."</td>\n</tr>\n";
foreach ($defenses_L as $key => $value) {
    echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
    for ($i=201; $i<=$nbre_planete+200; $i++) {
     $nombre  = $user_defence[$i][$value["nom"]];
     $price = $defenses[$key]["prix"] * $nombre;
  	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
        
        }
        echo "\t<th>total</th>\n</tr>\n";
    }

// Affichage du total des défenses
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
 for ($i=201; $i<=$nbre_planete+200; $i++) {
    echo "\t<th><font color='lime'>Total</font></th>\n";
    }
echo "\t<th>super_total</th>\n</tr>\n";


// Affichage du pied de tableau
echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_total']."</td></tr>\n<tr>\n\t<th><a>".$lang['decolo_total']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
	echo "\t<th><font color='lime'>super_total</font></th>\n";
}

echo "\t<th>super_mega_total</th>\n".
	"</tr>\n<tr>\n\t<th><a>".$lang['decolo_percent']."</a></th>\n";

for ($i=101; $i<=$nbre_planete+100; $i++) {

	echo "\t<th><font color='lime'>total en  %</font></th>\n";
}

echo "\t<th>super_total en %</th>\n</tr>\n<tr>\n\t<td></td>\n";
echo "\t</tr>\n</table>";
//$graph_values = '';
//$graph_legend = '';
//for ($i=1; $i<=$nbre_planete; $i++) {
//	if ($graph_values != '') {
//		$graph_values .= '_x_';
//		$graph_legend .= '_x_';
//	}
//	$graph_values .= intval($total_general[$planete[$i]]);
//	$graph_legend .= $name[$planete[$i]];
//	$name[$planete[$i]] = $user_building[$planete[$i]]['planet_name'];
//	if ($name[$planete[$i]] == "") $name[$planete[$i]] = "&nbsp;";
//	echo "\t<td class='c' style='text-align:center'><a>".$name[$planete[$i]]."</a></td>\n";
//}
//echo "\t<td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n".
//	"</tr>\n</table>\n<br />\n";
//if ($total_general_tot < $points) {
//	$graph_values .= '_x_'.intval($points - $total_general_tot);
//	$graph_legend .= '_x_'.$lang['decolo_other'];
}
//if ($graph_values != '') echo "<div align='center'><img src='index.php?action=graphic_pie&values=".$graph_values."&legend=".$graph_legend."&title=".$lang['decolo_graph']."' title='".$lang['decolo_graph']."' alt='".$lang['decolo_graph_alt']."' width='400' height='200' /></div>";
//


//Coûts d'amélioration des batiments et recherches
function building_upgrade($building, $level)
{
    switch ($building) {
        case "M":
            $M = 60 * pow(1.5, ($level - 1));
            $C = 15 * pow(1.5, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "C":
            $M = 48 * pow(1.6, ($level - 1));
            $C = 24 * pow(1.6, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "D":
            $M = 225 * pow(1.5, ($level - 1));
            $C = 75 * pow(1.5, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "CES":
            $M = 75 * pow(1.5, ($level - 1));
            $C = 30 * pow(1.5, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "CEF":
            $M = 900 * pow(1.8, ($level - 1));
            $C = 360 * pow(1.8, ($level - 1));
            $D = 180 * pow(1.8, ($level - 1));
            $NRJ = 0;
            break;

        case "UdR":
            $M = 400 * pow(2, ($level - 1));
            $C = 120 * pow(2, ($level - 1));
            $D = 200 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "UdN":
            $M = 1000000 * pow(2, ($level - 1));
            $C = 500000 * pow(2, ($level - 1));
            $D = 100000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "CSp":
            $M = 400 * pow(2, ($level - 1));
            $C = 200 * pow(2, ($level - 1));
            $D = 100 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "HM":
            $M = 2000 * pow(2, ($level - 1));
            $C = 0;
            $D = 0;
            $NRJ = 0;
            break;

        case "HC":
            $M = 2000 * pow(2, ($level - 1));
            $C = 1000 * pow(2, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "HD":
            $M = 2000 * pow(2, ($level - 1));
            $C = 2000 * pow(2, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "Lab":
            $M = 200 * pow(2, ($level - 1));
            $C = 400 * pow(2, ($level - 1));
            $D = 200 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Ter":
            $M = 0;
            $C = 50000 * pow(2, ($level - 1));
            $D = 100000 * pow(2, ($level - 1));
            $NRJ = 1000 * pow(2, ($level - 1));
            break;

        case "Silo":
            $M = 20000 * pow(2, ($level - 1));
            $C = 20000 * pow(2, ($level - 1));
            $D = 1000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "BaLu":
            $M = 20000 * pow(2, ($level - 1));
            $C = 40000 * pow(2, ($level - 1));
            $D = 20000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Pha":
            $M = 20000 * pow(2, ($level - 1));
            $C = 40000 * pow(2, ($level - 1));
            $D = 20000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "PoSa":
            $M = 2000000 * pow(2, ($level - 1));
            $C = 4000000 * pow(2, ($level - 1));
            $D = 2000000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Esp":
            $M = 200 * pow(2, ($level - 1));
            $C = 1000 * pow(2, ($level - 1));
            $D = 200 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Ordi":
            $M = 0;
            $C = 400 * pow(2, ($level - 1));
            $D = 600 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Armes":
            $M = 800 * pow(2, ($level - 1));
            $C = 200 * pow(2, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "Bouclier":
            $M = 200 * pow(2, ($level - 1));
            $C = 600 * pow(2, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "Protection":
            $M = 1000 * pow(2, ($level - 1));
            $C = 0;
            $D = 0;
            $NRJ = 0;
            break;

        case "NRJ":
            $M = 0;
            $C = 800 * pow(2, ($level - 1));
            $D = 400 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Hyp":
            $M = 0;
            $C = 4000 * pow(2, ($level - 1));
            $D = 2000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "RC":
            $M = 400 * pow(2, ($level - 1));
            $C = 0;
            $D = 600 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "RI":
            $M = 2000 * pow(2, ($level - 1));
            $C = 4000 * pow(2, ($level - 1));
            $D = 600 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "PH":
            $M = 10000 * pow(2, ($level - 1));
            $C = 20000 * pow(2, ($level - 1));
            $D = 6000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Laser":
            $M = 200 * pow(2, ($level - 1));
            $C = 100 * pow(2, ($level - 1));
            $D = 0;
            $NRJ = 0;
            break;

        case "Ions":
            $M = 1000 * pow(2, ($level - 1));
            $C = 300 * pow(2, ($level - 1));
            $D = 100 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Plasma":
            $M = 2000 * pow(2, ($level - 1));
            $C = 4000 * pow(2, ($level - 1));
            $D = 1000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "RRI":
            $M = 20000 * pow(2, ($level - 1));
            $C = 20000 * pow(2, ($level - 1));
            $D = 1000 * pow(2, ($level - 1));
            $NRJ = 0;
            break;

        case "Graviton":
            $M = 0;
            $C = 0;
            $D = 0;
            $NRJ = 300000 * pow(3, ($level - 1));
            break;

        case "Astrophysique":
            $M = 4000 * pow(1.75, ($level - 1));
            $C = 8000 * pow(1.75, ($level - 1));
            $D = 4000 * pow(1.75, ($level - 1));
            $NRJ = 0;
            break;

        default:
            $M = 0;
            $C = 0;
            $D = 0;
            $NRJ = 0;
            break;
    }

    return array("M" => $M, "C" => $C, "D" => $D, "NRJ" => $NRJ);
}

//Coûts cumulés des batiments
function building_cumulate($building, $level)
{
    switch ($building) {
        case "M":
            $M = 60 * (1 - pow(1.5, $level)) / (-0.5);
            $C = 15 * (1 - pow(1.5, $level)) / (-0.5);
            $D = 0;
            break;

        case "C":
            $M = 48 * (1 - pow(1.6, $level)) / (-0.6);
            $C = 24 * (1 - pow(1.6, $level)) / (-0.6);
            $D = 0;
            break;

        case "D":
            $M = 225 * (1 - pow(1.5, $level)) / (-0.5);
            $C = 75 * (1 - pow(1.5, $level)) / (-0.5);
            $D = 0;
            break;

        case "CES":
            $M = 75 * (1 - pow(1.5, $level)) / (-0.5);
            $C = 30 * (1 - pow(1.5, $level)) / (-0.5);
            $D = 0;
            break;

        case "CEF":
            $M = 900 * (1 - pow(1.8, $level)) / (-0.8);
            $C = 360 * (1 - pow(1.8, $level)) / (-0.8);
            $D = 180 * (1 - pow(1.8, $level)) / (-0.8);
            break;

        case "Sat":
            $M = 0;
            $C = 2000 * $level;
            $D = 500 * $level;
            break;

        default:
            list($M, $C, $D) = array_values(building_upgrade($building, 1));
            $M = $M * -(1 - pow(2, $level));
            $C = $C * -(1 - pow(2, $level));
            $D = $D * -(1 - pow(2, $level));
            break;
    }

    return array("M" => $M, "C" => $C, "D" => $D);
}

?>
//<br />
//<br />
