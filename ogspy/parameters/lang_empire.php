<?php
/***************************************************************************
*	filename	: home_empire.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 19/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

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
$technology_requirement["Plasma"] = array(4, "NRJ" => 8, "Laser" => 10, "Ions" => 5);
$technology_requirement["RRI"] = array(10, "Ordi" => 8, "Hyp" => 8);
$technology_requirement["Graviton"] = array(12);
$technology_requirement["Expeditions"] = array(3, "Esp" => 4, "RI" => 3);
?>