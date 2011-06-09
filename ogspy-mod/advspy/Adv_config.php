<?php
/***************************************************************************
*	filename	: config.php pour AdvSpy v0.9 et +
*	Author		: kilops - http://ogs.servebbs.net/
***************************************************************************/
//================= Securité == ne pas toucher ! ==================
if (!defined('IN_SPYOGAME')) die("Hacking attempt");
if (!defined('IN_MOD_ADVSPY')) die("Hacking attempt");
//=================================================================


// ================================================================
// ====================== CONFIGURATION ===========================
// ========================================================touchez!

// TRUE = les ally protégées seront cachées lors des recherches. -sauf pour les admins- (voir configuration OGSpy).
// FALSE si vous ne voulez pas les cacher. (mais une alerte s'afficheras quand meme à  coté du R.E.)
$AdvSpyConfig['protection']['Hide_Protected']=TRUE;

// TRUE = les ally amies seront cachées lors des recherches. -sauf pour les admins- (voir configuration OGSpy).
// FALSE si vous ne voulez pas les cacher. (mais une alerte s'afficheras quand meme à  coté du R.E.)
$AdvSpyConfig['protection']['Hide_Allied']=FALSE;

// Listes personnalisées pour cacher les rapports au sujet de joueurs, d'alliance, ou de coordonées que vous specifiez ici
// pour créer une liste de joueur par exemple faites le sous la forme :
// $AdvSpyConfig['protection']['customlist_player']=array('nom de joueur','luke skywalker','nadia');
// si vous ne voulez cacher personne, laissez vide : array()
// Pour les coordonées mettez les sous la forme : array('[1:2:3]','[9:499:15]','[4:5:6]')
// EXEMPLES :
// $AdvSpyConfig['protection']['customlist_player']=array('Moi','Mon pote','et un autre');
// $AdvSpyConfig['protection']['customlist_allytag']=array('MATF','UAA');
// $AdvSpyConfig['protection']['customlist_coord']=array('[1:2:3]','[9:499:15]','[4:5:6]');
//
// N'oubliez pas les guimmets ' et les virgules ,

$AdvSpyConfig['protection']['customlist_player']=array();
$AdvSpyConfig['protection']['customlist_allytag']=array();
$AdvSpyConfig['protection']['customlist_coord']=array();

// Liste des alliances ENNEMIES à  raider en priorité :) (alerte en rouge)
$AdvSpyConfig['protection']['customlist_enemytag']=array();


// TRUE = Les utilisateurs non-admin peuvent enregistrer une sauvegarde publique.
// FALSE = Seul les admin/co-admin peuvent enregistrer une sauvegarde publique.
$AdvSpyConfig['Restrictions']['Save_AllowPublic']=TRUE;


// ================================================================

// Configuration des couleurs :

// Couleurs pour le taux de patate.
$AdvSpyConfig['color']['PatatePourcent0']='#FF0000'; // Rouge
$AdvSpyConfig['color']['PatatePourcent10']='#CC0033';
$AdvSpyConfig['color']['PatatePourcent20']='#AA0055';
$AdvSpyConfig['color']['PatatePourcent30']='#880077';
$AdvSpyConfig['color']['PatatePourcent40']='#6600BB';
$AdvSpyConfig['color']['PatatePourcent50']='#0000FF'; // Bleu
$AdvSpyConfig['color']['PatatePourcent60']='#0033CC';
$AdvSpyConfig['color']['PatatePourcent70']='#006699';
$AdvSpyConfig['color']['PatatePourcent80']='#009966';
$AdvSpyConfig['color']['PatatePourcent90']='#00CC33';
$AdvSpyConfig['color']['PatatePourcent100']='#00FF00'; //Vert
$AdvSpyConfig['color']['PatatePourcent??']='#AAAAAA'; //Blanc
$AdvSpyConfig['color']['PatatePourcent!!']='#00FF00'; //Vert > Easy raids (def=0)

$AdvSpyConfig['color']['Fleet']='#FF7722'; // Orange
$AdvSpyConfig['color']['Def']='#33CCFF'; // Bleu clair
$AdvSpyConfig['color']['Buildings']='#7777FF'; // Violet
$AdvSpyConfig['color']['Tech']='#77FF77'; // Vert

$AdvSpyConfig['color']['Spy_PlanetName']='#77FF77';
$AdvSpyConfig['color']['Spy_Coord']='#DD5555';
$AdvSpyConfig['color']['Spy_PlayerName']='#11FF77';
$AdvSpyConfig['color']['Spy_AllyTag']='#77FF77';

$AdvSpyConfig['color']['Spy_Lune']='#FFFF77';
$AdvSpyConfig['color']['Spy_LuneBlink']=TRUE;

$AdvSpyConfig['color']['ToolTipBackground']='#FFFF77'; // jaune clair

// ================================================================

//Liste (en secondes) des ages max de RE proposés dans la liste déroulante.
// info : les calculs sont possible à  l'interieur meme des elements.
$AdvSpyConfig['Settings']['ListeAgeMax']=array(
												60*30, // 30 mn
												60*60, //60 sec * 60 = 1 heure
												60*60*2, //60 sec * 60 (=1heure) *2 = 2 heures
												60*60*3, //3 heures
												60*60*4,
												60*60*5,
												60*60*6,
												60*60*12, // 12 heures
												60*60*24, // 1 jour
												60*60*24*2, // 2 jours
												60*60*24*3, 
												60*60*24*7, // une semaine
												60*60*24*7*2, // deux semaines
												60*60*24*7*3, 
												60*60*24*7*4, // 4 semaine (1 mois)
												60*60*24*7*8, // 2 mois
												60*60*24*7*12, // 3 mois
												60*60*24*90); // 90 jours (maximum)
//



// ne mettez rien ('') si vous ne voulez pas de point dans les nombres (defaut : '.')
$lang['Options']['SeparateurDeMilliers']['Name']='Séparateur de milliers';
$lang['Options']['SeparateurDeMilliers']['Desc']='Caractère utilisé pour ponctuer les nombres à  chaque milliers ex: 123.456.789 (Par défaut \'.\' ou rien pour ne pas avoir de séparateur) --- Celà  affecte l\'affichage des RE dans AdvSpy, et les RE copiés dans le presse-papier avec BBCode seulement';
$lang['Options']['SeparateurDeMilliers']['Type']='*string';
$lang['Options']['SeparateurDeMilliers']['Value_Config']='.';


// TRUE= Considérer qu'une planète appellée 'lune' est une lune (defaut : FALSE)
// FALSE= Considérer une lune uniquement si ' (Lune) ' est affiché après le nom de l'astre dans le RE (ogame 0.76 et +)
$AdvSpyConfig['Settings']['OldMoonDetection']=FALSE;

// Detection 'intelligente' de lune
// TRUE= Se base su plusieurs critères (comme les batiments présents) pour déterminer si ce rapport concerne une lune ou pas.
// FALSE= déconseillé !! uniquement si vous jouez sur un univers 'chelou'.
// Info: Quand cette option est activée, elle est prioritaire sur les autres options (comme OldMoonDetection).
$AdvSpyConfig['Settings']['SmartMoonDetection']=TRUE;



//Nombre de résultats maximum par défaut
$lang['Options']['SearchResult_DefaultMax']['Name']='Nombre max de résultat par page';
$lang['Options']['SearchResult_DefaultMax']['Desc']='Nombre maximum de Rapport d\'Espionnage à  afficher par défaut sur chaque page (Défaut: 20)';
$lang['Options']['SearchResult_DefaultMax']['Type']='integer';
$lang['Options']['SearchResult_DefaultMax']['Value_Config']='20';


// TRUE = (défaut) Affiche les messages d'AdvSpy dans les logs d'OGSpy.
// FALSE = Désactivé
$AdvSpyConfig['Settings']['EnableLog']=TRUE;


// TRUE = Affiche les messages supplémentaires de débug visibles dans la parte 'Administration' (donc reservé aux admins).
// FALSE = (défaut) Désactivé car inutile sauf si vous etes développeurs/curieux.
$AdvSpyConfig['Settings']['EnableDebug']=TRUE;

// Préfixe des tables de la base de données ()
if (@TABLE_USER) { $AdvSpyConfig['Settings']['AdvSpy_TablePrefix']=substr(TABLE_USER, 0, strlen(TABLE_USER)-4); }
else { $AdvSpyConfig['Settings']['AdvSpy_TablePrefix']='ogspy_'; }

// nom de la table pour RaidAlert (defaut : "advspy_raids")
$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']="advspy_raids";
// pas touche à  cette ligne ki ajoute le préfixe :
$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert']=$AdvSpyConfig['Settings']['AdvSpy_TablePrefix'].$AdvSpyConfig['Settings']['AdvSpy_TableName_RaidAlert'];

// nom de la table pour les sauvegardes (defaut : "advspy_save")
$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']="advspy_save";
// pas touche à  cette ligne ki ajoute le préfixe :
$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad']=$AdvSpyConfig['Settings']['AdvSpy_TablePrefix'].$AdvSpyConfig['Settings']['AdvSpy_TableName_SaveLoad'];





// Changez suivant les options spéciales de votre serveur
// par exemple, uni 50 FR :
//     $AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max']=50;
//     $AdvSpyConfig['Settings']['OgameUniverse_System_Max']=100;
//     $AdvSpyConfig['Settings']['OgameUniverse_Row_Max']=15;
// défaut : 9 / 499 / 15
// (merci shadowmoon pour l'idée :] )

$AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max']=9;
$AdvSpyConfig['Settings']['OgameUniverse_System_Max']=499;
$AdvSpyConfig['Settings']['OgameUniverse_Row_Max']=15;

// un minimum est-il nécéssaire ?
// rappel : pour le moment une limitation de raidalert (la structure de la bdd) fais que le maximum absolu est de : 99 / 999 / 99









// ================================================================
// ====================ALERTE PARTIE RISQUEE=======================
// ================================================================
// ====A partir d'ici se trouve les definitions memes du jeux======
// ====Les nom prix et puissances des vaisseaux, batiments et =====
// ====tous les elements 'statiques' du jeux Ogame=================
// ================================================================
// ====Ne changez rien de ce qui ce trouve ci dessous à  moins =====
// ====qu'une mise à  jour du jeux ne modifie des carracteristiques=
// ====d'un vaisseaux ou meme en rajoute un (ex:traqueur) =========
// ================================================================
// ================================================================
// ====Si vous foutez le bordel : reinstallez le mod ==============
// ================================================================



$lang['DicOgame']['Text']['Spy']['start']="Matières premières sur "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['lune']=" (Lune) "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['interlude']=" le "; //laissez les espaces !
$lang['DicOgame']['Text']['Spy']['nolastseen']="Le scanner des sondes n'a pas détecté d'anomalies atmosphériques sur cette planète. Une activité sur cette planète dans la dernière heure peut quasiment àªtre exclue";
$lang['DicOgame']['Text']['Spy']['lastseenstart']="Le scanner des sondes a détecté des anomalies dans l'atmosphère de cette planète, indiquant qu'il y a eu une activité sur cette planète dans les ";
$lang['DicOgame']['Text']['Spy']['lastseenend']=" dernières minutes.";
$lang['DicOgame']['Text']['Spy']['metal']="Métal:";
$lang['DicOgame']['Text']['Spy']['cristal']="Cristal:";
$lang['DicOgame']['Text']['Spy']['deut']="Deutérium:";
$lang['DicOgame']['Text']['Spy']['energie']="Energie:";
$lang['DicOgame']['Text']['Spy']['Fleet']="Flotte";
$lang['DicOgame']['Text']['Spy']['Def']="Défense";
$lang['DicOgame']['Text']['Spy']['Buildings']="Bà¢timents";
$lang['DicOgame']['Text']['Spy']['Tech']="Recherche";
$lang['DicOgame']['Text']['Spy']['end']="Probabilité de destruction de la flotte d'espionnage :";



//pas touche
$lang['DicOgame']['SpyCatList']=array('Fleet'=>'Flottes','Def'=>'Défenses','Buildings'=>'Bà¢timents','Tech'=>'Recherches');


// ================================================================
// ======================BATIMENTS=================================

//$lang['DicOgame']['Buildings'][0]['Name']="Mine de métal";
$lang['DicOgame']['Buildings'][0]['PostVar']='b_metal';
$lang['DicOgame']['Buildings'][0]['OgsName']='M';

//$lang['DicOgame']['Buildings'][1]['Name']="Mine de cristal";
$lang['DicOgame']['Buildings'][1]['PostVar']='b_cristal';
$lang['DicOgame']['Buildings'][1]['OgsName']='C';

//$lang['DicOgame']['Buildings'][2]['Name']="Synthétiseur de deutérium";
$lang['DicOgame']['Buildings'][2]['PostVar']='b_deut';
$lang['DicOgame']['Buildings'][2]['OgsName']='D';

//$lang['DicOgame']['Buildings'][3]['Name']="Centrale électrique solaire";
$lang['DicOgame']['Buildings'][3]['PostVar']='b_solaire';
$lang['DicOgame']['Buildings'][3]['OgsName']='CES';

//$lang['DicOgame']['Buildings'][4]['Name']="Centrale électrique de fusion";
$lang['DicOgame']['Buildings'][4]['PostVar']='b_fusion';
$lang['DicOgame']['Buildings'][4]['OgsName']='CEF';

//$lang['DicOgame']['Buildings'][5]['Name']="Usine de robots";
$lang['DicOgame']['Buildings'][5]['PostVar']='b_robot';
$lang['DicOgame']['Buildings'][5]['OgsName']='UdR';

//$lang['DicOgame']['Buildings'][6]['Name']="Usine de nanites";
$lang['DicOgame']['Buildings'][6]['PostVar']='b_nanites';
$lang['DicOgame']['Buildings'][6]['OgsName']='UdN';

//$lang['DicOgame']['Buildings'][7]['Name']="Chantier spatial";
$lang['DicOgame']['Buildings'][7]['PostVar']='b_spatial';
$lang['DicOgame']['Buildings'][7]['OgsName']='CSp';

//$lang['DicOgame']['Buildings'][8]['Name']="Hangar de métal";
$lang['DicOgame']['Buildings'][8]['PostVar']='b_hmetal';
$lang['DicOgame']['Buildings'][8]['OgsName']='HM';

//$lang['DicOgame']['Buildings'][9]['Name']="Hangar de cristal";
$lang['DicOgame']['Buildings'][9]['PostVar']='b_hcristal';
$lang['DicOgame']['Buildings'][9]['OgsName']='HC';

//$lang['DicOgame']['Buildings'][10]['Name']="Réservoir de deutérium";
$lang['DicOgame']['Buildings'][10]['PostVar']='b_hdeut';
$lang['DicOgame']['Buildings'][10]['OgsName']='HD';

//$lang['DicOgame']['Buildings'][11]['Name']="Laboratoire de recherche";
$lang['DicOgame']['Buildings'][11]['PostVar']='b_labo';
$lang['DicOgame']['Buildings'][11]['OgsName']='Lab';

//$lang['DicOgame']['Buildings'][12]['Name']="Terraformeur";
$lang['DicOgame']['Buildings'][12]['PostVar']='b_terra';
$lang['DicOgame']['Buildings'][12]['OgsName']='Ter';

//$lang['DicOgame']['Buildings'][13]['Name']="Silo de missiles";
$lang['DicOgame']['Buildings'][13]['PostVar']='b_missiles';
$lang['DicOgame']['Buildings'][13]['OgsName']='Silo';

//$lang['DicOgame']['Buildings'][14]['Name']="Base lunaire";
$lang['DicOgame']['Buildings'][14]['PostVar']='b_lune';
$lang['DicOgame']['Buildings'][14]['OgsName']='BaLu';

//$lang['DicOgame']['Buildings'][15]['Name']="Phalange de capteur";
$lang['DicOgame']['Buildings'][15]['PostVar']='b_phalange';
$lang['DicOgame']['Buildings'][15]['OgsName']='Pha';

//$lang['DicOgame']['Buildings'][16]['Name']="Porte de saut spatial";
$lang['DicOgame']['Buildings'][16]['PostVar']='b_stargate';
$lang['DicOgame']['Buildings'][16]['OgsName']='PoSa';

//$lang['DicOgame']['Buildings'][17]['Name']="Dépot de Ravitaillement";
$lang['DicOgame']['Buildings'][17]['PostVar']='b_depot';
$lang['DicOgame']['Buildings'][17]['OgsName']='DdR';


// ================================================================
// ==================TECHNOLOGIES==================================
//$lang['DicOgame']['Tech'][0]['Name']="Technologie Espionnage";
$lang['DicOgame']['Tech'][0]['PostVar']='t_spy';
$lang['DicOgame']['Tech'][0]['OgsName']='Esp';

//$lang['DicOgame']['Tech'][1]['Name']="Technologie Ordinateur";
$lang['DicOgame']['Tech'][1]['PostVar']='t_ordi';
$lang['DicOgame']['Tech'][1]['OgsName']='Ordi';

//$lang['DicOgame']['Tech'][2]['Name']="Technologie Armes";
$lang['DicOgame']['Tech'][2]['PostVar']='t_armes';
$lang['DicOgame']['Tech'][2]['OgsName']='Armes';

//$lang['DicOgame']['Tech'][3]['Name']="Technologie Bouclier";
$lang['DicOgame']['Tech'][3]['PostVar']='t_bouclier';
$lang['DicOgame']['Tech'][3]['OgsName']='Bouclier';

//$lang['DicOgame']['Tech'][4]['Name']="Technologie Protection des vaisseaux spatiaux";
$lang['DicOgame']['Tech'][4]['PostVar']='t_protect';
$lang['DicOgame']['Tech'][4]['OgsName']='Protection';

//$lang['DicOgame']['Tech'][5]['Name']="Technologie Energie";
$lang['DicOgame']['Tech'][5]['PostVar']='t_energie';
$lang['DicOgame']['Tech'][5]['OgsName']='NRJ';

//$lang['DicOgame']['Tech'][6]['Name']="Technologie Hyperespace";
$lang['DicOgame']['Tech'][6]['PostVar']='t_hyper';
$lang['DicOgame']['Tech'][6]['OgsName']='Hyp';

//$lang['DicOgame']['Tech'][7]['Name']="Réacteur à  combustion";
$lang['DicOgame']['Tech'][7]['PostVar']='t_combu';
$lang['DicOgame']['Tech'][7]['OgsName']='RC';

//$lang['DicOgame']['Tech'][8]['Name']="Réacteur à  impulsion";
$lang['DicOgame']['Tech'][8]['PostVar']='t_impu';
$lang['DicOgame']['Tech'][8]['OgsName']='RI';

//$lang['DicOgame']['Tech'][9]['Name']="Propulsion hyperespace";
$lang['DicOgame']['Tech'][9]['PostVar']='t_phyper';
$lang['DicOgame']['Tech'][9]['OgsName']='PH';

//$lang['DicOgame']['Tech'][10]['Name']="Technologie Laser";
$lang['DicOgame']['Tech'][10]['PostVar']='t_laser';
$lang['DicOgame']['Tech'][10]['OgsName']='Laser';

//$lang['DicOgame']['Tech'][11]['Name']="Technologie Ions";
$lang['DicOgame']['Tech'][11]['PostVar']='t_ions';
$lang['DicOgame']['Tech'][11]['OgsName']='Ions';

//$lang['DicOgame']['Tech'][12]['Name']="Technologie Plasma";
$lang['DicOgame']['Tech'][12]['PostVar']='t_plasma';
$lang['DicOgame']['Tech'][12]['OgsName']='Plasma';

//$lang['DicOgame']['Tech'][13]['Name']="Réseau de recherche intergalactique";
$lang['DicOgame']['Tech'][13]['PostVar']='t_reseau';
$lang['DicOgame']['Tech'][13]['OgsName']='RRI';

//$lang['DicOgame']['Tech'][14]['Name']="Technologie Expéditions";
$lang['DicOgame']['Tech'][14]['PostVar']='t_expeditions';
$lang['DicOgame']['Tech'][14]['OgsName']='Expeditions';

//$lang['DicOgame']['Tech'][15]['Name']="Technologie Graviton";
$lang['DicOgame']['Tech'][15]['PostVar']='t_graviton';
$lang['DicOgame']['Tech'][15]['OgsName']='Graviton';


// ================================================================
// ================FLOTTES=========================================
//$lang['DicOgame']['Fleet'][0]['Name']='Petit transporteur';
$lang['DicOgame']['Fleet'][0]['PostVar']='f_pt';
$lang['DicOgame']['Fleet'][0]['OgsName']='PT';
$lang['DicOgame']['Fleet'][0]['Prix']=array(2000,2000,0);
$lang['DicOgame']['Fleet'][0]['Structure']=4000;
$lang['DicOgame']['Fleet'][0]['Bouclier']=10;
$lang['DicOgame']['Fleet'][0]['Attaque']=5;
$lang['DicOgame']['Fleet'][0]['Fret']=5000;
$lang['DicOgame']['Fleet'][0]['Vitesse']=5000;
$lang['DicOgame']['Fleet'][0]['Carbu']=10;

//$lang['DicOgame']['Fleet'][1]['Name']='Grand transporteur';
$lang['DicOgame']['Fleet'][1]['PostVar']='f_gt';
$lang['DicOgame']['Fleet'][1]['OgsName']='GT';
$lang['DicOgame']['Fleet'][1]['Prix']=array(6000,6000,0);
$lang['DicOgame']['Fleet'][1]['Structure']=12000;
$lang['DicOgame']['Fleet'][1]['Bouclier']=25;
$lang['DicOgame']['Fleet'][1]['Attaque']=5;
$lang['DicOgame']['Fleet'][1]['Fret']=25000;
$lang['DicOgame']['Fleet'][1]['Vitesse']=7500;
$lang['DicOgame']['Fleet'][1]['Carbu']=50;

//$lang['DicOgame']['Fleet'][2]['Name']='Chasseur léger';
$lang['DicOgame']['Fleet'][2]['PostVar']='f_cle';
$lang['DicOgame']['Fleet'][2]['OgsName']='CLE';
$lang['DicOgame']['Fleet'][2]['Prix']=array(3000,1000,0);
$lang['DicOgame']['Fleet'][2]['Structure']=4000;
$lang['DicOgame']['Fleet'][2]['Bouclier']=10;
$lang['DicOgame']['Fleet'][2]['Attaque']=50;
$lang['DicOgame']['Fleet'][2]['Fret']=50;
$lang['DicOgame']['Fleet'][2]['Vitesse']=12500;
$lang['DicOgame']['Fleet'][2]['Carbu']=20;

//$lang['DicOgame']['Fleet'][3]['Name']='Chasseur lourd';
$lang['DicOgame']['Fleet'][3]['PostVar']='f_clo';
$lang['DicOgame']['Fleet'][3]['OgsName']='CLO';
$lang['DicOgame']['Fleet'][3]['Prix']=array(6000,4000,0);
$lang['DicOgame']['Fleet'][3]['Structure']=10000;
$lang['DicOgame']['Fleet'][3]['Bouclier']=25;
$lang['DicOgame']['Fleet'][3]['Attaque']=150;
$lang['DicOgame']['Fleet'][3]['Fret']=100;
$lang['DicOgame']['Fleet'][3]['Vitesse']=10000;
$lang['DicOgame']['Fleet'][3]['Carbu']=75;

//$lang['DicOgame']['Fleet'][4]['Name']='Croiseur';
$lang['DicOgame']['Fleet'][4]['PostVar']='f_cro';
$lang['DicOgame']['Fleet'][4]['OgsName']='CR';
$lang['DicOgame']['Fleet'][4]['Prix']=array(20000,7000,2000);
$lang['DicOgame']['Fleet'][4]['Structure']=27000;
$lang['DicOgame']['Fleet'][4]['Bouclier']=50;
$lang['DicOgame']['Fleet'][4]['Attaque']=400;
$lang['DicOgame']['Fleet'][4]['Fret']=800;
$lang['DicOgame']['Fleet'][4]['Vitesse']=15000;
$lang['DicOgame']['Fleet'][4]['Carbu']=300;

//$lang['DicOgame']['Fleet'][5]['Name']='Vaisseau de bataille';
$lang['DicOgame']['Fleet'][5]['PostVar']='f_vb';
$lang['DicOgame']['Fleet'][5]['OgsName']='VB';
$lang['DicOgame']['Fleet'][5]['Prix']=array(45000,15000,0);
$lang['DicOgame']['Fleet'][5]['Structure']=60000;
$lang['DicOgame']['Fleet'][5]['Bouclier']=200;
$lang['DicOgame']['Fleet'][5]['Attaque']=1000;
$lang['DicOgame']['Fleet'][5]['Fret']=1500;
$lang['DicOgame']['Fleet'][5]['Vitesse']=10000;
$lang['DicOgame']['Fleet'][5]['Carbu']=500;

//$lang['DicOgame']['Fleet'][6]['Name']='Vaisseau de colonisation';
$lang['DicOgame']['Fleet'][6]['PostVar']='f_vc';
$lang['DicOgame']['Fleet'][6]['OgsName']='VC';
$lang['DicOgame']['Fleet'][6]['Prix']=array(10000,20000,10000);
$lang['DicOgame']['Fleet'][6]['Structure']=30000;
$lang['DicOgame']['Fleet'][6]['Bouclier']=100;
$lang['DicOgame']['Fleet'][6]['Attaque']=50;
$lang['DicOgame']['Fleet'][6]['Fret']=7500;
$lang['DicOgame']['Fleet'][6]['Vitesse']=2500;
$lang['DicOgame']['Fleet'][6]['Carbu']=1000;

//$lang['DicOgame']['Fleet'][7]['Name']='Recycleur';
$lang['DicOgame']['Fleet'][7]['PostVar']='f_rec';
$lang['DicOgame']['Fleet'][7]['OgsName']='REC';
$lang['DicOgame']['Fleet'][7]['Prix']=array(10000,6000,2000);
$lang['DicOgame']['Fleet'][7]['Structure']=16000;
$lang['DicOgame']['Fleet'][7]['Bouclier']=10;
$lang['DicOgame']['Fleet'][7]['Attaque']=1;
$lang['DicOgame']['Fleet'][7]['Fret']=20000;
$lang['DicOgame']['Fleet'][7]['Vitesse']=2000;
$lang['DicOgame']['Fleet'][7]['Carbu']=300;

//$lang['DicOgame']['Fleet'][8]['Name']='Sonde espionnage';
$lang['DicOgame']['Fleet'][8]['PostVar']='f_se';
$lang['DicOgame']['Fleet'][8]['OgsName']='SE';
$lang['DicOgame']['Fleet'][8]['Prix']=array(0,1000,0);
$lang['DicOgame']['Fleet'][8]['Structure']=1000;
$lang['DicOgame']['Fleet'][8]['Bouclier']=0;
$lang['DicOgame']['Fleet'][8]['Attaque']=0;
$lang['DicOgame']['Fleet'][8]['Fret']=5;
$lang['DicOgame']['Fleet'][8]['Vitesse']=100000000;
$lang['DicOgame']['Fleet'][8]['Carbu']=1;

//$lang['DicOgame']['Fleet'][9]['Name']='Bombardier';
$lang['DicOgame']['Fleet'][9]['PostVar']='f_bom';
$lang['DicOgame']['Fleet'][9]['OgsName']='BMD';
$lang['DicOgame']['Fleet'][9]['Prix']=array(50000,25000,15000);
$lang['DicOgame']['Fleet'][9]['Structure']=75000;
$lang['DicOgame']['Fleet'][9]['Bouclier']=500;
$lang['DicOgame']['Fleet'][9]['Attaque']=1000;
$lang['DicOgame']['Fleet'][9]['Fret']=500;
$lang['DicOgame']['Fleet'][9]['Vitesse']=5000;
$lang['DicOgame']['Fleet'][9]['Carbu']=1000;

//$lang['DicOgame']['Fleet'][10]['Name']='Satellite solaire';
$lang['DicOgame']['Fleet'][10]['PostVar']='f_sat';
$lang['DicOgame']['Fleet'][10]['OgsName']='SAT';
$lang['DicOgame']['Fleet'][10]['Prix']=array(0,2000,500);
$lang['DicOgame']['Fleet'][10]['Structure']=2000;
$lang['DicOgame']['Fleet'][10]['Bouclier']=1;
$lang['DicOgame']['Fleet'][10]['Attaque']=1;
$lang['DicOgame']['Fleet'][10]['Fret']=0;
$lang['DicOgame']['Fleet'][10]['Vitesse']=0;
$lang['DicOgame']['Fleet'][10]['Carbu']=0;

//$lang['DicOgame']['Fleet'][11]['Name']='Destructeur';
$lang['DicOgame']['Fleet'][11]['PostVar']='f_des';
$lang['DicOgame']['Fleet'][11]['OgsName']='DST';
$lang['DicOgame']['Fleet'][11]['Prix']=array(60000,50000,15000);
$lang['DicOgame']['Fleet'][11]['Structure']=110000;
$lang['DicOgame']['Fleet'][11]['Bouclier']=500;
$lang['DicOgame']['Fleet'][11]['Attaque']=2000;
$lang['DicOgame']['Fleet'][11]['Fret']=2000;
$lang['DicOgame']['Fleet'][11]['Vitesse']=5000;
$lang['DicOgame']['Fleet'][11]['Carbu']=1000;

//$lang['DicOgame']['Fleet'][12]['Name']='à‰toile de la mort';
$lang['DicOgame']['Fleet'][12]['PostVar']='f_edlm';
$lang['DicOgame']['Fleet'][12]['OgsName']='EDLM';
$lang['DicOgame']['Fleet'][12]['Prix']=array(5000000,4000000,1000000);
$lang['DicOgame']['Fleet'][12]['Structure']=9000000;
$lang['DicOgame']['Fleet'][12]['Bouclier']=50000;
$lang['DicOgame']['Fleet'][12]['Attaque']=200000;
$lang['DicOgame']['Fleet'][12]['Fret']=1000000;
$lang['DicOgame']['Fleet'][12]['Vitesse']=100;
$lang['DicOgame']['Fleet'][12]['Carbu']=1;

//$lang['DicOgame']['Fleet'][13]['Name']='Traqueur';
$lang['DicOgame']['Fleet'][13]['PostVar']='f_traq';
$lang['DicOgame']['Fleet'][13]['OgsName']='TRA';
$lang['DicOgame']['Fleet'][13]['Prix']=array(30000,40000,15000);
$lang['DicOgame']['Fleet'][13]['Structure']=70000;
$lang['DicOgame']['Fleet'][13]['Bouclier']=400;
$lang['DicOgame']['Fleet'][13]['Attaque']=700;
$lang['DicOgame']['Fleet'][13]['Fret']=750;
$lang['DicOgame']['Fleet'][13]['Vitesse']=10000;
$lang['DicOgame']['Fleet'][13]['Carbu']=250;

// ================================================================
// ==============DEFENSES==========================================

//$lang['DicOgame']['Def'][0]['Name']='Lanceur de missiles';
$lang['DicOgame']['Def'][0]['PostVar']='d_mis';
$lang['DicOgame']['Def'][0]['OgsName']='LM';
$lang['DicOgame']['Def'][0]['Prix']=array(2000,0,0);
$lang['DicOgame']['Def'][0]['Structure']=2000;
$lang['DicOgame']['Def'][0]['Bouclier']=20;
$lang['DicOgame']['Def'][0]['Attaque']=80;

//$lang['DicOgame']['Def'][1]['Name']='Artillerie laser légère';
$lang['DicOgame']['Def'][1]['PostVar']='d_lle';
$lang['DicOgame']['Def'][1]['OgsName']='LLE';
$lang['DicOgame']['Def'][1]['Prix']=array(1500,500,0);
$lang['DicOgame']['Def'][1]['Structure']=2000;
$lang['DicOgame']['Def'][1]['Bouclier']=25;
$lang['DicOgame']['Def'][1]['Attaque']=100;

//$lang['DicOgame']['Def'][2]['Name']='Artillerie laser lourde';
$lang['DicOgame']['Def'][2]['PostVar']='d_llo';
$lang['DicOgame']['Def'][2]['OgsName']='LLO';
$lang['DicOgame']['Def'][2]['Prix']=array(6000,2000,0);
$lang['DicOgame']['Def'][2]['Structure']=8000;
$lang['DicOgame']['Def'][2]['Bouclier']=100;
$lang['DicOgame']['Def'][2]['Attaque']=250;

//$lang['DicOgame']['Def'][3]['Name']='Canon de Gauss';
$lang['DicOgame']['Def'][3]['PostVar']='d_gaus';
$lang['DicOgame']['Def'][3]['OgsName']='CG';
$lang['DicOgame']['Def'][3]['Prix']=array(20000,15000,2000);
$lang['DicOgame']['Def'][3]['Structure']=35000;
$lang['DicOgame']['Def'][3]['Bouclier']=200;
$lang['DicOgame']['Def'][3]['Attaque']=1100;

//$lang['DicOgame']['Def'][4]['Name']='Artillerie à  ions';
$lang['DicOgame']['Def'][4]['PostVar']='d_ion';
$lang['DicOgame']['Def'][4]['OgsName']='AI';
$lang['DicOgame']['Def'][4]['Prix']=array(2000,6000,0);
$lang['DicOgame']['Def'][4]['Structure']=8000;
$lang['DicOgame']['Def'][4]['Bouclier']=500;
$lang['DicOgame']['Def'][4]['Attaque']=150;

//$lang['DicOgame']['Def'][5]['Name']='Lanceur de plasma';
$lang['DicOgame']['Def'][5]['PostVar']='d_pla';
$lang['DicOgame']['Def'][5]['OgsName']='LP';
$lang['DicOgame']['Def'][5]['Prix']=array(50000,50000,30000);
$lang['DicOgame']['Def'][5]['Structure']=100000;
$lang['DicOgame']['Def'][5]['Bouclier']=300;
$lang['DicOgame']['Def'][5]['Attaque']=3000;

//$lang['DicOgame']['Def'][6]['Name']='Petit bouclier';
$lang['DicOgame']['Def'][6]['PostVar']='d_pb';
$lang['DicOgame']['Def'][6]['OgsName']='PB';
$lang['DicOgame']['Def'][6]['Prix']=array(10000,10000,0);
$lang['DicOgame']['Def'][6]['Structure']=20000;
$lang['DicOgame']['Def'][6]['Bouclier']=2000;
$lang['DicOgame']['Def'][6]['Attaque']=1;

//$lang['DicOgame']['Def'][7]['Name']='Grand bouclier';
$lang['DicOgame']['Def'][7]['PostVar']='d_gb';
$lang['DicOgame']['Def'][7]['OgsName']='GB';
$lang['DicOgame']['Def'][7]['Prix']=array(50000,50000,0);
$lang['DicOgame']['Def'][7]['Structure']=100000;
$lang['DicOgame']['Def'][7]['Bouclier']=10000;
$lang['DicOgame']['Def'][7]['Attaque']=1;

//$lang['DicOgame']['Def'][8]['Name']='Missile Interception';
$lang['DicOgame']['Def'][8]['PostVar']='d_mi';
$lang['DicOgame']['Def'][8]['OgsName']='MIC';
$lang['DicOgame']['Def'][8]['Prix']=array(8000,0,2000);
$lang['DicOgame']['Def'][8]['Structure']=8000;
$lang['DicOgame']['Def'][8]['Bouclier']=1;
$lang['DicOgame']['Def'][8]['Attaque']=1;

//$lang['DicOgame']['Def'][9]['Name']='Missile Interplanétaire';
$lang['DicOgame']['Def'][9]['PostVar']='d_mip';
$lang['DicOgame']['Def'][9]['OgsName']='MIP';
$lang['DicOgame']['Def'][9]['Prix']=array(12500,2500,10000);
$lang['DicOgame']['Def'][9]['Structure']=15000;
$lang['DicOgame']['Def'][9]['Bouclier']=1;
$lang['DicOgame']['Def'][9]['Attaque']=12000;

// ================================================================
// ================================================================
// à§a c'est plus en rapport avec le coeur d'AdvSpy ... notament l'affichage des statistiques ...
// y a pas forcement tout mais vous croyez pas que c'est deja assé non ?

/*
$lang['FlatSpyElements']['spy_galaxy']['Name']='Galaxie';
$lang['FlatSpyElements']['spy_system']['Name']='Système';
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
$lang['FlatSpyElements']['ArmyRessources_f']['Name']='Resoources totale des vaisseaux';
$lang['FlatSpyElements']['ArmyRessources_d']['Name']='Resoources totale des défenses';
$lang['FlatSpyElements']['ArmyRessourcesD']['Name']='Ressources totale de la flotte (avec Deut)';
$lang['FlatSpyElements']['ArmyRessourcesD_f']['Name']='Ressources totale de la flotte (avec Deut)';
$lang['FlatSpyElements']['ArmyRessourcesD_d']['Name']='Ressources totale des défenses (avec Deut)';
$lang['FlatSpyElements']['GrandNombre']['Name']='Le plus Grand Nombre';
$lang['FlatSpyElements']['Transport_PT']['Name']='Nombre de PT nécéssaires pour le transport';
$lang['FlatSpyElements']['Transport_GT']['Name']='Nombre de GT nécéssaires pour le transport';
$lang['FlatSpyElements']['Raid_metal']['Name']='Métal à  gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_cristal']['Name']='Cristal à  gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_deut']['Name']='Deutérium à  gagner en raidant (1/2 du total)';
$lang['FlatSpyElements']['Raid_total']['Name']='Ressources totales à  gagner en raidant (1/2 du total)';

$lang['FlatSpyElements']['Raid2_metal']['Name']='Métal à  gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_cristal']['Name']='Cristal à  gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_deut']['Name']='Deutérium à  gagner en raidant 2 fois';
$lang['FlatSpyElements']['Raid2_total']['Name']='Ressources totales à  gagner en raidant 2 fois';

$lang['FlatSpyElements']['Raid3_metal']['Name']='Métal à  gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_cristal']['Name']='Cristal à  gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_deut']['Name']='Deutérium à  gagner en raidant 3 fois';
$lang['FlatSpyElements']['Raid3_total']['Name']='Ressources totales à  gagner en raidant 3 fois';

$lang['FlatSpyElements']['Raid_PT']['Name']='Nombre de PT nécéssaires pour le raid';
$lang['FlatSpyElements']['Raid_GT']['Name']='Nombre de GT nécéssaires pour le raid';
$lang['FlatSpyElements']['Ressources_total']['Name']='Total des ressources';
$lang['FlatSpyElements']['Raided']['Name']='Nombre de raids récents signalés';
$lang['FlatSpyElements']['Indice_PR']['Name']='Indice Patate/Ressources';
*/


$AdvSpyConfig['version']['advspy']='0.00';
$VersionFilePath=$AdvSpyConfig['Settings']['AdvSpy_BasePath']."version.txt";
if (file_exists($VersionFilePath)) { 
	$file = file($VersionFilePath);
	$AdvSpyConfig['version']['advspy']=trim(@$file[1]);
}

// URL oà¹ se trouvent les mises à  jour officielles :
// défaut : "http://kilops2.free.fr/og/AdvSpy/"
$AdvSpyConfig['Settings']['AdvSpy_AutoUpdate_MasterURL']="http://kilops2.free.fr/og/AdvSpy/";



// liste des critères de tris :

$AdvSpyConfig['Liste_Tris']=array('1'=>'Date (récents en premier)',
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
							'17'=>'Coordonnées (&lt;)',
							'18'=>'Coordonnées (&gt;)',
							'19'=>'Scanner d`activité (&lt;)',
							'20'=>'Champ de ruines (&gt;)',
							'21'=>'Champ de ruines (&lt;)');


// ca on s'en sert pour l'affichage des noms dans les détails d'une sauvegarde. (Name)
// le Type sert aussi (et surtout) à  la verification du formulaire posté.
// integer 1 8 = nombre entier de 1 à  8 (inclus)
// si pas de max... pas de max.
// duration = entier (en secondes, convertis en texte)
// onoff = 'ON' (en maj) ou '' (rien=off)
// *num = (numeric) nombre (un . pour virgule)
// boolean = 0 ou 1
//
// L'étoile * en 1ere position signifie que NULL ('' vide) est aussi accepté
//
// *integer = pareil pour un nombre entier , l'etoile compte partout (y compris dans duration ...)
// tout élément du formulaire (BlockRecherche) qui ne correspond pas à  ces définitions génère une erreur (log+die()).


//$lang['BlockRechercheElements']['ChercherOK']['Name']='Bouton Chercher';
$lang['BlockRechercheElements']['ChercherOK']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_TRIS']['Name']='Ordre de tris';
$lang['BlockRechercheElements']['AdvSpy_TRIS']['Type']='integer 1 21';

//$lang['BlockRechercheElements']['AdvSpy_OnlyMyScan']['Name']='Uniquement mes RE';
$lang['BlockRechercheElements']['AdvSpy_OnlyMyScan']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SearchResult_Min']['Name']='Résultat min';
$lang['BlockRechercheElements']['AdvSpy_SearchResult_Min']['Type']='integer 1';

//$lang['BlockRechercheElements']['AdvSpy_SearchResult_Max']['Name']='Résultat max';
$lang['BlockRechercheElements']['AdvSpy_SearchResult_Max']['Type']='integer 1';

//$lang['BlockRechercheElements']['AdvSpy_GalaxyMin']['Name']='Galaxie Min';
$lang['BlockRechercheElements']['AdvSpy_GalaxyMin']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'];

//$lang['BlockRechercheElements']['AdvSpy_GalaxyMax']['Name']='Galaxie Max';
$lang['BlockRechercheElements']['AdvSpy_GalaxyMax']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_Galaxy_Max'];

//$lang['BlockRechercheElements']['AdvSpy_SystemMin']['Name']='Système Min';
$lang['BlockRechercheElements']['AdvSpy_SystemMin']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_System_Max'];

//$lang['BlockRechercheElements']['AdvSpy_SystemMax']['Name']='Système Max';
$lang['BlockRechercheElements']['AdvSpy_SystemMax']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_System_Max'];

//$lang['BlockRechercheElements']['AdvSpy_RowMin']['Name']='Rang Min';
$lang['BlockRechercheElements']['AdvSpy_RowMin']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_Row_Max'];

//$lang['BlockRechercheElements']['AdvSpy_RowMax']['Name']='Rang Max';
$lang['BlockRechercheElements']['AdvSpy_RowMax']['Type']='integer 1 '.$AdvSpyConfig['Settings']['OgameUniverse_Row_Max'];

//$lang['BlockRechercheElements']['AdvSpy_CoordsToHide']['Name']='Planètes cachées';
$lang['BlockRechercheElements']['AdvSpy_CoordsToHide']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_AgeMax']['Name']='Age Max du RE';
$lang['BlockRechercheElements']['AdvSpy_AgeMax']['Type']='duration';

//$lang['BlockRechercheElements']['AdvSpy_NoDoublon']['Name']='Pas de doublons';
$lang['BlockRechercheElements']['AdvSpy_NoDoublon']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_ShowOnlyMoon']['Name']='Afficher que les lunes';
$lang['BlockRechercheElements']['AdvSpy_ShowOnlyMoon']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Scanned_Fleet']['Name']='Flotte sondée';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Fleet']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Reduire_Fleet']['Name']='Réduire les flottes';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Fleet']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Scanned_Def']['Name']='Défenses sondées';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Def']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Reduire_Def']['Name']='Réduire défenses';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Def']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Scanned_Buildings']['Name']='Bà¢timents sondés';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Buildings']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Reduire_Buildings']['Name']='Réduire les bà¢timents';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Buildings']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Scanned_Tech']['Name']='Recherches sondées';
$lang['BlockRechercheElements']['AdvSpy_Scanned_Tech']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_Reduire_Tech']['Name']='Réduire les recherches';
$lang['BlockRechercheElements']['AdvSpy_Reduire_Tech']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_OnlyInactif']['Name']='Seulement les inactifs';
$lang['BlockRechercheElements']['AdvSpy_OnlyInactif']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_PlayerSearch']['Name']='Nom de joueur';
$lang['BlockRechercheElements']['AdvSpy_PlayerSearch']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_AllySearch']['Name']='Nom d\'ally';
$lang['BlockRechercheElements']['AdvSpy_AllySearch']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_PlanetSearch']['Name']='Nom de planète';
$lang['BlockRechercheElements']['AdvSpy_PlanetSearch']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_SeuilGrandNombre']['Name']='Grand Nombre';
$lang['BlockRechercheElements']['AdvSpy_SeuilGrandNombre']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_OnlyGrandNombre']['Name']='Seulement si Grand Nombre est dépassé';
$lang['BlockRechercheElements']['AdvSpy_OnlyGrandNombre']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_RessourceMinMetal']['Name']='Métal minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinMetal']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_RessourceMinCristal']['Name']='Cristal minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinCristal']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_RessourceMinDeut']['Name']='Deutérium minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinDeut']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_RessourceMinEnergie']['Name']='Energie minimum';
$lang['BlockRechercheElements']['AdvSpy_RessourceMinEnergie']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_TauxPatateMini']['Name']='Chances de victoire minimum';
$lang['BlockRechercheElements']['AdvSpy_TauxPatateMini']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_HideRaided']['Name']='Cacher les RE raidés';
$lang['BlockRechercheElements']['AdvSpy_HideRaided']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_OnlyRaided']['Name']='N\'afficher que les RE raidés';
$lang['BlockRechercheElements']['AdvSpy_OnlyRaided']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_RaidAgeMax']['Name']='Raids de moin de';
$lang['BlockRechercheElements']['AdvSpy_RaidAgeMax']['Type']='duration';

//$lang['BlockRechercheElements']['AdvSpy_PatateTotalMin']['Name']='PATATE Min';
$lang['BlockRechercheElements']['AdvSpy_PatateTotalMin']['Type']='*num';

//$lang['BlockRechercheElements']['AdvSpy_PatateTotalMax']['Name']='PATATE Max';
$lang['BlockRechercheElements']['AdvSpy_PatateTotalMax']['Type']='*num';

foreach($lang['DicOgame']['SpyCatList'] as $Cat=>$Catname){
	foreach($lang['DicOgame'][$Cat] as $num=>$valuesarray){
		if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar']]['Name']=$valuesarray['Name']; }
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar']]['Type']='*ipa';
		
		if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Min']['Name']=$valuesarray['Name'].' Min'; }
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Min']['Type']='*integer';
		
		if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Max']['Name']=$valuesarray['Name'].' Max'; }
		$lang['BlockRechercheElements']['AdvSpy_'.$valuesarray['PostVar'].'_Max']['Type']='*integer';

		if (strpos($valuesarray['PostVar'],'f_') === 0) {
			if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_Sim_atk_'.$valuesarray['PostVar']]['Name']='[Simulateur]Attaque '.$valuesarray['Name'].''; }
			$lang['BlockRechercheElements']['AdvSpy_Sim_atk_'.$valuesarray['PostVar']]['Type']='*integer';
			
			if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Name']='[Simulateur]Défense '.$valuesarray['Name'].''; }
			$lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Type']='*integer';
		}
		if (strpos($valuesarray['PostVar'],'d_') === 0) {
			if (isset($valuesarray['Name'])) { $lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Name']='[Simulateur]Défense '.$valuesarray['Name'].''; }
			$lang['BlockRechercheElements']['AdvSpy_Sim_def_'.$valuesarray['PostVar']]['Type']='*integer';
		}		
	}
}

//$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_armes']['Name']='[Simulateur]Attaque Tech Armes';
$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_armes']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_bouclier']['Name']='[Simulateur]Attaque Tech Bouclier';
$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_bouclier']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_protect']['Name']='[Simulateur]Attaque Tech Protection';
$lang['BlockRechercheElements']['AdvSpy_Sim_atk_t_protect']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_armes']['Name']='[Simulateur]Défense Tech Armes';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_armes']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_bouclier']['Name']='[Simulateur]Défense Tech Bouclier';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_bouclier']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_protect']['Name']='[Simulateur]Défense Tech Protection';
$lang['BlockRechercheElements']['AdvSpy_Sim_def_t_protect']['Type']='*integer';



// Name est pas vraiment utile pour ceux là , ce qui compte c'est le Type pour la securité

//$lang['BlockRechercheElements']['AdvSpy_SaveIdToLoad']['Name']='Numéro de sauvegarde';
$lang['BlockRechercheElements']['AdvSpy_SaveIdToLoad']['Type']='*integer';

//$lang['BlockRechercheElements']['AdvSpy_SaveDelConfirmation']['Name']='Confirmation de suppression';
$lang['BlockRechercheElements']['AdvSpy_SaveDelConfirmation']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveNameToSave']['Name']='Nom de la sauvegarde';
$lang['BlockRechercheElements']['AdvSpy_SaveNameToSave']['Type']='*string';

//$lang['BlockRechercheElements']['AdvSpy_SaveIsPublic']['Name']='Sauvegarde publique';
$lang['BlockRechercheElements']['AdvSpy_SaveIsPublic']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveIsDefault']['Name']='Sauvegarde générale';
$lang['BlockRechercheElements']['AdvSpy_SaveIsDefault']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Tris']['Name']='Sauvegarde du tris';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Tris']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Secteur']['Name']='Sauvegarde du secteur';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Secteur']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_RE']['Name']='Sauvegarde des carracteristiques du RE';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_RE']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Joueur']['Name']='Sauvegarde des critères de joueurs';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Joueur']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Ressources']['Name']='Sauvegarde des critères de ressources';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Ressources']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Analyse']['Name']='Sauvegarde des contraintes de Patate';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Analyse']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMFleet']['Name']='Sauvegarde de Recherche Plus Flotte';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMFleet']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMDef']['Name']='Sauvegarde de Recherche Plus Défenses';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMDef']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMBuildings']['Name']='Sauvegarde de Recherche Plus Bà¢timents';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMBuildings']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMTech']['Name']='Sauvegarde de Recherche Plus Technologies';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_MMTech']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk']['Name']='Sauvegarde du Simulateur Attaquant';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk_tech']['Name']='Sauvegarde du Simulateur Attaquant (tech)';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_atk_tech']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def']['Name']='Sauvegarde du Simulateur Défenseur';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def']['Type']='*onoff';

//$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def_tech']['Name']='Sauvegarde du Simulateur Défenseur (tech)';
$lang['BlockRechercheElements']['AdvSpy_SaveElement_Sim_def_tech']['Type']='*onoff';

// ===================================================================================================

/*
$lang['Options']['']['Name']='xx';
$lang['Options']['']['Desc']='xx';
$lang['Options']['']['Type']='xx';
$lang['Options']['']['Value_Config']='xx';
*/


//$lang['Options']['RecycleDef']['Name']='Défenses dans débris (Uni40)';
//$lang['Options']['RecycleDef']['Desc']='Prend en compte les débris des défenses pour le calcul du champ de ruines recyclable (Spécifique Uni 40 fr)';
$lang['Options']['RecycleDef']['Type']='*boolean';
$lang['Options']['RecycleDef']['Value_Config']='0';

//$lang['Options']['HideCopyClipAlert']['Name']='Désactiver le message d`erreur de copie presse-papier';
//$lang['Options']['HideCopyClipAlert']['Desc']='Permet de ne plus voir l`avertissement pour les cas oà¹ la copie automatique ne fonctionne pas (sous linux par ex)';
$lang['Options']['HideCopyClipAlert']['Type']='*boolean';
$lang['Options']['HideCopyClipAlert']['Value_Config']='0';

//$lang['Options']['ExpressCopyClipRE']['Name']='Copie express des RE dans le Presse-Papier';
//$lang['Options']['ExpressCopyClipRE']['Desc']='Si activé, le menu de copie de RE ne s\'affiche plus et tente de copier directement le RE \'Standard\' dans le presse-papier quand on click sur l\'icone';
$lang['Options']['ExpressCopyClipRE']['Type']='*boolean';
$lang['Options']['ExpressCopyClipRE']['Value_Config']='0';

//$lang['Options']['ShowRaidsInPT']['Name']='Afficher le nombre de <b>Petits Transporteurs</b> pour les raids';
//$lang['Options']['ShowRaidsInPT']['Desc']='Indique le nombre de PT nécéssaires lors d`un raid à  la place du nombre de GT';
$lang['Options']['ShowRaidsInPT']['Type']='*boolean';
$lang['Options']['ShowRaidsInPT']['Value_Config']='0';

//$lang['Options']['BackgroundOpacity']['Name']='Opacité du fond grisé (de 0 à  100)';
//$lang['Options']['BackgroundOpacity']['Desc']='Opacité du fond grisé 0=transparent 100=noir, Défaut: 50';
$lang['Options']['BackgroundOpacity']['Type']='integer';
$lang['Options']['BackgroundOpacity']['Value_Config']='50';

//$lang['Options']['HideSimAlert']['Name']='Cacher l\'avertissement dans le simulateur de combat';
//$lang['Options']['HideSimAlert']['Desc']='Si activé, le message d\'avertissement en haut de l\'onglet "Simulateur de combat" ne sera pas affiché';
$lang['Options']['HideSimAlert']['Type']='*boolean';
$lang['Options']['HideSimAlert']['Value_Config']='0';

//$lang['Options']['CompactSpy']['Name']='Afficher le contenu des RE en colonnes';
//$lang['Options']['CompactSpy']['Desc']='Si activé, les vaisseaux/def/batiments/tech seront affichés en tableau 2*2';
$lang['Options']['CompactSpy']['Type']='*boolean';
$lang['Options']['CompactSpy']['Value_Config']='1';




//foreach($lang['Options'] as $OptionVar=>$props){
//	$lang['BlockRechercheElements']['AdvSpy_Option_'.$OptionVar]['Name']=$props['Name'];
//	$lang['BlockRechercheElements']['AdvSpy_Option_'.$OptionVar]['Type']=$props['Type'];
//}

// ================================================================
// ==============================FIN===============================
// ====================================================des haricots
?>