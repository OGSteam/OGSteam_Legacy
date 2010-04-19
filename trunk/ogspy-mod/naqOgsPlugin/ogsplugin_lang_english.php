<?php
/***************************************************************************
*	filename	: ogsplugin_lang_english.php
*	desc.		: Fichier de langue EN pour ogsplugin.php - english resource strings
*	Author		: Naqdazar   -
*	created		: 28/11/2006
*	modified	:
***************************************************************************/


// ******************
// * ogsplugmod.php *
// ******************
// sous menu du module OGS Plugin

// ******************
// * ogsplugmod.php *
// ******************
// sous menu du module OGS Plugin / submenus of OGS Plugin admin page
$ogp_lang["principal_menu"] = "Main";
$ogp_lang["ogspylog_menu"] = "OGSPY Log";
$ogp_lang["ogspygroupman_menu"] = "Groups management";
$ogp_lang["history_menu"] = "History";
$ogp_lang["thirdpartymods_menu"] = "Author's others tools";

// Pied de Page
$ogp_lang["developpedby_tail"] = "developped by";
$ogp_lang["forumlinkinfo_tail"] = "Having question?";
$ogp_lang["authorforum_tail"] = "Support Forum (Author/French)";

// *******************
// * ogsplugmain.php *
// *******************
// titres de rubrique du panneau principal
$ogp_lang["moduleinterf_main"] = "Module Interface";
$ogp_lang["gameident_main"] = "Game and Universe Settings";
$ogp_lang["pluglogopts_main"] = "Mod logging options";
$ogp_lang["pagehandling_main"] = "Pages management - Common data";
$ogp_lang["miscellanous_main"] = "Miscellanous - Security";
$ogp_lang["diplomaty_main"] = "Diplomaty - Common Game HighLighting";
$ogp_lang["redirection_main"] = "Redirect message";
$ogp_lang["usersinfos_main"] = "User config settings";

// texte bulles d'aide
$ogp_lang["ogsplug_univ_help"] = "Universe server name related to current OGSPY / Unispy server.<br><b>eg.</b> for universe 12</b>(Ogame): <b>ogame190.de<br />universe <b>beta4</b>(E-Univers): <b>beta4.e-univers.org</b><br />Modify to show universe number fill in box.";
$ogp_lang["ogsplug_log_help"] = "Actions labels which be logged (french).<br>02/11/2006 00:49:25 :  Joueur charge 15 planètes du système 2:294(2:294) via plugin OGSPY (1.6)";
$ogp_lang["ogsgametype_help"] = "Submit this option before gates URLs list can be updated!!";
$ogp_lang["ogsportailurl_help"] = "Submit this option before universe list can be updated!";
$ogp_lang["ogsactivate_debuglog_help"] = "This option can reveal confifential data<br>and is intended to bug tracking.<br>Use with care!";
$ogp_lang["ogspageman_help"] = "These options set common Ogame data handled on ogsplugin mod<br>Please, check them all but don't in case on a stat server for example<br>Data not handled will be notified to sending toolbars";
$ogp_lang["ogsstats_timetable_help"] = "Fill in allowed stats timetables:<br>e.g.: 0|6|12|18 or 0|8|16";

// texte boutons formulaire
$ogp_lang["actionvalidate_form"] = "Submit";
$ogp_lang["actionreset_form"] = "Reset";

// main header / before params
$ogp_lang["noupdate_header"] = "No update found";
$ogp_lang["newversionfound.prefix_header"] = "A new version";
$ogp_lang["newversionfound.suffix_header"] = "has been found";
$ogp_lang["downloadaction_header"] = "Download";
$ogp_lang["tutorialmodmenu_header"] = "Toolbar Settings Tutorial of Module(french)";

// Interface module

$ogp_lang["modlanguage_lang"] = "Langage";
$ogp_lang["menupos_label"] = "Menu position";
$ogp_lang["menupos_common"] = "Common";

// Identification jeu et univers
$ogp_lang["servergametype"] = "Game server type";

// Options journalisation
$ogp_lang["plugconnection_logopts"] = "Firefox Plugin auth";
$ogp_lang["spyreportupdate_logopts"] = "Spy reports update";
$ogp_lang["galviewsupdate_logopts"] = "Galaxy updates";
$ogp_lang["playerstatsupdate_logopts"] = "Player stats updates";
$ogp_lang["allystatsupdate_logopts"] = "Ally stats updates";
$ogp_lang["allyhistoryupdate_logopts"] = "Ally histories updates";
$ogp_lang["buildingspageupdate_logopts"] = "Building pages update";
$ogp_lang["technopageupdate_logopts"] = "Laboratory page updates";
$ogp_lang["defencepageupdate_logopts"] = "Defence page updates";
$ogp_lang["planetempireupdate_logopts"] = "Planet empire update";
$ogp_lang["moonempireupdate_logopts"] = "Moon empire update";

// Rubrique Gestion des Pages
$ogp_lang["galviews_pghand"] = "Handle galaxy views";
$ogp_lang["playerstats_pghand"] = "Handle player stats";
$ogp_lang["allystats_pghand"] = "Handle ally stats";
$ogp_lang["allystats_timetable"] = "Stats timetable";
$ogp_lang["spyreports_pghand"] = "Handle spy reports";

// Divers - Sécurité
$ogp_lang["connectattempt_misc"] = "Unknown / unallowed auth attempt";
$ogp_lang["blockoutdatedtoolbars_misc"] = "Block and notify outdated toolbars' users";
$ogp_lang["logogspluginphp_misc"] = "Enable OGS Plugin MOD";


$ogp_lang["blockextrarequests_misc"] = "Block game datas from unallowed servers?";
$ogp_lang["databasefailure_misc"] = "Database server failures";
$ogp_lang["gamegate"] = "Gate?";
$ogp_lang["ogamegate_misc"] = "Ogame gate";
$ogp_lang["euniversgate_misc"] = "E-Univers Gate";
$ogp_lang["ogameserver_misc"] = "Ogame&reg; server related to this OGSpy/Unispy server";
$ogp_lang["euniversserver_misc"] = "E-Univers&reg; server related to this  OGSpy/Unispy server";
$ogp_lang["domain_misc"] = "domain?";
$ogp_lang["universe_misc"] = "Universe?";
$ogp_lang["errorreadingxmluni_misc"] = "Error reading file";
$ogp_lang["universelabel_misc"] = "Universe";
$ogp_lang["plugconnection_misc"] = "Domain?";

// Diplomatie
$ogp_lang["ptcontract_diplo"] = "Friend allies";
$ogp_lang["pnacontract_diplo"] = "Neutral allies";
$ogp_lang["enemiesallies_diplo"] = "Enemy allies";
$ogp_lang["tradingallies_diplo"] = "Trading allies";

// Redirection
$ogp_lang["notifyredir_redir"] = "Notify script redirection";
$ogp_lang["redirmessage_redir"] = "Message to show(url)";

// Infos utilisateurs
$ogp_lang["gameserver_usrinfo"] = "Universe server ";
$ogp_lang["gameserver_namelabel"] = "Name";
$ogp_lang["ogameserver_usrinfo"] = "Ogame Universe server";
$ogp_lang["euniversserver_usrinfo"] = "E-Universe Universe server";
$ogp_lang["urlplugin_usrinfo"] = "Plugin URL";
$ogp_lang["frxplugin_info"] = "Firefox Toolbar'";
$ogp_lang["download_frxplugin"] = "Download(save as)";
$ogp_lang["tutorial_word"] = "Tutorial";
$ogp_lang["tutorial_label"] = "Toolbar Settings";
?>
