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

function nbsp(text) {
	return text.replace(/\&nbsp;/gi, '');
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
function GetGalaxy()
{
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
					var pos = cells[0].textContent;
     
					var playerSpans = cells[2].getElementsByTagName("span");
					var player = "";
					if (playerSpans.length> 0)
					{
						player = trim(playerSpans[0].textContent.replace("\n",""));
					}
					var ally = "";
					if (playerSpans.length> 1)
					{
						ally = trim(playerSpans[1].textContent.replace("\n",""));   
					}
					var planet = cells[1].innerHTML;
					planet= trim(planet.substring(0,planet.indexOf('<')));

					galaxy += pos+"\t"+player +"\t"+ally+"\t"+planet+"\t"; 
					galaxy += "\n";					
				}
				
				data = new Array();
				data[0] = galaxy;
				data[1] = x;
				data[2] = y;

					SendData('galaxy', data, id);
			}
		}
	}
}

//---------------------- Récuperation du classement -------------------------//
function getRanking(){
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
					var r = rank.getElementsByTagName("tr");
					var ranking = "";
		
					for (var i = 1; i < 100; i++)
					{
						var line = lines[i];
						var cells = line.getElementsByTagName("td");
						var rank1 = trim(cells[1].textContent);
						var ally = trim(cells[3].textContent);
						var player = trim(cells[2].textContent);

						var tot = Number(RemovePoint(cells[4].getAttribute("title")));
						var build = Number(RemovePoint(cells[5].getAttribute("title")));
						var res = Number(RemovePoint(cells[6].getAttribute("title")));
						var fleetdef = Number(RemovePoint(cells[7].getAttribute("title")));

						ranking += rank1+"\t"+player+"\t"+ally+"\t"+tot+"\t"+build+"\t"+res+"\t"+fleetdef+"\n";
					}
					
					data = new Array();
					data[0] = ranking;
					
					SendData('ranking', data, id);
			}
		}
	}
}

//---------------------- Récuperation du rapport d'espionnage -------------------------//
function GetSpy() {
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
				var r = msg.getElementsByTagName("tr");
				var spy = "";
	
				for (var i = 2; i < r.length; i++)
				{
					var c = r[i].getElementsByTagName("td");
				}
			}
		}
	}
}

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

  var os = Components.classes["@mozilla.org/observer-service;1"]
                     .getService(Components.interfaces.nsIObserverService);
  var cancelQuit = Components.classes["@mozilla.org/supports-PRBool;1"]
                             .createInstance(Components.interfaces.nsISupportsPRBool);
  os.notifyObservers(cancelQuit, "quit-application-requested", null);

  if (cancelQuit.data)
    return;

  os.notifyObservers(null, "quit-application-granted", null);

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

