/**
 * @author Unibozu
 * @license GNU/GPL
 */

function Request(Tab, callback, scope) {
	this.send = function (servers) {
		if (!servers) servers = Xservers.list;
		
		for (var i = 0, len = servers.length; i < len; i++) {
			var server = servers[i];
			var postData = 'toolbar_version=' + Xtense.VERSION + '&mod_min_version=' + Xtense.PLUGIN_REQUIRED + '&user=' + server.user
							+ '&password=' + server.hash + '&univers=' + server.univers +this.serializeData();
			
			if (Xprefs.getBool('spy-debug')) postData += '&spy_debug=1';
			if (Xprefs.getBool('dev')) postData += '&dev=1';
			Xconsole("sending "+postData+" to "+server.url+" from "+server.univers);
			new Xajax({
				url: server.url,
				post: postData,
				callback: this.call,
				scope: this,
				args: [server]
			});
			
			this.postedData[server.n] = postData;
			this.loading[server.n] = true;
		}
	}
	
	this.call = function (Server, Response) {
		this.loading[Server.n] = false;
		this.callback.apply(this.scope, [this, Server, Response]);
	}
	
	this.set = function (name, value) {
		if (typeof name == 'string') this.data[name] = value;
		else {
			for (var n = 0, len = arguments.length; n < len; n++) {
				for (var i in arguments[n]) this.data[i] = arguments[n][i];
			}
		}
	}
	
	this.serializeObject = function(obj,parent,tab) {
		var retour = '';
		var type = typeof obj;
		if (type == 'object') {
			for (var i in obj) {
				if(parent!='')
					var str = parent+'['+i+']';
				else var str = i;
				var a = false;
				// Patch pour Graphic Tools for Ogame
				if(str.search("existsTOG") == -1){
				 a = this.serializeObject(obj[i],str,tab);
				}
				if(a!=false)
					tab.push(a);
			}
			return false;
		}
		else if (type == 'boolean')
			retour = (obj == true ? 1 : 0);
		else retour = obj+'';
			return parent+'='+encodeURIComponent(retour).replace(new RegExp("(%0A)+", "g"), '%20').replace(new RegExp("(%09)+", "g"), '%20').replace(new RegExp("(%20)+", "g"), '%20');
	}
	
	this.serializeData = function () {
		var uri = '';
		var tab = [];
		this.serializeObject(this.data,'',tab);
		uri = '&'+tab.join('&');
		return uri;
	}
	
	this.postedData = [];
	this.callback = callback;
	this.scole = scope;
	this.loading = {};
	this.data = {};
	this.Tab = Tab;
}
