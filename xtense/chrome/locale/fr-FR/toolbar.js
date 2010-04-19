/**
 * @author Unibozu
 * @license GNU/GPL
 */

Ximplements(Xlocales, {
	'toolbar activated': 'Barre d\'outils activée',
	'toolbar deactivated': 'Barre d\'outils désactivée',
	
	'ogspy menu tooltip': 'Connexion automatique au serveur OGSpy',
	
	'fatal error': 'Une erreur critique est survenue et a arrêtée l\'exécution de Xtense',
	'parsing error': 'Une erreur critique est survenue lors de la récupération des données de la page',
	
	'no ogspy server': 'Aucun serveur',
	//'no ogame page': 'Page ogame non pris en compte',
	'no server': 'Aucun serveur disponible pour cet univers',
	'unknow page': 'Page inconnue',
	'activate': 'Activer',
	'deactivate': 'Desactiver',
	'wait send': 'En attente de l\'envoi manuel des données',
	'unavailable parser lang': 'Xtense ne prend pas en charge ce serveur de jeu ($1)', // lang (ogame domain extension)
	
	'overview detected': 'Vue générale détectée',
	'buildings detected': 'Batiments détectés',
	'installations detected': 'Installations détectés',
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
	'no buildings' : 'Aucun bâtiment à envoyer',
	'no defenses' : 'Aucune défense à envoyer',
	'no fleet' : 'Pas de flotte à envoyer',
	
	'ranking player': 'joueurs',
	'ranking ally': 'alliances',
	'ranking points': 'points',
	'ranking fleet': 'flotte',
	'ranking research': 'recherches',
	'ranking defense': 'défense',
	'ranking buildings': 'bâtiments',
	
	'invalid system': 'Système solaire non pris en compte',
	'invalid ranking': 'Page des statistiques invalide',
	'invalid rc': 'Rapport de combat invalide (Contact perdu)',
	'no ranking': 'Aucun classement à envoyer',
	'no messages': 'Aucun message à envoyer',
	'impossible ranking': 'Impossible de récupérer le classement alliance suivant les points par membre',
	
	// Responses
	'response start': 'Serveur $1 : ', // Serveur number
	'http status 403': 'Erreur 403, Impossible d\'acceder au Plugin Xtense',
	'http status 404': 'Erreur 404, Plugin Xtense introuvable',
	'http status 500': 'Erreur 500, Erreur interne au serveur',
	'http timeout': 'Impossible de contacter le serveur OGSpy cible',
	'http status unknow': 'Code d\'erreur Inconnu $1', // Http status
	'empty response': 'Réponse du plugin vide',
	'invalid response': 'Réponse inconnue du plugin (activez le debug pour voir le contenu)',
	'response hack': 'Les données envoyées ont été refusées par le plugin Xtense',
	
	'error php version': 'Le plugin requiert PHP 5.1 pour fonctionner, la version actuelle ($1) n\'est pas assez récente',
	'error wrong version plugin': 'La version du mod Xtense sur le serveur est incompatible avec la version de votre barre d\'outils (requise: $1, version du mod : $2)', // required version, actual version
	'error wrong version xtense.php': 'Votre fichier xtense.php n\'a pas la même version que celle du plugin installé',
	'error wrong version toolbar': 'La version de la barre d\'outils Xtense est incompatible avec celle du plugin (requise: $1, votre version: $2)', // required version, actual version
	'error server active': 'Serveur OGSpy inactif (Raison: $1)', // reason
	'error username': 'Pseudo invalide',
	'error password': 'Mot de passe invalide',
	'error user active': 'Votre compte est inactif',
	'error home full': 'Votre espace personnel est plein, impossible de rajouter une nouvelle planète',
	'error plugin connections': 'Connexions au plugin Xtense non autorisées',
	'error plugin config': 'Plugin Xtense non configuré par votre administrateur, impossible de l\'utiliser',
	'error plugin univers': 'Numéro d\'univers d\'Ogame invalide sur cet OGSpy',
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
	'page installations': 'Installations',
	'page labo': 'Laboratoire',
	'page defense': 'Défense',
	'page fleet': 'Flotte',
	'page fleetSending': 'Départ de flotte',
	
	//'PM':'MP',
	
	'call messages': '-- Messages renvoyés par les appels'
});
