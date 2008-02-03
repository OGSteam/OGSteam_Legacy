<?php
/***************************************************************************
*	filename	: home_empire.php
*	desc.		:
*	Author		: Kyser - http://ogsteam.fr/
*	created		: 19/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPACSPY')) {
	die("Hacking attempt");
}

//Bâtiments
$lang_building["M"] = "Extracteur d\'acier";
$lang_building["C"] = "Mine de silicium";
$lang_building["D"] = "Synthétiseur de deutéride";
$lang_building["CES"] = "Panneau de production énergétique solaire";
$lang_building["CEF"] = "Centrale électrique de fusion";
$lang_building["UdR"] = "Usine de robots";
$lang_building["UdN"] = "Usine de nanites";
$lang_building["CSp"] = "Usine spatiale";
$lang_building["HM"] = "Hangar d\'Acier";
$lang_building["HC"] = "Hangar de Silicium";
$lang_building["HD"] = "Réservoir de Deutéride";
$lang_building["Lab"] = "Laboratoire de recherches";
$lang_building["CdC"] = "Centre de communication";
$lang_building["Silo"] = "Silo de missiles";
$lang_building["CrAt"] = "Créateur d'atmosphère";
$lang_building["Pha"] = "Phalange de capteur";
$lang_building["PoSa"] = "Porte de saut spatial";

$lang_defence["CA"] = "Canon automatique";
$lang_defence["TLM"] = "Tourelle lance missiles";
$lang_defence["ASA"] = "Artillerie sol-air";
$lang_defence["CP"] = "Canon à proton";
$lang_defence["AM"] = "Artillerie de masse";
$lang_defence["Dem"] = "Dématérialisateur";
$lang_defence["PB"] = "Petit bouclier";
$lang_defence["GB"] = "Grand bouclier";
$lang_defence["MIC"] = "Missile Interception";
$lang_defence["MIP"] = "Missile Interplanétaire";

$lang_technology["Esp"] = "Technologie Espionnage";
$lang_technology["Gestion"] = "Technologie Gestion";
$lang_technology["Armes"] = "Technologie Armes";
$lang_technology["Bouclier"] = "Technologie Bouclier";
$lang_technology["Blindage"] = "Technologie Blindage";
$lang_technology["NRJ"] = "Technologie Energie";
$lang_technology["Hyp"] = "Technologie Hyperespace";
$lang_technology["RC"] = "Réacteur à combustion interne";
$lang_technology["RI"] = "Réacteur à impulsion";
$lang_technology["PH"] = "Propulsion hyperespace";
$lang_technology["Laser"] = "Technologie Laser";
$lang_technology["Ions"] = "Technologie Ions";
$lang_technology["Plasma"] = "Technologie Plasma";
$lang_technology["Antimatiere"] = "Technologie Antimatiere";

$lang_empire["Batiment"] = "Bâtiments";
$lang_empire["Recherche"] = "Recherche";
$lang_empire["Vaisseaux"] = "Vaisseaux";
$lang_empire["Défense"] = "Défense";

$technology_requirement["Esp"] = array(3);
$technology_requirement["Gestion"] = array(1);
$technology_requirement["Armes"] = array(4);
$technology_requirement["Bouclier"] = array(6, "NRJ" => 3);
$technology_requirement["Blindage"] = array(2);
$technology_requirement["NRJ"] = array(1);
$technology_requirement["Hyp"] = array(1, "NRJ" => 3, "Bouclier" => 5);
$technology_requirement["RC"] = array(1, "NRJ" => 1);
$technology_requirement["RI"] = array(2, "NRJ" => 1);
$technology_requirement["PH"] = array(7, "HYP" => 3);
$technology_requirement["Laser"] = array(1, "NRJ" => 2);
$technology_requirement["Ions"] = array(4, "Laser" => 5, "NRJ" => 4);
$technology_requirement["Plasma"] = array(4, "NRJ" => 8, "Laser" => 10, "Ions" => 5);
$technology_requirement["Antimatiere"] = array(12);
?>