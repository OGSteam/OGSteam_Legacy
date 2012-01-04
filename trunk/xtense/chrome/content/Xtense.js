/**
 * @author Unibozu
 * @license GNU/GPL
 */

/* Links
 * http://greasemonkey.devjavu.com/Browser/trunk/src/components/greasemonkey.js
 * http://code.google.com/p/fbug/source/browse/branches/firebug1.2/content/firebug/commandLine.js
*/

var Browser = null;//getBrowser();

window.on('load', function(){
	try{
		Browser = getBrowser();
		Browser.tabContainer.on('TabOpen', function(e){ Xtense.tabOpen(e); });
		Browser.tabContainer.on('TabSelect', function(){ Xtense.tabSelect(); });
		//$('appcontent').on('DOMContentLoaded', function(e){ Xtense.onPageLoad(e); });
		Browser.on('DOMContentLoaded', function(e){ Xtense.onPageLoad(e); });
		
		$('xtense-menu-options').on('command', function(){
			Xtense.clickAutohideMenu();
		});
		
		$('contentAreaContextMenu').on('popupshowing', function(e) { Xtense.showContextMenu(e); });
		
		window.removeEventListener("load", arguments.callee, false); 
		}
	catch(e){
			throw_error(e);
			}
});

var Xtense = {
	VERSION: '2.3.15',
	REVISION: 0,
	PLUGIN_REQUIRED: '2.3.10',
	
	active: false,
	CurrentTab: null,
	XtabInstances: 0,
	
	pageLoadHooks: [],
	pageDetectHooks: [],
	noAutohideRegs: [],
	
	logOpen: false,
	logWindow: null,
	
	//docXML : null,
	initialized:false,
	
	init: function(){
		try {
			if (Xprefs.getBool('autostart')) 
				this.activate(true);
			this.update();
		} 
		catch (e) {
			throw_error(e);
		}
	},
	
	activate: function(init){
		if (!this.active) {
			this.active = true;
			$('xtense-activate').set('label', Xl('deactivate')).set('class', 'disable');
			//if (!init) 
				this.CurrentTab.setStatus(Xl('toolbar activated'));
		}
		else {
			this.active = false;
			$('xtense-activate').set('label', Xl('activate')).set('class', 'enable');
			//if (!init) 
				this.CurrentTab.setStatus(Xl('toolbar deactivated'));
		}
	},
	
	/*registerNoAutohidePage: function (Reg) {
		this.noAutohideRegs.push(Reg);
		return this.noAutohideRegs.length - 1;
	},*/
	
	checkDomain: function(url) {
	//Xconsole('this.pageDetectHooks.length:'+this.pageDetectHooks.length+' url'+url);
		for(var i in this.pageDetectHooks) {
				if(this.pageDetectHooks[i].fn.apply(this.pageDetectHooks[i].scope,[url]) != false) {
					//Xconsole(this.pageDetectHooks[i].fn.apply(this.pageDetectHooks[i].scope,[url])+' | '+this.pageDetectHooks[i].scope.getUniverse);
					return this.pageDetectHooks[i].scope;
				}
			}
		return false;
	},
	
	registerPageDetect: function(fn, scope) {
		//Xconsole(fn+" "+scope+" "+this.pageDetectHooks.length);
		this.pageDetectHooks.push({
			fn: fn,
			scope: scope,
			active: true
		});
		return this.pageDetectHooks.length - 1;
	},
	
	registerPageLoad: function(fn, scope) {
		this.pageLoadHooks.push({
			fn: fn,
			scope: scope,
			active: true
		});
		return this.pageLoadHooks.length - 1;
	},
	
	unregisterPageLoad: function(n) {
		this.pageLoadHooks[n].active = false;
	},
	
	onPageLoad: function(e){
		try {
			if (!this.CurrentTab) 
				this.CurrentTab = Browser.selectedTab.Xtab = new Xtab();
			if(!this.initialized)
				{
				Xtense.init();
				this.initialized=true;
				}
			if (!this.active) 
				return;
			
			var doc = e.originalTarget;
			//this.docXML=e.originalTarget;
			
			//var win = e.originalTarget.defaultView;
			
			/*from stogame*/
		    var unsafeWin=doc.defaultView;
	        if (unsafeWin.wrappedJSObject)
	        {
		        unsafeWin=unsafeWin.wrappedJSObject;
	        }
	        /*end of stogame quote*/
	        
			var url = null;
			try {
				url = doc.location.href;
			}
			catch (e) {}
			
			if (url == null)
				return;
			if (url == 'about:blank' || url.match('delivery.ads.gfsrv.net') || !url) //delivery.ads.gfsrv.net -> Pub sur le côté
				return;
			
			if(typeof doc.defaultView.top == 'undefined')return;//TODO comprendre comment ça peut arriver
			var tabIndex = Browser.getBrowserIndexForDocument(doc.defaultView.top.document);
			if (tabIndex < 0)
				return;
			var Tab = Browser.tabContainer.childNodes[tabIndex].Xtab;
			//Xconsole(doc.location.href+' '+Tab+' '+Browser.tabContainer.childNodes[tabIndex]);
			if(typeof Tab == 'undefined')return;//http://board.ogsteam.fr/viewtopic.php?id=5028
			var status = false;
			
			Xtoolbar.checkAutohide(doc.defaultView.top.document.location.href);
			
			for (var i = 0, len = this.pageLoadHooks.length; i < len; i++) {
				var Hook = this.pageLoadHooks[i];
				//var s = false;
				if (Hook.active) {
					//s = Hook.fn.apply(Hook.scope, [doc, url, Tab]);
					//Xconsole(s+' | '+url+' | '+Hook.scope.getUniverse);
					//status |= s;
					status |= Hook.fn.apply(Hook.scope, [doc, url, Tab,unsafeWin]);
				}
			}
			
			// Si aucun message n'a été affiché au statut
			if (!status) {
				//if (!Tab.lastEntryUnknow) {
					Tab.setStatus(Xl('unknow page'), XLOG_NORMAL, {url: url});
				//	Tab.lastEntryUnknow = true;
				//}
					Tab.removeAction();//on ne désactive le bouton que si aucun parser n'est activé
			}
		}
		catch (e) {
			throw_error(e);
		}
	},
	
	update: function(){
		// Mise à jour
		var old_revision = parseInt(Xprefs.getChar('previous-revision'));
		if (old_revision != this.REVISION) {
			
			// 2.0b7
			if (old_revision < 1) {
				// Build 1 : rajout de l'activation des serveurs
				for (var i = 0; i < 5; i++) {
					var str = Xprefs.getChar('server' + i);
					if (str != '') {
						var server = eval(str);
						Xprefs.setChar('server' + i, '({univers: "' + server.univers + '", url: "' + server.url + '", user: "' + server.user + '", password: "' + server.password + '", hash: "' + server.hash + '", active: 1})');
					}
				}
				
				old_revision = 1;
			}
			
			Xprefs.setChar('previous-revision', this.REVISION);
		}
	},
	
	tabOpen: function(e){
		var tab = e.target;
		tab.Xtab = new Xtab();
	},
	
	tabSelect: function(){
		var tab = Browser.selectedTab;
		var doc = Browser.selectedBrowser.contentDocument;
		this.CurrentTab = tab.Xtab;
		
		Xtoolbar.sync();
		Xtoolbar.checkAutohide(doc.location.href);
		
		if (this.logOpen) {
			this.logWindow.Log.init();
		}
	},
	
	showContextMenu: function(event){
		try {
			//if (event.target.id != 'contentAreaContextMenu') 
			//	return;
			
			if (Xprefs.getBool('context-menu')) {
				$('xtense-menu-separator').set('hidden', 'false');
				$('xtense-menu-options').set('hidden', 'false');
				//Xopen_prefs(false);
				//$('xtense-menu-autohide').set('checked', Xprefs.getBool('autohide'));
			}
			else {
				$('xtense-menu-separator').set('hidden', 'true');
				$('xtense-menu-options').set('hidden', 'true');
			}
			return;
		} 
		catch (e) {
			throw_error(e);
		}
	},
	
	clickAutohideMenu: function(e){
		try {
			Xprefs.setBool('autohide', !Xprefs.getBool('autohide'));
			Xtoolbar.checkAutohide(Browser.selectedBrowser.contentDocument.location.href);
		} 
		catch (e) {
			throw_error(e);
		}
	},
	
	getVersion : function() {
		try {
			return Components.classes["@mozilla.org/extensions/manager;1"].getService(Components.interfaces.nsIExtensionManager).getItemForID("xtense2@ogsteam.fr").version;
		}catch(e) {
			return this.VERSION;
		}
	}	
}
Xtense.VERSION = Xtense.getVersion();

function Xtab () {
	this.setStatus = function (text, type, extra) {
		this.Status = {type: type || XLOG_NORMAL, value: text, extra: extra || {}};
		this.lastEntryUnknow = false;
		//this.addLog(text, type, extra);
		this.addLog(this.Status);
		Xtoolbar.sync();
	}
	
	this.setNewPMStatus = function (number,server) {
		this.newPMStatus = {number:number, server:server};
		//Xdump(server);
	}
	
	this.addLog = function (obj) {
		obj.Date = new Date();
		this.log.push(obj);
		
		var maxSize = Xprefs.getInt('log-max-size');
		if (maxSize != 0 && this.log.length > maxSize) {
			var delta = this.log.length - maxSize;
			this.log = this.log.slice(delta);
			if (Xtense.logOpen) {
				var currentExtra = Xtense.logWindow.Log.currentExtra;
				currentExtra = (currentExtra - delta < 0 ? 0 : currentExtra - delta);
			}
		}
		
		if (Xtense.logOpen) {
			Xtense.logWindow.Log.init();
		}
	}
	
	this.setSendAction = function (fn, scope, args) {
		this.sendAction = {
			fn: fn, scope: scope, args: args || []
		};
	}
	
	this.removeAction = function () {
		this.sendAction = null;
		Xtoolbar.sync();
	}
	
	this.lastEntryUnknow = false;
	this.log = [];
	this.Status = {type: XLOG_NORMAL, value: '-', extra: {}};
	this.newPMStatus = {number: 0, server:null };
	this.callback = [];
	this.sendAction = null;
	this.instance = Xtense.XtabInstances++;
}