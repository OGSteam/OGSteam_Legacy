<?php
/***************************************************************************
*	filename	: install.php fr
*	generated	: on 01/14/2009 at 20:55:34
*	created by	: Rica & Styx
***************************************************************************/
/* index.php */
$lang['welcome'] = 'Bienvenue sur le projet OGSpy';
$lang['description-0'] = 'OGSpy est un projet qui a pour but d\'enregistrer dans une base de donn&eacute;es les coordonn&eacute;es de tous les joueurs d\'un univers.';
$lang['description-1'] = 'Disposer d\'un tel outil offre de multiples avantages pour une alliance ou un collectif :';
$lang['description-2'] = 'Recensement de toutes les coordonn&eacute;es libres selon plusieurs crit&egrave;res (galaxie, syst&egrave;me solaire et rang).';
$lang['description-3'] = 'Possibilit&eacute;s d\'extensions quasi illimit&eacute;es gr&acirc;ce aux mods.';
$lang['description-4'] = 'Etc. ...';
$lang['moreinfo'] = 'Si vous souhaitez plus d\'informations, rendez-vous sur ce forum : ';
$lang['chooseaction'] = 'Choisissez quelle action vous d&eacute;sirez effectuer : ';
$lang['fullinstall'] = 'Installation compl&egrave;te';
$lang['update'] = 'Mise à jour';

/* install.php */
$lang['writable'] = 'Acc&egrave;s en &eacute;criture confirm&eacute;';
//$lang['unwritable'] = 'Acc&egrave;s en &eacute;criture pas confirm&eacute;';
$lang['unwritable'] = 'Pas d&apos;acc&egrave;s en &eacute;criture';
$lang['installwarning'] = 'Des erreurs sont survenues et risquent de pertuber le fonctionnement de votre site';
$lang['allowwrite'] = 'Vous devez autoriser ces dossiers en &eacute;criture pour poursuivre :';
//$lang['installtitle'] = 'Installation OGSpy';
//$lang['opterror'] = 'Erreur optionelle (cad osef) :';
//$lang['opterror1'] = 'Ces dossiers servent à l\'installation et à la mise à jour des modules OGSpy.';
//$lang['opterror2'] = 'Leurs dossiers et fichiers doivent &ecirc;tre accessibles en &eacute;criture.';
//$lang['refresh'] = 'Refresh';

$lang['sqlerror'] = 'Erreur durant la proc&eacute;dure d\'installation du serveur OGSpy.';
$lang['installfail'] = 'Echec installation, impossible de g&eacute;n&eacute;rer le fichier \'parameters/id.php\'.';
$lang['installsuccess'] = 'Installation du serveur OGSpy %s effectu&eacute;e avec succ&egrave;s';
$lang['deleteinstall'] = 'Pensez &agrave; supprimer le dossier \'install\'';
//$lang['back'] = 'Retour';

$lang['badcharacterstableprefix'] = 'Des caract&egrave;res utilis&eacute;s pour le pr&eacute;fixe de la base de donn&eacute;es sont incorrect.';
$lang['badcharacterslogin'] = 'Des caract&egrave;res utilis&eacute;s pour le nom d\'utilisateur ou le mot de passe ne sont pas corrects.';
$lang['baduniconfig'] = 'Vous n\'avez pas rentr&eacute; des valeurs correctes pour le nombre de galaxies et/ou de syst&egrave;mes solaires.';
//$lang['badsqlandaccountconfig'] = 'Saisissez correctement les champs de connexion à la base de donn&eacute;es et du compte administrateur.';
$lang['badsqlconfig'] = 'Saisissez correctement les champs de connexion &agrave; la base de donn&eacute;es';

$lang['installwelcome'] = 'Installation d\'OGSpy version %s - Bienvenue !';
$lang['updatewelcome'] = 'Mise &agrave; jour d\'OGSpy vers la version %s - Bienvenue !';
$lang['dbconfigtitle'] = 'Configuration de la base de donn&eacute;es';
$lang['dbhostname'] = 'Nom du Serveur de Base de donn&eacute;es / SGBD';
$lang['dbname'] = 'Nom de votre base de donn&eacute;es';
$lang['dbusername'] = 'Nom d\'utilisateur';
$lang['dbpassword'] = 'Mot de passe';
$lang['dbtableprefix'] = 'Pr&eacute;fixe des tables';
$lang['uniconfigtitle'] = 'Configuration de l\'univers';
$lang['numgalaxies'] = 'Nombre de galaxies';
$lang['numsystems'] = 'Nombre de syst&egrave;mes par galaxie';
$lang['adminconfigtitle'] = 'Configuration du compte administrateur';
$lang['adminloginname'] = 'Nom d\'utilisateur';
$lang['adminpassword'] = 'Mot de passe';
$lang['adminpasswordconfirm'] = 'Mot de passe [Confirmer]';
$lang['serverlanguage'] = 'Langage du serveur OGSpy';
$lang['parsinglanguage'] = 'Langage du parsing du serveur OGSpy';
//$lang['startfullinstall'] = 'D&eacute;marrer l\'installation compl&egrave;te';
//$lang['or'] = 'ou';
//$lang['generateidphp'] = 'G&eacute;n&eacute;rer le fichier \'id.php\'';
$lang['needhelp'] = 'Besoin d\'assistance ?';

$lang['cantconnect'] = 'Impossible de se connecter &agrave; la base de donn&eacute;es';
$lang['noinstallscript'] = 'Le script SQL d\'installation est introuvable';

/* upgrade_to_latest.php */
$lang['updatetitle'] = 'Mise &agrave; jour d\'OGSpy';
$lang['noupdateavailable'] = 'Aucune mise &agrave; jour n\'est disponible';
$lang['updatesuccess'] = 'Mise &agrave; jour du serveur OGSpy vers la version %s effectu&eacute;e avec succ&egrave;s';
$lang['sqlupdated'] = 'Le script a seulement modifi&eacute; la base de donn&eacute;es, pensez &agrave; mettre &agrave; jour vos fichiers';
$lang['notuptodate'] = 'Cette version n\'est pas la derni&egrave;re en date, veuillez r&eacute;ex&eacute;cuter le script';
$lang['newupdate'] = 'Recommencer l\'op&eacute;ration';

// Added
$lang['controltitle'] = 'Contr&ocirc;le des pr&eacute;-requis';
$lang['SQLConnect_Success'] = 'Connexion &agrave; la base de donn&eacute;e r&eacute;alis&eacute;e avec succ&egrave;s.';
$lang['Passwords_NotMatch'] = 'Les mots de passe ne correspondent pas';
$lang['Version_Php_Error'] = 'La version de PHP (%1$s) n\'est pas compatible (version minimum requise %2$s)';
$lang['Param_chmod_Error'] = 'Les droits en &eacute;criture du dossier /parameters/ n\'ont pu &ecirc;tre mis en place';
$lang['Log_chmod_Error'] = 'Les droits en &eacute;criture du dossier /journal/ n\'ont pu &ecirc;tre mis en place';
$lang['Mod_chmod_Error'] = 'Les droits en &eacute;criture du dossier /mod/ n\'ont pu &ecirc;tre mis en place';
$lang['ConfigControl_Success'] = 'Tout est en ordre pour installer OGSpy';
$lang['ConfigControl_Fail'] = '<span style="color: #ff0000; font-size:14px;">Vous ne pouvez pas poursuivre l&apos;installation de OGSpy tant que vous n&apos;aurez pas corrig&eacute; les erreurs</span>';
$lang['Parameter_Access'] = 'Acc&egrave;s au dossier /parameters/';
$lang['Journal_Access'] = 'Acc&egrave;s au dossier /journal/';
$lang['Mod_Access'] = 'Acc&egrave;s au dossier /mod/';
$lang['Enter_SQL_Access'] = 'Entrez les param&egrave;tres du serveur SQL';
$lang['Enter_Admin_Access'] = 'Entrez les informations du compte Admin';
$lang['OGSpy_1st_Config'] = 'Configuration de OGSpy';
$lang['servername'] = 'Nom du Serveur';
$lang['Cartography'] = 'Cartographie';
$lang['speeduni'] = 'Vitesse de l\'Univers';
$lang['ddr'] = 'Depot de Ravitaillement';
$lang['Unable_Open_Mod'] = 'Impossible d\'ouvrir le dossier des mods';
$lang['Mod_Name'] = 'Modules Installable';
$lang['Install_Button'] = 'Installer';
$lang['Thanks_For_Having_Installed_OGSpy'] = 'Merci d\'avoir install&eacute; OGSpy!!!';
$lang['end_install_notes'] = 'Tr&egrave;s bien, maintenant que votre OGSpy est bien configur&eacute; autant au niveau de ses configurations basiques que de ses modules ou du compte admin, vous pouvez maintenant finaliser l\'installation du serveur pour pouvoir commencer &agrave; en profiter imm&eacute;diatement.<br /><br />En revanche, si vous avez un doute au sujet de vos r&eacute;glages, il est toujours temps d\'utiliser le bouton pr&eacute;c&eacute;dent pour revenir à l\'&eacute;tape en question.<br /><br />Une fois l\'installation valid&eacute;e, il ne sera plus possible de revenir modifier l\'installation.';
$lang['end_install_notes2'] = 'Votre OGSpy est maintenant op&eacute;rationnel !<br /><br />Vous allez devoir supprimer le dossier /install/ de votre OGSpy pour pouvoir vous connecter';
$lang['end_install_button'] = 'Terminer l\'installation';
$lang['Install_Modules_Inclued'] = 'Installation des modules fournis';
$lang['Return_to_OGSpy'] = 'Se connecter à OGSpy';
$lang['PHP_Version'] = 'Version de PHP : %s';
$lang['Already_Installed'] = 'Installation OK';
$lang['Installed_OutDate'] = 'Install&eacute; mais version d&eacute;pass&eacute;e';
$lang['SQL_Version_Error'] = 'La version de votre serveur SQL (%1$s) est trop ancienne: Version requise (%2$s)';
$lang['Admin_Create_Success'] = 'Le compte admin a &eacute;t&eacute; cr&eacute;&eacute; avec succ&egrave;s';
$lang['SQL_Installation_Success'] = 'La base de donn&eacute;e a &eacute;t&eacute; configur&eacute;e avec succ&egrave;s';
$lang['Wrong_DB_Name'] = 'Le nom de la base de donn&eacute;e n\'est pas valide';

$lang['select_all'] = 'Tout';
$lang['unselect_all'] = 'Aucun';
$lang['reverse_all'] = 'Inverse';
?>
