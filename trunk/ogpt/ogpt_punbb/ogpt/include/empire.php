<?php
// fn recuperation empire ( global ?????? )))
////  user bulding
///   user recherche
/// user def

// 1 creation d'un empire de 0 a 18 planete valeur -1

function tableau($planete, $planet_id)
{
    global $pun_user, $db, $i, $bat;

    $tableau = '<tr>';
    $tableau .= ' <th>' . $planete . '</th>';
    $j = 1;
    while ($i >= $j) {
        $tableau .= '<td style="text-align:center;">' . $bat[$j][$planet_id] . '</td>';
        $j = $j + 1;
    }
    $tableau .= '</tr>';

    return $tableau;


}

function tableau_bis($planete, $planet_id)
{
    global $pun_user, $db, $i, $bat;

    $tableau = '<tr>';
    $tableau .= ' <th>' . $planete . '</th>';
    $j = 1;
    while ($i >= $j) {
        $tableau .= '<td style="text-align:center;"><img src="ogpt/skin/img/p' . $bat[$j][$planet_id] .
            '.jpg"></td>';
        $j = $j + 1;
    }
    $tableau .= '</tr>';

    return $tableau;


}

function tableau_lune($planete, $planet_id)
{
    global $pun_user, $db, $i, $bat;

    $tableau = '<tr>';
    $tableau .= ' <th>' . $planete . '</th>';
    $j = 10;
    while (18 >= $j) {
        $tableau .= '<td style="text-align:center;">' . $bat[$j][$planet_id] . '</td>';
        $j = $j + 1;
    }
    $tableau .= '</tr>';

    return $tableau;


}


function tableau_bis_lune($planete, $planet_id)
{
    global $pun_user, $db, $i, $bat;

    $tableau = '<tr>';
    $tableau .= ' <th>' . $planete . '</th>';
    $j = 10;
    while (18 >= $j) {
        $tableau .= '<td style="text-align:center;"><img src="ogpt/skin/img/p' . $bat[$j][$planet_id] .
            '.jpg"></td>';
        $j = $j + 1;
    }
    $tableau .= '</tr>';

    return $tableau;


}

function user_get_empire() {
		global $db,  $pun_user, $pun_config;

	$planet = array(false, "user_id" => "", "planet_name" => "", "coordinates" => "",
	"fields" => "", "fields_used" => "", "temperature" => "", "Sat" => "",
	"M" => 0, "C" => 0, "D" => 0,
	"CES" => 0, "CEF" => 0,
	"UdR" => 0, "UdN" => 0, "CSp" => 0,
	"HM" => 0, "HC" => 0, "HD" => 0,
	"Lab" => 0, "Ter" => 0, "Silo" => 0,
	"BaLu" => 0, "Pha" => 0, "PoSa" => 0, "DdR" => 0);

	$defence = array("LM" => 0, "LLE" => 0, "LLO" => 0,
	"CG" => 0, "AI" => 0, "LP" => 0,
	"PB" => 0, "GB" => 0,
	"MIC" => 0, "MIP" => 0);

	$request = "select planet_id, planet_name, `coordinates`, `fields`, temperature, Sat, M, C, D, CES, CEF, UdR, UdN, CSp, HM, HC, HD, Lab, Ter, Silo, BaLu, Pha, PoSa, DdR";
	$request .= " from ".$pun_config["ogspy_prefix"]."user_building";
	$request .= " where user_id = ".$pun_user['id_ogspy'];
	$request .= " order by planet_id";
	$result = $db->query($request);

	$user_building = array_fill(1, 18, $planet);
	while ($row = $db->fetch_assoc($result)) {
		$arr = $row;
		unset($arr["planet_id"]);
		unset($arr["planet_name"]);
		unset($arr["coordinates"]);
		unset($arr["fields"]);
		unset($arr["temperature"]);
		unset($arr["Sat"]);
		$fields_used = array_sum(array_values($arr));

		$row["fields_used"] = $fields_used;
		$user_building[$row["planet_id"]] = $row;
		$user_building[$row["planet_id"]][0] = true;
	}

	$request = "select Esp, Ordi, Armes, Bouclier, Protection, NRJ, Hyp, RC, RI, PH, Laser, Ions, Plasma, RRI, Graviton, Expeditions";
	$request .= " from ".$pun_config["ogspy_prefix"]."user_technology ";
	$request .= " where user_id = ".$pun_user['id_ogspy'];
	$result = $db->query($request);

	$user_technology = $db->fetch_assoc($result);

	$request = "select planet_id, LM, LLE, LLO, CG, AI, LP, PB, GB, MIC, MIP";
	$request .= " from ".$pun_config["ogspy_prefix"]."user_defence ";
	$request .= " where user_id = ".$pun_user['id_ogspy'];
	$request .= " order by planet_id";
	$result = $db->query($request);

	$user_defence = array_fill(1, 18, $defence);
	while ($row = $db->fetch_assoc($result)) {
		$planet_id = $row["planet_id"];
		unset($row["planet_id"]);
		$user_defence[$planet_id] = $row;
	}

	return array("building" => $user_building, "technology" => $user_technology, "defence" => $user_defence, );
}




///////////////: lang_empire

//Bâtiments
$lang_building["M"] = "Mine de métal";
$lang_building["C"] = "Mine de cristal";
$lang_building["D"] = "Synthétiseur de deutérium";
$lang_building["CES"] = "Centrale électrique solaire";
$lang_building["CEF"] = "Centrale électrique de fusion";
$lang_building["UdR"] = "Usine de robots";
$lang_building["UdN"] = "Usine de nanites";
$lang_building["CSp"] = "Chantier spatial";
$lang_building["HM"] = "Hangar de métal";
$lang_building["HC"] = "Hangar de cristal";
$lang_building["HD"] = "Réservoir de deutérium";
$lang_building["Lab"] = "Laboratoire de recherche";
$lang_building["Ter"] = "Terraformeur";
$lang_building["Silo"] = "Silo de missiles";
$lang_building["BaLu"] = "Base lunaire";
$lang_building["Pha"] = "Phalange de capteur";
$lang_building["PoSa"] = "Porte de saut spatial";

$lang_defence["LM"] = "Lanceur de missiles";
$lang_defence["LLE"] = "Artillerie laser légère";
$lang_defence["LLO"] = "Artillerie laser lourde";
$lang_defence["CG"] = "Canon de Gauss";
$lang_defence["AI"] = "Artillerie à ions";
$lang_defence["LP"] = "Lanceur de plasma";
$lang_defence["PB"] = "Petit bouclier";
$lang_defence["GB"] = "Grand bouclier";
$lang_defence["MIC"] = "Missile Interception";
$lang_defence["MIP"] = "Missile Interplanétaire";

$lang_technology["Esp"] = "Technologie Espionnage";
$lang_technology["Ordi"] = "Technologie Ordinateur";
$lang_technology["Armes"] = "Technologie Armes";
$lang_technology["Bouclier"] = "Technologie Bouclier";
$lang_technology["Protection"] = "Technologie Protection des vaisseaux spatiaux";
$lang_technology["NRJ"] = "Technologie Energie";
$lang_technology["Hyp"] = "Technologie Hyperespace";
$lang_technology["RC"] = "Réacteur à combustion";
$lang_technology["RI"] = "Réacteur à impulsion";
$lang_technology["PH"] = "Propulsion hyperespace";
$lang_technology["Laser"] = "Technologie Laser";
$lang_technology["Ions"] = "Technologie Ions";
$lang_technology["Plasma"] = "Technologie Plasma";
$lang_technology["RRI"] = "Réseau de recherche intergalactique";
$lang_technology["Graviton"] = "Technologie Graviton";
$lang_technology["Expeditions"] = "Technologie Expéditions";

$lang_empire["Batiment"] = "Bâtiments";
$lang_empire["Recherche"] = "Recherche";
$lang_empire["Vaisseaux"] = "Vaisseaux";
$lang_empire["Défense"] = "Défense";

$technology_requirement["Esp"] = array(3);
$technology_requirement["Ordi"] = array(1);
$technology_requirement["Armes"] = array(4);
$technology_requirement["Bouclier"] = array(6, "NRJ" => 3);
$technology_requirement["Protection"] = array(2);
$technology_requirement["NRJ"] = array(1);
$technology_requirement["Hyp"] = array(1, "NRJ" => 3, "Bouclier" => 5);
$technology_requirement["RC"] = array(1, "NRJ" => 1);
$technology_requirement["RI"] = array(2, "NRJ" => 1);
$technology_requirement["PH"] = array(7, "HYP" => 3);
$technology_requirement["Laser"] = array(1, "NRJ" => 2);
$technology_requirement["Ions"] = array(4, "Laser" => 5, "NRJ" => 4);
$technology_requirement["Plasma"] = array(4, "NRJ" => 8, "Laser" => 10, "Ions" =>
    5);
$technology_requirement["RRI"] = array(10, "Ordi" => 8, "Hyp" => 8);
$technology_requirement["Graviton"] = array(12);
$technology_requirement["Expeditions"] = array(3, "Esp" => 4, "RI" => 3);



?>