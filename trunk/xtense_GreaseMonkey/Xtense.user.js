// ==UserScript==
// @name		Xtense
// @version     2.3.10
// @namespace	xtense.ogsteam.fr
// @include     http://*.ogame.*/game/index.php*
// @description Cette extensions permet d'envoyer des données d'Ogame à votre serveur OGSPY d'alliance
// ==/UserScript==

// Variables Xtense
var VERSION = "2.3.10";
var PLUGIN_REQUIRED = "2.3.10";
var callback = null;
var Xlocales = {};
var urlIcone = "http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtense.gif";

const XLOG_WARNING = 1, XLOG_ERROR = 2, XLOG_NORMAL = 3, XLOG_SUCCESS = 4, XLOG_COMMENT = 5;


// Navigateurs
var isFirefox = (window.navigator.userAgent.indexOf('Firefox') > -1 ) ? true : false;
var isChrome = (window.navigator.userAgent.indexOf('Chrome') > -1 ) ? true : false;

// Variables globales
var url=location.href;// Adresse en cours sur la barre d'outils
var urlUnivers = url.match(new RegExp('(.*)\/game'))[1];
var numUnivers = urlUnivers.match(new RegExp('uni(.*).ogame'))[1];
var langUnivers = urlUnivers.match(new RegExp('ogame.(.*)'))[1];
var nomScript = 'Xtense';
var cookie = nomScript+"-"+numUnivers+"-";
var callback = null;

if(isChrome){
	function Ximplements (object, implement) {
		for (var i in implement) object[i] = implement[i];
	}
	function Xl(name) {
		try {
			if (!Xlocales[name]) {
				log('Unknow locale "'+name+'"');
				return '[Chaine non disponible]';
			}
			
			var locale = Xlocales[name];
			for (var i = 1, len = arguments.length; i < len; i++) {
				locale = locale.replace('$'+i, arguments[i]);
			}
			return locale;
		} catch (e) { alert(e); return false; }
	}
	var XtenseXpaths = {
		metas : {
			ogame_version: "//meta[@name='ogame-version']/@content",
			timestamp: "//meta[@name='ogame-timestamp']/@content",
			universe: "//meta[@name='ogame-universe']/@content",
			language: "//meta[@name='ogame-language']/@content",
			player_id: "//meta[@name='ogame-player-id']/@content",
			player_name: "//meta[@name='ogame-player-name']/@content",
			ally_id: "//meta[@name='ogame-alliance-id']/@content",
			ally_name: "//meta[@name='ogame-alliance-name']/@content",
			ally_tag: "//meta[@name='ogame-alliance-tag']/@content",
			planet_id: "//meta[@name='ogame-planet-id']/@content",
			planet_name: "//meta[@name='ogame-planet-name']/@content",
			planet_coords: "//meta[@name='ogame-planet-coordinates']/@content",
			planet_type: "//meta[@name='ogame-planet-type']/@content"
		},
		ally_members_list : {
			rows : '//table[@class="members zebra bborder"]/tbody/tr',
			player : 'td[1]',
			rank : 'td[4]/span',
			points : 'td[4]/span/@title',
			coords : 'td[5]/a',
			tag : '//table[@class="members bborder"]/tbody/tr[2]/td[2]/span'
		},
		
		overview : {
			cases : "//*[@id='diameterContentField']/span[2]",
			temperatures : "//*[@id='temperatureContentField']/text()"
		},
		
		galaxy : { 
			rows : '//tr[@class="row"]',
			position : 'td[@class="position"]/text()',
			planetname : 'td[@class="planetname"]/text()',
			planetname_l : 'td[@class="planetname"]/a/text()',
			moon : 'td[@class="moon"]/a',
			debris : 'descendant::li[@class="debris-content"]',
			playername : 'td[contains(@class,"playername")]/*[1]',//* pour a en gï¿½nï¿½ral, span pour joueur courant,
			allytag : 'td[@class="allytag"]/span/text()',
			status : 'descendant::span[@class="status"]',
			activity : 'descendant::div[@id="TTPlanet"]/descendant::span[@class="spacing"]/text()',
			player_id : 'descendant::a[contains(@href,"writemessage")]/@href',
			ally_id : 'descendant::a[@target="_ally"]/@href'
		},
		
		levels : {
			level : '//span[@class="level"]/text()'
		},
		
		messages : {
			from : '//tr[1]/td',
			to : '//tr[2]/td',
			subject : '//tr[3]/td',
			date : '//tr[4]/td',
			contents : {
				'spy' : '//div[@class="note"]',
				'msg': '//div[@class="note"]',
				'ally_msg': '//div[@class="note"]',
				'expedition': '//div[@class="note"]',
				'rc': '//div[@id="battlereport"]',
				'rc_cdr': '//div[@class="note"]',
				'ennemy_spy': '//div[@class="textWrapper"]/div[@class="note"]',
				'livraison': '//div[@class="note"]',
				'livraison_me': '//div[@class="note"]'
			},
			spy : {
				fleetdefbuildings : '//table[contains(@class, "spy")]//th[@colspan="6"]',
				moon : '//a[@class="buttonSave"]'
			}
		},
		
		parseTableStruct : {
			units : "id('buttonz')//ul/li/div/div",
			id : "a[starts-with(@id,'details')]",
			number : "a/span"
		},
		
		planetData : {
			name : "id('selectedPlanetName')",
			name_planete : "//span[@class='planet-name']",
			coords : "//div[@class='smallplanet']/a[contains(@class,'active') or @href='#']/span[@class='planet-koords']",
			coords_unique_planet : "//div[@class='smallplanet']/a[contains(@class,'') or @href='#']/span[@class='planet-koords']"
		},
		
		ranking : { 
			time : '//div[@id="statisticsContent"]//div[@class="header"]/h3/text()',
			who : '//input[@id="who"]/@value',
			type : '//input[@id="type"]/@value',
			
			rows : 'id("ranks")/tbody/tr',
			position : 'td[@class="position"]/text()',
			player : {
				playername : 'td[@class="name"]//a[contains(@href,"galaxy") and contains(@href,"system") and contains(@href,"position")]/text()',
				allytag : 'td[@class="name"]//a[contains(@href,"alliance") or contains(@href,"ainfo.php?allyid")]/text()',
				points :  'td[@class="score"]/text()',
				player_id : 'td[@class="sendmsg"]//a[contains(@href,"writemessage")]/@href',
				ally_id : 'td[@class="name"]//a[contains(@target,"_ally")]/@href'
			},
			
			ally : {
				position_ally : 'td[1]/text()',
				allytag : 'td[2]/a[contains(@href,"alliance") or contains(@href,"ainfo.php?allyid")]/text()',
				points :  'td[4]/text()',
				members : 'td[5]/text()',
				ally_id : 'td[2]/a[contains(@target,"_ally")]/@href'
			}
		},
		
		ressources : {
			metal : "//span[@id='resources_metal']/text()",
			cristal : "//span[@id='resources_crystal']/text()",
			deuterium : "//span[@id='resources_deuterium']/text()",
			antimatiere : "//span[@id='resources_darkmatter']/text()",
			energie : "//span[@id='resources_energy']/text()"	
		},
		
		rc : {
			list_infos : '//td[@class="newBack"]/center',
			list_rounds : '//div[@class="round_info"]',
			infos: {
				player : 'span[contains(@class, "name")]',
				weapons : 'span[contains(@class, "weapons")]',
				destroyed : 'span[contains(@class, "destroyed")]'
			},
			list_types : 'table/tbody/tr[1]/th',
			list_values : 'table/tbody/tr[2]/td',
			result : '//div[@id="combat_result"]',
			combat_round : '//div[@id="master"]'//div[@class="combat_round"]'
		},
		
		writemessage : {
			form : '//form[1]',
			from : 'id("wrapper")/form/div/table/tbody/tr[1]/td',
			to : 'id("wrapper")/form/div/table/tbody/tr[2]/td',
			subject : 'id("wrapper")/form/div[1]/table/tbody/tr[3]/td/input',
			date : 'id("wrapper")/form/div/table/tbody/tr[4]/td',
			content : 'id("wrapper")/form/div[2]/div/textarea'
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
		'fleet': { 		202:'PT', 203:'GT', 204:'CLE', 205:'CLO',
							206:'CR', 207:'VB', 208:'VC', 209:'REC', 
							210:'SE', 211:'BMD', 212:'SAT', 213:'DST', 
							214:'EDLM', 215:'TRA',
							},
		'defense': { 	401:'LM', 402:'LLE', 403:'LLO', 404:'CG',
							405:'AI', 406:'LP', 407:'PB', 408:'GB', 
							502:'MIC', 503:'MIP' 
							}
	}
	
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
	
	var XtenseMetas = {
		getOgameVersion : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.ogame_version);	
		},
		getTimestamp : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.timestamp);	
		},
		getUniverse : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.universe);	
		},
		getLanguage : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.language);	
		},
		getPlayerId : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.player_id);	
		},
		getPlayerName : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.player_name);	
		},
		getAllyId : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.ally_id);	
		},
		getAllyName : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.ally_name);	
		},
		getAllyTag : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.ally_tag);	
		},
		getPlanetId : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.planet_id);	
		},
		getPlanetName : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.planet_name);	
		},
		getPlanetCoords : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.planet_coords);	
		},
		getPlanetType : function() {
			return Xpath.getStringValue(document,XtenseXpaths.metas.planet_type);	
		}
	}
	
	Ximplements(Xlocales, {
		'error start': 'ERREUR: ',
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
		
	//**********************
	//** Fonctions Xtense **
	//**********************
	var XtenseRequest = {
		postedData : [],
		loading : {},
		data : {},
		send : function (){
			//if (! servers) servers = Xservers.list;
			
			//for (var i = 0, len = servers.length; i < len; i++){
				//var server = servers[i];
				var postData = 'toolbar_version=' + VERSION + '&mod_min_version=' + PLUGIN_REQUIRED + '&user=' + GM_getValue(XtenseOptions.server_ids.user,'') + '&password=' + MD5(SHA1(GM_getValue(XtenseOptions.server_ids.password,''))) + '&univers=' + urlUnivers + XtenseRequest.serializeData();
				
				//if (Xprefs.getBool('spy-debug')) postData += '&spy_debug=1';
				//if (Xprefs.getBool('dev')) postData += '&dev=1';
				//log("sending " + postData + " to " + GM_getValue(XtenseOptions.server_ids.url,'') + " from " + urlUnivers);
				new Xajax(
				{
					url: GM_getValue(XtenseOptions.server_ids.url,''),
					post: postData,
					callback: null,
					scope: this
				});
				
				postedData = postData;
				loading = true;
				
			//}
		},		
		call : function (Server, Response){
			XtenseRequest.loading[Server.n] = false;
			XtenseRequest.callback.apply(this.scope,[ this, Server, Response]);
		},
		set : function (name, value){
			if (typeof name == 'string') this.data[name] = value; else {
				for (var n = 0, len = arguments.length; n < len; n++){
					for (var i in arguments[n]) this.data[i] = arguments[n][i];
				}
			}
		},		
		serializeObject : function (obj, parent, tab){
			var retour = '';
			var type = typeof obj;
			if (type == 'object'){
				for (var i in obj){
					if (parent != '')
					var str = parent + '[' + i + ']'; else var str = i;
					var a = false;
					// Patch pour Graphic Tools for Ogame
					if (str.search("existsTOG") == - 1){
						a = this.serializeObject(obj[i], str, tab);
					}
					if (a != false)
					tab.push(a);
				}
				return false;
			} else if (type == 'boolean')
			retour = (obj == true? 1: 0); else retour = obj + '';
			return parent + '=' + encodeURIComponent(retour).replace(new RegExp("(%0A)+", "g"), '%20').replace(new RegExp("(%09)+", "g"), '%20').replace(new RegExp("(%20)+", "g"), '%20');
		},		
		serializeData : function (){
			var uri = '';
			var tab =[];
			this.serializeObject(this.data, '', tab);
			uri = '&' + tab.join('&');
			return uri;
		}
	}
	function GM_getValue(key,defaultVal){
		var retValue=null;
		var keyStore = cookie+key;
		try{			
			retValue = window.localStorage.getItem(keyStore);
			if (retValue == null || retValue.length == 0) retValue = defaultVal;
			//log("GM_getValue() returned :"+retValue);
			return retValue;
		}catch(e) {
      		log("Error inside GM_getValue() for key:" + keyStore);
		}
	}
	function GM_setValue(key,value){
		var keyStore=cookie+key;
		try{
			retValue = window.localStorage.getItem(keyStore);
			if (retValue == null || retValue.length == 0) window.localStorage.removeItem(keyStore);
			window.localStorage.setItem(keyStore, value);
			//log("GM_setValue() set "+keyStore+"="+value);
		}catch(e) {
      		log("Error inside GM_setValue() for key:" + keyStore+" and value:"+value);
		}	
	}
	function GM_deleteValue(key){
		window.localStorage.removeItem(key);
	}
	function log(message){
		console.log(nomScript+" says : "+message);
	}
	var Xpath = {//node est facultatif
		getNumberValue : function (doc,xpath,node) {
			node = node ? node : doc;
			return doc.evaluate(xpath,node,null,XPathResult.NUMBER_TYPE, null).numberValue;
		},
		getStringValue : function (doc,xpath,node) {
			node = node ? node : doc;
			return doc.evaluate(xpath,node,null,XPathResult.STRING_TYPE, null).stringValue;
		},
		getOrderedSnapshotNodes : function (doc,xpath,node) {
			node = node ? node : doc;
			return doc.evaluate(xpath,node,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
		},
		getUnorderedSnapshotNodes : function (doc,xpath,node) {
			node = node ? node : doc;
			return doc.evaluate(xpath,node,null,XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);
		},	
		getSingleNode : function (doc,xpath,node) {
			node = node ? node : doc;
			return doc.evaluate(xpath,node,null,XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
		}
	}	
	String.prototype.trim = function () {
		return this.replace(/^\s*/, '').replace(/\s*$/, '');
	}
	String.prototype.trimAll = function () {
		return this.replace(/\s*/g, '');
	}
	String.prototype.trimInt = function() {
		string = this.replace(/\D/g,'');
		return string ? parseInt(string) : 0;
	}
	String.prototype.trimZeros = function() {
		return this.replace(/^0+/g,'');
	}
	String.prototype.getInts = function (/*separator*/) {
		/*if(typeof separator!="undefined")reg=new Regexp("[0-9("+separator+")]+","g");
		else reg=new Regexp("[0-9("+separator+")]+","g");*/
		var v = this.match(/[0-9][0-9.]*/g);
		v.forEach(function (el, index, arr) { arr[index] = parseInt(el.replace(/\./g, '')); });
		return v;
	}
	function Xajax(obj) {
		var xhr = new XMLHttpRequest();
		var callback = obj.callback || function(){};
		//var args = obj.args || [];
		var args = new Array();
		var scope = obj.scope || null;
		var url = obj.url || '';
		var post = obj.post || '';
	
		xhr.onreadystatechange =  function() {
			if(xhr.readyState == 4) {
				args.push({status: xhr.status, content: xhr.responseText});
				//alert(args[0].status);
				//callback.apply(scope, args);
				handleResponse(args[0]);
			}
		};
		
		xhr.open('POST', url, true);
		xhr.setRequestHeader('User-Agent', 'Xtense2');
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.send(post);
		
		//data = eval(Response.content);
	}
	
	function setStatus(type,message){
		if(type==XLOG_SUCCESS){
			document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseOk.gif";
		} else if(type==XLOG_NORMAL){
			document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseNo.gif";
		} else if(type==XLOG_WARNING){
			document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseWarn.gif";
		} else if(type==XLOG_ERROR){
			document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseKo.gif";
		} else {
			document.getElementById("xtense.icone").src=urlIcone;
		}
		document.getElementById("xtense.icone").title=message;
	}
	
	var XtenseOptions = {
		server_ids : {
			url : "server.url.plugin",
			user : "server.user",
			password : "server.pwd"
		}
	}
	
	function handleResponse(Response) {
		//Xdump(Response.content);
		//if (Server.cached()) var message_start = '"'+Server.name+'" : ';
		//else var message_start = Xl('response start', Server.n+1);
		
		//var extra = {Request: Request, Server: Server, Response: Response, page: Request.data.type};
		if (Response.status != 200) {
			if (Response.status == 404) 		log(Xl('http status 404'));
			else if (Response.status == 403) 	log(Xl('http status 403'));
			else if (Response.status == 500) 	log(Xl('http status 500'));
			else if (Response.status == 0)		log(Xl('http timeout'));
			else 								log(Xl('http status unknow', Response.status));
		} else {
			var type = XLOG_SUCCESS;
			
			/*if (Response.content == '') {
				Request.Tab.setStatus(message_start + Xl('empty response'), XLOG_ERROR, extra);
				return;
			}
			
			if (Response.content == 'hack') {
				Request.Tab.setStatus(message_start + Xl('response hack'), XLOG_ERROR, extra);
				return;
			}*/
			
			var data = {};
			if (Response.content.match(/^\(\{.*\}\)$/g)){
				data = eval(Response.content);
			} else {
				var match = null;
				if ((match = Response.content.match(/\(\{.*\}\)/))) {
					data = eval(match[0]);
					// Message d'avertissement
					type = XLOG_WARNING;
					log("full response:"+escape(Response.content));
				} else {
					// Message d'erreur
					/*Request.Tab.setStatus(message_start + Xl('invalid response'), XLOG_ERROR, extra);
					if (Xprefs.getBool('debug')) {
						throw_plugin_error(Response, Server);
					}*/
					return;
				}
			}
			
			var message = '';
			var code = data.type;

			/*if (data.status == 0) {
				type = XLOG_ERROR;
				if (code == 'wrong version') {
					if (data.target == 'plugin') 			message = Xl('error wrong version plugin', Xtense.PLUGIN_REQUIRED, data.version); 
					else if (data.target == 'xtense.php') 	message = Xl('error wrong version xtense.php');
					else 									message = Xl('error wrong version toolbar', data.version, Xtense.VERSION);
				}
				else if (code == 'php version')			message = Xl('error php version', data.version);
				else if (code == 'server active') 		message = Xl('error server active', data.reason);
				else if (code == 'username') 			message = Xl('error username');
				else if (code == 'password') 			message = Xl('error password');
				else if (code == 'user active') 		message = Xl('error user active');
				else if (code == 'home full')			message = Xl('error home full');
				else if (code == 'plugin connections')	message = Xl('error plugin connections');
				else if (code == 'plugin config')		message = Xl('error plugin config');
				else if (code == 'plugin univers')		message = Xl('error plugin univers');
				else if (code == 'grant') 				message = Xl('error grant start') + Xl('error grant '+ data.access);
				else 									message = Xl('unknow response', code, Response.content);
			} else {*/
				if (code == 'home updated') 			message = Xl('success home updated', Xl('page '+data.page));
				else if (code == 'system')				message = Xl('success system', data.galaxy, data.system);
				/*else if (code == 'ranking') 			message = Xl('success ranking', Xl('ranking '+data.type1), Xl('ranking '+data.type2), data.offset, data.offset+99);
				else if (code == 'rc')					message = Xl('success rc');
				else if (code == 'ally_list')			message = Xl('success ally_list', data.tag);
				else if (code == 'messages')			message = Xl('success messages');
				else if (code == 'spy') 				message = Xl('success spy');
				else if (code == 'fleetSending')		message = Xl('success fleetSending');*/
				else 									message = Xl('unknow response', code, Response.content);
			//}
			
			//if (Xprefs.getBool('display-execution-time') && data.execution) message = '['+data.execution+' ms] '+ message_start + message;
			//if (Xprefs.getBool('display-new-messages') && typeof data.new_messages!='undefined') Request.Tab.setNewPMStatus (data.new_messages, Server);
			
			if (data.calls) {
				// Merge the both objects
				//var calls = extra.calls = data.calls;
				var calls = data.calls;
				calls.status = 'success';
				
				if (calls.warning.length > 0) calls.status = 'warning';
				if (calls.error.length > 0) calls.status = 'error';
				
				// Calls messages
				if (data.call_messages) {
					calls.messages = {success: [], warning: [], error: []};
					
					// Affichage des messages dans l'ordre : success, warning, error
					for (var i = 0, len = data.call_messages.length; i < len; i++) {
						calls.messages[data.call_messages[i].type].push(data.call_messages[i].mod + ' : ' +data.call_messages[i].message);
					}
				}
			}
			setStatus(type,'['+data.execution+' ms] '+message);
			//Request.Tab.setStatus(message, type, extra);
		}
	}
	
	eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('l 3Q(w){l P(n,s){e 2w=(n<<s)|(n>>>(32-s));f 2w};l 2z(1w){e 1c="";e i;e 2d;e 1Y;J(i=0;i<=6;i+=2){2d=(1w>>>(i*4+4))&1X;1Y=(1w>>>(i*4))&1X;1c+=2d.1N(16)+1Y.1N(16)}f 1c};l 1a(1w){e 1c="";e i;e v;J(i=7;i>=0;i--){v=(1w>>>(i*4))&1X;1c+=v.1N(16)}f 1c};l 1K(q){q=q.2q(/\\r\\n/g,"\\n");e u="";J(e n=0;n<q.T;n++){e c=q.L(n);Y(c<X){u+=M.N(c)}1e Y((c>2k)&&(c<2r)){u+=M.N((c>>6)|2s);u+=M.N((c&1b)|X)}1e{u+=M.N((c>>12)|2t);u+=M.N(((c>>6)&1b)|X);u+=M.N((c&1b)|X)}}f u};e 1E;e i,j;e W=2o 1L(3B);e 1r=2i;e 1x=2j;e 1i=2f;e 1h=2g;e 1B=3F;e A,B,C,D,E;e K;w=1K(w);e O=w.T;e S=2o 1L();J(i=0;i<O-3;i+=4){j=w.L(i)<<24|w.L(i+1)<<16|w.L(i+2)<<8|w.L(i+3);S.1j(j)}3G(O%4){1Q 0:i=3T;1M;1Q 1:i=w.L(O-1)<<24|3r;1M;1Q 2:i=w.L(O-2)<<24|w.L(O-1)<<16|2F;1M;1Q 3:i=w.L(O-3)<<24|w.L(O-2)<<16|w.L(O-1)<<8|2n;1M}S.1j(i);2p((S.T%16)!=14)S.1j(0);S.1j(O>>>29);S.1j((O<<3)&R);J(1E=0;1E<S.T;1E+=16){J(i=0;i<16;i++)W[i]=S[1E+i];J(i=16;i<=2h;i++)W[i]=P(W[i-3]^W[i-8]^W[i-14]^W[i-16],1);A=1r;B=1x;C=1i;D=1h;E=1B;J(i=0;i<=19;i++){K=(P(A,5)+((B&C)|(~B&D))+E+W[i]+3c)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=20;i<=39;i++){K=(P(A,5)+(B^C^D)+E+W[i]+3s)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=3U;i<=2N;i++){K=(P(A,5)+((B&C)|(B&D)|(C&D))+E+W[i]+2V)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=2Y;i<=2h;i++){K=(P(A,5)+(B^C^D)+E+W[i]+2R)&R;E=D;D=C;C=P(B,30);B=A;A=K}1r=(1r+A)&R;1x=(1x+B)&R;1i=(1i+C)&R;1h=(1h+D)&R;1B=(1B+E)&R}e K=1a(1r)+1a(1x)+1a(1i)+1a(1h)+1a(1B);f K.2v()}l 33(q){l 1v(1z,2c){f(1z<<2c)|(1z>>>(32-2c))}l h(1W,1U){e 1V,1T,1d,1f,18;1d=(1W&2a);1f=(1U&2a);1V=(1W&1O);1T=(1U&1O);18=(1W&2u)+(1U&2u);Y(1V&1T){f(18^2a^1d^1f)}Y(1V|1T){Y(18&1O){f(18^3a^1d^1f)}1e{f(18^1O^1d^1f)}}1e{f(18^1d^1f)}}l F(x,y,z){f(x&y)|((~x)&z)}l G(x,y,z){f(x&z)|(y&(~z))}l H(x,y,z){f(x^y^z)}l I(x,y,z){f(y^(x|(~z)))}l o(a,b,c,d,x,s,U){a=h(a,h(h(F(b,c,d),x),U));f h(1v(a,s),b)};l t(a,b,c,d,x,s,U){a=h(a,h(h(G(b,c,d),x),U));f h(1v(a,s),b)};l m(a,b,c,d,x,s,U){a=h(a,h(h(H(b,c,d),x),U));f h(1v(a,s),b)};l p(a,b,c,d,x,s,U){a=h(a,h(h(I(b,c,d),x),U));f h(1v(a,s),b)};l 2e(q){e Z;e 1C=q.T;e 26=1C+8;e 2m=(26-(26%2l))/2l;e 1P=(2m+1)*16;e V=1L(1P-1);e 1y=0;e Q=0;2p(Q<1C){Z=(Q-(Q%4))/4;1y=(Q%4)*8;V[Z]=(V[Z]|(q.L(Q)<<1y));Q++}Z=(Q-(Q%4))/4;1y=(Q%4)*8;V[Z]=V[Z]|(2n<<1y);V[1P-2]=1C<<3;V[1P-1]=1C>>>29;f V};l 1q(1z){e 1S="",1R="",27,1t;J(1t=0;1t<=3;1t++){27=(1z>>>(1t*8))&3u;1R="0"+27.1N(16);1S=1S+1R.3w(1R.T-2,2)}f 1S};l 1K(q){q=q.2q(/\\r\\n/g,"\\n");e u="";J(e n=0;n<q.T;n++){e c=q.L(n);Y(c<X){u+=M.N(c)}1e Y((c>2k)&&(c<2r)){u+=M.N((c>>6)|2s);u+=M.N((c&1b)|X)}1e{u+=M.N((c>>12)|2t);u+=M.N(((c>>6)&1b)|X);u+=M.N((c&1b)|X)}}f u};e x=1L();e k,2b,1Z,25,28,a,b,c,d;e 1o=7,1m=12,1n=17,1p=22;e 1I=5,1J=9,1k=14,1u=20;e 1g=4,1A=11,1F=16,1D=23;e 1s=6,1l=10,1G=15,1H=21;q=1K(q);x=2e(q);a=2i;b=2j;c=2f;d=2g;J(k=0;k<x.T;k+=16){2b=a;1Z=b;25=c;28=d;a=o(a,b,c,d,x[k+0],1o,2B);d=o(d,a,b,c,x[k+1],1m,2C);c=o(c,d,a,b,x[k+2],1n,2E);b=o(b,c,d,a,x[k+3],1p,2G);a=o(a,b,c,d,x[k+4],1o,2H);d=o(d,a,b,c,x[k+5],1m,2I);c=o(c,d,a,b,x[k+6],1n,2K);b=o(b,c,d,a,x[k+7],1p,2L);a=o(a,b,c,d,x[k+8],1o,3j);d=o(d,a,b,c,x[k+9],1m,3k);c=o(c,d,a,b,x[k+10],1n,2O);b=o(b,c,d,a,x[k+11],1p,2P);a=o(a,b,c,d,x[k+12],1o,2U);d=o(d,a,b,c,x[k+13],1m,2T);c=o(c,d,a,b,x[k+14],1n,2W);b=o(b,c,d,a,x[k+15],1p,31);a=t(a,b,c,d,x[k+1],1I,34);d=t(d,a,b,c,x[k+6],1J,35);c=t(c,d,a,b,x[k+11],1k,36);b=t(b,c,d,a,x[k+0],1u,38);a=t(a,b,c,d,x[k+5],1I,3b);d=t(d,a,b,c,x[k+10],1J,3d);c=t(c,d,a,b,x[k+15],1k,3e);b=t(b,c,d,a,x[k+4],1u,3g);a=t(a,b,c,d,x[k+9],1I,3i);d=t(d,a,b,c,x[k+14],1J,3l);c=t(c,d,a,b,x[k+3],1k,3m);b=t(b,c,d,a,x[k+8],1u,3n);a=t(a,b,c,d,x[k+13],1I,3o);d=t(d,a,b,c,x[k+2],1J,3q);c=t(c,d,a,b,x[k+7],1k,3t);b=t(b,c,d,a,x[k+12],1u,3x);a=m(a,b,c,d,x[k+5],1g,3y);d=m(d,a,b,c,x[k+8],1A,3z);c=m(c,d,a,b,x[k+11],1F,3C);b=m(b,c,d,a,x[k+14],1D,3E);a=m(a,b,c,d,x[k+1],1g,3H);d=m(d,a,b,c,x[k+4],1A,3I);c=m(c,d,a,b,x[k+7],1F,3K);b=m(b,c,d,a,x[k+10],1D,3L);a=m(a,b,c,d,x[k+13],1g,3M);d=m(d,a,b,c,x[k+0],1A,3N);c=m(c,d,a,b,x[k+3],1F,3P);b=m(b,c,d,a,x[k+6],1D,3S);a=m(a,b,c,d,x[k+9],1g,2x);d=m(d,a,b,c,x[k+12],1A,2A);c=m(c,d,a,b,x[k+15],1F,2D);b=m(b,c,d,a,x[k+2],1D,2M);a=p(a,b,c,d,x[k+0],1s,2Q);d=p(d,a,b,c,x[k+7],1l,2S);c=p(c,d,a,b,x[k+14],1G,2Z);b=p(b,c,d,a,x[k+5],1H,37);a=p(a,b,c,d,x[k+12],1s,3f);d=p(d,a,b,c,x[k+3],1l,3D);c=p(c,d,a,b,x[k+10],1G,3p);b=p(b,c,d,a,x[k+1],1H,3v);a=p(a,b,c,d,x[k+8],1s,3A);d=p(d,a,b,c,x[k+15],1l,3J);c=p(c,d,a,b,x[k+6],1G,3O);b=p(b,c,d,a,x[k+13],1H,2y);a=p(a,b,c,d,x[k+4],1s,2J);d=p(d,a,b,c,x[k+11],1l,2X);c=p(c,d,a,b,x[k+2],1G,3h);b=p(b,c,d,a,x[k+9],1H,3R);a=h(a,2b);b=h(b,1Z);c=h(c,25);d=h(d,28)}e K=1q(a)+1q(b)+1q(c)+1q(d);f K.2v()}',62,243,'||||||||||||||var|return||AddUnsigned||||function|HH||FF|II|string|||GG|utftext||msg|||||||||||||for|temp|charCodeAt|String|fromCharCode|msg_len|rotate_left|lByteCount|0x0ffffffff|word_array|length|ac|lWordArray||128|if|lWordCount|||||||||lResult||cvt_hex|63|str|lX8|else|lY8|S31|H3|H2|push|S23|S42|S12|S13|S11|S14|WordToHex|H0|S41|lCount|S24|RotateLeft|val|H1|lBytePosition|lValue|S32|H4|lMessageLength|S34|blockstart|S33|S43|S44|S21|S22|Utf8Encode|Array|break|toString|0x40000000|lNumberOfWords|case|WordToHexValue_temp|WordToHexValue|lY4|lY|lX4|lX|0x0f|vl|BB||||||CC|lNumberOfWords_temp1|lByte|DD||0x80000000|AA|iShiftBits|vh|ConvertToWordArray|0x98BADCFE|0x10325476|79|0x67452301|0xEFCDAB89|127|64|lNumberOfWords_temp2|0x80|new|while|replace|2048|192|224|0x3FFFFFFF|toLowerCase|t4|0xD9D4D039|0x4E0811A1|lsb_hex|0xE6DB99E5|0xD76AA478|0xE8C7B756|0x1FA27CF8|0x242070DB|0x08000|0xC1BDCEEE|0xF57C0FAF|0x4787C62A|0xF7537E82|0xA8304613|0xFD469501|0xC4AC5665|59|0xFFFF5BB1|0x895CD7BE|0xF4292244|0xCA62C1D6|0x432AFF97|0xFD987193|0x6B901122|0x8F1BBCDC|0xA679438E|0xBD3AF235|60|0xAB9423A7||0x49B40821||MD5|0xF61E2562|0xC040B340|0x265E5A51|0xFC93A039|0xE9B6C7AA||0xC0000000|0xD62F105D|0x5A827999|0x2441453|0xD8A1E681|0x655B59C3|0xE7D3FBC8|0x2AD7D2BB|0x21E1CDE6|0x698098D8|0x8B44F7AF|0xC33707D6|0xF4D50D87|0x455A14ED|0xA9E3E905|0xFFEFF47D|0xFCEFA3F8|0x0800000|0x6ED9EBA1|0x676F02D9|255|0x85845DD1|substr|0x8D2A4C8A|0xFFFA3942|0x8771F681|0x6FA87E4F|80|0x6D9D6122|0x8F0CCC92|0xFDE5380C|0xC3D2E1F0|switch|0xA4BEEA44|0x4BDECFA9|0xFE2CE6E0|0xF6BB4B60|0xBEBFBC70|0x289B7EC6|0xEAA127FA|0xA3014314|0xD4EF3085|SHA1|0xEB86D391|0x4881D05|0x080000000|40'.split('|'),0,{}));
}
	


// Ajout du Menu Options
if (document.getElementById('playerName')){
	//var icone = 'data:image/gif;base64,R0lGODlhJgAdAMZ8AAAAABwgJTU4OhwhJRYaHjQ3OQcICjM2OA8SFQoMDxsgJB0hJjI1Nw8TFQcICAQEBDE0NgwPEAECAiYoKREVGB8lKi4yNCMlJgoNDzAzNiMnKzE0NxATFgsNECwuMAEBASotMB4iJyImKg8SFg4PDw8QESEjJQICAiAkKRgZGhsdHhUWFwoLCwoMDjI2OBcbHxsgIw0PEhsfIx8jJywvMh8hIhobHB8kKQkMDQYICQoNECwwMxcZGQsOER0iJygrLxweHysuMSUoLAkLDiQnKwwPESElKTM2NyAiIwcKCyAjJxoeISIlKiIkJRIWGRQWFiosLSUnKDAzNBscHRoeIgMEBDAyNA4ODyAkKAcICQkKCwwQEiMnKhwgJBIVGRAQEScqLiosLgcJCgcJCzQ2OAQEBQgICAkJCiksMCQmJwYHCSAjKC0vMQYGBh4jJyUpLSksLRAUFygsLzM2OSsuLyotMQwNDTAzNS4xMiwvMAkJDAkLDf///////////////yH5BAEAAH8ALAAAAAAmAB0AAAf+gH+CFQOFhoeIiRWCjI2ON4cBkpKIlIgVMI6af4SFk5+gk5UwBJuNBIahqqs+paaCBKuyoG4BA66vBFSgAr2+k74CnwoBuKaxkz7AvZ9rAcyTCgrGm8iq0Mug0tSa1qG/ktiTXbevsDKfC5/YwqvcjgTosszt7uZ/BN7f4Kov741i8gkcKLAXwYNZ7gFYyLAhQ18OIyqM6DCYAIoMJ2JceBFAr40ANGLs6PEjRpERTXJUyVBCSHMbWa48CZOizJUkG6IsGaxhT4k1I7oESXHnwqFEHd7LAUBN0qT3huDYI3VMEgNYs27EmkOLnnt/tsQoUqRHh7MY0iZY24KtDh0gAHpEmAtWkBMvceJw2NsAQV+/IwALpkChruHDiBPXDQQAOw==';
			
	var aff_option ='<li><span class="menu_icon"><a href="http://board.ogsteam.fr" target="blank_" ><img id="xtense.icone" class="mouseSwitch" src="'+urlIcone+'" height="29" width="38"></span><a class="menubutton " href="'+url+'&xtense=Options" accesskey="" target="_self">';
		aff_option += '<span class="textlabel">Xtense</span></a></li>';
				
				
	var sp1 = document.createElement("span");
	sp1.setAttribute("id", "optionIFC");
	var sp1_content = document.createTextNode('');
	sp1.appendChild(sp1_content);				
	
	var sp2 = document.getElementById('menuTable').getElementsByTagName('li')[Math.min(10,document.getElementById('menuTable').getElementsByTagName('li').length-1)];
			
	parentDiv = sp2.parentNode;
	parentDiv.insertBefore(sp1, sp2.nextSibling);
	var tableau = document.createElement("span");
	tableau.innerHTML = aff_option;
	document.getElementById('optionIFC').insertBefore(tableau, document.getElementById('optionIFC').firstChild);
}

// Page des Options Xtense
if((new RegExp(/xtense=Options/)).test(url)){		
	if(url.indexOf('xtense=Options',0) >= 0){
		if(isChrome){				
			var options = '<div id="Xtense_Div" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;"><br/><br/>';
			// Serveur Univers
			options+= '<img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png" alt="Options Xtense"/>';
			options+= '<br/><br/>';
			options+= '<table style="width:675px;">' +
					  '<colgroup><col width="25%"/><col width="25%"/><col width="25%"/><col width="25%"/></colgroup>' +
					  '<tbody>' +
					  '<tr>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_serveurs\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/server.png"/><span id="menu_servers" style="font-size: 20px; color: white;"><b>&#160;Serveur</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_pages\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/pages.png"/><span id="menu_pages" style="font-size: 20px; color: orange;"><b>&#160;Pages</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_options\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/conf.png"/><span id="menu_options" style="font-size: 20px; color: orange;"><b>&#160;Options</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_about\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/about.png"/><span id="menu_about" style="font-size: 20px; color: orange;"><b>&#160;A propos</b></span></a></td>' +
					  '</tr>' +
					  '</tbody>' +
					  '</table>';
			options+= '<div id="Xtense_serveurs">';		
			options += '<table id="Xtense_table_serveurs" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">URL OGSpy</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Utilisateur</label></td>';
			options+= '<td class="value"><input class="speed" id="server.user" value="'+GM_getValue('server.user','utilisateur')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Mot de passe</label></td>';
			options+= '<td class="value"><input class="speed" id="server.pwd" value="'+GM_getValue('server.pwd','mot de passe')+'" size="35" alt="24" type="password"/></td>';
			options+= '</tr>';
			options+= '</tbody></table>';
			options+= '</div>';			
			// Pages
			options+= '<div id="Xtense_pages">';
			options += '<table id="Xtense_table_pages" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Systemes solaires</label></td>';
			//alert("GM_getValue('handle.system','false'))="+(GM_getValue('handle.system','false')=='true')+"\n"+((GM_getValue('handle.system','false')=='true')?'checked="true" ':'checked="false" '));
			options+= '<td class="value"><input class="speed" id="handle.system" checked="false" size="35" alt="24" type="checkbox"/></td>';
			options+= '</tr>';
			options+= '</tbody></table>';
			options+= '</div>';
			// Options
			options+= '<div id="Xtense_options">';
			options += '<table id="Xtense_table_options" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			/*options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Options</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';*/
			options+= '</tbody></table>';
			options+= '</div>';
			// A propos
			options+= '<div id="Xtense_about">';
			options += '<table id="Xtense_table_about" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			/*options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">A propos</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';*/
			options+= '</tbody></table>';
			options+= '</div>';
			options+= '<br/><br/></div>'; //fin Tableau
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			
			var script = document.createElement('script');
			script.setAttribute('type','text/javascript');
			script.setAttribute('src',"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/scripts/prefs.js");
			escriptopt.appendChild(script);
			
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
						
			document.getElementById("Xtense_serveurs").style.display="block";
			document.getElementById("Xtense_pages").style.display="none";
			document.getElementById("Xtense_options").style.display="none";
			document.getElementById("Xtense_about").style.display="none";
			
			var checkboxOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[@type='checkbox']");
			//log("checkboxOptions.snapshotLength="+checkboxOptions.snapshotLength);
			if(checkboxOptions.snapshotLength > 0){
			   	for(var j=0;j<checkboxOptions.snapshotLength;j++){
			   		var checkbox = checkboxOptions.snapshotItem(j);
			   		//checkbox.checked=Boolean(GM_getValue(checkbox.id,"false"));
			   		checkbox.checked=GM_getValue(checkbox.id,false)=='true'?true:false;
			   		//alert("checkbox:"+checkbox.id+"="+checkbox.checked+"\n\nGM_getValue()="+GM_getValue(checkbox.id,false));
			   	}
			}

			function enregistreOptionsXtense(){				
				// Sauvegarde des inputs
				var inputOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[not(@type='checkbox')]");
				//log("inputOptions.snapshotLength="+inputOptions.snapshotLength);
				if(inputOptions.snapshotLength > 0){					
				   	for(var i=0;i<inputOptions.snapshotLength;i++){
				   		var input = inputOptions.snapshotItem(i);
				   		GM_setValue( input.id , input.value);
				   	}
				}
				// Sauvegarde des checkbox
				var checkboxOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[@type='checkbox']");
				//log("checkboxOptions.snapshotLength="+checkboxOptions.snapshotLength);
				if(checkboxOptions.snapshotLength > 0){
				   	for(var j=0;j<checkboxOptions.snapshotLength;j++){
				   		var checkbox = checkboxOptions.snapshotItem(j);
				   		GM_setValue(checkbox.id , checkbox.checked);
				   	}
				}	
			}
			setInterval(enregistreOptionsXtense, 500);
		// Firefox ?
		} else if(isFirefox){
			var options = "<div>" +
			"<br/><br/><br/><br/>" +
			"<div style=\"color: orange; background-color: black; text-align: center; font-size: 16px; opacity : 0.7;\">" +
			"<img src=\"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/OGSteam.gif\" alt\"OGSteam\"/>" +
			"<br/>" +
			"<img src=\"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png\" alt\"Xtense\"/>" +			
			"<br/><br/>" +
			"Une extension Firefox de ce script existe." +
			"<br/><br/>" +
			"Veuillez la télécharger afin de profiter pleinement de cet outil." +
			"<br/><br/><br/>" +
			"Ce module complémentaire est disponible à l'<a href=\"http://update.ogsteam.fr/xtense/download.php\" target=\"_blank\">adresse suivante.</a>" +
			"<br/><br/>" +
			"Pour tout renseignement complémentaire, " +
			"<br/>" +
			"vous pouvez vous rendre sur le forum de l'OGSteam." +
			"<br/>" +
			"<a href=\"http://board.ogsteam.fr/index.php\" target=\"_blank\">http://board.ogsteam.fr/index.php</a>" +
			"<br/><br/>" +
			"</div></div>";
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
		} else {
			var options = "<div><h1>Ce script n'est pas compatible avec ce navigateur internet.</h1></div>";
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
		}
	}
}

/* Page Autre que Galaxie */
var regGalaxy = new RegExp(/(galaxy)/);
if(!regGalaxy.test(url)){
	GM_setValue('lastAction','');
}
/* Page Galaxie */
if(regGalaxy.test(url)){
	if(Boolean(GM_getValue("handle.system"))){
		var target = document.getElementById('galaxyContent');
		target.removeEventListener("DOMNodeInserted");
		target.removeEventListener("DOMSubtreeModified");
		//target.addEventListener("DOMNodeInserted", parseSystem_Inserted, false);
		target.addEventListener("DOMSubtreeModified", parseSystem_Inserted, false);
	}
}

/* Page Overview */
var regOverview = new RegExp(/(overview)/);
if(regOverview.test(url)){	
	var planetData = getPlanetData();
	
	var cases = Xpath.getStringValue(document,XtenseXpaths.overview.cases);
	var temperatures = Xpath.getStringValue(document,XtenseXpaths.overview.temperatures);
	var temperature_max = temperatures.match(/\d+[^\d-]*(-?\d+)[^\d]/)[1];
	var temperature_min = temperatures.match(/(-?\d+)/)[1]; //TODO trouver l'expression reguliere pour la temperature min
	
	var resources = getResources();
	
	XtenseRequest.set(
		{
			type: 'overview',
			fields: cases,
			temperature_min: temperature_min,
			temperature_max: temperature_max,
			ressources: resources
		},
		planetData
	);
		
	XtenseRequest.set('lang',langUnivers);
	XtenseRequest.send();
}

//************************
//** PARSINGS DES PAGES **
//************************
if(isChrome){
	function parseSystem_Inserted(event){
		var doc = event.target.ownerDocument;
		var paths = XtenseXpaths.galaxy;
		var galaxy = Xpath.getSingleNode(document,"//input[@id='galaxy_input']").value;
		var system = Xpath.getSingleNode(document,"//input[@id='system_input']").value;
		
		if (GM_getValue('lastAction','') != 's:'+galaxy+':'+system){
			var coords = [galaxy, system];
			if (isNaN(coords[0]) || isNaN(coords[1])) {
				log('invalid system'+' '+coords[0]+' '+coords[1]);
				return;
			}
			log(Xl('system detected',galaxy,system));
			setStatus(XLOG_NORMAL,Xl('system detected',galaxy,system));
		
			var rows = Xpath.getUnorderedSnapshotNodes(doc,paths.rows);
			//log(paths.rows+' '+rows.snapshotLength);
			if(rows.snapshotLength > 0) {
				//var XtenseRequest = new XtenseRequest(null, null, null);
				//log(rows.snapshotLength+' rows found');
				var rowsData = [];
				for (var i = 0; i < rows.snapshotLength ; i++) {
					var row = rows.snapshotItem(i);
					var name = Xpath.getStringValue(doc,paths.planetname,row).trim().replace(/\($/,'');
					var name_l = Xpath.getStringValue(doc,paths.planetname_l,row).trim().replace(/\($/,'');
					var player = Xpath.getStringValue(doc,paths.playername,row).trim();
					
					if (player == '') {
						log('row '+i+' has no player name');
						continue;
					}
					if (name == '') {
						if (name_l == '') {
							log('row '+i+' has no planet name');
							continue;
						} else
							name = name_l;
					}
					var position = Xpath.getNumberValue(doc,paths.position,row);
					if(isNaN(position)) {
						log('position '+position+' is not a number');
						continue;
					}

					var moon = Xpath.getUnorderedSnapshotNodes(doc,paths.moon,row);
					moon = moon.snapshotLength > 0 ? 1 : 0;
					var status = Xpath.getUnorderedSnapshotNodes(doc,paths.status,row);
					if(status.snapshotLength>0){
						status = status.snapshotItem(0);
						status = status.textContent;
						status = status.match(/\((.*)\)/);
						status = status ? status[1] : "";
						status = status.trimAll();
					}
					else status = "";
					var activity = Xpath.getStringValue(doc,paths.activity,row).trim();
					activity = activity.match(/: (.*)/);
					if(activity)
						activity = activity[1];
					else activity = '';
					var allytag = Xpath.getStringValue(doc,paths.allytag,row).trim();
					var debris = [];
					for(var j = 0; j < 2; j++) {
						debris[XtenseDatabase['resources'][601+j]] = 0;
					}
					var debrisCells = Xpath.getUnorderedSnapshotNodes(doc,paths.debris,row);
					for (var j = 0; j < debrisCells.snapshotLength ; j++) {
						debris[XtenseDatabase['resources'][601+j]] = debrisCells.snapshotItem(j).innerHTML.trimInt();
					}
					
					var player_id = Xpath.getStringValue(doc,paths.player_id,row).trim();
					if (player_id != '' ) {
						player_id = player_id.match(/\&to\=(.*)\&ajax/);
						player_id = player_id[1];
					}
					else if(doc.cookie.match(/login_(.*)=U_/))
						player_id = doc.cookie.match(/login_(.*)=U_/)[1]; 
					
					var ally_id = Xpath.getStringValue(doc,paths.ally_id,row).trim();
					if (ally_id != '' ) {
						ally_id = ally_id.match(/allyid\=(.*)/);
						ally_id = ally_id[1];
					}
					else if (allytag)
						ally_id = '-1';
					
					var r = {player_id:player_id,planet_name:name,moon:moon,player_name:player,status:status,ally_id:ally_id,ally_tag:allytag,debris:debris,activity:activity};
					rowsData[position]=r;
				}
				XtenseRequest.set(
					{
						row : rowsData,
						galaxy : coords[0],
						system : coords[1],
						type : 'system'
					}
				);

				XtenseRequest.set('lang',langUnivers);
				//Xdump(XtenseRequest.data);
				XtenseRequest.send();
				GM_setValue('lastAction','s:'+coords[0]+':'+coords[1]);
			}
		}/* else {
			log("Système déjà traité !");
		}*/
	}
}

if(isChrome){
	// converti un nombre de la forme xxx.xxx.xxx en xxxxxxxxx
	function parseNB(monText){
	  return (monText.replace(/\./g,""));  
	}
	
	/* Recuperation de données */
	function getPlanetData() {
		var planet_type = "";
		if(XtenseMetas.getPlanetType() == 'moon'){
			planet_type = '1';
		} else {
			planet_type = '0';
		}
		log("planet_name: "+XtenseMetas.getPlanetName()+", coords : "+XtenseMetas.getPlanetCoords()+", planet_type : "+planet_type);
		return {planet_name: XtenseMetas.getPlanetName(), coords : XtenseMetas.getPlanetCoords(), planet_type : planet_type};
	}
	function getResources(){		
		var metal = Xpath.getStringValue(document,XtenseXpaths.ressources.metal).trimInt();
	    var cristal = Xpath.getStringValue(document,XtenseXpaths.ressources.cristal).trimInt();
	    var deut = Xpath.getStringValue(document,XtenseXpaths.ressources.deuterium).trimInt();
		var antimater = Xpath.getStringValue(document,XtenseXpaths.ressources.antimatiere).trimInt();
	    var energy = Xpath.getStringValue(document,XtenseXpaths.ressources.energie).trimInt();
		log("metal="+metal+", cristal="+cristal+", deuterium="+deut+", antimatiere="+antimater+", energie="+energy);
		return Array(metal,cristal,deut,antimater,energy);
	}
}
