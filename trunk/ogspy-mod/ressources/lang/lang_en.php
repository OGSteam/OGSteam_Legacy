<?php
/***************************************************************************
*	filename	: lang_en.php
*	package		: Mod Ressources
*	version		: 0.2
*	desc.			: List of strings for the English language.
*	Author		: Scaler - http://ogsteam.fr
*	created		: 11:23 19/09/2009
*	modified	: 20:59 19/01/2010
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['ressources_name'] = "Resources";
$lang['ressources_mod_name'] = "Mod Resources";
$lang['ressources_thousands_separator'] = ".";
$lang['ressources_locale'] = "en_US.UTF-8";
$lang['ressources_planete'] = "Planetes";
$lang['ressources_none'] = "Clic to unselect all planetes"; // Not implemented yet
$lang['ressources_all'] = "Clic to select all planetes"; // Not implemented yet
$lang['ressources_ressources'] = "Resources";
$lang['ressources_production'] = "Production";
$lang['ressources_storage'] = "Storage";
$lang['ressources_metal'] = "Metal";
$lang['ressources_crystal'] = "Crystal";
$lang['ressources_deuterium'] = "Deuterium";
$lang['ressources_SCS'] = "SCS";
$lang['ressources_LCS'] = "LCS";
$lang['ressources_Rec'] = "Rec";
$lang['ressources_RIP'] = "RIP";
$lang['ressources_take_into'] = "Take into account"; // Not implemented yet
$lang['ressources_update'] = "Update:";
$lang['ressources_metal_const_date'] = "Metal available at the time of construction";
$lang['ressources_crystal_const_date'] = "Crystal available at the time of construction";
$lang['ressources_deut_const_date'] = "Deuterium available at the time of construction";
$lang['ressources_less_24h'] = "Less than 24 hours before complete filling";
$lang['ressources_total'] = "Total";
$lang['ressources_delete'] = "Delete";
$lang['ressources_level'] = "Level";
$lang['ressources_quantity'] = "Quantity";
$lang['ressources_hidden_ressources'] = "Hidden resources";
$lang['ressources_add_hidden'] = "Add a building or research for hidden resources";
$lang['ressources_hide_max'] = "No more than 20 constructions for hidden resources.";
$lang['ressources_research_max'] = "There is already a research.";
$lang['ressources_trades'] = "Trades";
$lang['ressources_add_trade'] = "Add a planned exchange or resources in flight";
$lang['ressources_trade_max'] = "No more than 20 trades.";
$lang['ressources_metal_ratio'] = "Metal ratio";
$lang['ressources_crystal_ratio'] = "Crystal ratio";
$lang['ressources_deut_ratio'] = "Deuterium ratio";
$lang['ressources_constructions'] = "Constructions";
$lang['ressources_add_construction'] = "Add a planned construction";
$lang['ressources_construction_max'] = "No more than 20 planned constructions.";
$lang['ressources_construction_date'] = "Date when constructions will be possible:";
$lang['ressources_metal_construction'] = "Metal available at the time of construction";
$lang['ressources_crystal_construction'] = "Crystal available at the time of construction";
$lang['ressources_deut_construction'] = "Deuterium available at the time of construction";
$lang['ressources_save'] = "Save";
$lang['ressources_save_erase'] = "Saving will overwrite the previous save";
$lang['ressources_months'] = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
$lang['ressources_created_by'] = "Mod Resources v"./*$mod_version*/"%1\$s"." developped by "./*$creator_name*/"%2\$s";
$lang['ressources_changelog'] = "See the "./*$changelog_link*/"%1\$s"."ChangeLog"./*$end_link*/"%3\$s"." or "./*$forum_link*/"%2\$s"."more informations"./*$end_link*/"%3\$s";

// Buildings, technologies, fleets, defenses
$lang['ressources_construction'] = array(
	"Buildings", // Buildings
		"Metal mine",
		"Crystal mine",
		"Deuterium synthesizer",
		"Solar plant",
		"Fusion reactor",
		"Robotic factory",
		"Nanite factory",
		"Shipyard",
		"Metal storage",
		"Crystal storage",
		"Deuterium tank",
		"Research lab",
		"Terraformer",
		"Alliance depot",
		"Missile silo",
		"Lunar base",
		"Phalanx",
		"Jump gate",
	"Technologies", // Technologies
		"Espionage technology",
		"Computer technology",
		"Weapon technology",
		"Shielding technology",
		"Armour technology",
		"Energy technology",
		"Hyperspace technology",
		"Combustion drive",
		"Impulse drive",
		"Hyperspace drive",
		"Laser technology",
		"Ion technology",
		"Plasma technology",
		"Intergalactic research network",
		"Astrophysics technology",
	"Fleets", // Fleets
		"Small cargo ship",
		"Large cargo ship",
		"Light fighter",
		"Heavy fighter",
		"Cruiser",
		"Battleship",
		"Colony ship",
		"Recycler",
		"Espionage probe",
		"Bomber",
		"Solar satellite",
		"Destroyer",
		"Death star",
		"Battlecruiser",
	"Defenses", // Defenses
		"Missile launcher",
		"Light laser",
		"Heavy laser",
		"Gauss cannon",
		"Ion cannon",
		"Plasma cannon",
		"Small shield dome",
		"Large shield dome",
		"Anti-ballistic missile",
		"Interplanetary missile"
);

// Trading
$lang['ressources_trade'] = array(
	"Buying/selling metal",
	"Buying/selling crystal",
	"Buying/selling deuterium",
	"Flying resources"
);

// Installation
$lang['ressources_xtense'] = "Compatibility of the Resources mod with the Xtense2 mod is installed!";
$lang['ressources_no_xtense'] = "The Xtense2 mod is not installed.\nThe compatibility with the Resources mod will not be installed!\nConsider installing the Xtense2 mod it is convenient.";
$lang['ressources_xtense_rem'] = "Compatibility of the Resources mod with the Xtense2 mod is uninstalled!";

// Changelog
$lang['ressources_back'] = "Back";
$lang['ressources_date_format'] = "m/d/y";
$lang['ressources_version'] = "Version";
$lang['ressources_legend'] = "[Fix] : fixing a bug<br />".
	"[Add] : adding a new function<br />".
	"[Imp] : improvement of a function";
$lang['ressources_version_0.1'] = "- [Add] Displaying available resources by planet and total in real time.<br />".
	"- [Add] Displaying production and storage by planet and total.<br />".
	"- [Add] Taking into account the hidden resources and trading planned or underway.<br />".
	"- [Add] Calculating the possible date of construction with the resources available and production.";
$lang['ressources_version_0.2'] = "-[Fix] mySQL error during à installation.<br />".
	"- [Fix] Some small omission.<br />".
	"- [Add] Alternative text on pictures.";
?>
