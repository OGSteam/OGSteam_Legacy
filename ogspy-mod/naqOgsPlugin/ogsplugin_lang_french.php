<?php
/***************************************************************************
*	filename	: ogsplugin_lang_french.php
*	desc.		: Fichier de langue FR pour ogsplugin.php
*	Author		: Naqdazar   - 
*	created		: 28/11/2006
*	modified	: 
***************************************************************************/
// escaper ' entre "" -> "l\'aurore"

// ******************
// * ogsplugmod.php *
// ******************
// sous menu du module OGS Plugin
$ogp_lang["principal_menu"]="Principal";
$ogp_lang["ogspylog_menu"]="Journal OGSPY";
$ogp_lang["ogspygroupman_menu"]="Gestion des groupes";
$ogp_lang["history_menu"]="Historique";
$ogp_lang["thirdpartymods_menu"]="Du M�me Auteur";



// Pied de Page
$ogp_lang["developpedby_tail"]="d�velopp� par";
$ogp_lang["forumlinkinfo_tail"]="Espace surpport";
$ogp_lang["authorforum_tail"]="Forum Support(Auteur)";

// *******************
// * ogsplugmain.php *
// *******************
// titres de rubrique du panneau principal
$ogp_lang["moduleinterf_main"] = "Interface Module";
$ogp_lang["gameident_main"]="Identification de jeu et d'univers [Obligatoire] (Valider 1 puis 2 et enfin 3)";
$ogp_lang["pluglogopts_main"]="Option de journalisation du plugin [Facultatif]";
$ogp_lang["pagehandling_main"]="Traitement des Pages - Donn�es Communes [Obligatoire]";
$ogp_lang["miscellanous_main"]="S�curit� [Recommand�]";
$ogp_lang["diplomaty_main"]="Diplomatie - Surbrillance globale utilisateurs [Facultatif]";
$ogp_lang["redirection_main"]="Message de Redirection [Facultatif]";
$ogp_lang["usersinfos_main"]="Infos de configuration Utilisateur";

// texte bulles d'aide
$ogp_lang["ogsplug_univ_help"] = "Nom du serveur de l'univers associ� au serveur OGSPY courant.<br><b>Ex.</b> pour l'<b>univers 12</b>(Ogame): <b>ogame190.de<br />l'univers <b>beta4</b>(E-Univers): <b>beta4.e-univers.org</b><br />Modifier pour faire appara�tre la bo�te de saisie de num�ro d'univers.";
$ogp_lang["ogsplug_log_help"] = "Libell�s des op�rations qui seront enregistr�es dans le journal.<br>02/11/2006 00:49:25 :  Joueur charge 15 plan�tes du syst�me 2:294(2:294) via plugin OGSPY (1.6)";
$ogp_lang["ogsgametype_help"] = "Valider cette option avant que la liste des portails ne puisse �tre mise � jour!";
$ogp_lang["ogsportailurl_help"] = "Valider cette option avant que la liste des univers ne puisse �tre mise � jour!";
$ogp_lang["ogsactivate_debuglog_help"] = "Cette option peut r�v�ler des informations confidentielles<br>et n'est destin�e qu'� des fins de d�boguage.<br>L'utiliser rel�ve de votre responsabilit�!";
$ogp_lang["ogspageman_help"] = "Ces options d�finissent les cat�gories de <u>donn�es communes</u> accept�es par le module.<br>Il est recommand� de cocher toutes les cases, sauf pour un serveur d�di� aux statistiques par exemple.<br>Toutes donn�es re�ues mais non g�r�es seront notifi�es � la barre d'outils �mettrice.";
$ogp_lang["ogsstats_timetable_help"] = "Indiquer les horaires accept�s pour la mise � jour des statistiques:<br>ex: 0|6|12|18 ou 0|8|16";

// texte boutons formulaire
$ogp_lang["actionvalidate_form"] = "Valider";
$ogp_lang["actionreset_form"] = "R�initialiser";
  

// main header / before params
$ogp_lang["noupdate_header"] = "Aucune mise � jour d�tect�e";
$ogp_lang["newversionfound.prefix_header"] = "Une nouvelle version";
$ogp_lang["newversionfound.suffix_header"] = "a �t� trouv�e";
$ogp_lang["downloadaction_header"] = "T�l�charger";
$ogp_lang["tutorialmodmenu_header"] = "Tutoriel de configuration du Module(fran�ais)";

// Interface module
$ogp_lang["modlanguage_lang"] = "Langue";
$ogp_lang["menupos_label"] = "Position du module";
$ogp_lang["menupos_common"] = "Commun";

// Identification jeu et univers
$ogp_lang["servergametype"] = "Type de jeu du serveur";

// Options journalisation
$ogp_lang["plugconnection_logopts"] = "Connection du plugin";
$ogp_lang["spyreportupdate_logopts"] = "Mises � jour de rapports d'espionnage";
$ogp_lang["galviewsupdate_logopts"] = "Mises � jour de galaxie";
$ogp_lang["playerstatsupdate_logopts"] = "Mises � jour classements joueurs";
$ogp_lang["allystatsupdate_logopts"] = "Mises � jour classements alliances";
$ogp_lang["allyhistoryupdate_logopts"] = "Mises � jour classements alliance interne";
$ogp_lang["buildingspageupdate_logopts"] = "Mises � jour de la page b�timents";
$ogp_lang["technopageupdate_logopts"] = "Mises � jour de la page technologie";
$ogp_lang["defencepageupdate_logopts"] = "Mises � jour de la page d�fense";
$ogp_lang["planetempireupdate_logopts"] = "Mises � jour de la page empire(plan�tes)";
$ogp_lang["moonempireupdate_logopts"] = "Mises � jour de la page empire(lunes)";

// Rubrique Gestion des Pages
$ogp_lang["galviews_pghand"] = "Traitement des vues galaxies";
$ogp_lang["playerstats_pghand"] = "Traitement des classements joueur";
$ogp_lang["allystats_pghand"] = "Traitement des classements alliance";
$ogp_lang["allystats_timetable"] = "Horaires accept�s";
$ogp_lang["spyreports_pghand"] = "Traitement des rapports d'espionnage";

// Divers - S�curit�
$ogp_lang["connectattempt_misc"] = "Tentative de connexion non autoris�e/inconnue";
$ogp_lang["blockoutdatedtoolbars_misc"] = "Bloquer et avertir les barre d'outils obsol�tes";
$ogp_lang["logogspluginphp_misc"] = "Activer la journalisation de d�bogage du module";

$ogp_lang["blockextrarequests_misc"] = "Bloquer les requ�tes provenant d'un serveur de jeu non autoris�";
$ogp_lang["databasefailure_misc"] = "�checs de requ�te base de donn�es";
$ogp_lang["gamegate"] = "Portail?";
$ogp_lang["ogamegate_misc"] = "Portail Ogame";
$ogp_lang["euniversgate_misc"] = "Portail E-Univers";
$ogp_lang["projet42gate_misc"] = "Portail Projet42";
$ogp_lang["ogameserver_misc"] = "Serveur d'univers Ogame� associ� au serveur OGSPY";
$ogp_lang["euniversserver_misc"] = "Serveur d'univers E-Univers� associ� au serveur OGSPY/UniSpy";
$ogp_lang["projet42server_misc"] = "Serveur d'univers Projet42� associ� au serveur OGSPY/UniSpy";
$ogp_lang["domain_misc"] = "domaine?";
$ogp_lang["universe_misc"] = "Univers?";
$ogp_lang["errorreadingxmluni_misc"] = "Erreur lecture fichier";
$ogp_lang["universelabel_misc"] = "Univers";
$ogp_lang["plugconnection_misc"] = "Domaine?";

// Diplomatie - Surbrillance commune
$ogp_lang["ptcontract_diplo"] = "Alliances en pacte total";
$ogp_lang["pnacontract_diplo"] = "Alliances en pacte de non agression";
$ogp_lang["enemiesallies_diplo"] = "Alliances enemies";
$ogp_lang["tradingallies_diplo"] = "Alliances commer�antes";

// Redirection
$ogp_lang["notifyredir_redir"] = "Notifier la redirection du script";
$ogp_lang["redirmessage_redir"] = "Message � afficher(url)";

// Infos utilisateurs
$ogp_lang["gameserver_usrinfo"] = "Serveur d'Univers ";
$ogp_lang["gameserver_namelabel"] = "Nom";
$ogp_lang["ogameserver_usrinfo"] = "Serveur d'Univers Ogame";
$ogp_lang["euniversserver_usrinfo"] = "Serveur d'Univers E-Univers";
$ogp_lang["urlplugin_usrinfo"] = "URL plugin";
$ogp_lang["frxplugin_info"] = "Barre d'Outils pour Firefox";
$ogp_lang["download_frxplugin"] = "T�l�charger(enregistrer sous)";
$ogp_lang["tutorial_word"] = "Tutoriel";
$ogp_lang["tutorial_label"] = "Configuration de la Barre d'Outils";



?>
