/**
 * @author Unibozu
 * @author OGSteam
 * @license GNU/GPL
 */

window.on('load', function () {
	$('xtense-activate')		.on('command', function(){ Xtense.activate(); });
	$('xtense-send')			.on('command', function(){ Xtoolbar.sendClick(); });
	$('xtense-log')				.on('command', function(){ Xtoolbar.openLog(); });
	$('xtense-options')			.on('command', function(){ Xopen_prefs(); });
	$('xtense-ogspy-menu')		.on('popupshowing', 	function(){ Xtoolbar.showOgspyMenu(); });
	
	if (Xprefs.getBool('dev')) {
		$('xtense-dev-utils').set('style', 'display:block;');
		//toJavaScriptConsole();
	}
});

var Xtoolbar = {
	ogspyConnect : function (id) {
		var server = eval(Xprefs.getChar('server'+id));
		var n = -1;
		var url = server.url.substr(0, ((n = server.url.indexOf('mod/xtense/xtense.php')) == -1 ? server.url.indexOf('xtense.php') : n));
		var dataString = 'action=login_web&login='+server.user+'&password='+server.password;
		var stringStream = Cc['@mozilla.org/io/string-input-stream;1'].createInstance(Ci.nsIStringInputStream);
		if ('data' in stringStream) stringStream.data = dataString;
		else 						stringStream.setData(dataString, dataString.length);
		
		var postData = Cc['@mozilla.org/network/mime-input-stream;1'].createInstance(Ci.nsIMIMEInputStream);
		postData.addHeader('Content-Type', 'application/x-www-form-urlencoded');
		postData.addContentLength = true;
		postData.setData(stringStream);
		
		Browser.selectedTab = Browser.addTab(url, null, null, postData);
	},
	
	ogspyConnectGalaxy : function (url_univers,g,s) {
		var server=null;
		for(var i = 0 ; i < 5 ; i++){
			server = eval(Xprefs.getChar('server'+i));
			if(server.univers==url_univers){
				 break;
			} else {
				server=null;
			}
		}
		if(server!=null){
			var n = -1;
			var url = server.url.substr(0, ((n = server.url.indexOf('mod/xtense/xtense.php')) == -1 ? server.url.indexOf('xtense.php') : n));
			var dataString = 'action=login_web&login='+server.user+'&password='+server.password+"&goto=galaxy&galaxy="+g+"&system="+s;
			var stringStream = Cc['@mozilla.org/io/string-input-stream;1'].createInstance(Ci.nsIStringInputStream);
			if ('data' in stringStream) stringStream.data = dataString;
			else 						stringStream.setData(dataString, dataString.length);
			
			Xconsole(url+"\n"+dataString);
			
			var postData = Cc['@mozilla.org/network/mime-input-stream;1'].createInstance(Ci.nsIMIMEInputStream);
			postData.addHeader('Content-Type', 'application/x-www-form-urlencoded');
			postData.addContentLength = true;
			postData.setData(stringStream);

			Browser.selectedTab = Browser.addTab(url, null, null, postData);
		}
	},
	
	
	ogspyConnect2 : function (id,page) {
		var server = eval(Xprefs.getChar('server'+id));
		var n = -1;
		var url = server.url.substr(0, ((n = server.url.indexOf('mod/Xtense/xtense.php')) == -1 ? server.url.indexOf('xtense.php') : n));
		if(typeof page != 'undefined')
			url+=page;
		//var dataString = 'action=login_web&login='+server.user+'&password='+server.password;
		/*var stringStream = Cc['@mozilla.org/io/string-input-stream;1'].createInstance(Ci.nsIStringInputStream);
		if ('data' in stringStream) stringStream.data = dataString;
		else 						stringStream.setData(dataString, dataString.length);*/
		
		var postData = Cc['@mozilla.org/network/mime-input-stream;1'].createInstance(Ci.nsIMIMEInputStream);
		postData.addHeader('Content-Type', 'application/x-www-form-urlencoded');
		postData.addContentLength = true;
		//postData.setData(stringStream);
		
		Browser.selectedTab = Browser.addTab(url, null, null, postData);
	},
	
	sync : function () {
		try {
			var tab = Xtense.CurrentTab;
			if(typeof tab == 'undefined')return;//http://ogsteam.fr/viewtopic.php?id=5028
			var Status = tab.Status;
			
			$('xtense-status').value = Status.value;
			$('xtense-status').set('class', logClassName[Status.type]);
			//Xconsole("tab.sendAction:"+tab.sendAction);
			$('xtense-send').disabled = !tab.sendAction;
			
			if (Status.extra && Status.extra.calls) {
				var calls = Status.extra.calls;
				//$('xtense-status-icon').src = 'chrome://xtense2/skin/images/calls-'+calls.status+'.png';
				$('xtense-status-icon').set('class', 'icon calls-'+calls.status);
				$('xtense-calls-tooltip').set('style', '');
				
				for (var i = 0, keys = ['success', 'warning', 'error']; i < 3; i++) {
					var type = keys[i];
					if (calls[type].length == 0) {
						$('xtense-calls-'+type).set('style', 'display:none;');
					} else {
						$('xtense-calls-'+type).set('style', '');
						$('xtense-calls-list-'+type).empty();
						
						$('xtense-calls-list-'+type).add(new Xel('label').set('value', calls[type][0]).set('class', type));
						
						for (var t = 1, len = calls[type].length; t < len; t++) {
							$('xtense-calls-list-'+type).add(
								new Xel('label').set('value', ', '),
								new Xel('label').set('value', calls[type][t]).set('class', type)
							);
						}
					}
				}
			} else {
				$('xtense-status-icon').set('class', 'icon info');
				$('xtense-calls-tooltip').set('style', 'display:none;');
			}
			
			//affichage des nouveaux messages d'OGSpy
			if(Xprefs.getBool('display-new-messages')) {
				//var url = '';
				var serverId = 0;
				if(typeof tab.newPMStatus.server != 'undefined' && tab.newPMStatus.server) {
					/*url = tab.newPMStatus.server.url;
					url = url.replace(/mod\/Xtense\/xtense.php/,'').replace(/xtense.php/,'');
					url += 'index.php?action=messages';*/
					serverId = tab.newPMStatus.server.n;
				}
				//Xdump(tab.newPMStatus.server);
				if(tab.newPMStatus.number > 0) {
					//$('xtense-new-messages-icon').set('class', 'icon new-messages');
					$('xtense-new-messages-hbox').set('class', 'new-messages');
					$('xtense-new-messages-status').set('value', tab.newPMStatus.number /*+ Xl('PM')*/);
					/*if(serverId>0) $('xtense-new-messages-icon').set('oncommand','Xtoolbar.ogspyConnect2('+serverId+',"index.php?action=mp")');
					else $('xtense-new-messages-icon').set('oncommand','');*/
					
				} else {
					//$('xtense-new-messages-icon').set('class', 'icon no-new-message');
					$('xtense-new-messages-hbox').set('class', 'no-new-message');
					$('xtense-new-messages-status').set('value', 0 /*+ Xl('PM')*/);
					/*if(serverId>0) $('xtense-new-messages-icon').set('oncommand','Xtoolbar.ogspyConnect2('+serverId+',"index.php?action=mp")');
					else $('xtense-new-messages-icon').set('oncommand','');*/
				}
				if(serverId>0) $('xtense-new-messages-icon').set('oncommand','Xtoolbar.ogspyConnect2('+serverId+',"index.php?action=mp")');
				else $('xtense-new-messages-icon').set('oncommand','');
			}
			
		} catch (e) { /*throw_error(e); */ //ne pas essayer d'afficher l'erreur dans la barre, sinon récursion infinie
			Xdump(e);
		}
	},
	
	sendClick: function() {
		var Tab = Xtense.CurrentTab;
		if (!Tab.sendAction) return;
		var args = Tab.sendAction.args;
		args.unshift('command');
		Tab.sendAction.fn.apply(Tab.sendAction.scope, args);
		Tab.removeAction();
	},
	
	openLog : function () {
		Xtense.logWindow = window.openDialog('chrome://xtense2/content/ui/log.xul', 'statuslog', 'resizable, centerscreen');
	},
	
	showOgspyMenu : function () {
		var menu = $('xtense-ogspy-menu').empty();
		
		Xservers.each(function(server){
			var row = new Xel('menuitem').set({
				id: 'fastaccess-' + server.n,
				idx: server.n,
				//label: (server.cached() ? server.name + ': ' : '') + server.url.match(/^https?:\/\/[^\/]*\/[^\/]*\//gi)[0],
				label: (server.cached() ? server.name : server.url.match(/^https?:\/\/[^\/]*\/[^\/]*\//gi)[0]),
				tooltiptext: Xl('ogspy menu tooltip')
			});
			row.on('click', function(){
				Xtoolbar.ogspyConnect(this.get('idx'));
			});
			menu.add(row);
		});
		
		if (menu.childNodes.length == 0) menu.add(new Xel('menuitem').set('label', Xl('no ogspy server')).set('disabled', 'true'));
	},
	
	show : function () {
		//var win = Cc["@mozilla.org/appshell/window-mediator;1"].getService(Ci.nsIWindowMediator).getMostRecentWindow("navigator:browser");
		//win.toolbar.visible = true;
		window.toolbar.visible = true;
	},
	
	copyStatus: function() {
		Xclipboard(Xtense.CurrentTab.Status.value);
	},
	
	checkAutohide: function(docUrl){
		$('xtense-toolbar').hidden = false;
		
		if (Xprefs.getBool('autohide')) {
			$('xtense-toolbar').hidden = true;

			/*for (var i = 0, len = Xtense.noAutohideRegs.length; i < len; i++) {
				Xdump('Reg ['+i+']; "'+Xtense.noAutohideRegs[i]+'" > '+ docUrl.match(Xtense.noAutohideRegs[i]));
				if (docUrl.match(Xtense.noAutohideRegs[i])) {
					$('xtense-toolbar').hidden = false;
					return;
				}
			}*/
			//Xconsole(Xogame.isHandled(docUrl));
			if(Xtense.checkDomain(docUrl))
				$('xtense-toolbar').hidden = false;	
		}
	}
};

