//Ce fichier contient diverses petites fonctions pouvant être appellées aussi bien par le coeur, que modules ou que la fenêtre d'options

/*ufLog and ufDir doesnt belong to the object UFUtils 
because their short name is meant to be used by developpers*/
const UFErrorReportingLevels = {
	NONE : 0,//aucune erreur n'est loguée
	LOG_ERRORS : 1,
	DISPLAY_ERRORS : 2,
	ALERT_ERRORS : 4
}

const UFDebugLevels = {
	NONE : 0,
	ERROR : 1,
	WARNING : 2,
	NOTICE : 4,
	MESSAGE : 8,
	ALL : 15
}

const UFLog = {
	NONE : 0,
	ERROR : 1,
	WARNING : 2,
	NOTICE : 4,
	MESSAGE : 8,
	ALL : 15
}
/**
* Writes a message to the console
* @param message: string, the message to be writen
* @param level: UFLog, importance of the message
*/
function ufLog(message,level)
{
	if(typeof level == "undefined")
	{
		//var service =Components.classes["@mozilla.org/consoleservice;1"].getService(Components.interfaces.nsIConsoleService);
		//service.logStringMessage(UFUtils.extensionFullName + " : \n" + message);
		UFUtils.consoleService.logStringMessage(UFUtils.extensionFullName + " : \n" + message);
	}
	else 
	{
		var debug = UFUtils.getPref("LogLevel", UFLog.ERROR);
		var common = debug&level;
		if(common > UFLog.NONE)
		{
			var type = "";
			if((common&UFLog.ERROR) == UFLog.ERROR)
				type = "error";
			if((common&UFLog.WARNING) == UFLog.WARNING)
				type = "warning";
			if((common&UFLog.NOTICE) == UFLog.NOTICE)
				type = "notice";
			if((common&UFLog.MESSAGE) == UFLog.MESSAGE)
				type = "message";
			UFUtils.consoleService.logStringMessage(UFUtils.extensionFullName + " :("+type+")\n" + message);
		}
	}
}
/**
* Writes all properties of the given objects to the console
* @params: as many optional objects as you want
*/
function ufOldDir()
{
	if(arguments.length > 0)
	for (var i = 0; i < arguments.length ; i++) 
	{
		if(arguments[i])
			ufLog(UFUtils.getPropertyList(arguments[i]));
		else ufLog("argument "+i+" is invalid for listing");
    }
}
/**
* Writes all properties of the given objects to the console
* @param object: object,
* @param args
*/
function ufDir(object,args)
{
	ufLog(UFUtils.getPropertyList(object,args));
}

/**
* Objet regroupant les utilitaires
*/
var UFUtils = {
	/**
	*
	* @param time: int, the time in milliseconds
	*/
	formatDate : function (time) {
		var str = "";
		var d = new Date();
		d.setTime(time);
		var month = d.getMonth();
		month = this.addStartingZero(month);
		var days = d.getDate();
		days = this.addStartingZero(days);
		var hours = d.getHours();
		hours = this.addStartingZero(hours);
		var mins = d.getMinutes();
		mins = this.addStartingZero(mins);
		var secs = d.getSeconds();
		secs = this.addStartingZero(secs);
		
		str = days+"/"+month+" "+hours+":"+mins+":"+secs;
		
		return str;
	},
	/**
	*
	* @param time: int, the time in milliseconds
	*/
	formatTimespan : function (time) {
		var str = "";
		var d = new Date();
		d.setTime(time);
		var days = Math.floor(time/(24*3600*1000));
		var hours = d.getHours();
		var mins = d.getMinutes();
		var secs = d.getSeconds();
		if(days > 0)
		{
			str += days+"j ";
		}
		if(time >= 3600*1000)
		{
			str += hours+"h ";
		}
		if(time >= 60*1000)
		{
			/*if(mins < 10)
				mins = "0"+mins;*/
			str += mins+"m ";
		}
		
		/*if(secs < 10)
			secs = "0"+secs;*/
		str += secs+"s";
		
		return str;
	},
	
	stripNotDigit : function (str,withMinus) {
		str = str+'';
		if(typeof withMinus != "undefined" && withMinus==true)
		{
			str = str.replace(/[^0-9-]/g,"");
			if(str[0]=="-")
				str = "-"+str.replace(/\D/g,"");
		}
		else 
			str = str.replace(/\D/g,"");
			
		if(str == "")
			str = 0;
		else
			str = parseInt(str);
		return str;
	},
	
	addStartingZero : function (number) {
		if(number < 10)
			return "0"+number;
		else 
			return number;
	},
	
	addThounsandsSeparator : function (str,separator) {
		if(typeof separator == "undefined")
			separator = ' ';
		if(separator == '') return str;//si il n'y a pas de séparateur, évite les boucles infinies
		if(separator.match(/\d/)) return str;//si il y a un chiffre, évite les boucles infinies
		str += '';
		var rgx = /(\d+)(\d{3})/;
		while (rgx.test(str)) {
			str = str.replace(rgx, '$1' + separator + '$2');
		}
		return str;
	},
	
	/**
	*
	*/
	logError : function(error,message,throwFlag)
	{
		ufLog(message+"\n"+this.getPropertyList(error),UFLog.ERROR);
		if(throwFlag)
			throw error;
	},
	/**
	*
	*/
	catchError : function(error)
	{
		var reportingLevel = this.getPref("ErrorReportingLevel",UFErrorReportingLevels.NONE);
		if((reportingLevel&UFErrorReportingLevels.NONE) == UFErrorReportingLevels.NONE)
		{
			
		}
		if((reportingLevel&UFErrorReportingLevels.LOG_ERRORS) == UFErrorReportingLevels.LOG_ERRORS)
		{
			logError(error,"");
			//ufLog(error,UFLog.ERROR);
		}
		if((reportingLevel&UFErrorReportingLevels.DISPLAY_ERRORS) == UFErrorReportingLevels.DISPLAY_ERRORS)
		{
			//TODO: écrire l'erreur dans la page
		}
		if((reportingLevel&UFErrorReportingLevels.ALERT_ERRORS) == UFErrorReportingLevels.ALERT_ERRORS)
		{
			alert(error);
		}
	},
	
	/**
	* Adds attributes to an object
	* @param object: object, the object to be improved
	* @param implement: object, the attributes to be added
	*/
	implement : function (object, implement) {
		for (var i in implement) object[i] = implement[i];
	},
	
	/* Xpath management	*/
	/**
	* @param doc: document, the read document
	* @param xpath: XPath string
	* @param node: optional Node, the context node, default is the whole document
	* @return: found XPathResult  
	*/
	getNodesFromDoc : function (doc,xpath,node)
	{
		node = node ? node : doc;
		return doc.evaluate(xpath,node,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
	},
	/* End of Xpath management */
	
	/**
	* 
	*/
	ajaxRequest : function(obj) {
		var xhr = new XMLHttpRequest();
		var callback = obj.callback || function(){};
		var args = obj.args || [];
		var scope = obj.scope || null;
		var url = obj.url || '';
		var post = obj.post || '';
		var type = obj.type || 'GET';

		xhr.onreadystatechange =  function() {
			if(xhr.readyState == 4) {
				args.push({status: xhr.status, content: xhr.responseText, rawXMLHttpRequest: xhr});
				callback.apply(scope, args);
			}
		};
		
		xhr.open(type, url, true);
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.send(post);
		return xhr;
	},
	/**
	* 
	*/
	updateRemotePrefsCallback : function(args,response) {
		
		var input = response.content;
		try{
			var value = JSON.parse(input);
		}catch(e){
			this.logError(e,"JSON parse error in updateRemotePrefsCallback (input:,"+input+") : ");
			var value = {};
		}
		
		if(typeof value != "undefined")
		{
			UFUtils.setJSONPref(args.prefName,value);
			ufLog("Updated pref "+args.prefName+", value:\n"+response.content.substr(0,30)+"\n[...]\n"+response.content.substr(response.content.length-30,30)+" (length:"+response.content.length+")",UFLog.MESSAGE);
			var now = new Date();
			now = Math.round(now.getTime()/1000);
			UFUtils.setIntPref("LastUpdate",now);
		}
		else 
		{
			ufLog("Wrong remote value for "+args.prefName+", value:"+response.content,UFLog.ERROR);
		}
		if(args.scope!=false && args.callback!=false)
		{
			args.response = response;
			args.callback.apply(args.scope, [args]);
		}
	},
	/**
	* 
	*/
	updateRemotePrefs : function(args) {
		var scope = false;
		var callback = false;
		if(typeof args != "undefined")
		{
			if(typeof args.scope != "undefined")
				scope = args.scope;
			if(typeof args.callback != "undefined")
				callback = args.callback;
		}
		/*UFUtils.ajaxRequest({
			url: "http://unifox2.free.fr/GameData.json",
			callback: this.updateRemotePrefsCallback,
			scope: this,
			args: [{prefName:"GameData"}]
		});*/
		UFUtils.ajaxRequest({
			url: "http://unifox2.free.fr/ServerData.json?"+Math.random(),//un paramètre aléatoire pour ignorer le cache
			callback: this.updateRemotePrefsCallback,
			scope: this,
			args: [{prefName:"ServerData",scope:scope,callback:callback}]
		});
	},
	
	/**
	* Returns an object containing the list of servers and universes
	*/
	getServerData : function () {
		if(this.serverData==false)
			this.serverData = this.getJSONPref("ServerData",{
							"servers" : {
								0 : {
									"name" : "E-Univers",
									"domain" : "e-univers.org",
									"login" : ["login.e-univers.org","login2.e-univers.org"],
									"index" : 0,
									"universes" : {
										1 : {
											"url" : "beta1.e-univers.org",
											"name" : "Beta 1",
											"index" : 1,
											"indexInLogin" : 1,
											"vortex" : 5,
											"speed" : 10
										},
										3 : {
											"url" : "beta3.e-univers.org",
											"name" : "Beta 3",
											"index" : 3,
											"indexInLogin" : 2,
											"vortex" : 2,
											"speed" : 1
										},
										4 : {
											"url" : "beta4.e-univers.org",
											"name" : "Beta 4",
											"index" : 4,
											"indexInLogin" : 3,
											"vortex" : 4,
											"speed" : 5
										},
										5 : {
											"url" : "beta5.e-univers.org",
											"name" : "Beta 5",
											"index" : 5,
											"indexInLogin" : 4,
											"vortex" : 3,
											"speed" : 10
										},
										6 : {
											"url" : "beta6.e-univers.org",
											"name" : "Beta 6",
											"index" : 6,
											"indexInLogin" : 5,
											"vortex" : 2,
											"speed" : 1
										},
										7 : {
											"url" : "beta7.e-univers.org",
											"name" : "Ultima",
											"index" : 2,
											"indexInLogin" : 6,
											"vortex" : 5,
											"speed" : 10
										},
										8 : {
											"url" : "testing.e-univers.org",
											"name" : "Testing",
											"index" : 7,
											"indexInLogin" : 7,
											"vortex" : 8,
											"speed" : 200
										}
									},
									"missingFromLogin" : [7]
								},
								
								1: {
									"name" : "Projet42",
									"domain" : "projet42.org",
									"login" : ["login.projet42.org"],
									"index" : 1,
									"universes" : {
										1 : {
											"url" : "uni1.projet42.org",
											"name" : "Univers 1",
											"index" : 1,
											"indexInLogin" : 1,
											"vortex" : 2,
											"speed" : 1
										},
										2 : {
											"url" : "uni2.projet42.org",
											"name" : "Univers 2",
											"index" : 2,
											"indexInLogin" : 2,
											"vortex" : 4,
											"speed" : 10
										},
										3 : {
											"url" : "libra.projet42.org",
											"name" : "Univers Libra",
											"index" : 3,
											"indexInLogin" : 4,
											"vortex" : 3,
											"speed" : 10
										}
									},
									"missingFromLogin" : []
								}
							}
						});
		return this.serverData;
	},
	
	/**
	* Returns an object containing all the necessary constants of the game:
	* prices, ships capacity etc...
	*/
	getGameData : function() {
		if(this.gameData == false)
			this.gameData = this.getJSONPref("GameData");
		return this.gameData;
	},
	
	/**
	* 
	*/
	switchEnableUniFox : function() {
		var enabled = this.getPref("UniFoxEnabled",true);
		enabled = !enabled;
		this.setBoolPref("UniFoxEnabled",enabled);
	},
	
	/**
	* Returns a preference value
	* Automaticaly finds its type
	* @param key: string, the preference name
	* @param defval: any type, a default value to be used if the preference is not found
	* @returns the preference value
	*/
	getPref : function(key, defval)
	{	
		var val = defval;
		
		try
		{
			switch(this.userprefsBranch.getPrefType(key) ) // Permet de savoir de quel type de preference il s'agit
			{
				case this.userprefsBranch.PREF_INT:
					val = this.userprefsBranch.getIntPref(key);
				break;
				
				case this.userprefsBranch.PREF_STRING:
					val = this.userprefsBranch.getCharPref(key);
				break;
				
				case this.userprefsBranch.PREF_BOOL:
					val = this.userprefsBranch.getBoolPref(key);
				break;
				
				default : // Si aucune preference de ce nom a été trouvé, on retourne celle par default
					//val = defval;
			}
		} 
		catch (e) // En cas d'erreur
		{
			//val = defval; // On defini la valeur par default comme etant la valeur
			this.logError(e,"can't get pref "+key+", using default value: "+val);
		}
		return val;
	},
	
	setBoolPref : function(key, val)  {
		try{
			this.userprefsBranch.setBoolPref(key,val);    
		}catch(e){
			this.logError(e,"can't save bool pref ("+key+","+val+") : ");
		}
	},

	setIntPref : function(key, val)  {
		try{
			this.userprefsBranch.setIntPref(key,val);   
		}catch(e){
			this.logError(e,"can't save int pref ("+key+","+val+") : ");
		}		
	},
	
	setCharPref : function(key, val)  {
		try{
			this.userprefsBranch.setCharPref(key,val);
		}catch(e){
			this.logError(e,"can't save char pref ("+key+","+val+") : ");
		}				
	},
	
	getJSONPref : function(key, val)
	{
		if(typeof val == "undefined")
			val = {};
		val = this.getPref(key,JSON.stringify(val));
		try{
			val = JSON.parse(val+"");
		}catch(e){
			this.logError(e,"JSON parse error ("+key+","+val+") : ");
			val = {};
		}
		
		return val;
	},
	
	setJSONPref : function(key, val)
	{
		val = JSON.stringify(val);
		//ufLog("setJSONPref:"+val);
		this.setCharPref(key,val);
	},
	
	/**
	* Tests a string and returns true if it is a CSS color
	* It can have the format #xxxxxx or can be the english name of a color (red etc.)
	* @param color: the string to be tested
	* @param canBeEmpty: optional bool, true if the string "" must return true
	* @return bool, true if the string is a color
	*/
	isColor : function(color,canBeEmpty)
	{
		if(typeof canBeEmpty=="undefined")
			var canBeEmpty=false;
		if(typeof color == "string")
		{
			if(canBeEmpty==true && color == "")
				return true;
			if(color.match(/^#[0-9a-fA-F]{6}$/))
				return true;
			if(typeof UniFox.ColorList[color] != "undefined")
				return true;
			else
				return false;
		}
		else
			return false;
	},
	
	/**
	* Lists the properties of an object
	* @param object: object, the object to be listed
	* @param args: object, optional arguments
	* @param args.lineFeed: string, separator between properties, default is \n, can be set to <br/> for html display
	* @param args.tab: string, char for tabulation, default is \t
	* @params args.infLimit, args.supLimit: ints, can be used to display only some of the properties (between infLimit and supLimit), defaults are 0 and 200
	*/
	getPropertyList : function(object,args)
	{	
		var str = object+" :";
		var lineFeed = "\n";
		var infLimit = 0;
		var supLimit = 200;
		var tab = "\t";
		var depth = 0;
		var initialtab = "";
		if(typeof args != "undefined")
		{
			if(typeof args.lineFeed != "undefined")
				infLimit = args.lineFeed;
			if(typeof args.infLimit != "undefined")
				infLimit = args.infLimit;
			if(typeof args.supLimit != "undefined")
				supLimit = args.supLimit;
			if(typeof args.tab != "undefined")
				tab = args.tab;
			if(typeof args.depth != "undefined")
				depth = args.depth;
			if(typeof args.initialtab != "undefined")
				initialtab = args.initialtab;
		}
		
		if (object) 
		{
			var lim=0;
			for (var i in object) 
			{
				try{
					if(lim>=infLimit && lim<supLimit)
					{
						var type = typeof object[i];
						lim++;
						str+= lineFeed+initialtab+"("+type;
						if(object[i].length)
							str+="["+object[i].length+"]";
						str+=")";
						str+= tab+i+" = ";
						if(depth > 0 && type == "object")
							str+= this.getPropertyList(object[i],{depth:depth-1,initialtab:initialtab+tab});
						else 
							str+= object[i]+"";
					}
				} catch(e) {
					ufLog("can't display value of "+i+" : "+e,UFLog.ERROR);
				}
			}
			str+= lineFeed+initialtab+"properties:"+lim;
		} 
		else 
		{
			str+= null;
		}
		return str;
	},
	
	/**
	* Extracts GET parameters from URL
	* @return : associative array containing the parameters, 
	*			index is the parameter name, value is the parameter value
	*/
	getParamsFromUrl : function(url)
	{
		var params = {};
		var index = url.indexOf('?');
		if(index > -1)
		{
			url = url.split('?')[1];
			url = url.split('#')[0];
			url = url.split('&');
			var sTmp = "";
			for(var i in url)
			{
				sTmp = url[i];
				sTmp = sTmp.split('=');
				params[sTmp[0]] = sTmp[1];
			}
		}
		return params;
	},
	
	/**
	* Restarts Firefox
	*/
	restartApp : function () 
	{
		if(UFUtils.getPref("DebugMode", UFDebugLevels.ERROR) > UFDebugLevels.NONE)
		{
			try
			{
				const nsIAppStartup = Components.interfaces.nsIAppStartup;

				// Notify all windows that an application quit has been requested.
				var os = Components.classes["@mozilla.org/observer-service;1"]
									 .getService(Components.interfaces.nsIObserverService);
				var cancelQuit = Components.classes["@mozilla.org/supports-PRBool;1"]
											 .createInstance(Components.interfaces.nsISupportsPRBool);
				os.notifyObservers(cancelQuit, "quit-application-requested", null);

				// Something aborted the quit process. 
				if (cancelQuit.data)
					return;

				// Notify all windows that an application quit has been granted.
				os.notifyObservers(null, "quit-application-granted", null);

				// Enumerate all windows and call shutdown handlers
				var wm = Components.classes["@mozilla.org/appshell/window-mediator;1"]
									 .getService(Components.interfaces.nsIWindowMediator);
				var windows = wm.getEnumerator(null);
				while (windows.hasMoreElements()) 
					{
					var win = windows.getNext();
					if (("tryToClose" in win) && !win.tryToClose())
						return;
					}
				Components.classes["@mozilla.org/toolkit/app-startup;1"].getService(nsIAppStartup)
						.quit(nsIAppStartup.eRestart | nsIAppStartup.eAttemptQuit);
			}
			catch(e)
			{
				this.catchError(e);
			}
		}
		else 
		{
			ufLog('debug mode off, restart aborted',UFLog.NOTICE);
		}
	},
		
	/**
	* Opens the prefs dialog window
	*/
	openUnifoxOptions : function()
	{
		
		window.openDialog("chrome://unifox2/content/options/UniFoxOptions.xul", "", "centerscreen, dialog, chrome, resizable=yes");
	},

	/**
	* Gets a string in the common lang bundle, according to its name
	* @param stringName: string, the name of the string to be found
	* @return : string, the found string 
	*/
	getString : function(stringName,params)
	{
		return this.langService.getString(stringName,params);
	},
	
	/**
	* Loads the variables to be used as globals
	*/
	load : function()
	{
		this.consoleService = Components.classes["@mozilla.org/consoleservice;1"].getService(Components.interfaces.nsIConsoleService);
		this.extensionService = Components.classes["@mozilla.org/extensions/manager;1"].getService(Components.interfaces.nsIExtensionManager).getItemForID("unifox2@ogsteam.fr");
		this.extensionName = this.extensionService.name;
		this.extensionVersion = this.extensionService.version;
		this.extensionFullName = this.extensionName+' v'+this.extensionVersion;
		
		this.prefService = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
		this.userprefsBranch = this.prefService.getBranch("unifox2.userprefs."); // Recupere les preferences
		//srGetStrBundle("chrome://unifox2/locale/lang.properties"); // Recupere les valeurs de langue
		//this.langService = document.getElementById("UniFoxBundle");
		
		
		this.serverData = false;
		this.gameData = false;
		
		this.modulesUrl = "chrome://unifox2/content/modules/";
		this.modulesLocalesUrl = "chrome://unifox2/locale/modules/";
		this.chromeLocalesUrl = "chrome://unifox2/locale/";
		this.chromeContentUrl = "chrome://unifox2/content/";
		this.chromeContentResourcesUrl = "chrome://unifox2/content/resources/";
		this.langService = new UniFox.Bundle(this.chromeLocalesUrl+"unifox.properties");
	}
}
UFUtils.load();