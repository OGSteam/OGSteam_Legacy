var url = "";
var user = "";
var pass = "";

// Instancie un nouvelle objet pour faire une requête (GET ou POST)
function _getXhr() {
	var conn;
	
	try {
		conn = new XMLHttpRequest();		
	}
	catch (error) {
		conn = false;
	}
	return conn;
}

// Récupère les informations de connexion
function getOptions() {
	var OGSFoxPrefs = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService).getBranch("ogsfox.");
	
	if (OGSFoxPrefs.prefHasUserValue("url")) url = OGSFoxPrefs.getCharPref("url");
	if (OGSFoxPrefs.prefHasUserValue("user")) user = encodeURI(OGSFoxPrefs.getCharPref("user"));
	if (OGSFoxPrefs.prefHasUserValue("pass")) pass = encodeURI(OGSFoxPrefs.getCharPref("pass"));
	if (url == "" || user == "" || pass == "")
	{
		window.openDialog('chrome://ogsfox/content/options.xul', 'Paramètrage', 'centerscreen, chrome, resizable, modal').focus();
		if (OGSFoxPrefs.prefHasUserValue("url")) url = OGSFoxPrefs.getCharPref("url");
		if (OGSFoxPrefs.prefHasUserValue("user")) user = encodeURI(OGSFoxPrefs.getCharPref("user"));
		if (OGSFoxPrefs.prefHasUserValue("pass")) pass = encodeURI(OGSFoxPrefs.getCharPref("pass"));
	}

}

// Procédure simple pour s'identifier.
function login() {
	var xrequest = _getXhr();
	xrequest.onreadystatechange = function()
	{
		if (xrequest.readyState == 4 && xrequest.status == 200)
		{
			if (DEBUG) alert("login :\n" + xrequest.responseText);
		}
	};
	getOptions();
	var req = url + "index.php?action=login&name=" + user + "&pass=" + pass;
	xrequest.open("GET", req, true);
	xrequest.setRequestHeader("User-Agent", "OGSClient");
	xrequest.send(null);
}

// Envoie les données
function sendDatas(action, data) {
	var xrequest = _getXhr();
	xrequest.onreadystatechange = function()
	{
		if (xrequest.readyState == 4 && xrequest.status == 200)
		{
			if (DEBUG) alert("sendDatas :\n" + xrequest.responseText);
		}
	};
	var req = url + "index.php?action=" + action + "&name=" + user + "&pass=" + pass;
	xrequest.open("POST", req, true);
	xrequest.setRequestHeader("User-Agent", "OGSClient");
	xrequest.setRequestHeader("Content-Type", "text/xml");
	xrequest.send(data);
}