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
$ogp_lang["thirdpartymods_menu"]="Du Même Auteur";



// Pied de Page
$ogp_lang["developpedby_tail"]="développé par";
$ogp_lang["forumlinkinfo_tail"]="Espace surpport";
$ogp_lang["authorforum_tail"]="Forum Support(Auteur)";

// *******************
// * ogsplugmain.php *
// *******************
// titres de rubrique du panneau principal
$ogp_lang["moduleinterf_main"] = "Interface Module";
$ogp_lang["gameident_main"]="Identification de jeu et d'univers [Obligatoire] (Valider 1 puis 2 et enfin 3)";
$ogp_lang["pluglogopts_main"]="Option de journalisation du plugin [Facultatif]";
$ogp_lang["pagehandling_main"]="Traitement des Pages - Données Communes [Obligatoire]";
$ogp_lang["miscellanous_main"]="Sécurité [Recommandé]";
$ogp_lang["diplomaty_main"]="Diplomatie - Surbrillance globale utilisateurs [Facultatif]";
$ogp_lang["redirection_main"]="Message de Redirection [Facultatif]";
$ogp_lang["usersinfos_main"]="Infos de configuration Utilisateur";

// texte bulles d'aide
$ogp_lang["ogsplug_univ_help"] = "Nom du serveur de l'univers associé au serveur OGSPY courant.<br><b>Ex.</b> pour l'<b>univers 12</b>(Ogame): <b>ogame190.de<br />l'univers <b>beta4</b>(E-Univers): <b>beta4.e-univers.org</b><br />Modifier pour faire apparaître la boîte de saisie de numéro d'univers.";
$ogp_lang["ogsplug_log_help"] = "Libellés des opérations qui seront enregistrées dans le journal.<br>02/11/2006 00:49:25 :  Joueur charge 15 planètes du système 2:294(2:294) via plugin OGSPY (1.6)";
$ogp_lang["ogsgametype_help"] = "Valider cette option avant que la liste des portails ne puisse être mise à jour!";
$ogp_lang["ogsportailurl_help"] = "Valider cette option avant que la liste des univers ne puisse être mise à jour!";
$ogp_lang["ogsactivate_debuglog_help"] = "Cette option peut révéler des informations confidentielles<br>et n'est destinée qu'à des fins de déboguage.<br>L'utiliser relève de votre responsabilité!";
$ogp_lang["ogspageman_help"] = "Ces options définissent les catégories de <u>données communes</u> acceptées par le module.<br>Il est recommandé de cocher toutes les cases, sauf pour un serveur dédié aux statistiques par exemple.<br>Toutes données reçues mais non gérées seront notifiées à la barre d'outils émettrice.";
$ogp_lang["ogsstats_timetable_help"] = "Indiquer les horaires acceptés pour la mise à jour des statistiques:<br>ex: 0|6|12|18 ou 0|8|16";

// texte boutons formulaire
$ogp_lang["actionvalidate_form"] = "Valider";
$ogp_lang["actionreset_form"] = "Réinitialiser";
  

// main header / before params
$ogp_lang["noupdate_header"] = "Aucune mise à jour détectée";
$ogp_lang["newversionfound.prefix_header"] = "Une nouvelle version";
$ogp_lang["newversionfound.suffix_header"] = "a été trouvée";
$ogp_lang["downloadaction_header"] = "Télécharger";
$ogp_lang["tutorialmodmenu_header"] = "Tutoriel de configuration du Module(français)";

// Interface module
$ogp_lang["modlanguage_lang"] = "Langue";
$ogp_lang["menupos_label"] = "Position du module";
$ogp_lang["menupos_common"] = "Commun";

// Identification jeu et univers
$ogp_lang["servergametype"] = "Type de jeu du serveur";

// Options journalisation
$ogp_lang["plugconnection_logopts"] = "Connection du plugin";
$ogp_lang["spyreportupdate_logopts"] = "Mises à jour de rapports d'espionnage";
$ogp_lang["galviewsupdate_logopts"] = "Mises à jour de galaxie";
$ogp_lang["playerstatsupdate_logopts"] = "Mises à jour classements joueurs";
$ogp_lang["allystatsupdate_logopts"] = "Mises à jour classements alliances";
$ogp_lang["allyhistoryupdate_logopts"] = "Mises à jour classements alliance interne";
$ogp_lang["buildingspageupdate_logopts"] = "Mises à jour de la page bâtiments";
$ogp_lang["technopageupdate_logopts"] = "Mises à jour de la page technologie";
$ogp_lang["defencepageupdate_logopts"] = "Mises à jour de la page défense";
$ogp_lang["planetempireupdate_logopts"] = "Mises à jour de la page empire(planètes)";
$ogp_lang["moonempireupdate_logopts"] = "Mises à jour de la page empire(lunes)";

// Rubrique Gestion des Pages
$ogp_lang["galviews_pghand"] = "Traitement des vues galaxies";
$ogp_lang["playerstats_pghand"] = "Traitement des classements joueur";
$ogp_lang["allystats_pghand"] = "Traitement des classements alliance";
$ogp_lang["allystats_timetable"] = "Horaires acceptés";
$ogp_lang["spyreports_pghand"] = "Traitement des rapports d'espionnage";

// Divers - Sécurité
$ogp_lang["connectattempt_misc"] = "Tentative de connexion non autorisée/inconnue";
$ogp_lang["blockoutdatedtoolbars_misc"] = "Bloquer et avertir les barre d'outils obsolètes";
$ogp_lang["logogspluginphp_misc"] = "Activer la journalisation de débogage du module";

$ogp_lang["blockextrarequests_misc"] = "Bloquer les requètes provenant d'un serveur de jeu non autorisé";
$ogp_lang["databasefailure_misc"] = "Échecs de requète base de données";
$ogp_lang["gamegate"] = "Portail?";
$ogp_lang["ogamegate_misc"] = "Portail Ogame";
$ogp_lang["euniversgate_misc"] = "Portail E-Univers";
$ogp_lang["projet42gate_misc"] = "Portail Projet42";
$ogp_lang["ogameserver_misc"] = "Serveur d'univers Ogame® associé au serveur OGSPY";
$ogp_lang["euniversserver_misc"] = "Serveur d'univers E-Univers® associé au serveur OGSPY/UniSpy";
$ogp_lang["projet42server_misc"] = "Serveur d'univers Projet42® associé au serveur OGSPY/UniSpy";
$ogp_lang["domain_misc"] = "domaine?";
$ogp_lang["universe_misc"] = "Univers?";
$ogp_lang["errorreadingxmluni_misc"] = "Erreur lecture fichier";
$ogp_lang["universelabel_misc"] = "Univers";
$ogp_lang["plugconnection_misc"] = "Domaine?";

// Diplomatie - Surbrillance commune
$ogp_lang["ptcontract_diplo"] = "Alliances en pacte total";
$ogp_lang["pnacontract_diplo"] = "Alliances en pacte de non agression";
$ogp_lang["enemiesallies_diplo"] = "Alliances enemies";
$ogp_lang["tradingallies_diplo"] = "Alliances commerçantes";

// Redirection
$ogp_lang["notifyredir_redir"] = "Notifier la redirection du script";
$ogp_lang["redirmessage_redir"] = "Message à afficher(url)";

// Infos utilisateurs
$ogp_lang["gameserver_usrinfo"] = "Serveur d'Univers ";
$ogp_lang["gameserver_namelabel"] = "Nom";
$ogp_lang["ogameserver_usrinfo"] = "Serveur d'Univers Ogame";
$ogp_lang["euniversserver_usrinfo"] = "Serveur d'Univers E-Univers";
$ogp_lang["urlplugin_usrinfo"] = "URL plugin";
$ogp_lang["frxplugin_info"] = "Barre d'Outils pour Firefox";
$ogp_lang["download_frxplugin"] = "Télécharger(enregistrer sous)";
$ogp_lang["tutorial_word"] = "Tutoriel";
$ogp_lang["tutorial_label"] = "Configuration de la Barre d'Outils";



?>
