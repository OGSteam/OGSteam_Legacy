/**
 * @author Unibozu
 * @license GNU/GPL
 */

var boolPrefs = ['autostart', 'debug', 'dev', 'handle-overview', 'handle-system', 'handle-buildings', 'handle-researchs', 'handle-defense',
'handle-fleet', 'handle-ranking', 'handle-messages', 'handle-ally_list', 'msg-spy', 'msg-expeditions','msg-ennemy_spy', 'msg-rc_cdr','msg-rc',
'msg-msg', 'msg-ally_msg', 'log-display-time', 'log-hide_psw', 'fixpopups', 'autohide', 'context-menu', 'display-execution-time'];

var Xtense = XgetMainInstance();

window.on('load', function() {	
	$('dev').onclick = function () {
			if (this.checked && !confirm(Xl('onclick dev'))) this.checked = false;
	}
	Xoptions.init();
});

var Xoptions = {
	pageDetectHooks: [],
	
	init: function () {
		try {
			//TODO à améliorer (placer dans l'opener ?)
			if(typeof window.arguments!='undefined')
			if(typeof window.arguments[0]!='undefined')
			if (window.arguments[0]) {
				window.opener.close();
			}
			
			/*if (!Xprefs.getBool('dev')) $('eval_box').style.display = 'none';*/
			document.title = Xl('title', Xtense.getVersion());
			
			Xservers.each(function(server){
				$('univers'+server.n).value 	= server.univers;
				$('url'+server.n).value			= server.url;
				$('username'+server.n).value	= server.user;
				$('password'+server.n).value	= server.password;
				$('active'+server.n).checked	= server.active ? true : false;
			});
			
			var len = boolPrefs.length;
			for (i = 0; i < len; i++) {
				$(boolPrefs[i]).checked = Xprefs.getBool(boolPrefs[i],true);
			}
			
			//$('log-max-size').value = Xprefs.getInt('log-max-size');
			$('log-time-format').selectedIndex = Xprefs.getInt('log-time-format');
			
			window.sizeToContent();
		} catch(e) {
			show_backtrace(e);
			//Xconsole('erreur'+boolPrefs[i]+' '+i);
		}
	},
	
	save: function() {
		try {
			var toCheck = [];
			
			for (i = 0; i < 5; i++) {
				var Server = new ServerItem(i);
				var univers 	= $('univers'+i).value.trim();
				var url 		= $('url'+i).value.trim();
				var user 		= $('username'+i).value.trim();
				var password 	= $('password'+i).value.trim();
				
				if (univers != '' || url != '' || user != '' || password != '') {
					if (univers != '' && url != '' && user != '' && password != '') {
						//if (!univers.match(new RegExp('^http://uni[0-9]{1,2}\.ogame\.[A-Z]{1,4}$', 'gi'))) {
						/*var isOgame = Xogame.getUniverse(univers);
						var isEUnivers = XEUnivers.getUniverse(univers);*/
						var handlingParser = Xtense.checkDomain(univers);
						if(!handlingParser) {
							return !confirm(Xl('save wrong universe', i+1) + Xl('save end'));
						}
						if (!user.match(/^[\w\s-]{3,15}$/g)) {
							return !confirm(Xl('save wrong user', i+1) + Xl('save end'));
						}
						if (!password.match(/^[\w\s-]{6,15}$/g)) {
							return !confirm(Xl('save wrong password', i+1) + Xl('save end'));
						}
						if (!url.match(new RegExp('xtense\.php$', 'gi'))) {
							if (url.match(new RegExp('xtense_plugin\.php$', 'gi'))) return !confirm(Xl('save wrong url old', i+1) + Xl('save end'));
							return !confirm(Xl('save wrong url', i+1) + Xl('save end'));
						}
						
						// Verification du support du parsing de la langue
						var lang = univers.substring(univers.lastIndexOf('.')+1).toLowerCase();
						//Xconsole(handlingParser.getUniverse);
						if(handlingParser.getLang)
							lang = handlingParser.getLang(univers);
						//Xconsole(handlingParser.getUniverse);
						//alert(handlingParser.locale);
						if (typeof handlingParser.locales[lang] == 'undefined') {
							return !confirm(Xl('save unavailable parser', i+1, lang) + Xl('save end'));
						}
						
						var newData = {
							univers: univers,
							url: url,
							user: user,
							password: password,
							active: $('active' + i).checked ? 1 : 0
						};
						
						if (!Server.equals(newData) || $('force'+i).checked) {
							toCheck.push(Server.n);
						}
						
						Server.set(newData);
						Server.save();
					} else {
						return !confirm(Xl('save fill', i) + Xl('save end'));
					}
				} else {
					Server.clear();
				}
			}
			
			// Sauvegarde des checkbox
			for (var i = 0, len = boolPrefs.length; i < len; i++) {
				Xprefs.setBool(boolPrefs[i], $(boolPrefs[i]).checked);
			}
			
			Xprefs.setInt('log-time-format', $('log-time-format').selectedIndex);
			Xprefs.setInt('log-max-size', parseInt($('log-max-size').value) < 10 ? 10 : parseInt($('log-max-size').value));
			
			// Si il y a eu des modifications, ouverture de la fenetre de verifs
			if (toCheck.length != 0) {
				window.openDialog('chrome://xtense2/content/ui/servers_check.xul', 'servers_check', 'centerscreen, resizable', 
				{servers: toCheck, Xprefs: Xprefs});
			}
			
			if (boolPrefs['dev']) {
				document.getElementById('xtense-dev-utils').set('style', 'display:block;');
				//toJavaScriptConsole();
			}
			
			return true;
		} catch (e) {
			show_backtrace(e);
		}
		return true;
	},
	
	lineReset: function (n) {
		$('active'+n).checked = true;
		$('univers'+n).value = '';
		$('url'+n).value = '';
		$('username'+n).value = '';
		$('password'+n).value = '';
	},
	
	validate: function() {
		/*if(false)//$('xtense').acceptDialog)
			$('xtense').acceptDialog();
		else {*/
		var test = this.save();
		//Xconsole('t'+test);
		if(test)
			window.close();
		
	}	
}

function open_link(uri) {
	var Browser = window.opener.getBrowser();
	Browser.selectedTab = Browser.addTab(uri);
	window.close();
}
