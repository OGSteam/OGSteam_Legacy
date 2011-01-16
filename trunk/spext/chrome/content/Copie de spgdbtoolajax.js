var SPGdbprefs = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);

function SPGdbAJAX_trim(text){
	var text = text.replace(/^\s+/, '');
	return text.replace(/\s+$/, '');
}

function RemoveHTMLTags(texte){
  var exp1=new RegExp("\\<.*?\\>","g"); 
  return texte.replace(exp1,"");
}

function RemoveIGU(texte){ 
  var exp1=new RegExp("\\(.*?\\)","g"); 
  return texte.replace(exp1,"");
}

//---------------------- Suppression des points -------------------------//
function RemovePoint(texte) { 
return texte.replace(/\./g, ''); 
}

function SPGdbAJAX_encode(text){
	var text = encodeURIComponent(text);
	text = text.replace(/%C3%A8/gi,"%E8");
	text = text.replace(/%C3%A9/gi,"%E9");
	text = text.replace(/%C2%A0/gi,"%20");
	text = text.replace(/%C2/gi,"");
	
	return text;
}

function SPGdbAJAX_getSPserver(id) {
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

function SPGdbAJAX_sendData(what, data, id){
	var root = SPGdbprefs.getCharPref("spgdbtoolajax.root");
	
	data[0] = SPGdbAJAX_encode(data[0]);
	
	var user = SPGdbprefs.getCharPref("spgdbtoolajax.username");
	user = SPGdbAJAX_encode(user);
	
	var pass = SPGdbprefs.getCharPref("spgdbtoolajax.password");
	pass = SPGdbAJAX_encode(pass);
	
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

function greload()
{ 
status_timer = setInterval("SPGdbAJAX_getGalaxy()", 500);
}

//---------------------- Récuperation de la galaxie -------------------------//
function SPGdbAJAX_getGalaxy(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = SPGdbAJAX_getSPserver(z);
		var doc =  window.content.document;

		if ( doc.location.host == hoststring )
		{
			var id = ( z == 1 ) ? '' : z;
			if ( sys = doc.getElementById('sys_navigation') )
			{
					var x = doc.getElementById("tpl_system_ppx").value;
					var y = doc.getElementById("tpl_system_ppy").value;
					var r = sys.getElementsByTagName("table");
					var galaxy = "";
		alert(x+" - "+y);
// jusque là ca fonctionne, 'alert' me renvoi bien la galaxie X et Y
					for (var i = 1; i <= 16; i++)
					{
						var c = r[i].getElementsByTagName("table");
						var pos = c[0].textContent;
						var ally = c[2].textContent;
						var planet = c[3].textContent;
						var player = c[4].textContent;
		
						galaxy += pos+"\t"+ally+"\t"+planet+"\t"+player+"\t";
						if ( oldname = c[4].innerHTML.match(/previous ([\x20-\x7e\x81-\xff]+), place/) )
							galaxy += oldname[1];
						else
							galaxy += player;
			
						galaxy += "\n";
					}
					data = new Array();
					data[0] = galaxy;
					data[1] = x;
					data[2] = y;
alert(data);
//					SPGdbAJAX_sendData('galaxy', data, id); // envois les données au serveur.
			}
			else
				break;
		}
	}
}
		

//---------------------- Récuperation du classement -------------------------//
function SPGdbAJAX_getRanking(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = SPGdbAJAX_getSPserver(z);
	
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
						
						if ( oldname = c[3].innerHTML.match(/Également connu sous le nom de: ([\x20-\x7e\x81-\xff]+)" color="/) )
							ranking += oldname[1];
						else
							ranking += player;
			
						ranking += "\n";
					}
					
					data = new Array();
					
					data[0] = ranking;
					
					SPGdbAJAX_sendData('ranking', data, id);
//				}
				break;
			}
			else
				break;
		}
	}
}

//---------------------- Récuperation du rapport d'espionnage -------------------------//
function SPGdbAJAX_getSpy(){
	for (var z = 1; z <= 3; z++)
	{
		var hoststring = SPGdbAJAX_getSPserver(z);
	
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

function SPGdbAJAX_options_init(){
		var root = SPGdbprefs.getCharPref("spgdbtoolajax.root");
		document.getElementById("SPGdbAJAX-options-root").value = root;
		var username = SPGdbprefs.getCharPref("spgdbtoolajax.username");
		document.getElementById("SPGdbAJAX-options-username").value = username;
		var password = SPGdbprefs.getCharPref("spgdbtoolajax.password");
		document.getElementById("SPGdbAJAX-options-password").value = password;
		var galaxyserver = SPGdbprefs.getCharPref("spgdbtoolajax.galaxy.server");
		document.getElementById("SPGdbAJAX-options-galaxy-server").value = galaxyserver;
}

function SPGdbAJAX_setPref(){
		var root = SPGdbAJAX_trim(document.getElementById("SPGdbAJAX-options-root").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.root", SPGdbAJAX_trim(root));
		var username = SPGdbAJAX_trim(document.getElementById("SPGdbAJAX-options-username").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.username", SPGdbAJAX_trim(username));
		var password = SPGdbAJAX_trim(document.getElementById("SPGdbAJAX-options-password").value);
		SPGdbprefs.setCharPref("spgdbtoolajax.password", SPGdbAJAX_trim(password));
		var galaxyserver = document.getElementById("SPGdbAJAX-options-galaxy-server").value;	
		SPGdbprefs.setCharPref("spgdbtoolajax.galaxy.server", galaxyserver);
}

function SPGdbAJAX_openOptions() {
	window.openDialog("chrome://spgdbtoolajax/content/options.xul", "spgdb-options", "chrome,centerscreen");
}

function SPGdbAJAX_openlog() {
	window.openDialog("chrome://spgdbtoolajax/content/log.xul", "spgdb-log", "chrome,centerscreen");
}

