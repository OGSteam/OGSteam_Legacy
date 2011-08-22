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