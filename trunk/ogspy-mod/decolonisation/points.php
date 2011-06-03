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

//preparatif total colonne 
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $user_building[$i]['total_building'] = 0;
    $user_building[$i+100]['total_building_L'] = 0;
    $user_building[$i]['total_defense'] = 0;
    $user_building[$i+100]['total_defense_L'] = 0;
    
    }

foreach ($buildings as $key => $value) {
echo "<tr>\n\t<th><a>".$lang["decolo_building_".$value["nom"]]."</a></th>\n";
$temp_total = 0; // ligne
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $level  = $user_building[$i][$value["nom"]];
    $price =intval(array_sum(building_cumulate($value["nom"],$level))/ 1000);
    $temp_total +=$price; // pour le total : ligne
    $user_building[$i]['total_building']  +=$price ;//pour le total colonne
    if ($level == "") $level = "0";
	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";
     }
     
     ///affichage sat
echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
$temp_total = 0;
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $nombre  = $user_building[$i]['Sat'];
    if ($nombre == "") $nombre = "0";
    $price = intval(2.5 * $nombre);
    $temp_total  += $price ;
    $user_building[$i]['total_building']  +=$price;
		echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";


// Affichage du total des bâtiments
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
  for ($i=101; $i<=$nbre_planete+100; $i++) {
    echo "\t<th><font color='lime'>".number_format($user_building[$i]['total_building'], 0, $virgule, $sep_mille)."</font></th>\n";
    }
    $temp_total = 0;
    for ($i=101; $i<=$nbre_planete+100; $i++) {
        $temp_total += $user_building[$i]['total_building'];
        }
    
    echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";

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
    $temp_total = 0;
    echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
    for ($i=101; $i<=$nbre_planete+100; $i++) {
     $nombre  = $user_defence[$i][$value["nom"]];
     $price = $defenses[$key]["prix"] * $nombre;
     $temp_total  += $price ;
    $user_building[$i]['total_defense']  +=$price;
  	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
        
        }
        echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";
    }

// Affichage du total des défenses
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
 for ($i=101; $i<=$nbre_planete+100; $i++) {
    echo "\t<th><font color='lime'>".number_format($user_building[$i]['total_defense'], 0, $virgule, $sep_mille)."</font></th>\n";
    }
     $temp_total  = 0 ;
for ($i=101; $i<=$nbre_planete+100; $i++) {
    $temp_total += $user_building[$i]['total_defense'];
    }
echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";



// Affichage des bâtiments des lunes
if ($lune!=0) {
    echo "</tr>\n<tr>\n\t<td class='c' colspan='".($nbre_planete + 1)."'>".$lang['decolo_moon_buildings_points']."</td><td class='c' style='text-align:center'>".$lang['decolo_total']."</td>\n</tr>\n";

	echo "<tr>\n\t<th class='c'><a>".$lang['decolo_name']."</a></th>\n";
    
      
    for ($i=201; $i<=$nbre_planete+200; $i++) {
   	$name = $user_building[$i]['planet_name'];
	if ($name == "") $name = "-&nbsp;";
	echo "\t<th><a>".$name."</a></th>\n";
}
	echo "\t<th class='c' style='text-align:center'>-</th>\n</tr>\n";
    
    
    
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
    $temp_total=0;
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $level  = $user_building[$i][$value["nom"]];
    $price =intval(array_sum(building_cumulate($value["nom"],$level))/ 1000);
    $temp_total +=$price; // pour le total : ligne
    $user_building[$i]['total_building_L']  +=$price ;//pour le total colonne
	if ($level == "") $level = "0";
	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";
     }
     

///affichage sat
echo "<tr>\n\t<th><a>".$lang['decolo_SS']."</a></th>\n";
$temp_total = 0 ;
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $nombre  = $user_building[$i]['Sat'];
    if ($nombre == "") $nombre = "0";
    $price = intval(2.5 * $nombre);
    $temp_total += $price ;
    $user_building[$i]['total_building_L']  +=$price ;//pour le total colonne
		echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
     }
     echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";


// Affichage du total des bâtiments
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
  for ($i=201; $i<=$nbre_planete+200; $i++) {
    echo "\t<th><font color='lime'>".number_format($user_building[$i]['total_building_L'], 0, $virgule, $sep_mille)."</font></th>\n";
    }
    $temp_total  = 0 ;
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $temp_total += $user_building[$i]['total_building_L'];
    }
echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";


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
    $temp_total = 0 ;
    echo "<tr>\n\t<th><a>".$lang["decolo_defense_".$value["nom"]]."</a></th>\n";
    for ($i=201; $i<=$nbre_planete+200; $i++) {
     $nombre  = $user_defence[$i][$value["nom"]];
     $price = $defenses[$key]["prix"] * $nombre;
     $temp_total +=$price; // pour le total : ligne
    $user_building[$i]['total_defense_L']  +=$price ;//pour le total colonne
  	echo "\t<th><a>".number_format($price, 0, $virgule, $sep_mille)."</a></th>\n";
        
        }
        echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";
    }

// Affichage du total des défenses
echo "<tr>\n\t<th><a>".$lang['decolo_subtotal']."</a></th>\n";
 for ($i=201; $i<=$nbre_planete+200; $i++) {
    echo "\t<th><font color='lime'>".number_format($user_building[$i]['total_defense_L'], 0, $virgule, $sep_mille)."</font></th>\n";
    }
  $temp_total  = 0 ;
for ($i=201; $i<=$nbre_planete+200; $i++) {
    $temp_total += $user_building[$i]['total_defense_L'];
    }
echo "\t<th>".number_format($temp_total, 0, $virgule, $sep_mille)."</th>\n</tr>\n";


// Affichage du pied de tableau
echo "<tr>\n\t<td class='c' colspan='".($nbre_planete + 2)."'>".$lang['decolo_total']."</td></tr>\n<tr>\n\t<th><a>".$lang['decolo_total']."</a></th>\n";
for ($i=101; $i<=$nbre_planete+100; $i++) {
	$user_building[$i]['super_total'] = $user_building[$i]['total_building'] +  $user_building[$i]['total_defense'] +  $user_building[$i+100]['total_defense_L'] +  $user_building[$i+100]['total_building_L'];
    echo "\t<th><font color='lime'>".number_format($user_building[$i]['super_total'], 0, $virgule, $sep_mille)."</font></th>\n";
}
$temp_super_total=0;
for ($i=101; $i<=$nbre_planete+100; $i++) {
	$temp_super_total += $user_building[$i]['super_total'] ;
  }

echo "\t<th>".number_format($temp_super_total, 0, $virgule, $sep_mille)."</th>\n".
	"</tr>\n<tr>\n\t<th><a>".$lang['decolo_percent']."</a></th>\n";


// calcule au debut : $points 

for ($i=101; $i<=$nbre_planete+100; $i++) {
$temp_total = ($user_building[$i]['super_total'] *100 / $points) ;
	echo "\t<th><font color='lime'>".round($temp_total, "2")." %</font></th>\n";
}
$temp_total = ($temp_super_total *100 / $points) ;
echo "\t<th>".round($temp_total, "2")." %</th>\n</tr>\n<tr>\n\t<td></td>\n";
echo "\t</tr>\n</table>";
}

//
$graph_values = '';
//
$graph_legend = '';
//
for ($i=101; $i<=$nbre_planete+100; $i++) {
	if ($graph_values != '') {
	$graph_values .= '_x_';
	$graph_legend .= '_x_'; 
    }
    $graph_values .= intval($user_building[$i]['super_total']);
    $graph_legend .= $user_building[$i]['planet_name'];
    }
    
    if ($graph_values != '') echo "<div align='center'><img src='index.php?action=graphic_pie&values=".$graph_values."&legend=".$graph_legend."&title=".$lang['decolo_graph']."' title='".$lang['decolo_graph']."' alt='".$lang['decolo_graph_alt']."' width='400' height='200' /></div>";
    