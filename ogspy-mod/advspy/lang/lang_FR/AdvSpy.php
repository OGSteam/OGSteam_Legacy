<?php
/***************************************************************************
*	filename	: AdvSpy_Lang_fra.php
*	desc.		: AdvSpy, fichier de langue version Française
*	Author		: kilops - http://ogsteam.fr/
*	created		: 24/06/2008
***************************************************************************/
//=================================================================
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY')) die("Hacking attempt");
//=================================================================


// ================================================================
// ===================== AdvSpy's Internals =======================

$lang['DicOgame']['Text']['Spy']['start']="Matières premières sur "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['playerstart']=" (Joueur '"; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['playerend']="')";
$lang['DicOgame']['Text']['Spy']['lune']=" (Lune) "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['interlude']=" le "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['nolastseen']="Le scanner des sondes n'a pas détecté d'anomalies atmosphériques sur cette planète. Une activitée sur cette planète dans la derniére heure peut quasiment être exclue";
$lang['DicOgame']['Text']['Spy']['lastseenstart']="Le scanner des sondes a détecté des anomalies dans l'atmosphére de cette planète, indiquant qu'il y a eu une activitée sur cette planète dans les ";
$lang['DicOgame']['Text']['Spy']['lastseenend']=" dernières minutes.";
$lang['DicOgame']['Text']['Spy']['metal']="Métal:";
$lang['DicOgame']['Text']['Spy']['cristal']="Cristal:";
$lang['DicOgame']['Text']['Spy']['deut']="Deutérium:";
$lang['DicOgame']['Text']['Spy']['energie']="Energie:";
$lang['DicOgame']['Text']['Spy']['Fleet']="Flotte";
$lang['DicOgame']['Text']['Spy']['Def']="Défense";
$lang['DicOgame']['Text']['Spy']['Buildings']="Bâtiments";
$lang['DicOgame']['Text']['Spy']['Tech']="Recherche";
$lang['DicOgame']['Text']['Spy']['end']="Probabilité de destruction de la flotte d'espionnage :";


// ================================================================
// ======================BATIMENTS=================================
$lang['DicOgame']['Buildings'][0]['Name']="Mine de métal";
$lang['DicOgame']['Buildings'][1]['Name']="Mine de cristal";
$lang['DicOgame']['Buildings'][2]['Name']="Synthétiseur de deutérium";
$lang['DicOgame']['Buildings'][3]['Name']="Centrale électrique solaire";
$lang['DicOgame']['Buildings'][4]['Name']="Centrale électrique de fusion";
$lang['DicOgame']['Buildings'][5]['Name']="Usine de robots";
$lang['DicOgame']['Buildings'][6]['Name']="Usine de nanites";
$lang['DicOgame']['Buildings'][7]['Name']="Chantier spatial";
$lang['DicOgame']['Buildings'][8]['Name']="Hangar de métal";
$lang['DicOgame']['Buildings'][9]['Name']="Hangar de cristal";
$lang['DicOgame']['Buildings'][10]['Name']="Réservoir de deutérium";
$lang['DicOgame']['Buildings'][11]['Name']="Laboratoire de recherche";
$lang['DicOgame']['Buildings'][12]['Name']="Terraformeur";
$lang['DicOgame']['Buildings'][13]['Name']="Silo de missiles";
$lang['DicOgame']['Buildings'][14]['Name']="Base lunaire";
$lang['DicOgame']['Buildings'][15]['Name']="Phalange de capteur";
$lang['DicOgame']['Buildings'][16]['Name']="Porte de saut spatial";
$lang['DicOgame']['Buildings'][17]['Name']="Dépot de Ravitaillement";

// ================================================================
// ==================TECHNOLOGIES==================================
$lang['DicOgame']['Tech'][0]['Name']="Technologie Espionnage";
$lang['DicOgame']['Tech'][1]['Name']="Technologie Ordinateur";
$lang['DicOgame']['Tech'][2]['Name']="Technologie Armes";
$lang['DicOgame']['Tech'][3]['Name']="Technologie Bouclier";
$lang['DicOgame']['Tech'][4]['Name']="Technologie Protection des vaisseaux spatiaux";
$lang['DicOgame']['Tech'][5]['Name']="Technologie Energie";
$lang['DicOgame']['Tech'][6]['Name']="Technologie Hyperespace";
$lang['DicOgame']['Tech'][7]['Name']="Réacteur à combustion";
$lang['DicOgame']['Tech'][8]['Name']="Réacteur à impulsion";
$lang['DicOgame']['Tech'][9]['Name']="Propulsion hyperespace";
$lang['DicOgame']['Tech'][10]['Name']="Technologie Laser";
$lang['DicOgame']['Tech'][11]['Name']="Technologie Ions";
$lang['DicOgame']['Tech'][12]['Name']="Technologie Plasma";
$lang['DicOgame']['Tech'][13]['Name']="Réseau de recherche intergalactique";
$lang['DicOgame']['Tech'][14]['Name']="Technologie Astrophysique";
$lang['DicOgame']['Tech'][15]['Name']="Technologie Graviton";

// ================================================================
// ================FLOTTES=========================================
$lang['DicOgame']['Fleet'][0]['Name']='Petit transporteur';
$lang['DicOgame']['Fleet'][1]['Name']='Grand transporteur';
$lang['DicOgame']['Fleet'][2]['Name']='Chasseur léger';
$lang['DicOgame']['Fleet'][3]['Name']='Chasseur lourd';
$lang['DicOgame']['Fleet'][4]['Name']='Croiseur';
$lang['DicOgame']['Fleet'][5]['Name']='Vaisseau de bataille';
$lang['DicOgame']['Fleet'][6]['Name']='Vaisseau de colonisation';
$lang['DicOgame']['Fleet'][7]['Name']='Recycleur';
$lang['DicOgame']['Fleet'][8]['Name']='Sonde espionnage';
$lang['DicOgame']['Fleet'][9]['Name']='Bombardier';
$lang['DicOgame']['Fleet'][10]['Name']='Satellite solaire';
$lang['DicOgame']['Fleet'][11]['Name']='Destructeur';
$lang['DicOgame']['Fleet'][12]['Name']='Étoile de la mort';
$lang['DicOgame']['Fleet'][13]['Name']='Traqueur';

// ================================================================
// ==============DEFENSES==========================================
$lang['DicOgame']['Def'][0]['Name']='Lanceur de missiles';
$lang['DicOgame']['Def'][1]['Name']='Artillerie laser légère';
$lang['DicOgame']['Def'][2]['Name']='Artillerie laser lourde';
$lang['DicOgame']['Def'][3]['Name']='Canon de Gauss';
$lang['DicOgame']['Def'][4]['Name']='Artillerie à ions';
$lang['DicOgame']['Def'][5]['Name']='Lanceur de plasma';
$lang['DicOgame']['Def'][6]['Name']='Petit bouclier';
$lang['DicOgame']['Def'][7]['Name']='Grand bouclier';
$lang['DicOgame']['Def'][8]['Name']='Missile Interception';
$lang['DicOgame']['Def'][9]['Name']='Missile Interplanétaire';

// ================================================================
// ================================================================
// ça c'est plus en rapport avec les statistiques ...


$lang['FlatSpyElements']['spy_galaxy']['Name']='Galaxie';
$lang['FlatSpyElements']['spy_system']['Name']='Systéme';
$lang['FlatSpyElements']['spy_row']['Name']='Rang';
$lang['FlatSpyElements']['metal']['Name']='Métal présent';
$lang['FlatSpyElements']['cristal']['Name']='Cristal présent';
$lang['FlatSpyElements']['deut']['Name']='Deutérium présent';
$lang['FlatSpyElements']['energie']['Name']='Energie produite';
foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
	foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
		$lang['FlatSpyElements'][$valuesarray['PostVar']]['Name']=$valuesarray['Name'];
	}
}
$lang['FlatSpyElements']['PATATE']['Name']='Patate totale de la flotte';
$lang['FlatSpyElements']['PATATE_f']['Name']='Patate des vaisseaux';
$lang['FlatSpyElements']['PATATE_d']['Name']='Patate des défenses';
$lang['FlatSpyElements']['PATATE_Balance_f']['Name']='Pourcentage de Patate de la flotte';
$lang['FlatSpyElements']['PATATE_Balance_d']['Name']='Pourcentage de Patate de la défense';
$lang['FlatSpyElements']['TauxPatateVsCurrentAtk']['Name']='Chances de victoire';
$lang['FlatSpyElements']['ArmyRessources']['Name']='Ressources totale de la flotte';
$lang['FlatSpyElements']['ArmyRessources_f']['Name']='Ressources totale des vaisseaux';
$lang['FlatSpyElements']['ArmyRessources_d']['Name']='Ressources totale des défenses';
$lang['FlatSpyElements']['ArmyRessourcesD']['Name']='Ressources totale de la flotte (avec Deut)';
$lang['FlatSpyElements']['ArmyRessourcesD_f']['Name']='Ressources totale de la flotte (avec Deut)';
$lang['FlatSpyElements']['ArmyRessourcesD_d']['Name']='Ressources totale des défenses (avec Deut)';
$lang['FlatSpyElements']['GrandNombre']['Name']='Le plus Grand Nombre';
$lang['FlatSpyElements']['Transport_PT']['Name']='Nombre de PT nécessaires pour le transport';
$lang['FlatSpyElements']['Transport_GT']['Name']='Nombre de GT nécessaires pour le transport';

$lang['FlatSpyElements']['Raid_metal']['Name']='Métal à gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_cristal']['Name']='Cristal à gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_deut']['Name']='Deutérium à gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_total']['Name']='Ressources totales à gagner en raidant (1/2 du total)';

$lang['FlatSpyElements']['Raid2_metal']['Name']='Métal à gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_cristal']['Name']='Cristal à gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_deut']['Name']='Deutérium à gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_total']['Name']='Ressources totales à gagner en raidant 2 fois';

$lang['FlatSpyElements']['Raid3_metal']['Name']='Métal à gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_cristal']['Name']='Cristal à gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_deut']['Name']='Deutérium à gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_total']['Name']='Ressources totales à gagner en raidant 3 fois';

$lang['FlatSpyElements']['Raid_PT']['Name']='Nombre de PT nécessaires pour le raid';
$lang['FlatSpyElements']['Raid_GT']['Name']='Nombre de GT nécessaires pour le raid';
$lang['FlatSpyElements']['Ressources_total']['Name']='Total des ressources';
$lang['FlatSpyElements']['Raided']['Name']='Nombre de raids récents signalés';
$lang['FlatSpyElements']['Indice_PR']['Name']='Indice Patate/Ressources';


$lang['Liste_Tris']=array('1'=>'Date (récents en premier)',
							'2'=>'Date (vieux en premier)',
							'3'=>'Ressources total (&gt;)',
							'4'=>'Metal (&gt;)',
							'5'=>'Cristal (&gt;)',
							'6'=>'Deutérium (&gt;)',
							'7'=>'Flottes (en ressources) (&gt;)',
							'8'=>'Indice Patate/Ressource (&lt;)',
							'9'=>'PATATE Totale (&lt;)',
							'10'=>'PATATE Totale (&gt;)',
							'11'=>'PATATE- Vaisseaux (&lt;)',
							'12'=>'PATATE- Vaisseaux (&gt;)',
							'13'=>'PATATE- Défenses (&lt;)',
							'14'=>'PATATE- Défenses (&gt;)',
							'15'=>'Taux de Patate (&gt;)',
							'16'=>'Nombre de PT/GT (raid) (&gt;)',
							'17'=>'Coordonées (&lt;)',
							'18'=>'Coordonées (&gt;)',
							'19'=>'Scanner d`activité (&lt;)',
							'20'=>'Champ de ruines (&gt;)',
							'21'=>'Champ de ruines (&lt;)');



$lang['BlockRechercheElements']['ChercherOK']['Name']='Bouton Chercher';
$lang['BlockRechercheElements']['AdvSpy_TRIS']['Name']='Ordre de tris';
$lang['BlockRechercheElements']['AdvSpy_OnlyMyScan']['Name']='Uniquement mes RE';
$lang['BlockRechercheElements']['AdvSpy_SearchResult_Min']['Name']='Résultat min';
$lang['BlockRechercheElements']['AdvSpy_SearchResult_Max']['Name']='Résultat max';
$lang['BlockRechercheElements']['AdvSpy_GalaxyMin']['Name']='Galaxie Min';
$lang['BlockRechercheElements']['AdvSpy_GalaxyMax']['Name']='Galaxie Max';
$lang['BlockRechercheElements']['AdvSpy_SystemMin']['Name']='Systéme Min';
$lang['BlockRechercheElements']['AdvSpy_SystemMax']['Name']='Systéme Max';
$lang['BlockRechercheElements']['AdvSpy_RowMin']['Name']='Rang Min';
$lang['BlockRechercheElements']['AdvSpy_RowMax']['Name']='Rang Max';
$lang['BlockRechercheElements']['AdvSpy_CoordsToHide']['Name']='planètes cachées';
$lang['BlockRechercheElements']['AdvSpy_AgeMax']['Name']='Age Max du RE';
$lang['BlockRechercheElements']['AdvSpy_NoDoublon']['Name']='Pas de doublons';
$lang['BlockRechercheElements']['AdvSpy_ShowOnlyMoon']['Name']='Afficher que les lunes';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Fleet']['Name']='Flotte sondée';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Fleet']['Name']='Réduire les flottes';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Def']['Name']='Défenses sondées';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Def']['Name']='Réduire défenses';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Buildings']['Name']='Bâtiments sondés';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Buildings']['Name']='Réduire les bâtiments';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Tech']['Name']='Recherches sondées';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Tech']['Name']='Réduire les recherches';
$lang['BlockRechercheElements']['AdvSpy_OnlyInactif']['Name']='Seulement les inactifs';
$lang['BlockRechercheElements']['AdvSpy_PlayerSearch']['Name']='Nom de joueur';
$lang['BlockRechercheElements']['AdvSpy_AllySearch']['Name']='Nom d\'ally';
$lang['BlockRechercheElements']['AdvSpy_PlanetSearch']['Name']='Nom de planète';
$lang['BlockRechercheElements']['AdvSpy_SeuilGrandNombre']['Name']='Grand Nombre';
$lang['BlockRechercheElements']['AdvSpy_OnlyGrandNombre']['Name']='Seulement si Grand Nombre est dépassé';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinMetal']['Name']='Métal minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinCristal']['Name']='Cristal minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinDeut']['Name']='Deutérium minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinEnergie']['Name']='Energie minimum';
$lang['BlockRechercheElements']['AdvSpy_TauxPatateMini']['Name']='Chances de victoire minimum';
$lang['BlockRechercheElements']['AdvSpy_HideRaided']['Name']='Cacher les RE raidés';
$lang['BlockRechercheElements']['AdvSpy_OnlyRaided']['Name']='N\'afficher que les RE raidés';
$lang['BlockRechercheElements']['AdvSpy_RaidAgeMax']['Name']='Raids de moin de';
$lang['BlockRechercheElements']['AdvSpy_PatateTotalMin']['Name']='PATATE Min';
$lang['BlockRechercheElements']['AdvSpy_PatateTotalMax']['Name']='PATATE Max';

foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
	foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar']]['Name']=$valuesarray['Name'];
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Min']['Name']=$valuesarray['Name'].' Min';
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Max']['Name']=$valuesarray['Name'].' Max';
		if (strpos($valuesarray['PostVar'],'f_') === 0) {
			$lang['BlockRechercheElements']['AdvSpy_Sim_atk_'.$valuesarray['PostVar']]['Name']='[Simulateur]Attaque '.$valuesarray['Name'].'';
			$lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Name']='[Simulateur]Défense '.$valuesarray['Name'].'';
		}
		if (strpos($valuesarray['PostVar'],'d_') === 0) {
			$lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Name']='[Simulateur]Défense '.$valuesarray['Name'].'';
		}
	}
}

$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_armes']['Name']='[Simulateur]Attaque Tech Armes';
$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_bouclier']['Name']='[Simulateur]Attaque Tech Bouclier';
$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_protect']['Name']='[Simulateur]Attaque Tech Protection';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_armes']['Name']='[Simulateur]Défense Tech Armes';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_bouclier']['Name']='[Simulateur]Défense Tech Bouclier';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_protect']['Name']='[Simulateur]Défense Tech Protection';


$lang['BlockRechercheElements']['AdvSpy_SaveIdToLoad']['Name']='Numéro de sauvegarde';
$lang['BlockRechercheElements']['AdvSpy_SaveDelConfirmation']['Name']='Confirmation de suppression';
$lang['BlockRechercheElements']['AdvSpy_SaveNameToSave']['Name']='Nom de la sauvegarde';
$lang['BlockRechercheElements']['AdvSpy_SaveIsPublic']['Name']='Sauvegarde publique';
$lang['BlockRechercheElements']['AdvSpy_SaveIsDefault']['Name']='Sauvegarde générale';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Tris']['Name']='Sauvegarde du tris';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Secteur']['Name']='Sauvegarde du secteur';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_RE']['Name']='Sauvegarde des carracteristiques du RE';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Joueur']['Name']='Sauvegarde des critéres de joueurs';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Ressources']['Name']='Sauvegarde des critéres de ressources';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Analyse']['Name']='Sauvegarde des contraintes de Patate';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMFleet']['Name']='Sauvegarde de Recherche Plus Flotte';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMDef']['Name']='Sauvegarde de Recherche Plus Défenses';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMBuildings']['Name']='Sauvegarde de Recherche Plus Bâtiments';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMTech']['Name']='Sauvegarde de Recherche Plus Technologies';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk']['Name']='Sauvegarde du Simulateur Attaquant';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk_tech']['Name']='Sauvegarde du Simulateur Attaquant (tech)';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def']['Name']='Sauvegarde du Simulateur Défenseur';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def_tech']['Name']='Sauvegarde du Simulateur Défenseur (tech)';




// ===================================================================================================
// ===================================== OPTIONS =====================================================
// ===================================================================================================

$lang['Options']['RecycleDef']['Name']='Défenses dans débris (Uni40)';
$lang['Options']['RecycleDef']['Desc']='Prend en compte les débris des défenses pour le calcul du champ de ruines recyclable (Spécifique Uni 40 fr)';

$lang['Options']['HideCopyClipAlert']['Name']='Désactiver le message d`erreur de copie presse-papier';
$lang['Options']['HideCopyClipAlert']['Desc']='Permet de ne plus voir l`avertissement pour les cas où la copie automatique ne fonctionne pas (sous linux par ex)';

$lang['Options']['ExpressCopyClipRE']['Name']='Copie express des RE dans le Presse-Papier';
$lang['Options']['ExpressCopyClipRE']['Desc']='Si activé, le menu de copie de RE ne s\'affiche plus et tente de copier directement le RE \'Standard\' dans le presse-papier quand on click sur l\'icone';

$lang['Options']['ShowRaidsInPT']['Name']='Afficher le nombre de <b>Petits Transporteurs</b> pour les raids';
$lang['Options']['ShowRaidsInPT']['Desc']='Indique le nombre de PT nécessaires lors d`un raid à la place du nombre de GT';

$lang['Options']['BackgroundOpacity']['Name']='Opacité du fond grisé (de 0 à 100)';
$lang['Options']['BackgroundOpacity']['Desc']='Opacité du fond grisé 0=transparent 100=noir, Défaut: 50';

$lang['Options']['HideSimAlert']['Name']='Cacher l\'avertissement dans le simulateur de combat';
$lang['Options']['HideSimAlert']['Desc']='Si activé, le message d\'avertissement en haut de l\'onglet "Simulateur de combat" ne sera pas affiché';

$lang['Options']['CompactSpy']['Name']='Afficher le contenu des RE en colonnes';
$lang['Options']['CompactSpy']['Desc']='Si activé, les vaisseaux/def/batiments/tech seront affichés en tableau 2*2';

$lang['Options']['SeparateurDeMilliers']['Name']='Séparateur de milliers';
$lang['Options']['SeparateurDeMilliers']['Desc']='Caractére utilisé pour ponctuer les nombres à chaque milliers ex: 123.456.789 (Par défaut \'.\' ou rien pour ne pas avoir de séparateur) --- Celà affecte l\'affichage des RE dans AdvSpy, et les RE copiés dans le presse-papier avec BBCode seulement';

$lang['Options']['SearchResult_DefaultMax']['Name']='Nombre max de résultat par page';
$lang['Options']['SearchResult_DefaultMax']['Desc']='Nombre maximum de Rapport d\'Espionnage à afficher par défaut sur chaque page (Défaut: 20)';



// ===================================================================================================
// ===================================== User Interface ==============================================
// ===================================================================================================

// Each button must have it's own value, never put the same string twice !! (and respect html syntax)
$lang['UI_Lang']['BT_Search']="-- Chercher --";
$lang['UI_Lang']['BT_Sim']="-- Valider --";
$lang['UI_Lang']['BT_Load']="-- LOAD --";
$lang['UI_Lang']['BT_Save']="-- SAVE --";
$lang['UI_Lang']['BT_Del']="-!- SUPPRESSION -!-";
$lang['UI_Lang']['BT_Admin']="- ! -";
$lang['UI_Lang']['BT_OptSubmit']="Valider ces options";
$lang['UI_Lang']['BT_OptRefresh']="Actualiser les options";

$lang['UI_Lang']['Loging_NewSearch']="Nouvelle recherche";
$lang['UI_Lang']['Loging_NewSim']="Nouvelle simulation";
$lang['UI_Lang']['Loging_OpeningAdvSpy']="Ouverture d'AdvSpy";

$lang['UI_Lang']['UsedMemory']="Mémoire utilisée:";
$lang['UI_Lang']['WeekAsName']="Semaine";
$lang['UI_Lang']['DayAsName']="Jour";
$lang['UI_Lang']['TrailingLetterForPlurial']="s"; // Trailing letter for plurial week or day (one week, two weeks) "s" is added at the end. If none in your language, put "".
$lang['UI_Lang']['HourAsLetter']="H";
$lang['UI_Lang']['MinuteAsLetter']="M";
$lang['UI_Lang']['SecondAsLetter']="S";

$lang['UI_Lang']['Error_InvalidChar']="Erreur! Ne pas utiliser le charactére :";
$lang['UI_Lang']['Error_InvalidInput']="Erreur! Saisie invalide dans";

$lang['UI_Lang']['OptionIsYes']="Oui / Activé";
$lang['UI_Lang']['OptionIsNo']="Non / Désactivé";

$lang['UI_Lang']['CloseMsgText']="Fermer ce message";


$lang['UI_Lang']['SearchPlus']="Recherche PLUS";
$lang['UI_Lang']['SearchPlus_TooltipTitle']="Info";
$lang['UI_Lang']['SearchPlus_TooltipText']="Clique ici pour voir des options de recherche supplémentaires (nombre de vaisseaux)";


$lang['UI_Lang']['Tab_SearchResult_Text']="Résultat de la recherche.";
$lang['UI_Lang']['Tab_SearchResult_Title']="Click pour voir le résultat de la recherche";

$lang['UI_Lang']['Tab_Sim_Text']="Simulateur de combat.";
$lang['UI_Lang']['Tab_Sim_Title']="Click pour voir le simulateur";

$lang['UI_Lang']['Tab_Stats_Text']="Statistiques";
$lang['UI_Lang']['Tab_Stats_Title']="Click pour voir les statistiques de cette recherche";

$lang['UI_Lang']['Tab_SaveLoad_Text']="Save/Load";
$lang['UI_Lang']['Tab_SaveLoad_Title']="Click pour voir le menu de sauvegarde / chargement";

$lang['UI_Lang']['Tab_Options_Text']="Options";
$lang['UI_Lang']['Tab_Options_Title']="Click pour voir les options";

$lang['UI_Lang']['Tab_Admin_Text']="Administration";
$lang['UI_Lang']['Tab_Admin_Title']="Click pour voir le panneau d'administration";


$lang['UI_Lang']['PatateLegendHeader']="Le taux de PATATE représente les chances de gagner le raid avec";
$lang['UI_Lang']['PatateLegendMyFleet']="Ma flotte";
$lang['UI_Lang']['PatateDefeat']="-Défaite-"; // (MUST BE 9-11 CHAR LONG)
$lang['UI_Lang']['PatateDraw']="-Nul-"; // (MUST BE 5-6 CHAR LONG)
$lang['UI_Lang']['PatateWin']="-Victoire-"; // (MUST BE 9-11 CHAR LONG)
$lang['UI_Lang']['PatateLegendFooter']="De 0% à 50% = Défaite.<br/>De 50% à 80% = Match nul.<br/>De 80% à 90% = Victoire.<br/>De 90% à 100% = Victoire totale.<br/>";


$lang['UI_Lang']['Tab_FrontPage_Title']="Bienvenue dans -AdvSpy-";
$lang['UI_Lang']['Tab_FrontPage_Define1']="Ce mod permet de faire des recherches parmis les Rapports d'Espionnage (RE ou R.E.) présents dans la base de donnée.";

$lang['UI_Lang']['Tab_FrontPage_Help1']="Les critéres de recherche sont à définir dans le menu de gauche.";

$lang['UI_Lang']['Tab_FrontPage_Help2A']="La "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help2B']="Recherche PLUS";
$lang['UI_Lang']['Tab_FrontPage_Help2C']=" permet de définir avec précision le minimum et maximum desiré pour chaques vaisseaux/défenses/batiments/technologies."; // (keep leading space)

$lang['UI_Lang']['Tab_FrontPage_Help3A']="Le "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help3B']="Résultat de la recherche";
$lang['UI_Lang']['Tab_FrontPage_Help3C']=" affiche les RE avec une mise en forme, des informations connexes supplémentaires et des outils afin de gérer au mieux vos campagnes de raid."; // (keep leading space)

$lang['UI_Lang']['Tab_FrontPage_Help4A']="De "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help4B']="nombreuses Statistiques";
$lang['UI_Lang']['Tab_FrontPage_Help4C']=" sont calculées sur la base des rapports affichés. (Vous devez avoir un résultat à votre recherche)"; // (keep leading space)

$lang['UI_Lang']['Tab_FrontPage_Help5A']="Le "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help5B']="Simulateur de Combat";
$lang['UI_Lang']['Tab_FrontPage_Help5C']=" permet de renseigner votre flotte attaquante, n'oubliez pas de renseigner cette partie pour bénéficier des options d'affichage et de recherche basés sur les chances de victoire de votre flotte (Patate)."; // (keep leading space)

$lang['UI_Lang']['Tab_FrontPage_Help6A']="La partie "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help6B']="Save / Load";
$lang['UI_Lang']['Tab_FrontPage_Help6C']=" permet de sauvegarder ou charger des CRITERES DE RECHERCHE et/ou les flottes du simulateur<br/>
Lorsque vous Chargez une sauvegarde, seul les elements présents dans la sauvegarde remplacent vos paramétres de recherche actuels.<br/>
Vous pouvez donc Enregistrer ou Charger séparément les paramétres de la recherche et une ou plusieurs sauvegardes de flottes.";

$lang['UI_Lang']['Tab_FrontPage_Help7A']="Enfin, l'onglet "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help7B']="Options";
$lang['UI_Lang']['Tab_FrontPage_Help7C']=" vous permet de changer certains parametres d'AdvSpy (en fonction des restrictions)."; // (keep leading space)

$lang['UI_Lang']['Tab_FrontPage_Help8A']="Si vous rencontrez un bug, venez le signaler "; // (keep trailing space)
$lang['UI_Lang']['Tab_FrontPage_Help8B']="sur le forum dédié sur le site de l'OGSTeam";
$lang['UI_Lang']['Tab_FrontPage_Help8C']="Vous pouvez aussi venir y témoigner de hô combien ce mod vous change la vie (euh, les raid), ou alors proposer encore plus de fonctions parsque toujours plus, c'est toujours mieux.";

$lang['UI_Lang']['Tab_FrontPage_Help9']="Bon raids à vous !";



$lang['UI_Lang']['ClipboardCopyAlert_Title']="** Informations sur la compatibilité entre Firefox et l'autocopie";

$lang['UI_Lang']['ClipboardCopyAlert_Text']="La fonction de copie automatique est compatible Internet Explorer et Firefox
(probablement d'autres navigateurs basés sur Netscape également).
<p>Sous Internet Explorer pas de configuration nécessaire (à part activer le java
script).</p><br/>
<p>Sous Firefox, le navigateur est configuré par défaut pour refuser toute sorte
d'accés aux données locales (dont le presse papier).<br>
La manipulation suivante vous permet d'activer ces accés : à chaque script un
message vous demande si vous donnez l'autorisation à ce script de s'exécuter.<br>
Vous avez la possibilité de cocher &quot;Toujours accepter les scripts de ce site...&quot;
pour ne pas voir ce message à chaque copie de rapport d'espionnage.</p>
<ol>
	<li><a href='about:blank' target='_new'>Ouvrez une nouvelle fenêtre</a> : <font face=\"Fixedsys\">Ctrl + N</font>&nbsp;&nbsp;
	-&nbsp; Ou un nouvel Onglet : <font face=\"Fixedsys\">Ctrl + T</font></li>
	<li>Tapez cette adresse puis 'Go' : <b> <font face=\"Fixedsys\">about:config</font></b> (comme n'importe quelle
	adresse de site)</li>
	<li>En haut de cette page, dans la zone de recherche tapez : <b>
	<font face=\"Fixedsys\">signed</font></b></li>
	<li>Maintenant vous ne voyez qu'une seule ligne appelée '<font face=\"Fixedsys\">signed.applets.codebase_principal_support</font>'
	avec comme valeure : 'false' (ou faux)</li>
	<li>Double-cliquez sur cette ligne : le texte se met en gras et la valeur
	deviens 'true' (ou vrais).</li>
	<li>Voilà ! Vous pouvez fermer cette fenêtre, maintenant un message vous
	demanderas avant d'exécuter les scripts, vous donnant la possibilité
	d'accepter ou de refuser.</li>
</ol>";



$lang['UI_Lang']['HSR_ToolTip_System_1']="Voir le systéme [";
$lang['UI_Lang']['HSR_ToolTip_System_2']=":xx] dans la vue 'Galaxie' de OGSpy";

$lang['UI_Lang']['HSR_ToolTip_Duration1']="Il y a ";
$lang['UI_Lang']['HSR_ToolTip_Duration2']=""; // ago

$lang['UI_Lang']['HSR_ToolTip_Metal']="Définir Métal Minimum : ";
$lang['UI_Lang']['HSR_ToolTip_Cristal']="Définir Cristal Minimum : ";
$lang['UI_Lang']['HSR_ToolTip_Deut']="Définir Deutérium Minimum : ";
$lang['UI_Lang']['HSR_ToolTip_Engergie']="Définir Energie Minimum : ";


$lang['UI_Lang']['Tab_NoSearch1']="Aucune recherche donc aucun resultat ;)";
$lang['UI_Lang']['Tab_NoSearch2']="N'oubliez pas de renseigner ";
$lang['UI_Lang']['Tab_NoSearch3']="votre flotte et vos technologies";
$lang['UI_Lang']['Tab_NoSearch4']=" pour bénéficier des options d'affichage et de recherche en fonction des chances de réussite du raid (Taux de Patate).";


$lang['UI_Lang']['Tab_SL_NewSave']="Nouvelle sauvegarde :";
$lang['UI_Lang']['Tab_SL_Error_PrivateMode']="Seul les admins peuvent enregistrer une sauvegarde générale, passage en mode privé.";
$lang['UI_Lang']['Tab_SL_Error_PublicMode']="Desolé, mais tu ne peut pas faire de sauvegarde publique (en plus t'es pas sensé voir ce message donc arrete d'essayer de hacker le serveur)";
$lang['UI_Lang']['Tab_SL_Error_PublicMode_Log']="L'utilisateur a un comportement suspect : Tentative de sauvegarde publique sans avoir les droits adéquats";

$lang['UI_Lang']['Tab_SL_Error_ShortName']="Une sauvegarde doit avoir un nom d'au moins 3 charactéres (sinon ça veux rien dire)";


$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";
$lang['UI_Lang']['Tab_SL_']="";

$lang['UI_Lang']['Raidalert_Error1']="RaidAlert: Galaxy, System ou Row ne sont pas des nombres entiers";
$lang['UI_Lang']['Raidalert_Moon']="Lune ";
$lang['UI_Lang']['Raidalert_Planet']="planète ";
$lang['UI_Lang']['Raidalert_LogNewRaid']="Nouveau raid sur";
$lang['UI_Lang']['Raidalert_LogShowRaids']="Affichage des raids sur";
$lang['UI_Lang']['Raidalert_RaidOwner']="Raideur";
$lang['UI_Lang']['Raidalert_RaidDate']="Date du Raid";
$lang['UI_Lang']['Raidalert_RaidETime']="Temps écoulé depuis ce Raid";
$lang['UI_Lang']['Raidalert_Raided']="Raidé";
$lang['UI_Lang']['Raidalert_RaidBT']="Raider !";


$lang['UI_Lang']['NoPrintReason']['AdvSpy_NoDoublon']='Doublons d\'une même planète';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_CoordsToHide']='Coordonées temporairement cachées';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_PlayerSearch']='N\'est pas le joueur recherché';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_AllySearch']='N\'est pas l\'alliance recherchée';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_PlanetSearch']='N\'est pas le nom de planète recherché';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_OnlyGrandNombre']='Ne dépasse pas le seuil \'Grand Nombre\' ';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_RessourceMetal']='Pas assé de Métal';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_RessourceCristal']='Pas assé de Cristal';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_RessourceDeut']='Pas assé de Deutérium';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_RessourceEnergie']='Pas assé de d\'énergie';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_TauxPatateMini']='Chances de victoire trop faible';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_PatateTotalMin']='Pas assé de puissance de feu';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_PatateTotalMax']='Trop de puissance de feu';
$lang['UI_Lang']['NoPrintReason']['Hide_Allied']='Joueur allié';
$lang['UI_Lang']['NoPrintReason']['Hide_AllyProtected']='Alliance alliée';
$lang['UI_Lang']['NoPrintReason']['customlist_player']='Joueur caché';
$lang['UI_Lang']['NoPrintReason']['customlist_allytag']='Alliance cachée';
$lang['UI_Lang']['NoPrintReason']['customlist_coord']='Coordonées cachées';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_HideRaided']='planète raidée';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_OnlyRaided']='planète non-raidée';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_BFTD_min']='Batiments,Flotte,Tech,Def trop petit';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_BFTD_max']='Batiments,Flotte,Tech,Def trop grand';
$lang['UI_Lang']['NoPrintReason']['AdvSpy_ShowOnlyMoon']='N\'est pas une lune';
$lang['UI_Lang']['NoPrintReason']['Autre_Page']='Se trouve sur les pages suivantes/précédentes';



$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";
$lang['UI_Lang']['']="";



?>