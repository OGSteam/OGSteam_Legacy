/**
 * @author Unibozu
 * @author Jedinight
 * @license GNU/GPL
 */

function ServerItem (n) {
	this.save = function () {
		Xprefs.setChar('server'+this.n, '({univers: "'+this.univers+'", url: "'+this.url+'", user: "'+this.user+'", password: "'+this.password+'", hash: "'+MD5(SHA1(this.password))+'", active: '+this.active+'})');
		Xprefs.setChar('server-cache', '({name: "'+this.name+'", version: "'+this.version+'"})');
		Xprefs.setChar('server-cache'+this.n, '({name: "'+this.name+'", version: "'+this.version+'"})');
	}
	
	this.load = function () {
		var data = eval(Xprefs.getChar('server'+n));
		if (data) {
			_empty = false;
			for (var i in data) this[i] = data[i];
			var cachedData = eval(Xprefs.getChar('server-cache'+n));
			for (var i in cachedData) this[i] = cachedData[i];			
		}
	}
	
	this.equals = function (data) {
		for (var i in data) {
			if (data[i] != this[i] && i != 'active') return false;
		}
		return true;
	}
	
	this.cached = function () {
		return this.name != '' && this.version != '';
	}
	
	this.clear = function () {
		for (var i = 0, props = ['univers', 'url', 'user', 'password', 'hash', 'active', 'name', 'version'], len = props.length; i < len; i++) {
			delete this[props[i]];
		}
		Xprefs.setChar('server'+this.n, '');
	}
	
	this.empty = function () {
		return _empty;
	}
	
	this.set = function (name, value) {
		if (value) this[name] = value;
		else {
			for (var i in name) this[i] = name[i];
		}
	}
	
	this.n = n;
	var _empty = true;
	this.load();
}

