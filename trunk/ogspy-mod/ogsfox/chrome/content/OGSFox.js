const DEBUG = true;
var logged = false;
var pattern = new Array();
pattern[0] = /Syst.me.solaire?.(\d)\:(\d+)/;
pattern[1] = /(Mati.res\spremi.res\ssur(.*?)\s\[(([\d]+):([\d]+):([\d]+))\]\sle\s([\d]+)-([\d]+)\s+([\d]+)\:([\d]+)\:([\d]+)[^%]*Probabilit.\sde\sdestruction\sde\sla\sflotte\sd[\\]?'espionnage\s:(\d+)%)/;

window.addEventListener("load", initOverlay, false);

// Nécessaire pour intéragir avec le clic droit
function initOverlay() {
  var menu = document.getElementById("contentAreaContextMenu");
  menu.addEventListener("popupshowing", contextPopupShowing, false);
}

// Affiche notre menu que si du texte est sélectionné
function contextPopupShowing() {
  gContextMenu.showItem("context-ogspy", gContextMenu.isTextSelected);
}

// Récupère le texte sélectionné
function _getSel() {
  var focusedWindow = document.commandDispatcher.focusedWindow;
  var searchStr = focusedWindow.getSelection.call(focusedWindow);
  searchStr = searchStr.toString();
  return searchStr;
}

// Test des différents types de données à envoyer
function OGSFox() {
	var str = _getSel();

	if (logged == false) { login(); logged = true; }
	if (pattern[0].test(str)) // galaxie
		parseGalaxy(str);
	if (pattern[1].test(str)) // rapport d'espionnage
		parseSpyreport(str);
}