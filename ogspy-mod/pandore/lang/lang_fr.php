<?php
/***************************************************************************
*	filename	: lang_french.php
*	package		: Mod Pandore
*	version		: 0.5
*	desc.			: Liste des chaines pour la langue FranÃ§aise.
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 15/11/2008
*	modified	: 14:03 08/01/2010
***************************************************************************/

// Direct call prohibited (do not translate this one !!)
if (!defined('IN_SPYOGAME')) die("Hacking attempt");

// Various
$lang['pandore_pandore'] = "Pandore";
$lang['pandore_mod'] = "Mod Pandore";
$lang['pandore_thousands_separator'] = " ";
$lang['pandore_date_format'] = "d-m-y H:i:s";
$lang['pandore_search'] = "Recherche";
$lang['pandore_target'] = "Cible";
$lang['pandore_player'] = "Joueur";
$lang['pandore_rank_points'] = "Classement général";
$lang['pandore_rank_research'] = "Classement recherches";
$lang['pandore_rank_fleet'] = "Classement vaisseaux";
$lang['pandore_link_search'] = "Lien vers la page recherche";
$lang['pandore_coordinates'] = "Coordonnées";
$lang['pandore_send'] = "Lancer";
$lang['pandore_planets'] = "Planètes";
$lang['pandore_moons'] = "Lunes";
$lang['pandore_moon'] = "Lune";
$lang['pandore_link_galaxy'] = "Lien vers la page galaxie";
$lang['pandore_link_spy'] = "Lien vers les rapports d'espionnages";
$lang['pandore_no_report'] = "Pas de rapport";
$lang['pandore_incomplete_report'] = "Rapport incomplet";
$lang['pandore_last_complete_report_date'] = "Date du dernier rapport complet";
$lang['pandore_jump_gate'] = "Porte de saut spatial";
$lang['pandore_jump_gate_short'] = "P";
$lang['pandore_probe_number'] = "Nombre de sondes nécessaires pour l'espionnage";
$lang['pandore_buildings'] = "des bâtiments";
$lang['pandore_researchs'] = "des recherches";
$lang['pandore_update_date'] = "Date de mise à jour";
$lang['pandore_points_total'] = "Total de points";
$lang['pandore_custom_points_total'] = "Total de points personnalisé";
$lang['pandore_reset_points_total'] = "Cliquez pour réinitialiser le total de points";
$lang['pandore_points_rank_unavailable'] = "Classement général "./*start_red*/"%s"."indisponible"./*end_red*/"%s";
$lang['pandore_points_rank_of'] = "Classement général du"/*date*/;
$lang['pandore_buildings_points'] = "Points bâtiments";
$lang['pandore_reset_buildings_points'] = "Cliquez pour réinitialiser les points bâtiments";
$lang['pandore_defenses_points'] = "Points défenses";
$lang['pandore_reset_defenses_points'] = "Cliquez pour réinitialiser les points défenses";
$lang['pandore_research_points'] = "Points recherches";
$lang['pandore_research_menu'] = "Cliquez pour modifier les technologies";
$lang['pandore_reset_research'] = "Réinitialiser les recherches";
$lang['pandore_reset_research_clic'] = "Cliquez pour réinitialiser les recherches";
$lang['pandore_ok'] = "Ok";
$lang['pandore_research_rank_unavailable'] = "Classement recherche "./*start_red*/"%s"."indisponible"./*end_red*/"%s";
$lang['pandore_good_number_research'] = "Le nombre de technologies correspond avec le classement recherche du"/*date*/;
$lang['pandore_bad_number_research'] = "Le nombre de technologies ne correspond pas avec le classement recherche du"/*date*/;
$lang['pandore_calculated_fleet_points'] = "Points vaisseaux calculés";
$lang['pandore_reset_fleet_points'] = "Cliquez pour réinitialiser les points vaisseaux";
$lang['pandore_fleet_rank_unavailable'] = "Classement vaisseaux "./*start_red*/"%s"."indisponible"./*end_red*/"%s";
$lang['pandore_fleet_rank_of'] = "Classement vaisseaux du"/*date*/;
$lang['pandore_fleet_number'] = "Nombre de vaisseaux";
$lang['pandore_custom_fleet_number'] = "Nombre de vaisseaux personnalisé;";
$lang['pandore_reset_fleet_number'] = "Cliquez pour réinitialiser le nombre de vaisseaux";
$lang['pandore_fleets'] = "Vaisseaux";
$lang['pandore_spyed'] = "sondés";
$lang['pandore_maximum'] = "maximum";
$lang['pandore_assumed'] = "supposés";
$lang['pandore_assumed_help'] = "Les flottes grisées ne sont pas constructibles avec les technologies sondées.";
$lang['pandore_help'] = "Aide";
$lang['pandore_fleet_points'] = "Points vaisseaux";
$lang['pandore_missing_points'] = "Points manquants";
$lang['pandore_missing_fleet'] = "Vaisseaux manquants";
$lang['pandore_save'] = "Sauvegarder";
$lang['pandore_and'] = "et";
$lang['pandore_created_by'] = "Mod Pandore v"./*$mod_version*/"%1\$s"." développé par "./*$creator_name*/"%2\$s";
$lang['pandore_updated_by'] = "Mod Pandore v"./*$mod_version*/"%1\$s"." Mise à jour par "./*$updator_name*/" %2\$s";
$lang['pandore_forum'] = "Voir "./*forum_start_link*/"%1\$s"."plus d'informations"./*end_link*/"%2\$s";

// Records
$lang['pandore_records'] = "Enregistrements";
$lang['pandore_player_search'] = "Rechercher un joueur :";
$lang['pandore_mine'] = "Ne montrer que mes enregistrements";
$lang['pandore_ranks_points'] = "Classements / points";
$lang['pandore_points'] = "points";
$lang['pandore_fleet'] = "flotte";
$lang['pandore_research'] = "recherche";
$lang['pandore_saved_by'] = "Sauvegardé par";
$lang['pandore_date'] = "Date";
$lang['pandore_no_records'] = "Pas d\'enregistrements.";
$lang['pandore_click'] = "Cliquez pour voir l\'enregistrement";
$lang['pandore_select_all'] = "Tous sélectionnés";
$lang['pandore_unselect_all'] = "Aucun sélectionné;";
$lang['pandore_page'] = "Page "./*$page_number*/"%1\$s"." sur "./*$total_page*/"%2\$s";
$lang['pandore_erase'] = "Effacer les enregistrements sélectionnés";

// Solar Satellite
$lang['pandore_SAT'] = "Satellite solaire";

// Fleet
$lang['pandore_PT'] = "Petit transporteur";
$lang['pandore_GT'] = "Grand transporteur";
$lang['pandore_CLE'] = "Chasseur léger";
$lang['pandore_CLO'] = "Chasseur lourd";
$lang['pandore_CR'] = "Croiseur";
$lang['pandore_VB'] = "Vaisseau de bataille";
$lang['pandore_VC'] = "Vaisseau de colonisation";
$lang['pandore_REC'] = "Recycleur";
$lang['pandore_SE'] = "Sonde espionnage";
$lang['pandore_BMD'] = "Bombardier";
$lang['pandore_DST'] = "Destructeur";
$lang['pandore_EDLM'] = "Etoile de la mort";
$lang['pandore_TRA'] = "Traqueur";

// Technologies
$lang['pandore_Esp'] = "Technologie espionnage";
$lang['pandore_Ordi'] = "Technologie ordinateur";
$lang['pandore_Armes'] = "Technologie armes";
$lang['pandore_Bouclier'] = "Technologie bouclier";
$lang['pandore_Protection'] = "Technologie protection des vaisseaux";
$lang['pandore_NRJ'] = "Technologie Energie";
$lang['pandore_Hyp'] = "Technologie hyperespace";
$lang['pandore_RC'] = "Réacteur à combustion";
$lang['pandore_RI'] = "Réacteur à impulsion";
$lang['pandore_PH'] = "Propulsion hyperespace";
$lang['pandore_Laser'] = "Technologie laser";
$lang['pandore_Ions'] = "Technologie ions";
$lang['pandore_Plasma'] = "Technologies plasma";
$lang['pandore_RRI'] = "Réseau de recherche intergalactique";
$lang['pandore_Astrophysique'] = "Technologie Astrophysique";
$lang['pandore_Graviton'] = "Technologie graviton";

// Warnings
$lang['pandore_warning'] = "Attention";
$lang['pandore_warning_all_planete'] = "Toutes les planètes ont été trouvées.";
$lang['pandore_warning_one_planete'] = "Seule 1 planète a été trouvée.";
$lang['pandore_warning_less_planetes'] = "Seulement "./*$number_of_planets*/"%1\$s"." planètes sur "./*$planet_max*/"%2\$s"." maximum ont été trouvées.";
$lang['pandore_warning_ride_universe'] = "Sillonnez l'univers pour vous assurer que le joueur n'a pas d'autre planètes.";
$lang['pandore_warning_old_reports'] = "Certains rapports d'espionnage datent de plus d'une semaine.";
$lang['pandore_warning_respy'] = "Il serait préférable de ré-espionner les planètes et lunes suivantes :";
$lang['pandore_warning_old_rankings'] = "Certains classements datent de plus d'une semaine.";
$lang['pandore_warning_update_rankings'] = "Il serait préférable de mettre à jour les classements suivants :";

// Errors
$lang['pandore_error'] = "Erreur";
$lang['pandore_error_coord'] = "Coordonnées erronées, indiquez les valeurs séparées par deux points (ex: 1:234:5).";
$lang['pandore_error_player'] = "Pas de joueur trouvé aux coordonnées";
$lang['pandore_error_no_planete'] = "Aucune planète du joueur "./*$player_name*/"%s"." n'a été trouvée, vérifiez la typographie du pseudo.";
$lang['pandore_error_planete'] = "Plus de "./*$planet_max*/"%1\$s"." planète(s) autorisé par l'astrophysique ont été répertoriées pour le joueur "./*$player_name*/"%2\$s".". Veuillez mettre à jour les systèmes solaires suivants :\n";
$lang['pandore_error_missing_reports'] = "Il manque des rapports d'espionnage.";
$lang['pandore_error_respy'] = "Veuillez espionner les planètes et lunes suivantes :";
$lang['pandore_error_incomplete_reports'] = "Certains rapports d'espionnages sont incomplets.";
$lang['pandore_error_unknown_player'] = "Le joueur "./*$player_name*/"%s"." n'as pas été trouvé dans les classements.";
$lang['pandore_error_update_rankings'] = "Veuillez mettre à jour les classements suivants :";
$lang['pandore_error_points_ranking'] = "classement points";
$lang['pandore_error_fleet_ranking'] = "classement vaisseaux";
$lang['pandore_error_research_ranking'] = "classement recherche";

// Changelog
$lang['pandore_changelog'] = "Changelog";
$lang['pandore_changelog_date_format'] = "d/m/y";
$lang['pandore_intro'] = "Pandore fut crée sur l'ordre de Zeus ou Jupiter qui voulait se venger des hommes pour le vol du feu par Prométhée.<br />
Elle fut ainsi façonnée dans de l'argile par Héphaïstos ;<br />
Athéna lui donna ensuite la vie et l'habilla ;<br />
Aphrodite lui donna la beauté ;<br />
Apollon le talent musical,<br />
enfin Hermès lui apprit le mensonge et l'art de la persuasion.<br /><br />
Oserez-vous ouvrir la boîte ?";
$lang['pandore_version'] = "Version";
$lang['pandore_legend'] = "[Fix] : supression d'un bug<br />".
	"[Add] : rajout d'une fonction<br />".
	"[Imp] : amélioration d'une fonction";
$lang['pandore_version_0.1'] = "- [Add] Recherche d'un pseudo ou de coordonnées.<br />
	- [Add] Affichage des planètes et des lunes du joueur.<br />
	- [Add] Affichage des dates de dernière mise à jour complète avec un dégradé de couleur en fonction de leur ancienneté (moins d'un jour : vert, plus d'une semaine : rouge).<br />
	- [Add] Affichage des différents points et du nombre total de vaisseaux.<br />
	- [Add] Affichage des vaisseaux trouvés dans les rapports d'espionnage et du maximum possible de chaque vaisseaux.<br />
	- [Add] Possibilité de tester une composition de flotte.";
$lang['pandore_version_0.2'] = "- [Fix] Divers bugs.<br />
	- [Imp] Affichage des résultats même lorsqu'il manque des informations.";
$lang['pandore_version_0.3'] = "- [Fix] Encore des erreurs de calcul.<br />
	- [Fix] L'avertissement des rapports de plus d'une semaine reste parfois alors que tous les rapports sont à jour.<br />
	- [Fix] Les lunes sont toujours affichées dans l'avertissement comme datant de plus d'une semaine.";
$lang['pandore_version_0.4'] = "- [Fix] Date du dernier rapport complet erronée.<br />
	- [Fix] Détection des planètes nommées 'lune' erronée.<br />
	- [Add] Modifier les points et technologies à la main.<br />
	- [Add] Raccourcis vers les RE, la page galaxie et la page recherche.<br />
	- [Add] Nombre de sondes nécessaires pour avoir un rapport complet, lorsque les technologies sont connues.<br />
	- [Add] Enregistrements de simulations.<br />
	- [Imp] Internationalisation.";
$lang['pandore_version_0.5'] = "- [Fix] Détection des lunes qui dépend de la langue d'affichage.<br />
	- [Fix] La langue par défaut devient le français.<br />
	- [Fix] Erreur lors de l'installation avec une version récente de mySQL.<br />
	- [Fix] Erreur lors de l'enregistrement alors qu'un classement n'as pas été trouvé.<br />
	- [Fix] Mauvais affichage des classements dans les enregistrements.<br />
	- [Fix] Suppression impossible des enregistrements chez certains hébergeurs.";
$lang['pandore_version_1.0.0'] = "- [Fix] Mise à jour de la compatibilité avec OGSpy 3.0.7.<br />
	- [Fix] Technologies Expéditions remplacé par Astrophysique.<br />
	- [Add] Ajout du calcul de planètes maximum autorisé par l'astrophyque.<br />";
?>
