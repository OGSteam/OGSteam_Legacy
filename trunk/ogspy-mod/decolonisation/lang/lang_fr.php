<?php
/***************************************************************************
*	filename	: lang_fr.php
*	package		: Mod Decolonization
*	version		: 0.7c
*	desc.			: Liste des chaines pour la langue Française.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 11/08/2006
*	modified	: 01:50 01/06/2009
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['decolo_nization'] = "D&eacute;colonisation";
$lang['decolo_nization_mod'] = "Mod D&eacute;colonisation";
$lang['decolo_thousands_separator'] = " ";
$lang['decolo_decimal_separator'] = ",";
$lang['decolo_name'] = "Nom";
$lang['decolo_coord'] = "Coordonn&eacute;es";
$lang['decolo_temp'] = "Temp&eacute;rature";
$lang['decolo_total'] = "Total";
$lang['decolo_subtotal'] = "Sous-total";
$lang['decolo_percent'] = "Pourcentage des points";
$lang['decolo_other'] = "Autre";
$lang['decolo_graph'] = "Proportion en points des differentes plan&egrave;tes";
$lang['decolo_graph_alt'] = "Pas de graphique disponible";
$lang['decolo_created_by'] = "Mod D&eacute;colonisation v"./*$mod_version*/"%1\$s d&eacute;velopp&eacute; par "./*$creator_name*/"%2\$s modifi&eacute; par "./*$modifier_name*/"%3\$s";
$lang['decolo_changelog'] = "Voir le "./*$changelog_link*/"%1\$sChangeLog</a> ou "./*$forum_link*/"%2\$splus d'informations</a>";

// Buildings
$lang['decolo_buildings_points'] = "Points B&acirc;timents";
$lang['decolo_moon_buildings_points'] = "Points B&acirc;timents Lune";
$lang['decolo_building_M'] = "Mine de m&eacute;tal";
$lang['decolo_building_C'] = "Mine de cristal";
$lang['decolo_building_D'] = "Synth&eacute;tiseur de deut&eacute;rium";
$lang['decolo_building_SoP'] = "Centrale &eacute;lectrique solaire";
$lang['decolo_building_FR'] = "Centrale &eacute;lectrique de fusion";
$lang['decolo_building_RF'] = "Usine de robots";
$lang['decolo_building_NF'] = "Usine de nanites";
$lang['decolo_building_S'] = "Chantier spatial";
$lang['decolo_building_MS'] = "Hangar de m&eacute;tal";
$lang['decolo_building_CS'] = "Hangar de cristal";
$lang['decolo_building_DT'] = "R&eacute;servoir de deut&eacute;rium";
$lang['decolo_building_RL'] = "Laboratoire de recherche";
$lang['decolo_building_T'] = "Terraformeur";
$lang['decolo_building_ML'] = "Silo de missiles";
$lang['decolo_building_AD'] = "D&eacute;p&ocirc;t de ravitaillement";
$lang['decolo_building_LB'] = "Base lunaire";
$lang['decolo_building_SPh'] = "Phalange de capteur";
$lang['decolo_building_JG'] = "Porte de saut spatial";

// Solar Satellite
$lang['decolo_SS'] = "Satellite solaire";

// Defense
$lang['decolo_defense_points'] = "Points D&eacute;fense";
$lang['decolo_moon_defense_points'] = "Points D&eacute;fense Lune";
$lang['decolo_defense_ML'] = "Lanceur de missiles";
$lang['decolo_defense_LL'] = "Artillerie laser l&eacute;g&egrave;re";
$lang['decolo_defense_HL'] = "Artillerie laser lourde";
$lang['decolo_defense_GC'] = "Canon de Gauss";
$lang['decolo_defense_IC'] = "Artillerie &agrave; ions";
$lang['decolo_defense_PC'] = "Lanceur de plasma";
$lang['decolo_defense_SSD'] = "Petit bouclier";
$lang['decolo_defense_LSD'] = "Grand bouclier";
$lang['decolo_defense_ABM'] = "Missile Interception";
$lang['decolo_defense_IM'] = "Missile Interplan&eacute;taire";

// Changelog
$lang['decolo_back'] = "Retour";
$lang['decolo_version'] = "Version";
$lang['decolo_legend'] = "[Fix] : supression d'un bug<br />".
	"[Add] : rajout d'une fonction<br />".
	"[Imp] : am&eacute;lioration d'une fonction";
$lang['decolo_version_0.2'] = "- [Fix] Calcul du sous-total des points d&eacute;fense prends en compte deux fois les lanceur de missiles.<br />".
	"- [Fix] Calcul des points de l'usine de robot erron&eacute;.<br />".
	"- [Fix] Calcul des points du terraformeur erron&eacute;.<br />".
	"- [Add] Points des b&acirc;timents et d&eacute;fense des lunes pris en compte.<br />".
	"- [Add] Sous-total par cat&eacute;gorie.<br />".
	"- [Add] ChangeLog.";
$lang['decolo_version_0.3'] = "- [Add] Nom des lunes.<br />".
	"- [Add] S&eacute;parateur des milliers.<br />".
	"- [Add] Pourcentage de points d'une plan&egrave;te (plus lune correspondante) par rapport au total de points.<br />".
	"- [Imp] Calcul des points b&acirc;timents en prenant en compte l'arrondi &agrave chaque niveau.";
$lang['decolo_version_0.3b'] = "- [Fix] Calcul du total de points des d&eacute;fenses des lunes erron&eacute;.";
$lang['decolo_version_0.4'] = "- [Imp] Suppression des colonnes des plan&egrave;tes non colonis&eacute;es.<br />".
	"- [Imp] Suppression des infos lune si aucune lune.";
$lang['decolo_version_0.5'] = "- [Fix] Correction de petites erreurs dans le code.<br />".
	"- [Imp] Retour &agrave l'ancien mode de calcul des points (avant la v0.3), moins gourmand en ressources.";
$lang['decolo_version_0.6'] = "- [Fix] Correction d'erreurs.<br />".
	"- [Add] Graphique de r&eacute;partition des points.<br />".
	"- [Add] Prise en compte du D&eacute;p&ocirc;t de Ravitaillement (uniquement pour OGSpy 3.05 et plus).";
$lang['decolo_version_0.7b'] = "- [Imp] Internationalisation.";
$lang['decolo_version_0.7c'] = "- [Fix] D&eacute;p&ocirc;t de Ravitaillement sur les lunes.<br />".
	"- [Imp] Am&eacute;lioration du code.";
?>
