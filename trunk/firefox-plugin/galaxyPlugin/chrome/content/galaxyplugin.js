
// Get the "extensions.gtplugin." branch

var prefs = GTPlugin_getPrefs();
var GTPlugin_activated = 0;
var GTPlugin_result = 2;
var GTPlugin_selectedTyp = -1;
var GTPlugin_selectedWer = -1;
var GTPlugin_selectedGalaxy = -1;
var GTPlugin_selectedSystem = -1;
var GTPlugin_selectedRanks = -1;
var GTPlugin_Messagedoc;

function init() { GTPlugin_ext.init(); }

window.addEventListener("load", init, false);

var GTPlugin_ext = {
	init: function() {
		var appcontent = document.getElementById("appcontent");   // browser
		if(appcontent)
		appcontent.addEventListener("load", this.onPageLoad, true);
		var messagepane = document.getElementById("messagepane"); // mail
		if(messagepane)
		messagepane.addEventListener("load", this.onPageLoad, true);
		var prefs = GTPlugin_getPrefs();
		if (prefs.getBoolPref("gtplugin.settings.autostarten") == true)
		GTPlugin_Activate();
	},

	onPageLoad: function(aEvent) {

		if (GTPlugin_activated == 0) return;
		var doc = aEvent.originalTarget; // doc is document that triggered "onload" event
		var text;
		// do something with the loaded page.
		// doc.location is a Location object (see below for a link).
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString( "toolbar.status.nothing" );
		if(doc.location.href.search("/game/galaxy.php") > -1) {
			// break if foxgame reduced galaxyview or enhanced debris field is enabled

			try {
				if (fgGetBooleanPref("foxgameRemovePlanets",true)) {
					// reduced galaxyview activated
					GTPlugin_selectedGalaxy = GTPlugin_getGalaxy(doc);
					GTPlugin_selectedSystem = GTPlugin_getSystem(doc);

					document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("galaxyfound.prefix")+GTPlugin_selectedGalaxy+":"+GTPlugin_selectedSystem+GTPlugin_GetLocString("galaxyfound.suffix");
					text = GTPlugin_get_galaxyview_data(doc,true);

				} else {
					// foxgame installed, but no reduced galaxyview activated
					GTPlugin_selectedGalaxy = GTPlugin_getGalaxy(doc);
					GTPlugin_selectedSystem = GTPlugin_getSystem(doc);

					document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("galaxyfound.prefix")+GTPlugin_selectedGalaxy+":"+GTPlugin_selectedSystem+GTPlugin_GetLocString("galaxyfound.suffix");
					text = GTPlugin_get_galaxyview_data(doc,false);
				}
			} catch(e) {
				// no foxgame installed
				GTPlugin_selectedGalaxy = GTPlugin_getGalaxy(doc);
				GTPlugin_selectedSystem = GTPlugin_getSystem(doc);

				document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("galaxyfound.prefix")+GTPlugin_selectedGalaxy+":"+GTPlugin_selectedSystem+GTPlugin_GetLocString("galaxyfound.suffix");
				text = GTPlugin_get_galaxyview_data(doc,false);
			}
			GTPlugin_result = GTPlugin_sendText("galaxy",text,doc.location.href);

		}
		if(doc.location.href.search("/game/stat.php") > -1) {
			GTPlugin_selectedTyp = GTPlugin_getStatsTyp(doc);
			GTPlugin_selectedWer = GTPlugin_getStatsWho(doc);
			GTPlugin_selectedRanks = GTPlugin_getStatswhitch(doc);
			document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("statsfound");

			var text = GTPlugin_getStatsText(doc);
			GTPlugin_result = GTPlugin_sendText("stats",text,doc.location.href);
		}
		if(doc.location.href.search("/game/messages.php") > -1) {
			document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("reportsfound");
			GTPlugin_Messagedoc = doc;
		}
		// Allyhistory
		if((doc.location.href.search("/game/allianzen.php") > -1) && (doc.location.href.search("&a=4") > -1)) {
			GTPlugin_result = GTPlugin_sendText("allyhistory",doc.getElementsByTagName("table")[4].innerHTML,doc.location.href);
		}


	}
}

function GTPlugin_FindReports() {
	// get information about what ranks were selected
	try {
		var messageElements = GTPlugin_Messagedoc.getElementsByTagName("table")[5].innerHTML;
		GTPlugin_result = GTPlugin_sendText("reports",messageElements,GTPlugin_Messagedoc.location.href);
	} catch(e) {
		//alert(e);
	}
}

function GTPlugin_getGalaxy(docroot) {
	// get information about what galaxy selected
	try {
		if (parseInt(docroot.getElementsByTagName("input")[3].value) > 0) {
			return docroot.getElementsByTagName("input")[3].value;
		} else {
			return docroot.getElementsByTagName("input")[4].value;
		}
	} catch (e){
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("gt_error.gvnotupdated");
		//alert(GTPlugin_GetLocString("erroralert: ")+e);
		return -1;
	}
}

function GTPlugin_getSystem(docroot) {
	// get information about what system selected
	try {
		if (parseInt(docroot.getElementsByTagName("input")[6].value) > 0) {
			return docroot.getElementsByTagName("input")[6].value;
		} else {
			return docroot.getElementsByTagName("input")[7].value;
		}
	} catch (e){
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("gt_error.gvnotupdated");
		//alert(GTPlugin_GetLocString("erroralert: ")+e);
		return -1;
	}

}

function GTPlugin_getStatsWho(docroot) {
	// get information about what was selected - player=0 or ally=1
	var optionElements = docroot.getElementsByTagName("select")[1].getElementsByTagName("option");
	for (var j = 0; j < optionElements.length; j++) {
		var optionElement = optionElements.item(j);
		if (optionElement.hasAttribute("selected")) {
			return j;
		}
	}
	return -1;
}


function GTPlugin_getStatsTyp(docroot) {
	// get information about what was selected - points=0 or fleet=1 or research=2
	var optionElements = docroot.getElementsByTagName("select")[2].getElementsByTagName("option");
	for (var j = 0; j < optionElements.length; j++) {
		var optionElement = optionElements.item(j);
		if (optionElement.hasAttribute("selected")) {
			return j;
		}
	}
	return -1;
}

function GTPlugin_getStatswhitch(docroot) {
	// get information about what ranks were selected
	var optionElements = docroot.getElementsByTagName("select")[3].getElementsByTagName("option");
	for (var j = 0; j < optionElements.length; j++) {
		var optionElement = optionElements.item(j);
		if (optionElement.hasAttribute("selected")) {
			return optionElement.innerHTML;
			//return j;
		}
	}
	return -1;
}

function GTPlugin_getStatsText(docroot) {
	/* Most parts used from Dr|Willy's Version */
	var rows = docroot.getElementsByTagName('table')[5].rows;
	var cells;
	if(GTPlugin_selectedWer == 0) { //Players
		var ranks = new Array(100);
		var players = new Array(100);
		var pIds = new Array(100);
		var alliances = new Array(100);
		var points = new Array(100);
		var j;
		var pIdRegExp = /messageziel\=(\d+)/;

		for(var i = rows.length - 2; i >= 0; i--) {
			j = 0;
			cells      = rows[i+1].cells;
			ranks[i]   = parseInt(cells[j++].innerHTML);
			players[i] = cells[j++];

			while(players[i].firstChild) {
				players[i] = players[i].firstChild;
			}

			players[i] = players[i].nodeValue;
			try {
				//TODO: Saubere Loesung
				pIds[i] = cells[j++].innerHTML.match(pIdRegExp)[1];
			} catch(e) { }
			alliances[i] = cells[j++].innerHTML;
			points[i]    = parseInt(cells[j].innerHTML);
		}

		var data = "";
		data += "&ranks=" + ranks.join("|");
		data += "&players=" + players.join("|");
		data += "&pIds=" + pIds.join("|");
		data += "&alliances=" + alliances.join("|");
		data += "&points=" + points.join("|");
	} else { //Alliances
		var ranks = new Array(100);
		var alliances = new Array(100);
		var members = new Array(100);
		var points = new Array(100);
		var j;
		for(var i = rows.length - 2; i >= 0; i--) {
			j = 0;
			cells = rows[i+1].cells;
			ranks[i] = parseInt(cells[j++].innerHTML);
			alliances[i] = cells[j++];
			while(alliances[i].firstChild)
			alliances[i] = alliances[i].firstChild;
			alliances[i] = alliances[i].nodeValue;
			j++;
			members[i] = cells[j++].innerHTML;
			points[i] = cells[j++].innerHTML;
		}
		var data = "";
		data += "&ranks=" + ranks.join("|");
		data += "&alliances=" + alliances.join("|");
		data += "&members=" + members.join("|");
		data += "&points=" + points.join("|");
	}
	return data;
}

function GTPlugin_get_galaxyview_data(docroot,foxgame) {

	var rows = docroot.getElementsByTagName('table')[3].rows;
	var cells;
	var galaxyview = new Array(15);
	var galaxy_content;
	var posRegExp = />(\d+)<\/a>/;
	var debrisRegExp = /:[a-zA-Z&;\/<>]+([0-9\.]+)[a-zA-Z&;\/<>]+:[a-zA-Z&;\/<>]+([0-9\.]+)/;

	var moonsize;
	var metal_debris;
	var crystal_debris;
	var planetname;
	var corrector = 0;
	if (foxgame == true) {
		corrector = 1; // foxgame removes the planet, so substract 1 from cellarray
	}

	// Foxgame may add a row at the top of the table with its own buttons for submitting to a database such as galaxietool
	// currently it only adds one, but assume it may add a few.. 10 should be a safe upper bound
	var systemRowRegExp = / \d:\d{1,3}/;
	var systemRow = 0;
	for(var i = 0; i < 10; i++) {
		cells = rows[i].cells;
		if(cells[0].innerHTML.match(systemRowRegExp)) {
			systemRow = i;
			break;
		}
	}

	// find the word for "solar system" to determine the language later
	cells = rows[0].cells;
	var solar_system = cells[0].innerHTML;
	solar_system = solar_system.replace(/\s/,"");

	for(var i = 2; i < 17; i++) {
		// reset data
		moonsize = 0;
		metal_debris = 0;
		crystal_debris = 0;
		playerid = 0;
		playerstatus = "";
		playername = "";
		planetname = "";
		alliance = "";

		cells = rows[i].cells;
		try {
			moonsize = parseInt(cells[3-corrector].getElementsByTagName('img')[0].getAttribute('alt').match(/(\d+)/)[1]);
		} catch(e) { /* no moon */ }
		try {
			var tmp = cells[4-corrector].innerHTML.match(debrisRegExp);
			metal_debris = parseInt(tmp[1].replace(".","").replace(".","").replace(".",""));
			crystal_debris = parseInt(tmp[2].replace(".","").replace(".","").replace(".",""));
		} catch(e) { /* no debris field */ }

		if (foxgame == true) {
			try {
				// in reach of a phalanx
				planetname = cells[2-corrector].getElementsByTagName('a')[0].getElementsByTagName('a')[0].innerHTML;
			}catch(e) { /* no planet */
				// not in reach of a phalanxy
				try {
					planetname = cells[2-corrector].getElementsByTagName('a')[0].innerHTML;
				}catch(e) { /* no planet */ }
			}

		} else {
			try {
				// planet is in reach of a phalanx
				planetname = cells[2].getElementsByTagName('a')[0].innerHTML;
			} catch(e) {
				// not in reach of a phalanx
				planetname = cells[2].innerHTML;
			}
		}


		planetname = planetname.replace(/\([0-9a-zA-Z\*\s]+\)/,""); // remove activity behind planet name
		planetname = planetname.replace("&nbsp;","");
		planetname = planetname.replace(/\s/,"");

		galaxy_content = parseInt(cells[0].innerHTML.match(posRegExp)[1])+"|"; // position
		galaxy_content += planetname+"|"; // planetname
		galaxy_content += moonsize+"|"; // moon
		galaxy_content += metal_debris+"|"; // metal debris field
		galaxy_content += crystal_debris+"|"; // crystal debris field
		try {
			playername = cells[5-corrector].getElementsByTagName('span')[0].innerHTML; // playername
			// get playerstats - at max 6 (i,I,u,g,s,n)
			for (var j=1; j<7; j++) {
				playerstatus += cells[5-corrector].getElementsByTagName('span')[j].innerHTML;
			}

		} catch(e) { /* catch when there is no player or last playerstatus was found */ }
		galaxy_content += playername+"|";
		galaxy_content += playerstatus+"|"; // add playerstats
		try {
			try {
				// own alliance
				alliance = cells[6-corrector].getElementsByTagName('a')[0].getElementsByTagName('span')[0].innerHTML; // alliance
			} catch(e) {
				// another alliance
				alliance = cells[6-corrector].getElementsByTagName('a')[0].innerHTML; // alliance
			}
			alliance = alliance.replace(/\n+/,"");
		} catch(e) { /* catch when there is no alliance */ }
		galaxy_content += alliance+"|";

		// try to find the playerid
		try {
			playerid = parseInt(cells[7-corrector].getElementsByTagName('a')[1].getAttribute('href').match(/messageziel=(\d+)/)[1]);
		} catch(e) { /* no playerid found (no planet or the players' planet */ }
		galaxy_content += playerid;

		// delete all \n within this string
		galaxy_content = galaxy_content.replace(/\n+/,"");
		galaxyview[i] = galaxy_content;
	}
	var galaxystring = solar_system + galaxyview.join("\n");
	return galaxystring;
}


function GTPlugin_sendText(typ,text,source_url) {
	try {
		if (source_url.search(prefs.getCharPref("gtplugin.settings.ogameurl1")) > -1) {
			var txt = "user="+prefs.getCharPref("gtplugin.settings.username1")+"&password="+prefs.getCharPref("gtplugin.settings.password1")+"&typ="+typ;
			var url = prefs.getCharPref("gtplugin.settings.url1");
		} else if (source_url.search(prefs.getCharPref("gtplugin.settings.ogameurl2")) > -1) {
			var txt = "user="+prefs.getCharPref("gtplugin.settings.username2")+"&password="+prefs.getCharPref("gtplugin.settings.password2")+"&typ="+typ;
			var url = prefs.getCharPref("gtplugin.settings.url2");
		} else if (source_url.search(prefs.getCharPref("gtplugin.settings.ogameurl3")) > -1) {
			var txt = "user="+prefs.getCharPref("gtplugin.settings.username3")+"&password="+prefs.getCharPref("gtplugin.settings.password3")+"&typ="+typ;
			var url = prefs.getCharPref("gtplugin.settings.url3");
		} else if (source_url.search(prefs.getCharPref("gtplugin.settings.ogameurl4")) > -1) {
			var txt = "user="+prefs.getCharPref("gtplugin.settings.username4")+"&password="+prefs.getCharPref("gtplugin.settings.password4")+"&typ="+typ;
			var url = prefs.getCharPref("gtplugin.settings.url4");
		} else if (source_url.search(prefs.getCharPref("gtplugin.settings.ogameurl5")) > -1) {
			var txt = "user="+prefs.getCharPref("gtplugin.settings.username5")+"&password="+prefs.getCharPref("gtplugin.settings.password5")+"&typ="+typ;
			var url = prefs.getCharPref("gtplugin.settings.url5");
		} else {
			document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.unknownuni");
			return;
		}

		var responsetext = "";

		if (typ == "stats") {
			txt = txt + "&who="+GTPlugin_selectedWer+"&what="+GTPlugin_selectedTyp;
			if (GTPlugin_selectedWer == 0) responsetext = GTPlugin_GetLocString("statsupdated.playerprefix");
			if (GTPlugin_selectedWer == 1) responsetext = GTPlugin_GetLocString("statsupdated.allyprefix");
			if (GTPlugin_selectedTyp == 0) responsetext = responsetext + GTPlugin_GetLocString("statsupdated.scoreinfix")+GTPlugin_selectedRanks+GTPlugin_GetLocString("statsupdated.suffix");
			if (GTPlugin_selectedTyp == 1) responsetext = responsetext + GTPlugin_GetLocString("statsupdated.fleetinfix")+GTPlugin_selectedRanks+GTPlugin_GetLocString("statsupdated.suffix");
			if (GTPlugin_selectedTyp == 2) responsetext = responsetext + GTPlugin_GetLocString("statsupdated.researchinfix")+GTPlugin_selectedRanks+GTPlugin_GetLocString("statsupdated.suffix");
		}

		if (typ == "galaxy") {
			txt = txt + "&galaxy="+GTPlugin_selectedGalaxy+"&system="+GTPlugin_selectedSystem;
			responsetext = GTPlugin_GetLocString("galaxyupdated.prefix")+GTPlugin_selectedGalaxy+":"+GTPlugin_selectedSystem+GTPlugin_GetLocString("galaxyupdated.suffix");
		}

		if (typ == "reports") {
			responsetext = GTPlugin_GetLocString("reportsupdated");
		}
		if (typ == "allyhistory") {
			responsetext = GTPlugin_GetLocString("allyhistoryupdated");
		}

		txt = txt + "&content=" + encodeURIComponent(text); // needed to send data with special chars like \s or \n


		var httpRequest = new XMLHttpRequest();
		httpRequest.open("POST", url, true); // 3. Parameter ist für asynchronen Transfer nötig
		httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		httpRequest.setRequestHeader("Content-Length", txt.length);
		httpRequest.send(txt);

		httpRequest.onreadystatechange = function () {

			if (httpRequest.readyState != 4) {
				//alert('Bad Ready State: ' + httpRequest.status);
				//document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.badreadystate")+httpRequest.status;
				return 0;
			} else {
				/*
				* Status Codes:
				- 200 = gernally okay
				- 403 = forbidden
				- Response Text:
				- 601: galaxy view inserted
				- 602: problem with inserting galaxy view
				- 611: report inserted
				- 612: at least one report was wrong
				- 621: stats updated
				- 622: stats not updated
				- 631: allyhistory updated
				- 632: allyhistory not updated
				*/

				if (httpRequest.status == 403) { // forbidden
					document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.permissiondenied");
					return 0;
				} else if (httpRequest.status == 404) { // Server responsed
					document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.pagenotfound");
					return 0;
				} else if (httpRequest.status == 200) { // Server responsed
					if ((parseInt(httpRequest.responseText) == 601) || (parseInt(httpRequest.responseText) == 611) ||
					(parseInt(httpRequest.responseText) == 621) || (parseInt(httpRequest.responseText) == 631)) { // gv updated
						document.getElementById("GTPlugin-status-view").value = responsetext;
						return 1;
					} else if (parseInt(httpRequest.responseText) == 602) { // gv not updated
						document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.gvnotupdated");
						return 0;
					} else if (parseInt(httpRequest.responseText) == 612) { // at least 1 report not inserted
						document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.reporterror");
						return 0;
					} else if (parseInt(httpRequest.responseText) == 622) { // stats not updated
						document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.statserror");
						return 0;
					} else if (parseInt(httpRequest.responseText) == 632) { // allyhistory not updated
						document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.allyhistoryerror");
						return 0;
					}
				} else {
					document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.badstatuscode")+httpRequest.status;
					return 0;
				}

			}
		};


	} catch (e){
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("error.gtservernotfound");
		//alert('An error has occured calling the external site: '+e);
		return 0;
	}
	return 0;
}

function GTPlugin_getPrefs() {
	return Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);
}

function GTPlugin_Activate() {
	if (GTPlugin_activated == 0) {
		GTPlugin_activated = 1;
		document.getElementById("GTPlugin-activate").setAttribute("tooltiptext", GTPlugin_GetLocString("toolbar.deactivate.t"), 0);
		document.getElementById("GTPlugin-activate").setAttribute("label", GTPlugin_GetLocString("toolbar.deactivate"), 0);
		document.getElementById("GTPlugin-activate").setAttribute("image", "chrome://galaxyplugin/skin/images/disable.gif", 0);
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("toolbar.deactivate.status");
		//        window.addEventListener("load", init, true);
	} else {
		GTPlugin_activated = 0;
		document.getElementById("GTPlugin-activate").setAttribute("tooltiptext", GTPlugin_GetLocString("toolbar.activate.t"), 0);
		document.getElementById("GTPlugin-activate").setAttribute("label", GTPlugin_GetLocString("toolbar.activate"), 0);
		document.getElementById("GTPlugin-activate").setAttribute("image", "chrome://galaxyplugin/skin/images/enable.gif", 0);
		document.getElementById("GTPlugin-status-view").value = GTPlugin_GetLocString("toolbar.activate.status");
		//        window.removeEventListener("load", init, true);
	}
}

function GTPlugin_Options() {
	var windowobject = window.openDialog("chrome://galaxyplugin/content/galaxyoptions.xul", "options", "chrome,width=600,height=300");
}

function GTPlugin_TrimString(string) {
	// Return empty if nothing was passed in
	if (!string) return "";

	// Efficiently replace any leading or trailing whitespace
	var value = string.replace(/^\s+/, '');
	value = value.replace(/\s+$/, '');

	// Replace any multiple whitespace characters with a single space
	value = value.replace(/\s+/g, ' ');

	// Return the altered string
	return value;
}

function GTPlugin_GetLocString(string)
{
	var locString = document.getElementById( "gtStrings" ).getString( "gt_" + string );

	locString = locString.replace(/^[.]/, '');
	locString = locString.replace(/[.]$/, '');
	return locString;
}
