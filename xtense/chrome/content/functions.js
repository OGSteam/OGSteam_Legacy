/**
 * @author Unibozu
 * @license GNU/GPL
 */

if (typeof Cc == 'undefined') {
	var Cc = Components.classes;
	var Ci = Components.interfaces;
}

const XLOG_WARNING = 1, XLOG_ERROR = 2, XLOG_NORMAL = 3, XLOG_SUCCESS = 4, XLOG_COMMENT = 5;
const logClassName = [0, 'warning', 'error', 'normal', 'success', 'comment'];

var Xlocales = {};

function Ximplements (object, implement) {
	for (var i in implement) object[i] = implement[i];
}

/**
 * trim() >> QuentinC.net
 */
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

String.prototype.cleanPoints = function() {return parseInt(this.replace(/\.+/g, ''));}

String.prototype.cleanHTML = function () {
	return this.replace(/<.+>/g, '');
}
String.prototype.stripHTML = function () {
	return this.replace(/<[^>]*>/g, '');
}
String.prototype.between = function (s1, s2) {
	var n;
	if ((n = this.indexOf(s1)) == -1) return this;
	var str = this.substr(this.indexOf());
	return str.substr();
}

Element.prototype.set = function (name, value) {
	if (typeof value != 'undefined') this.setAttribute(name, value);
	else {
		for (var i in name) {
			this.setAttribute(i, name[i]);
		}
	}
	return this;
}

Element.prototype.setText = function (text) {
	this.textContent = text;
	return this;
}

Element.prototype.setInnerHTML = function (text) {
	this.innerHTML = text;
	return this;
}

Element.prototype.get = function (type) {
	return this.getAttribute(type);
}

Element.prototype.delClass = function () {
	var args = to_array(arguments);
	if (this.className) {
		var classes = this.className.split(/ +/g);
		for (var a = 0, arg_len = args.length; a < arg_len; a++) {
			for (var i = 0, len = classes.length; i < len; i++) {
				if (classes[i] == args[a]) {
					classes.splice(i, 1); break;
				}
			}
		}
		this.className = classes.join(' ');
	}
	return this;
}

Element.prototype.addClass = function () {
	var args = to_array(arguments);
	if (!this.className) this.className = '';
	
	var classes = this.className.split(/ +/g);
	for (var a = 0, arg_len = args.length; a < arg_len; a++) {
		var found = false;
		for (var i = 0, len = classes.length; i < len; i++) {
			if (classes[i] == args[a]) found = true;
		}
		
		if (!found) classes.push(args[a]);
	}
	this.className = classes.join(' ');
	return this;
}

Element.prototype.empty = function () {
	for (var i = 0, len = this.childNodes.length; i < len; i++) this.removeChild(this.childNodes[0]);
	return this;
}


Element.prototype.on = function (type, fn) {
	this.addEventListener(type, fn, false);
	return this;
}
window.on = Element.prototype.on;

Element.prototype.add = function () {
	for (var i = 0, len = arguments.length; i < len; i++) this.appendChild(arguments[i]);
	return this;
}

function to_array(obj) {
	var array = [];
	for (var i = 0, len = obj.length; i < len; i++) {
		array.push(obj[i]);
	}
	return array;
}

function Xel(type) {
	return document.createElement(type);
}

function XparseDate(dateString,handler) {
	var date = new Date();
	var m = dateString.match(new RegExp(handler.regexp));
	var time = new Date();
	if(m) {
		if(handler.fields.year!=-1)
			time.setYear(m[handler.fields.year]);
		if(handler.fields.month!=-1)
			time.setMonth(m[handler.fields.month]*1-1);
		//Xconsole('month:'+m[handler.fields.month]+'|'+parseInt(m[handler.fields.month].trimZeros()));
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
}
	
String.prototype.Xwordwrap = function (int_width, str_break, cut ) {
    // http://kevin.vanzonneveld.net
    var m = int_width, b = str_break, c = cut;
    var i, j, l, s, r;
    if(m < 1) {
        return this;
    }
    for(i = -1, l = (r = this.split("\n")).length; ++i < l; r[i] += s) {
        for(s = r[i], r[i] = ""; s.length > m; r[i] += s.slice(0, j) + ((s = s.slice(j)).length ? b : "")){
            j = c == 2 || (j = s.slice(0, m + 1).match(/\S*(\s)?$/))[1] ? m : j.input.length - j[0].length || c == 1 && m || j.input.length + (j = s.slice(m).match(/^\S*/)).input.length;
        }
    }
    return r.join("\n");
}

/**
 * Fonction de debogage d'exception -> de Foxgame
 */
function show_backtrace(e) {
	window.openDialog(
        'chrome://xtense2/content/ui/ErrorBacktrace.html',
        'errorbacktrace'+new Date().getTime(),
        'centerscreen,chrome,resizable',
        e,
        'display error'
      );
}

function throw_error(e) {
	if(typeof Xtense.CurrentTab!='undefined')
		if(Xtense.CurrentTab!=null)
			Xtense.CurrentTab.setStatus(Xl('fatal error'), XLOG_ERROR);
	if (Xprefs.getBool('debug')) {
		show_backtrace(e);
	}
}

function throw_plugin_error(data, server) {
	window.openDialog(
		'chrome://xtense2/content/ui/pluginError.html',
		'debug_window'+ new Date().getTime(),
		'centerscreen=yes,chrome=yes,modal=no,resizable=yes',
		{status: data.status, content: data.content, server: server}
	);
}

/*function l(name) {
	try {
		if (!XtenseLang[name]) return '[Chaine non disponible]';
		
		var locale = XtenseLang[name];
		if (typeof locale == 'string') return locale;
		var str = locale[0];
		
		for (var i = 1, len = locale.length; i < len; i++) {
			str += arguments[i]+locale[i];
		}
		return str;
	} catch (e) { throw_error(e); }
}*/

function XgetMainInstance() {
	var wm = Cc["@mozilla.org/appshell/window-mediator;1"].getService(Ci.nsIWindowMediator);
	return wm.getMostRecentWindow("navigator:browser").Xtense;
}

function Xl(name) {
	try {
		if (!Xlocales[name]) {
			Xtense.CurrentTab.setStatus('Unknow locale "'+name+'"', XLOG_WARNING);
			return '[Chaine non disponible]';
		}
		
		var locale = Xlocales[name];
		for (var i = 1, len = arguments.length; i < len; i++) {
			locale = locale.replace('$'+i, arguments[i]);
		}
		return locale;
	} catch (e) { alert(e); return false; }
}

function Xopen_prefs(_1) {
	window.openDialog('chrome://xtense2/content/ui/prefs.xul', 'prefs', 'chrome,titlebar,toolbar,resizable,centerscreen', _1);
}


function Xclipboard(text) {
	var str   = Cc["@mozilla.org/supports-string;1"]
			.createInstance(Ci.nsISupportsString);
	str.data  = text;
	var trans = Cc["@mozilla.org/widget/transferable;1"]
			.createInstance(Ci.nsITransferable);
	trans.addDataFlavor("text/unicode");
	trans.setTransferData("text/unicode", str, text.length * 2);
	var clipid = Ci.nsIClipboard;
	var clip   = Cc["@mozilla.org/widget/clipboard;1"].getService(clipid);
	clip.setData(trans, null, clipid.kGlobalClipboard);
}

function _dump(v, n) {
	//if (!v) return;
	var str = '';
	var type = typeof v;
	var ident = '';
	var nbsp = '     ';
	for (var a = 0; a < n; a++) ident += nbsp;
	
	if (type == 'object') {
		//if (v.length == null) {
			var nb = 0;
			for (var i in v) nb++;
			var begin = 'object('+nb+')';
		//} else {
		//	var begin = 'array('+v.length+')';
		//}
		
		str += begin+' {';
		for (var i in v) {
			str += '\n'+ident+nbsp+'['+(!isNaN(i) ? i : '"'+i+'"')+']=>  '+ _dump(v[i], n+1);
		}
		if (!i) str += '\n'+ident+nbsp+'Empty';
		str += '\n'+ident+'}';
	}
	else if (type == 'string')  str += 'string('+v.length+') "'+v+'"';
	else if (type == 'number')  str += 'number('+v+')';
	else if (type == 'boolean') str += 'bool('+(v == true ? 'true' : 'false')+')';
	else if (type == 'function') str += 'function()';
	
	return str;
}

function Xdump() {
	for (var i = 0, len = arguments.length; i < len; i++) {
		Xconsole(_dump(arguments[i], 0));
	}
}

function Xrdump() {
	for (var i = 0, len = arguments.length, str = []; i < len; i++) {
		str.push(_dump(arguments[i], 0));
	}
	return str.join("\n");
}


function Xsimple_dump(v, toConsole) {
	var str = '';
	var type = typeof v;
	var nbsp = '     ';
	
	if (type == 'object') {
		var begin = '';
		//if (typeof v.length == 'number') {
		//	begin = 'array('+v.length+')';
		//} else {
			var nb = 0;
			for (var i in v) nb++;
			begin = 'object('+nb+')';
		//}
		
		str += begin+' {';
		for (var i in v) {
			str += '\n'+nbsp+'['+(!isNaN(i) ? i : '"'+i+'"')+']=>  ';
			
			var t = typeof v[i];
			if (t == 'string') str += 'string('+v[i].length+') "'+v[i]+'"';
			else if (t == 'number') str += 'number('+v[i]+')';
			else if (t == 'boolean') str += 'bool('+(v[i] == true ? 'true' : 'false')+')';
			else if (t == 'undefined') str += 'null';
			else {
				try {
					//if (typeof v[i].length == 'number') {
					//	str += ' array('+v[i].length+')';
					//} else {
						var nb = 0;
						//for (var b in v[i]) nb++;
						str += ' object('/*+nb*/+')';
					//}
				} catch (e) {
					var nb = 0;
					//for (var b in v[i]) nb++;
					str += ' object('/*+nb*/+')';
				}
			}
		}
		if (!i) str += '\n'+nbsp+'Empty';
		str += '\n}';
	}
	else if (type == 'string') str += 'string('+v.length+') "'+v+'"';
	else if (type == 'number') str += 'number('+v+')';
	else if (type == 'boolean') str += 'bool('+(v == true ? 'true' : 'false')+')';
	else if (type == 'undefined') str += 'null';
	
	if (toConsole) Xconsole(str);
	else return str;
}

/**
 * Encodage d'URL / Decodage
 */
function urlencode(s) { return encodeURIComponent(s); }
function urldecode(s) { return decodeURIComponent(s); }

/**
 * Affiche dans la console JS en avertissement le message <msg>
 */
function Xconsole(_1) {
	if (typeof _1 == 'undefined' || _1 == null) var msg = '<<empty>>';
	else var msg = 'Xtense says: '+_1;
	Components.classes["@mozilla.org/consoleservice;1"].getService(Components.interfaces.nsIConsoleService).logStringMessage(msg);
}

/**
 * Retourne l'element HTML ayant l'id <id>
 */
function $(id) {
	return document.getElementById(id);
}

/**
 * Inclusion du fichier chrome de xtense $file
 */
function include_file(file) {
	var objTemp = new Object();
	var loader = Components.classes["@mozilla.org/moz/jssubscript-loader;1"].getService(Components.interfaces.mozIJSSubScriptLoader);
	loader.loadSubScript("chrome://xtense2/content/"+file, objTemp);
	return objTemp;
}

// From GM
function getContents(aURL){
	var ioService = Components.classes["@mozilla.org/network/io-service;1"]
		.getService(Components.interfaces.nsIIOService);
	var scriptableStream = Components.classes["@mozilla.org/scriptableinputstream;1"]
		.getService(Components.interfaces.nsIScriptableInputStream);
	
	var channel = ioService.newChannelFromURI(aURL);
	var input = channel.open();
	scriptableStream.init(input);
	var str = scriptableStream.read(input.available());
	scriptableStream.close();
	input.close();
	
	return str;
}

function Xreload_chrome() {
	Components.classes["@mozilla.org/chrome/chrome-registry;1"]
	.getService(Components.interfaces.nsIXULChromeRegistry)
	.reloadChrome();
}

function Xreload_firefox() {
	if (Xprefs.getBool('debug')) {
	try{
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
  while (windows.hasMoreElements()) {
    var win = windows.getNext();
    if (("tryToClose" in win) && !win.tryToClose())
      return;
  }
  Components.classes["@mozilla.org/toolkit/app-startup;1"].getService(nsIAppStartup)
            .quit(nsIAppStartup.eRestart | nsIAppStartup.eAttemptQuit);
				}catch(e){ufLog(e.name+": "+e.message+"line "+e.lineNumber);}
	}
	else {Xconsole('debug mode off, restart aborted');}
}

/**
 * Envoi d'une requete HTTP GET.
 * Attend un objet en param avec attributs: url, callback
 * Optionnels: scope, args, all
 */

function Xajax(obj) {
	this.xhr = new XMLHttpRequest();
	this.callback = obj.callback || function(){};
	this.args = obj.args || [];
	this.scope = obj.scope || null;
	this.url = obj.url || '';
	this.post = obj.post || '';

	var self = this;

	this.xhr.onreadystatechange =  function() {
		if(self.xhr.readyState == 4) {
			self.args.push({status: self.xhr.status, content: self.xhr.responseText});
			self.callback.apply(self.scope, self.args);
		}
	};
	
	this.xhr.open('POST', this.url, true);
	this.xhr.setRequestHeader('User-Agent', 'Xtense2');
	this.xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	this.xhr.send(this.post);
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
