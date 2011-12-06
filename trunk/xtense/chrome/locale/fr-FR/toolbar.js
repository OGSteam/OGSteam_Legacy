/**
 * @author Unibozu
 * @license GNU/GPL
 */

Ximplements(Xlocales, {
	'toolbar activated': 'Barre d\'outils activ�e',
	'toolbar deactivated': 'Barre d\'outils d�sactiv�e',
	
	'ogspy menu tooltip': 'Connexion automatique au serveur OGSpy',
	
	'fatal error': 'Une erreur critique est survenue et a arr�t� l\'ex�cution de Xtense',
	'parsing error': 'Une erreur critique est survenue lors de la r�cup�ration des donn�es de la page',
	
	'no ogspy server': 'Aucun serveur',
	//'no ogame page': 'Page ogame non pris en compte',
	'no server': 'Aucun serveur disponible pour cet univers',
	'unknow page': 'Page inconnue',
	'activate': 'Activer',
	'deactivate': 'Desactiver',
	'wait send': 'En attente de l\'envoi manuel des donn�es',
	'unavailable parser lang': 'Xtense ne prend pas en charge ce serveur de jeu ($1)', // lang (ogame domain extension)
	
	'overview detected': 'Vue g�n�rale d�tect�e',
	'buildings detected': 'Batiments d�tect�s',
	'installations detected': 'Installations d�tect�s',
	'researchs detected': 'Recherches d�tect�s',
	'fleet detected': 'Flotte d�tect�e',
	'defense detected': 'D�fenses d�tect�s',
	'messages detected': 'Page de messages d�tect�e',
	'ranking detected': 'Statistiques $2 des $1 d�tect�es', // Primary type (ally/player), Secondary type (points, research, fleet)
	'ally_list detected': 'Liste des joueurs de l\'alliance d�tect�e',
	'system detected': 'Syst�me solaire [$1:$2] d�tect�', // Galaxy, System
	're detected': 'Rapport d\'espionnage d�tect�',
	'rc detected': 'Rapport de combat d�tect�',
	'res detected': 'Message de commerce d�tect�',
	
	'no researchs' : 'Aucune recherche � envoyer',
	'no defenses' : 'Aucune d�fense � envoyer',
	'no buildings' : 'Aucun b�timent � envoyer',
	'no fleet' : 'Pas de flotte � envoyer',
	
	'ranking player': 'joueurs',
	'ranking ally': 'alliances',
	'ranking points': 'points',
	'ranking fleet': 'flotte',
	'ranking research': 'recherches',
	'ranking defense': 'd�fense',
	'ranking buildings': 'b�timents',
	
	'invalid system': 'Syst�me solaire non pris en compte',
	'invalid ranking': 'Page des statistiques invalide',
	'invalid rc': 'Rapport de combat invalide (Contact perdu)',
	'no ranking': 'Aucun classement � envoyer',
	'no messages': 'Aucun message � envoyer',
	'impossible ranking': 'Impossible de r�cup�rer le classement alliance suivant les points par membre',
	
	// Responses
	'response start': 'Serveur $1 : ', // Serveur number
	'http status 403': 'Erreur 403, Impossible d\'acceder au Plugin Xtense',
	'http status 404': 'Erreur 404, Plugin Xtense introuvable',
	'http status 500': 'Erreur 500, Erreur interne au serveur',
	'http timeout': 'Impossible de contacter le serveur OGSpy cible',
	'http status unknow': 'Code d\'erreur Inconnu $1', // Http status
	'empty response': 'R�ponse du plugin vide',
	'invalid response': 'R�ponse inconnue du plugin (activez le debug pour voir le contenu)',
	'response hack': 'Les donn�es envoy�es ont �t� refus�es par le plugin Xtense',
	
	'error php version': 'Le plugin requiert PHP 5.1 pour fonctionner, la version actuelle ($1) n\'est pas assez r�cente',
	'error wrong version plugin': 'La version du mod Xtense sur le serveur est incompatible avec la version de votre barre d\'outils (requise: $1, version du mod : $2)', // required version, actual version
	'error wrong version xtense.php': 'Votre fichier xtense.php n\'a pas la m�me version que celle du plugin install�',
	'error wrong version toolbar': 'La version de la barre d\'outils Xtense est incompatible avec celle du plugin (requise: $1, votre version: $2)', // required version, actual version
	'error server active': 'Serveur OGSpy inactif (Raison: $1)', // reason
	'error username': 'Pseudo invalide',
	'error password': 'Mot de passe invalide',
	'error user active': 'Votre compte est inactif',
	'error home full': 'Votre espace personnel est plein, impossible de rajouter une nouvelle plan�te',
	'error plugin connections': 'Connexions au plugin Xtense non autoris�es',
	'error plugin config': 'Plugin Xtense non configur� par votre administrateur, impossible de l\'utiliser',
	'error plugin univers': 'Num�ro d\'univers d\'Ogame invalide sur cet OGSpy',
	'error grant start': 'Vous ne poss�dez pas les autorisations n�cessaires pour envoyer ',
	'error grant empire': 'des pages de votre empire (B�timents, Laboratoire...)',
	'error grant messages': 'des messages',
	'error grant system': 'des syst�mes solaires',
	'error grant ranking': 'des classements',
	
	'success home updated': 'Espace personnel mis � jour ($1)', // Page name
	'success system': 'Mise � jour du syst�me solaire [$1:$2] effectu�e', // Galaxy, System
	'success ranking': 'Classement $2 des $1 ($3-$4) mis � jour', // Primary type, secondary type, offset min, offset max
	'success rc': 'Rapport de combat envoy�',
	'success ally_list': 'Liste des joueurs de l\'alliance [$1] correctement envoy�e', // TAG
	'success messages': 'Message correctement envoy�',
	'success fleetSending': 'D�part de flotte correctement envoy�',
	'success spy': 'Rapport d\'espionnage correctement envoy�',
	'success res': 'Message de commerce correctement envoy�',
	
	'unknow response': 'Code r�ponse inconnu : "$1", data: "$2"', // code, content
	
	'page overview': 'Vue g�n�rale',
	'page buildings': 'B�timents',
	'page installations': 'Installations',
	'page labo': 'Laboratoire',
	'page defense': 'D�fense',
	'page fleet': 'Flotte',
	'page fleetSending': 'D�part de flotte',
	
	//'PM':'MP',
	
	'call messages': '-- Messages renvoy�s par les appels'
});
