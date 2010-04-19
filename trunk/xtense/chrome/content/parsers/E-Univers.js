/**
* @author Unibozu
 * @author Jormund
 * @license GNU/GPL
 */

var XEUnivers = {
	locales: {},
	
	PLANET: 0,
	MOON: 1,
	
	doc : null,
	url : null,
	Tab : null,
	page : null,
	univers : null,
	lang: null,
	callback : [],
	allys : [],
	params : [],
	
	messagesCache: {},

	l: function(name) {
		if (!this.locales[this.lang][name]) {
			throw new Error('Unknow locale "'+name+'"');
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

	include_script : function (name) {
		// Sandbox
		var s = this.doc.createElement('script');
		s.setAttribute('type', 'text/javascript');
		s.setAttribute('src', 'chrome://xtense2/content/scripts/'+name+'.js');
		this.doc.getElementsByTagName('head')[0].appendChild(s);
	},

	manual_send : function () {
		$('xtense-send').setAttribute('disabled', 'true');
		this.callback[0].apply(this, this.callback[1]);
	},

	onPageLoad: function(doc, url, Tab) {
		try {
			this.doc = doc;
			this.url = url;
			this.Tab = Tab;
			
			if (!(this.universe = this.getUniverse(url))) return false;
			
			if (!Xservers.check(this.universe)) {
				Tab.setStatus(Xl('no server'), XLOG_NORMAL, {url: url});
				return true;
			}
			
			this.lang = this.getLang(this.universe);//.substring(this.universe.lastIndexOf('.')+1).toLowerCase();
			
			if (!this.locales[this.lang]) {
				Tab.setStatus(Xl('unavailable parser lang', this.lang), XLOG_ERROR, {url: url});
				return true;
			}
			//Xdump(this.universe,this.lang,this.locales[this.lang]);
			this.page = this.getPage(url);
			Xdump(this.universe,this.lang,this.page,this.params);
			if (this.page == 'rc') 
				Xtoolbar.show();
		} catch(e) {
			throw_error(e);
		}
		
		try {
			// Ne pas mettre d'erreur pour la page de login
			//if (page == false && !url.match(/\/reg\//g)) 
			//	Tab.setStatus(l('no ogame page'), XLOG_NORMAL, {url: url});
			
			if (!Xtense.active || !this.page) 
				return false;
			
			//TODO
			// Eviter les erreurs sur les pages a moitié chargées (logout...)
			/*if (!doc.getElementById('errorbox') && page != 'rc') 
				return false;*/
			
			if (this.page == 'ally') {
				this.setAlly();
				return true;
			}
			
			//TODO régler le pbm du shipyard
			if (Xprefs.isset('handle-'+this.page) && !Xprefs.getBool('handle-'+this.page)) {
				Tab.setSendAction(this.manualSend, this, [this.page, url, doc, Tab,this.lang, this.universe,this.params]);
				Tab.setStatus(Xl('wait send'), XLOG_NORMAL, {url: url});
				return true;
			}
			Tab.setStatus("E-Univers: "+this.page, XLOG_NORMAL, {url: url});
			//Xconsole("status changed");
			this.sendPage(this.page);
			return true;
		} catch (e) {
			Xtense.CurrentTab.setStatus(Xl('parsing error'), XLOG_ERROR, {url: url, page: this.page});
			if (Xprefs.getBool('debug'))
				show_backtrace(e);
		}
	},
	
	manualSend: function (type, page, url, doc, Tab, lang, universe, params) {
		// Obligé de restaurer le contexte
		this.doc = doc;
		this.Tab = Tab;
		this.universe = universe;
		this.params=params;
		this.lang = lang;
		//Xconsole(doc+" "+universe+" "+_dump(params));
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
		Xconsole('starting parsing '+page+' of E-Univers');
		if (page == 'overview') 		Request = this.parseOverview();
		else if (page == 'buildings') 	Request = this.parseBuildings();
		else if (page == 'researchs') 	Request = this.parseResearchs();
		else if (page == 'defense') 	Request = this.parseDefense();
		else if (page == 'fleet') 		Request = this.parseFleet();
		else if (page == 'shipyard') 		Request = this.parseShipyard();
		else if (page == 'fleetSending')Request = this.parseFleetSending();
		else if (page == 'system') 		Request = this.parseSystem();
		else if (page == 'ranking') 	Request = this.parseRanking();
		else if (page == 'ally_list') 	Request = this.parseAlly_list();
		else if (page == 'rc') 			Request = this.parseRc();
		else if (page == 'messages') 	Request = this.parseMessages();
		else this.Tab.setStatus('invalid page type: "'+page+'"', XLOG_ERROR, {url: this.url});
		Xdump("ending parsing E-Univers");
		
		if (Request) {
			Request.set('lang',this.lang);
			Xdump(Request.data);
			Request.send();
		}
	},
	
	getLang: function (url) {
		var tab = url.split('.');
		switch(tab[tab.length-1])
		{
			case 'org': return 'fr';
			default: return tab[tab.length-1];
		}
	},
	
	getUniverse: function (url) {
		var universe = null;
		var gameURLs=new Array(/^http:\/\/b1.e-univers\.org/g,
										/^http:\/\/bt.e-univers\.org/g,
										/^http:\/\/beta[0-9]+.e-univers\.org/g,
										/^http:\/\/testing.e-univers\.org/g);
		for (var i = 0; i< gameURLs.length; i++) {
			//Xdump(url,gameURLs[i].toString(),url.match(gameURLs[i]));
         universe = url.match(gameURLs[i]);
			if(universe != null)
	         return universe[0];   
        }   
		return false;
	},

	setParams: function (url){
		url = url.split('?')[1];
		url = url.split('#')[0];
		url = url.split('&');
		for(var i=0;i<url.length;i++)
			{
			this.params[url[i].split('=')[0]]=url[i].split('=')[1];
			}
	},
	
	getPage: function(url) {
		try {
			if(url.indexOf('?')>=0)this.setParams(url);
			var corePage = url.match(/\.org\/([a-z]*\.(?:php|html))/);
			corePage = corePage && corePage[1]!="" ? corePage[1] : "index.php";
			Xconsole("corePage: "+corePage);
			if(corePage == "index.php") {
				// Nettoyage de la chaine, on ne prend que ce qu'il y a après index.php?page(>>)
				if((url.indexOf('action=')<0 || typeof this.params['action']=='undefined') && url.match(/\/$/)) //si pas de paramètre, on est sur la page d'accueil
					{
					this.params['action']='accueil';
					}
				switch(this.params['action'])
				{
					case 'accueil':return 'overview';
					case 'batiments':return 'buildings';
					case 'labo':return 'researchs';
					case 'galaxie':return 'system';
					case 'stats':return 'ranking';
					case 'chantier':
									if(typeof this.params['subaction']=="undefined")
										this.params['subaction']='flotte';
									switch(this.params['subaction']) {
										case 'flotte':return 'shipyard';
										case 'def':return 'defense';
									}
					case 'messages': return 'messages';
					case 'flotte': return 'fleet';
				}
			}
			else if(corePage == "popup.php") {//rc
				return 'rc';
			}
/*			
			if (page == 'allianzen') {
				mode = url.substr(url.indexOf('&a=')+3, 1);
				if (mode == '4') return 'ally_list';
				else if (mode == 't') return 'ally';
			}
			
			if (page == 'allianzen') return 'ally';
			if (page == 'flottenversand') return 'fleetSending'
			if (page == 'messages') return 'messages';
			if (page == 'bericht') return 'rc';*/
			
			return false;
		} catch (e) {
			throw_error(e);
		}
	},

	setAlly : function () {
		//if (!force) SetStatus('normal', 'Page d\'alliance détectée');
		if (!this.doc.getElementsByTagName('table')[6]) return;
		var tag = this.doc.getElementsByTagName('table')[6].getElementsByTagName('th')[1].textContent.replace(/\(.+\)/g, '').trim();

		for (var i = 0, len = this.allys.length; i < len; i++) {
			if (this.allys[i].server == this.universe) {
				this.allys[i].tag = tag;
				return;
			}
		}

		this.allys.push({
			server : this.universe,
			tag : tag
		});
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
			else 								Request.Tab.setStatus(message_start + Xl('http status unknow')+ Response.status, XLOG_ERROR, extra);
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
				if ((match = Response.content.match(/(\(\{.*\}\))/))) {
					//Xconsole("data: "+match[1]);
					data = eval(match[1]);
					// Message d'avertissement
					type = XLOG_WARNING;
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
				
				// else if (code == 'home full')			message = '';
				
				else 									message = Xl('unknow response', code, Response.content);
			} else {
				if (code == 'home updated') 			message = Xl('success home updated', Xl('page '+data.page));
				else if (code == 'system')				message = Xl('success system', data.galaxy, data.system);
				else if (code == 'ranking') 			message = Xl('success ranking', Xl('ranking '+data.type1), Xl('ranking '+data.type2), data.offset, data.offset+99);
				else if (code == 'rc')					message = Xl('success rc');
				else if (code == 'ally_list')			message = Xl('success ally_list', data.tag);
				else if (code == 'messages')			message = Xl('success messages');
				else if (code == 'spy') 				message = Xl('success spy');
				//else if (code == '')					message = '';
				else 									message = Xl('unknow response', code, Response.content);
			}
			
			if (Xprefs.getBool('display-execution-time') && data.execution) message = '['+data.execution+' ms] '+ message_start + message;
			
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

	//------ PARSING
	//récupération des ressources
	getTCTE : function () {
		var path = this.l('resources path');//une case sur deux contient les ressources à quai
		var nodes = Xpath.getOrderedSnapshotNodes(this.doc,path);
		var res = new Array();
		for(var i=0;i<3;i++)
		{
			var cell = nodes.snapshotItem(i*2+1).innerHTML;
			res.push(cell.replace(/\n/ig,"").replace(/&nbsp;/ig,"").replace(/[^\d]+(\d+)[^\d]+/ig,'$1'));
		}
		cell = nodes.snapshotItem(7).innerHTML;
		cell = cell.replace(/\n/ig,"").replace(/&nbsp;/ig,"");
		cell = cell.match(/(-?\d+)[^\d]* \/\ (\d+)/i,"");
		res.push(cell[1]);//energie restante (ou manquante)
		res.push(cell[2]);//energie totale
		return res;
	},
	
	// Recuperation des coords actuelles + type de planete + nom + ressources à quai
	getPlanetData : function () {
		var El = this.doc.getElementsByTagName('select')[0];
		var str = El.options[El.selectedIndex].innerHTML;
		var name = str.substr(0, str.indexOf('['));
		var coords = str.substring(str.indexOf('[')+1, str.length-1);
		var type= this.PLANET;
		var res = this.getTCTE();
		var id = El.value.match(/planete_select=(\d+)/)[1];
		//Xdump(name, coords, res);
		return {planet_name: name, coords : coords, planet_type : type, resources: res, planet_id : id};
	},

	parseOverview : function () {
		var path = "id('divpage')/center/table[3]/tbody/tr[1]/th[2]/table/tbody/tr/th[2]";
		var nodes = Xpath.getOrderedSnapshotNodes(this.doc,path);
		
		var cell = nodes.snapshotItem(0);//contient par exemple: 17321 km (218/300 cases)
		var cases = cell.innerHTML.match(/\/(\d+) cases/)[1];
		
		cell = nodes.snapshotItem(1);//contient par exemple: env de 10°C à 50°C
		var temp = cell.innerHTML.match(/C à (-?\d+)°C/)[1];//\u00C0=à     \u00B0=°
		//Xdump(cases,temp);

		var Request = this.newRequest();
		Request.set({
			type: 'overview',
			fields: cases,
			temp: temp
		}, this.getPlanetData());
		
		return Request;
	},

	parseResearchs : function () {
		//this.Tab.setStatus(Xl('researchs detected'));
		
		var Request = this.parseTableStruct();
		
		// Si le labo est vide, Request = false
		if (Request) Request.set('type', 'researchs');
		else this.Tab.setStatus(Xl('no researchs'), XLOG_NORMAL, {url: this.url});
		
		return Request;
	},

	parseBuildings : function () {
		//this.Tab.setStatus(Xl('buildings detected'));
		
		var Request =  this.parseTableStruct();
		
		// Si il n'y a pas de batiments, Request = false
		if (Request) Request.set('type', 'buildings');
		else {
			Request = this.newRequest();
			Request.set(this.getPlanetData());
		}
		
		return Request;
	},
	
	parseTableStruct : function() {
		var reg = new RegExp(this.l('parsetablestruct regexp'),'g');
		var reg2 = new RegExp(this.l('parsetablestruct regexp'));
		var input = this.doc.body.innerHTML;
		var m = input.match(reg);//reg.exec(input);
		var m2 = null;
		Xdump(reg.toString(),m,m.length);
		if(m.length ==0)return false;
		var Request = this.newRequest();
		for (var i = 0 ; i < m.length; i++ ) {
			m2 = m[i].match(reg2);
			Request.set(this.database[this.page][m2[1].trimInt()], m2[2].trimInt());//TODO adapter le format à la DB unispy
			Xdump(m2);
			//Xconsole(this.page+' '+m[i][1]+' '+m[i][2]+' '+this.database[this.page][parseInt(m[i][1])]);
		}
		Request.set(this.getPlanetData());
		//Xdump(this.data);
		return Request;
	},

	parseDefense : function () {
		var Request =  this.parseTableStruct();
		
		// Si il n'y a pas de défense, Request = false
		if (Request) Request.set('type', 'defense');
		else {
			Request = this.newRequest();
			Request.set(this.getPlanetData());
		}
		return Request;
	},
	
	parseShipyard : function () {
		var Request = false;// this.parseTableStruct();
		
		// Si il n'y a pas de défense, Request = false
		if (Request) Request.set('type', 'fleet');
		else {
			Request = this.newRequest();
			Request.set(this.getPlanetData());
		}
		return Request;
	},
	
	parseFleet : function () {
		var path = "//input[@type='hidden' and contains(@name,'maxvaisseau')]";
		var els = Xpath.getOrderedSnapshotNodes(this.doc,path);
		var Request = this.newRequest();
		var count = 0.

		for (i = 0; i < els.snapshotLength; i++) {
			var input = els.snapshotItem(i);
			var id = input.name.trimInt();
			var nb = input.value.trimInt();
			Request.set(this.database['fleet'][id], nb);
		}
		
		Request.set({type: 'fleet'}, this.getPlanetData());
		
		return Request;
	},
	
	parseFleetSending : function () {
		
		
		
	},

	parseSystem : function () {
		if (!this.doc.getElementsByName('galaxiec')[0]) {
			this.Tab.setStatus(Xl('invalid system'), XLOG_NORMAL, {url: this.url});
			return false;
		}

		var coords = [parseInt(this.doc.getElementsByName('galaxiec')[0].value), parseInt(this.doc.getElementsByName('systemec')[0].value)];
		this.Tab.setStatus(Xl('system detected', coords[0], coords[1]));
		var regList = this.regexps.galaxy;//this.l('galaxy');
		var paths = this.Xpaths.galaxy;//regList['lines path'];
		var rows = Xpath.getOrderedSnapshotNodes(this.doc,paths.rows);
		if(rows.snapshotLength<17)this.Tab.setStatus(Xl('system detected', coords[0], coords[1]));
		var Request = this.newRequest();
		
		var rowsData = [];
		// 15 lignes
		for (var i = 2; i < 17; i++) {
			var row = rows.snapshotItem(i);
			var th = row.getElementsByTagName('th');
			
			if(th[1].innerHTML=="") continue;//si pas de lien, le nom de planète est vide, on passe à la suivante
			
			var debris = {'titanium':0,'carbon':0,'tritium':0}
			//var moon = 0;//pas de lune sur e-univers
			//var activity = '';//pas d'activité sur e-univers
			var name = "";
			var player = "";
			var ally = "";
			var status = "";
			var input=row.innerHTML.replace(/\n|\r|\t/g,'');
			var player_id = "";
			var ally_id = "";
			var reg = new RegExp(this.l('galaxy')['line regexp']);
						//
			var m = reg.exec(input);
			//Xdump(reg.toString(),m);
			//Xdump(input);
			if(m)
				{
				name = m[1];
				debris['titanium']=m[3];
				debris['carbon']=m[4];
				debris['tritium']=m[5];
				/*for(var j = 0;j<debris.length;j++)
					{
					debris[j] = (m[j+3]+'').trimInt();
					}*/
				player = m[6];
				player_id = m[7];
				ally = typeof m[9]=='undefined' ? '' : m[9];
				ally_id = typeof m[9]=='undefined' ? '' : m[10];
				}
			if (name == '' || player == '') continue;
			reg = regList.noob;
			m = reg.exec(input);
			if(m)
				status += "d";
			reg = regList.strong;
			m = reg.exec(input);
			if(m)
				status += "f";
			reg = regList.longinactive;
			m = reg.exec(input);
			if(m)
				status += "I";
			reg = regList.inactive;
			m = reg.exec(input);
			if(m)
				status += "i";
			reg = regList.vacation;
			m = reg.exec(input);
			if(m)
				status += "v";
			var r = {planet_name:name, player_name:player,status:status,ally_tag:ally, debris:debris, ally_id:ally_id, player_id:player_id};
			rowsData[i-1]=r;
		}

		Request.set({
			row : rowsData,
			galaxy : coords[0],
			system : coords[1],
			type : 'system',
		});

		return Request;
	},

	parseRanking : function () {
		var select = this.doc.getElementsByTagName('select');
		//Xdump(select);
		if (select.length < 4) {
			this.Tab.setStatus(Xl('invalid ranking'), XLOG_WARNING, {url: this.url});
			return false;
		}

		//on n'enregistre rien si tri par membre
		if (select[1].value == '3') {
			this.Tab.setStatus(Xl('impossible ranking'), XLOG_WARNING, {url: this.url});
			return false;
		}

		var type = new Array();
		switch(select[1].value)
		{
			case '2':type[0] = 'player';
						break;
			case '1':type[0] = 'ally';
						break;
			default:this.Tab.setStatus(Xl('invalid ranking'), XLOG_WARNING, {url: this.url});
						return false;
						break;
		}
		
		switch(select[2].value)
		{
			case '1':type[1] = 'buildings';
						break;
			case '2':type[1] = 'research';
						break;
			case '3':type[1] = 'fleet';
						break;
			case '4':type[1] = 'defense';
						break;
			case '5':type[1] = 'points';
						break;
			default:this.Tab.setStatus(Xl('invalid ranking'), XLOG_WARNING, {url: this.url});
						return false;
						break;
		}

		this.Tab.setStatus(Xl('ranking detected', Xl('ranking '+type[0]), Xl('ranking '+type[1])));
		
		var Request = this.newRequest();
		var regList = this.regexps.ranks;//this.l('ranking');
		var path = this.Xpaths.ranks.time;
		var div = Xpath.getOrderedSnapshotNodes(this.doc,path).snapshotItem(0);
		var hmin = div.innerHTML.getInts();
		var d = new Date();

		d.setHours(hmin[0]);
		d.setMinutes(hmin[1]);
		d.setSeconds(0);

		var time = Math.floor(d.getTime()/1000);

		var path = this.Xpaths.ranks.lines;
		var rows = Xpath.getOrderedSnapshotNodes(this.doc,path);
		var length = 0;
		var reg = new RegExp(regList[type[0]]);
		//Xdump(reg.toString());
		var offset = 0;
		var rowsData = [];
		for (i = 1; i < rows.snapshotLength; i++) {
			var ally = '';
			var n = '';
			var name = '';
			var points = '';
			var members = '';
			var player_id = '';
			var ally_id = '';
			
			var moy = '';var row = rows.snapshotItem(i);
			var input = row.innerHTML.replace(/\n|\r|\t/g,'');
			var m = reg.exec(input);
			if(m)
			{
			if (type[0] == 'player') {
				//Xdump(m);
				n = m[1];
				name = m[2];
				player_id = m[3];
				ally_id = typeof m[4]=='undefined' ? '' : m[4];
				ally = typeof m[5]=='undefined' ? '' : m[5];
				points = m[6].trimInt();
				var r = {player_name:name, ally_tag:ally, points:points, player_id:player_id, ally_id:ally_id};
				rowsData[n]=r;
				//Request.set('n['+n+']', name+'|'+ally+'|'+points+'|'+player_id+'|'+ally_id);
				length ++;
			} else if(type[0] == 'ally') {
				n = m[1];
				ally_id = m[2];
				ally = m[3];
				points = m[4].trimInt();
				var r = {ally_tag:ally, points:points, ally_id:ally_id};
				rowsData[n]=r;
				//Request.set('n['+n+']', ally+'|'+members+'|'+points+'|'+moy+'|'+ally_id);
				length ++;
			}
			}
			if(i==1 && n!='')offset=n;
		}
		var path = this.Xpaths.ranks.offset;
		var offsetSelect = select[3];
			if(typeof offsetSelect!="undefined")offset = offsetSelect.value;

		// Aucune ligne
		if (length == 0) {
			this.Tab.setStatus(Xl('no ranking'), XLOG_NORMAL, {url: this.url});
			return false;
		}
		
		Request.set({
			n : rowsData,
			type : 'ranking',
			offset : offset,
			type1 : type[0],
			type2 : type[1],
			time: time
		});
		
		return Request;
	},

	parseAlly_list : function () {
		//this.Tab.setStatus(l('ally_list detected'));

		var rows = this.doc.getElementsByTagName('table')[6].getElementsByTagName('tr');
		var len = rows.length;
		var Request = this.newRequest();

		for (var i = 2; i < len; i++) {
			var th = rows[i].getElementsByTagName('th');
			var coords = th[5].firstChild.innerHTML;
			coords = coords.substr(1, coords.length - 2);
			// Pseudo, points, coords, rang
			Request.set('n['+(i-2)+']', th[1].innerHTML+'|'+th[4].innerHTML.replace(/\./g, '')+'|'+coords+'|'+th[3].innerHTML);
		}

		var len = this.allys.length;
		var tag = '';
		for (var i = 0; i < len; i ++) {
			if (this.allys[i].server == this.universe) {
				tag = this.allys[i].tag;
				break;
			}
		}
		
		Request.set({
			type : 'ally_list',
			tag : tag
		});
		
		return Request;
	},

	parseRc : function () {
		// Contact perdu
		if (this.doc.getElementsByTagName('tr').length == 1) {
			this.Tab.setStatus(Xl('invalid rc'));
			return false;
		}

		// RE
		if (this.doc.getElementsByTagName('td')[0].firstChild.nodeValue == "\n") {
			//this.Tab.setStatus(l('re detected'));

			var content = this.cleanSpyReport(this.doc.getElementsByTagName('td')[0].innerHTML.trim());
			var coords = this.doc.getElementsByTagName('a')[0].innerHTML;
			coords = coords.substr(1, coords.length-2);
			var time = this.doc.getElementsByTagName('td')[1].childNodes[4].nodeValue;
			time = time.substr(time.indexOf('-')-2, time.length);

			var d = new Date();
			d.setMonth(time.substr(0, 2)-1);
			d.setDate(time.substr(3, 2));
			d.setHours(time.substr(6, 2));
			d.setMinutes(time.substr(9, 2));
			d.setSeconds(time.substr(12, 2));
			if (d.getMonth() == 11 && (new Date().getMonth()) == 0) d.setFullYear(d.getFullYear()-1); // Compatibilité nouvelle année
			
			var Request = this.newRequest();
			
			Request.set({
				'type': 'messages',
				'returnAs': 'spy',
				'data[0][type]': 'spy',
				'data[0][time]': Math.floor(d.getTime()/1000),
				'data[0][coords]': urlencode(coords),
				'data[0][content]': urlencode(content)
			});
			
			return Request;;
		}

		// RC
		//this.Tab.setStatus(l('rc detected'));

		var Request = this.newRequest();
		Request.set({
			type: 'rc',
			content: this.doc.body.innerHTML
		});
		
		return Request;
	},

	parseMessages : function () {
		//this.Tab.setStatus(l('messages detected'));
		var path = this.l('messages path');//chaque ligne est soit l'entête d'un message, soit son contenu (2 lignes par message sauf pour les RC)
		var rows = Xpath.getOrderedSnapshotNodes(this.doc,path);
		var len = rows.snapshotLength;
		var data = [], n = 0;
		var checked_only = Xprefs.getBool('msg-only_checked');
		var prefMessagesCache = Xprefs.getBool('messages-cache');
		
		for (var i = 3; i < len; i++) {
			var row = rows.snapshotItem(i);
			
			var th = row.getElementsByTagName('th');
			var td = row.getElementsByTagName('td');
			//Xconsole(row.textContent+' | '+th.length+' | '+td.length);
			if (td.length != 3 || th.length == 0) continue;
			if (!th[0].firstChild.checked && checked_only) { continue; }
			//Xconsole(th[0].firstChild.value);
			if (prefMessagesCache) {
				var messageId = parseInt(th[0].firstChild.value);
				Xconsole("traitement du message "+messageId);
				
				if (typeof this.messagesCache[this.univers] == 'undefined') 
					this.messagesCache[this.univers] = [];
				else if (this.messagesCache[this.univers].indexOf(messageId) != -1) {
					Xdump('Message sent; Jump');
					i++; continue;
				}
			}
			
			// Messages de joueurs
			/*if (th[3].getElementsByTagName('img').length == 1 && Xprefs.getBool('msg-msg')) {
				var from = th[2].firstChild.nodeValue.trim();
				var coords = th[2].childNodes[1].innerHTML;
				coords = coords.substring(1, coords.length-1);
				var subject = th[3].firstChild.nodeValue.trim();
				var message = rows[i+1].getElementsByTagName('td')[1].innerHTML.replace(/<br>/g, '\n').trim();

				data.push({type:'msg', from: from, coords: coords, subject: subject, message: message});
			}
			
			// Messages d'alliance
			else if (th[3].textContent.indexOf(this.l('title ally_msg')) != -1 && Xprefs.getBool('msg-ally_msg')) {
				var content = th[3].textContent;
				var tag = content.substring(content.indexOf('[')+1, content.length-2);

				var message = rows[i+1].getElementsByTagName('td')[1].innerHTML.replace(/<br>/g, '\n');
				message = message.substring(message.indexOf('\n')+1, message.length).trim();
				
				var from = message.substring(0, message.indexOf('\n')).substring(10);
				from = from.substring(0, from.indexOf(this.l('ally_msg from')));
				Xdump(from,tag,message);
				data.push({type: 'ally_msg', from: from, tag: tag, message: message});
			}
			
			// Expeditions
			else if (th[3].textContent.indexOf(this.l('title expedition')) != -1 && Xprefs.getBool('msg-expeditions')) {
				var coords = th[3].innerHTML.substr(th[3].innerHTML.indexOf('[')+1, 30);
				coords = coords.substr(0, coords.length - 2);
				var content = rows[i+1].getElementsByTagName('td')[1].innerHTML.trim();
				data.push({type: 'expedition', coords: coords, content: content});
			}
			
			// Rapports de recyclage
			else if (th[3].textContent.indexOf(this.l('title rc_cdr')) != -1 && Xprefs.getBool('msg-rc')) {
				var content = rows[i+1].getElementsByTagName('td')[1].innerHTML;
				var nums = content.getInts();
				var coords = th[3].childNodes[1].innerHTML;
				coords = coords.substring(1, coords.length-1);

				data.push({
					type:'rc_cdr',
					coords: coords,
					nombre: nums[0],
					M_recovered: nums[4],
					C_recovered: nums[5],
					M_total: nums[2],
					C_total: nums[3]
				});
			}
			
			// Espionnages ennemis
			else if (th[3].textContent.indexOf(this.l('title ennemy_spy')) != -1 && Xprefs.getBool('msg-ennemy_spy')) {
				var td = rows[i+1].getElementsByTagName('td')[1];
				var from = td.childNodes[1].innerHTML.substring(1, td.childNodes[1].innerHTML.length-1);
				var to = td.childNodes[3].innerHTML.substring(1, td.childNodes[3].innerHTML.length-1);
				var proba = td.childNodes[4].nodeValue;
				var rawdata = td.childNodes[0].nodeValue + td.childNodes[2].nodeValue;
				proba = proba.substring(0, proba.length-2);
				proba = proba.substr(proba.lastIndexOf(' ')+1, 4);

				data.push({type: 'ennemy_spy', from: from, to: to, proba: proba, rawdata: rawdata});
			}*/
			
			// Rapports d'espionnage
			if (td[2].textContent.indexOf(this.l('title spy')) != -1 && Xprefs.getBool('msg-spy')) {
				var reportCell = rows.snapshotItem(i+1).getElementsByTagName('th')[0];
				var contentData = this.parseSpyReport(reportCell.innerHTML);
				i++;//on saute une ligne
				if(contentData)//contentData is false when no valid SR is found
				{
					//Xdump(reportCell.innerHTML);
					Ximplements(contentData, {type: 'spy'});
					//Xdump(contentData);
					
					data.push(contentData);
				}
				else
				{
					continue;
				}
				
			}
			
			else {
				continue;
			}
			
			//data[data.length-1].time = Math.floor(d.getTime()/1000);
			var date = XparseDate(td[0].innerHTML,this.l('dates')['messages']);//replace(/(\d+)\/(\d+)\/\d+/,'$2-$1');//28/10/2008 17:13:40 to 10-28 17:13:40
			data[data.length-1].date = date;
			if (prefMessagesCache) this.messagesCache[this.univers].push(messageId);
		}
		
		
		if (data.length == 0) {
			this.Tab.setStatus(Xl('no messages'), XLOG_NORMAL, {url: this.url});
			return false;
		}
		
		var Request = this.newRequest();
		for (var key = 0, len = data.length; key < len; key++) {
			for (var i in data[key]) {
				Request.set('data['+key+']['+i+']', data[key][i]);
			}
		}
		
		Request.set('type', 'messages');
		
		return Request;
	},

	cleanSpyReport : function (content) {
		content = content.replace(/\n/g, ''); // Sauts à la ligne
		content = content.replace(/<\/td[^>]*><td[^>]*>/g, '\t').replace(/<tr[^>]*>/g, '\n').replace('<center> ', '\n').replace(this.l('spy attack'), '');
		content = content.replace(/<[^>]*>/g, '').trim(); // Balises restantes
		content = content.replace(new RegExp('     \n'+this.l('spy activity')+'.*;">', 'g'), ''); //Bug Activité...
		return content;
	},
	getElementInSpyReport : function (RE,elem) {
		var num = -1;
		var reg = new RegExp('>'+elem+':?<\\D+(\\d[^<]*)');
		//Xconsole("elem: "+reg.toString());
		var m = reg.exec(RE);
		if(m)
			num = m[1].trimInt();
		return num;
	},
	parseSpyReport: function(RE) {
		var resources = this.l('resources');
		var spyStrings = this.l('spy strings');

		var data = {};
		
		var res = new Array();
		for (var i = 0; i < resources.length ; i++) {
			data[this.database['resources'][i]] = this.getElementInSpyReport(RE,resources[i]);
		}
		
		for (var i in spyStrings) {
			for (var j in spyStrings[i]) {
				data[this.database[i][j]] = this.getElementInSpyReport(RE,spyStrings[i][j]);
				
			}
			
		}
		var header = RE.match(this.l('spy header regexp'));
		
		if(!header)
			return false;
		//header = header ? header : new Array("","","");
		
		//Xdump(data);
		
		var parsedData = [];
		for (var i in data) parsedData.push(i+':'+data[i]);
		parsedData = parsedData.join(':');
		
		return {
			content: parsedData,
			planetName: header[1],
			playerName: " ",//pas dans les RE e-univers
			coords: header[2],
			proba: RE.match(this.l('spy proba regexp'))[1],
			moon: false//pas de lune sur e-univers
		};
	}
}


// Enregistrements
if (typeof Xoptions == 'undefined') { // Ne pas enregistrer plusieurs fois
	Xtense.registerPageLoad(XEUnivers.onPageLoad, XEUnivers);
	Xtense.registerPageDetect(XEUnivers.getUniverse, XEUnivers);
	/*Xtense.registerNoAutohidePage(/^http:\/\/bt\.e-univers\.org\//);
	Xtense.registerNoAutohidePage(/^http:\/\/beta[0-6]\.e-univers\.org\//);
	Xtense.registerNoAutohidePage(/^http:\/\/testing\.e-univers\.org\//);*/
}