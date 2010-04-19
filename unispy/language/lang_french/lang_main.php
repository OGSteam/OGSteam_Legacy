<?php
/***************************************************************************
*	filename	: lang_main.php
*	desc.		: Fichier de langue FR
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 21/08/2006
*	modified	: 
***************************************************************************/
// escaper ' entre "" -> "l\'aurore"

global $server_config; // pour récup valeur config dans chaînes

//Paramètres langues
$LANG["french"] = "Francais";

//setup
$LANG["Language_french"] = "Francais";


//Paramètre linguistiques : langue ; encodage des caractères
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
$LANG["univers_Planet"] = "Planète";
$LANG["univers_Planets"] = "Planètes";
$LANG["univers_Satellite"] = "Satellite";
$LANG["univers_Titane"] = "Titane";
$LANG["univers_Carbon"] = "Carbone";
$LANG["univers_Tritium"] = "Tritium";
$LANG["univers_Energy"] = "Energie";
$LANG["univers_TitaneMine"] = "Mine de titane";
$LANG["univers_CarbonMine"] = "Mine de carbone";
$LANG["univers_TritiumExtractor"] = "Extracteur de Tritium";
$LANG["univers_GeothermalPlant"] = "Centrale Géothermique";
$LANG["univers_TritiumPlant"] = "Centrale à tritium";
$LANG["univers_DroidFactory"] = "Usine de droïdes";
$LANG["univers_AndroidsFactory"] = "Usine d'Androïdes";
$LANG["univers_ArmsFactory"] = "Usine d'armement";
$LANG["univers_TitaneStorage"] = "Silo de Titane";
$LANG["univers_CarbonStorage"] = "Silo de Carbone";
$LANG["univers_TritiumStorage"] = "Silo de Tritium";
$LANG["univers_TechnicalCenter"] = "Centre Technique";
$LANG["univers_MolecularConverter"] = "Convertisseur moléculaire";
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
$LANG["univers_Antimatter"] = "Antimatière";
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
$LANG["univers_GaussCannon"] = "Déflecteurs";
$LANG["univers_IonCannon"] = "Plate-Forme Ionique";
$LANG["univers_PlasmaTuret"] = "Aereon Missile Defense";
$LANG["univers_SmallShield"] = "Champ de force";
$LANG["univers_LargeShield"] = "Holochamp";
$LANG["univers_AntiBallisticMissiles"] = "Contre Mesure Electromagnétique";
$LANG["univers_InterplanetaryMissiles"] = "Missile EMP";
$LANG["univers_TemperatureMax"] = "Température Max";
$LANG["univers_Temperature"] = "Température";
$LANG["univers_Field"] = "Cases";
$LANG["univers_Coordinates"] = "Coordonnées";
$LANG["univers_Empire"] = "Empire";
$LANG["univers_Tech"] = "Technologies";
$LANG["univers_Building"] = "Bâtiments";
$LANG["univers_Defence"] = "Défenses";
$LANG["univers_Research"] = "Recherches";
$LANG["univers_Technology"] = "Technologies";


//Pied de page
$LANG["Time_generation"] = "Temps de génération";
$LANG["pagetail_Copyright"] = "is a";
$LANG["pagetail_Copyright2"] = "Kyser Software";

//Page d"accueil d"identification
$LANG["Connection_parameters"] = "Paramètres de connexion";
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
$LANG["menu_ObsoletedData"] = "Syst. obsolètes";
$LANG["menu_Logout"] = "Déconnexion";
$LANG["menu_Forum"] = "Forum";
$LANG["menu_About"] = "A propos ...";





//message.php
//(ericalens)
$LANG["message_SystemMessage"] = "Message Système";
$LANG["message_DontHaveRights"] = "Vous ne disposez pas des droits nécessaires pour effectuer cette action";
$LANG["message_ErrorFatal"]  =  "Interruption suite à une erreur fatale";
$LANG["message_ErrorData"]  =  "Les données transmises sont incorrectes";
$LANG["message_AccountCreation"] = "Création du compte de <a>%s</a> réussie";
$LANG["message_AccountTransmitInfo"] = "Transmettez lui ces informations";
$LANG["message_ServerURL"] = "URL du serveur";
$LANG["message_Password"] = "Mot de passe";
$LANG["message_ChangePasswordSuccess"] = "Génération du nouveau mot de passe de <a>%s</a> réussie";
$LANG["message_SendPassword"] = "Transmettez lui son mot de passe";
$LANG["message_RegeneratePasswordFailed"] = "Génération du nouveau mot de passe échouée";
$LANG["message_FailedPseudoLocked"] = "Création du compte de <a>%s</a> échouée";
$LANG["message_AccountCreationFailed"] = "Création du compte de <a>%s</a> échouée";
$LANG["message_NickRequierements"] = "Le pseudo doit contenir entre 3 et 15 caractères standards";
$LANG["message_NickIncorrect"] = "Le pseudo est incorrect";
$LANG["message_ProfileChangedSuccess"] = "Modification du profil de <a>%s</a> réussie";
$LANG["message_ProfileChangedFailed"] = "Modification du profil échouée";
$LANG["message_UserProfileChangedSuccess"] = "Modification de votre profil réussie";
$LANG["message_UserProfileChangedFailed"] = "Modification de votre profil a échouée";
$LANG["message_UserPasswordCheck"] = "Saisissez correctement votre ancien mot de passe et deux fois le nouveau";
$LANG["message_PasswordRequiert"] = "Le mot de passe doit contenir entre 6 et 15 caractères standards";
$LANG["message_NickAlreadyUsed"] = "Le pseudo est déjà utilisé par un autre membre";
$LANG["message_DeleteMemberSuccess"] = "Suppression du membre <a>%s</a> réussie";
$LANG["message_DeleteMemberFailed"] = "Suppression du membre échouée";
$LANG["message_LoginWrong"] = "Identifiants de connexion incorrects";
$LANG["message_AccountLock"] = "Votre compte n'est pas activé";
$LANG["message_ContactAdmin"] = "Contactez un administrateur";
$LANG["message_MaxFavorites"] = "Vous avez atteint le nombre maximal de favoris (%s)";
$LANG["message_ServerConfigFailed"] = "La configuration des paramètre serveur à echouée";
$LANG["message_ServerConfigSuccess"] = "Configuration des paramètre serveur achevée avec succès";
$LANG["message_LogMissing"] = "Il n'y a pas de fichiers logs à cette période";
$LANG["message_PlanetIDFailed"] = "Veuillez préciser la planète concernée";
$LANG["message_DeleteInstall"] = "Veuillez supprimer le dossier 'install'";
$LANG["message_LoadedSpyReport"] = "Chargement des rapports d'espionnage terminé";
$LANG["message_SpyReportFor"] = "Rapport d'espionnage de la planète %s";
$LANG["message_Loaded"] = "Chargé";
$LANG["message_Ignored"] = "Ignoré";
$LANG["message_GroupCreationSuccess"] = "Création du groupe <a>%s</a> réussie";
$LANG["message_GroupCreationFailed"] = "Création du groupe <a>%s</a> échoué";
$LANG["message_NameAlreadyUsed"] = "Le nom est déjà utilisé";
$LANG["message_GroupNameRequiert"] = "Le nom doit contenir entre 3 et 15 caractères standards";
$LANG["message_GroupNameIncorrect"] = "Le nom est incorrect";
$LANG["message_DBOptimizeFinished"] = "Optimisation terminée";
$LANG["message_DBSpaceBeforeOptimize"] = "Espace occupé avant optimisation";
$LANG["message_DBSpaceAfterOptimize"] = "Espace occupé après optimisation";
$LANG["message_EmpireFailed"] = "Un probleme est survenu durant l'acquisition de votre empire";
$LANG["message_Return"] = "Retour";

//admin_members_group.php
//ericalens
//
$LANG["admingroup_GroupCreate"] = "Création d'un groupe";
$LANG["admingroup_Permissions"] = "Permissions";
$LANG["admingroup_SelectGroup"] = "Sélectionnez un groupe";
$LANG["admingroup_ShowPermissions"] = "Voir les permissions";
$LANG["admingroup_GroupMember"] = "Membre du groupe";
$LANG["admingroup_ConfirmMemberDeletion"] = "Etes-vous sûr de vouloir supprimer %s du groupe ?";
$LANG["admingroup_MemberList"] = "Liste des membres";
$LANG["admingroup_AddToGroup"] = "Ajouter dans le groupe";
$LANG["admingroup_ConfirmGroupDeletion"] = "Etes-vous sûr de vouloir supprimer le groupe ?";
$LANG["admingroup_DeleteGroup"] = "Supprimer le groupe";
$LANG["admingroup_GroupName"] = "Nom du groupe";
$LANG["admingroup_ShowProtectedAlly"] = "Visualiser coordonnées alliances protégées";
$LANG["admingroup_ValidatePermissions"] = "Valider les permissions";

//itori
$LANG["admingroup_Modname"] = "Nom du mod";



//admin_mod.php
//ericalens
//
$LANG["adminmod_ActiveMods"] = "Mods installés actifs";
$LANG["adminmod_Up"] = "Monter";
$LANG["adminmod_Down"] = "Descendre";
$LANG["adminmod_Desactivate"] = "Desactiver";
$LANG["adminmod_Uninstall"] = "Désinstaller";
$LANG["adminmod_Update"] = "Mettre à jour";
$LANG["adminmod_InactiveMods"] = "Mods installés inactifs";
$LANG["adminmod_Activate"] = "Activer";
$LANG["adminmod_InstallableMods"] = "Mods non installés";
$LANG["adminmod_Install"] = "Installer";
$LANG["adminmod_InvalidMods"] = "Mods invalides";

//Verite
$LANG["adminmod_confirm_Desactivate"] = "La desactivation rendra le mod inaccessible à tous les membres. Confirmez-vous cette action ?";
$LANG["adminmod_confirm_Uninstall"] = "La suppression du mod entrainera la suppression des données le concernant. Confirmez-vous cette action ?";

// Naqdazar
$LANG["adminmod_Action"] = "Action";
$LANG["adminmod_promote"] = "Promouvoir";
$LANG["adminmod_position"] = "Position";
$LANG["adminmod_sitting"] = "Emplacement";
$LANG["adminmod_user_required"]= "Utilisateur requis";
$LANG["adminmod_validate_mod_params"] = "Valider les paramètres du mod ";
$LANG["adminmod_sort_alpha"] = "Trier alphabétiquement";

$LANG["adminmod_menupos_header"] = "Entête";
$LANG["adminmod_menupos_home"] = "Perso";
$LANG["adminmod_menupos_common"] = "Commun";
$LANG["adminmod_menupos_thirdparty"] = "Tierce Partie";
$LANG["adminmod_menupos_admin"] = "Admin";
$LANG["adminmod_menupos_homearea"] = "Espace Perso";

//admin_parameters.php
//ericalens
//
$LANG["adminparam_GeneralOptions"] = "Option générales du serveur";
$LANG["adminparam_ServerName"] = "Nom du serveur";
$LANG["adminparam_Language"] = "Langage du serveur";
$LANG["adminparam_Language_parsing"] = "Langage du parsing du serveur";
$LANG["adminparam_timeshift"] = "Décalage horaire";
$LANG["adminparam_ActivateServer"] = "Activer le serveur";
$LANG["adminparam_ServerDownReason"] = "Motif fermeture";
$LANG["adminparam_MembersOptions"] = "Option des membres";
$LANG["adminparam_EnableDesactivateIPCheck"] = "Autoriser la désactivation du controle des adresses ip";
$LANG["adminparam_DefaultSkin"] = "Skin par défaut";
$LANG["adminparam_MaximumFavorites"] = "Nombre maximum de favoris système autorisé";
$LANG["adminparam_MaximumSpyReport"] = "Nombre maximum de rapports d'espionnage favoris autorisé";
$LANG["adminparam_SessionsManagement"] = "Gestion des sessions";
$LANG["adminparam_SessionDuration"] = "Durée des sessions";
$LANG["adminparam_InfiniteSession"] = "durée indéterminée";
$LANG["adminparam_AllianceProtection"] = "Protection alliance";
$LANG["adminparam_HidenAllianceList"] = "Liste des alliances à ne pas afficher";
$LANG["adminparam_AddComaBetweenAlliance"] = "Séparez les alliances avec des virgules";
$LANG["adminparam_FriendlyAllianceList"] = "Liste des alliances amies";
$LANG["adminparam_OtherParameters"] = "Paramètres divers";
$LANG["adminparam_AllyBoardLink"] = "Lien du forum de l'alliance";
$LANG["adminparam_LogSQLQuery"] = "Journaliser les transactions et requêtes SQL";
$LANG["adminparam_WarnPerformance"] = "Risque de dégradation des performances du serveur";
$LANG["adminparam_Maintenance"] = "Maintenance";
$LANG["adminparam_KeepRankingDuration"] = "Durée de conservation des classements [1-50 jours ou nombre]";
$LANG["adminparam_Number"] = "Nombre";
$LANG["adminparam_Days"] = "Jours";
$LANG["adminparam_MaximumSpyReportByPlanets"] = "Nombre maximal de rapports d'espionnage par planète [1-10]";
$LANG["adminparam_KeepSpyReportDuration"] = "Durée de conservation des rapports d'espionnage [1-90 jours]";
$LANG["adminparam_KeepLogfileDuration"] = "Durée de conservation des fichiers logs <a>[0-365 jours]</a>";
$LANG["adminparam_Validate"] = "Valider";
$LANG["adminparam_Reset"] = "Réinitialiser";
$LANG["adminparam_defaultloginpage"]="Page de login par defaut";
//rajout pour les couleurs des alliances protégées
//Verite
$LANG["adminparam_color_ally_hided"] = "Couleur pour les alliances à ne pas afficher :";
$LANG["adminparam_color_ally_friend"] = "Couleur pour les alliances amies :";
$LANG["adminparam_color_exemple"] = "Par exemple pour rouge : #FF0000";
$LANG["adminparam_galaxyOption"] = "Configuration de la galaxie";
$LANG["adminparam_nbgalaxy"] = "Nombre de galaxies";
$LANG["adminparam_nbsystem"] = "Nombre de systèmes solaires par galaxie";
$LANG["adminparam_nbrow"] = "Nombre de positions par système solaire";
$LANG["adminparam_galaxyOptionwarning"] = "/!\ Attention /!\<br> La modification de ces informations peut entrainer la suppression de certaines données. Par exemple si vous étiez à 16 galaxies et que vous passez à 15, toutes les données de la galaxie 16 seront supprimées. <br>Pour cette raison, ces paramètres ne sont modifiable que par l'administrateur";
$LANG["adminparam_unispeed"] = "Vitesse de l'univers";

//views/statistics.php
//ericalens
//
$LANG["stats_DBState"] = "Etat de la base de données";
$LANG["stats_KnownPlanets"] = "Planètes répertoriées";
$LANG["stats_FreePlanets"] = "Planètes colonisables";
$LANG["stats_UpdatedRecentlyPlanets"] = "Planète mise à jour récemment";
$LANG["stats_Nicknames"] = "Pseudos";
$LANG["stats_RankingLines"] = "Classement (lignes)";
$LANG["stats_ResearchMade"] = "Recherches<br />effectuées";
$LANG["stats_Ratio"] = "Ratio";
$LANG["stats_LoadedFromBrowser"] = "Chargées via le navigateur";
$LANG["stats_LoadedFromOGS"] = "Chargées via OGS";
$LANG["stats_SendedToOGS"] = "Envoyées vers OGS";
$LANG["stats_ConnectedLegend"] = "(*) connecté sur le serveur<br />(**) connecté avec OGS et/ou sur le serveur";

//includes/galaxy.php
//ericalens
//
$LANG["incgal_AccesDenied"] = "Accès refusé";
$LANG["incgal_IncorrectData"] = "Données transmises incorrectes";
$LANG["incgal_NoRightExportSolarSystem"] = "Vous n'avez pas les droits pour exporter des systèmes solaires";
$LANG["incgal_NoRightImportSolarSystem"] = "Vous n'avez pas les droits pour importer des systèmes solaires";
$LANG["incgal_NoRightExportSpyReport"] = "Vous n'avez pas les droits pour exporter des rapports d'espionnage";
$LANG["incgal_NoRightImportSpyReport"] = "Vous n'avez pas les droits pour importer des rapports d'espionnage";
$LANG["incgal_NoRightExportRankings"] = "Vous n'avez pas les droits pour exporter des classements";
$LANG["incgal_NoRightImportRankings"] = "Vous n'avez pas les droits pour importer des classements";
$LANG["incgal_Thanks"] = "Thanks";
$LANG["incgal_PlanetsSended"] = "Nb de planètes soumises";
$LANG["incgal_PlanetsInserted"] = "Nb de planètes insérées";
$LANG["incgal_PlanetsUpdated"] = "Nb de planètes mise à jour";
$LANG["incgal_PlanetsObsolete"] = "Nb de planètes obsolètes";
$LANG["incgal_PlanetsFailed"] = "Nb d'échec";
$LANG["incgal_CommitDuration"] = "Durée de traitement";

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
$LANG["profile_Positionmp"] = "Position de la planète principale";
$LANG["profile_Various"] = "Divers";
$LANG["profile_languagechoice"] = "Langue de l'interface";
$LANG["profile_Linkskin"] = "Lien du skin utilisé";
$LANG["profile_Disableipcheck"] = "Désactiver la vérification de l'adresse IP";
$LANG["profile_Validate"] = "Valider";
$LANG["profile_Generalinfo"] = "Informations Générales";
$LANG["profile_newpassandconf"] = "Saisissez le nouveau mot de passe et sa confirmation";
$LANG["profile_keyoldpass"] = "Saisissez l'ancien mot de passe";
$LANG["profile_newdifferentconf"] = "Le mot de passe saisie est différent de la confirmation";
$LANG["profile_word6to15"] = "Le mot de passe doit contenir entre 6 et 15 caractères";

//views/ranking_ally.php
//bartheleway
//
$LANG["rankingally_Orderbymember"] = "Tri par Membre";
$LANG["rankingally_Ptsgeneral"] = "Points Général";
$LANG["rankingally_Ptsfloat"] = "Points Flotte";
$LANG["rankingally_Ptsresearch"] = "Points Recherche";
$LANG["rankingally_Areyousure"] = "Êtes vous sûr de vouloir supprimer ce classement ?";
$LANG["rankingally_Deletefillingof"] = "Supprimer le classement du";
$LANG["rankingally_Place"] = "Place";
$LANG["rankingally_Member"] = "Membre";
$LANG["rankingally_Orderglobal"] = "Tri Global";

//views/ranking_player.php
//bartheleway
//
$LANG["rankingplayer_Orderbymember"] = "Tri par Membre";
$LANG["rankingplayer_Ptsgeneral"] = "Points Général";
$LANG["rankingplayer_Ptsfloat"] = "Points Flotte";
$LANG["rankingplayer_Ptsresearch"] = "Points Recherche";
$LANG["rankingplayer_Areyousure"] = "Êtes vous sûr de vouloir supprimer ce classement ?";
$LANG["rankingplayer_Deletefillingof"] = "Supprimer le classement du";
$LANG["rankingplayer_Place"] = "Place";
$LANG["rankingplayer_Member"] = "Membre";


//views/search.php et views/galaxy.php
//ericalens
//
$LANG["search_OptionStrict"] = "Option strict";
$LANG["search_Search"] = "Chercher";
$LANG["search_SpecialSearch"] = "Recherche Spéciale";
$LANG["search_Colonization"] = "Planètes colonisables";
$LANG["search_Away"] = "Joueurs absents";
$LANG["search_Spyed"] = "Planètes espionnées";
$LANG["search_Minimum"] = "Minimum";
$LANG["search_Maximum"] = "Maximum";
$LANG["search_SolarSystem"] = "Système solaire";
$LANG["search_StatFrom"] = "Classement du %s";
$LANG["search_General"] = "Général";
$LANG["search_Flotte"] = "Flotte";
$LANG["search_Research"] = "Recherche";
$LANG["search_DetailsView"] = "Voir détail";
$LANG["search_Legend"] = "Légende";
$LANG["search_Inactive7Day"] = "Inactif 7 jours";
$LANG["search_Inactive28Day"] = "Inactif 28 jours";
$LANG["search_WeakPlayer"] = "Joueur faible";
$LANG["search_MoonPhallanx"] = "Lune<br><i>phalange 4 avec porte spatial</i>";
$LANG["search_SpyReport"] = "Rapport d'espionnage";
$LANG["search_FriendAlly"] = "Joueur / Alliance alliés";
$LANG["search_HidenAlly"] = "Joueur / Alliance masqués";
$LANG["search_StatsFor"] = "Classement de <a>%s</a>";
$LANG["search_GeneralPoints"] = "Pts Général";
$LANG["search_FlottePoints"] = "Pts Flotte";
$LANG["search_ResearchPoints"] = "Pts Recherche";
$LANG["search_MemberCount"] = "Nb Membre";
$LANG["search_Show"] = "Afficher";
$LANG["search_FavoritesList"] = "Liste des systèmes favoris";
$LANG["search_NoFavorites"] = "Vous n'avez pas de favoris";
$LANG["search_AddFavorites"] = "Ajouter aux favoris";
$LANG["search_DelFavorites"] = "Supprimer des favoris";
$LANG["search_Update"] = "Mises à jour";
$LANG["search_DangerousPhallanx"] = "Liste des phalanges hostiles dans le secteur";
$LANG["search_NoPhallanx"] = "Aucune phalange répertoriée a une portée suffisante pour phalanger les planètes de ce systeme";
$LANG["search_SystemAround"] = "systèmes environnants";
$LANG["search_InactivePlayers"] = "Joueurs inactifs";

// ajout Naqdazar
$LANG["search_ratio_restrict"] = "Le mode recherche vous est inaccessible étant donné un ratio de participation insuffisant.<br />Améliorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";
$LANG["search_ratio_info"] = "Votre ratio indique votre participation rapportée à la participation globale des autres membres pour les trois types de pages univers (Galaxie,Classement et rapports d'espionnage).<br/>Saisissez autant de données que possible afin d'améliorer votre ratio.<br /><br />Utilisez le plugin pour firefox pour faciliter ce travail si vous le souhaitez.<br /><br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";

$LANG["galaxy_ratio_restrict"] = "La page galaxie vous est inaccessible étant donné un ratio de participation insuffisant.<br />Améliorez votre participation afin de rendre le mode recherche de nouveau actif.<br /> Valeur plancher: ".$server_config["user_lower_ratio"].".";

$LANG["galaxy_Planet_Launching_Coords"] = "Colonies pouvant atteindre ce système par missile EMP";
$LANG["galaxy_withan"] = " avec une ";
$LANG["galaxy_stargate"] = "porte spatiale";
$LANG["galaxy_labelnummembers"] = " membre(s)";
$LANG["galaxy_playerimpulsionlevel"] = " possède la technologie impulsion de niveau ";
$LANG["galaxy_witha"] = " avec un ";
$LANG["galaxy_silolevel"] = "silo de niveau ";
$LANG["galaxy_noplanetcanlaunch"] = "Aucune colonie recensée ne possède de silo prêt pour envoyer des missiles dans ce système";
$LANG["galaxy_silosneedsspyreports"] = "Chargez des rapports d'espionnage pour afficher les colonies hostiles";
//$LANG["galaxy_"] = "";


//views/serverdown.php
//bartheleway
//
$LANG["serverdown_serverclose"] = "Le serveur est temporairement désactivé";


//admin.php
//ericalens
//
$LANG["admin_adminsubmenus"]= "Sous-menus administration";
$LANG["admin_GeneralInfo"] = "Informations générales";
$LANG["admin_ServerParameters"] = "Paramètres du serveur";
$LANG["admin_UserManagement"] = "Gestion des membres";
$LANG["admin_GroupManagement"] = "Gestion des groupes";
$LANG["admin_Journal"] = "Journal";
$LANG["admin_Mods"] = "Mods";
$LANG["admin_ServerUpToDate"] = "Votre serveur UniSpy est à jour.";
$LANG["admin_ServerNeedUpDate"] = "Votre serveur UniSpy n'est pas à jour.";
$LANG["admin_ServerUpDateMessage"] = "Rendez vous sur le  <a href='http://www.ogsteam.fr' target='_blank'>forum</a> dédié au support d'UniSpy pour récupérer la dernière version : ";
$LANG["admin_ServerUpDateCheckError"] = "Une incohérence a été rencontrée avec le serveur de contrôle de version.";
$LANG["admin_CantCheckVersion"] = "Impossible de récupérer le numéro de la dernière version car le lien n'a pas pu être établie avec le serveur de contrôle.";
$LANG["admin_CantCheckReason"] = "Il se peut que ce soit votre hébergeur qui n'autorise pas cette action.";
$LANG["admin_Value"] = "Valeur";
$LANG["admin_CountMember"] = "Nombre de membres";
$LANG["admin_CountPlanet"] = "Nombre de planètes répertoriées";
$LANG["admin_CountFreePlanet"] = "Nombre de planètes répertoriées libres";
$LANG["admin_LogSize"] = "Espace occupé par les logs";
$LANG["admin_DBSize"] = "Espace occupé par la base de données";
$LANG["admin_OptimizeDB"] = "Optimiser la base de données";
$LANG["admin_ServerConnection"] = "Connexions [Serveur]";
$LANG["admin_OGSConnection"] = "Connexions [OGS]";
$LANG["admin_ServerPlanets"] = "Planètes [Serveur]";
$LANG["admin_OGSPlanets"] = "Planètes [OGS]";
$LANG["admin_ServerSpy"] = "Rapports espionnage [Serveur]";
$LANG["admin_OGSSpy"] = "Rapports espionnage [OGS]";
$LANG["admin_ServerRanking"] = "Classement (nombre de lignes) [Serveur]";
$LANG["admin_OGSRanking"] = "Classement (nombre de lignes) [OGS]";
$LANG["admin_VersionInformation"] = "Information de version";
$LANG["admin_MemberName"] = "Nom de membre";
$LANG["admin_Connection"] = "Connexion";
$LANG["admin_LastActivity"] = "Dernière activité";
$LANG["admin_IPAddress"] = "Adresse IP";
$LANG["admin_CreateNewAccount"] = "Création d'un nouveau compte";
$LANG["admin_RegisteredOn"] = "Inscrit le";
$LANG["admin_ActiveAccount"] = "Compte actif";
$LANG["admin_CoAdmin"] = "Co-administrateur";
$LANG["admin_RankingManagement"] = "Gestion des classements";
$LANG["admin_LastConnection"] = "Dernière connexion";
$LANG["admin_ServerRights"] = "Droits sur le serveur";
$LANG["admin_AddSolarSystem"] = "Ajout de systèmes solaires";
$LANG["admin_AddSpyReport"] = "Ajout de rapports d'espionnages";
$LANG["admin_AddRanking"] = "Ajout de classements";
$LANG["admin_ViewHiddenPosition"] = "Affichage des positions protégées";
$LANG["admin_ExternalClientRights"] = "Droits clients externes (OGS)";
$LANG["admin_ServerConnection"] = "Connexion au serveur";

$LANG["admin_ImportSolarSystem"] = "Importation de systèmes solaires";
$LANG["admin_ExportSolarSystem"] = "Exportation de systèmes solaires";
$LANG["admin_ImportSpyReport"] = "Importation de rapports d'espionnages";
$LANG["admin_ExportSpyReport"] = "Exportation de rapports d'espionnages";
$LANG["admin_ImportRanking"] = "Importation de classements";
$LANG["admin_ExportRanking"] = "Exportation de classements";
$LANG["admin_ValidateParameters"] = "Valider les paramètres de";
$LANG["admin_ConfirmDelete"] = "Etes-vous sûr de vouloir supprimer %s";
$LANG["admin_ConfirmPasswordChange"] = "Etes-vous sûr de vouloir changer le mot de passe %s";


//views/about_ogsteam.php
//Styx
$LANG["ogsteam_website"] = "Site internet : ";
$LANG["ogsteam_ircchan"] = "Canal IRC : ";
$LANG["ogsteam_Kyser"] = "<center><b>Concepteur du serveur d'alliance OGSpy.</b><br /><br /></center><b>U18 => Kyser [Dwelwork]<br />U32 => Kyser [Brothers]</b>";
$LANG["ogsteam_Rica"] = "<center><b>Concepteur du client OGame Stratege (OGS)<br />Concepteur de l'ancien serveur d'alliance OGame Stratege Serveur (OGSS)</b><br /></center>";
$LANG["ogsteam_Ben12"] = "<center><b>Développeur sur le projet OGSpy.</b><br /><br /></center><b>U6 => ange de la mort<br />";
$LANG["ogsteam_Capi"] = "<center><b>Testeur.<br /><font color=\"orange\">Capi capi, capo...</font></b></center><br />";
$LANG["ogsteam_Corwin"] = "<center><b>Testeur / \"Profiteur de Service\"</b></center><br />";
$LANG["ogsteam_Erreur32"] = "<center><b>Testeur<br /><font color=\"orange\">Skinner de l'espace (-•O•-)</font></b></center><br /><b>FR - U21 => Erreur32 [MoD]</b><br /><b>FR - U6 => Erreur32 [S R ]</b><br /><br /><b>Skin Ogame : </b><a href=\"http://skin.erreur32.info\" target=\"_blank\">http://skin.erreur32.info</a><br />";
$LANG["ogsteam_Aeris"] = "<center><b>Développeur</b></center><br /><b>U31 => Aeris [LMG]</b>";
$LANG["ogsteam_Bousteur"] = "<center><b>Développeur sur Xtense<br />\"Bidouilleur\" sur OGSpy<br /><font color=\"orange\">N'a ni msn ni Skype :p</font></b></center><br />";
$LANG["ogsteam_Itori"] = "<center><b>Adaptation de OGSpy à E-Univers (UniSpy)</b><br /><b>Création de modules OGSpy & UniSpy en tout genre</b></center>";
$LANG["ogsteam_Verite"] = "<center><b>Adaptation de OGSpy à E-Univers (UniSpy)</b><br /><b>\"Bidouilleur\" sur OGSpy et Xtense</b><br /><b>Création de modules OGSpy & UniSpy en tout genre</b></center>";
$LANG["ogsteam_oXid_FoX"] = "<center><b>Développeur - débuggueur</b></center><br /><b>U4</b><br />";
$LANG["ogsteam_santory2"] = "<center><b>Développeur</b></center><br />";

//views/galaxy_obsolete.php
//Kyser
$LANG["galaxyobsolete_HeadTitle"] = "Recherche des systèmes solaires et lunes obsolètes";
$LANG["galaxyobsolete_AllUniverse"] = "Tous l'univers";
$LANG["galaxyobsolete_Week"] = "Semaine(s)";
$LANG["galaxyobsolete_ShowPlanets"] = "Afficher les planètes";
$LANG["galaxyobsolete_ShowMoons"] = "Afficher les lunes";
$LANG["galaxyobsolete_Interval"] = "Entre %d et %d semaines";
$LANG["galaxyobsolete_IntervalMax"] = "Plus de %d semaines";
$LANG["galaxyobsolete_UpdateDate"] = "Date de mise à jour";
$LANG["galaxyobsolete_SolarSystem"] = "Systeme solaire";


//views/cartography.php
//Kyser
$LANG["cartography_Ally"] = "Alliance ";
$LANG["cartography_ShowPosition"] = "Afficher les positions";
$LANG["cartography_PresentPlayer"] = "Joueur(s) présent(s)";
$LANG["cartography_GalaxyShortcut"] = "G%d";


//views/galaxy_sector.php
//Kyser
$LANG["galaxysector_Previous"] = "- Précédent";
$LANG["galaxysector_Next"] = "Suivant +";
$LANG["galaxysector_Navigation"] = "Navigation";


//views/home_empire.php
//Kyser
$LANG["homeempire_Warning"] = "Pense à renseigner, si besoin est, les noms de planetes et les temperatures\nqui ne peuvent pas être récupérés par la page empire d'Univers.";
$LANG["homeempire_Warning2"] = "Vous devez selectionner une planete";
$LANG["homeempire_Send"] = "Envoyer";
$LANG["homeempire_LeftMove"] = "Déplacer la planète %s vers la gauche";
$LANG["homeempire_RightMove"] = "Déplacer la planète %s vers la droite";
$LANG["homeempire_DeletePlanet"] = "Supprimer la planète %s";
$LANG["homeempire_HeadTitle"] = "";
$LANG["homeempire_Textarea"] = "Empire & Bâtiments & Laboratoire & Défenses";
$LANG["homeempire_Paste"] = "Collez les infos ici";
$LANG["homeempire_SelectPlanet"] = "Sélectionnez une planète";
$LANG["homeempire_PlanetName"] = "Nom de la planète";
$LANG["homeempire_Coordinates"] = "Coordonnées (par ex 3:100:10)";
$LANG["homeempire_Field"] = "Nombre de case";
$LANG["homeempire_GeneralInfo"] = "Vue d'ensemble de votre empire";
$LANG["homeempire_Production"] = "Production théorique";
$LANG["homeempire_Others"] = "Divers";
$LANG["homeempire_xp_mineur"] = "Expérience mineur";
$LANG["homeempire_xp_raideur"] = "Expérience raideur";

//common.php
//Bartheleway
//
$LANG["common_impo"] = "Impossible de se connecter à la base de données";

//includes/help.php
//Bartheleway
//
$LANG["help_serverstatus"] = "Lorsque le serveur est désactivé, seul les membres avec le statut d'administrateur ont accès aux fonctionnalités du serveur";
$LANG["help_servermessage"] = "Le message sera affiché aux membres \"de base\" lorsque le serveur sera désactivé";
$LANG["help_savetransaction"] = "Les transactions correspondent aux :";
$LANG["help_savetransaction1"] = "- Systèmes solaires";
$LANG["help_savetransaction2"] = "- Rapports d'espionnage";
$LANG["help_savetransaction3"] = "- Classements joueurs et alliances";
$LANG["help_membermanager"] = "Autorise la création, la mise à jour et la suppression des utilisateurs";
$LANG["help_rankingmanager"] = "Autorise la suppression des classements joueurs et alliances";
$LANG["help_checkip"] = "Certains utilisateures subissent des déconnections intempestives (AOL, proxy, etc).";
$LANG["help_checkip1"] = "Autorisez la vérification afin qu'il puisse désactiver la vérification.";
$LANG["help_sessioninfini"] = "Si vous choisissez des sessions indéfinies dans le temps, plusieurs individus ne pourront plus utiliser le même compte en même temps";
$LANG["help_homecommandant"] = "Page empire du compte commandant";
$LANG["help_profileskin"] = "Unispy utilise les même skin qu'Univers";
$LANG["help_profilelogin"] = "Doit contenir entre 3 et 15 caractères";
$LANG["help_profilelogin1"] = "(les caractères spéciaux ne sont pas acceptés).";
$LANG["help_profilepassword"] = "Doit contenir entre 6 et 15 caractères (les caractères spéciaux ne sont pas acceptés)";
$LANG["help_profiledisableipcheck"] = "La vérification de l'adresse IP permet de vous protéger contre le vol de session.";
$LANG["help_profiledisableipcheck1"] = "Si vous êtes déconnecté régulièrement (AOL, Proxy, etc), désactivez la vérification.";
$LANG["help_profiledisableipcheck2"] = "L'option est disponible uniquement si l'administrateur la activée.";
$LANG["help_galaxyphalanx"] = "Chargez des rapports d'espionnage pour afficher les phalanges hostiles";
$LANG["help_searchstrict"] = "Joueur recherché :";
$LANG["help_searchstrict1"] = "Liquid snake";
$LANG["help_searchstrict2"] = "Critère de recherche :";
$LANG["help_searchstrict3"] = "snake";
$LANG["help_searchstrict4"] = "Résultat positif";
$LANG["help_searchstrict5"] = " si l'option \"strict\" est désactivé";
$LANG["help_searchstrict6"] = "Résultat négatif";
$LANG["help_searchstrict7"] = " si l'option \"strict\" est activé";
$LANG["help_help"] = "Aide";

//admin_viewers.php
//Kyser
//
$LANG["adminviewer_SelectedDate"] = "Date sélectionnée : %s";
$LANG["adminviewer_SelectedMonth"] = "Sélectionnez le mois";
$LANG["adminviewer_SelectedDay"] = "Sélectionnez le jour";
$LANG["adminviewer_SelectedLog"] = "Sélectionnez le type de log à visualiser";
$LANG["adminviewer_GetLog"] = "Télécharger les logs de %s";
$LANG["adminviewer_GetLog2"] = "Télécharger les logs du %s";
$LANG["adminviewer_SQLLog"] = "Log SQL";
$LANG["adminviewer_GeneralLog"] = "Log général";
$LANG["adminviewer_NoData"] = "Aucun log n'a été trouvé à cette date";
$LANG["adminviewer_Notice"] = "Si vous souhaitez visualiser les fichiers transactionnels, télechargez les logs via le FTP";
$LANG["adminviewer_Viewer"] = "Visionneuse :";

//home_simulation.php
//Kyser
//
$LANG["homesimulation_Totals"] = "Totaux";
$LANG["homesimulation_Energies"] = "Energies";
$LANG["homesimulation_Level"] = "Niveau";
$LANG["homesimulation_ConsumptionEnergy"] = "Consommation d'énergie";
$LANG["homesimulation_Production"] = "Production";
$LANG["homesimulation_PointsPerPlanet"] = "Points par planète";

//home_spy.php
//Kyser
//
$LANG["homespy_Updated"] = "Mises à jour";
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
$LANG["homestat_General"] = "Général";
$LANG["homestat_Fleet"] = "Flotte";
$LANG["homestat_Technology"] = "Technologie";
$LANG["homestat_Various"] = "Divers";
$LANG["homestat_Notice"] = "Basé sur vos données dans \"Empire\" et les stats de %s du %s";
$LANG["homestat_Range"] = "Intervalle d'étude :";
$LANG["homestat_RangeStart"] = "Du";
$LANG["homestat_RangeEnd"] = "au";
$LANG["homestat_Zoom"] = "Zoom :";
$LANG["homestat_NoDataEmpire"] = "Pas de données dans empire disponible";
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
$LANG["homestat_GeneralPoints"] = "Pts Général";
$LANG["homestat_FleetPoints"] = "Pts Flotte";
$LANG["homestat_FleetResearch"] = "Pts Recherche";
$LANG["homestat_AverageProgressionPerDay"] = "Progression moyenne par jour :";

//report_spy
$LANG["ReportSpy_SentBy"] = "Rapport d'espionnage envoyée par ";

//admin_ratio.php
//Bousteur
//
$LANG["ratioalterdone"] = "Les modifications du ratio on été effectuées.";
//admin_members_group.php 
$LANG["unlimitedratio"] = "Ratio illimité";

//search.php
$LANG["your_ratio_is"] = "Votre ratio étant de ";
$LANG["can_t_search"] = ", vous ne pouvez pas effectuer de recherches.";
?>