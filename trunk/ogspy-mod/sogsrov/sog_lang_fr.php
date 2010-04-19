<?php
/**
* sogsrov_lang_fr.php : Fichier de langue fr du module SOGSROV
* @author tsyr2ko <tsyr2ko-sogsrov@yahoo.fr>
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
* @version 0.33
* @package Sogsrov
*/

$lang['menu.options'] = "- Options -";
$lang['menu.admin'] = "- Administration -";
$lang['menu.credits'] = "- Crédits -";


// normalement vous ne devriez pas avoir besoin de changer ça,
// sauf si ogame change.fr ses phrases,
// ou si vous voulez utiliser ce script sur un ogame de langue différente
$lang['parse.resources'] = 'Matières premières sur ';
$lang['parse.at'] = "le";
$lang['parse.metal'] = 'Métal:';
$lang['parse.crystal'] = 'Cristal:';
$lang['parse.deuterium'] = 'Deutérium:';
$lang['parse.energy'] = 'Energie:';
$lang['parse.fleet'] = 'Flotte';
$lang['parse.defense'] = 'Défense';
$lang['parse.buildings'] = 'Bâtiments';
$lang['parse.research'] = 'Recherche';
$lang['parse.chance'] = 'Probabilité de destruction de la flotte d\'espionnage :';
$lang['parse.priority'] = 'Priorité';
$lang['parse.moon'] = 'lune';


$lang['admin.title'] = "Administration";
$lang['admin.restrict_re'] = "Importer uniquement les rapports uploadés";
$lang['admin.error'] = "Seul les administrateurs peuvent avoir accès à cette page.<br />";

$lang['options.pref'] = "Préférences d'affichage";
$lang['options.language'] = "Langue OGame";
$lang['options.menu'] = "Menu de contrôle";
$lang['options.left'] = "gauche";
$lang['options.right'] = "droite";
$lang['options.reports_per_page'] = "Rapports par page";
/**
* $lang['(0 for all)'] = "(0 pour tous)";
*/
$lang['options.default_color'] = "Couleur par défaut";
$lang['options.critical_limit_color'] = "Couleur seuil critique";
$lang['options.moon_color'] = "Couleur pour lune";
/**
* $lang['Can be empty for no color'] = "Pour ceci, vous pouvez laisser vide pour n'utiliser aucune couleur";
*/
$lang['options.low_priority_color'] = "Couleur priorité basse";
$lang['options.normal_priority_color'] = "Couleur priorité normale";
$lang['options.high_priority_color'] = "Couleur priorité haute";
$lang['options.min_metal'] = "Seuil métal";
$lang['options.min_crystal'] = "Seuil cristal";
$lang['options.min_deuterium'] = "Seuil deutérium";
$lang['options.min_energy'] = "Seuil énergie";
$lang['options.min_fleet'] = "Seuil Flotte";
$lang['options.min_defense'] = "Seuil Défense";
$lang['options.min_buildings'] = "Seuil Bâtiments";
$lang['options.min_research'] = "Seuil Recherche";
$lang['options.order_by'] = "Classement selon";
$lang['options.order_by_metal'] = "la quantité de métal";
$lang['options.order_by_crystal'] = "la quantité de cristal";
$lang['options.order_by_deuterium'] = "la quantité de deutérium";
$lang['options.order_by_energy'] = "la quantité d'énergie";
$lang['options.order_by_total'] = "la somme des ressources";
$lang['options.order_by_position'] = "la position de la planète/lune";
$lang['options.order_by_priority'] = "la priorité du rapport";
$lang['options.default'] = "Valeurs par défaut";

$lang['credits'] = "Crédits";
$lang['credits.version'] = "version %s par";
$lang['credits.more_info'] = "Pour le téléchargement, les questions, les idées<br />et suggestions, c'est sur le";
$lang['credits.board'] = "forum officiel";
$lang['credits.create_by'] = "SOGSROV est un logiciel créé à l'origine par Stalkr";
$lang['credits.update'] = "J'ai repris et amélioré à ma convenance ce programme.";
$lang['credits.official_version'] = "Pour plus de renseignement sur la version originale, c'est";
$lang['credits.here'] = "par ici";




// langue de l'interface
$lang['refresh page'] = "rafraîchir";
$lang['Spy reports'] = "Rapports d'espionnage";
$lang['Show reports of'] = "Afficher les rapports de";
$lang['all galaxies'] = "toutes les galaxies";
$lang['the galaxy x only'] = "la galaxie %s uniquement";

$lang['Import OGSpy reports'] = "Importation rapports OGSpy";
$lang['Import all'] = "tout importer";
$lang['only'] = "uniquement";
$lang['from galaxy'] = "la galaxie";
$lang['to'] = "à";
$lang['from system'] = "du système";
$lang['of max'] = "d'au plus";
$lang['hours old'] = "heures d'ancienneté";
$lang['Import from OGSpy'] = "Importer à partir d'OGSpy";
/**
* $lang['OGSpy cannot import.explain'] = "Pour pouvoir importer les rapports d'espionnage de votre serveur OGSpy, vous devez renseigner dans la configuration de SOGSROV les informations de connexion à la base de donnée de votre serveur OGSpy.";
*/



$lang['Delete selected'] = "Effacer sélectionnés";
$lang['Delete unselected'] = "Effacer non sélectionnés";
$lang['Delete fleet'] = "Effacer flotte > %d";
$lang['Delete defense'] = "Effacer défense > %d";
$lang['Delete all fleet'] = "Effacer toutes les flottes";
$lang['Delete all defense'] = "Effacer toutes les défenses";
$lang['Delete displayed'] = "Effacer affichés";
$lang['Delete all'] = "Effacer tous";
$lang['Delete one'] = "Effacer";
$lang['Delete one.explain'] = "Effacer ce message";
$lang['submit delete messages'] = "ok";
$lang['Order by2'] = "Classer par : ";
$lang['Order by metal'] = "M";
$lang['Order by metal.explain'] = "Classe selon les planètes/lunes qui ont le plus de métal";
$lang['Order by crystal'] = "C";
$lang['Order by crystal.explain'] = "Classe selon les planètes/lunes qui ont le plus de cristal";
$lang['Order by deuterium'] = "D";
$lang['Order by deuterium.explain'] = "Classe selon les planètes/lunes qui ont le plus de deutérium";
$lang['Order by total'] = "total";
$lang['Order by total.explain'] = "Classe selon les planètes/lunes qui ont le plus de ressources (métal+cristal+deutérium)";
$lang['Order by position'] = "position";
$lang['Order by position.explain'] = "Classe selon la position de la planète/lune";
$lang['Order by priority'] = "priorité";
$lang['Order by priority.explain'] = "Classe selon la priorité du rapport";

$lang['x for the galaxy y'] = "%s pour la galaxie %s";
$lang['total reports: x'] = "%s au total";
$lang['previous page'] = "&lt;- Préc.";
$lang['previous page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
$lang['next page'] = "Suiv. -&gt;";
$lang['next page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";

$lang['Action'] = "Action";
$lang['Date'] = "Date";
$lang['Player'] = "Joueur";

$lang['OGSpy.information not available.explain'] = "Information indisponible sur le serveur OGSpy : pensez à mettre régulièrement la galaxie à jour pour y remédier.";
$lang['low'] = "basse";
$lang['normal'] = "normale";
$lang['high'] = "haute";
$lang['total resources'] = "Total ressources:";

?>