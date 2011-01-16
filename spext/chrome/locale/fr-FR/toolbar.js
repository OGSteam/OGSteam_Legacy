/**
 * @author Unibozu
 * @license GNU/GPL
 */

Ximplements(Xlocales, {
	'toolbar activated': 'Barre d\'outils activée',
	'toolbar deactivated': 'Barre d\'outils désactivée',
	
	'SP²Gbd menu tooltip': 'Connexion automatique au serveur SP²Gbd',
	
	'fatal error': 'Une erreur critique est survenue et a arrêtée l\'exécution de SP²Gbd',
	'parsing error': 'Une erreur critique est survenue lors de la récupération des données de la page',
	
	'no SP²Gbd server': 'Aucun serveur',
	//'no ogame page': 'Page ogame non pris en compte',
	'no server': 'Aucun serveur disponible pour cet univers',
	'unknow page': 'Page inconnue',
	'activate': 'Activer',
	'deactivate': 'Desactiver',
	'wait send': 'En attente de l\'envoi manuel des données',
	'unavailable parser lang': 'SP²Gbd ne prend pas en charge ce serveur de jeu ($1)', // lang (ogame domain extension)
	
	'overview detected': 'Vue générale détectée',
	'buildings detected': 'Batiments détectés',
	'researchs detected': 'Recherches détectés',
	'fleet detected': 'Flotte détectée',
	'defense detected': 'Défenses détectés',
	'messages detected': 'Page de messages détectée',
	'ranking detected': 'Statistiques $2 des $1 détectées', // Primary type (ally/player), Secondary type (points, research, fleet)
	'ally_list detected': 'Liste des joueurs de l\'alliance détectée',
	'system detected': 'Système solaire [$1:$2] détecté', // Galaxy, System
	're detected': 'Rapport d\'espionnage détecté',
	'rc detected': 'Rapport de combat détecté',
	
	'no researchs' : 'Aucune recherche à envoyer',
	'no defenses' : 'Aucune défense à envoyer',
	'no fleet' : 'Pas de flotte à envoyer',
	
	'ranking player': 'joueurs',
	'ranking ally': 'alliances',
	'ranking points': 'points',
	'ranking fleet': 'flotte',
	'ranking research': 'recherches',
	
	'invalid system': 'Système solaire non pris en compte',
	'invalid ranking': 'Page des statistiques invalide',
	'invalid rc': 'Rapport de combat invalide (Contact perdu)',
	'no ranking': 'Aucun classement à envoyer',
	'no messages': 'Aucun message à envoyer',
	'impossible ranking': 'Impossible de récupérer le classement alliance suivant les points par membre',
	
	// Responses
	'response start': 'Serveur $1 : ', // Serveur number
	'http status 403': 'Erreur 403, Impossible d\'acceder au Plugin SP²Gbd',
	'http status 404': 'Erreur 404, Plugin SP²Gbd introuvable',
	'http status 500': 'Erreur 500, Erreur interne au serveur',
	'http timeout': 'Impossible de contacter le serveur SP²Gbd cible',
	'http status unknow': 'Code d\'erreur Inconnu $1', // Http status
	'empty response': 'Réponse du plugin vide',
	'invalid response': 'Réponse inconnue du plugin (activez le debug pour voir le contenu)',
	'response hack': 'Les données envoyées ont été refusées par le plugin SP²Gbd',
	
	'error php version': 'Le plugin requiert PHP 5.1 pour fonctionner, la version actuelle ($1) n\'est pas assez récente',
	'error wrong version plugin': 'La version du mod SP²Gbd sur le serveur est incompatible avec la version de votre barre d\'outils (requise: $1, version du mod : $2)', // required version, actual version
	'error wrong version SP²Gbd.php': 'Votre fichier SP²Gbd.php n\'a pas la même version que celle du plugin installé',
	'error wrong version toolbar': 'La version de la barre d\'outils SP²Gbd est incompatible avec celle du plugin (requise: $1, votre version: $2)', // required version, actual version
	'error server active': 'Serveur SP²Gbd inactif (Raison: $1)', // reason
	'error username': 'Pseudo invalide',
	'error password': 'Mot de passe invalide',
	'error user active': 'Votre compte est inactif',
	'error home full': 'Votre espace personnel est plein, impossible de rajouter une nouvelle planète',
	'error plugin connections': 'Connexions au plugin SP²Gbd non autorisées',
	'error plugin config': 'Plugin SP²Gbd non configuré par votre administrateur, impossible de l\'utiliser',
	'error plugin univers': 'Numéro d\'univers d\'Ogame invalide sur cet SP²Gbd',
	'error grant start': 'Vous ne possédez pas les autorisations nécessaires pour envoyer ',
	'error grant empire': 'des pages de votre empire (Bâtiments, Laboratoire...)',
	'error grant messages': 'des messages',
	'error grant system': 'des systèmes solaires',
	'error grant ranking': 'des classements',
	
	'success home updated': 'Espace personnel mis à jour ($1)', // Page name
	'success system': 'Mise à jour du système solaire [$1:$2] effectuée', // Galaxy, System
	'success ranking': 'Classement $2 des $1 ($3-$4) mis à jour', // Primary type, secondary type, offset min, offset max
	'success rc': 'Rapport de combat envoyé',
	'success ally_list': 'Liste des joueurs de l\'alliance [$1] correctement envoyée', // TAG
	'success messages': 'Messages correctement envoyés',
	'success fleetSending': 'Départ de flotte correctement envoyé',
	'success spy': 'Rapport d\'espionnage correctement envoyé',
	
	'unknow response': 'Code réponse inconnu : "$1", data: "$2"', // code, content
	
	'page overview': 'Vue générale',
	'page buildings': 'Bâtiments',
	'page labo': 'Laboratoire',
	'page defense': 'Défense',
	'page fleet': 'Flotte',
	'page fleetSending': 'Départ de flotte',
	
	
	'call messages': '-- Messages renvoyés par les appels'
});
