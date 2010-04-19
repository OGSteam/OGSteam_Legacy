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
							//+ '&password=' + server.hash + '&univers=' + server.univers + this.serializeData2();
							+ '&password=' + server.hash + '&univers=' + server.univers +this.serializeData();
			 //this.serializeData2();
			
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
		//Xservers.handleResponse(this, Server, Eesponse);
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
		//var str = parent;
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
			return parent+'='+encodeURIComponent(retour);
	}
	
	this.serializeData = function () {
		var uri = '';
		/*for (var i in this.data) {
			uri += '&'+i+this.serializeObject(this.data[i]);
		}*/
		var tab = [];
		this.serializeObject(this.data,'',tab);
		/*for(var i in tab) {
			tab[i]=encodeURIComponent(tab[i]);
		}*/
		uri = '&'+tab.join('&');
		//Xconsole('data1: '+unescape(uri));
		//Xdump(tab);
		return uri;
	}
	
	/*this.serializeData2 = function () {
		var uri = '';
		for (var i in this.data) {
			uri += '&'+i+'='+encodeURIComponent(this.data[i]);
		}
		//Xconsole('data2: '+unescape(uri));
		return uri;
	}*/
	
	this.postedData = [];
	this.callback = callback;
	this.scole = scope;
	this.loading = {};
	this.data = {};
	this.Tab = Tab;
}
