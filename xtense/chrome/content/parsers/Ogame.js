/**
 * @author Unibozu
 * @license GNU/GPL
 */

var Xogame = {
	locales: {},
	Xpaths: {},
	
	PLANET: 0,
	MOON: 1,
	
	doc : null,
	url : null,
	Tab : null,
	univers : null,
	lang: null,
	callback : [],
	allys : [],
	
	messagesCache: {},

	// Données sur les batiments,  def...
	database : {
		/* Batiments */ 1:'M', 2:'C', 3:'D', 4:'CES', 12:'CEF', 14:'UdR', 15:'UdN', 21:'CSp', 22:'HM', 23:'HC', 24:'HD', 31:'Lab', 33:'Ter', 34:'DdR', 44:'Silo', 41:'BaLu', 42:'Pha', 43:'PoSa',
		/* Technos */ 106:'Esp', 108:'Ordi', 109:'Armes', 110:'Bouclier', 111:'Protection', 113:'NRJ', 114:'Hyp', 115:'RC', 117:'RI', 118:'PH', 120:'Laser', 121:'Ions', 122:'Plasma', 123:'RRI', 124: 'Expeditions', 199:'Graviton',
		/* Flotte */ 202:'PT', 203:'GT', 204:'CLE', 205:'CLO', 206:'CR', 207:'VB', 208:'VC', 209:'REC', 210:'SE', 211:'BMD', 212:'SAT', 213:'DST', 214:'EDLM', 215:'TRA',
		/* Def */ 401:'LM', 402:'LLE', 403:'LLO', 404:'CG', 405:'AI', 406:'LP', 407:'PB', 408:'GB', 502:'MIC', 503:'MIP'
	},
	
	regexpList : {
		'parsetableStruct': '<a[^>]*gid=(\\d+)[^>]*>[^<]*</a> \\([^<\\d]*([\\d.]+)[^<]*<'
	},

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
			
			this.lang = this.universe.substring(this.universe.lastIndexOf('.')+1).toLowerCase();
			
			if (!this.locales[this.lang]) {
				Tab.setStatus(Xl('unavailable parser lang', this.lang), XLOG_ERROR, {url: url});
				return true;
			}
			
			var page = this.getPage(url);
			
			if (page == 'rc') 
				Xtoolbar.show();
		} catch(e) {
			throw_error(e);
		}
		
		try {
			// Ne pas mettre d'erreur pour la page de login
			if (!Xtense.active || !page) 
				return false;
			
			// Eviter les erreurs sur les pages a moitié chargées (logout...)
			if (!doc.getElementById('errorbox') && page != 'rc') 
				return false;
			
			if (page == 'ally') {
				this.setAlly();
				return true;
			}
			
			if (Xprefs.isset('handle-'+page) && !Xprefs.getBool('handle-'+page)) {
				Tab.setSendAction(this.manualSend, this, [page, url, doc, Tab,this.lang, this.universe]);
				Tab.setStatus(Xl('wait send'), XLOG_NORMAL, {url: url});
				return true;
			}
			
			this.sendPage(page);
			return true;
		} catch (e) {
			Xtense.CurrentTab.setStatus(Xl('parsing error'), XLOG_ERROR, {url: url, page: page});
			if (Xprefs.getBool('debug'))
				show_backtrace(e);
		}
	},
	
	manualSend: function (type, page, url, doc, Tab,lang, universe) {
		// Obligé de restaurer le contexte
		this.page = page;
		this.doc = doc;
		this.Tab = Tab;
		this.universe = universe;
		this.lang = lang;
		
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
		else if (page == 'researchs') 	Request = this.parseResearchs();
		else if (page == 'defense') 	Request = this.parseDefense();
		else if (page == 'fleet') 		Request = this.parseFleet();
		else if (page == 'fleetSending')Request = this.parseFleetSending();
		else if (page == 'system') 		Request = this.parseSystem();
		else if (page == 'ranking') 	Request = this.parseRanking();
		else if (page == 'ally_list') 	Request = this.parseAlly_list();
		else if (page == 'rc') 			Request = this.parseRc();
		else if (page == 'messages') 	Request = this.parseMessages();
		else this.Tab.setStatus('invalid page type: "'+page+'"', XLOG_ERROR, {url: this.url});
		
		//Xdump(Request.data);
		if (Request) {
			Request.set('lang',this.lang);
		    Xdump(Request.data);
		    Request.send();
		}
	},
	
	getUniverse: function (url) {
		var universe = url.match(/^http:\/\/uni[0-9]{1,2}\.ogame\.[a-z]{2,4}/gi);
		if(universe && !url.match(/^http:\/\/uni42\.ogame\.org/gi))
			return universe[0];
		else return false;
	},

	getPage: function(url) {
		try {
			// Nettoyage de la chaine, on ne prend que ce qu'il y a après index.php?page(>>)
			url = url.substr(url.indexOf('game/')+20, url.length);
			var page = url.substr(0, url.indexOf('&'));
			
			if (page == 'buildings') {
				mode = url.substr(url.indexOf('&mode=')+6, 9);
				
				if (mode == 'Verteidig') return 'defense';
				if (mode == 'Forschung') return 'researchs';
			}
			
			if (page == 'allianzen') {
				mode = url.substr(url.indexOf('&a=')+3, 1);
				
				if (mode == '4') return 'ally_list';
				else if (mode == 't') return 'ally';
			}
			
			if (page == 'galaxy') return 'system';
			if (page == 'overview') return 'overview';
			if (page == 'allianzen') return 'ally';
			if (page == 'b_building') return 'buildings';
			if (page == 'flotten1') return 'fleet';
			if (page == 'flottenversand') return 'fleetSending'
			if (page == 'stat' || page == 'statistics') return 'ranking';
			if (page == 'messages') return 'messages';
			if (page == 'bericht') return 'rc';
			
			return false;
		} catch (e) {
			throw_error(e);
		}
	},

	setAlly : function () {
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

	//------ PARSING

	// Recuperation des coords actuelles + type de planete + nom
	getPlanetData : function () {
		var El = this.doc.getElementsByTagName('select')[0];
		var str = El.getElementsByTagName('option')[El.selectedIndex].innerHTML;
		var coords = str.substring(str.indexOf('[')+1, str.length-1);
		var n = -1, type = this.PLANET;

		if ((n = str.indexOf('('+this.l('moon')+')	')) != -1) {
			var name = str.substr(0, n-1);
			type = this.MOON;
		} else {
			var name = str.substr(0, str.indexOf('	'));
			if (name.toLowerCase() == this.l('moon').toLowerCase()) 	type = this.MOON;
			else 					type = this.PLANET;
		}
		
		return {planet_name: name, coords : coords, planet_type : type/*, resources: res*/};
	},
	
	getResources : function () {
		var cells = this.doc.getElementById('resources').getElementsByTagName('tr')[2].getElementsByTagName('td');
		var metal = cells[0].textContent.getInts()[0];
		var cristal = cells[1].textContent.getInts()[0];
		var deut = cells[2].textContent.getInts()[0];
		var antimater = cells[3].textContent.getInts()[0];
		var energy = cells[4].textContent.getInts();
		return [metal,cristal,deut,antimater,energy];
	},
	
	parseOverview : function () {
		var cells = this.doc.getElementById('content').getElementsByTagName('table')[0].getElementsByTagName('th');
		var len = cells.length;
		
		var cases = cells[len - 7].textContent.getInts()[2];
		var temp = cells[len - 5].textContent.match(/\d+[^\d-]*(-?\d+)[^\d]/)[1];//\u00C0=à     \u00B0=°
		//Xdump(cells[len - 5].textContent.getInts());
		
		var Request = this.newRequest();
		Request.set({
			type: 'overview',
			fields: cases,
			temp: temp,
			ressources: this.getResources()
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
		else this.Tab.setStatus(Xl('no buildings'), XLOG_NORMAL, {url: this.url});
		
		return Request;
	},
	
	parseTableStruct : function() {
		var reg = new RegExp(this.regexpList['parsetableStruct'],'g');
		var reg2 = new RegExp(this.regexpList['parsetableStruct']);
		var input = this.doc.getElementById('content').innerHTML;
		var m = input.match(reg);//reg.exec(input);
		var m2 = null;
		Xdump(m);
		Xconsole("reg:"+reg.toString());//+"|m.length:"+m.length);
		Xdump(input);
		if(!m)return false;
		
		var Request = this.newRequest();
		for (var i = 0 ; i < m.length; i++ ) {
			m2 = m[i].match(reg2);
			Request.set(this.database[m2[1].trimInt()], m2[2].trimInt());
			Xdump(m2);
			//Xconsole(this.page+' '+m[i][1]+' '+m[i][2]+' '+this.database[this.page][parseInt(m[i][1])]);
		}
		Request.set(this.getPlanetData());
		//Xdump(this.data);
		return Request;
	},

	parseDefense : function () {
		var Request =  this.parseTableStruct();
		
		// Si il n'y a pas de batiments, Request = false
		if (Request) Request.set('type', 'defense');
		else {
			//Request = this.newRequest();
			//Request.set(this.getPlanetData());
			this.Tab.setStatus(Xl('no defenses'), XLOG_NORMAL, {url: this.url});
		}
		
		return Request;
	},
	
	parseFleet : function () {
		var els = this.doc.getElementsByTagName('input');
		var Request = this.newRequest();
		var count = 0.

		for (i = 0; i < els.length; i++) {
			if (els[i].type == 'text') {
				var nb = els[i].alt.substr(els[i].alt.lastIndexOf(' ')+1, 9);
				var id = els[i].name.substr(4, 3);
				Request.set(this.database[id], nb);
			}
		}

		if (this.doc.getElementsByName('maxship212')[0]) {
			Request.set(this.database[212], this.doc.getElementsByName('maxship212')[0].value);
		}
		
		Request.set({type: 'fleet'}, this.getPlanetData());
		
		return Request;
	},
	
	parseFleetSending : function () {
		var Request = this.newRequest();
		var els = this.doc.getElementById('content').getElementsByTagName('tr');
		var j=0;
		if(els.length>0)
		for (i = 0; i < els.length; i++) {
			row = els[i].getElementsByTagName('th');
			if(row.length>1){
				left = row[0].textContent.trim();
				right = row[1].textContent.trim();
				Request.set('row['+j+']',left+'|'+right);
				j++;
			}
		}
		Request.set({type: 'fleetSending'}, this.getPlanetData());
		
		return Request;
	},

	parseSystem : function () {
		if (!this.doc.getElementsByName('galaxy')[0]) {
			this.Tab.setStatus(Xl('invalid system'), XLOG_NORMAL, {url: this.url});
			return false;
		}

		if (Xprefs.getBool('fixpopups')) {
			//this.include_script('galaxy');
			fix_ally_popups();
		}
		var coords = [Xpath.getNumberValue(this.doc,this.Xpaths.galaxy_galaxy),Xpath.getNumberValue(this.doc,this.Xpaths.galaxy_system)];
		//this.Tab.setStatus(Xl('system detected', coords[0], coords[1]));

		var div_content = this.doc.getElementById('content');
		var tables = div_content.getElementsByTagName('table');
		var len = tables.length;
		var rows = tables[3].getElementsByTagName('tr');
		
		var foxgame = (rows[2].childNodes.length == 17 ? false : true);
		var col = (foxgame ? 0 : 1);
		var Request = this.newRequest();

		var rowsData = [];
		// 15 lignes
		for (var i = 2; i < 17; i++) {
			var th = rows[i].getElementsByTagName('th');

			if (!th[col+4].childNodes[1]) continue;
			if (th[col+4].childNodes[1].nodeType != 1) continue;
			var name = th[col+1].textContent.trim();
		
			var activity = '';
			if (name.indexOf('(') != -1) {
				activity = name.substring(name.indexOf('(')+1, name.indexOf(')'));
				name = name.substring(0, name.indexOf('(')-1);
			}
			

			// CDR
			var cdrEls = th[0].getElementsByTagName('a');
			var debrisM = debrisC = 0;
			if (cdrEls.length == 2) {
				var ints = cdrEls[1].title.getInts();
				debrisM = ints[0];
				debrisC = ints[1];
			}

			var moon = (th[col+2].childNodes.length == 1 ? 0 : 1);
			var player = th[col+4].childNodes[1].childNodes[1].innerHTML.trim();

			if (th[col+5].childNodes.length > 1) {
				if (th[col+5].childNodes[1].childNodes.length == 1) {
					var ally = th[col+5].childNodes[1].innerHTML.trim();
					//alert(th[col+5].childNodes[1].innerHTML.trim());
				} else {
					var ally = th[col+5].childNodes[1].childNodes[1].innerHTML.trim();
				}

			} else {
				var ally = '';
			}
			if (th[col+6].childNodes.length > 1) {
				if(th[col+6].getElementsByTagName('a')[0].href.trim().match(/#/))
					var player_id = th[col+6].getElementsByTagName('a')[2].href.trim().match(/messageziel=(.*)/)[1];
				else
					var player_id = th[col+6].getElementsByTagName('a')[1].href.trim().match(/messageziel=(.*)/)[1];
			} else if(this.doc.cookie.match(/login_(.*)=U_/))
					var player_id = this.doc.cookie.match(/login_(.*)=U_/)[1]; 
			var status = th[col+4].textContent.trimAll();
			//Xconsole(status+' '+status.indexOf('(')+' '+status.indexOf(')'));
			if(status.indexOf('(')>-1 && status.indexOf(')')>-1)
				{
				status = status.substring(status.indexOf('(')+1,status.indexOf(')'));
				}
			else status ='';
			//Xconsole(status);
			if (name == '' || player == '') continue;
			debris= {'metal':debrisM,'cristal':debrisC};
			var r = {
				planet_name: name,
				moon: moon,
				player_id: player_id,
				player_name: player,
				status: status,
				ally_tag: ally,
				debris: debris,
				activity:activity
			};
			rowsData[i-1]=r;
		}

		Request.set({
			row: rowsData,
			galaxy : coords[0],
			system : coords[1],
			type : 'system'
		});

		return Request;
	},

	parseRanking : function () {
		var select = this.doc.getElementsByTagName('select');

		if (select.length == 1) {
			this.Tab.setStatus(Xl('invalid ranking'), XLOG_WARNING, {url: this.url});
			return false;
		}

		if (this.doc.getElementById('sort_per_member').value == 1) {
			this.Tab.setStatus(Xl('impossible ranking'), XLOG_WARNING, {url: this.url});
			return false;
		}

		var offset = 0;
		var type = [select[1].value, ''];
		if (select[2].value == 'flt' || select[2].value == 'fleet') 			type[1] = 'fleet';
		else if (select[2].value == 'pts' || select[2].value == 'ressources') 	type[1] = 'points';
		else 																	type[1] = 'research';

		//this.Tab.setStatus(Xl('ranking detected', Xl('ranking '+type[0]), Xl('ranking '+type[1])));

		var timeText = this.doc.getElementsByTagName('table')[this.doc.getElementsByTagName('table').length-2].getElementsByTagName('td')[0].innerHTML;
		var time = new Date();
		timeText = timeText.match(/(\d+)-(\d+)-(\d+)[^\d]+(\d+):\d+:\d+/);
		var time = new Date();
		time.setHours(Math.floor(time.getHours()/6)*6);
		if(timeText) {
			time.setYear(timeText[1]);
			time.setMonth(parseInt(timeText[2].trimZeros())-1);
			time.setDate(timeText[3]);
			time.setHours(Math.floor(parseInt(timeText[4].trimZeros()/8))*8);
			time.setMinutes(0);
			time.setSeconds(0);
		}
		//Xconsole(timeText+' | '+time);
		time =  Math.floor(time.getTime()/1000);;
		
		var rows = this.doc.getElementById('content').getElementsByTagName('table')[1].getElementsByTagName('tr');
		var length = 0;
		var Request = this.newRequest();
		var rowsData = [];
		for (i = 1; i < rows.length; i++) {
			var th = rows[i].getElementsByTagName('th');
			var n = parseInt(th[0].firstChild.nodeValue.trim());
			if (i == 1) offset = n;

			if (type[0] == 'player') {
				if (th[1].childNodes.length != 1) 
					var name = th[1].childNodes[1].innerHTML.trim();
				else 
					var name = th[1].innerHTML.trim();
				if(th[2].getElementsByTagName('a')[0])
					var player_id = th[2].getElementsByTagName('a')[0].href.trim().match(/messageziel=(.*)/)[1];
				else if(this.doc.cookie.match(/login_(.*)=U_/))
					var player_id = this.doc.cookie.match(/login_(.*)=U_/)[1]; 
				var ally = th[3].childNodes[1].innerHTML.trim();
				if(ally != "") 
					if(th[3].getElementsByTagName('a')[0].href.trim().match(/allyid=(.*)/))
						var ally_id = th[3].getElementsByTagName('a')[0].href.trim().match(/allyid=(.*)/)[1];
					else
						var ally_id = "-1";
				else
					var ally_id = "";
				
				var points = parseInt(th[4].innerHTML.replace(/\./g, ''));
				var r = {player_id: player_id, player_name: name, ally_id: ally_id, ally_tag: ally, points: points};
				rowsData[n]=r;
				length ++;
			} else {
				if (th[1].childNodes[1].tagName != 'A') 
					continue;
				var ally = th[1].childNodes[1].innerHTML.trim();
				if(th[1].getElementsByTagName('a')[0].href.trim().match(/allyid=(.*)/))
					var ally_id = th[1].getElementsByTagName('a')[0].href.trim().match(/allyid=(.*)/)[1];
				else
					var ally_id = "-1";
				var points = parseInt(th[4].innerHTML.replace(/\./g, ''));
				var members = parseInt(th[3].innerHTML);
				var moy = parseInt(th[5].innerHTML.replace(/\./g, ''));
				
				var r = {ally_id: ally_id, ally_tag: ally, members: members, points: points, mean: moy};
				rowsData[n]=r;
				length ++;
			}
		}

		// Aucune ligne
		if (offset == 0 || length == 0) {
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
		var rowsData = [];

		for (var i = 2; i < len; i++) {
			var th = rows[i].getElementsByTagName('th');
			var coords = th[5].firstChild.innerHTML;
			coords = coords.substr(1, coords.length - 2);
			var r = {player: th[1].innerHTML, points: th[4].innerHTML.replace(/\./g, ''), coords: coords, rank: th[3].innerHTML};
			rowsData[i-1]=r;
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
			n : rowsData,
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
	
	parseDate : function(dateString,handler) {
		var date = new Date();
		var m = dateString.match(new RegExp(handler.regexp));
		var time = new Date();
		if(m) {
			if(handler.fields.year!=-1)
				time.setYear(m[handler.fields.year]);
			if(handler.fields.month!=-1)
				time.setMonth(parseInt(m[handler.fields.month].trimZeros())-1);
			if(handler.fields.day!=-1)
				time.setDate(m[handler.fields.day]);
			if(handler.fields.hour!=-1)
				time.setHours(m[handler.fields.hour]);
			if(handler.fields.min!=-1)
				time.setMinutes(m[handler.fields.min]);
			if(handler.fields.sec!=-1)
				time.setSeconds(m[handler.fields.sec]);
		}
		//Xconsole(m+' | '+time);
		time =  Math.floor(time.getTime()/1000);//division par 1000 pour un timestamp php
		return time;
	},
	
	parseMessages : function () {
		//this.Tab.setStatus(l('messages detected'));
		var rows = this.doc.getElementsByTagName('table')[7].getElementsByTagName('tbody')[0].getElementsByTagName('tr');
		var len = rows.length;
		var data = [], n = 0;
		var checked_only = Xprefs.getBool('msg-only_checked');
		var prefMessagesCache = Xprefs.getBool('messages-cache');
		
		for (var i = 2; i < len; i++) {
			var th = rows[i].getElementsByTagName('th');
			if (th.length != 4) continue;
			if (th[0].innerHTML == 'Action') continue;
			if (th[3].firstChild.tagName == 'A') continue; // RC
			if (!th[0].firstChild.checked && checked_only) { i++; continue; }

			if (prefMessagesCache) {
				var messageId = Number(th[0].firstChild.name.substring(6));
				Xdump(messageId);
				
				if (typeof this.messagesCache[this.univers] == 'undefined') 
					this.messagesCache[this.univers] = [];
				else if (this.messagesCache[this.univers].indexOf(messageId) != -1) {
					Xdump('Message sent; Jump');
					i++; continue;
				}
			}
			
			// Messages de joueurs
			//Xconsole(th[3].getElementsByTagName('img').length+' '+Xprefs.getBool('msg-msg')+' '+th[2].childNodes.length);
			if (th[3].getElementsByTagName('img').length == 1 && Xprefs.getBool('msg-msg') 
				&& th[2].childNodes.length > 1) { // Si count < 2, alors c'est pas un msg de joueur mais un RE avec une img rajoutée par FoxGame
				var from = th[2].firstChild.nodeValue.trim();
				var coords = th[2].childNodes[1].innerHTML;
				coords = coords.substring(1, coords.length-1);
				var subject = th[3].firstChild.nodeValue.trim();
				var message = rows[i+1].getElementsByTagName('td')[1].innerHTML.replace(/<br>/g, '\n').trim();
				message = message.replace(/<.*/,'');//compatibilité Foxgame, on coupe dès qu'on trouve une balise html
				data.push({type:'msg', from: from, coords: coords, subject: subject, message: message});
			}
			
			// Messages d'alliance
			else if (th[3].textContent.indexOf(this.l('title ally_msg')) != -1 && Xprefs.getBool('msg-ally_msg')) {
				var content = th[3].textContent;
				var tag = content.substring(content.indexOf('[')+1, content.length-2);

				var message = rows[i+1].getElementsByTagName('td')[1].innerHTML.replace(/<br>/g, '\n');
				var from = message.match(this.l('ally_msg from'))[1];
				
				message = message.substring(message.indexOf('\n')+1, message.length).trim();
				Xdump(from,tag,message);
				data.push({type: 'ally_msg', from: from, tag: tag, message: message});
			}
			//messages d'alliance reformaté par Foxgame
			else if(th[3].textContent.match(this.l('ally_msg from')) && Xprefs.getBool('msg-ally_msg')) {
				var content = th[2].textContent;
				var tag = content.substring(content.indexOf('[')+1, content.length-2);
				
				var message = rows[i+1].getElementsByTagName('td')[1].innerHTML.replace(/<.*/,'');
				var from = th[3].textContent.match(this.l('ally_msg from'))[1];
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
				Xdump(content,nums);
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
			}
			
			// Rapports d'espionnage
			else if (th[3].textContent.indexOf(this.l('title spy')) != -1 && Xprefs.getBool('msg-spy')) {
				var td = rows[i+1].getElementsByTagName('td')[1];
				var contentData = this.parseSpyReport(td.innerHTML);
				
				Ximplements(contentData, {type: 'spy'});
				//Xdump(contentData);
				
				data.push(contentData); 
			}
			
			else {
				i++; continue;
			}
			
			var date = th[1].innerHTML;
			data[data.length-1].date = this.parseDate(date,this.l('dates')['messages']);
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
	
	parseSpyReport: function(re) {
		re = re.replace(/\n/g, '')
				.replace(/<t(r|d)[^>]*>/g, '\n')
				.replace('<center> ', '\n')
				.replace(this.l('spy attack'), '')
				.replace(/<[^>]*>/g, '')
				.replace(new RegExp(this.l('spy activity')+'.*;">', 'g'), '')
				.replace(/[\t ]+$/gm, '')
				.replace(/\n+/g, '\n').trim()
		
		var spyStrings = this.l('spy strings');
		var database = this.l('spy database');
		var groups = this.l('spy groups');
		
		var data = {};
		
		for (var i in spyStrings) {
			data[i] = -1;
			re = re.replace(spyStrings[i], i);
		}
		
		if (re.indexOf(groups['fleet']) != -1) 
			for (var i = 0, len = database.fleet.length; i < len; i++) 
				data[database.fleet[i]] = 0;
		if (re.indexOf(groups['defense']) != -1) 
			for (var i = 0, len = database.defense.length; i < len; i++) 
				data[database.defense[i]] = 0;
		if (re.indexOf(groups['researchs']) != -1) 
			for (var i = 0, len = database.researchs.length; i < len; i++) 
				data[database.researchs[i]] = 0;
		if (re.indexOf(groups['buildings']) != -1) 
			for (var i = 0, len = database.buildings.length; i < len; i++) 
				data[database.buildings[i]] = 0;
		
		re = re.replace(groups['fleet'] + '\n', '')
				.replace(groups['defense'] + '\n', '')
				.replace(groups['researchs'] + '\n', '')
				.replace(groups['buildings'] + '\n', '')
				.split('\n');
		
		for (var i = 9, max = re.length - 1; i < max; i += 2) 
			data[re[i]] = re[i + 1].replace(/\.+/g, '');
		
		var header = new RegExp(this.l('spy header regexp'), 'g').exec(re[0]);
		
		data.metal = re[2].cleanPoints();
		data.cristal = re[4].cleanPoints();
		data.deuterium = re[6].cleanPoints();
		data.energie = re[8].cleanPoints();
		
		Xdump(data);
		
		var parsedData = [];
		for (var i in data) parsedData.push(i+':'+data[i]);
		parsedData = parsedData.join(':');
		
		return {
			content: parsedData,
			planetName: header[1],
			playerName: header[3],
			coords: header[2],
			proba: re[re.length - 1].match(/[0-9.]+/g)[0].replace(/\.+/g, ''),
			moon: (header[1] == this.l('moon').toLowerCase() || header[1].indexOf('('+this.l('moon')+')') != -1 ? true : false)
		};
	}
}


// Enregistrements
if (typeof Xoptions == 'undefined') { // Ne pas enregistrer plusieurs fois
	Xtense.registerPageLoad(Xogame.onPageLoad, Xogame);
	Xtense.registerPageDetect(Xogame.getUniverse, Xogame);
}
