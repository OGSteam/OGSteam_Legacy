const DEBUG = true;
var logged = false;
var pattern = new Array();
pattern[0] = /Syst.me.solaire?.(\d)\:(\d+)/;
pattern[1] = /(Mati.res\spremi.res\ssur(.*?)\s\[(([\d]+):([\d]+):([\d]+))\]\sle\s([\d]+)-([\d]+)\s+([\d]+)\:([\d]+)\:([\d]+)[^%]*Probabilit.\sde\sdestruction\sde\sla\sflotte\sd[\\]?'espionnage\s:(\d+)%)/;

window.addEventListener("load", initOverlay, false);

// N�cessaire pour int�ragir avec le clic droit
function initOverlay() {
  var menu = document.getElementById("contentAreaContextMenu");
  menu.addEventListener("popupshowing", contextPopupShowing, false);
}

// Affiche notre menu que si du texte est s�lectionn�
function contextPopupShowing() {
  gContextMenu.showItem("context-ogspy", gContextMenu.isTextSelected);
}

// R�cup�re le texte s�lectionn�
function _getSel() {
  var focusedWindow = document.commandDispatcher.focusedWindow;
  var searchStr = focusedWindow.getSelection.call(focusedWindow);
  searchStr = searchStr.toString();
  return searchStr;
}

// Test des diff�rents types de donn�es � envoyer
function OGSFox() {
	var str = _getSel();

	if (logged == false) { login(); logged = true; }
	if (pattern[0].test(str)) // galaxie
		parseGalaxy(str);
	if (pattern[1].test(str)) // rapport d'espionnage
		parseSpyreport(str);
}