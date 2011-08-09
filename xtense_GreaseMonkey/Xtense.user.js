// ==UserScript==
// @name		Xtense
// @version     2.4.0
// @namespace	xtense.ogsteam.fr
// @include     http://*.ogame.*/game/index.php*
// @description Cette extensions permet d'envoyer des données d'Ogame à votre serveur OGSPY d'alliance
// ==/UserScript==

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
	
if(isChrome){
	function GM_getValue(key,defaultVal){
		key=cookie+"-"+key;
		var retValue = localStorage.getItem(key);
		if ( !retValue ) return defaultVal;
		return retValue;
	}
	function GM_setValue(key,value){ key=cookie+"-"+key; localStorage.setItem(key, value);}
	function GM_deleteValue(value){ key=cookie+"-"+key; localStorage.removeItem(value);}
	function log(message){ console.log(nomScript+" says : "+message);}
}
	


// Ajout du Menu Options
if (document.getElementById('playerName')){
	var icone = 'data:image/gif;base64,R0lGODlhJgAdAMZ8AAAAABwgJTU4OhwhJRYaHjQ3OQcICjM2OA8SFQoMDxsgJB0hJjI1Nw8TFQcICAQEBDE0NgwPEAECAiYoKREVGB8lKi4yNCMlJgoNDzAzNiMnKzE0NxATFgsNECwuMAEBASotMB4iJyImKg8SFg4PDw8QESEjJQICAiAkKRgZGhsdHhUWFwoLCwoMDjI2OBcbHxsgIw0PEhsfIx8jJywvMh8hIhobHB8kKQkMDQYICQoNECwwMxcZGQsOER0iJygrLxweHysuMSUoLAkLDiQnKwwPESElKTM2NyAiIwcKCyAjJxoeISIlKiIkJRIWGRQWFiosLSUnKDAzNBscHRoeIgMEBDAyNA4ODyAkKAcICQkKCwwQEiMnKhwgJBIVGRAQEScqLiosLgcJCgcJCzQ2OAQEBQgICAkJCiksMCQmJwYHCSAjKC0vMQYGBh4jJyUpLSksLRAUFygsLzM2OSsuLyotMQwNDTAzNS4xMiwvMAkJDAkLDf///////////////yH5BAEAAH8ALAAAAAAmAB0AAAf+gH+CFQOFhoeIiRWCjI2ON4cBkpKIlIgVMI6af4SFk5+gk5UwBJuNBIahqqs+paaCBKuyoG4BA66vBFSgAr2+k74CnwoBuKaxkz7AvZ9rAcyTCgrGm8iq0Mug0tSa1qG/ktiTXbevsDKfC5/YwqvcjgTosszt7uZ/BN7f4Kov741i8gkcKLAXwYNZ7gFYyLAhQ18OIyqM6DCYAIoMJ2JceBFAr40ANGLs6PEjRpERTXJUyVBCSHMbWa48CZOizJUkG6IsGaxhT4k1I7oESXHnwqFEHd7LAUBN0qT3huDYI3VMEgNYs27EmkOLnnt/tsQoUqRHh7MY0iZY24KtDh0gAHpEmAtWkBMvceJw2NsAQV+/IwALpkChruHDiBPXDQQAOw==';
			
	var aff_option ='<li><span class="menu_icon"><a href="http://board.ogsteam.fr" target="blank_" ><img class="mouseSwitch" src="'+icone+'" height="29" width="38"></span><a class="menubutton " href="'+url+'&xtense=Options" accesskey="" target="_self">';
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
var reg = new RegExp(/(galaxy|overview)/);
if((! reg.test(url)) || (new RegExp(/xtense=Options/)).test(url)){		
	if(url.indexOf('xtense=Options',0) >= 0){
		if(isChrome){	
			var options = '<div style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;"><br/><br/>';
			// Serveur Univers
			options+= '<img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png" alt="Options Xtense"/>';
			options+= '<br/><br/>';
			options+= '<table>' +
					  '<colgroup><col width="25%"/><col width="25%"/><col width="25%"/><col width="25%"/></colgroup>' +
					  '<tbody>' +
					  '<tr>' +
					  '<td><a onclick="displayOption(\'Xtense_serveurs\')"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/server.png"/><span style="font-size: 20px;"><b>&#160;Serveur</b></span></a></td>' +
					  '<td><a onclick="displayOption(\'Xtense_pages\')"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/pages.png"/><span style="font-size: 20px;"><b>&#160;Pages</b></span></a></td>' +
					  '<td>&#160;</td>' +
					  '<td>&#160;</td>' +
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
			options+= '<td class="value"><input class="speed" id="server1.url.plugin" value="'+GM_getValue('server1.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Utilisateur</label></td>';
			options+= '<td class="value"><input class="speed" id="server1.user" value="'+GM_getValue('server1.user','utilisateur')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Mot de passe</label></td>';
			options+= '<td class="value"><input class="speed" type="password" id="server1.pwd" value="'+GM_getValue('server1.pwd','mot de passe')+'" size="35" alt="24" type="text"/></td>';
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
			options+= '<td class="champ"><label class="styled textBeefy">URL OGSpy</label></td>';
			options+= '<td class="value"><input class="speed" id="server1.url.plugin" value="'+GM_getValue('server1.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
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
			script.setAttribute('src',"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/functions.js");
			escriptopt.appendChild(script);
			
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
						
			document.getElementById("Xtense_serveurs").style.display="block";
			document.getElementById("Xtense_pages").style.display="none";
			
			function enregistreOptionsXtense(){
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
				var inputOptions = Xpath.getOrderedSnapshotNodes(document, "//table[@id='Xtense_table']//input");
				if(inputOptions.snapshotLength > 0){
					//console.log("Xtense says : inputOptions.snapshotLength="+inputOptions.snapshotLength);
				   	for(var i=0;i<inputOptions.snapshotLength;i++){
				   		var input = inputOptions.snapshotItem(i);
				   		GM_setValue(nomScript+'-'+input.id , input.value);
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

// Page Galaxy
var reg = new RegExp(/(galaxy)/);
if((! reg.test(url))){
	log("Page galaxie !");
}

if(isChrome){
	// converti un nombre de la forme xxx.xxx.xxx en xxxxxxxxx
	function parseNB(monText){
	  return (monText.replace(/\./g,""));  
	}
		
	//**********************
	//** Fonctions Xtense **
	//**********************
	var Xservers = {
		/**
		* Liste des serveurs OGSpy pour la page courante de Ogame
		*/
		list:[],
		
		/**
		* Verification si la page de ogame correspond a un serveur
		* @return {boolean}
		*/
		check: function (univers)
		{
			this.list =[];
			this.each(function (server)
			{
				if (server.active && server.univers == univers) this.list.push(server);
			},
			this);
			return this.list.length != 0;
		},
		
		/**
		* Parcours les serveurs disponibles avec une fonction
		* @param {Function} callback
		* @param {Object} scope
		*/
		each: function (callback, scope)
		{
			var server = null;
			for (var i = 0, server = null; i < 5 && !(server = new ServerItem(i)).empty();
			i++)
			{
				callback.apply(scope,[server]);
			}
		}
	}
	
	function ServerItem(n)
	{
		this.save = function ()
		{
			Xprefs.setChar('server' + this.n, '({univers: "' + this.univers + '", url: "' + this.url + '", user: "' + this.user + '", password: "' + this.password + '", hash: "' + MD5(SHA1(this.password)) + '", active: ' + this.active + '})');
			Xprefs.setChar('server-cache' + this.n, '({name: "' + this.name + '", version: "' + this.version + '"})');
		}
		
		this.load = function ()
		{
			var data = eval(Xprefs.getChar('server' + n));
			if (data)
			{
				_empty = false;
				for (var i in data) this[i] = data[i];
				var cachedData = eval(Xprefs.getChar('server-cache' + n));
				for (var i in cachedData) this[i] = cachedData[i];
			}
		}
		
		this.equals = function (data)
		{
			for (var i in data)
			{
				if (data[i] != this[i] && i != 'active') return false;
			}
			return true;
		}
		
		this.cached = function ()
		{
			return this.name != '' && this.version != '';
		}
		
		this.clear = function ()
		{
			for (var i = 0, props =[ 'univers', 'url', 'user', 'password', 'hash', 'active', 'name', 'version'], len = props.length; i < len; i++)
			{
				delete this[props[i]];
			}
			Xprefs.setChar('server' + this.n, '');
		}
		
		this.empty = function ()
		{
			return _empty;
		}
		
		this.set = function (name, value)
		{
			if (value) this[name] = value; else
			{
				for (var i in name) this[i] = name[i];
			}
		}
		
		this.n = n;
		var _empty = true;
		this.load();
	}
	
	
	function Request(Tab, callback, scope)
	{
		this.send = function (servers)
		{
			if (! servers) servers = Xservers.list;
			
			for (var i = 0, len = servers.length; i < len; i++)
			{
				var server = servers[i];
				var postData = 'toolbar_version=' + Xtense.VERSION + '&mod_min_version=' + Xtense.PLUGIN_REQUIRED + '&user=' + server.user + '&password=' + server.hash + '&univers=' + server.univers + this.serializeData();
				
				if (Xprefs.getBool('spy-debug')) postData += '&spy_debug=1';
				if (Xprefs.getBool('dev')) postData += '&dev=1';
				Xconsole("sending " + postData + " to " + server.url + " from " + server.univers);
				new Xajax(
				{
					url: server.url,
					post: postData,
					callback: this.call,
					scope: this,
					args:[server]
				});
				
				this.postedData[server.n] = postData;
				this.loading[server.n] = true;
			}
		}
		
		this.call = function (Server, Response)
		{
			this.loading[Server.n] = false;
			this.callback.apply(this.scope,[ this, Server, Response]);
		}
		
		this.set = function (name, value){
			if (typeof name == 'string') this.data[name] = value; else {
				for (var n = 0, len = arguments.length; n < len; n++){
					for (var i in arguments[n]) this.data[i] = arguments[n][i];
				}
			}
		}
		
		this.serializeObject = function (obj, parent, tab){
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
		}
		
		this.serializeData = function (){
			var uri = '';
			var tab =[];
			this.serializeObject(this.data, '', tab);
			uri = '&' + tab.join('&');
			return uri;
		}
		
		this.postedData =[];
		this.callback = callback;
		this.scole = scope;
		this.loading = {};
		this.data = {};
		this.Tab = Tab;
	}
}