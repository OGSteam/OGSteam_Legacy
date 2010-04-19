<?php
/***************************************************************************
*	filename	: lang_fr.php
*	package		: Mod Ressources
*	version		: 0.2
*	desc.			: Liste des chaines pour la langue Française.
*	Author		: Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 21:00 19/01/2010
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['ressources_name'] = "Ressources";
$lang['ressources_mod_name'] = "Mod Ressources";
$lang['ressources_thousands_separator'] = "&nbsp;";
$lang['ressources_locale'] = "fr_FR.UTF-8";
$lang['ressources_planete'] = "Planètes";
$lang['ressources_none'] = "Cliquez pour dé-sélectionner toutes les planètes"; // Not implemented yet
$lang['ressources_all'] = "Cliquez pour sélectionner toutes les planètes"; // Not implemented yet
$lang['ressources_ressources'] = "Ressources";
$lang['ressources_production'] = "Production";
$lang['ressources_storage'] = "Hangars";
$lang['ressources_metal'] = "Métal";
$lang['ressources_crystal'] = "Cristal";
$lang['ressources_deuterium'] = "Deutérium";
$lang['ressources_SCS'] = "PT";
$lang['ressources_LCS'] = "GT";
$lang['ressources_Rec'] = "Rec";
$lang['ressources_RIP'] = "EDLM";
$lang['ressources_take_into'] = "Prendre en compte"; // Not implemented yet
$lang['ressources_update'] = "MàJ&nbsp;:";
$lang['ressources_metal_const_date'] = "Métal disponible à la date de construction";
$lang['ressources_crystal_const_date'] = "Cristal disponible à la date de construction";
$lang['ressources_deut_const_date'] = "Deutérium disponible à la date de construction";
$lang['ressources_less_24h'] = "Moins de 24 heures avant remplissage total";
$lang['ressources_total'] = "Total";
$lang['ressources_delete'] = "Supprimer";
$lang['ressources_level'] = "Niveau";
$lang['ressources_quantity'] = "Quantité";
$lang['ressources_hidden_ressources'] = "Ressources cachées";
$lang['ressources_add_hidden'] = "Ajouter un bâtiment ou une recherche permettant de cacher ses ressources";
$lang['ressources_hide_max'] = "Pas plus de 20 constructions pour cacher des ressources.";
$lang['ressources_research_max'] = "Il y a déjà une recherche de lancée.";
$lang['ressources_trades'] = "Échanges";
$lang['ressources_add_trade'] = "Ajouter un échange prévu ou des ressources en vol";
$lang['ressources_trade_max'] = "Pas plus de 20 échanges.";
$lang['ressources_metal_ratio'] = "Rapport métal";
$lang['ressources_crystal_ratio'] = "Rapport cristal";
$lang['ressources_deut_ratio'] = "Rapport deutérium";
$lang['ressources_constructions'] = "Constructions";
$lang['ressources_add_construction'] = "Ajouter une construction prévue";
$lang['ressources_construction_max'] = "Pas plus de 20 constructions.";
$lang['ressources_construction_date'] = "Date à laquelle les constructions seront possibles :";
$lang['ressources_metal_construction'] = "Métal disponible à la date de construction";
$lang['ressources_crystal_construction'] = "Cristal disponible à la date de construction";
$lang['ressources_deut_construction'] = "Deutérium disponible à la date de construction";
$lang['ressources_save'] = "Sauvegarder";
$lang['ressources_save_erase'] = "Sauvegarder écrasera la sauvegarde précédente";
$lang['ressources_months'] = array("janv.", "févr.", "mars", "avr.", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc.");
$lang['ressources_created_by'] = "Mod Ressources v"./*$mod_version*/"%1\$s"." développé par "./*$creator_name*/"%2\$s";
$lang['ressources_changelog'] = "Voir le "./*$changelog_link*/"%1\$s"."ChangeLog"./*$end_link*/"%3\$s"." ou "./*$forum_link*/"%2\$s"."plus d'informations"./*$end_link*/"%3\$s";

// Buildings, technologies, fleets, defenses
$lang['ressources_construction'] = array(
	"Bâtiments", // Buildings
		"Mine de métal",
		"Mine de cristal",
		"Synthétiseur de deutérium",
		"Centrale électrique solaire",
		"Centrale électrique de fusion",
		"Usine de robots",
		"Usine de nanites",
		"Chantier spatial",
		"Hangar de métal",
		"Hangar de cristal",
		"Réservoir de deutérium",
		"Laboratoire de recherche",
		"Terraformeur",
		"Dépôt de ravitaillement",
		"Silo de missiles",
		"Base lunaire",
		"Phalange de capteur",
		"Porte de saut spatial",
	"Technologies", // Technologies
		"Technologie espionnage",
		"Technologie ordinateur",
		"Technologie armes",
		"Technologie bouclier",
		"Technologie protection des vaisseaux",
		"Technologie énergie",
		"Technologie hyperespace",
		"Réacteur à combustion",
		"Réacteur à impulsion",
		"Propulsion hyperespace",
		"Technologie laser",
		"Technologie ions",
		"Technologies plasma",
		"Réseau de recherche intergalactique",
		"Technologie Expéditions",
	"Flottes", // Fleets
		"Petit transporteur",
		"Grand transporteur",
		"Chasseur léger",
		"Chasseur lourd",
		"Croiseur",
		"Vaisseau de bataille",
		"Vaisseau de colonisation",
		"Recycleur",
		"Sonde espionnage",
		"Bombardier",
		"Satellite solaire",
		"Destructeur",
		"Étoile de la mort",
		"Traqueur",
	"Défenses", // Defenses
		"Lanceur de missiles",
		"Artillerie laser légère",
		"Artillerie laser lourde",
		"Canon de Gauss",
		"Artillerie à ions",
		"Lanceur de plasma",
		"Petit bouclier",
		"Grand bouclier",
		"Missile interception",
		"Missile interplanétaire"
);

// Trading
$lang['ressources_trade'] = array(
	"Achat/vente de métal",
	"Achat/vente de cristal",
	"Achat/vente de deutérium",
	"Ressources en vol"
);

// Installation
$lang['ressources_xtense'] = "La compatibilité du mod Ressources avec le mod Xtense2 est installée !";
$lang['ressources_no_xtense'] = "Le mod Xtense2 n'est pas installé.\nLa compatibilité avec le mod Ressources ne sera donc pas installée !\nPensez à installer Xtense2 c'est pratique ;)";
$lang['ressources_xtense_rem'] = "La compatibilité du mod Ressources avec le mod Xtense2 est désinstallée !";

// Changelog
$lang['ressources_back'] = "Retour";
$lang['ressources_date_format'] = "d/m/y";
$lang['ressources_version'] = "Version";
$lang['ressources_legend'] = "[Fix] : supression d'un bug<br />".
	"[Add] : rajout d'une fonction<br />".
	"[Imp] : amélioration d'une fonction";
$lang['ressources_version_0.1'] = "- [Add] Affichage des ressources disponibles par planète en temps réel.<br />".
	"- [Add] Affichage de la production et des hangars par planète.<br />".
	"- [Add] Prise en compte des ressources cachées et des échanges prévus ou en cours.<br />".
	"- [Add] Calcul de la date possible de constructions en fonction des ressources disponibles et de la production.";
$lang['ressources_version_0.2'] = "- [Fix] Erreur mySQL à l'installation.<br />".
	"- [Fix] Quelques petits oublis.<br />".
	"- [Add] Texte alternatif sur les images.";
?>
