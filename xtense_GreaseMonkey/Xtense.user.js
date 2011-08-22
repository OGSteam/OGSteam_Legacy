// ==UserScript==
// @name		Xtense
// @version     2.3.10
// @namespace	xtense.ogsteam.fr
// @include     http://*.ogame.*/game/index.php*
// @description Cette extensions permet d'envoyer des données d'Ogame à votre serveur OGSPY d'alliance
// ==/UserScript==

// Variables Xtense
var VERSION = "2.3.10";
var PLUGIN_REQUIRED = "2.3.10";
var callback = null;
var Xlocales = {};
var urlIcone = "http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/icones/xtense.gif";

const XLOG_WARNING = 1, XLOG_ERROR = 2, XLOG_NORMAL = 3, XLOG_SUCCESS = 4, XLOG_COMMENT = 5;


// Navigateurs
var isFirefox = (window.navigator.userAgent.indexOf('Firefox') > -1 ) ? true : false;
var isChrome = (window.navigator.userAgent.indexOf('Chrome') > -1 ) ? true : false;

// Variables globales
var url=location.href;// Adresse en cours sur la barre d'outils
var urlUnivers = url.match(new RegExp('(.*)\/game'))[1];
var numUnivers = urlUnivers.match(new RegExp('uni(.*).ogame'))[1];
var langUnivers = urlUnivers.match(new RegExp('ogame.(.*)'))[1];
var nomScript = 'Xtense';
var cookie = nomScript+"-"+numUnivers+"-";
var callback = null;

if(isChrome){
	
	function Ximplements (object, implement) { for (var i in implement) object[i] = implement[i];}
	function Xl(name) {
		try {
			if (!Xlocales[name]) {
				log('Unknow locale "'+name+'"');
				return '[Chaine non disponible]';
			}
			
			var locale = Xlocales[name];
			for (var i = 1, len = arguments.length; i < len; i++) {
				locale = locale.replace('$'+i, arguments[i]);
			}
			return locale;
		} catch (e) { alert(e); return false; }
	}
	
	/* Recupération de sources */
	function getRessourceAsUrl(url) { var xhr = new XMLHttpRequest(); var data = ""; xhr.onreadystatechange =  function(){ if(xhr.readyState == 4) data=xhr.responseText; }; xhr.open('GET', url+"?nocache="+Math.random(), false); xhr.send(null); return data;}
	
	/* Récupération des constantes */
	eval(getRessourceAsUrl('http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/data/XtenseConstants.js'));
	
	/* Récupération des fonctions */
	eval(getRessourceAsUrl('http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/data/XtenseFunctions.js'));
}
	


// Ajout du Menu Options
if (document.getElementById('playerName')){
	//var icone = 'data:image/gif;base64,R0lGODlhJgAdAMZ8AAAAABwgJTU4OhwhJRYaHjQ3OQcICjM2OA8SFQoMDxsgJB0hJjI1Nw8TFQcICAQEBDE0NgwPEAECAiYoKREVGB8lKi4yNCMlJgoNDzAzNiMnKzE0NxATFgsNECwuMAEBASotMB4iJyImKg8SFg4PDw8QESEjJQICAiAkKRgZGhsdHhUWFwoLCwoMDjI2OBcbHxsgIw0PEhsfIx8jJywvMh8hIhobHB8kKQkMDQYICQoNECwwMxcZGQsOER0iJygrLxweHysuMSUoLAkLDiQnKwwPESElKTM2NyAiIwcKCyAjJxoeISIlKiIkJRIWGRQWFiosLSUnKDAzNBscHRoeIgMEBDAyNA4ODyAkKAcICQkKCwwQEiMnKhwgJBIVGRAQEScqLiosLgcJCgcJCzQ2OAQEBQgICAkJCiksMCQmJwYHCSAjKC0vMQYGBh4jJyUpLSksLRAUFygsLzM2OSsuLyotMQwNDTAzNS4xMiwvMAkJDAkLDf///////////////yH5BAEAAH8ALAAAAAAmAB0AAAf+gH+CFQOFhoeIiRWCjI2ON4cBkpKIlIgVMI6af4SFk5+gk5UwBJuNBIahqqs+paaCBKuyoG4BA66vBFSgAr2+k74CnwoBuKaxkz7AvZ9rAcyTCgrGm8iq0Mug0tSa1qG/ktiTXbevsDKfC5/YwqvcjgTosszt7uZ/BN7f4Kov741i8gkcKLAXwYNZ7gFYyLAhQ18OIyqM6DCYAIoMJ2JceBFAr40ANGLs6PEjRpERTXJUyVBCSHMbWa48CZOizJUkG6IsGaxhT4k1I7oESXHnwqFEHd7LAUBN0qT3huDYI3VMEgNYs27EmkOLnnt/tsQoUqRHh7MY0iZY24KtDh0gAHpEmAtWkBMvceJw2NsAQV+/IwALpkChruHDiBPXDQQAOw==';
			
	var aff_option ='<li><span class="menu_icon"><a href="http://board.ogsteam.fr" target="blank_" ><img id="xtense.icone" class="mouseSwitch" src="'+urlIcone+'" height="29" width="38"></span><a class="menubutton " href="'+url+'&xtense=Options" accesskey="" target="_self">';
		aff_option += '<span class="textlabel">Xtense</span></a></li>';
				
				
	var sp1 = document.createElement("span");
	sp1.setAttribute("id", "optionIFC");
	var sp1_content = document.createTextNode('');
	sp1.appendChild(sp1_content);				
	
	var sp2 = document.getElementById('menuTable').getElementsByTagName('li')[Math.min(10,document.getElementById('menuTable').getElementsByTagName('li').length-1)];
			
	parentDiv = sp2.parentNode;
	parentDiv.insertBefore(sp1, sp2.nextSibling);
	var tableau = document.createElement("span");
	tableau.innerHTML = aff_option;
	document.getElementById('optionIFC').insertBefore(tableau, document.getElementById('optionIFC').firstChild);
}

// Page des Options Xtense
if((new RegExp(/xtense=Options/)).test(url)){		
	if(url.indexOf('xtense=Options',0) >= 0){
		if(isChrome){				
			var options = '<div id="Xtense_Div" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;"><br/><br/>';
			// Serveur Univers
			options+= '<img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png" alt="Options Xtense"/>';
			options+= '<br/><br/>';
			options+= '<table style="width:675px;">' +
					  '<colgroup><col width="25%"/><col width="25%"/><col width="25%"/><col width="25%"/></colgroup>' +
					  '<tbody>' +
					  '<tr>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_serveurs\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/server.png"/><span id="menu_servers" style="font-size: 20px; color: white;"><b>&#160;Serveur</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_pages\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/pages.png"/><span id="menu_pages" style="font-size: 20px; color: orange;"><b>&#160;Pages</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_options\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/conf.png"/><span id="menu_options" style="font-size: 20px; color: orange;"><b>&#160;Options</b></span></a></td>' +
					  '<td align="center"><a onclick="displayOption(\'Xtense_about\')" style="cursor:pointer;"><img src="http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/about.png"/><span id="menu_about" style="font-size: 20px; color: orange;"><b>&#160;A propos</b></span></a></td>' +
					  '</tr>' +
					  '</tbody>' +
					  '</table>';
			options+= '<div id="Xtense_serveurs">';		
			options += '<table id="Xtense_table_serveurs" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">URL OGSpy</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Utilisateur</label></td>';
			options+= '<td class="value"><input class="speed" id="server.user" value="'+GM_getValue('server.user','utilisateur')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';
			options+= '<tr><td>&#160;</td><td>&#160;</td></tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Mot de passe</label></td>';
			options+= '<td class="value"><input class="speed" id="server.pwd" value="'+GM_getValue('server.pwd','mot de passe')+'" size="35" alt="24" type="password"/></td>';
			options+= '</tr>';
			options+= '</tbody></table>';
			options+= '</div>';			
			// Pages
			options+= '<div id="Xtense_pages">';
			options += '<table id="Xtense_table_pages" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Systemes solaires</label></td>';
			//alert("GM_getValue('handle.system','false'))="+(GM_getValue('handle.system','false')=='true')+"\n"+((GM_getValue('handle.system','false')=='true')?'checked="true" ':'checked="false" '));
			options+= '<td class="value"><input class="speed" id="handle.system" checked="false" size="35" alt="24" type="checkbox"/></td>';
			options+= '</tr>';
			options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Vue générale</label></td>';
			options+= '<td class="value"><input class="speed" id="handle.overview" checked="false" size="35" alt="24" type="checkbox"/></td>';
			options+= '</tr>';
			options+= '</tbody></table>';
			options+= '</div>';
			// Options
			options+= '<div id="Xtense_options">';
			options += '<table id="Xtense_table_options" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			/*options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">Options</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';*/
			options+= '</tbody></table>';
			options+= '</div>';
			// A propos
			options+= '<div id="Xtense_about">';
			options += '<table id="Xtense_table_about" style="width:675px; color: orange; background-color: black; text-align: center; font-size: 12px; opacity : 0.8;">';
			options += '<colgroup><col width="20%"/><col/></colgroup>';
			options += '<thead><tr><th class="Xtense_th" colspan="2" style="font-size: 12px; text-align:center; font-weight: bold; color: #539fc8; line-height: 30px; height: 30px;"></th></tr></thead>';
			options+= '<tbody>';
			/*options+= '<tr>';
			options+= '<td class="champ"><label class="styled textBeefy">A propos</label></td>';
			options+= '<td class="value"><input class="speed" id="server.url.plugin" value="'+GM_getValue('server.url.plugin','http://VOTREPAGEPERSO/VOTREDOSSIEROGSPY/mod/xtense/xtense.php')+'" size="35" alt="24" type="text"/></td>';
			options+= '</tr>';*/
			options+= '</tbody></table>';
			options+= '</div>';
			options+= '<br/><br/></div>'; //fin Tableau
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			
			var script = document.createElement('script');
			script.setAttribute('type','text/javascript');
			script.setAttribute('src',"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/scripts/prefs.js");
			escriptopt.appendChild(script);
			
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
						
			document.getElementById("Xtense_serveurs").style.display="block";
			document.getElementById("Xtense_pages").style.display="none";
			document.getElementById("Xtense_options").style.display="none";
			document.getElementById("Xtense_about").style.display="none";
			
			var checkboxOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[@type='checkbox']");
			//log("checkboxOptions.snapshotLength="+checkboxOptions.snapshotLength);
			if(checkboxOptions.snapshotLength > 0){
			   	for(var j=0;j<checkboxOptions.snapshotLength;j++){
			   		var checkbox = checkboxOptions.snapshotItem(j);
			   		//checkbox.checked=Boolean(GM_getValue(checkbox.id,"false"));
			   		checkbox.checked=GM_getValue(checkbox.id,false)=='true'?true:false;
			   		//alert("checkbox:"+checkbox.id+"="+checkbox.checked+"\n\nGM_getValue()="+GM_getValue(checkbox.id,false));
			   	}
			}

			function enregistreOptionsXtense(){				
				// Sauvegarde des inputs
				var inputOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[not(@type='checkbox')]");
				//log("inputOptions.snapshotLength="+inputOptions.snapshotLength);
				if(inputOptions.snapshotLength > 0){					
				   	for(var i=0;i<inputOptions.snapshotLength;i++){
				   		var input = inputOptions.snapshotItem(i);
				   		GM_setValue( input.id , input.value);
				   	}
				}
				// Sauvegarde des checkbox
				var checkboxOptions = Xpath.getOrderedSnapshotNodes(document, "//div[@id='Xtense_Div']//input[@type='checkbox']");
				//log("checkboxOptions.snapshotLength="+checkboxOptions.snapshotLength);
				if(checkboxOptions.snapshotLength > 0){
				   	for(var j=0;j<checkboxOptions.snapshotLength;j++){
				   		var checkbox = checkboxOptions.snapshotItem(j);
				   		GM_setValue(checkbox.id , checkbox.checked);
				   	}
				}	
			}
			setInterval(enregistreOptionsXtense, 500);
		// Firefox ?
		} else if(isFirefox){
			var options = "<div>" +
			"<br/><br/><br/><br/>" +
			"<div style=\"color: orange; background-color: black; text-align: center; font-size: 16px; opacity : 0.7;\">" +
			"<img src=\"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/OGSteam.gif\" alt\"OGSteam\"/>" +
			"<br/>" +
			"<img src=\"http://svn.ogsteam.fr/trunk/xtense_GreaseMonkey/images/xtense.png\" alt\"Xtense\"/>" +			
			"<br/><br/>" +
			"Une extension Firefox de ce script existe." +
			"<br/><br/>" +
			"Veuillez la télécharger afin de profiter pleinement de cet outil." +
			"<br/><br/><br/>" +
			"Ce module complémentaire est disponible à l'<a href=\"http://update.ogsteam.fr/xtense/download.php\" target=\"_blank\">adresse suivante.</a>" +
			"<br/><br/>" +
			"Pour tout renseignement complémentaire, " +
			"<br/>" +
			"vous pouvez vous rendre sur le forum de l'OGSteam." +
			"<br/>" +
			"<a href=\"http://board.ogsteam.fr/index.php\" target=\"_blank\">http://board.ogsteam.fr/index.php</a>" +
			"<br/><br/>" +
			"</div></div>";
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
		} else {
			var options = "<div><h1>Ce script n'est pas compatible avec ce navigateur internet.</h1></div>";
			
			var einhalt=document.getElementById('inhalt');
			var escriptopt=document.createElement('div');
			escriptopt.id='xtenseScriptOpt';
			escriptopt.innerHTML=options;
			escriptopt.style.cssFloat='left';
			escriptopt.style.position='relative';
			escriptopt.style.width='670px';
			einhalt.style.display='none';
			einhalt.parentNode.insertBefore(escriptopt,einhalt);
		}
	}
}

/* Page Autre que Galaxie */
var regGalaxy = new RegExp(/(galaxy)/);
if(!regGalaxy.test(url)){
	GM_setValue('lastAction','');
}
/* Page Galaxie */
if(regGalaxy.test(url)){
	if(Boolean(GM_getValue("handle.system"))){
		var target = document.getElementById('galaxyContent');
		target.removeEventListener("DOMNodeInserted");
		target.removeEventListener("DOMSubtreeModified");
		//target.addEventListener("DOMNodeInserted", parseSystem_Inserted, false);
		target.addEventListener("DOMSubtreeModified", parseSystem_Inserted, false);
	}
}

/* Page Overview */
var regOverview = new RegExp(/(overview)/);
if(regOverview.test(url)){
	setStatus(XLOG_NORMAL,Xl('overview detected'));
	
	if(Boolean(GM_getValue("handle.overview"))){
		var planetData = getPlanetData();
		
		var cases = Xpath.getStringValue(document,XtenseXpaths.overview.cases);
		var temperatures = Xpath.getStringValue(document,XtenseXpaths.overview.temperatures);
		var temperature_max = temperatures.match(/\d+[^\d-]*(-?\d+)[^\d]/)[1];
		var temperature_min = temperatures.match(/(-?\d+)/)[1]; //TODO trouver l'expression reguliere pour la temperature min
		
		var resources = getResources();
		
		XtenseRequest.set(
			{
				type: 'overview',
				fields: cases,
				temperature_min: temperature_min,
				temperature_max: temperature_max,
				ressources: resources
			},
			planetData
		);
			
		XtenseRequest.set('lang',langUnivers);
		XtenseRequest.send();
	}
}

//************************
//** PARSINGS DES PAGES **
//************************
if(isChrome){
	function parseSystem_Inserted(event){
		var doc = event.target.ownerDocument;
		var paths = XtenseXpaths.galaxy;
		var galaxy = Xpath.getSingleNode(document,"//input[@id='galaxy_input']").value;
		var system = Xpath.getSingleNode(document,"//input[@id='system_input']").value;
		
		if (GM_getValue('lastAction','') != 's:'+galaxy+':'+system){
			var coords = [galaxy, system];
			if (isNaN(coords[0]) || isNaN(coords[1])) {
				log('invalid system'+' '+coords[0]+' '+coords[1]);
				return;
			}
			log(Xl('system detected',galaxy,system));
			setStatus(XLOG_NORMAL,Xl('system detected',galaxy,system));
		
			var rows = Xpath.getUnorderedSnapshotNodes(doc,paths.rows);
			//log(paths.rows+' '+rows.snapshotLength);
			if(rows.snapshotLength > 0) {
				//var XtenseRequest = new XtenseRequest(null, null, null);
				//log(rows.snapshotLength+' rows found');
				var rowsData = [];
				for (var i = 0; i < rows.snapshotLength ; i++) {
					var row = rows.snapshotItem(i);
					var name = Xpath.getStringValue(doc,paths.planetname,row).trim().replace(/\($/,'');
					var name_l = Xpath.getStringValue(doc,paths.planetname_l,row).trim().replace(/\($/,'');
					var player = Xpath.getStringValue(doc,paths.playername,row).trim();
					
					if (player == '') {
						log('row '+i+' has no player name');
						continue;
					}
					if (name == '') {
						if (name_l == '') {
							log('row '+i+' has no planet name');
							continue;
						} else
							name = name_l;
					}
					var position = Xpath.getNumberValue(doc,paths.position,row);
					if(isNaN(position)) {
						log('position '+position+' is not a number');
						continue;
					}

					var moon = Xpath.getUnorderedSnapshotNodes(doc,paths.moon,row);
					moon = moon.snapshotLength > 0 ? 1 : 0;
					var status = Xpath.getUnorderedSnapshotNodes(doc,paths.status,row);
					if(status.snapshotLength>0){
						status = status.snapshotItem(0);
						status = status.textContent;
						status = status.match(/\((.*)\)/);
						status = status ? status[1] : "";
						status = status.trimAll();
					}
					else status = "";
					var activity = Xpath.getStringValue(doc,paths.activity,row).trim();
					activity = activity.match(/: (.*)/);
					if(activity)
						activity = activity[1];
					else activity = '';
					var allytag = Xpath.getStringValue(doc,paths.allytag,row).trim();
					var debris = [];
					for(var j = 0; j < 2; j++) {
						debris[XtenseDatabase['resources'][601+j]] = 0;
					}
					var debrisCells = Xpath.getUnorderedSnapshotNodes(doc,paths.debris,row);
					for (var j = 0; j < debrisCells.snapshotLength ; j++) {
						debris[XtenseDatabase['resources'][601+j]] = debrisCells.snapshotItem(j).innerHTML.trimInt();
					}
					
					var player_id = Xpath.getStringValue(doc,paths.player_id,row).trim();
					if (player_id != '' ) {
						player_id = player_id.match(/\&to\=(.*)\&ajax/);
						player_id = player_id[1];
					}
					else if(doc.cookie.match(/login_(.*)=U_/))
						player_id = doc.cookie.match(/login_(.*)=U_/)[1]; 
					
					var ally_id = Xpath.getStringValue(doc,paths.ally_id,row).trim();
					if (ally_id != '' ) {
						ally_id = ally_id.match(/allyid\=(.*)/);
						ally_id = ally_id[1];
					}
					else if (allytag)
						ally_id = '-1';
					
					var r = {player_id:player_id,planet_name:name,moon:moon,player_name:player,status:status,ally_id:ally_id,ally_tag:allytag,debris:debris,activity:activity};
					rowsData[position]=r;
				}
				XtenseRequest.set(
					{
						row : rowsData,
						galaxy : coords[0],
						system : coords[1],
						type : 'system'
					}
				);

				XtenseRequest.set('lang',langUnivers);
				//Xdump(XtenseRequest.data);
				XtenseRequest.send();
				GM_setValue('lastAction','s:'+coords[0]+':'+coords[1]);
			}
		}
	}
}