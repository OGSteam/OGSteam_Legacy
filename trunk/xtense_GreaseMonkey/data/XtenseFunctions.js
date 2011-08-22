/* Fonctions permettant de récupérer les données des balises metas */
var XtenseMetas = {
	getOgameVersion : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.ogame_version);	
	},
	getTimestamp : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.timestamp);	
	},
	getUniverse : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.universe);	
	},
	getLanguage : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.language);	
	},
	getPlayerId : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.player_id);	
	},
	getPlayerName : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.player_name);	
	},
	getAllyId : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.ally_id);	
	},
	getAllyName : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.ally_name);	
	},
	getAllyTag : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.ally_tag);	
	},
	getPlanetId : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.planet_id);	
	},
	getPlanetName : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.planet_name);	
	},
	getPlanetCoords : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.planet_coords);	
	},
	getPlanetType : function() {
		return Xpath.getStringValue(document,XtenseXpaths.metas.planet_type);	
	}
}
/* Fonctions permettant de récupérer des données via des Xpaths */
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
//**********************
//** Fonctions Xtense **
//**********************
var XtenseRequest = {
	postedData : [],
	loading : {},
	data : {},
	send : function (){
		//if (! servers) servers = Xservers.list;
		
		//for (var i = 0, len = servers.length; i < len; i++){
			//var server = servers[i];
			var postData = 'toolbar_version=' + VERSION + '&mod_min_version=' + PLUGIN_REQUIRED + '&user=' + GM_getValue(XtenseOptions.server_ids.user,'') + '&password=' + MD5(SHA1(GM_getValue(XtenseOptions.server_ids.password,''))) + '&univers=' + urlUnivers + XtenseRequest.serializeData();
			
			//if (Xprefs.getBool('spy-debug')) postData += '&spy_debug=1';
			//if (Xprefs.getBool('dev')) postData += '&dev=1';
			//log("sending " + postData + " to " + GM_getValue(XtenseOptions.server_ids.url,'') + " from " + urlUnivers);
			new Xajax(
			{
				url: GM_getValue(XtenseOptions.server_ids.url,''),
				post: postData,
				callback: null,
				scope: this
			});
			
			postedData = postData;
			loading = true;
			
		//}
	},		
	call : function (Server, Response){
		XtenseRequest.loading[Server.n] = false;
		XtenseRequest.callback.apply(this.scope,[ this, Server, Response]);
	},
	set : function (name, value){
		if (typeof name == 'string') this.data[name] = value; else {
			for (var n = 0, len = arguments.length; n < len; n++){
				for (var i in arguments[n]) this.data[i] = arguments[n][i];
			}
		}
	},		
	serializeObject : function (obj, parent, tab){
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
	},		
	serializeData : function (){
		var uri = '';
		var tab =[];
		this.serializeObject(this.data, '', tab);
		uri = '&' + tab.join('&');
		return uri;
	}
}
function GM_getValue(key,defaultVal){
	var retValue=null;
	var keyStore = cookie+key;
	try{			
		retValue = window.localStorage.getItem(keyStore);
		if (retValue == null || retValue.length == 0) retValue = defaultVal;
		//log("GM_getValue() returned :"+retValue);
		return retValue;
	}catch(e) {
  		log("Error inside GM_getValue() for key:" + keyStore);
	}
}
function GM_setValue(key,value){
	var keyStore=cookie+key;
	try{
		retValue = window.localStorage.getItem(keyStore);
		if (retValue == null || retValue.length == 0) window.localStorage.removeItem(keyStore);
		window.localStorage.setItem(keyStore, value);
		//log("GM_setValue() set "+keyStore+"="+value);
	}catch(e) {
  		log("Error inside GM_setValue() for key:" + keyStore+" and value:"+value);
	}	
}
function GM_deleteValue(key){
	window.localStorage.removeItem(key);
}
function log(message){
	console.log(nomScript+" says : "+message);
}

function Xajax(obj) {
	var xhr = new XMLHttpRequest();
	var callback = obj.callback || function(){};
	//var args = obj.args || [];
	var args = new Array();
	var scope = obj.scope || null;
	var url = obj.url || '';
	var post = obj.post || '';

	xhr.onreadystatechange =  function() {
		if(xhr.readyState == 4) {
			args.push({status: xhr.status, content: xhr.responseText});
			//alert(args[0].status);
			//callback.apply(scope, args);
			handleResponse(args[0]);
		}
	};
	
	xhr.open('POST', url, true);
	xhr.setRequestHeader('User-Agent', 'Xtense2');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send(post);
	
	//data = eval(Response.content);
}

function setStatus(type,message){
	if(type==XLOG_SUCCESS){
		document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseOk.gif";
	} else if(type==XLOG_NORMAL){
		document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseNo.gif";
	} else if(type==XLOG_WARNING){
		document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseWarn.gif";
	} else if(type==XLOG_ERROR){
		document.getElementById("xtense.icone").src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtenseKo.gif";
	} else {
		document.getElementById("xtense.icone").src=urlIcone;
	}
	document.getElementById("xtense.icone").title=message;
}

var XtenseOptions = {
	server_ids : {
		url : "server.url.plugin",
		user : "server.user",
		password : "server.pwd"
	}
}

function handleResponse(Response) {
	//Xdump(Response.content);
	//if (Server.cached()) var message_start = '"'+Server.name+'" : ';
	//else var message_start = Xl('response start', Server.n+1);
	
	//var extra = {Request: Request, Server: Server, Response: Response, page: Request.data.type};
	if (Response.status != 200) {
		if (Response.status == 404) 		log(Xl('http status 404'));
		else if (Response.status == 403) 	log(Xl('http status 403'));
		else if (Response.status == 500) 	log(Xl('http status 500'));
		else if (Response.status == 0)		log(Xl('http timeout'));
		else 								log(Xl('http status unknow', Response.status));
	} else {
		var type = XLOG_SUCCESS;
		
		/*if (Response.content == '') {
			Request.Tab.setStatus(message_start + Xl('empty response'), XLOG_ERROR, extra);
			return;
		}
		
		if (Response.content == 'hack') {
			Request.Tab.setStatus(message_start + Xl('response hack'), XLOG_ERROR, extra);
			return;
		}*/
		
		var data = {};
		if (Response.content.match(/^\(\{.*\}\)$/g)){
			data = eval(Response.content);
		} else {
			var match = null;
			if ((match = Response.content.match(/\(\{.*\}\)/))) {
				data = eval(match[0]);
				// Message d'avertissement
				type = XLOG_WARNING;
				log("full response:"+escape(Response.content));
			} else {
				// Message d'erreur
				/*Request.Tab.setStatus(message_start + Xl('invalid response'), XLOG_ERROR, extra);
				if (Xprefs.getBool('debug')) {
					throw_plugin_error(Response, Server);
				}*/
				return;
			}
		}
		
		var message = '';
		var code = data.type;

		/*if (data.status == 0) {
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
		} else {*/
			if (code == 'home updated') 			message = Xl('success home updated', Xl('page '+data.page));
			else if (code == 'system')				message = Xl('success system', data.galaxy, data.system);
			/*else if (code == 'ranking') 			message = Xl('success ranking', Xl('ranking '+data.type1), Xl('ranking '+data.type2), data.offset, data.offset+99);
			else if (code == 'rc')					message = Xl('success rc');
			else if (code == 'ally_list')			message = Xl('success ally_list', data.tag);
			else if (code == 'messages')			message = Xl('success messages');
			else if (code == 'spy') 				message = Xl('success spy');
			else if (code == 'fleetSending')		message = Xl('success fleetSending');*/
			else 									message = Xl('unknow response', code, Response.content);
		//}
		
		//if (Xprefs.getBool('display-execution-time') && data.execution) message = '['+data.execution+' ms] '+ message_start + message;
		//if (Xprefs.getBool('display-new-messages') && typeof data.new_messages!='undefined') Request.Tab.setNewPMStatus (data.new_messages, Server);
		
		if (data.calls) {
			// Merge the both objects
			//var calls = extra.calls = data.calls;
			var calls = data.calls;
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
		setStatus(type,'['+data.execution+' ms] '+message);
		//Request.Tab.setStatus(message, type, extra);
	}
}

eval(function(p,a,c,k,e,d){e=function(c){return(c<a?"":e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('l 3Q(w){l P(n,s){e 2w=(n<<s)|(n>>>(32-s));f 2w};l 2z(1w){e 1c="";e i;e 2d;e 1Y;J(i=0;i<=6;i+=2){2d=(1w>>>(i*4+4))&1X;1Y=(1w>>>(i*4))&1X;1c+=2d.1N(16)+1Y.1N(16)}f 1c};l 1a(1w){e 1c="";e i;e v;J(i=7;i>=0;i--){v=(1w>>>(i*4))&1X;1c+=v.1N(16)}f 1c};l 1K(q){q=q.2q(/\\r\\n/g,"\\n");e u="";J(e n=0;n<q.T;n++){e c=q.L(n);Y(c<X){u+=M.N(c)}1e Y((c>2k)&&(c<2r)){u+=M.N((c>>6)|2s);u+=M.N((c&1b)|X)}1e{u+=M.N((c>>12)|2t);u+=M.N(((c>>6)&1b)|X);u+=M.N((c&1b)|X)}}f u};e 1E;e i,j;e W=2o 1L(3B);e 1r=2i;e 1x=2j;e 1i=2f;e 1h=2g;e 1B=3F;e A,B,C,D,E;e K;w=1K(w);e O=w.T;e S=2o 1L();J(i=0;i<O-3;i+=4){j=w.L(i)<<24|w.L(i+1)<<16|w.L(i+2)<<8|w.L(i+3);S.1j(j)}3G(O%4){1Q 0:i=3T;1M;1Q 1:i=w.L(O-1)<<24|3r;1M;1Q 2:i=w.L(O-2)<<24|w.L(O-1)<<16|2F;1M;1Q 3:i=w.L(O-3)<<24|w.L(O-2)<<16|w.L(O-1)<<8|2n;1M}S.1j(i);2p((S.T%16)!=14)S.1j(0);S.1j(O>>>29);S.1j((O<<3)&R);J(1E=0;1E<S.T;1E+=16){J(i=0;i<16;i++)W[i]=S[1E+i];J(i=16;i<=2h;i++)W[i]=P(W[i-3]^W[i-8]^W[i-14]^W[i-16],1);A=1r;B=1x;C=1i;D=1h;E=1B;J(i=0;i<=19;i++){K=(P(A,5)+((B&C)|(~B&D))+E+W[i]+3c)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=20;i<=39;i++){K=(P(A,5)+(B^C^D)+E+W[i]+3s)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=3U;i<=2N;i++){K=(P(A,5)+((B&C)|(B&D)|(C&D))+E+W[i]+2V)&R;E=D;D=C;C=P(B,30);B=A;A=K}J(i=2Y;i<=2h;i++){K=(P(A,5)+(B^C^D)+E+W[i]+2R)&R;E=D;D=C;C=P(B,30);B=A;A=K}1r=(1r+A)&R;1x=(1x+B)&R;1i=(1i+C)&R;1h=(1h+D)&R;1B=(1B+E)&R}e K=1a(1r)+1a(1x)+1a(1i)+1a(1h)+1a(1B);f K.2v()}l 33(q){l 1v(1z,2c){f(1z<<2c)|(1z>>>(32-2c))}l h(1W,1U){e 1V,1T,1d,1f,18;1d=(1W&2a);1f=(1U&2a);1V=(1W&1O);1T=(1U&1O);18=(1W&2u)+(1U&2u);Y(1V&1T){f(18^2a^1d^1f)}Y(1V|1T){Y(18&1O){f(18^3a^1d^1f)}1e{f(18^1O^1d^1f)}}1e{f(18^1d^1f)}}l F(x,y,z){f(x&y)|((~x)&z)}l G(x,y,z){f(x&z)|(y&(~z))}l H(x,y,z){f(x^y^z)}l I(x,y,z){f(y^(x|(~z)))}l o(a,b,c,d,x,s,U){a=h(a,h(h(F(b,c,d),x),U));f h(1v(a,s),b)};l t(a,b,c,d,x,s,U){a=h(a,h(h(G(b,c,d),x),U));f h(1v(a,s),b)};l m(a,b,c,d,x,s,U){a=h(a,h(h(H(b,c,d),x),U));f h(1v(a,s),b)};l p(a,b,c,d,x,s,U){a=h(a,h(h(I(b,c,d),x),U));f h(1v(a,s),b)};l 2e(q){e Z;e 1C=q.T;e 26=1C+8;e 2m=(26-(26%2l))/2l;e 1P=(2m+1)*16;e V=1L(1P-1);e 1y=0;e Q=0;2p(Q<1C){Z=(Q-(Q%4))/4;1y=(Q%4)*8;V[Z]=(V[Z]|(q.L(Q)<<1y));Q++}Z=(Q-(Q%4))/4;1y=(Q%4)*8;V[Z]=V[Z]|(2n<<1y);V[1P-2]=1C<<3;V[1P-1]=1C>>>29;f V};l 1q(1z){e 1S="",1R="",27,1t;J(1t=0;1t<=3;1t++){27=(1z>>>(1t*8))&3u;1R="0"+27.1N(16);1S=1S+1R.3w(1R.T-2,2)}f 1S};l 1K(q){q=q.2q(/\\r\\n/g,"\\n");e u="";J(e n=0;n<q.T;n++){e c=q.L(n);Y(c<X){u+=M.N(c)}1e Y((c>2k)&&(c<2r)){u+=M.N((c>>6)|2s);u+=M.N((c&1b)|X)}1e{u+=M.N((c>>12)|2t);u+=M.N(((c>>6)&1b)|X);u+=M.N((c&1b)|X)}}f u};e x=1L();e k,2b,1Z,25,28,a,b,c,d;e 1o=7,1m=12,1n=17,1p=22;e 1I=5,1J=9,1k=14,1u=20;e 1g=4,1A=11,1F=16,1D=23;e 1s=6,1l=10,1G=15,1H=21;q=1K(q);x=2e(q);a=2i;b=2j;c=2f;d=2g;J(k=0;k<x.T;k+=16){2b=a;1Z=b;25=c;28=d;a=o(a,b,c,d,x[k+0],1o,2B);d=o(d,a,b,c,x[k+1],1m,2C);c=o(c,d,a,b,x[k+2],1n,2E);b=o(b,c,d,a,x[k+3],1p,2G);a=o(a,b,c,d,x[k+4],1o,2H);d=o(d,a,b,c,x[k+5],1m,2I);c=o(c,d,a,b,x[k+6],1n,2K);b=o(b,c,d,a,x[k+7],1p,2L);a=o(a,b,c,d,x[k+8],1o,3j);d=o(d,a,b,c,x[k+9],1m,3k);c=o(c,d,a,b,x[k+10],1n,2O);b=o(b,c,d,a,x[k+11],1p,2P);a=o(a,b,c,d,x[k+12],1o,2U);d=o(d,a,b,c,x[k+13],1m,2T);c=o(c,d,a,b,x[k+14],1n,2W);b=o(b,c,d,a,x[k+15],1p,31);a=t(a,b,c,d,x[k+1],1I,34);d=t(d,a,b,c,x[k+6],1J,35);c=t(c,d,a,b,x[k+11],1k,36);b=t(b,c,d,a,x[k+0],1u,38);a=t(a,b,c,d,x[k+5],1I,3b);d=t(d,a,b,c,x[k+10],1J,3d);c=t(c,d,a,b,x[k+15],1k,3e);b=t(b,c,d,a,x[k+4],1u,3g);a=t(a,b,c,d,x[k+9],1I,3i);d=t(d,a,b,c,x[k+14],1J,3l);c=t(c,d,a,b,x[k+3],1k,3m);b=t(b,c,d,a,x[k+8],1u,3n);a=t(a,b,c,d,x[k+13],1I,3o);d=t(d,a,b,c,x[k+2],1J,3q);c=t(c,d,a,b,x[k+7],1k,3t);b=t(b,c,d,a,x[k+12],1u,3x);a=m(a,b,c,d,x[k+5],1g,3y);d=m(d,a,b,c,x[k+8],1A,3z);c=m(c,d,a,b,x[k+11],1F,3C);b=m(b,c,d,a,x[k+14],1D,3E);a=m(a,b,c,d,x[k+1],1g,3H);d=m(d,a,b,c,x[k+4],1A,3I);c=m(c,d,a,b,x[k+7],1F,3K);b=m(b,c,d,a,x[k+10],1D,3L);a=m(a,b,c,d,x[k+13],1g,3M);d=m(d,a,b,c,x[k+0],1A,3N);c=m(c,d,a,b,x[k+3],1F,3P);b=m(b,c,d,a,x[k+6],1D,3S);a=m(a,b,c,d,x[k+9],1g,2x);d=m(d,a,b,c,x[k+12],1A,2A);c=m(c,d,a,b,x[k+15],1F,2D);b=m(b,c,d,a,x[k+2],1D,2M);a=p(a,b,c,d,x[k+0],1s,2Q);d=p(d,a,b,c,x[k+7],1l,2S);c=p(c,d,a,b,x[k+14],1G,2Z);b=p(b,c,d,a,x[k+5],1H,37);a=p(a,b,c,d,x[k+12],1s,3f);d=p(d,a,b,c,x[k+3],1l,3D);c=p(c,d,a,b,x[k+10],1G,3p);b=p(b,c,d,a,x[k+1],1H,3v);a=p(a,b,c,d,x[k+8],1s,3A);d=p(d,a,b,c,x[k+15],1l,3J);c=p(c,d,a,b,x[k+6],1G,3O);b=p(b,c,d,a,x[k+13],1H,2y);a=p(a,b,c,d,x[k+4],1s,2J);d=p(d,a,b,c,x[k+11],1l,2X);c=p(c,d,a,b,x[k+2],1G,3h);b=p(b,c,d,a,x[k+9],1H,3R);a=h(a,2b);b=h(b,1Z);c=h(c,25);d=h(d,28)}e K=1q(a)+1q(b)+1q(c)+1q(d);f K.2v()}',62,243,'||||||||||||||var|return||AddUnsigned||||function|HH||FF|II|string|||GG|utftext||msg|||||||||||||for|temp|charCodeAt|String|fromCharCode|msg_len|rotate_left|lByteCount|0x0ffffffff|word_array|length|ac|lWordArray||128|if|lWordCount|||||||||lResult||cvt_hex|63|str|lX8|else|lY8|S31|H3|H2|push|S23|S42|S12|S13|S11|S14|WordToHex|H0|S41|lCount|S24|RotateLeft|val|H1|lBytePosition|lValue|S32|H4|lMessageLength|S34|blockstart|S33|S43|S44|S21|S22|Utf8Encode|Array|break|toString|0x40000000|lNumberOfWords|case|WordToHexValue_temp|WordToHexValue|lY4|lY|lX4|lX|0x0f|vl|BB||||||CC|lNumberOfWords_temp1|lByte|DD||0x80000000|AA|iShiftBits|vh|ConvertToWordArray|0x98BADCFE|0x10325476|79|0x67452301|0xEFCDAB89|127|64|lNumberOfWords_temp2|0x80|new|while|replace|2048|192|224|0x3FFFFFFF|toLowerCase|t4|0xD9D4D039|0x4E0811A1|lsb_hex|0xE6DB99E5|0xD76AA478|0xE8C7B756|0x1FA27CF8|0x242070DB|0x08000|0xC1BDCEEE|0xF57C0FAF|0x4787C62A|0xF7537E82|0xA8304613|0xFD469501|0xC4AC5665|59|0xFFFF5BB1|0x895CD7BE|0xF4292244|0xCA62C1D6|0x432AFF97|0xFD987193|0x6B901122|0x8F1BBCDC|0xA679438E|0xBD3AF235|60|0xAB9423A7||0x49B40821||MD5|0xF61E2562|0xC040B340|0x265E5A51|0xFC93A039|0xE9B6C7AA||0xC0000000|0xD62F105D|0x5A827999|0x2441453|0xD8A1E681|0x655B59C3|0xE7D3FBC8|0x2AD7D2BB|0x21E1CDE6|0x698098D8|0x8B44F7AF|0xC33707D6|0xF4D50D87|0x455A14ED|0xA9E3E905|0xFFEFF47D|0xFCEFA3F8|0x0800000|0x6ED9EBA1|0x676F02D9|255|0x85845DD1|substr|0x8D2A4C8A|0xFFFA3942|0x8771F681|0x6FA87E4F|80|0x6D9D6122|0x8F0CCC92|0xFDE5380C|0xC3D2E1F0|switch|0xA4BEEA44|0x4BDECFA9|0xFE2CE6E0|0xF6BB4B60|0xBEBFBC70|0x289B7EC6|0xEAA127FA|0xA3014314|0xD4EF3085|SHA1|0xEB86D391|0x4881D05|0x080000000|40'.split('|'),0,{}));

/* Fonctions sur strings */
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