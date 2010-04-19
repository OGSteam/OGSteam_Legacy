<?php
/***************************************************************************
*	filename	: lang_french.php
*	package		: Mod Energie
*	version		: 0.8
*	desc.			: Liste des chaines pour la langue Française.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 26/08/2006
*	modified	: 09:54 05/09/2009
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['energy_energy'] = "&Eacute;nergie";
$lang['energy_mod'] = "Mod &Eacute;nergie";
$lang['energy_thousands_separator'] = " ";
$lang['energy_reset'] = "Cliquez pour r&eacute;initialiser";
$lang['energy_all_planets'] = "Prend en compte l&#39;&eacute;nergie gagn&eacute;e sur toutes les plan&egrave;tes";
$lang['energy_sort_prod'] = "Cliquez pour classer par moyen de production";
$lang['energy_means_prod'] = "Moyen de production";
$lang['energy_before'] = "Avant";
$lang['energy_after'] = "Apr&egrave;s";
$lang['energy_sort_energy'] = "Cliquez pour classer par &eacute;nergie gagn&eacute;e";
$lang['energy_gained_energy'] = "&Eacute;nergie gagn&eacute;e";
$lang['energy_cost'] = "Co&ucirc;t";
$lang['energy_sort_metal_cost'] = "Cliquez pour classer par co&ucirc;t en m&eacute;tal";
$lang['energy_M'] = "M&eacute;tal";
$lang['energy_sort_crystal_cost'] = "Cliquez pour classer par co&ucirc;t en cristal";
$lang['energy_C'] = "Cristal";
$lang['energy_sort_deut_cost'] = "Cliquez pour classer par co&ucirc;t en deut&eacute;rium";
$lang['energy_D'] = "Deut&eacute;rium";
$lang['energy_sort_unit_cost'] = "Cliquez pour classer par co&ucirc;t unitaire";
$lang['energy_M_short'] = "M";
$lang['energy_C_short'] = "C";
$lang['energy_D_short'] = "D";
$lang['energy_unit_cost'] = "Co&ucirc;t unitaire";
$lang['energy_ratio'] = "Rapport";
$lang['energy_ratio_help'] = "Utilis&eacute; pour calculer le co&ucirc;t unitaire";
$lang['energy_ratio_ressources'] = "Rapport entre les ressources :";
$lang['energy_officer_E'] = "Officier Ing&eacute;nieur";
$lang['energy_officer_E_help'] = "+10% d\'&eacute;nergie";
$lang['energy_using_officer_E'] = "J&#39;utilise l&#39;Officier Ing&eacute;nieur";
$lang['energy_not_FR_D'] = "Ne pas prendre en compte la consommation en deut&eacute;rium de la Centrale &eacute;lectrique de fusion";
$lang['energy_needed_energy'] = "&Eacute;nergie n&eacute;cessaire :";
$lang['energy_planet'] = "sur la plan&egrave;te";
$lang['energy_energy_available'] = "&Eacute;nergie disponible :";
$lang['energy_temperature'] = "Temp&eacute;rature:";
$lang['energy_from_level'] = "du niveau";
$lang['energy_to'] = "&agrave;";
$lang['energy_help'] = "Aide";
$lang['energy_max_SS_help'] = "0 = illimit&eacute;";
$lang['energy_max_SS'] = "Nombre maximal de Satellites solaires :";
$lang['energy_created_by'] = "Mod &Eacute;nergie v"./*$mod_version*/"%1\$s"." d&eacute;velopp&eacute; par "./*$creator_name*/"%2\$s";
$lang['energy_changelog'] = "Voir le "./*$changelog_link*/"%1\$s"."ChangeLog"./*end_link*/"</a>"." ou "./*$forum_link*/"%2\$s"."plus d&#39;informations"./*end_link*/"</a>";

// Buildings
$lang['energy_building_M'] = "Mine de m&eacute;tal";
$lang['energy_building_C'] = "Mine de cristal";
$lang['energy_building_D'] = "Synth&eacute;tiseur de deut&eacute;rium";
$lang['energy_building_SoP'] = "Centrale &eacute;lectrique solaire";
$lang['energy_building_FR'] = "Centrale &eacute;lectrique de fusion";
$lang['energy_building_T'] = "Terraformeur";

// Solar Satellite
$lang['energy_SS'] = "Satellites solaires";

// Technologies
$lang['energy_technology_En'] = "Technologie &Eacute;nergie";
$lang['energy_technology_G'] = "Technologie Graviton";

// Errors
$lang['energy_error'] = "erreur";
$lang['energy_no_FR'] = "pas de Centrale &eacute;lectrique de fusion";
$lang['energy_FR_too_small'] = "Centrale &eacute;lectrique de fusion pas assez d&eacute;velopp&eacute;e";
$lang['energy_SS_exceeded'] = "Nombre maximal de Satellites solaires d&eacute;pass&eacute;";

// Changelog
$lang['energy_back'] = "Retour";
$lang['energy_date_format'] = "d/m/y";
$lang['energy_version'] = "Version";
$lang['energy_legend'] = "[Fix] : supression d&#39;un bug<br />".
	"[Add] : rajout d&#39;une fonction<br />".
	"[Imp] : am&eacute;lioration d&#39;une fonction";
$lang['energy_version_0.2'] = "- [Imp] L&eacute;gers r&eacute;arrangements graphiques pour une meilleur lisibilit&eacute;.<br />".
	"- [Imp] Prise en compte de la consommation de deut&eacute;rium par la Centrale &eacute;lectrique de Fusion (en incluant le co&ucirc;t du Synth&eacute;tiseur de Deut&eacute;rium n&eacute;cessaire pour combler la consommation).<br />".
	"- [Add] Calcul du rapport optimum entre Centrale &eacute;lectrique Solaire et Centrale &eacute;lectrique de Fusion.<br />".
	"- [Add] Classement des r&eacute;sultats par co&ucirc;t en m&eacute;tal, cristal, deut ou co&ucirc;t unitaire.<br />".
	"- [Add] Choix de construction de plusieurs b&acirc;timents.";
$lang['energy_version_0.2b'] = "- [Fix] Calcul du meilleur rapport avec l&#39;ensemble des moyens de production erron&eacute;.<br />".
	"- [Imp] Classement des r&eacute;sultats par &eacute;nergie produite ou moyen de production.<br />".
	"- [Add] Lien sur le niveau actuel d&#39;un b&acirc;timent pour remettre &agrave; ce niveau.";
$lang['energy_version_0.3'] = "- [Imp] Nouvelle formule de production d&#39;&eacute;nergie de la Centrale &eacute;lectrique de Fusion avec la version 0.78a d&#39;ogame.";
$lang['energy_version_0.3b'] = "- [Fix] Mauvais fonctionnement du choix des plan&egrave;tes lorsqu&#39;il y a un &#39;trou&#39; entre deux plan&egrave;tes dans l&#39;espace personnel.";
$lang['energy_version_0.4'] = "- [Add] Prise en compte de l&#39;Ing&eacute;nieur.";
$lang['energy_version_0.5'] = "- [Fix] Prise en compte de l&#39;&eacute;nergie n&eacute;cessaire pour le Terraformeur et le Graviton erron&eacute;e.<br />".
	"- [Fix] Calcul de l&#39;&eacute;nergie produite par la Centrale &eacute;lectrique solaire erron&eacute;e.<br />".
	"- [Add] Nombre maximal de Satellites solaires r&eacute;glable.";
$lang['energy_version_0.6'] = "- [Add] Possibilit&eacute; de d&eacute;sactiver la prise en compte la consommation en deut&eacute;rium de la Centrale &eacute;lectrique de fusion.<br />".
	"- [Add] Rentabilit&eacute; de la technologie &eacute;nergie.";
$lang['energy_version_0.6b'] = "- [Fix] Bug &agrave; l&#39;installation ou mise &agrave; jour sur certains serveurs.<br />".
	"- [Add] Ic&ocirc;nes signalant la pr&eacute;sence d&#39;info-bulles.";
$lang['energy_version_0.7b'] = "- [Imp] Internationalisation.";
$lang['energy_version_0.8'] = "- [Add] Liens pour modifier facilement le niveau des constructions.<br />".
	"- [Add] Prise en compte des pourcentages des mines.";
?>
