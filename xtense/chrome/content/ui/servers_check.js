/**
 * @author Unibozu
 * @license GNU/GPL
 */

var servers = window.arguments[0].servers;
var Xtense = XgetMainInstance();

window.on('load', function(){
	Xcheck.init();
});

var Xcheck = {
	current: 0,
	isError: false,
	Server: null,
	
	init: function () {
		this.next();
	},
	
	next: function () {
		if (typeof servers[this.current] == 'undefined') {
			$('img').set('style', 'display:none;');
			$('log').value += '\n\n-----------------------------------\n'+Xl('checking end')+'\n';
			$('log').value += Xl('checking '+ (this.isError ? 'errors' : 'success'));
			
			return;
		}
		
		this.Server = new ServerItem(servers[this.current]);
		
		if (this.current != 0) $('log').value += '\n\n';
		$('log').value += Xl('checking server', this.Server.n+1) + '\n' +
						'-----------------------------------\n' +
						Xl('connecting') + this.Server.url;
		
		
		var postData = 'toolbar_version=' + Xtense.VERSION + '&toolbar_type=' + Xtense.TYPE + '&mod_min_version=' + Xtense.PLUGIN_REQUIRED + '&user=' + this.Server.user
						+ '&password=' + this.Server.hash + '&univers=' + this.Server.univers + '&server_check=1';
		
		if (Xprefs.getBool('dev')) postData += '&dev=1';
		
		new Xajax({
			url: this.Server.url,
			post: postData,
			callback: this.call,
			scope: this
		});
		
		/*
		new Xajax({
			url: 	this.Server.url + '?toolbar_version=' + TOOLBAR_VERSION + '&mod_min_version=' + MOD_MIN_VERSION + '&user='+ this.Server.user
					+'&password=' + this.Server.hash + '&univers=' + encodeURIComponent(this.Server.univers) + '&server_check', 
			callback: this.call,
			scope: this
		});
		*/
		
		this.current ++;
	},
	
	error: function () {
		if (this.isError) return;
		this.isError = true;
		
		$('status').setAttribute('style', 'color:red; font-weight:bold;');
		$('status').value = Xl('error occurs');
	},
	
	call: function (Response) {
		$('log').value += '\n';
		
		if (Response.status != 200) {
			$('log').value += Xl('error start');
			
			if (Response.status == 404) 		$('log').value += Xl('http status 404');
			else if (Response.status == 403) 	$('log').value += Xl('http status 403');
			else if (Response.status == 500) 	$('log').value += Xl('http status 500');
			else if (Response.status == 0) 		$('log').value += Xl('http timeout');
			else 								$('log').value += Xl('http status unknow', Response.status);
			
			this.error();
		} else {
			if (Response.content == '') {
				$('log').value += Xl('error start') + Xl('empty response');
				
				this.error();
				this.next();
				return;
			}
			Xconsole(Response.content);
			Xdump(Response.content);
			
			var data = {};
			if (Response.content.match(/^\(\{.*\}\)$/g)) 
				{
				Xconsole("only content");
				data = eval(Response.content);
				}
			else {
				Xconsole("not only content");
				var match = null;
				if ((match = Response.content.match(/\(\{.*\}\)/g)) !== null) {
					data = eval(match[0]);
					// Message d'avertissement
					$('log').value += Xl('incorrect response');
				} else {
					// Message d'erreur
					$('log').value += Xl('error start') + Xl('invalid response');
					
					if (Xprefs.getBool('debug')) {
						throw_plugin_error(Response, this.Server);
					}
					
					this.error();
					this.next();
					return;
				}
			}
			Xconsole("coucou");
			Xdump(data);
			// Erreurs
			if (data.status == 0) {
				var code = data.type;
				$('log').value += Xl('error start');
				
				if (code == 'wrong version') {
					if (data.target == 'plugin') 			$('log').value += Xl('wrong version plugin', data.version, Xtense.PLUGIN_REQUIRED);
					else if (data.target == 'xtense.php') 	$('log').value += Xl('wrong version xtense.php');
					else 									$('log').value += Xl('wrong version toolbar', TOOLBAR_VERSION, data.version);
				}
				else if (code == 'php version') 		$('log').value += Xl('php version');
				else if (code == 'server active')		$('log').value += Xl('server active');
				else if (code == 'plugin connections')	$('log').value += Xl('plugin connections');
				else if (code == 'plugin config')		$('log').value += Xl('plugin config');
				else if (code == 'plugin univers')		$('log').value += Xl('plugin univers');
				else if (code == 'username')			$('log').value += Xl('username', this.Server.user);
				else if (code == 'password')			$('log').value += Xl('password');
				else if (code == 'user active')			$('log').value += Xl('user active');
				else $('log').value += 'Invalid response code "'+cod+'"';
				
				this.error();
			} else {
				$('log').value += '\n -- '+ Xl('informations')
					+ '\n'+ Xl('server name')+' : '+data.servername
					+ '\n'+ Xl('version')+' : '+data.version + '\n';
					
				if (data.grant.system && data.grant.ranking && data.grant.empire && data.grant.messages) {
					$('log').value += Xl('grant all');
				} else if (!data.grant.system && !data.grant.ranking && !data.grant.spy && !data.grant.messages) {
					$('log').value += Xl('grant nothing');
				} else {
					$('log').value += ' - ' + Xl('grant system', Xl('grant ' + (data.grant.system ? 'can' : 'cannot'))) + '\n';
					$('log').value += ' - ' + Xl('grant ranking', Xl('grant ' + (data.grant.ranking ? 'can' : 'cannot'))) + '\n';
					$('log').value += ' - ' + Xl('grant empire', Xl('grant ' + (data.grant.empire ? 'can' : 'cannot'))) + '\n';
					$('log').value += ' - ' + Xl('grant messages', Xl('grant ' + (data.grant.messages ? 'can' : 'cannot')));
				}
				
				this.Server.set({
					name: data.servername.replace(/\"/g, '\\"'),
					version: data.version
				});
				this.Server.save();
			}
		}
		
		this.next();
	}
}

