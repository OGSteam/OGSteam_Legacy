<?php
/***************************************************************************
*	filename	: lang_en.php
*	package		: Mod Energie
*	version		: 0.8
*	desc.			: List of strings for the English language.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 26/08/2006
*	modified	: 09:54 05/09/2009
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['energy_energy'] = "Energy";
$lang['energy_mod'] = "Mod Energy";
$lang['energy_thousands_separator'] = ",";
$lang['energy_reset'] = "Click to reset";
$lang['energy_all_planets'] = "Take into account the energy gain over all the planets";
$lang['energy_sort_prod'] = "Click to sort by means of production";
$lang['energy_means_prod'] = "Means of production";
$lang['energy_before'] = "Before";
$lang['energy_after'] = "After";
$lang['energy_sort_energy'] = "Click to sort by gained energy";
$lang['energy_gained_energy'] = "Gained energy";
$lang['energy_cost'] = "Cost";
$lang['energy_sort_metal_cost'] = "Click to sort by metal cost";
$lang['energy_M'] = "Metal";
$lang['energy_sort_crystal_cost'] = "Click to sort by crystal cost";
$lang['energy_C'] = "Crystal";
$lang['energy_sort_deut_cost'] = "Click to sort by deuterium cost";
$lang['energy_D'] = "Deuterium";
$lang['energy_sort_unit_cost'] = "Click to sort by unit cost";
$lang['energy_M_short'] = "M";
$lang['energy_C_short'] = "C";
$lang['energy_D_short'] = "D";
$lang['energy_unit_cost'] = "Unit cost";
$lang['energy_ratio'] = "Ratio";
$lang['energy_ratio_help'] = "Used to calculate the unit cost";
$lang['energy_ratio_ressources'] = "Ratio between resources:";
$lang['energy_officer_E'] = "Engineer Officer";
$lang['energy_officer_E_help'] = "+10% energy";
$lang['energy_using_officer_E'] = "I'm using the Engineer Officer";
$lang['energy_not_FR_D'] = "Do not take into account the deuterium consumption of Fusion reactor";
$lang['energy_needed_energy'] = "Needed energy:";
$lang['energy_planet'] = "on the planet";
$lang['energy_energy_available'] = "Energy available:";
$lang['energy_temperature'] = "Temperature:";
$lang['energy_from_level'] = "from level";
$lang['energy_to'] = "to";
$lang['energy_help'] = "Help";
$lang['energy_max_SS_help'] = "0 = unlimited";
$lang['energy_max_SS'] = "Maximum number of Solar Satellite:";
$lang['energy_created_by'] = "Mod Energy v"./*$mod_version*/"%1\$s"." developed by "./*$creator_name*/"%2\$s";
$lang['energy_changelog'] = "See the "./*$changelog_link*/"%1\$s"."ChangeLog"./*end_link*/"</a>"." or "./*$forum_link*/"%2\$s"."more information"./*end_link*/"</a>";

// Buildings
$lang['energy_building_M'] = "Metal mine";
$lang['energy_building_C'] = "Crystal mine";
$lang['energy_building_D'] = "Deuterium synthesizer";
$lang['energy_building_SoP'] = "Solar plant";
$lang['energy_building_FR'] = "Fusion reactor";
$lang['energy_building_T'] = "Terraformer";

// Solar Satellite
$lang['energy_SS'] = "Solar Satellite";

// Technologies
$lang['energy_technology_En'] = "Energy Technology";
$lang['energy_technology_G'] = "Graviton Technology";

// Errors
$lang['energy_error'] = "error";
$lang['energy_no_FR'] = "no Fusion reactor";
$lang['energy_FR_too_small'] = "Fusion reactor too small";
$lang['energy_SS_exceeded'] = "Maximum number of Solar Satellite exceeded";

// Changelog
$lang['energy_back'] = "Back";
$lang['energy_date_format'] = "m/d/y";
$lang['energy_version'] = "Version";
$lang['energy_legend'] = "[Fix] : fixing a bug<br />".
	"[Add] : adding a new function<br />".
	"[Imp] : improvement of a function";
$lang['energy_version_0.2'] = "- [Imp] Light graphics rearrangements for better readability.<br />".
	"- [Imp] Taking into account the deuterium consumption of Fusion reactor (by including the cost of Deuterium synthesizer needed to fill consumption).<br />".
	"- [Add] Calculating optimum levels between Solar plant and Fusion reactor.<br />".
	"- [Add] Sort by metal, crystal, deuterium or unit cost.<br />".
	"- [Add] Several buildings construction.";
$lang['energy_version_0.2b'] = "- [Fix] Wrong calculation of the best among all means of production.<br />".
	"- [Imp] Sort by gained energy or means of production.<br />".
	"- [Add] Link on the current level of a building to reset this level.";
$lang['energy_version_0.3'] = "- [Imp] New formula of energy production of the Fusion reactor with 0.78a version of ogame.";
$lang['energy_version_0.3b'] = "- [Fix] Malfunction of planet choice when there is a 'hole' between two planets in one's personal zone.";
$lang['energy_version_0.4'] = "- [Add] Taking into account the Engineer Officer.";
$lang['energy_version_0.5'] = "- [Fix] Wrong required energy for Terraformer and Graviton Technology.<br />".
	"- [Fix] Wrong calculation of the produced energy by Solar plant.<br />".
	"- [Add] Maximum number of Solar Satellites adjustable.";
$lang['energy_version_0.6'] = "- [Add] Option to not take the deuterium consumption of Fusion reactor into account.<br />".
	"- [Add] Profitability of Energy Technology.";
$lang['energy_version_0.6b'] = "- [Fix] Bug to install or update on some servers.<br />".
	"- [Add] Icons indicating tooltips.";
$lang['energy_version_0.7b'] = "- [Imp] Internationalization.";
$lang['energy_version_0.8'] = "- [Add] Links to modify levels of constructions.<br />".
	"- [Add] Taking into account the percentage of mines.";
?>
