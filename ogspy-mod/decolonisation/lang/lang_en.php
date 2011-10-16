<?php
/***************************************************************************
*	filename	: lang_en.php
*	package		: Mod Decolonization
*	version		: 0.7c
*	desc.			: List of strings for the English language.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 01:50 01/06/2009
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['decolo_nization'] = "Decolonization";
$lang['decolo_nization_mod'] = "Mod Decolonization";
$lang['decolo_thousands_separator'] = ",";
$lang['decolo_decimal_separator'] = ".";
$lang['decolo_name'] = "Name";
$lang['decolo_coord'] = "Coordinates";
$lang['decolo_temp'] = "Temperature";
$lang['decolo_total'] = "Total";
$lang['decolo_subtotal'] = "Subtotal";
$lang['decolo_percent'] = "Percentage Points";
$lang['decolo_other'] = "Other";
$lang['decolo_graph'] = "Proportion of points on each planets";
$lang['decolo_graph_alt'] = "No graphics available";
$lang['decolo_created_by'] = "Mod Decolonization v"./*$mod_version*/"%1\$s developed by "./*$creator_name*/"%2\$s modified by "./*$modifier_name*/"%3\$s";
$lang['decolo_forum'] = "See the "./*$changelog_link*/"%1\$sChangeLog</a> or "./*$forum_link*/"%2\$ssmore information</a>";

// Buildings
$lang['decolo_buildings_points'] = "Buildings Points";
$lang['decolo_moon_buildings_points'] = "Moon Buildings Points";
$lang['decolo_building_M'] = "Metal mine";
$lang['decolo_building_C'] = "Crystal mine";
$lang['decolo_building_D'] = "Deuterium synthesizer";
$lang['decolo_building_SoP'] = "Solar plant";
$lang['decolo_building_FR'] = "Fusion reactor";
$lang['decolo_building_RF'] = "Robotic factory";
$lang['decolo_building_NF'] = "Nanite factory";
$lang['decolo_building_S'] = "Shipyard";
$lang['decolo_building_MS'] = "Metal storage";
$lang['decolo_building_CS'] = "Crystal storage";
$lang['decolo_building_DT'] = "Deuterium tank";
$lang['decolo_building_RL'] = "Research lab";
$lang['decolo_building_T'] = "Terraformer";
$lang['decolo_building_ML'] = "Missile silo";
$lang['decolo_building_AD'] = "Alliance depot";
$lang['decolo_building_LB'] = "Lunar base";
$lang['decolo_building_SPh'] = "Sensor phalanx";
$lang['decolo_building_JG'] = "Jump gate";

// Solar Satellite
$lang['decolo_SS'] = "Solar Satellite";

// Defense
$lang['decolo_defense_points'] = "Defense Points";
$lang['decolo_moon_defense_points'] = "Moon Defense Points";
$lang['decolo_defense_ML'] = "Missile launcher";
$lang['decolo_defense_LL'] = "Light laser";
$lang['decolo_defense_HL'] = "Heavy laser";
$lang['decolo_defense_GC'] = "Gauss cannon";
$lang['decolo_defense_IC'] = "Ion cannon";
$lang['decolo_defense_PC'] = "Plasma cannon";
$lang['decolo_defense_SSD'] = "Small shield dome";
$lang['decolo_defense_LSD'] = "Large shield dome";
$lang['decolo_defense_ABM'] = "Anti-ballistic missile";
$lang['decolo_defense_IM'] = "Interplanetary missile";

// Changelog
$lang['decolo_back'] = "Back";
$lang['decolo_version'] = "Version";
$lang['decolo_legend'] = "[Fix] : fixing a bug<br />".
	"[Add] : adding a new function<br />".
	"[Imp] : improvement of a function";
$lang['decolo_version_0.2'] = "- [Fix] Calculation of sub-total points defence take into account twice the missile launcher.<br />".
	"- [Fix] Wrong calculation of points of the robot factory.<br />".
	"- [Fix] Wrong calculation of points of the terraformer.<br />".
	"- [Add] Points of moons buildings and moons defence taken into account.<br />".
	"- [Add] Subtotal by category.<br />".
	"- [Add] ChangeLog.";
$lang['decolo_version_0.3'] = "- [Add] Name of moons.<br />".
	"- [Add] Thousands separator.<br />".
	"- [Add] Percentage of points of a planet (plus corresponding moon) compared to the total of points.<br />".
	"- [Imp] Calculation of points buildings taking into account the flare at every level.";
$lang['decolo_version_0.3b'] = "- [Fix] Wrong calculation of total moons defenses points.";
$lang['decolo_version_0.4'] = "- [Imp] Removing columns of uncolonized planets.<br />".
	"- [Imp] Removing moon information if no moon.";
$lang['decolo_version_0.5'] = "- [Fix] Correction of small errors in the code.<br />".
	"- [Imp] Back to the old method of calculating points (before v0.3), less greedy for resources.";
$lang['decolo_version_0.6'] = "- [Fix] Correction of errors.<br />".
	"- [Add] Graph of points distribution.<br />".
	"- [Add] Taking into account of the alliance depot (only for OGSpy 3.05 or more).";
$lang['decolo_version_0.7b'] = "- [Imp] Internationalization.";
$lang['decolo_version_0.7c'] = "- [Fix] Alliance Depot on Moon.<br />".
	"- [Imp] Code improvement.";
?>
