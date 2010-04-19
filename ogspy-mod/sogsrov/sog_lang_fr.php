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
$lang['menu.credits'] = "- Cr�dits -";


// normalement vous ne devriez pas avoir besoin de changer �a,
// sauf si ogame change.fr ses phrases,
// ou si vous voulez utiliser ce script sur un ogame de langue diff�rente
$lang['parse.resources'] = 'Mati�res premi�res sur ';
$lang['parse.at'] = "le";
$lang['parse.metal'] = 'M�tal:';
$lang['parse.crystal'] = 'Cristal:';
$lang['parse.deuterium'] = 'Deut�rium:';
$lang['parse.energy'] = 'Energie:';
$lang['parse.fleet'] = 'Flotte';
$lang['parse.defense'] = 'D�fense';
$lang['parse.buildings'] = 'B�timents';
$lang['parse.research'] = 'Recherche';
$lang['parse.chance'] = 'Probabilit� de destruction de la flotte d\'espionnage :';
$lang['parse.priority'] = 'Priorit�';
$lang['parse.moon'] = 'lune';


$lang['admin.title'] = "Administration";
$lang['admin.restrict_re'] = "Importer uniquement les rapports upload�s";
$lang['admin.error'] = "Seul les administrateurs peuvent avoir acc�s � cette page.<br />";

$lang['options.pref'] = "Pr�f�rences d'affichage";
$lang['options.language'] = "Langue OGame";
$lang['options.menu'] = "Menu de contr�le";
$lang['options.left'] = "gauche";
$lang['options.right'] = "droite";
$lang['options.reports_per_page'] = "Rapports par page";
/**
* $lang['(0 for all)'] = "(0 pour tous)";
*/
$lang['options.default_color'] = "Couleur par d�faut";
$lang['options.critical_limit_color'] = "Couleur seuil critique";
$lang['options.moon_color'] = "Couleur pour lune";
/**
* $lang['Can be empty for no color'] = "Pour ceci, vous pouvez laisser vide pour n'utiliser aucune couleur";
*/
$lang['options.low_priority_color'] = "Couleur priorit� basse";
$lang['options.normal_priority_color'] = "Couleur priorit� normale";
$lang['options.high_priority_color'] = "Couleur priorit� haute";
$lang['options.min_metal'] = "Seuil m�tal";
$lang['options.min_crystal'] = "Seuil cristal";
$lang['options.min_deuterium'] = "Seuil deut�rium";
$lang['options.min_energy'] = "Seuil �nergie";
$lang['options.min_fleet'] = "Seuil Flotte";
$lang['options.min_defense'] = "Seuil D�fense";
$lang['options.min_buildings'] = "Seuil B�timents";
$lang['options.min_research'] = "Seuil Recherche";
$lang['options.order_by'] = "Classement selon";
$lang['options.order_by_metal'] = "la quantit� de m�tal";
$lang['options.order_by_crystal'] = "la quantit� de cristal";
$lang['options.order_by_deuterium'] = "la quantit� de deut�rium";
$lang['options.order_by_energy'] = "la quantit� d'�nergie";
$lang['options.order_by_total'] = "la somme des ressources";
$lang['options.order_by_position'] = "la position de la plan�te/lune";
$lang['options.order_by_priority'] = "la priorit� du rapport";
$lang['options.default'] = "Valeurs par d�faut";

$lang['credits'] = "Cr�dits";
$lang['credits.version'] = "version %s par";
$lang['credits.more_info'] = "Pour le t�l�chargement, les questions, les id�es<br />et suggestions, c'est sur le";
$lang['credits.board'] = "forum officiel";
$lang['credits.create_by'] = "SOGSROV est un logiciel cr�� � l'origine par Stalkr";
$lang['credits.update'] = "J'ai repris et am�lior� � ma convenance ce programme.";
$lang['credits.official_version'] = "Pour plus de renseignement sur la version originale, c'est";
$lang['credits.here'] = "par ici";




// langue de l'interface
$lang['refresh page'] = "rafra�chir";
$lang['Spy reports'] = "Rapports d'espionnage";
$lang['Show reports of'] = "Afficher les rapports de";
$lang['all galaxies'] = "toutes les galaxies";
$lang['the galaxy x only'] = "la galaxie %s uniquement";

$lang['Import OGSpy reports'] = "Importation rapports OGSpy";
$lang['Import all'] = "tout importer";
$lang['only'] = "uniquement";
$lang['from galaxy'] = "la galaxie";
$lang['to'] = "�";
$lang['from system'] = "du syst�me";
$lang['of max'] = "d'au plus";
$lang['hours old'] = "heures d'anciennet�";
$lang['Import from OGSpy'] = "Importer � partir d'OGSpy";
/**
* $lang['OGSpy cannot import.explain'] = "Pour pouvoir importer les rapports d'espionnage de votre serveur OGSpy, vous devez renseigner dans la configuration de SOGSROV les informations de connexion � la base de donn�e de votre serveur OGSpy.";
*/



$lang['Delete selected'] = "Effacer s�lectionn�s";
$lang['Delete unselected'] = "Effacer non s�lectionn�s";
$lang['Delete fleet'] = "Effacer flotte > %d";
$lang['Delete defense'] = "Effacer d�fense > %d";
$lang['Delete all fleet'] = "Effacer toutes les flottes";
$lang['Delete all defense'] = "Effacer toutes les d�fenses";
$lang['Delete displayed'] = "Effacer affich�s";
$lang['Delete all'] = "Effacer tous";
$lang['Delete one'] = "Effacer";
$lang['Delete one.explain'] = "Effacer ce message";
$lang['submit delete messages'] = "ok";
$lang['Order by2'] = "Classer par : ";
$lang['Order by metal'] = "M";
$lang['Order by metal.explain'] = "Classe selon les plan�tes/lunes qui ont le plus de m�tal";
$lang['Order by crystal'] = "C";
$lang['Order by crystal.explain'] = "Classe selon les plan�tes/lunes qui ont le plus de cristal";
$lang['Order by deuterium'] = "D";
$lang['Order by deuterium.explain'] = "Classe selon les plan�tes/lunes qui ont le plus de deut�rium";
$lang['Order by total'] = "total";
$lang['Order by total.explain'] = "Classe selon les plan�tes/lunes qui ont le plus de ressources (m�tal+cristal+deut�rium)";
$lang['Order by position'] = "position";
$lang['Order by position.explain'] = "Classe selon la position de la plan�te/lune";
$lang['Order by priority'] = "priorit�";
$lang['Order by priority.explain'] = "Classe selon la priorit� du rapport";

$lang['x for the galaxy y'] = "%s pour la galaxie %s";
$lang['total reports: x'] = "%s au total";
$lang['previous page'] = "&lt;- Pr�c.";
$lang['previous page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
$lang['next page'] = "Suiv. -&gt;";
$lang['next page.blank.length'] = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";

$lang['Action'] = "Action";
$lang['Date'] = "Date";
$lang['Player'] = "Joueur";

$lang['OGSpy.information not available.explain'] = "Information indisponible sur le serveur OGSpy : pensez � mettre r�guli�rement la galaxie � jour pour y rem�dier.";
$lang['low'] = "basse";
$lang['normal'] = "normale";
$lang['high'] = "haute";
$lang['total resources'] = "Total ressources:";

?>