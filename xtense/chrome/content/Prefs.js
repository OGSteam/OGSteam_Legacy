/**
 * @author Unibozu
 * @license GNU/GPL
 */

var Xprefs = {
	isset : function(name) {
		try { return this.branch.prefHasUserValue(name) == true; }
		catch (e) { show_backtrace(e); }
		return false;
	},
	
	setInt : function (name, value) {
		try { this.branch.setIntPref(name, value); }
		catch (e) { show_backtrace(e); }
	},
	
	setChar : function (name, value) {
		try { this.branch.setCharPref(name, value); }
		catch (e) { show_backtrace(e); }
	},
	
	setBool : function (name, value) {
		try { this.branch.setBoolPref(name, value == true); }
		catch (e) { show_backtrace(e); }
	},
	
	getInt : function (name) {
		try { return this.branch.getIntPref(name); }
		catch (e) {
			dump('Pref error: '+name);
			show_backtrace(e);
		}
		return 0;
	},
	
	getChar : function (name) {
		try { return this.branch.getCharPref(name); }
		catch (e) {
			dump('Pref error: '+name);
			show_backtrace(e);
		}
		return '';
	},

	getBool : function (name,defval) {
		try { return this.branch.getBoolPref(name); }
		catch (e) {
			if(typeof defval != 'undefined')
				return defval;
			else return false;
		}
		return false;
	},
	
	restore : function (name) {
		if (this.branch.prefHasUserValue(name)) this.branch.clearUserPref(name);
	},
	
	branch : Cc["@mozilla.org/preferences-service;1"].getService(Ci.nsIPrefService).getBranch('Xtense.')
}