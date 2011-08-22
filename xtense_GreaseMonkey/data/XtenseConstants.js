var XtenseXpaths = {
metas : {
	ogame_version: "//meta[@name=\'ogame-version\']/@content",
	timestamp: "//meta[@name=\'ogame-timestamp\']/@content",
	universe: "//meta[@name=\'ogame-universe\']/@content",
	language: "//meta[@name=\'ogame-language\']/@content",
	player_id: "//meta[@name=\'ogame-player-id\']/@content",
	player_name: "//meta[@name=\'ogame-player-name\']/@content",
	ally_id: "//meta[@name=\'ogame-alliance-id\']/@content",
	ally_name: "//meta[@name=\'ogame-alliance-name\']/@content",
	ally_tag: "//meta[@name=\'ogame-alliance-tag\']/@content",
	planet_id: "//meta[@name=\'ogame-planet-id\']/@content",
	planet_name: "//meta[@name=\'ogame-planet-name\']/@content",
	planet_coords: "//meta[@name=\'ogame-planet-coordinates\']/@content",
	planet_type: "//meta[@name=\'ogame-planet-type\']/@content"
},
ally_members_list : {
	rows : "//table[@class=\'members zebra bborder\']/tbody/tr",
	player : "td[1]",
	rank : "td[4]/span",
	points : "td[4]/span/@title",
	coords : "td[5]/a",
	tag : "//table[@class=\'members bborder\']/tbody/tr[2]/td[2]/span"
},

overview : {
	cases : "//*[@id=\'diameterContentField\']/span[2]",
	temperatures : "//*[@id=\'temperatureContentField\']/text()"
},

galaxy : { 
	rows : "//tr[@class=\'row\']",
	position : "td[@class=\'position\']/text()",
	planetname : "td[@class=\'planetname\']/text()",
	planetname_l : "td[@class=\'planetname\']/a/text()",
	moon : "td[@class=\'moon\']/a",
	debris : "descendant::li[@class=\'debris-content\']",
	playername : "td[contains(@class,\'playername\')]/*[1]",//* pour a en gÃ©nÃ©ral, span pour joueur courant,
	allytag : "td[@class=\'allytag\']/span/text()",
	status : "descendant::span[@class=\'status\']",
	activity : "descendant::div[@id=\'TTPlanet\']/descendant::span[@class=\'spacing\']/text()",
	player_id : "descendant::a[contains(@href,\'writemessage\')]/@href",
	ally_id : "descendant::a[@target=\'_ally\']/@href"
},

levels : {
	level : "//span[@class=\'level\']/text()"
},

messages : {
	from : "//tr[1]/td",
	to : "//tr[2]/td",
	subject : "//tr[3]/td",
	date : "//tr[4]/td",
	contents : {
		"spy" : "//div[@class=\'note\']",
		"msg": "//div[@class=\'note\']",
		"ally_msg": "//div[@class=\'note\']",
		"expedition": "//div[@class=\'note\']",
		"rc": "//div[@id=\'battlereport\']",
		"rc_cdr": "//div[@class=\'note\']",
		"ennemy_spy": "//div[@class=\'textWrapper\']/div[@class=\'note\']",
		"livraison": "//div[@class=\'note\']",
		"livraison_me": "//div[@class=\'note\']"
	},
	spy : {
		fleetdefbuildings : "//table[contains(@class,\'spy\')]//th[@colspan=\'6\']",
		moon : "//a[@class=\'buttonSave\']"
	}
},

parseTableStruct : {
	units : "id(\'buttonz\')//ul/li/div/div",
	id : "a[starts-with(@id,\'details\')]",
	number : "a/span"
},

planetData : {
	name : "id(\'selectedPlanetName\')",
	name_planete : "//span[@class=\'planet-name\']",
	coords : "//div[@class=\'smallplanet\']/a[contains(@class,\'active\') or @href=\'#\']/span[@class=\'planet-koords\']",
	coords_unique_planet : "//div[@class=\'smallplanet\']/a[contains(@class,\'\') or @href=\'#\']/span[@class=\'planet-koords\']"
},

ranking : { 
	time : "//div[@id=\'statisticsContent\']//div[@class=\'header\']/h3/text()",
	who : "//input[@id=\'who\']/@value",
	type : "//input[@id=\'type\']/@value",
	
	rows : "id(\'ranks\')/tbody/tr",
	position : "td[@class=\'position\']/text()",
	player : {
		playername : "td[@class=\'name\']//a[contains(@href,\'galaxy\') and contains(@href,\'system\') and contains(@href,\'position\')]/text()",
		allytag : "td[@class=\'name\']//a[contains(@href,\'alliance\') or contains(@href,\'ainfo.php?allyid\')]/text()",
		points :  "td[@class=\'score\']/text()",
		player_id : "td[@class=\'sendmsg\']//a[contains(@href,\'writemessage\')]/@href",
		ally_id : "td[@class=\'name\']//a[contains(@target,\'_ally\')]/@href"
	},
	
	ally : {
		position_ally : "td[1]/text()",
		allytag : "td[2]/a[contains(@href,\'alliance\') or contains(@href,\'ainfo.php?allyid\')]/text()",
		points :  "td[4]/text()",
		members : "td[5]/text()",
		ally_id : "td[2]/a[contains(@target,\'_ally\')]/@href"
	}
},

ressources : {
	metal : "//span[@id=\'resources_metal\']/text()",
	cristal : "//span[@id=\'resources_crystal\']/text()",
	deuterium : "//span[@id=\'resources_deuterium\']/text()",
	antimatiere : "//span[@id=\'resources_darkmatter\']/text()",
	energie : "//span[@id=\'resources_energy\']/text()"	
},

rc : {
	list_infos : "//td[@class=\'newBack\']/center",
	list_rounds : "//div[@class=\'round_info\']",
	infos: {
		player : "span[contains(@class,\'name\')]",
		weapons : "span[contains(@class,\'weapons\')]",
		destroyed : "span[contains(@class,\'destroyed\')]"
	},
	list_types : "table/tbody/tr[1]/th",
	list_values : "table/tbody/tr[2]/td",
	result : "//div[@id=\'combat_result\']",
	combat_round : "//div[@id=\'master\']//div[@class=\'combat_round\']"
},

writemessage : {
	form : "//form[1]",
	from : "id(\'wrapper\')/form/div/table/tbody/tr[1]/td",
	to : "id(\'wrapper\')/form/div/table/tbody/tr[2]/td",
	subject : "id(\'wrapper\')/form/div[1]/table/tbody/tr[3]/td/input",
	date : "id(\'wrapper\')/form/div/table/tbody/tr[4]/td",
	content : "id(\'wrapper\')/form/div[2]/div/textarea"
	}
}

// Toutes les unites du jeu
// id : nom du champ dans la bdd
var XtenseDatabase = {
'resources': {601:'metal',602:'cristal',603:'deuterium',604:'energie'},
'buildings': { 1:'M', 2:'C', 3:'D', 4:'CES', 
			12:'CEF', 14:'UdR', 15:'UdN', 
			21:'CSp', 212:'Sat', 22:'HM', 23:'HC', 
			24:'HD', 31:'Lab', 33:'Ter', 
			34:'DdR', 44:'Silo', 41:'BaLu', 
			42:'Pha', 43:'PoSa'
			},
'researchs': { 106:'Esp', 108:'Ordi', 109:'Armes',
			110:'Bouclier', 111:'Protection', 
			113:'NRJ', 114:'Hyp', 115:'RC', 
			117:'RI', 118:'PH', 120:'Laser', 
			121:'Ions', 122:'Plasma', 123:'RRI', 
			124: 'Astrophysique', 199:'Graviton'
			},
'fleet': { 202:'PT', 203:'GT', 204:'CLE', 205:'CLO', 206:'CR', 207:'VB', 208:'VC', 209:'REC', 210:'SE', 211:'BMD', 212:'SAT', 213:'DST',
			214:'EDLM', 215:'TRA'
			},
'defense': { 401:'LM', 402:'LLE', 403:'LLO', 404:'CG', 405:'AI', 406:'LP', 407:'PB', 408:'GB', 502:'MIC', 503:'MIP' }
}

Ximplements(Xlocales, {'error start': 'ERREUR: ',
'http status 403': 'statut 403, Impossible d\'acceder au plugin Xtense.',
'http status 404': 'statut 404, Plugin Xtense introuvable, vérifiez que vous avez bien mis la bonne adresse vers le plugin Xtense',
'http status 500': 'statut 500: Erreur interne au serveur.',
'http timeout': 'Le serveur n\'a pas répondu à temps. Verifiez que votre hébergeur ne rencontre pas des problêmes de reseau.',
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
'grant system': 'Vous $1 ajouter des systêmes solaires', // can / cannot
'grant ranking': 'Vous $1 ajouter des classements', // can / cannot
'grant empire': 'Vous $1 mettre à jour votre espace personnel (Batiments, Recherches, Empire...)', // can / cannot
'grant messages': 'Vous $1 ajouter de messages (Rapports d\'espionnages, Rapports de combats, Espionnages ennemis...)', // can / cannot

'checking end': 'VERIFICATION TERMINEE',
'checking errors': 'Une ou plusieurs erreurs sont survenues, vous pouvez soit retourner à la fenetre des options ou alors fermer cette fenetre sans prendre en compte les erreurs.',
'checking success': 'Aucune erreur à signaler, vous pouvez fermer les options',

'connecting': 'Connexion en cours : ', // Server url
'checking server': 'Verification du serveur OGSpy n°$1', // Server number
'toolbar activated': 'Barre d\'outils activée',
'toolbar deactivated': 'Barre d\'outils désactivée',

'ogspy menu tooltip': 'Connexion automatique au serveur OGSpy',

'fatal error': 'Une erreur critique est survenue et a arrêté l\'exécution de Xtense',
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
'system detected': 'Systême solaire [$1:$2] détecté', // Galaxy, System
're detected': 'Rapport d\'espionnage détecté',
'rc detected': 'Rapport de combat détecté',
'res detected': 'Message de commerce détecté',

'no researchs' : 'Aucune recherche à envoyer',
'no defenses' : 'Aucune défense à envoyer',
'no buildings' : 'Aucun bâtiment à envoyer',
'no fleet' : 'Pas de flotte à envoyer',

'ranking player': 'joueurs',
'ranking ally': 'alliances',
'ranking points': 'points',
'ranking fleet': 'flotte',
'ranking research': 'recherches',
'ranking defense': 'défense',
'ranking buildings': 'bâtiments',

'invalid system': 'Systême solaire non pris en compte',
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
'error home full': 'Votre espace personnel est plein, impossible de rajouter une nouvelle planête',
'error plugin connections': 'Connexions au plugin Xtense non autorisées',
'error plugin config': 'Plugin Xtense non configuré par votre administrateur, impossible de l\'utiliser',
'error plugin univers': 'Numéro d\'univers d\'Ogame invalide sur cet OGSpy',
'error grant start': 'Vous ne possédez pas les autorisations nécessaires pour envoyer ',
'error grant empire': 'des pages de votre empire (Bâtiments, Laboratoire...)',
'error grant messages': 'des messages',
'error grant system': 'des systêmes solaires',
'error grant ranking': 'des classements',

'success home updated': 'Espace personnel mis à jour ($1)', // Page name
'success system': 'Mise à jour du système solaire [$1:$2] effectuée', // Galaxy, System
'success ranking': 'Classement $2 des $1 ($3-$4) mis à jour', // Primary type, secondary type, offset min, offset max
'success rc': 'Rapport de combat envoyé',
'success ally_list': 'Liste des joueurs de l\'alliance [$1] correctement envoyée', // TAG
'success messages': 'Message correctement envoyé',
'success fleetSending': 'Départ de flotte correctement envoyé',
'success spy': 'Rapport d\'espionnage correctement envoyé',
'success res': 'Message de commerce correctement envoyé',

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

var XtenseRegexps = {
planetNameAndCoords : ' (.*) \\[(\\d+:\\d+:\\d+)\\]',
planetCoords : '\\[(\\d+:\\d+:\\d+)\\]',
userNameAndCoords : '(.*) \\[(\\d+:\\d+:\\d+)\\]',
userNameAndDestroyed : ' (.*) d.truit',
moon : '=(\\d+)*',

messages : {
	ennemy_spy : '\\[(\\d+:\\d+:\\d+)\\][^\\]]*\\[(\\d+:\\d+:\\d+)\\][^%\\d]*([\\d]+)[^%\\d]*%',		
	trade_message_infos : 'Une flotte .trang.re de (\\S+) livre des ressources . (\\S+) (\\S+) :',
	trade_message_infos_me : 'Votre flotte atteint la plan.te (.*) (.*) et y livre les ressources suivantes',
	trade_message_infos_res_livrees : '(.*)Vous aviez :',
	trade_message_infos_res : 'M.tal : (.*) Cristal : (.*) Deut.rium : (.*)',
	trade_message_infos_me_res : 'M.tal :(.*)Cristal:(.*)Deut.rium:(.*)'
},
spy : {
	player : " '(.*)'\\)"
},
probability : ': (\\d+) %',
coords : '\\[(\\d+:\\d+:\\d+)\\]',
ally : 'Alliance \\[(.*)\\]',

parseTableStruct : '<a[^>]*id="details(\\d+)"[^>]*>[\\D\\d]*?([\\d.]+[KMG]?)<\/span>[^<]*<\/span>[^<]*<\/a>'
}