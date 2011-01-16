/**
 * @author Unibozu
 * @license GNU/GPL
 */

 Ximplements(Xlocales, {
	'error start': 'ERREUR: ',
	'http status 403': 'statut 403, Impossible d\'acceder au plugin Xtense.',
	'http status 404': 'statut 404, Plugin Xtense introuvable, vérifiez que vous avez bien mis la bonne adresse vers le plugin Xtense',
	'http status 500': 'statut 500: Erreur interne au serveur.',
	'http timeout': 'Le serveur n\'a pas répondu à temps. Verifiez que votre hébergeur ne rencontre pas des problèmes de reseau.',
	'http status unknow': 'statut http inconnu ($1)',
	
	'incorrect response' : 'Réponse incorrecte',
	'empty response': 'Réponse du plugin vide',
	'invalid response': 'Impossible de récupérer les données envoyées par le plugin, verifiez que votre hebergeur ne rajoute pas de la pub, ce qui peut provoquer cette erreur.',
	
	'php version': 'La version PHP de votre hébergement n\'est pas assez récente. Xtense requiert au minimum la version 5.1 de PHP.',
	'error occurs': 'Une erreur est survenue',
	'wrong version plugin': 'Vous ne pouvez pas vous connecter au plugin, sa version est trop vielle pour pouvoir être utilisée avec votre barre d\'outils. Version du plugin : $1, version requise : $2 \nVous devez mettre à jour le plugin Xtense avant de pouvoir continuer', // Actual pluhin version, version required
	'wrong version xtense.php': 'Votre fichier xtense.php n\'a pas la même version que celle du plugin installé',
	'wrong version toolbar': 'Vous ne pouvez pas vous connecter au plugin avec votre version de Xtense.\nVotre version : $1, requise : $2\nVous devez mettre à jour votre barre d\'outils Xtense avant de pouvoir continuer', // Actual toolbar version, version required
	'server active': 'le serveur OGSpy est pour le moment désactivé',
	'plugin connections': 'Connexions au plugin Xtense désactivées',
	'plugin config': 'Plugin Xtense non configuré par votre administrateur, impossible de l\'utiliser',
	'plugin univers': 'Numéro d\'univers d\'Ogame invalide sur cet OGSpy',
	'username': 'Le compte "$1" est inconnu. Attention à la casse (différence Majuscules / minuscules)', // Username
	'password': 'Votre mot de passe n\'est pas bon. Attention à la casse (différence Majuscules / minuscules)',
	'user active': 'Votre compte est inactif, vous ne pouvez pas vous connecter',
	
	'informations': 'Informations',
	'server name': 'Nom du serveur OGSpy', // Server name
	'version': 'Version', // version
	'grant all': 'Vous possédez tous les droits pour utiliser Xtense',
	'grant nothing': 'Vous ne possédez aucune autorisation quant à l\'import de données sur votre OGSpy',
	
	'grant can': 'pouvez',
	'grant cannot': 'ne pouvez pas',
	'grant system': 'Vous $1 ajouter des systèmes solaires', // can / cannot
	'grant ranking': 'Vous $1 ajouter des classements', // can / cannot
	'grant empire': 'Vous $1 mettre à jour votre espace personnel (Batiments, Recherches, Empire...)', // can / cannot
	'grant messages': 'Vous $1 ajouter de messages (Rapports d\'espionnages, Rapports de combats, Espionnages ennemis...)', // can / cannot
	
	'checking end': 'VERIFICATION TERMINEE',
	'checking errors': 'Une ou plusieurs erreurs sont survenues, vous pouvez soit retourner à la fenetre des options ou alors fermer cette fenetre sans prendre en compte les erreurs.',
	'checking success': 'Aucune erreur à signaler, vous pouvez fermer les options',
	
	'connecting': 'Connexion en cours : ', // Server url
	'checking server': 'Verification du serveur OGSpy n°$1' // Server number
});
