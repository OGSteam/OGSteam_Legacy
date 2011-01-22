var SPGdbprefs = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);

function trim(text){
	var text = text.replace(/^\s+/, '');
	return text.replace(/\s+$/, '');
}

function RemovePoint(texte) { 
return texte.replace(/\./g, ''); 
}

function RemoveHTMLTags(texte){
  var exp1=new RegExp("\\<.*?\\>","g"); 
  return texte.replace(exp1,"");
}

function RemoveIGU(texte){ 
  var exp1=new RegExp("\\(.*?\\)","g"); 
  return texte.replace(exp1,"");
}

function Encode(text){
	var text = encodeURIComponent(text);
	text = text.replace(/%C3%A8/gi,"%E8");
	text = text.replace(/%C3%A9/gi,"%E9");
	text = text.replace(/%C2%A0/gi,"%20");
	text = text.replace(/%C2/gi,"");
	return text;
}

function GetSPserver(id) {
	if ( id == 1 ) id = '';

	var galaxyserver = SPGdbprefs.getCharPref("spgdbtoolajax.galaxy.server");
	
	switch(galaxyserver)
	{
		case 'fr':
			var hoststring = 'sp2.looki.fr';
			break;
		case 'de':
			var hoststring = 'sp2.looki.de';
			break;
		case 'uk':
			var hoststring = 'sp2.looki.co.uk';
			break;
	}
	
	return hoststring;
}

//---------------------- Envois des données -------------------------//
function SendData(what, data, id){
	var root = SPGdbprefs.getCharPref("spgdbtoolajax.root");
	
	data[0] = encode(data[0]);
	
	var user = SPGdbprefs.getCharPref("spgdbtoolajax.username");
	user = encode(user);
	
	var pass = SPGdbprefs.getCharPref("spgdbtoolajax.password");
	pass = encode(pass);
	
	var con = new XMLHttpRequest();
	
	if ( what == 'galaxy' )
		con.open("post", root+"tool_parse_galassia.php", true);
	else if ( what == 'ranking' )
		con.open("post", root+"tool_parse_classifica.php", true);
		
	con.setRequestHeader("content-type", "application/x-www-form-urlencoded; charset=ISO-8859-1");
	
	con.onreadystatechange = function()
	{
		if ( con.readyState === 4 )
		{
			if ( con.status == 200 )
			{
				var info = con.responseXML.getElementsByTagName('info')[0].firstChild.data;
				
				switch ( info )
				{
					case '0':
						document.getElementById("SPGdbAJAX-button-get"+what).style.listStyleImage = 'url("chrome://spgdbtoolajax/skin/fail.gif")';
						break;
					case '1':
						document.getElementById("SPGdbAJAX-button-get"+what).style.listStyleImage = 'url("chrome://spgdbtoolajax/skin/accept.png")';
						break;
					case '2':
						document.getElementById("SPGdbAJAX-button-get"+what).style.listStyleImage = 'url("chrome://spgdbtoolajax/skin/alert.gif")';
						break;
				}
			}
			else
				document.getElementById("SPGdbAJAX-button-get"+what).style.listStyleImage = 'url("chrome://spgdbtoolajax/skin/fail.gif")';
		}
		
		if ( con.readyState === 1 )
			document.getElementById("SPGdbAJAX-button-get"+what).style.listStyleImage = 'url("chrome://spgdbtoolajax/skin/working.gif")';
	}
	
	if ( what == 'galaxy' )
		con.send("x="+data[1]+"&y="+data[2]+"&galassia="+data[0]+"&user="+user+"&pass="+pass);
	else if ( what == 'ranking' )
		con.send("classifica="+data[0]+"&user="+user+"&pass="+pass);
		
}

function Greload()
{ 
status_timer = setInterval("GetGalaxy()", 100);
}

//---------------------- Récuperation de la galaxie -------------------------//
function GetGalaxy(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = getSPserver(z);
		var doc =  window.content.document;

		if ( doc.location.host == hoststring )
		{
			var id = ( z == 1 ) ? '' : z;
			if ( sys = doc.getElementById('obj_systemviewer') )
			{
					var x = doc.getElementById("tpl_system_ppx").value;
					var y = doc.getElementById("tpl_system_ppy").value;
					var galaxy = "";
					var r = sys.getElementsByTagName("table");
					var lines = r[0].getElementsByTagName("tr");

					for (var i = 1; i <= 16; i++)
					{
						var line = lines[i];
						var cells = line.getElementsByTagName("td");
						var pos = RemovePoint(cells[2].textContent);
						var playerSpans = cells[2].getElementsByTagName("span");
						var ally = playerSpans[1].textContent;
						var player = trim(playerSpans[0].textContent);
						var planet = cells[1].innerHTML;
						planet= trim(planet.substring(0,planet.indexOf('<')));

						galaxy += pos+"\t"+ally+"\t"+planet+"\t"+player+"\t";
						galaxy += player;//le oldname n'existe plus, ligne à retirer une fois le php corrigé
			
						galaxy += "\n";
					}
					data = new Array();
					data[0] = galaxy;
					data[1] = x;
					data[2] = y;

//					SendData('galaxy', data, id);
			}
			else
				break;
		}
	}
}

//---------------------- Récuperation du classement -------------------------//
function GetRanking(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = getSPserver(z);
	
		if ( window.content.location.host == hoststring )
		{
			var id = ( z == 1 ) ? '' : z;
	
			var doc = window.content.document;
			var rank;
			if ( rank = doc.getElementById('obj_hiscore_table') )
			{			
				if ( doc.location.href.match(/connect/) )
				{
					var r = rank.getElementsByTagName("tr");
					var ranking = "";
		
//					for (var i = 2; i < r.length; i++)
//					{
						var c = r[i].getElementsByTagName("td");
						var ally = c[2].textContent;
						var player = c[3].textContent;
						var type = c[4].textContent;
						var tot = Number(RemovePoint(c[5].textContent));
						var build = Number(RemovePoint(c[6].textContent));
						var res = Number(RemovePoint(c[7].textContent));
						var fleetdef = Number(RemovePoint(c[8].textContent));
						
						ranking += ally+"\t"+player+"\t"+type+"\t"+tot+"\t"+build+"\t"+res+"\t"+fleetdef+"\t";
						
						/*if ( oldname = c[3].innerHTML.match(/Également connu sous le nom de: ([\x20-\x7e\x81-\xff]+)" color="/) )
							ranking += oldname[1];
						else*/
							ranking += player;
			
						ranking += "\n";
					}
					
					data = new Array();
					
					data[0] = ranking;
					
//					SendData('ranking', data, id);
//				}
				break;
			}
			else
				break;
		}
	}
}

//---------------------- Récuperation du rapport d'espionnage -------------------------//
function GetSpy(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = getSPserver(z);
	
		if ( window.content.location.host == hoststring )
		{
			var id = ( z == 1 ) ? '' : z;
	
			var doc = window.content.document;
			var msg;
			
			if ( msg = doc.getElementById('obj_messages_messages') )
			{			
				if ( doc.location.href.match(/connect/) )
				{
					var r = msg.getElementsByTagName("tr");
					var spy = "";
		
					for (var i = 2; i < r.length; i++)
					{
						var c = r[i].getElementsByTagName("td");
			

}}}}}}

function Options_init(){
		var root = SPGdbprefs.getCharPref("spgdbtoolajax.root");
		document.getElementById("SPGdbAJAX-options-root").value = root;
		var username = SPGdbprefs.getCharPref("spgdbtoolajax.username");
		document.getElementById("SPGdbAJAX-options-username").value = username;
		var password = SPGdbprefs.getCharPref("spgdbtoolajax.password");
		document.getElementById("SPGdbAJAX-options-password").value = password;
		var galaxyserver = SPGdbprefs.getCharPref("spgdbtoolajax.galaxy.server");
		document.getElementById("SPGdbAJAX-options-galaxy-server").value = galaxyserver;
}

function SetPref(){
		var root = trim(document.getElementById("SPGdbAJAX-options-root").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.root", trim(root));
		var username = trim(document.getElementById("SPGdbAJAX-options-username").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.username", trim(username));
		var password = trim(document.getElementById("SPGdbAJAX-options-password").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.password", trim(password));
		var galaxyserver = document.getElementById("SPGdbAJAX-options-galaxy-server").value;	
		SPGdbprefs.setCharPref("spgdbtoolajax.galaxy.server", galaxyserver);
}

function OpenOptions() {
	window.openDialog("chrome://spgdbtoolajax/content/options.xul", "spgdb-options", "chrome,centerscreen");
}

function Openlog() {
	window.openDialog("chrome://spgdbtoolajax/content/log.xul", "spgdb-log", "chrome,centerscreen");
}

function Xreload_chrome() {
	Components.classes["@mozilla.org/chrome/chrome-registry;1"]
	.getService(Components.interfaces.nsIXULChromeRegistry)
	.reloadChrome();
}

function Xreload_firefox() {
	if (Xprefs.getBool('debug')) {
	try{
 const nsIAppStartup = Components.interfaces.nsIAppStartup;

  // Notify all windows that an application quit has been requested.
  var os = Components.classes["@mozilla.org/observer-service;1"]
                     .getService(Components.interfaces.nsIObserverService);
  var cancelQuit = Components.classes["@mozilla.org/supports-PRBool;1"]
                             .createInstance(Components.interfaces.nsISupportsPRBool);
  os.notifyObservers(cancelQuit, "quit-application-requested", null);

  // Something aborted the quit process. 
  if (cancelQuit.data)
    return;

  // Notify all windows that an application quit has been granted.
  os.notifyObservers(null, "quit-application-granted", null);

  // Enumerate all windows and call shutdown handlers
  var wm = Components.classes["@mozilla.org/appshell/window-mediator;1"]
                     .getService(Components.interfaces.nsIWindowMediator);
  var windows = wm.getEnumerator(null);
  while (windows.hasMoreElements()) {
    var win = windows.getNext();
    if (("tryToClose" in win) && !win.tryToClose())
      return;
  }
  Components.classes["@mozilla.org/toolkit/app-startup;1"].getService(nsIAppStartup)
            .quit(nsIAppStartup.eRestart | nsIAppStartup.eAttemptQuit);
				}catch(e){ufLog(e.name+": "+e.message+"line "+e.lineNumber);}
	}
	else {Xconsole('debug mode off, restart aborted');}
}

