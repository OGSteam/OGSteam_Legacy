function OGSFox_saveOptions()
{
	var OGSFoxPrefs = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService).getBranch("ogsfox.");
	OGSFoxPrefs.setCharPref("url", document.getElementById("ogspy_url").value);
	OGSFoxPrefs.setCharPref("user", document.getElementById("ogspy_user").value);
	OGSFoxPrefs.setCharPref("pass", document.getElementById("ogspy_pass").value);
	window.close();
}

function getPrefString(value)
{
	var val = null;
	var OGSFoxPrefs = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService).getBranch("ogsfox.");
	
	if (OGSFoxPrefs.prefHasUserValue(value) && (OGSFoxPrefs.getPrefType(value) == OGSFoxPrefs.PREF_STRING))
	{
		val = OGSFoxPrefs.getCharPref(value);
	}
	return val;
}

function OGSFox_initOptions()
{
	document.getElementById("ogspy_url").value = getPrefString("url");
	document.getElementById("ogspy_user").value = getPrefString("user");
	document.getElementById("ogspy_pass").value = getPrefString("pass");
}
