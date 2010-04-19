<?php
/***************************************************************************
*	filename	: lang_main.php
*	desc.		: Fichier de langue FR
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 21/08/2006
*	modified	: 
***************************************************************************/
// escaper ' entre "" -> "l\'aurore"

global $server_config; // pour r�cup valeur config dans cha�nes

//Param�tres langues
$LANG["french"] = "Francais";

//setup
$LANG["Language_french"] = "Francais";


//Param�tre linguistiques : langue ; encodage des caract�res
$LANG["ENCODING"] = "ISO-8859-1";
$LANG["LANGUAGE"] = "FR";


//Courants
$LANG["basic_Yes"] = "Oui";
$LANG["basic_No"] = "Non";
$LANG["basic_Statistics"] = "Statistiques";


//
$LANG["univers_Player"] = "Joueur";
$LANG["univers_Players"] = "Joueurs";
$LANG["univers_Ally"] = "Alliance";
$LANG["univers_Allys"] = "Alliances";
$LANG["univers_SpyReports"] = "Rapports d'espionnage";
$LANG["univers_Galaxy"] = "Galaxie";
$LANG["univers_Planet"] = "Plan�te";
$LANG["univers_Planets"] = "Plan�tes";
$LANG["univers_Satellite"] = "Satellite";
$LANG["univers_Titane"] = "Titane";
$LANG["univers_Carbon"] = "Carbone";
$LANG["univers_Tritium"] = "Tritium";
$LANG["univers_Energy"] = "Energie";
$LANG["univers_TitaneMine"] = "Mine de titane";
$LANG["univers_CarbonMine"] = "Mine de carbone";
$LANG["univers_TritiumExtractor"] = "Extracteur de Tritium";
$LANG["univers_GeothermalPlant"] = "Centrale G�othermique";
$LANG["univers_TritiumPlant"] = "Centrale � tritium";
$LANG["univers_DroidFactory"] = "Usine de dro�des";
$LANG["univers_AndroidsFactory"] = "Usine d'Andro�des";
$LANG["univers_ArmsFactory"] = "Usine d'armement";
$LANG["univers_TitaneStorage"] = "Silo de Titane";
$LANG["univers_CarbonStorage"] = "Silo de Carbone";
$LANG["univers_TritiumStorage"] = "Silo de Tritium";
$LANG["univers_TechnicalCenter"] = "Centre Technique";
$LANG["univers_MolecularConverter"] = "Convertisseur mol�culaire";
$LANG["univers_Terraformer"] = "Terraformeur";
$LANG["univers_MissileSilo"] = "Hangar de missiles";
$LANG["univers_Espionage"] = "Espionnage";
$LANG["univers_Quantum"] = "Quantique";
$LANG["univers_Alloys"] = "Alliages";
$LANG["univers_CarbonStrat"] = "Stratification carbone";
$LANG["univers_Refinery"] = "Raffinerie";
$LANG["univers_Armament"] = "Armement";
$LANG["univers_Shield"] = "Bouclier";
$LANG["univers_Armour"] = "Blindage";
$LANG["univers_Thermodynamics"] = "Thermodynamique";
$LANG["univers_Antimatter"] = "Antimati�re";
$LANG["univers_Hyperdrive"] = "HyperDrive";
$LANG["univers_ImpulseDrive"] = "Impulsion";
$LANG["univers_Warp"] = "Warp";
$LANG["univers_Smart"] = "Smart";
$LANG["univers_Ions"] = "Ions";
$LANG["univers_Aereon"] = "Aereon";
$LANG["univers_GreatComputer"] = "Super Calculateur";
$LANG["univers_Graviton"] = "Graviton";
$LANG["univers_Administration"] = "Administration";
$LANG["univers_Exploitation"] = "Exploitation";
$LANG["univers_RocketLauncher"] = "BFG";
$LANG["univers_LightLaser"] = "Smart BFG";
$LANG["univers_HeavyLaser"] = "Plate-Forme Canon";
$LANG["univers_GaussCannon"] = "D�flecteurs";
$LANG["univers_IonCannon"] = "Plate-Forme Ionique";
$LANG["univers_PlasmaTuret"] = "Aereon Missile Defense";
$LANG["univers_SmallShield"] = "Champ de force";
$LANG["univers_LargeShield"] = "Holochamp";
$LANG["univers_AntiBallisticMissiles"] = "Contre Mesure Electromagn�tique";
$LANG["univers_InterplanetaryMissiles"] = "Missile EMP";
$LANG["univers_TemperatureMax"] = "Temp�rature Max";
$LANG["univers_Temperature"] = "Temp�rature";
$LANG["univers_Field"] = "Cases";
$LANG["univers_Coordinates"] = "Coordonn�es";
$LANG["univers_Empire"] = "Empire";
$LANG["univers_Tech"] = "Technologies";
$LANG["univers_Building"] = "B�timents";
$LANG["univers_Defence"] = "D�fenses";
$LANG["univers_Research"] = "Recherches";
$LANG["univers_Technology"] = "Technologies";


//Pied de page
$LANG["Time_generation"] = "Temps de g�n�ration";
$LANG["pagetail_Copyright"] = "is a";
$LANG["pagetail_Copyright2"] = "Kyser Software";

//Page d"accueil d"identification
$LANG["Connection_parameters"] = "Param�tres de connexion";
$LANG["Username"] = "Nom d'utilisateur";
$LANG["Password"] = "Mot de passe";
$LANG["Log_in"] = "Se connecter";

//Menu
$LANG["server_Time"] = "Heure serveur";
$LANG["Server_time2"] = "Initialisation en cours";
$LANG["server_Offline"] = "Serveur hors-ligne";
$LANG["menu_Administration"] = "Administration";
$LANG["menu_Profile"] = "Profil";
$LANG["menu_Home"] = "Espace personnel";
$LANG["menu_AllyTerritory"] = "Espace alliance";
$LANG["menu_Search"] = "Recherche";
$LANG["menu_Ranking"] = "Classement";
$LANG["menu_Statistics"] = "Statistiques";
$LANG["menu_ObsoletedData"] = "Syst. obsol�tes";
$LANG["menu_Logout"] = "D�connexion";
$LANG["menu_Forum"] = "Forum";
$LANG["menu_About"] = "A propos ...";





//message.php
//(ericalens)
$LANG["message_SystemMessage"] = "Message Syst�me";
$LANG["message_DontHaveRights"] = "Vous ne disposez pas des droits n�cessaires pour effectuer cette action";
$LANG["message_ErrorFatal"]  =  "Interruption suite � une erreur fatale";
$LANG["message_ErrorData"]  =  "Les donn�es transmises sont incorrectes";
$LANG["message_AccountCreation"] = "Cr�ation du compte de <a>%s</a> r�ussie";
$LANG["message_AccountTransmitInfo"] = "Transmettez lui ces informations";
$LANG["message_ServerURL"] = "URL du serveur";
$LANG["message_Password"] = "Mot de passe";
$LANG["message_ChangePasswordSuccess"] = "G�n�ration du nouveau mot de passe de <a>%s</a> r�ussie";
$LANG["message_SendPassword"] = "Transmettez lui son mot de passe";
$LANG["message_RegeneratePasswordFailed"] = "G�n�ration du nouveau mot de passe �chou�e";
$LANG["message_FailedPseudoLocked"] = "Cr�ation du compte de <a>%s</a> �chou�e";
$LANG["message_AccountCreationFailed"] = "Cr�ation du compte de <a>%s</a> �chou�e";
$LANG["message_NickRequierements"] = "Le pseudo doit contenir entre 3 et 15 caract�res standards";
$LANG["message_NickIncorrect"] = "Le pseudo est incorrect";
$LANG["message_ProfileChangedSuccess"] = "Modification du profil de <a>%s</a> r�ussie";
$LANG["message_ProfileChangedFailed"] = "Modification du profil �chou�e";
$LANG["message_UserProfileChangedSuccess"] = "Modification de votre profil r�ussie";
$LANG["message_UserProfileChangedFailed"] = "Modification de votre profil a �chou�e";
$LANG["message_UserPasswordCheck"] = "Saisissez correctement votre ancien mot de passe et deux fois le nouveau";
$LANG["message_PasswordRequiert"] = "Le mot de passe doit contenir entre 6 et 15 caract�res standards";
$LANG["message_NickAlreadyUsed"] = "Le pseudo est d�j� utilis� par un autre membre";
$LANG["message_DeleteMemberSuccess"] = "Suppression du membre <a>%s</a> r�ussie";
$LANG["message_DeleteMemberFailed"] = "Suppression du membre �chou�e";
$LANG["message_LoginWrong"] = "Identifiants de connexion incorrects";
$LANG["message_AccountLock"] = "Votre compte n'est pas activ�";
$LANG["message_ContactAdmin"] = "Contactez un administrateur";
$LANG["message_MaxFavorites"] = "Vous avez atteint le nombre maximal de favoris (%s)";
$LANG["message_ServerConfigFailed"] = "La configuration des param�tre serveur � echou�e";
$LANG["message_ServerConfigSuccess"] = "Configuration des param�tre serveur achev�e avec succ�s";
$LANG["message_LogMissing"] = "Il n'y a pas de fichiers logs � cette p�riode";
$LANG["message_PlanetIDFailed"] = "Veuillez pr�ciser la plan�te concern�e";
$LANG["message_DeleteInstall"] = "Veuillez supprimer le dossier 'install'";
$LANG["message_LoadedSpyReport"] = "Chargement des rapports d'espionnage termin�";
$LANG["message_SpyReportFor"] = "Rapport d'espionnage de la plan�te %s";
$LANG["message_Loaded"] = "Charg�";
$LANG["message_Ignored"] = "Ignor�";
$LANG["message_GroupCreationSuccess"] = "Cr�ation du groupe <a>%s</a> r�ussie";
$LANG["message_GroupCreationFailed"] = "Cr�ation du groupe <a>%s</a> �chou�";
$LANG["message_NameAlreadyUsed"] = "Le nom est d�j� utilis�";
$LANG["message_GroupNameRequiert"] = "Le nom doit contenir entre 3 et 15 caract�res standards";
$LANG["message_GroupNameIncorrect"] = "Le nom est incorrect";
$LANG["message_DBOptimizeFinished"] = "Optimisation termin�e";
$LANG["message_DBSpaceBeforeOptimize"] = "Espace occup� avant optimisation";
$LANG["message_DBSpaceAfterOptimize"] = "Espace occup� apr�s optimisation";
$LANG["message_EmpireFailed"] = "Un probleme est survenu durant l'acquisition de votre empire";
$LANG["message_Return"] = "Retour";

//admin_members_group.php
//ericalens
//
$LANG["admingroup_GroupCreate"] = "Cr�ation d'un groupe";
$LANG["admingroup_Permissions"] = "Permissions";
$LANG["admingroup_SelectGroup"] = "S�lectionnez un groupe";
$LANG["admingroup_ShowPermissions"] = "Voir les permissions";
$LANG["admingroup_GroupMember"] = "Membre du groupe";
$LANG["admingroup_ConfirmMemberDeletion"] = "Etes-vous s�r de vouloir supprimer %s du groupe ?";
$LANG["admingroup_MemberList"] = "Liste des membres";
$LANG["admingroup_AddToGroup"] = "Ajouter dans le groupe";
$LANG["admingroup_ConfirmGroupDeletion"] = "Etes-vous s�r de vouloir supprimer le groupe ?";
$LANG["admingroup_DeleteGroup"] = "Supprimer le groupe";
$LANG["admingroup_GroupName"] = "Nom du groupe";
$LANG["admingroup_ShowProtectedAlly"] = "Visualiser coordonn�es alliances prot�g�es";
$LANG["admingroup_ValidatePermissions"] = "Valider les permissions";

//itori
$LANG["admingroup_Modname"] = "Nom du mod";



//admin_mod.php
//ericalens
//
$LANG["adminmod_ActiveMods"] = "Mods install�s actifs";
$LANG["adminmod_Up"] = "Monter";
$LANG["adminmod_Down"] = "Descendre";
$LANG["adminmod_Desactivate"] = "Desactiver";
$LANG["adminmod_Uninstall"] = "D�sinstaller";
$LANG["adminmod_Update"] = "Mettre � jour";
$LANG["adminmod_InactiveMods"] = "Mods install�s inactifs";
$LANG["adminmod_Activate"] = "Activer";
$LANG["adminmod_InstallableMods"] = "Mods non install�s";
$LANG["adminmod_Install"] = "Installer";
$LANG["adminmod_InvalidMods"] = "Mods invalides";

//Verite
$LANG["adminmod_confirm_Desactivate"] = "La desactivation rendra le mod inaccessible � tous les membres. Confirmez-vous cette action ?";
$LANG["adminmod_confirm_Uninstall"] = "La suppression du mod entrainera la suppression des donn�es le concernant. Confirmez-vous cette action ?";

// Naqdazar
$LANG["adminmod_Action"] = "Action";
$LANG["adminmod_promote"] = "Promouvoir";
$LANG["adminmod_position"] = "Position";
$LANG["adminmod_sitting"] = "Emplacement";
$LANG["adminmod_user_required"]= "Utilisateur requis";
$LANG["adminmod_validate_mod_params"] = "Valider les param�tres du mod ";
$LANG["adminmod_sort_alpha"] = "Trier alphab�tiquement";

$LANG["adminmod_menupos_header"] = "Ent�te";
$LANG["adminmod_menupos_home"] = "Perso";
$LANG["adminmod_menupos_common"] = "Commun";
$LANG["adminmod_menupos_thirdparty"] = "Tierce Partie";
$LANG["adminmod_menupos_admin"] = "Admin";
$LANG["adminmod_menupos_homearea"] = "Espace Perso";

//admin_parameters.php
//ericalens
//
$LANG["adminparam_GeneralOptions"] = "Option g�n�rales du serveur";
$LANG["adminparam_ServerName"] = "Nom du serveur";
$LANG["adminparam_Language"] = "Langage du serveur";
$LANG["adminparam_Language_parsing"] = "Langage du parsing du serveur";
$LANG["adminparam_timeshift"] = "D�calage horaire";
$LANG["adminparam_ActivateServer"] = "Activer le serveur";
$LANG["adminparam_ServerDownReason"] = "Motif fermeture";
$LANG["adminparam_MembersOptions"] = "Option des membres";
$LANG["adminparam_EnableDesactivateIPCheck"] = "Autoriser la d�sactivation du controle des adresses ip";
$LANG["adminparam_DefaultSkin"] = "Skin par d�faut";
$LANG["adminparam_MaximumFavorites"] = "Nombre maximum de favoris syst�me autoris�";
$LANG["adminparam_MaximumSpyReport"] = "Nombre maximum de rapports d'espionnage favoris autoris�";
$LANG["adminparam_SessionsManagement"] = "Gestion des sessions";
$LANG["adminparam_SessionDuration"] = "Dur�e des sessions";
$LANG["adminparam_InfiniteSession"] = "dur�e ind�termin�e";
$LANG["adminparam_AllianceProtection"] = "Protection alliance";
$LANG["adminparam_HidenAllianceList"] = "Liste des alliances � ne pas afficher";
$LANG["adminparam_AddComaBetweenAlliance"] = "S�parez les alliances avec des virgules";
$LANG["adminparam_FriendlyAllianceList"] = "Liste des alliances amies";
$LANG["adminparam_OtherParameters"] = "Param�tres divers";
$LANG["adminparam_AllyBoardLink"] = "Lien du forum de l'alliance";
$LANG["adminparam_LogSQLQuery"] = "Journaliser les transactions et requ�tes SQL";
$LANG["adminparam_WarnPerformance"] = "Risque de d�gradation des performances du serveur";
$LANG["adminparam_Maintenance"] = "Maintenance";
$LANG["adminparam_KeepRankingDuration"] = "Dur�e de conservation des classements [1-50 jours ou nombre]";
$LANG["adminparam_Number"] = "Nombre";
$LANG["adminparam_Days"] = "Jours";
$LANG["adminparam_MaximumSpyReportByPlanets"] = "Nombre maximal de rapports d'espionnage par plan�te [1-10]";
$LANG["adminparam_KeepSpyReportDuration"] = "Dur�e de conservation des rapports d'espionnage [1-90 jours]";
$LANG["adminparam_KeepLogfileDuration"] = "Dur�e de conservation des fichiers logs <a>[0-365 jours]</a>";
$LANG["adminparam_Validate"] = "Valider";
$LANG["adminparam_Reset"] = "R�initialiser";
$LANG["adminparam_defaultloginpage"]="Page de login par defaut";
//rajout pour les couleurs des alliances prot�g�es
//Verite
$LANG["adminparam_color_ally_hided"] = "Couleur pour les alliances � ne pas afficher :";
$LANG["adminparam_color_ally_friend"] = "Couleur pour les alliances amies :";
$LANG["adminparam_color_exemple"] = "Par exemple pour rouge : #FF0000";
$LANG["adminparam_galaxyOption"] = "Configuration de la galaxie";
$LANG["adminparam_nbgalaxy"] = "Nombre de galaxies";
$LANG["adminparam_nbsystem"] = "Nombre de syst�mes solaires par galaxie";
$LANG["adminparam_nbrow"] = "Nombre de positions par syst�me solaire";
$LANG["adminparam_galaxyOptionwarning"] = "/!\ Attention /!\<br> La modification de ces informations peut entrainer la suppression de certaines donn�es. Par exemple si vous �tiez � 16 galaxies et que vous passez � 15, toutes les donn�es de la galaxie 16 seront supprim�es. <br>Pour cette raison, ces param�tres ne sont modifiable que par l'administrateur";
$LANG["adminparam_unispeed"] = "Vitesse de l'univers";

//views/statistics.php
//ericalens
//
$LANG["stats_DBState"] = "Etat de la base de donn�es";
$LANG["stats_KnownPlanets"] = "Plan�tes r�pertori�es";
$LANG["stats_FreePlanets"] = "Plan�tes colonisables";
$LANG["stats_UpdatedRecentlyPlanets"] = "Plan�te mise � jour r�cemment";
$LANG["stats_Nicknames"] = "Pseudos";
$LANG["stats_RankingLines"] = "Classement (lignes)";
$LANG["stats_ResearchMade"] = "Recherches<br />effectu�es";
$LANG["stats_Ratio"] = "Ratio";
$LANG["stats_LoadedFromBrowser"] = "Charg�es via le navigateur";
$LANG["stats_LoadedFromOGS"] = "Charg�es via OGS";
$LANG["stats_SendedToOGS"] = "Envoy�es vers OGS";
$LANG["stats_ConnectedLegend"] = "(*) connect� sur le serveur<br />(**) connect� avec OGS et/ou sur le serveur";

//includes/galaxy.php
//ericalens
//
$LANG["incgal_AccesDenied"] = "Acc�s refus�";
$LANG["incgal_IncorrectData"] = "Donn�es transmises incorrectes";
$LANG["incgal_NoRightExportSolarSystem"] = "Vous n'avez pas les droits pour exporter des syst�mes solaires";
$LANG["incgal_NoRightImportSolarSystem"] = "Vous n'avez pas les droits pour importer des syst�mes solaires";
$LANG["incgal_NoRightExportSpyReport"] = "Vous n'avez pas les droits pour exporter des rapports d'espionnage";
$LANG["incgal_NoRightImportSpyReport"] = "Vous n'avez pas les droits pour importer des rapports d'espionnage";
$LANG["incgal_NoRightExportRankings"] = "Vous n'avez pas les droits pour exporter des classements";
$LANG["incgal_NoRightImportRankings"] = "Vous n'avez pas les droits pour importer des classements";
$LANG["incgal_Thanks"] = "Thanks";
$LANG["incgal_PlanetsSended"] = "Nb de plan�tes soumises";
$LANG["incgal_PlanetsInserted"] = "Nb de plan�tes ins�r�es";
$LANG["incgal_PlanetsUpdated"] = "Nb de plan�tes mise � jour";
$LANG["incgal_PlanetsObsolete"] = "Nb de plan�tes obsol�tes";
$LANG["incgal_PlanetsFailed"] = "Nb d'�chec";
$LANG["incgal_CommitDuration"] = "Dur�e de traitement";

//home.php
//ericalens
//
$LANG["home_Simulation"] = "Simulation";
// Naqdazar
$LANG["home_empire"] = "Empire";
$LANG["home_spyreports"] = "Rapports d'espionnage";
$LANG["home_userstats"] = "Statistiques";
$LANG["home_homesubmenus"] = "Sous-menus de l'espace personnel";



//views/profile.php
//bartheleway
//
$LANG["profile_login"] = "Pseudo";
$LANG["profile_Oldpass"] = "Ancien mot de passe";
$LANG["profile_Newpass"] = "Nouveau mot de passe";
$LANG["profile_Newpassconf"] = "Nouveau mot de passe [Confirmer]";
$LANG["profile_Positionmp"] = "Position de la plan�te principale";
$LANG["profile_Various"] = "Divers";
$LANG["profile_languagechoice"] = "Langue de l'interface";
$LANG["profile_Linkskin"] = "Lien du skin utilis�";
$LANG["profile_Disableipcheck"] = "D�sactiver la v�rification de l'adresse IP";
$LANG["profile_Validate"] = "Valider";
$LANG["profile_Generalinfo"] = "Informations G�n�rales";
$LANG["profile_newpassandconf"] = "Saisissez le nouveau mot de passe et sa confirmation";
$LANG["profile_keyoldpass"] = "Saisissez l'ancien mot de passe";
$LANG["profile_newdifferentconf"] = "Le mot de passe saisie est diff�rent de la confirmation";
$LANG["profile_word6to15"] = "Le mot de passe doit contenir entre 6 et 15 caract�res";

//views/ranking_ally.php
//bartheleway
//
$LANG["rankingally_Orderbymember"] = "Tri par Membre";
$LANG["rankingally_Ptsgeneral"] = "Points G�n�ral";
$LANG["rankingally_Ptsfloat"] = "Points Flotte";
$LANG["rankingally_Ptsresearch"] = "Points Recherche";
$LANG["rankingally_Areyousure"] = "�tes vous s�r de vouloir supprimer ce classement ?";
$LANG["rankingally_Deletefillingof"] = "Supprimer le classement du";
$LANG["rankingally_Place"] = "Place";
$LANG["rankingally_Member"] = "Membre";
$LANG["rankingally_Orderglobal"] = "Tri Global";

//views/ranking_player.php
//bartheleway
//
$LANG["rankingplayer_Orderbymember"] = "Tri par Membre";
$LANG["rankingplayer_Ptsgeneral"] = "Points G�n�ral";
$LANG["rankingplayer_Ptsfloat"] = "Points Flotte";
$LANG["rankingplayer_Ptsresearch"] = "Points Recherche";
$LANG["rankingplayer_Areyousure"] = "�tes vous s�r de vouloir supprimer ce classement ?";
$LANG["rankingplayer_Deletefillingof"] = "Supprimer le classement du";
$LANG["rankingplayer_Place"] = "Place";
$LANG["rankingplayer_Member"] = "Membre";


//views/search.php et views/galaxy.php
//ericalens
//
$LANG["search_OptionStrict"] = "Option strict";
$LANG["search_Search"] = "Chercher";
$LANG["search_SpecialSearch"] = "Recherche Sp�ciale";
$LANG["search_Colonization"] = "Plan�tes colonisables";
$LANG["search_Away"] = "Joueurs absents";
$LANG["search_Spyed"] = "Plan�tes espionn�es";
$LANG["search_Minimum"] = "Minimum";
$LANG["search_Maximum"] = "Maximum";
$LANG["search_SolarSystem"] = "Syst�me solaire";
$LANG["search_StatFrom"] = "Classement du %s";
$LANG["search_General"] = "G�n�ral";
$LANG["search_Flotte"] = "Flotte";
$LANG["search_Research"] = "Recherche";
$LANG["search_DetailsView"] = "Voir d�tail";
$LANG["search_Legend"] = "L�gende";
$LANG["search_Inactive7Day"] = "Inactif 7 jours";
$LANG["search_Inactive28Day"] = "Inactif 28 jours";
$LANG["search_WeakPlayer"] = "Joueur faible";
$LANG["search_MoonPhallanx"] = "Lune<br><i>phalange 4 avec porte spatial</i>";
$LANG["search_SpyReport"] = "Rapport d'espionnage";
$LANG["search_FriendAlly"] = "Joueur / Alliance alli�s";
$LANG["search_HidenAlly"] = "Joueur / Alliance masqu�s";
$LANG["search_StatsFor"] = "Classement de <a>%s</a>";
$LANG["search_GeneralPoints"] = "Pts G�n�ral";
$LANG["search_FlottePoints"] = "Pts Flotte";
$LANG["search_ResearchPoints"] = "Pts Recherche";
$LANG["search_MemberCount"] = "Nb Membre";
$LANG["search_Show"] = "Afficher";
$LANG["search_FavoritesList"] = "Liste des syst�mes favoris";
$LANG["search_NoFavorites"] = "Vous n'avez pas de favoris";
$LANG["search_AddFavorites"] = "Ajouter aux favoris";
$LANG["search_DelFavorites"] = "Supprimer des favoris";
$LANG["search_Update"] = "Mises � jour";
$LANG["search_DangerousPhallanx"] = "Liste des phalanges hostiles dans le secteur";
$LANG["search_NoPhallanx"] = "Aucune phalange r�pertori�e a une port�e suffisante pour phalanger les plan�tes de ce systeme";
$LANG["search_SystemAround"] = "syst�mes environnants";
$LANG["search_InactivePlayers"] = "Joueurs inactifs";

// ajout Naqdazar
$LANG["search_ratio_restrict"] = "Le mode recherche vous est inaccessible �tant donn� un ratio de participation insuffisant.<br />Am�liorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";
$LANG["search_ratio_info"] = "Votre ratio indique votre participation rapport�e � la participation globale des autres membres pour les trois types de pages univers (Galaxie,Classement et rapports d'espionnage).<br/>Saisissez autant de donn�es que possible afin d'am�liorer votre ratio.<br /><br />Utilisez le plugin pour firefox pour faciliter ce travail si vous le souhaitez.<br /><br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";

$LANG["galaxy_ratio_restrict"] = "La page galaxie vous est inaccessible �tant donn� un ratio de participation insuffisant.<br />Am�liorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";

$LANG["galaxy_Planet_Launching_Coords"] = "Colonies pouvant atteindre ce syst�me par missile EMP";
$LANG["galaxy_withan"] = " avec une ";
$LANG["galaxy_stargate"] = "porte spatiale";
$LANG["galaxy_labelnummembers"] = " membre(s)";
$LANG["galaxy_playerimpulsionlevel"] = " poss�de la technologie impulsion de niveau ";
$LANG["galaxy_witha"] = " avec un ";
$LANG["galaxy_silolevel"] = "silo de niveau ";
$LANG["galaxy_noplanetcanlaunch"] = "Aucune colonie recens�e ne poss�de de silo pr�t pour envoyer des missiles dans ce syst�me";
$LANG["galaxy_silosneedsspyreports"] = "Chargez des rapports d'espionnage pour afficher les colonies hostiles";
//$LANG["galaxy_"] = "";


//views/serverdown.php
//bartheleway
//
$LANG["serverdown_serverclose"] = "Le serveur est temporairement d�sactiv�";


//admin.php
//ericalens
//
$LANG["admin_adminsubmenus"]= "Sous-menus administration";
$LANG["admin_GeneralInfo"] = "Informations g�n�rales";
$LANG["admin_ServerParameters"] = "Param�tres du serveur";
$LANG["admin_UserManagement"] = "Gestion des membres";
$LANG["admin_GroupManagement"] = "Gestion des groupes";
$LANG["admin_Journal"] = "Journal";
$LANG["admin_Mods"] = "Mods";
$LANG["admin_ServerUpToDate"] = "Votre serveur UniSpy est � jour.";
$LANG["admin_ServerNeedUpDate"] = "Votre serveur UniSpy n'est pas � jour.";
$LANG["admin_ServerUpDateMessage"] = "Rendez vous sur le  <a href='http://www.ogsteam.fr' target='_blank'>forum</a> d�di� au support d'UniSpy pour r�cup�rer la derni�re version : ";
$LANG["admin_ServerUpDateCheckError"] = "Une incoh�rence a �t� rencontr�e avec le serveur de contr�le de version.";
$LANG["admin_CantCheckVersion"] = "Impossible de r�cup�rer le num�ro de la derni�re version car le lien n'a pas pu �tre �tablie avec le serveur de contr�le.";
$LANG["admin_CantCheckReason"] = "Il se peut que ce soit votre h�bergeur qui n'autorise pas cette action.";
$LANG["admin_Value"] = "Valeur";
$LANG["admin_CountMember"] = "Nombre de membres";
$LANG["admin_CountPlanet"] = "Nombre de plan�tes r�pertori�es";
$LANG["admin_CountFreePlanet"] = "Nombre de plan�tes r�pertori�es libres";
$LANG["admin_LogSize"] = "Espace occup� par les logs";
$LANG["admin_DBSize"] = "Espace occup� par la base de donn�es";
$LANG["admin_OptimizeDB"] = "Optimiser la base de donn�es";
$LANG["admin_ServerConnection"] = "Connexions [Serveur]";
$LANG["admin_OGSConnection"] = "Connexions [OGS]";
$LANG["admin_ServerPlanets"] = "Plan�tes [Serveur]";
$LANG["admin_OGSPlanets"] = "Plan�tes [OGS]";
$LANG["admin_ServerSpy"] = "Rapports espionnage [Serveur]";
$LANG["admin_OGSSpy"] = "Rapports espionnage [OGS]";
$LANG["admin_ServerRanking"] = "Classement (nombre de lignes) [Serveur]";
$LANG["admin_OGSRanking"] = "Classement (nombre de lignes) [OGS]";
$LANG["admin_VersionInformation"] = "Information de version";
$LANG["admin_MemberName"] = "Nom de membre";
$LANG["admin_Connection"] = "Connexion";
$LANG["admin_LastActivity"] = "Derni�re activit�";
$LANG["admin_IPAddress"] = "Adresse IP";
$LANG["admin_CreateNewAccount"] = "Cr�ation d'un nouveau compte";
$LANG["admin_RegisteredOn"] = "Inscrit le";
$LANG["admin_ActiveAccount"] = "Compte actif";
$LANG["admin_CoAdmin"] = "Co-administrateur";
$LANG["admin_RankingManagement"] = "Gestion des classements";
$LANG["admin_LastConnection"] = "Derni�re connexion";
$LANG["admin_ServerRights"] = "Droits sur le serveur";
$LANG["admin_AddSolarSystem"] = "Ajout de syst�mes solaires";
$LANG["admin_AddSpyReport"] = "Ajout de rapports d'espionnages";
$LANG["admin_AddRanking"] = "Ajout de classements";
$LANG["admin_ViewHiddenPosition"] = "Affichage des positions prot�g�es";
$LANG["admin_ExternalClientRights"] = "Droits clients externes (OGS)";
$LANG["admin_ServerConnection"] = "Connexion au serveur";

$LANG["admin_ImportSolarSystem"] = "Importation de syst�mes solaires";
$LANG["admin_ExportSolarSystem"] = "Exportation de syst�mes solaires";
$LANG["admin_ImportSpyReport"] = "Importation de rapports d'espionnages";
$LANG["admin_ExportSpyReport"] = "Exportation de rapports d'espionnages";
$LANG["admin_ImportRanking"] = "Importation de classements";
$LANG["admin_ExportRanking"] = "Exportation de classements";
$LANG["admin_ValidateParameters"] = "Valider les param�tres de";
$LANG["admin_ConfirmDelete"] = "Etes-vous s�r de vouloir supprimer %s";
$LANG["admin_ConfirmPasswordChange"] = "Etes-vous s�r de vouloir changer le mot de passe %s";


//views/about_ogsteam.php
//Styx
$LANG["ogsteam_website"] = "Site internet : ";
$LANG["ogsteam_ircchan"] = "Canal IRC : ";
$LANG["ogsteam_Kyser"] = "<center><b>Concepteur du serveur d'alliance OGSpy.</b><br /><br /></center><b>U18 => Kyser [Dwelwork]<br />U32 => Kyser [Brothers]</b>";
$LANG["ogsteam_Rica"] = "<center><b>Concepteur du client OGame Stratege (OGS)<br />Concepteur de l'ancien serveur d'alliance OGame Stratege Serveur (OGSS)</b><br /></center>";
$LANG["ogsteam_Ben12"] = "<center><b>D�veloppeur sur le projet OGSpy.</b><br /><br /></center><b>U6 => ange de la mort<br />";
$LANG["ogsteam_Capi"] = "<center><b>Testeur.<br /><font color=\"orange\">Capi capi, capo...</font></b></center><br />";
$LANG["ogsteam_Corwin"] = "<center><b>Testeur / \"Profiteur de Service\"</b></center><br />";
$LANG["ogsteam_Erreur32"] = "<center><b>Testeur<br /><font color=\"orange\">Skinner de l'espace (-�O�-)</font></b></center><br /><b>FR - U21 => Erreur32 [MoD]</b><br /><b>FR - U6 => Erreur32 [S R ]</b><br /><br /><b>Skin Ogame : </b><a href=\"http://skin.erreur32.info\" target=\"_blank\">http://skin.erreur32.info</a><br />";
$LANG["ogsteam_Aeris"] = "<center><b>D�veloppeur</b></center><br /><b>U31 => Aeris [LMG]</b>";
$LANG["ogsteam_Bousteur"] = "<center><b>D�veloppeur sur Xtense<br />\"Bidouilleur\" sur OGSpy<br /><font color=\"orange\">N'a ni msn ni Skype :p</font></b></center><br />";
$LANG["ogsteam_Itori"] = "<center><b>Adaptation de OGSpy � E-Univers (UniSpy)</b><br /><b>Cr�ation de modules OGSpy & UniSpy en tout genre</b></center>";
$LANG["ogsteam_Verite"] = "<center><b>Adaptation de OGSpy � E-Univers (UniSpy)</b><br /><b>\"Bidouilleur\" sur OGSpy et Xtense</b><br /><b>Cr�ation de modules OGSpy & UniSpy en tout genre</b></center>";
$LANG["ogsteam_oXid_FoX"] = "<center><b>D�veloppeur - d�buggueur</b></center><br /><b>U4</b><br />";
$LANG["ogsteam_santory2"] = "<center><b>D�veloppeur</b></center><br />";

//views/galaxy_obsolete.php
//Kyser
$LANG["galaxyobsolete_HeadTitle"] = "Recherche des syst�mes solaires et lunes obsol�tes";
$LANG["galaxyobsolete_AllUniverse"] = "Tous l'univers";
$LANG["galaxyobsolete_Week"] = "Semaine(s)";
$LANG["galaxyobsolete_ShowPlanets"] = "Afficher les plan�tes";
$LANG["galaxyobsolete_ShowMoons"] = "Afficher les lunes";
$LANG["galaxyobsolete_Interval"] = "Entre %d et %d semaines";
$LANG["galaxyobsolete_IntervalMax"] = "Plus de %d semaines";
$LANG["galaxyobsolete_UpdateDate"] = "Date de mise � jour";
$LANG["galaxyobsolete_SolarSystem"] = "Systeme solaire";


//views/cartography.php
//Kyser
$LANG["cartography_Ally"] = "Alliance ";
$LANG["cartography_ShowPosition"] = "Afficher les positions";
$LANG["cartography_PresentPlayer"] = "Joueur(s) pr�sent(s)";
$LANG["cartography_GalaxyShortcut"] = "G%d";


//views/galaxy_sector.php
//Kyser
$LANG["galaxysector_Previous"] = "- Pr�c�dent";
$LANG["galaxysector_Next"] = "Suivant +";
$LANG["galaxysector_Navigation"] = "Navigation";


//views/home_empire.php
//Kyser
$LANG["homeempire_Warning"] = "Pense � renseigner, si besoin est, les noms de planetes et les temperatures\nqui ne peuvent pas �tre r�cup�r�s par la page empire d'Univers.";
$LANG["homeempire_Warning2"] = "Vous devez selectionner une planete";
$LANG["homeempire_Send"] = "Envoyer";
$LANG["homeempire_LeftMove"] = "D�placer la plan�te %s vers la gauche";
$LANG["homeempire_RightMove"] = "D�placer la plan�te %s vers la droite";
$LANG["homeempire_DeletePlanet"] = "Supprimer la plan�te %s";
$LANG["homeempire_HeadTitle"] = "";
$LANG["homeempire_Textarea"] = "Empire & B�timents & Laboratoire & D�fenses";
$LANG["homeempire_Paste"] = "Collez les infos ici";
$LANG["homeempire_SelectPlanet"] = "S�lectionnez une plan�te";
$LANG["homeempire_PlanetName"] = "Nom de la plan�te";
$LANG["homeempire_Coordinates"] = "Coordonn�es (par ex 3:100:10)";
$LANG["homeempire_Field"] = "Nombre de case";
$LANG["homeempire_GeneralInfo"] = "Vue d'ensemble de votre empire";
$LANG["homeempire_Production"] = "Production th�orique";
$LANG["homeempire_Others"] = "Divers";
$LANG["homeempire_xp_mineur"] = "Exp�rience mineur";
$LANG["homeempire_xp_raideur"] = "Exp�rience raideur";

//common.php
//Bartheleway
//
$LANG["common_impo"] = "Impossible de se connecter � la base de donn�es";

//includes/help.php
//Bartheleway
//
$LANG["help_serverstatus"] = "Lorsque le serveur est d�sactiv�, seul les membres avec le statut d'administrateur ont acc�s aux fonctionnalit�s du serveur";
$LANG["help_servermessage"] = "Le message sera affich� aux membres \"de base\" lorsque le serveur sera d�sactiv�";
$LANG["help_savetransaction"] = "Les transactions correspondent aux :";
$LANG["help_savetransaction1"] = "- Syst�mes solaires";
$LANG["help_savetransaction2"] = "- Rapports d'espionnage";
$LANG["help_savetransaction3"] = "- Classements joueurs et alliances";
$LANG["help_membermanager"] = "Autorise la cr�ation, la mise � jour et la suppression des utilisateurs";
$LANG["help_rankingmanager"] = "Autorise la suppression des classements joueurs et alliances";
$LANG["help_checkip"] = "Certains utilisateures subissent des d�connections intempestives (AOL, proxy, etc).";
$LANG["help_checkip1"] = "Autorisez la v�rification afin qu'il puisse d�sactiver la v�rification.";
$LANG["help_sessioninfini"] = "Si vous choisissez des sessions ind�finies dans le temps, plusieurs individus ne pourront plus utiliser le m�me compte en m�me temps";
$LANG["help_homecommandant"] = "Page empire du compte commandant";
$LANG["help_profileskin"] = "Unispy utilise les m�me skin qu'Univers";
$LANG["help_profilelogin"] = "Doit contenir entre 3 et 15 caract�res";
$LANG["help_profilelogin1"] = "(les caract�res sp�ciaux ne sont pas accept�s).";
$LANG["help_profilepassword"] = "Doit contenir entre 6 et 15 caract�res (les caract�res sp�ciaux ne sont pas accept�s)";
$LANG["help_profiledisableipcheck"] = "La v�rification de l'adresse IP permet de vous prot�ger contre le vol de session.";
$LANG["help_profiledisableipcheck1"] = "Si vous �tes d�connect� r�guli�rement (AOL, Proxy, etc), d�sactivez la v�rification.";
$LANG["help_profiledisableipcheck2"] = "L'option est disponible uniquement si l'administrateur la activ�e.";
$LANG["help_galaxyphalanx"] = "Chargez des rapports d'espionnage pour afficher les phalanges hostiles";
$LANG["help_searchstrict"] = "Joueur recherch� :";
$LANG["help_searchstrict1"] = "Liquid snake";
$LANG["help_searchstrict2"] = "Crit�re de recherche :";
$LANG["help_searchstrict3"] = "snake";
$LANG["help_searchstrict4"] = "R�sultat positif";
$LANG["help_searchstrict5"] = " si l'option \"strict\" est d�sactiv�";
$LANG["help_searchstrict6"] = "R�sultat n�gatif";
$LANG["help_searchstrict7"] = " si l'option \"strict\" est activ�";
$LANG["help_help"] = "Aide";

//admin_viewers.php
//Kyser
//
$LANG["adminviewer_SelectedDate"] = "Date s�lectionn�e : %s";
$LANG["adminviewer_SelectedMonth"] = "S�lectionnez le mois";
$LANG["adminviewer_SelectedDay"] = "S�lectionnez le jour";
$LANG["adminviewer_SelectedLog"] = "S�lectionnez le type de log � visualiser";
$LANG["adminviewer_GetLog"] = "T�l�charger les logs de %s";
$LANG["adminviewer_GetLog2"] = "T�l�charger les logs du %s";
$LANG["adminviewer_SQLLog"] = "Log SQL";
$LANG["adminviewer_GeneralLog"] = "Log g�n�ral";
$LANG["adminviewer_NoData"] = "Aucun log n'a �t� trouv� � cette date";
$LANG["adminviewer_Notice"] = "Si vous souhaitez visualiser les fichiers transactionnels, t�lechargez les logs via le FTP";
$LANG["adminviewer_Viewer"] = "Visionneuse :";

//home_simulation.php
//Kyser
//
$LANG["homesimulation_Totals"] = "Totaux";
$LANG["homesimulation_Energies"] = "Energies";
$LANG["homesimulation_Level"] = "Niveau";
$LANG["homesimulation_ConsumptionEnergy"] = "Consommation d'�nergie";
$LANG["homesimulation_Production"] = "Production";
$LANG["homesimulation_PointsPerPlanet"] = "Points par plan�te";

//home_spy.php
//Kyser
//
$LANG["homespy_Updated"] = "Mises � jour";
$LANG["homespy_Look"] = "Voir";
$LANG["homespy_Delete"] = "Supprimer des favoris";

//home_stat.php
//Kyser
//
$LANG["homestat_StatisticOf"] = "Les statistiques de :";
$LANG["homestat_StatisticOf2"] = "Les statistiques de %s";
$LANG["homestat_Options"] = "Options :";
$LANG["homestat_GetStat"] = "Obtenir les statistiques";
$LANG["homestat_Send"] = "Envoyer";
$LANG["homestat_CompareWith"] = "comparer avec";
$LANG["homestat_General"] = "G�n�ral";
$LANG["homestat_Fleet"] = "Flotte";
$LANG["homestat_Technology"] = "Technologie";
$LANG["homestat_Various"] = "Divers";
$LANG["homestat_Notice"] = "Bas� sur vos donn�es dans \"Empire\" et les stats de %s du %s";
$LANG["homestat_Range"] = "Intervalle d'�tude :";
$LANG["homestat_RangeStart"] = "Du";
$LANG["homestat_RangeEnd"] = "au";
$LANG["homestat_Zoom"] = "Zoom :";
$LANG["homestat_NoDataEmpire"] = "Pas de donn�es dans empire disponible";
$LANG["homestat_NoDataRanking"] = "Pas de classement disponible";
$LANG["homestat_GraphTitleGeneralRanking"] = "Classement General";
$LANG["homestat_GraphTitleGeneralPoints"] = "Points General";
$LANG["homestat_GraphTitleFleetRanking"] = "Classement flotte";
$LANG["homestat_GraphTitleFleetPoints"] = "Points flotte";
$LANG["homestat_GraphTitleResearchRanking"] = "Classement recherche";
$LANG["homestat_GraphTitleResearchPoints"] = "Points recherche";
$LANG["homestat_GraphTitleDistributionPoints"] = "Derniere repartition des points connue";
$LANG["homestat_GraphTitleDistributionPlanets"] = "Proportion des planetes";
$LANG["homestat_RankingOf"] = "Classement de %s";
$LANG["homestat_Date"] = "Date";
$LANG["homestat_GeneralPoints"] = "Pts G�n�ral";
$LANG["homestat_FleetPoints"] = "Pts Flotte";
$LANG["homestat_FleetResearch"] = "Pts Recherche";
$LANG["homestat_AverageProgressionPerDay"] = "Progression moyenne par jour :";

//report_spy
$LANG["ReportSpy_SentBy"] = "Rapport d'espionnage envoy�e par ";

//admin_ratio.php
//Bousteur
//
$LANG["ratioalterdone"] = "Les modifications du ratio on �t� effectu�es.";
//admin_members_group.php 
$LANG["unlimitedratio"] = "Ratio illimit�";

//search.php
$LANG["your_ratio_is"] = "Votre ratio �tant de ";
$LANG["can_t_search"] = ", vous ne pouvez pas effectuer de recherches.";
?>