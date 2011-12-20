/**
 * @author Unibozu
 * @license GNU/GPL
 */

var XnewOgame = {
	//on declare les varibles generales
	locales: {},
	doc : null,
	url : null,
	Tab : null,
	universe : null,
	lang: null,
	sandbox: null,	
	callback : [],
	params : [],
	messagesCache: {},
	lastAction: null,
		
	l: function(name) {
		if (!this.locales[this.lang][name]) {
			throw new Error('Unknow locale "'+name+'" for lang'+this.lang);
		}
		
		var locale = this.locales[this.lang][name];
		for (var i = 1, len = arguments.length; i < len; i++) {
			locale = locale.replace('$'+i, arguments[i]);
		}
		
		return locale;
	},

	newRequest: function() {
		return new Request(this.Tab, this.handleResponse, this);
	},

	manual_send : function () {
		$('xtense-send').setAttribute('disabled', 'true');
		this.callback[0].apply(this, this.callback[1]);
	},
	
	parseIntWithMultiplier : function(str) {
		var st = str;
		var m = st.match(/\d+.?\d*[kmg]?/i);
		if(m) {
			st = m[0].toLowerCase();
			var num = parseFloat(st.replace(/[kmg]/,''));
			switch(st[st.length-1]) {
				case 'k':
						num = num*1000;
						break;
				case 'm':
						num = num*1000000;
						break;
				case 'g':
						num = num*1000000000;
						break;
				default:break;
			}
			return Math.round(num);
		} else return 0;
	},
	
	onPageLoad: function(doc, url, Tab,window) {
		try {
			this.doc = doc;
			this.url = url;
			this.Tab = Tab;
            this.win = window;

			if (!(this.universe = this.getUniverse(url))) return false;
			
			if (!Xservers.check(this.universe)) {
				Tab.setStatus(Xl('no server'), XLOG_NORMAL, {url: url});
				return true;
			} else this.servers = Xservers.list;
			
			this.lang = this.getLang(this.universe);

			if (!this.locales[this.lang]) {
				Tab.setStatus(Xl('unavailable parser lang', this.lang), XLOG_ERROR, {url: url});
				return true;
			}
			
			var page = this.getPage(url);
			Xconsole("page:"+page);
			if (page == 'rc') 
				Xtoolbar.show();
		} catch(e) {
			throw_error(e);
		}
		
		try {
			// Ne pas mettre d'erreur pour la page de login
			if (!Xtense.active || !page) 
				return false;
			
			if (Xprefs.isset('handle-'+page) && !Xprefs.getBool('handle-'+page)) {
				Tab.setSendAction(this.manualSend, this, [page, url, doc, Tab, this.lang, this.universe,this.params,window,this.servers]);
				Tab.setStatus(Xl('wait send'), XLOG_NORMAL, {url: url});
				return true;
			}
			if(this.win.resourceTickerMetal || page == 'messages' || page == 'rc')
				this.sendPage(page);
			return true;
		} catch (e) {
			Xtense.CurrentTab.setStatus(Xl('parsing error'), XLOG_ERROR, {url: url, page: page});
			if (Xprefs.getBool('debug'))
				show_backtrace(e);
		}
	},
	
	manualSend: function (type, page, url, doc, Tab, lang, universe,params,window,servers) {
		// Oblige de restaurer le contexte
		this.page = page;
		this.doc = doc;
		this.Tab = Tab;
		this.universe = universe;
		this.params = params;
		this.win = window;
		this.lang = lang;
		this.servers = servers;
		
		try {
			if (type == 'command') this.sendPage(page);
		} catch (e) {
			Xtense.CurrentTab.setStatus(Xl('parsing error'), XLOG_ERROR, {url: url, page: page});
			if (Xprefs.getBool('debug'))
				show_backtrace(e);
		}
	},
	
	sendPage: function (page) {
		var Request = null;
		
		if (page == 'overview') 		Request = this.parseOverview();
		else if (page == 'buildings') 	Request = this.parseBuildings();
		else if (page == 'station') 	Request = this.parseStation();
		else if (page == 'researchs') 	Request = this.parseResearchs();
		else if (page == 'defense') 	Request = this.parseDefense();
		else if (page == 'fleet') 		Request = this.parseShipyard();
		else if (page == 'system') 		Request = this.parseSystem();
		else if (page == 'ranking')		Request = this.parseRanking();
		else if (page == 'ally_list') 	Request = this.parseAlly_list();
		else if (page == 'rc') 			Request = this.parseRc();
		else if (page == 'messages') 	Request = this.parseMessage();
		else if (page == 'trader') 		Request = this.parseTrader();
		else this.Tab.setStatus('invalid page type: "'+page+'"', XLOG_ERROR, {url: this.url});
		
		if (Request) {
			Request.set('lang',this.lang);
		    Xdump(Request.data);
		    Request.send(this.servers);
		}
	},

	getUniverse: function (url) {
		var universe = url.match(/^http:\/\/[a-z0-9]{4,10}\.ogame\.[a-z]{2,4}/gi);
		if(universe && !url.match(/^http:\/\/board\.ogame\.[a-z]{2,4}/gi))
			return universe[0];
		else if (url.match(/^http:\/\/localhost\/ogame\//gi))
			return "http://uni101.ogame.fr";
		else 
			return false;
	},
	
	getLang: function (url) {
		var tab = url.split('.');
		switch(tab[tab.length-1])
		{
			case 'fr': return 'fr';
			case 'us': return 'en';
			case 'org': return 'en';//TODO add other languages
			case 'de': return 'de';
			default: return tab[tab.length-1];
		}
	},

	setParams: function (url){
		this.params = [];
		if(url.indexOf('?')>=0) {
			url = url.split('?')[1];
			url = url.split('#')[0];
			url = url.split('&');
			for(var i=0;i<url.length;i++) {
				this.params[url[i].split('=')[0]]=url[i].split('=')[1];
			}
		}
	},
	
	getPage: function(url) {
		try {
			this.setParams(url);
			// Nettoyage de la chaine, on ne prend que ce qu'il y a apras index.php?page(>>)
			if((url.indexOf('page=')<0 || typeof this.params['page']=='undefined') && url.match(/\/$/)) //si pas de parametre, on n'est pas sur le jeu
				return false;
			switch(this.params['page']) {
				case 'overview':	return 'overview';
				case 'resources':	return 'buildings';
				case 'station':		return 'station';
				case 'research':	return 'researchs';
				case 'galaxy':		return 'system';
				case 'highscore':	return 'ranking';
				case 'defense':		return 'defense';
				case 'shipyard':	return 'fleet';
				case 'fleet1':	return 'fleet';
				case 'alliance':	return 'ally_list';
				case 'showmessage':	return 'messages';
				case 'combatreport': return 'rc';
				//case 'trader': 		return 'trader';
				default: 			return false;
			}
		} catch (e) {
			throw_error(e);
		}
	},

	handleResponse: function (Request, Server, Response) {
		Xdump(Response.content);
		if (Server.cached()) var message_start = '"'+Server.name+'" : ';
		else var message_start = Xl('response start', Server.n+1);
		
		var extra = {Request: Request, Server: Server, Response: Response, page: Request.data.type};
		
		if (Response.status != 200) {
			if (Response.status == 404) 		Request.Tab.setStatus(message_start + Xl('http status 404'), XLOG_ERROR, extra);
			else if (Response.status == 403) 	Request.Tab.setStatus(message_start + Xl('http status 404'), XLOG_ERROR, extra);
			else if (Response.status == 500) 	Request.Tab.setStatus(message_start + Xl('http status 404'), XLOG_ERROR, extra);
			else if (Response.status == 0)		Request.Tab.setStatus(message_start + Xl('http timeout'), XLOG_ERROR, extra);
			else 								Request.Tab.setStatus(message_start + Xl('http status unknow',Response.status), XLOG_ERROR, extra);
		} else {
			var type = XLOG_SUCCESS;
			
			if (Response.content == '') {
				Request.Tab.setStatus(message_start + Xl('empty response'), XLOG_ERROR, extra);
				return;
			}
			
			if (Response.content == 'hack') {
				Request.Tab.setStatus(message_start + Xl('response hack'), XLOG_ERROR, extra);
				return;
			}
			
			var data = {};
			if (Response.content.match(/^\(\{.*\}\)$/g)) data = eval(Response.content);
			else {
				var match = null;
				if ((match = Response.content.match(/\(\{.*\}\)/))) {
					data = eval(match[0]);
					// Message d'avertissement
					type = XLOG_WARNING;
					Xconsole("full response:"+escape(Response.content));
				} else {
					// Message d'erreur
					Request.Tab.setStatus(message_start + Xl('invalid response'), XLOG_ERROR, extra);
					if (Xprefs.getBool('debug')) {
						throw_plugin_error(Response, Server);
					}
					return;
				}
			}
			
			var message = '';
			var code = data.type;
			
			if (data.status == 0) {
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
			} else {
				if (code == 'home updated') 			message = Xl('success home updated', Xl('page '+data.page));
				else if (code == 'system')				message = Xl('success system', data.galaxy, data.system);
				else if (code == 'ranking') 			message = Xl('success ranking', Xl('ranking '+data.type1), Xl('ranking '+data.type2), data.offset, data.offset+99);
				else if (code == 'rc')					message = Xl('success rc');
				else if (code == 'ally_list')			message = Xl('success ally_list', data.tag);
				else if (code == 'messages')			message = Xl('success messages');
				else if (code == 'spy') 				message = Xl('success spy');
				else if (code == 'fleetSending')		message = Xl('success fleetSending');
				else 									message = Xl('unknow response', code, Response.content);
			}
			
			if (Xprefs.getBool('display-execution-time') && data.execution) message = '['+data.execution+' ms] '+ message_start + message;
			if (Xprefs.getBool('display-new-messages') && typeof data.new_messages!='undefined') Request.Tab.setNewPMStatus (data.new_messages, Server);
			
			if (data.calls) {
				// Merge the both objects
				var calls = extra.calls = data.calls;
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
			
			Request.Tab.setStatus(message, type, extra);
		}
	},

	getPlanetData : function () {
		var paths = this.Xpaths.planetData;

		if(this.win.resourceTickerMetal.production == '0' && this.win.resourceTickerCrystal.production == '0') { //si le coeficient de ressour est a 0 c'est une lune
			this.planet_type = '1';
		} else this.planet_type = '0';
		
		var name = Xpath.getStringValue(this.doc, paths.name);
		var coords = null;
		var coords_list = Xpath.getStringValue(this.doc, paths.coords); //Si plusieurs planètes
		if (!coords_list) {
			Xconsole("plan&egrave;te unique");
			coords_list = Xpath.getStringValue(this.doc, paths.coords_unique_planet); //Si 1 seule planète
		}
		coords = coords_list.match(new RegExp(this.regexps.planetCoords))[1]; //On récupère les coordonnées
		
		return {planet_name: name, coords : coords, planet_type : this.planet_type};
	},
	
	getResources : function () {
		var res = this.doc.getElementById("resources");
		var metal = res.getElementsByClassName("metal")[0].getAttribute('title').getInts()[0];
	    var cristal = res.getElementsByClassName("crystal")[0].getAttribute('title').getInts()[0];
	    var deut = res.getElementsByClassName("deuterium")[0].getAttribute('title').getInts()[0];
		var antimater = res.getElementsByClassName("darkmatter")[0].getAttribute('title').getInts()[0];
	    var energy = res.getElementsByClassName("energy")[0].getAttribute('title').getInts()[2];
		
		return Array(metal,cristal,deut,antimater,energy);
	},
	
	parseOverview : function () {
		//this.Tab.setStatus(Xl('overview detected'), XLOG_NORMAL, {url: this.url});
		var cases = this.win.textContent[1].getInts()[2];
		var temperature_max = this.win.textContent[3].match(/\d+[^\d-]*(-?\d+)[^\d]/)[1];
		var temperature_min = this.win.textContent[3].match(/(-?\d+)/)[1]; //TODO trouver l'expression reguliere pour la temperature min

		var planetData = this.getPlanetData();
		
		var Request = this.newRequest();
		Request.set(
			{
				type: 'overview',
				fields: cases,
				temperature_min: temperature_min,
				temperature_max: temperature_max,
				ressources: this.getResources()
			},
			planetData
		);
		
		return Request;
	},

    parseStation : function () {		
		var paths = XnewOgame.Xpaths.levels;
		//this.Tab.setStatus(Xl('installations detected'), XLOG_NORMAL, {url: this.url});
		var Request = this.newRequest();
		Request.set('type', 'buildings');
		
		var levels = Xpath.getOrderedSnapshotNodes(this.doc,paths.level,null);
		var tabLevel = new Array();
		if(levels.snapshotLength > 0){
		   	for(var lvl=0;lvl<levels.snapshotLength;lvl++){
		   		var level = levels.snapshotItem(lvl).nodeValue.trim();
		   		if(level!=""){
		   			tabLevel.push(level);
		   		}
		   	}
		}

		Request.set(this.getPlanetData());
		if(this.planet_type == '0'){
			var send = {
				"UdR": tabLevel[0],
				"CSp": tabLevel[1],
				"Lab": tabLevel[2],
				"DdR": tabLevel[3],
				"Silo": tabLevel[4],
				"UdN": tabLevel[5],
				"Ter": tabLevel[6]
			};
		} else {
			var send = {
				"UdR": tabLevel[0],
				"CSp": tabLevel[1],
				"BaLu": tabLevel[2],
				"Pha": tabLevel[3],
				"PoSa": tabLevel[4]
			};
		}
		Request.set(send);
		
		return Request;
	},
	
	parseResearchs : function () {
		var paths = XnewOgame.Xpaths.levels;		
		//this.Tab.setStatus(Xl('researchs detected'), XLOG_NORMAL, {url: this.url});
		var Request = this.newRequest();
		Request.set('type', 'researchs');
		var levels = Xpath.getOrderedSnapshotNodes(this.doc,paths.level,null);
		var tabLevel = new Array();
		
		if(levels.snapshotLength > 0){
		   	for(var lvl=0;lvl<levels.snapshotLength;lvl++){
		   		var level = levels.snapshotItem(lvl).nodeValue.trim();
		   		if(level!=""){
		   			tabLevel.push(level);
		   		}
		   	}
		}
		
		Request.set(this.getPlanetData());
		Request.set(
			{
				"NRJ": tabLevel[0],
				"Laser": tabLevel[1],
				"Ions": tabLevel[2],
				"Hyp": tabLevel[3],
				"Plasma": tabLevel[4],
				"RC": tabLevel[5],
				"RI": tabLevel[6],
				"PH": tabLevel[7],
				"Esp": tabLevel[8], 
				"Ordi": tabLevel[9],
				"Astrophysique": tabLevel[10],
				"RRI": tabLevel[11],
				"Graviton": tabLevel[12],
				"Armes": tabLevel[13],
				"Bouclier": tabLevel[14],
				"Protection": tabLevel[15]
			}
		);
		
		return Request;
	},

	parseBuildings : function () {
		var paths = XnewOgame.Xpaths.levels;
		//this.Tab.setStatus(Xl('buildings detected'), XLOG_NORMAL, {url: this.url});
		var Request = this.newRequest();
		Request.set('type', 'buildings');
		var levels = Xpath.getOrderedSnapshotNodes(this.doc,paths.level,null);
		var tabLevel = new Array();
		
		if(levels.snapshotLength > 0){
		   	for(var lvl=0;lvl<levels.snapshotLength;lvl++){
		   		var level = levels.snapshotItem(lvl).nodeValue.trim().replace(".", "");
				
		   		if(level!=""){
		   			tabLevel.push(level);
		   		}
		   	}
		}
		
		Request.set(this.getPlanetData());
		Request.set(
			{
				"M": tabLevel[0],
				"C": tabLevel[1],
				"D": tabLevel[2],
				"CES": tabLevel[3],
				"CEF": tabLevel[4],
				"SAT": tabLevel[5],
				"HM": tabLevel[6],
				"HC": tabLevel[7],
				"HD": tabLevel[8]
			}
		);
		
		return Request;
	},

	getDbFieldName : function(id) {
		for(var i in this.database) {
				if(typeof this.database[i][id] != 'undefined')
					return this.database[i][id];
			}
		return false;
	},
	
	parseTableStruct : function() {
		var reg = new RegExp(this.regexps.parseTableStruct,'g');
		var reg2 = new RegExp(this.regexps.parseTableStruct);
		var input = this.doc.body.innerHTML;
		var m = input.match(reg);
		var m2 = null;
		
		if(!m)
			return false;
		var Request = this.newRequest();
		for (var i = 0 ; i < m.length; i++ ) {
			m2 = m[i].match(reg2);
			var id = m2[1].trimInt();
			var fieldName = this.getDbFieldName(id);
			
			Request.set(fieldName, this.parseIntWithMultiplier(m2[2]));
			Xconsole(this.page+' '+m[i][1]+' '+m[i][2]+' '+this.database[this.page][parseInt(m[i][1])]);
		}
		
		Request.set(this.getPlanetData());
		
		return Request;
	},

	parseDefense : function () {		
		var paths = XnewOgame.Xpaths.levels;
		//this.Tab.setStatus(Xl('defense detected'), XLOG_NORMAL, {url: this.url});
		var Request = this.newRequest();
		Request.set('type', 'defense');
		var levels = Xpath.getOrderedSnapshotNodes(this.doc,paths.level,null);
		var tabLevel = new Array();
		
		if(levels.snapshotLength > 0){
		   	for(var lvl=0;lvl<levels.snapshotLength;lvl++){
		   		var level = levels.snapshotItem(lvl).nodeValue.trim().replace(".", "");
		   		if(level!=""){
		   			tabLevel.push(level);
		   		}
		   	}
		}
		
		Request.set(this.getPlanetData());
		Request.set(
			{
				"LM": tabLevel[0],
				"LLE": tabLevel[1],
				"LLO": tabLevel[2],
				"CG": tabLevel[3],
				"AI": tabLevel[4],
				"LP": tabLevel[5],
				"PB": tabLevel[6],
				"GB": tabLevel[7],
				"MIC": tabLevel[8],
				"MIP": tabLevel[9]
			}
		);
		
		return Request;
	},
	
	parseShipyard : function () {		
		var paths = XnewOgame.Xpaths.levels;
		//this.Tab.setStatus(Xl('fleet detected'), XLOG_NORMAL, {url: this.url});
		var Request = this.newRequest();
		Request.set('type', 'fleet');
		var levels = Xpath.getOrderedSnapshotNodes(this.doc,paths.level,null);
		var tabLevel = new Array();
		
		if(levels.snapshotLength > 0){
		   	for(var lvl=0;lvl<levels.snapshotLength;lvl++){
		   		var level = levels.snapshotItem(lvl).nodeValue.trim().replace(".", "");
		   		if(level!=""){
		   			tabLevel.push(level);
		   		}
		   	}
		}
		var req = "";
		if(tabLevel.length == 14){
			req={"CLE": tabLevel[0],
				"CLO": tabLevel[1],
				"CR": tabLevel[2],
				"VB": tabLevel[3],
				"TRA": tabLevel[4],
				"BMD": tabLevel[5],
				"DST": tabLevel[6],
				"EDLM": tabLevel[7],
				"PT": tabLevel[8],
				"GT": tabLevel[9],
				"VC": tabLevel[10],
				"REC": tabLevel[11],
				"SE": tabLevel[12], 
				"SAT": tabLevel[13]};
		} else {
			req={"CLE": tabLevel[0],
				"CLO": tabLevel[1],
				"CR": tabLevel[2],
				"VB": tabLevel[3],
				"TRA": tabLevel[4],
				"BMD": tabLevel[5],
				"DST": tabLevel[6],
				"EDLM": tabLevel[7],
				"PT": tabLevel[8],
				"GT": tabLevel[9],
				"VC": tabLevel[10],
				"REC": tabLevel[11],
				"SE": tabLevel[12]};
		}
		
		Request.set(this.getPlanetData());
		Request.set(req);
		
		return Request;
	},

	parseSystem : function() {
		var target = this.doc.getElementById('galaxyContent');
		target.win = this.win;
		target.addEventListener("DOMNodeInserted", this.parseSystem_Inserted, false);
	},
		
	parseSystem_Inserted : function (event) {
		var doc = event.target.ownerDocument;
		var win = doc.getElementById('galaxyContent').win;
		var paths = XnewOgame.Xpaths.galaxy;
		var galaxy = win.galaxy;
		var system = win.system;
		
		if (this.lastAction != 's:'+galaxy+':'+system){
			var coords = [galaxy, system];
			if (isNaN(coords[0]) || isNaN(coords[1])) {
				Xconsole(Xl('invalid system')+' '+coords[0]+' '+coords[1]);
				return;
			}
			//XnewOgame.Tab.setStatus(Xl('system detected', coords[0], coords[1]), XLOG_NORMAL, {url: this.url});
			Xconsole(Xl('system detected', coords[0], coords[1]));
			var rows = Xpath.getUnorderedSnapshotNodes(doc,paths.rows);
			Xconsole(paths.rows+' '+rows.snapshotLength);
			if(rows.snapshotLength > 0) {
				var Request = XnewOgame.newRequest();
				Xconsole(rows.snapshotLength+' rows found');
				var rowsData = [];
				for (var i = 0; i < rows.snapshotLength ; i++) {
					var row = rows.snapshotItem(i);
					var name = Xpath.getStringValue(doc,paths.planetname,row).trim().replace(/\($/,'');
					var name_l = Xpath.getStringValue(doc,paths.planetname_l,row).trim().replace(/\($/,'');
					var name_tooltip = Xpath.getStringValue(doc,paths.planetname_tooltip,row).trim().replace(/\($/,'');
					var player = Xpath.getStringValue(doc,paths.playername,row).trim();
					var player2 = Xpath.getStringValue(doc,paths.playername2,row).trim();
					var player_tooltip = Xpath.getStringValue(doc,paths.playername_tooltip,row).trim();
					
					if (player_tooltip == '') {
						if (player == '') {
							if (player2 == '') {
								Xconsole('row '+i+' has no player name');
								continue;
							} else
								player = player2;
						}
					} else
						player = player_tooltip;
					
					if (name_tooltip == '') {
						if (name == '') {
							if (name_l == '') {
								Xconsole('row '+i+' has no planet name');
								continue;
							} else
								name = name_l;
						}
					} else
						name = name_tooltip;

					var position = Xpath.getNumberValue(doc,paths.position,row);
					if(isNaN(position)) {
						Xconsole('position '+position+' is not a number');
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
					//activity = activity.match(/: (.*)/);
					/*if(activity)
						activity = activity[1];
					else activity = '';*/
					if(!activity) activity='';
					
					var allytag = Xpath.getStringValue(doc,paths.allytag,row).trim();

					var debris = [];
					for(var j = 0; j < 2; j++) {
						debris[XnewOgame.database['resources'][601+j]] = 0;
					}
					var debrisCells = Xpath.getUnorderedSnapshotNodes(doc,paths.debris,row);
					for (var j = 0; j < debrisCells.snapshotLength ; j++) {
						debris[XnewOgame.database['resources'][601+j]] = debrisCells.snapshotItem(j).innerHTML.trimInt();
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
				Request.set(
					{
						row : rowsData,
						galaxy : coords[0],
						system : coords[1],
						type : 'system'
					}
				);

				Request.set('lang',XnewOgame.lang);
				Xdump(Request.data);
				Request.send(XnewOgame.servers);
				this.lastAction = 's:'+coords[0]+':'+coords[1];
			}
		}
	},

	parseRanking : function() {
		var target = this.doc.getElementById('stat_list_content');
		target.win = this.win;
		target.addEventListener("DOMNodeInserted", this.parseRanking_Inserted, true);		
	},

	parseRanking_Inserted : function (event) {		
		try {
			var doc = event.target.ownerDocument;
			var win = doc.getElementById('stat_list_content').win;
			
			var paths = XnewOgame.Xpaths.ranking;
			
			var timeText = Xpath.getStringValue(doc,paths.date).trim();
			timeText += ";"+Xpath.getStringValue(doc,paths.time).trim();
			timeText = timeText.match(/(\d+).(\d+).(\d+);(\d+):\d+:\d+/);

			var time = new Date();
			time.setHours((Math.floor(time.getHours())/8)*8);
			time.setMinutes(0);
			time.setSeconds(0);
			if(timeText) {
				time.setYear(timeText[3]);
				time.setMonth(parseInt(timeText[2].trimZeros())-1);
				time.setDate(timeText[1]);
				time.setHours(Math.floor(parseInt(timeText[4].trimZeros())/8)*8);
			}
			
			time =  Math.floor(time.getTime()/1000);
			var type = new Array();
			type[0] = Xpath.getStringValue(doc,paths.who);
			type[1] = Xpath.getStringValue(doc,paths.type);
			type[2] = Xpath.getStringValue(doc,paths.subnav_fleet);
			type[0] = (type[0] != '') ? type[0] : 'player';
			type[0] = (type[0] == 'alliance') ? 'ally' : type[0];
			type[1] = (type[1] != '') ? type[1] : 'points';
	
			var length = 0;
			var rows = Xpath.getOrderedSnapshotNodes(doc,paths.rows,null);
			var offset = 0;
			
			var Request = XnewOgame.newRequest();
			if(rows.snapshotLength > 0){
				var rowsData = [];
				for (var i = 0; i < rows.snapshotLength; i++) {
					var row = rows.snapshotItem(i);
					var n = null;
					if (type[0] == 'player') {
						n = Xpath.getStringValue(doc,paths.position,row).trimInt();
					} else if(type[0] == 'ally') {
						n = Xpath.getStringValue(doc,paths.ally.position_ally,row).trimInt();
					}
					if (i == 1) {
						offset = Math.floor(n/100)*100+1;//parce que le nouveau classement ne commence pas toujours pile a la centaine et OGSpy toujours a 101,201...
					}
					if (type[0] == 'player') {
						var name = Xpath.getStringValue(doc,paths.player.playername,row).trim();
						var ally = Xpath.getStringValue(doc,paths.player.allytag,row).trim().replace(/\]|\[/g,'');
						var points = Xpath.getStringValue(doc,paths.player.points,row).trimInt();
						var player_id = Xpath.getStringValue(doc,paths.player.player_id,row).trim();
						var ally_id = Xpath.getStringValue(doc,paths.player.ally_id,row).trim();
						
						if (player_id != '' ) {
							player_id = player_id.match(/\&to\=(.*)\&ajax/);
							player_id = player_id[1];
						}
						else if(doc.cookie.match(/login_(.*)=U_/))
							player_id = doc.cookie.match(/login_(.*)=U_/)[1];
						
						if (ally_id != '' ) {
							ally_id = ally_id.match(/allyid\=(.*)/);
							ally_id = ally_id[1];
						} else if (ally){
							//ally_id = '-1';
							ally_id = XtenseMetas.getAllyId(XnewOgame.Xpaths.metas);
						}
//Xconsole('row '+i+' > player_id:'+player_id+',player_name:'+name+',ally_id:'+ally_id+',ally_tag:'+ally+',points:'+points);		
						var r = {player_id:player_id,player_name:name,ally_id:ally_id,ally_tag:ally,points:points};
						rowsData[n]=r;
						length ++;
					} else if(type[0] == 'ally') {
						var ally = Xpath.getStringValue(doc,paths.ally.allytag,row).trim().replace(/\]|\[/g,'');
						var members = Xpath.getStringValue(doc,paths.ally.members,row).getInts();
						moy = members[1];
						members = members[0];
						var points = Xpath.getStringValue(doc,paths.ally.points,row).trimInt();
						var ally_id = Xpath.getStringValue(doc,paths.ally.ally_id,row).trim();
						
						if (ally_id != '' ) {
							ally_id = ally_id.match(/allyid\=(.*)/);
							ally_id = ally_id[1];
						} else if (ally){
							//ally_id = '-1';
							ally_id = XtenseMetas.getAllyId(XnewOgame.Xpaths.metas);
						}
//Xconsole('row '+i+' > ally_id:'+ally_id+',ally_tag:'+ally+',members:'+members+',points:'+points+',mean:'+moy);
						var r = {ally_id:ally_id,ally_tag:ally,members:members,points:points,mean:moy};
						rowsData[n]=r;
						length ++;
					}
				}
				
				if(this.lastAction != 'r:'+type[0]+':'+type[1]+':'+offset){
					//XnewOgame.Tab.setStatus(Xl('ranking detected', Xl('ranking '+type[0]), Xl('ranking '+type[1])));
					if (offset != 0 && length != 0) {
						Request.set(
							{
								n : rowsData,
								type : 'ranking',
								offset : offset,
								type1 : type[0],
								type2 : type[1],
								time: time
							}
						);
						
						Request.set('lang',XnewOgame.lang);
						/*	Le if est temporaire : sert de filtre pour ne pas envoyer les sous-classements militaires (construit, détruit, perdu et points honorifiques)
						 *	On envoie seulement le classement militaire "de base" (quand aucune sous-categorie n'est selectionnée)
						 *	Devra être supprimé quand les tables pour stocker les nouveaux classements auront été crées,
						 *	et que le type[2] sera pris en compte pour l'insertion des classements
						*/
						if (type[2] == '')
							Request.send(XnewOgame.servers);
					}
					this.lastAction = 'r:'+type[0]+':'+type[1]+':'+offset;
				}
			}
		} catch (e) {
			throw_error(e);
		}
	},

	parseAlly_list : function () {
		var target = this.doc.getElementById('eins');
		target.win = this.win;
		target.addEventListener("DOMNodeInserted", this.parseAlly_Inserted, true);
	},
	
	parseAlly_Inserted : function (event) {
		try {
			var doc = event.target.ownerDocument;
			var paths = XnewOgame.Xpaths.ally_members_list;
			var rows = Xpath.getOrderedSnapshotNodes(doc,paths.rows,null);
			var rowsData = [];
			var Request = XnewOgame.newRequest();
			
			for (var i = 0; i < (rows.snapshotLength); i++) {
				var row = rows.snapshotItem(i);
				var player = Xpath.getStringValue(doc,paths.player,row).trim();
				var points = Xpath.getStringValue(doc,paths.points,row).trimInt();
				var rank = Xpath.getStringValue(doc,paths.rank,row).trimInt();
				var coords = Xpath.getStringValue(doc,paths.coords,row).trim();
				coords = coords.match(new RegExp(XnewOgame.regexps.coords))[1];
				
				var r = {player:player,points:points,coords:coords,rank:rank};
				rowsData[i]=r;
			}

			if(this.lastAction != 'ally_list' && rowsData != ""){
				//XnewOgame.Tab.setStatus(Xl('ally_list detected'), XLOG_NORMAL, {url: this.url});
				var tag = Xpath.getStringValue(doc,paths.tag);
				Request.set(
					{
						n : rowsData,
						type : 'ally_list',
						tag : tag
					}
				);
				Request.set('lang',XnewOgame.lang);
				Request.send(XnewOgame.servers);
			}
			this.lastAction = 'ally_list';
		} catch (e) {
			throw_error(e);
		}
	},

	parseRc : function () {
		var paths = this.Xpaths.rc;
		//this.Tab.setStatus(Xl('rc detected'), XLOG_NORMAL, {url: this.url});
		var rcStrings = this.l('combat report');
		var data = {};
		var rnds = {};
		var rslt = {};

		var infos = Xpath.getOrderedSnapshotNodes(this.doc,paths.list_infos);
		if(infos.snapshotLength > 0){
			//Heure et rounds
			var rounds = Xpath.getOrderedSnapshotNodes(this.doc,paths.list_rounds);
			var nbrounds = rounds.snapshotLength;
			if(nbrounds > 0){
				for(var div=0;div<nbrounds;div++){
					var round = rounds.snapshotItem(div).textContent.trim();
					
					if(div == 0){
						var m = round.match(new RegExp(rcStrings['regxps']['time']));
						if(m){
							// Calcul heure d'ete => offset = -120 & heure d'hiver  => offset = -60
							var diff = new Date(Date.UTC(m[3], (m[2]-1), m[1], m[4], m[5], m[6])).getTimezoneOffset();
							var correction = 0;
							if(diff==-120){
								correction = 2;
							} else if(diff==-60){
								correction = 1;
							}
							var date = (Date.UTC(m[3], (m[2]-1), m[1], (parseInt(m[4].replace(new RegExp("0(\\d)"), "$1")) - correction), m[5], m[6])) / 1000;

						} else {
							var date = Math.ceil((new Date().getTime()) / 1000);
						}
					} else {
						var rnd = {};
						for (var i in rcStrings['regxps']['round']) {
							var m = round.match(new RegExp(rcStrings['regxps']['round'][i]));
							if(m)
								rnd[i] = m[1].replace(/\./g, '');
						}
						rnds[div] = rnd;
					}
				}
			}

			//Vaisseaux/Défenses/Joueur/Coordonnées/Technos
			var rc_temp = eval(Xprefs.getChar('rc-temp')); //Coordonnées de destination
		   	for(var table=0;table<infos.snapshotLength;table++){
				var dat = {};
				var val = {};
				var weap = {};
				var info = infos.snapshotItem(table);
				var nbJoueurs=infos.snapshotLength/nbrounds;
				
				//Nombre d'unités
				var values = Xpath.getOrderedSnapshotNodes(this.doc,paths.list_values, info);
				if(values.snapshotLength > 0){
					for(var td=1;td<values.snapshotLength;td++){
						var value = values.snapshotItem(td).textContent.trim();
						if(value){
							val[td] = value.replace(/\./g, '');
						}
					}
				}
				
				//Type de l'unité
				var types = Xpath.getOrderedSnapshotNodes(this.doc,paths.list_types, info);
				if(types.snapshotLength > 0){
					for(var th=1;th<types.snapshotLength;th++){
						var type = types.snapshotItem(th).textContent.trim();
						if(type){
							for (var i in rcStrings['units']) {
								for (var j in rcStrings['units'][i]) {
									var typ = type.match(new RegExp(rcStrings['units'][i][j]));
									if (typ)
										dat[this.database[i][j]] = val[th];
								}
							}
						}
					}
				}

				//Nom joueur et coordonnées
				var dest = 0;
				var player = Xpath.getStringValue(this.doc,paths.infos.player,info).trim(); //Joueur non détruit
				if (player.length==0) { //Dans ce cas, joueur détruit
					player = Xpath.getStringValue(this.doc,paths.infos.destroyed,info).trim();
					dest=1;
				}
				if (!dest)
					var m = player.match(new RegExp(rcStrings['regxps']['attack']+this.regexps.planetNameAndCoords));
				else
					var m = player.match(new RegExp(rcStrings['regxps']['attack']+this.regexps.userNameAndDestroyed));
				if(m){
					var player = m[1];
					if (!dest)
						var coords = m[2];
					else
						var coords = data[(table-nbJoueurs)%nbJoueurs]['coords']; //Joueur détruit, on récupère ses coordonnées lorsqu'il était encore vivant
					var type = "A";
				} else {
					if(!dest)
						var m = player.match(new RegExp(rcStrings['regxps']['defense']+this.regexps.planetNameAndCoords));
					else
						var m = player.match(new RegExp(rcStrings['regxps']['defense']+this.regexps.userNameAndDestroyed));
					
					if(m){
						var player = m[1];
						if (!dest)
							var coords = m[2];
						else {
							if (rc_temp != "")
								var coords = rc_temp.coords; //Si défenseur où à lieu le raid est détruit au 1er tour
							else
								var coords = data[(table-nbJoueurs)%nbJoueurs]['coords']; // Si ce n'est pas le 1er round
						}
						rc_temp = "";
					} else {
						var player = "";
						var coords = "";
					}
					var type = "D";
				}
				
				//Technos
				var weapons = Xpath.getStringValue(this.doc,paths.infos.weapons,info).trim();
				for (var i in rcStrings['regxps']['weapons']) {
					var m = weapons.match(new RegExp(rcStrings['regxps']['weapons'][i]));
					if(m)
						weap[i] = m[1].replace(/\./g, '');
					else { //Joueur détruit
						if ((table-nbJoueurs)<0) //Défenseur où à lieu le raid détruit au 1er tour -> technos inutiles
							weap[i] = 0;
						else
							weap[i] = data[(table-nbJoueurs)%nbJoueurs]['weapons'][i]; //On récupère ses technos lorsqu'il était encore vivant
					}
				}
				
				if(coords != "")
					data[table] = {player : player, coords : coords, type : type, weapons : weap, content : dat};
			}
			
			//Pillages/Pertes/Cdr/Lune
			var result = Xpath.getStringValue(this.doc,paths.result).trim();
			if (result.match(new RegExp(rcStrings['regxps']['nul'], 'gi')))
				var win = "N";
			else if (result.match(new RegExp(rcStrings['regxps']['attack_win'], 'gi')))
				var win = "A";
			else
				var win = "D";

			if(result.match(new RegExp(rcStrings['regxps']['moon'], 'gi')))
				var moon = 1;
			else
				var moon = 0;
			
			if(result.match(new RegExp(rcStrings['regxps']['moonprob'], 'gi')))
				var moonprob = result.match(new RegExp(rcStrings['regxps']['moonprob']))[1];
			else
				var moonprob = 0;
			
			for (var i in rcStrings['regxps']['result']) {
				var m = result.match(new RegExp(rcStrings['regxps']['result'][i]));
				if(m)
					rslt[i] = m[1].replace(/\./g, '');
				else
					rslt[i] = 0;
			}

			//Texte entier du raid, brut
			var rounds = Xpath.getOrderedSnapshotNodes(this.doc,paths.combat_round);
			var round = -1;
			if(rounds.snapshotLength > 0){
				round = rounds.snapshotItem(0).textContent.trim();
			}

			var Request = this.newRequest();
			Request.set(
				{
					type: 'rc',
					date: date,
					win: win,
					count: nbrounds,
					result: rslt,
					moon: moon,
					moonprob : moonprob,
					rounds: rnds,
					n: data,
					rawdata: round
				}
			);
			
			return Request;
		}
	},
	
	parseSpyReport: function(RE) {
		var paths = this.Xpaths.messages.spy;
		//this.Tab.setStatus(Xl('re detected'), XLOG_NORMAL, {url: this.url});
		var spyStrings = this.l('spy reports');
		var locales = this.l('messages');
		var data = {};
		var typs = [];
		var res = new Array();
		
		var isMoon = false;
		//if(data['BaLu'] > 0) isMoon = true; //si il y a une base lunaire, alors c'est une lune
		var moonNode = Xpath.getSingleNode(this.doc, paths.moon);

		isMoon = (moonNode.href).match(new RegExp(locales['moon'] + this.regexps.moon))[1] == '3' ? true : false;
		var playerName = RE.match(new RegExp(this.regexps.spy.player))[1];
		
		var types = Xpath.getOrderedSnapshotNodes(this.doc,paths.fleetdefbuildings);
		if(types.snapshotLength > 0){
		   	for(var table=0;table<types.snapshotLength;table++){
				var type = types.snapshotItem(table).textContent.trim();
		   		if(type)
					typs.push(type);
		   	}
		}

		for (var i in spyStrings['units']) {
			for(var k=0; k<typs.length; k++){
				if(typs[k].match(new RegExp(spyStrings['groups'][i], 'gi'))){
					for (var j in spyStrings['units'][i]) {
						var m = this.getElementInSpyReport(RE,spyStrings['units'][i][j]);
						if(m != -1)
							data[this.database[i][j]] = m;
						else
							data[this.database[i][j]] = 0;
					}
				}
			}
		}
		
		return {
			content: data,
			playerName: playerName,
			moon: isMoon
		};
	},
	
	getElementInSpyReport : function (RE,elem) {
		var num = -1;
		var reg = new RegExp(elem+'\\D+(\\d[\\d.]*)');//recupere le nombre le plus proche apres le texte
		var m = reg.exec(RE);
		
		if(m)
			num = m[1].trimInt();

		return num;
	},
	
	parseTrader : function () {
		var Request = this.newRequest();
		Request.set(
			{
				type: 'trader',
			}
		);
		
		return Request;
	},
	
	parseMessage : function () {
		var paths = this.Xpaths.messages;
		var data = {};		
		var from = Xpath.getStringValue(this.doc,paths.from).trim();
		var to = Xpath.getStringValue(this.doc,paths.to).trim();
		var subject = Xpath.getStringValue(this.doc,paths.subject).trim();
		var date = Xpath.getStringValue(this.doc,paths.date).trim();
		var locales = this.l('messages');
		
		data.date = XparseDate(date,this.l('dates')['messages']);
		data.type = '';
		
		// Messages de joueurs
		if(Xprefs.getBool('msg-msg')) {
			if (Xpath.getOrderedSnapshotNodes(this.doc, paths.reply).snapshotLength > 0) { // si bouton "repondre", c'est un mp
				var m = from.match(new RegExp(this.regexps.userNameAndCoords));
				if(m) {
					var userName = m[1];
					var coords = m[2];
				}
				var contentNode = Xpath.getSingleNode(this.doc,paths.contents['msg']);
				var message = contentNode.getElementsByTagName('p')[0].innerHTML.trim();
				var ladate = data.date
				
				//correctif : pas de date 
				// si on procede comme suit : on redefini la variable data et on perd "date"
				//data = {type:'msg', from: userName, coords: coords, subject: subject, message: message};
					data.type = 'msg';
					data.from = userName;
					data.coords = coords;
					data.subject = subject;
					data.message = message;
				// fin correctif	
				
				
				
			} else Xconsole('The message is not a private message');
		}
		
		// Messages d'alliance
		if(Xprefs.getBool('msg-ally_msg')) {
			var m = from.match(new RegExp(XnewOgame.regexps.ally));
			if(m){
				var contentNode = Xpath.getSingleNode(this.doc,paths.contents['ally_msg']);
				var message = contentNode.innerHTML.replace(new RegExp(this.regexps.ally_msg_player_name, "g"), "$1");
				data.type = 'ally_msg';
				data.from = m[1];
				data.tag = m[1];
				data.message = message;
			} else Xconsole('The message is not an ally message');
		}
		
		// Espionnages perso
		if(Xprefs.getBool('msg-spy')) {
			var m = subject.match(new RegExp(locales['espionage of']+this.regexps.planetNameAndCoords));
			if(m){
				Xconsole('spy detected');
				Xconsole("subject:"+subject);
				
				var contentNode = Xpath.getSingleNode(this.doc,paths.contents['spy']);
				var content = contentNode.innerHTML;
				
				data.planetName = m[1];
				data.coords = m[2];
				
				m = content.match(new RegExp(locales['unespionage prob']+this.regexps.probability));
				if(m)
					data.proba = m[1];
				else data.proba = 0;
				
				data.activity = 0;
				m = content.match(new RegExp(locales['activity']));
				if (m)
					data.activity = m[1];
				
				Ximplements(data, this.parseSpyReport(content));		
				data.type = 'spy';
			} else Xconsole('The message is not a spy report');
		}
		
		// Espionnages ennemis
		 if(Xprefs.getBool('msg-ennemy_spy')) {
			if(subject.match(new RegExp(locales['espionnage action']))) {
				var contentNode = Xpath.getSingleNode(this.doc,paths.contents['ennemy_spy']);
				var rawdata = contentNode.textContent.trim();
				var m = rawdata.match(new RegExp(this.regexps.messages.ennemy_spy));

				if(m){
					data.type = 'ennemy_spy';
					data.from = m[1];
					data.to = m[2];
					data.proba = m[3];
				}
			} else Xconsole('The message is not an ennemy spy');
		}
		
		//RC
		if(Xprefs.getBool('msg-rc')) {
			var m = subject.match(new RegExp(locales['combat of']));
			if (m!=null){
				var rapport = Xpath.getStringValue(this.doc,paths.contents['rc']).trim();
				var m2 = rapport.match(new RegExp(locales['combat defence']+this.regexps.planetNameAndCoords));
				if (m2)
					Xprefs.setChar('rc-temp', '({name: "'+m2[1]+'", coords: "'+m2[2]+'"})');
			}
		}
		
		// Recyclages
		if(Xprefs.getBool('msg-rc_cdr')) {
			if(from.match(new RegExp(locales['fleet'])) && subject.match(new RegExp(locales['harvesting']))) {
			 	var m = subject.match(new RegExp(this.regexps.coords));
				if(m) {
					var coords = m[1];
					var contentNode = Xpath.getSingleNode(this.doc,paths.contents['rc_cdr']);
					var message = Xpath.getStringValue(this.doc,paths.contents['rc_cdr']).trim();
					var nums = message.getInts();
					data.type ='rc_cdr';
					data.coords = coords;
					data.nombre = nums[0];
					data.M_recovered = nums[7];
					data.C_recovered = nums[8];
					data.M_total = nums[2];
					data.C_total = nums[3];
				}
			} else Xconsole('The message is not a harvesting report');
		}
		
		// Expeditions
		if(Xprefs.getBool('msg-expeditions')) {
			var m = subject.match(new RegExp(locales['expedition result']+this.regexps.planetCoords));
			var m2 = from.match(new RegExp(locales['fleet command']));
			
			if (m2!=null && m!=null) {
				var coords = m[1];
				var contentNode = Xpath.getSingleNode(this.doc,paths.contents['expedition']);
				var message = Xpath.getStringValue(this.doc,paths.contents['expedition']).trim();
				data.type = 'expedition';
				data.coords = coords;
				data.content = message;
			} else Xconsole('The message is not an expedition report');
		}

		// Commerce
		if(Xprefs.getBool('msg-res-pref')) {
			var m = subject.match(new RegExp(locales['trade message 1']));
			var m2 = subject.match(new RegExp(locales['trade message 2']));
						
			// Livraison d'un ami sur une de mes planètes
			if (m!=null) {
				var message = Xpath.getStringValue(this.doc,paths.contents['livraison']).trim();
				var infos = message.match(new RegExp(this.regexps.messages.trade_message_infos));
				
				var ressourcesLivrees = message.match(new RegExp(this.regexps.messages.trade_message_infos_res_livrees)); // ressources livrées
				var ressources = ressourcesLivrees[1].match(new RegExp(this.regexps.messages.trade_message_infos_res)); // Quantité de ressources livrées

				var met=ressources[1].trimInt();
				var cri=ressources[2].trimInt();
				var deut=ressources[3].trimInt();
				
				data.type = 'trade';
				data.trader = infos[1].trim();
				data.trader_planet = infos[2].trim();
				data.trader_planet_coords = infos[3].trim();
				data.planet = infos[4].trim();
				data.planet_coords = infos[5].trim();
				data.metal = met;				
				data.cristal = cri;
				data.deuterium = deut;
				
				Xconsole('Livraison du joueur ('+infos[1].trim()+') de la planète '+infos[2].trim()+'('+infos[3].trim()+')sur ma planète '+infos[4].trim()+'('+infos[5].trim()+') : Metal='+met+' Cristal='+cri+' Deuterium='+deut);
				
			} else if (m2!=null) { // Livraison sur la planète d'un ami
				var message = Xpath.getStringValue(this.doc,paths.contents['livraison_me']).trim(); // Corps du message
				
				var infos = message.match(new RegExp(this.regexps.messages.trade_message_infos_me)); // Infos sur la planète
				var planeteLivraison = infos[4].trim(); // Planete sur laquelle la livraison à eu lieu
				
				// Récupération de mes planètes
				var mesPlanetes = Xpath.getOrderedSnapshotNodes(this.win.parent.parent.document,this.Xpaths.planetData['coords']);
				var isMyPlanet=false;
				
				// Parcours de mes planète pour s'assurer que ce n'est pas une des mienne
				if(mesPlanetes!=null && mesPlanetes.snapshotLength > 0){
				   	for(var i=0;i<mesPlanetes.snapshotLength;i++){
						var coord = mesPlanetes.snapshotItem(i).textContent.trim();
						Xconsole('Coordonnees='+coord+' | planeteLivraison='+planeteLivraison);
						if(coord.search(planeteLivraison) > -1){
							 isMyPlanet=true;
							 break;
						}	
				   	}
				}
				
				// Livraison sur une planète amie ? 
				if(!isMyPlanet){
					var ressources = message.match(new RegExp(this.regexps.messages.trade_message_infos_me_res)); // Quantité de ressources livrées
					
					var met=ressources[1].trimInt();
					var cri=ressources[2].trimInt();
					var deut=ressources[3].trimInt();
					
					data.type = 'trade_me';
					data.planet_dest = infos[3].trim();
					data.planet_dest_coords = planeteLivraison;
					data.planet = infos[1].trim();
					data.planet_coords = infos[2].trim();
					data.trader = 'ME';
					data.metal = met;				
					data.cristal = cri;
					data.deuterium = deut;
					
					Xconsole('Je livre de ma planète '+infos[1].trim()+'('+infos[2].trim()+') sur la planète '+infos[3].trim()+'('+infos[4].trim()+') : Metal='+met+' Cristal='+cri+' Deuterium='+deut);
				}
				
			}/* else {
				 Xconsole('The message is not a trade message');	 
			}*/
		}
		
		// Aucun message
		if(data.type == ''){
			this.Tab.setStatus(Xl('no messages'), XLOG_NORMAL, {url: this.url});
			return false;
		} else {
			var Request = this.newRequest();
			Request.set('data', data);
			Request.set('type', 'messages');
			return Request;
		}
	}
}


// Enregistrements
if (typeof Xoptions == 'undefined') { // Ne pas enregistrer plusieurs fois
	Xtense.registerPageLoad(XnewOgame.onPageLoad, XnewOgame);
	Xtense.registerPageDetect(XnewOgame.getUniverse, XnewOgame);
}
