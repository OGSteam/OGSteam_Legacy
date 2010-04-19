<?php

/**
 * Protocole a utiliser avec Xtense
 * -------------------------------------------
 * Réponses envoyées à la barre de type Json, sous cette forme : 
 * 
 * [ <code>, {<params 1>}, {<params 2>}, ...]
 * 
 * <code> : Code de réponse à Xtense pour signifier le type de réponse
 * 		0 : Erreur
 * 		1 : Valide
 */

/**
 * Codes des types de Callbacks
 * --------------------------------------------
 * galaxy 						: Page galaxie
 * ally_list 					: Membres de son alliance
 * buildings 					: Batiments
 * research 					: Recherche
 * fleet 						: Flotte
 * defense 						: Défenses
 * spy 							: Sondages
 * own_spy 						: Sondages sur soi
 * rc 							: Rapports de recyclages
 * 
 * 
 * ranking_player_fleet 		: Stats joueurs flotte
 * ranking_player_points 		: Stats joueurs points
 * ranking_player_research 		: Stats joueurs recherche
 * ranking_ally_fleet 			: Stats alliances flotte
 * ranking_ally_points 			: Stats alliances points
 * ranking_ally_research 		: Stats alliances recherche
 * 
 */

/**
 * Codes d'erreur renvoyés à Xtense
 * ---------------------------------------------
 * wrong version		: Mauvaise version de la barre
 * missing ident		: Paramètres d'identification manquants
 * server active		: Serveur OGSpy inactif
 * username				: Nom d'utilisateur inconnu
 * password				: Mauvais mot de passe
 * user active			: Utilisateur inactif
 * 
 */



?>