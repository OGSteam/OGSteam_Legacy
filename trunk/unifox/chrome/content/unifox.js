//var domain = "";
var ufTextColor="#00AA00";//couleur du texte inséré par unifox
var ufLang = srGetStrBundle("chrome://unifox/locale/unifox.properties");
/*var gameURLs=new Array();//liste des adresses des serveurs
var loginURLs=new Array();*/
var ufServerData=null;//liste des adresses des serveurs
var ufUnitsData=null;//liste des unités du jeu

//var ufLang = document.getElementById("ufLang");
//*****************************************************************************************
// MAIN load (executed only 1 time per tab)
//*****************************************************************************************
function unifox_load() {
	window.addEventListener('DOMContentLoaded', uf_adjustPages, true);
	window.addEventListener('popupshowing', uf_initPopupMenu, true);

	var old_onmouseup = window.onmouseup;
	window.onmouseup = function (e) { 
			unifoxOnMouseUp(e); 
			if (typeof old_onmouseup == "function") old_onmouseup(e);
			};
	var old_onkeyup = window.onkeyup;
	window.onkeyup = function (e) { 
			unifox_onKeyUpCheck(e);
			if (typeof old_onkeyp == "function") old_onkeyup(e);
			};

	PrefsBranchUF.setBoolPref("unifoxStoreCoordFlag",false);

	//uf_updateXMLs();
	uf_updateJSONs();
}

//*****************************************************************************************
// MAIN function
//*****************************************************************************************
function uf_adjustPages(event)	{
	if(ufGetPref("ufDisabled",false))
	{
		ufLog("No action (disabled)");
		return;
	}
       var doc = event.originalTarget;
       currentDoc = doc;
       try {
           if (doc.nodeType != doc.DOCUMENT_NODE) 
                doc = doc.ownerDocument;
		
		//ufBar.init(doc);//barre inutilisée à ce jour

		var href = doc.location.href;
		//Firebug.Console.log(href);
		//_FirebugCommandLine.evaluate("dir(2)");
		
		//ufDump(Firebug);
		if (uf_isUniversDomain(href)) {
			ufLog("start on: "+href);
			ufTextColor=ufGetColorPref("ufTextColor","#00AA00",false);
			ufRegisterUniverse(href);
			//unifoxdebug("","test",doc);
			
			//domain = uf_getDomain(doc);
			var functions = new Array(
				
				uf_addDebrisColor,
				uf_colorizePrivates,
				uf_bbCode,
				uf_colorizeAllyMessages,
				uf_formatMessage,
				uf_pasteCoords,
				uf_infosDeltas,
				uf_selectMission,
				uf_saveProd,
				uf_allyColor,
				uf_addRanks,
				uf_prodTime,
				uf_TochagaFunctions,
				uf_converter,
				uf_addREListener,
				uf_simulator,
				uf_fleetReturnTime,
				uf_saveExploitLvl,
				uf_addMessageOption,
				uf_changeFreightOrder,
				uf_fightReportConverter,
				uf_maxEMP,
				uf_rssReader,
				uf_Max485 // Permet d'appeller la fonction mere du script de Max485
				//uf_vortex
				);
				callUniversFunctions(functions, doc);
				ufLog("end on: "+href);
		}
		else 	if(uf_isLoginUrl(href))
				uf_logIn(doc);
		
	} catch (e) {
		unifoxdebug(e,"general",doc);
	}

}


//*****************************************************************************************
function callUniversFunction(func, doc) {
    try {
        func(doc);   
    } catch (e) {
        unifoxdebug(e);
    }
}

//*****************************************************************************************
function callUniversFunctions(funcs, doc) {
    //ufLog("calling e-univers functions");
    for (var i=0; i<funcs.length; i++) {
        callUniversFunction(funcs[i], doc);
    }
    
}

//*****************************************************************************************
function uf_initPopupMenu(event) {
    try {    
    	if (event.target.id != "contentAreaContextMenu") return;

   	var ufMenu = document.getElementById("unifox-config-menu");
	ufMenu.setAttribute("hidden",!uf_isUniversDomain(window._content.document.location.href));
	ufMenu = document.getElementById("unifox-switch-menu");
	ufMenu.setAttribute("hidden",!uf_isUniversDomain(window._content.document.location.href));
//	var label=ufGetPref("ufDisabled",true) ? "&unifox.menu.unifoxDisabled;":"&unifox.menu.unifoxEnabled;";
	var label=ufGetPref("ufDisabled",true) ? ufLang.GetStringFromName("unifoxDisabled"):ufLang.GetStringFromName("unifoxEnabled");
	//ufMenu.setAttribute("label", label);
	ufMenu.label=label;
	return;
    } catch (e){
        unifoxdebug(e);
    }

}

//*****************************************************************************************
// URL checks
//*****************************************************************************************
function uf_isLoginUrl(href) {
var ufServers = uf_getServerData();
	for(var i in ufServers["servers"]) {
		if (href.indexOf(ufServers["servers"][i]["url"]) > -1) {
			return true;   
		}
	}
     return false;
    //return href.search(/login2?\.e-univers\.org\/\?action=login/i) > -1 || href.search(/login\.e-univers\.org\/?/i)>-1/*|| href.search(/\.e-univers\.org\/login\/\?action=login/i) > -1*/;
}
function uf_isFightReportUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^message$/) && href.search("popup.php")>-1;
}
function uf_isRessourcesUrl(href) {
	var action=uf_getGET("action",href);
   return action.match(/^ressources$/);
}
function uf_isProdTimeUrl(href) {
	var action=uf_getGET("action",href);
   return action.match(/^batiments$/) || action.match(/^labo$/);
}
function uf_isFlota2Url(href) {
	var action=uf_getGET("action",href);
   return action.match(/^flotte2$/);
}

function uf_isFleetUrl(href) {
	var action=uf_getGET("action",href);
	var planete_select=uf_getGET("planete_select",href);
   return action.match(/^flotte$/) || (action.match(/^flotte/) && planete_select!="");
}
function uf_isShipyardUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^chantier$/);
}

function uf_isGalaxyUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^galaxie$/);
}

function uf_isVortexUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^vortex$/);
}

function uf_isMessagesUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^messages$/);
}

function uf_isOPMessagesUrl(href)
{
if(uf_isModoReportedMessagesUrl(href)||uf_isModoMessagesUrl(href)||uf_isModoPlayerMessagesUrl(href))
return true;
}
function uf_isModoReportedMessagesUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^msgsig$/);
}
function uf_isModoMessagesUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^messages$/);
}
function uf_isModoPlayerMessagesUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^viewmsg$/);
}

function uf_isResearchUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^labo$/);
}

function uf_isBuildingsUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^batiments$/);
}

function uf_isOverviewUrl(href) {
	var action=uf_getGET("action",href);
	return (action.match(/^accueil$/) || action=="") && !href.match(/login/);
}

function uf_isGlobalviewUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^overview$/);
}

function uf_isWriteMessagesUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^ecriremessages$/);
}
function uf_isWriteAllyMessagesUrl(href) {
	var subaction=uf_getGET("subaction",href);
	return subaction.match(/^messagealliance$/);
}

function uf_isBuildingInfosUrl(href) {
	var action=uf_getGET("action",href);
	var subaction=uf_getGET("subaction",href);
	var id=parseInt(uf_getGET("id",href));
	return action.match(/^info$/) && subaction.match(/^batiment$/) && id<4;
}

function uf_isConverterUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^convert$/);
}

function uf_isSimuUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^simu$/);
}

function uf_isStatUrl(href) {
	var action=uf_getGET("action",href);
	return action.match(/^stats$/);
}

function uf_isAllyPlayersUrl(href) {
	var action=uf_getGET("action",href);
	var subaction=uf_getGET("subaction",href);
	return action.match(/^alliance$/) && subaction.match(/^listeMembres$/);
}

//*****************************************************************************************
// Misc Functions
//*****************************************************************************************
function ufRegisterUniverse(url)
{
	var ufServers = uf_getServerData();
	for(var i in ufServers["servers"]) {
		for(var j in ufServers["servers"][i]["universes"]) {
			//ufLog(ufServers["servers"][i]["universe"][j]["url"]);
			if (url.indexOf(ufServers["servers"][i]["universes"][j]["url"]) > -1) {
				ufSetCharPref("unifoxLastUniverse",j+"");ufLog("unifoxLastUniverse="+j);
			}
		}
	}
}
//*****************************************************************************************
function uf_isCoord(str) {
	if (str.search(/[>\s\[\(](\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})[\s\]\)<,\.]/gi) != -1) return true;
	if (str.search(/^(\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})[\s\]\)<,\.]/gi) != -1) return true;
	if (str.search(/[>\s\[\(](\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})$/gi) != -1) return true;
	if (str.search(/^(\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})$/gi) != -1) return true;
	return false;
}

//**************************************************************************
function uf_updateXMLs() {
	/*var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET", "http://jormund.free.fr/e-univers/ufUniverses.xml", true);
	//xmlReq.open("GET", "http://svn.ogsteam.fr/Unifox/ufUniverses.xml", true);
	xmlReq.onload = uf_processUpdateResponse;
	xmlReq.send(null);*/
	
	//ufDump(xmlReq);
	/*var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET", "http://jormund.free.fr/e-univers/ufUnits.xml", true);
	//xmlReq.open("GET", "http://svn.ogsteam.fr/Unifox/ufUnits.xml", true);
	xmlReq.onload = uf_processXMLUpdateResponse;
	xmlReq.send(null);*/
}
//**************************************************************************
function uf_updateJSONs() {
	var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET", "http://jormund.free.fr/e-univers/ufUniverses.js", true);
	//xmlReq.open("GET", "http://svn.ogsteam.fr/Unifox/ufUniverses.xml", true);
	xmlReq.onload = uf_processJSONUpdateResponse;
	xmlReq.pref = "ufUniverses";
	xmlReq.send(null);
	
	//ufDump(xmlReq);
	var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET", "http://jormund.free.fr/e-univers/ufUnits.js", true);
	//xmlReq.open("GET", "http://svn.ogsteam.fr/Unifox/ufUnits.xml", true);
	xmlReq.onload = uf_processJSONUpdateResponse;
	xmlReq.pref = "ufUnits";
	xmlReq.send(null);
}

//**************************************************************************
function uf_processJSONUpdateResponse(event) {
try {
	var text=event.target.responseText+"";
	if(event.target.pref != "" && event.target.pref!= null) {
		ufSetCharPref(event.target.pref,text);
		ufLog(event.target.pref+" updated");
	}
} catch(e) {
	ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
	}
}
/*function uf_processXMLUpdateResponse(event) {
try {
	var text=event.target.responseText+"";
	if(event.target.pref != "" && event.target.pref!= null) {
		var fileName=event.target.pref+".xml";
		ufLog("saving "+fileName);
		var dir= uf_getConfigDir(null);
		dir.append(fileName);
		var file=dir;
//	ufLog(file.path);
		//dumpProperties_o(file);
		if( !file.exists() ) {   // if it doesn't exist, create
	   file.create(Components.interfaces.nsIFile.NORMAL_FILE_TYPE, 0777);
		}
		
		ufLog(text);
		var charset = "UTF-8"; // Can be any character encoding name that Mozilla supports
		var os = Components.classes["@mozilla.org/intl/converter-output-stream;1"]
	                  .createInstance(Components.interfaces.nsIConverterOutputStream);
		var fos = Components.classes["@mozilla.org/network/file-output-stream;1"]
							.createInstance(Components.interfaces.nsIFileOutputStream);
		fos.init(file, 0x02 | 0x08 | 0x20, 0777, 0);
		// This assumes that fos is the nsIOutputStream you want to write to
		os.init(fos, charset, 0, 0x0000);
		os.writeString(text);
		os.close();
		fos.close();
		ufLog(fileName+" updated");
	}
} catch(e) {
	ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
}
}*/



//*****************************************************************************************
function uf_addFiring(doc, func) {

  var head = doc.getElementsByTagName("head")[0];    

  var script = doc.createElement("script");
  script.setAttribute("language", "JavaScript");
  script.innerHTML = 'function fire(){'+
	'window.removeEventListener("mousemove", fire, true);'+
	func+'();'+
	'}'+
	'window.addEventListener("mousemove", fire, true);';
  head.appendChild(script);
}

//*****************************************************************************************
function uf_getServerData() {
	if(!ufServerData)ufServerData=ufGetJSONPref("ufUniverses");
	return ufServerData;
}
function uf_getUnitsData() {
	if(!ufUnitsData)ufUnitsData=ufGetJSONPref("ufUnits");
	return ufUnitsData;
}
function uf_getCurrentUniverseData(href) {
	var ufServers = uf_getServerData();
	for(var i in ufServers["servers"]) {
		for(var j in ufServers["servers"][i]["universes"]) {
			//ufLog(ufServers["servers"][i]["universe"][j]["url"]);
			if (href.indexOf(ufServers["servers"][i]["universes"][j]["url"]) > -1) {
				return ufServers["servers"][i]["universes"][j];   
			}
		}
	}
	return null;
	
}
//*****************************************************************************************
function uf_isUniversDomain(href) {

    if (href.match(/^file:\/\//)) return true;
          
     if(href.match(/\/modos\//) && href.match(/action=/) && href.match(/e-univers.org/))
		{
		if(uf_isOPMessagesUrl(href)/*uf_isModoReportedMessagesUrl(href) || uf_isModoMessagesUrl(href) || uf_isModoPlayerMessagesUrl(href)*/)
			return true;
		}
     var excludes = new Array(/\/modos\//,//opés
	  /google/); //pub
     for (var i = 0; i< excludes.length; i++) {
        if (href.search(excludes[i]) > -1) {
          return false;   
        } 
     }
	 
	var ufServers = uf_getServerData();
	for(var i in ufServers["servers"]) {
		for(var j in ufServers["servers"][i]["universes"]) {
			//ufLog(ufServers["servers"][i]["universe"][j]["url"]);
			if (href.indexOf(ufServers["servers"][i]["universes"][j]["url"]) > -1) {
				return true;   
			}
		}
	}
     return false;
}

//*****************************************************************************************
function uf_getDomain(document) {
	try {
		var text = document.location.href;
		text = text.split('\/\/');
		text = text[1];
		text = text.split('\/');
		text = text[0];
		return text;
	} catch(e){
		unifoxdebug(e);
		return null;
	}	
}


//*****************************************************************************************
function ufFindParentDocument(document) {
	try {
		var l = getBrowser().mPanelContainer.childNodes.length;
		var found = false;
		for(var i = 0; i < l; i++) {
			var b = getBrowser().mTabContainer.childNodes[i].linkedBrowser;
			if (!b && typeof getBrowser().getBrowserAtIndex() != "undefined" )
				b = getBrowser().getBrowserAtIndex(i);
			if (b && uf_isUniversDomain(b.currentURI.spec)) 
			{
				var frames = b.contentDocument.getElementsByTagName("frame");
				if(frames.length > 1 && (frames[1].contentDocument == document))
				{
					return b.contentDocument;
				}
			}
		}
		return null;
	} catch(e){
		unifoxdebug(e);
		return null;
	}	
}

//*****************************************************************************************
String.prototype.trim = function() {
  var x=this;
  x=x.replace(/^\s*|\s*$/g,"");
  return x;
}

//*****************************************************************************************
String.prototype.stripHTMLEntities = function() {
  var x=this;
  x=x.replace(/<([^>]+)>/g,"");
  return x;
}
//*****************************************************************************************
String.prototype.retrim = function() {
  var x=this.trim();
  x=x.replace(/\s+/g," ");
  return x;
}

//*****************************************************************************************
function unifox_onKeyUpCheck(e)
{
	if(e && e.keyCode == e.DOM_VK_A && e.ctrlKey)
	{
		unifoxOnMouseUp(e);
	}
}

//*****************************************************************************************
function unifoxOnMouseUp(e)
{
   if ((!e) || ((e.ctrlKey) && (!e.keyCode)))
	return;

   var targetclassname = e.target.toString();
   if (!ufGetPref("unifoxCoordCopy",false))  return;

	try {
		if(targetclassname.match(/InputElement|SelectElement|OptionElement/i) || targetclassname.match(/object XUL/i))
			return;
var doc=e.target.ownerDocument;
		if(doc.designMode)
			if(doc.designMode.match(/on/i))
				return;

		if(unifox_getSelection().length > 0)
		{
			var str = unifox_getSelection();
			if (unifox_saveCoords(str, /\[(\d{1,2}:\d{1,3}:\d{1,2})\]/i,true))
				return;
			else	if (unifox_saveCoords(str, /\d{1,2}:\d{1,3}:\d{1,2}/i,false))
				return;
			else {
				str = str.replace(/[>\s\[\(](\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})[\s\]\)<,\.]/gi,"$1:$2:$3");
				str = str.replace(/^(\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})[\s\]\)<,\.]/gi,"$1:$2:$3");
				str = str.replace(/[>\s\[\(](\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})$/gi,"$1:$2:$3");
				str = str.replace(/^(\d{1,2})[:\.\-\/\s](\d{1,3})[:\.\-\/\s](\d{1,2})$/gi,"$1:$2:$3");
				unifox_saveCoords(str, /\d{1,2}:\d{1,3}:\d{1,2}/i,false);
			}
	
		}
		return;
	} catch(e) {
		unifoxdebug(e);
		return;
	}
}
//*****************************************************************************************
function unifox_saveCoords(str, reg, extract){
	var found = false;
	var str2 = str.match(reg);
	if (str2 == null)
		return false;
	str2 = str2[0];
	str2 = str2.toString();
	if (extract)
		str2 = str2.replace(reg,"$1");
	while (str2 != null && found == false) {
		var temp = str2.split(':');
		var g = uf_parseInt(temp[0]);
		var s = uf_parseInt(temp[1]);
		var p = uf_parseInt(temp[2]);
		if (g+"" == temp[0] && s+"" == temp[1] && p+"" == temp[2] && !(g < 1 || g > 50) && !(s < 1 || s > 499 || (s > 100 && g >50)) && !(p > 15))
		{
			ufSetCharPref("unifoxStoreCoord",str2);
			ufSetBooleanPref("unifoxStoreCoordFlag",true);
			found = true;
		} else {
			str = str.substr(str.search(str2)+6);
			str2 = str.match(reg);
			if (str2 == null)
				return false;
			str2 = str2[0];
			str2 = str2.toString();
			if (extract)
				str2 = str2.replace(reg,"$1");
		}
	}
	return found;
}
//*****************************************************************************************
/*function unifox_getSelectionWithDoc(document)
{
var SelectionText = "";
try{
SelectionText = document.commandDispatcher.focusedWindow.getSelection().toString();
}catch(e)
		{
		SelectionText = "";
		}
alert(SelectionText);
return SelectionText;
} */

function unifox_getSelection() 
{
	var SelectionText = "";
	var trywindow = true;
	
	var focusedElement = document.commandDispatcher.focusedElement;
	if(focusedElement && typeof focusedElement != "undefined" && focusedElement != null)
	{
		try
		{
			SelectionText = focusedElement.value.substring(focusedElement.selectionStart, focusedElement.selectionEnd);
			trywindow = false;
		}
		catch(e)
		{
		}
	}
	if(trywindow)
	{
		var focusedWindow = document.commandDispatcher.focusedWindow;
		try
		{
			var winWrapper = new XPCNativeWrapper(focusedWindow, 'document', 'getSelection()');
			var Selection = winWrapper.getSelection();
		}
		catch(e)
		{
			var Selection = focusedWindow.getSelection();
		}
		SelectionText = Selection.toString();
	}
	return SelectionText;
}

//*****************************************************************************************
function uf_findUrlInFrames(document,func) {

	var frames = document.getElementsByTagName("frame");
	for (var i = 0; i < frames.length; i++) {
		if (frames[i] == null || frames[i].contentDocument == null)
			continue;
		if (func(frames[i].contentDocument.location.href)) {
			return(frames[i].contentDocument);
		}
		var ret = uf_findUrlInFrames(frames[i].contentDocument,func);
		if (ret)
			return ret;
	}
	var frames = document.getElementsByTagName("iframe");
	for (var i = 0; i < frames.length; i++) {
		if (frames[i] == null || frames[i].contentDocument == null)
			continue;
		if (func(frames[i].contentDocument.location.href)) {
			return(frames[i].contentDocument);
		}
		var ret = uf_findUrlInFrames(frames[i].contentDocument,func);
		if (ret)
			return ret;
	}	
	return null;
}

//*****************************************************************************************
function uf_doubleParseInt(string) {
	var x1=0;
	var x2=0;
	var ind=string.indexOf('+');
	if(ind>-1)
	{
	var sub1=string.substring(0,ind);
	var sub2=string.substring(ind);
	x1=uf_parseInt(sub1);
	x2=uf_parseInt(sub2);
	//alert(x1+"///"+sub2+"\\"+x2);
	}

	return x1+x2;
}

//*****************************************************************************************
// Features functions
//*****************************************************************************************
function uf_fleetReturnTime2(document,interval)
{
if(document)
{
//try {interval = uf_parseInt(PrefsBranchUF.getCharPref("unifoxTimersInterval")); interval=interval==0 ? 1000 : interval;}catch(e){var interval=1000;}
try{
var obj = ufEval( '//span[@class="return_time"]', document);
for ( var i = 0; i < obj.snapshotLength; i++) {//pour chaque bouton retour
		var span=obj.snapshotItem(i);
		//on récupère l'heure de départ
		var startTime = parseInt(span.getAttribute('start'));
		
		var start = new Date(startTime);
		var now = new Date();
		//var time = new Date();
		span.innerHTML= uf_relativeDate(2*now.getTime()-start.getTime());
		}
	//ufLog("call"+now.getTime()+"\n");
	setTimeout(function(){uf_fleetReturnTime2(document,interval)},interval);
//setTimeout("uf_fleetReturnTime2(document)",500);
}catch (e) {
		unifoxdebug(e,"return time 2",document);
	}
}
else ufLog("end uf_fleetReturnTime2"+now.getTime()+"\n");
}	
function uf_fleetReturnTime(doc) {

	//ufSetBooleanPref("unifoxFleetReturnTime",true);
	if (doc && !uf_isFleetUrl(doc.location.href)) return;
	if (!ufGetPref("unifoxFleetReturnTime",true)) return;
	try {
	var obj = ufEval( '//input[@value="Retour"]', doc);
		for ( var i = 0; i < obj.snapshotLength; i++) {//pour chaque bouton retour
		var inp=obj.snapshotItem(i);
		var tr=inp.parentNode.parentNode.parentNode;
		//on récupère l'heure de départ
		var th=tr.getElementsByTagName('th')[4];
		var T = uf_getDateFromFormat(th.innerHTML,"dd/MM/yyyy HH:mm:ss")
		var start = new Date(T);
		//l'heure de maintenant
		var now = new Date;
		//on en déduit le temps de parcours du retour
		//var time = new Date(now.getTime()-start.getTime());
		//var time = now.getTime()-start.getTime();
		//on l'affiche
		var date = uf_relativeDate(2*now.getTime()-start.getTime());
		var span = doc.createElement('span');
		span.setAttribute('style','color:'+ufTextColor+';');
		span.setAttribute('class','return_time');
		span.setAttribute('start',start.getTime());
		span.innerHTML=date;
		inp.parentNode.parentNode.appendChild(span);
		//alert(inp.parentNode.parentNode.innerHTML);
		//aler
	//	alert(th.innerHTML+"\nsta: "+start+"\n"+start.getTime()+"\nnow: "+now+"\n"+now.getTime()+"\ntime: "+time+"\n"+date);
		//doc.write(date+" : ");
		var interval = ufGetPref("unifoxTimersInterval",1000);
		
		}
		if(obj.snapshotLength>0)setTimeout(function(){uf_fleetReturnTime2(doc,interval/2)},interval/2);
	} catch (e) {
		//displayproperties_o(e);
		unifoxdebug(e,"return time",doc);
	}


}
//*****************************************************************************************
function uf_logIn(doc) {

	if (doc && !uf_isLoginUrl(doc.location.href)) return;
	if (ufGetPref("unifoxUniverseSelectionDisabled",true)) return;
try{

	ufLog("start uf_logIn");
	var uni=-1;
	if(ufGetPref("unifoxSaveLastUniverse",false))
		uni=ufGetPref("unifoxLastUniverse",-1);
	if(uni<0 && ufGetPref("unifoxSelectUniverse",true))
		uni=ufGetPref("ufUni",1);
		
	var server = ufGetPref("ufServer",0);
	var ufServers = uf_getServerData();
	uniIndex = ufServers["servers"][server]["universes"][uni]["value"];

	ufLog("ufUni="+uni+"uniIndex="+uniIndex);
	var login = ufGetPref("ufLogin","login");

	var pass = ufDecrypt(ufGetPref("ufPassword","pass"),"pwd");

	if(doc.getElementsByName("Uni")[0])//nouvelle page de login
	{
	doc.getElementsByName("login")[0].value=login;
	doc.getElementsByName("pass")[0].value=pass;
	var universelect = doc.getElementsByName("Uni")[0];
		/*if(doc.location.href.indexOf("login.e-univers.org")>-1 || doc.location.href.indexOf("login2.e-univers.org")>-1) {//cas particulier pour le btest
			
			universelect.options[0].value="http://bt.e-univers.org/login.php";//"http://"+gameURLs[0]+"/login.php";//"http://btest.e-univers.org/login.php";
			//universelect.options[0].value="http://www.e-univers.org/beta5/login.php";//"http://"+gameURLs[0]+"/login.php";//"http://btest.e-univers.org/login.php";
			universelect.options[0].innerHTML="Btest";
		}*/
	universelect.options[uniIndex].selected= true;
	//alert(universelect.options[uni].value);
	
	//ajout des unis absent du select
	if(ufGetPref("ufDebugMode", false)) {
		var opt = doc.createElement("option");
		opt.value = "http://testing.e-univers.org/login.php";
		opt.innerHTML = "Testing";
		universelect.appendChild(opt);
	}

	var path = '//input[@type="image"]';
	var obj = ufEval(path,doc);
	if(obj.snapshotLength == 1)
	obj.snapshotItem(0).focus();
	ufLog('end of login');
	}
	
} catch (e) {
		unifoxdebug(e,"autologin",doc);
	}	

}
//*****************************************************************************************
function uf_changeFreightOrder(document) {

	if (document && !uf_isFlota2Url(document.location.href)) return;
try {
	var script = document.createElement('script');
	//début de la fonction
	st= 'function maxRessources() {'+
	'var id;'+
	'var stockCap = stockage();'+
	'var r1Transport = document.getElementsByName("ressource1")[0].value;'+
	'var r2Transport = document.getElementsByName("ressource2")[0].value;'+
	'var r3Transport = document.getElementsByName("ressource3")[0].value-conso()-1;'+
	'var freeCapacity = stockCap - r1Transport - r2Transport - r3Transport;'+
	'if (freeCapacity < 0) {';
	var option=ufGetPref("unifoxFreightOrder",123);
	//partie à modifier
	switch(option)
	{
	case 312: st+= ' r3Transport = Math.min(r3Transport, stockCap) -1;';
				st+= ' r1Transport = Math.min(r1Transport, stockCap - r3Transport );';
				st+= ' r2Transport = Math.min(r2Transport, stockCap - r3Transport- r1Transport);';
				break;
	case 321: st+= ' r3Transport = Math.min(r3Transport, stockCap) -1;';
				st+= ' r2Transport = Math.min(r2Transport, stockCap - r3Transport);';
				st+= ' r1Transport = Math.min(r1Transport, stockCap - r3Transport - r2Transport);';
				break;
	case 213: st+= ' r2Transport = Math.min(r2Transport, stockCap) -1;';
				st+= ' r1Transport = Math.min(r1Transport, stockCap - r2Transport );';
				st+= ' r3Transport = Math.min(r3Transport, stockCap - r2Transport- r1Transport);';
				break;
	case 231: st+= ' r2Transport = Math.min(r2Transport, stockCap) -1;';
				st+= ' r3Transport = Math.min(r3Transport, stockCap - r2Transport);';
				st+= ' r1Transport = Math.min(r1Transport, stockCap - r2Transport - r3Transport);';
				break;
	case 132: st+= ' r1Transport = Math.min(r1Transport, stockCap) -1;';
			st+= ' r3Transport = Math.min(r3Transport, stockCap - r1Transport);';
			st+= ' r2Transport = Math.min(r2Transport, stockCap - r1Transport - r3Transport);';
			break;
	case 123:
	default:
			st+= ' r1Transport = Math.min(r1Transport, stockCap);';
			st+= ' r2Transport = Math.min(r2Transport, stockCap - r1Transport);';
			st+= ' r3Transport = Math.min(r3Transport, stockCap - r1Transport - r2Transport) -1;';	
			break;
	}
  
  //fin
  st+='}'+
  'document.getElementsByName("ressource1_aff")[0].value = Math.max(r1Transport, 0);'+
  'document.getElementsByName("ressource2_aff")[0].value = Math.max(r2Transport, 0);'+
  'document.getElementsByName("ressource3_aff")[0].value = Math.max(r3Transport, 0);'+
  'calculateTransportCapacity();'+
	'}';
	
	st+= 'function stockage() {'+
		'var stockage = 0;'+
		'if(typeof nbr_vaiss == "undefined") nbr_vaiss = 14;'+
		'for (i=1; i<=nbr_vaiss; i++) {'+
		'if (document.getElementsByName("vaisseau" + i)[0]) {'+
		'  if ((document.getElementsByName("vaisseau" + i)[0].value * 1) >= 1) {'+
		'stockage'+
		'  += document.getElementsByName("vaisseau" + i)[0].value'+
		'  *  document.getElementsByName("capacite" + i)[0].value'+
		'  }'+
		'}'+
		'}'+
		'return(stockage);'+
	'}';

	//TODO
	/*st+= 'function maxTritium() {'+
   ' var stockCap = stockage(); // Capacitée de stoquage'+
   ' var r1toTransport = document.getElementsByName("ressource1_aff")[0].value; // valeur inscrite dans le titane a envoyé pas le titane qu\'on a quai'+
   ' var r2toTransport = document.getElementsByName("ressource2_aff")[0].value; //pareille pour le carbone'+
   ' var r3Transport = document.getElementsByName("ressource3")[0].value - conso(); //tritium a quai - conso'+
   ' var freeCapacity = stockCap - r1toTransport - r2toTransport; // capacitée de stoquage moins le titane/carbonne deja "a envoyer"'+
   ' // si on a plus de place pour foutre du tritium ça reste a 0'+
   ' if (freeCapacity < 0) {'+
   '     document.getElementsByName("ressource3_aff")[0].value = "0";'+
   ' }'+
   ' // si on a encore de la place'+
   ' if (freeCapacity > 0) {'+
   '     // si on a plus de place que de tritium a quai'+
   '     if (freeCapacity >= r3Transport){'+
   '         document.getElementsByName("ressource3_aff")[0].value = r3Transport - 1;'+
   '         // si on a moins de place que de tritium a quai on calcule pour tritium 1000 avec une place de 500'+
   '     }'+
   '     if (freeCapacity < r3Transport){'+
    '        document.getElementsByName("ressource3_aff")[0].value = freeCapacity - 1;'+
    '    }'+
   ' }'+
    
   ' calculateTransportCapacity();'+
'}';*/
	script.innerHTML = st;
	document.body.appendChild(script);
}
catch (e) {
	unifoxdebug(e,"debris color",document);
}
}
//*****************************************************************************************
function uf_addDebrisColor(document) {

	if (document && !uf_isGalaxyUrl(document.location.href)) return;
	if (!ufGetPref("unifoxHighlightBigDebris",true)) return;	

	ufLog("Estamos escombros");

	try {

	      //var path = '//table[@width="569"]/child::tbody/descendant::tr/child::th[1]/child::a[1]';//cases avec la position
	      var path = "id('divpage')/table/tbody/tr/th[3]/a";//les cdr
      	var obj = ufEval(path,document);

		var color=ufGetColorPref("ufDebruf_isColor","#AA3333",false);

		var min=ufGetPref("ufDebrisMin",200000);

		min = uf_parseInt(min);
		var title;
		for (var i = 0; i < obj.snapshotLength; i++) {
			var obj2 = obj.snapshotItem(i);
			var total=0;
			if(omo = obj2.getAttribute("onmouseover"))
			{
				var str="Titane:";
				var ind=omo.indexOf(str);
				omo = omo.substr(ind);
				ind=omo.indexOf("<th>");//début de la case suivante
				omo = omo.substr(ind);
				ind = omo.indexOf("</th>");//fin de la case avec le nombre
				total+=uf_parseInt(omo.substr(0,ind));
				ufLog("cdr:"+i+" "+total+" "+omo);
				
				str="Carbone:";
				ind=omo.indexOf(str);
				omo = omo.substr(ind);
				ind=omo.indexOf("<th>");//début de la case suivante
				omo = omo.substr(ind);
				ind = omo.indexOf("</th>");//fin de la case avec le nombre
				total+=uf_parseInt(omo.substr(0,ind));
				ufLog("cdr:"+i+" "+total+" "+omo);
				
				str="Tritium:";
				ind=omo.indexOf(str);
				omo = omo.substr(ind);
				ind=omo.indexOf("<th>");//début de la case suivante
				omo = omo.substr(ind);
				ind = omo.indexOf("</th>");//fin de la case avec le nombre
				total+=uf_parseInt(omo.substr(0,ind));
				ufLog("cdr:"+i+" "+total+" "+omo);
			}
			if ( total >= min) {
				obj2.parentNode.setAttribute("style", "background-color : "+color+"; background-image : none;");
			}
			}
		}
	catch (e) {
		unifoxdebug(e,"debris color",document);
	}
}
//[i]test[color=#ff00ff]tst[/i] gdsg[/color]
function convertSmileys(str)
{
var str2=str;

var codes=new Array(':mellow:',
							':rolleyes:',
							':(',
							'B)',
							':D',//5
							':P',
							':o',
							';)',
							':)',
							':lol:',//10
							':huh:',
							':blink:',
							':angry:',
							':unsure:',		
							'&lt;_&lt;',//15
							'^_^',
							'-_-',
							':wub:',
							':wacko:',
							':ph34r:',//20
							':blush:',
							':excl:',
							':mad:',
							':-&gt;:');//24
var urls=new Array('http://forum.e-univers.org/style_emoticons/default/mellow.gif',
							'http://forum.e-univers.org/style_emoticons/default/rolleyes.gif',
							'http://forum.e-univers.org/style_emoticons/default/sad.gif',
							'http://forum.e-univers.org/style_emoticons/default/cool.gif',
							'http://forum.e-univers.org/style_emoticons/default/biggrin.gif',//5
							'http://forum.e-univers.org/style_emoticons/default/tongue.gif',
							'http://forum.e-univers.org/style_emoticons/default/ohmy.gif',
							'http://forum.e-univers.org/style_emoticons/default/wink.gif',
							'http://forum.e-univers.org/style_emoticons/default/smile.gif',
							'http://forum.e-univers.org/style_emoticons/default/laugh.gif',//10
							'http://forum.e-univers.org/style_emoticons/default/huh.gif',
							'http://forum.e-univers.org/style_emoticons/default/blink.gif',
							'http://forum.e-univers.org/style_emoticons/default/angry.gif',
							'http://forum.e-univers.org/style_emoticons/default/unsure.gif',			
							'http://forum.e-univers.org/style_emoticons/default/dry.gif',//15
							'http://forum.e-univers.org/style_emoticons/default/happy.gif',
							'http://forum.e-univers.org/style_emoticons/default/sleep.gif',
							'http://forum.e-univers.org/style_emoticons/default/wub.gif',
							'http://forum.e-univers.org/style_emoticons/default/wacko.gif',
							'http://forum.e-univers.org/style_emoticons/default/ph34r.gif',//20
							'http://forum.e-univers.org/style_emoticons/default/blush.gif',
							'http://forum.e-univers.org/style_emoticons/default/excl.gif',
							'http://forum.e-univers.org/style_emoticons/default/mad.gif',
							'http://forum.e-univers.org/style_emoticons/default/icon11.gif');//24
for(var i = 0; i < codes.length; i++ )
	{
	if(str2.indexOf(codes[i])>-1)
		str2=str2.replace(codes[i],'<img src="'+urls[i]+'"/>');
	}
return str2;
}

function convertBBcode(str/*,doc*/)
{
//var str2=str;
//var i=0;
/*while(doc.BBCode < 50 && i!=4) {
	if(str2.match(/(.*)\[b\]((.|\s)*?)\[\/b\](.*)/i))
		{
		str2 = str2.replace(/(.*)\[b\]((.|\s)*?)\[\/b\](.*)/i,'$1<span style="font-weight:bold">$2</span>$4');
		doc.BBCode++;
		}
	else i++;
	if(str2.match(/(.*)\[i\]((.|\s)*?)\[\/i\](.*)/i))
		{
		str2 = str2.replace(/(.*)\[i\]((.|\s)*?)\[\/i\](.*)/i,'$1<span style="font-style:italic">$2</span>$4');
		doc.BBCode++;
		}
	else i++;
	if(str2.match(/(.*)\[color=(.*?)\]((.|\s)*?)\[\/color\](.*)/i))
		{
		str2 = str2.replace(/(.*)\[color=(.*?)\]((.|\s)*?)\[\/color\](.*)/i,'$1<span style="color:$2">$3</span>$5');
		doc.BBCode++;
		}
	else i++;
	if(str2.match(/(.*)\[background=(.*?)\]((.|\s)*?)\[\/background\](.*)/i))
		{
		str2 = str2.replace(/(.*)\[background=(.*?)\]((.|\s)*?)\[\/background\](.*)/i,'$1<span style="background-color:$2">$3</span>$5');
		doc.BBCode++;
		}
	else i++;
}*/
ufLog(str);
str=str.replace(/\[i\]/g,'<span style="font-style:italic">');
str=str.replace(/\[b\]/g,'<span style="font-weight:bold">');
str=str.replace(/\[color=([^\]]*)\]/g,'<span style="color:$1">');
str=str.replace(/\[background=([^\]]*)\]/g,'<span style="background-color:$1">');
str=str.replace(/(\[\/i]|\[\/b]|\[\/color]|\[\/background])/g,'</span>');
//alert("avant:"+str+"\napres:"+str2);		

return str;
}

function uf_bbCode(document) {
if (document && !uf_isMessagesUrl(document.location.href) && !uf_isOPMessagesUrl(document.location.href)) return;
if (!ufGetPref("unifoxBBcode",true)) return;
try {
	if(!uf_isOPMessagesUrl(document.location.href)/*pas dans la console, donc sur le jeu*/ || uf_isModoMessagesUrl(document.location.href))
	{
	
		var path = '//td[@class="titmsgprive"]';
		var obj = ufEval(path,document);
		if(obj.snapshotLength>0)
		{
			for (var i = 0; i <obj.snapshotLength; i+=3)
			{
				var tr = obj.snapshotItem(i).parentNode;
				var line=tr.nextSibling;
				var th = line.getElementsByTagName('th')[0];
				var str=th.innerHTML;
				ufLog(str);
				if(str.indexOf("[background=")==0)//si le background encadre le message, on le met sur toute la case.
					{
					var color=str.substr(12,str.indexOf(']')-12);
					//alert(color);
					th.style.backgroundColor=color;
					str=str.substring(str.indexOf(']')+1,str.lastIndexOf('[/background]'));//on retire le tag background utilisé
					//alert(str);
					}
				//var str=convertSmileys(convertBBcode(str));
				var str=convertBBcode(str);
				if(str.indexOf(th.innerHTML)>-1);
				else	th.innerHTML= str;
			}
		}
		var path = '//td[@class="titmsgally"]';
		var obj = ufEval(path,document);
		if(obj.snapshotLength>0)
		{
			for (var i = 0; i <obj.snapshotLength; i+=3)
			{
				var tr = obj.snapshotItem(i).parentNode;
				var line=tr.nextSibling;
				var th = line.getElementsByTagName('th')[0];
				//var str=convertSmileys(convertBBcode(th.innerHTML));
				var str=convertBBcode(th.innerHTML);
				if(str.indexOf(th.innerHTML)>-1);
				else	th.innerHTML= str;
			}
		}
	}
	else {
		if(uf_isModoReportedMessagesUrl(document.location.href))//messages signalés
			{
			var path = '/html/body/table/tbody/tr[2]/td/table/tbody/tr/th[@colspan="2"]';
			var obj = ufEval(path,document);
			/*if(obj.snapshotLength>=4)
				{*/
				for (var i = 0; i <obj.snapshotLength; i++)
					{
					var tr=obj.snapshotItem(i);
					ufLog(tr.innerHTML);
					var cell=tr;//.firstChild;
					//alert(cell.innerHTML);
					//var str=convertSmileys(convertBBcode(cell.innerHTML));
					var str=convertBBcode(cell.innerHTML);
					if(str.indexOf(cell.innerHTML)>-1);//si il n'y a pas eu de changement, on ne fait rien
					else cell.innerHTML= str;
					}
				//}
			}
		if(uf_isModoPlayerMessagesUrl(document.location.href))
		{
		
			var path = '/html/body/table/tbody/tr[2]/td/form[2]/table/tbody/tr';
			var obj = ufEval(path,document);
		ufLog('isModoPlayerMessagesUrl'+obj.snapshotLength);	
			if(obj.snapshotLength>=5)
				{
				for (var i = 5; i <obj.snapshotLength; i+=2)
					{
					var tr=obj.snapshotItem(i);
					var cell=tr.getElementsByTagName('th')[0];
					//alert(cell.innerHTML);
					//var str=convertSmileys(convertBBcode(cell.innerHTML));
					var str=convertBBcode(cell.innerHTML);
					if(str.indexOf(cell.innerHTML)>-1);//si il n'y a pas eu de changement, on ne fait rien
					else cell.innerHTML= str;
					}
				}
		}
		
	}
	}
	catch (e) {
		unifoxdebug(e,"bbcode",document);
	}
}


//*****************************************************************************************
function uf_colorizePrivates(document) {

	if (document && !uf_isMessagesUrl(document.location.href)) return;
	if (!ufGetPref("unifoxHighlightPrivates",true)) return;
	//alert('ok');
	
	ufLog("Estamos privados");
	
	try {

		var path = '//td[@class="titmsgprive"]';
		var obj = ufEval(path,document);
		
		var color=ufGetColorPref("ufPrivateColor","#AA3333",false);
		/*try {
			var color = PrefsBranchUF.getCharPref("ufPrivateColor");
		} catch(e) { var color ="#AA3333";}*/
		if(obj.snapshotLength>0)
		{
			var table = obj.snapshotItem(0).parentNode.parentNode;
			var lines=table.getElementsByTagName('tr');
			//alert(table.innerHTML);
			for (var i = 0; i <lines.length; i++)
			{	
				
				if(lines[i].innerHTML.match(/titmsgprive/))
				{
				//alert("obj\n"+lines[i].innerHTML);
				myth = lines[i+1].getElementsByTagName('th')[0];
				//alert("myth\n"+myth.innerHTML);
				myth.setAttribute("style", "background-color : "+color+"; background-image : none;");
				}
				//alert("obj2\n"+obj2.innerHTML);
				//path = '//th[@colspan="3"]';
				//myth = ufEvalnode(path,document,obj2).snapshotItem(0);

			}
		}

	} catch (e) {
		unifoxdebug(e,"private messages color",doc);
	}
}

//*****************************************************************************************
function uf_addMessageOption(doc) {
try {
	if (!doc || !uf_isMessagesUrl(doc.location.href)) return;
	if (!ufGetPref("unifoxAddMessageOption",true)) return;
		uf_addJavaScript(doc, "chrome://unifox/content/resources/js/messages.js");
		//on ajoute la suppression des messages non selectionnes dans les propositions
		var select=doc.getElementsByName("supmsg2")[0];
		select.innerHTML+='<option value="myeff">Effacer les messages non selectionn\u00E9s</option>';
		select=doc.getElementsByName("supmsg1")[0];
		select.innerHTML+='<option value="myeff">Effacer les messages non selectionn\u00E9s</option>';
	//	doc.getElementsByName("button2")[0].setAttribute('type','button');
		doc.getElementsByName("button2")[0].setAttribute('onclick',  "uf_messageOptionListener(this);");
		doc.getElementsByName("button1")[0].setAttribute('onclick',  "uf_messageOptionListener(this);");
		//doc.getElementsByName("button1")[0].addEventListener("click",  uf_messageOptionListener, true);
		
}
catch (e) {
		unifoxdebug(e,"add message option",doc);
	}
}
//*****************************************************************************************
function uf_checkEmptySimu(doc)//retourn false si le simu n'est pas vide
{
var test=true;

//test sur les parametres en get
if(doc.location.href.match(/action=simu&/))return false;

//technos
if(uf_parseInt(doc.getElementsByName("ad")[0].value)!=0)
	return false;
if(uf_parseInt(doc.getElementsByName("bd")[0].value)!=0)
	return false;
if(uf_parseInt(doc.getElementsByName("cd")[0].value)!=0)
	return false;
/*if(uf_parseInt(doc.getElementsByName("aa")[0].value)!=0)
	return false;
if(uf_parseInt(doc.getElementsByName("ba")[0].value)!=0)
	return false;
if(uf_parseInt(doc.getElementsByName("ca")[0].value)!=0)
	return false;	*/

//vaisseaux
for(i=1;i<uf_shipsList.length;i++)
	{
	if(doc.getElementsByName("d_"+i)[0])
		if(uf_parseInt(doc.getElementsByName("d_"+i)[0].value)!=0)
			return false;
	}
/*for(i=1;i<uf_shipsList.length;i++)
	{
	if(doc.getElementsByName("a_"+i)[0])
		if(uf_parseInt(doc.getElementsByName("d_"+i)[0].value)!=0)
			return false;
	}*/
	
//defenses
for(i=1;i<10;i++)
	{
	if(uf_parseInt(doc.getElementsByName("d_10"+i)[0].value)!=0)
		return false;
	}
for(i=10;i<uf_defsList.length;i++)
	{
	if(uf_parseInt(doc.getElementsByName("d_1"+i)[0].value)!=0)
		return false;
	}


return test;
}

function uf_simulator(doc) {
try {
	if (doc && !uf_isSimuUrl(doc.location.href)) return;
	if (!ufGetPref("unifoxSimulator",true) && !ufGetPref("unifoxRECopy",true) && !ufGetPref("unifoxLastFleets",true)) return;

															//on verifie qu'il n'y a aucun RE déjà chargé
	var tables=doc.getElementsByTagName("table");
   var x=0;
	for(i=0;i<tables.length;i++)
		{
		if(tables[i].innerHTML.match(/simulation/)){x=i;}
		}
	
	table=tables[x];
	//alert(table.innerHTML);
	var lines=table.getElementsByTagName("tr");
	var line=lines[1];
	//alert(line.innerHTML);
	var box=line.getElementsByTagName("th")[1];
	var nbsim=parseInt(box.innerHTML);
//alert(nbsim);

	//chargement de l'attaquant et du défenseur
if(uf_checkEmptySimu(doc))//si le simulateur est vide
{
if(ufGetPref("ufLoadRE",true) && ufGetPref("unifoxRECopy",true) && nbsim==0 )//si on est pas en train de simuler et qu'aucun RE n'est chargé, on écrit les flottes//le RE si il y en a un
	{
	var defender = new ufReport("unifoxSpyRepport",new Array(),new Array(),new Array(),new Array(),"",999);
	defender.load();
	defender.writeTarget(doc);
	defender.writeD(doc);
	ufSetBooleanPref("ufLoadRE", false);
	
	if(ufGetPref("unifoxLastFleets",true))
		{	
		var attacker=new ufReport("",null,null,null,null,"",997);
		attacker.load();	
		attacker.writeA(doc);
		}
	}
else if(ufGetPref("unifoxLastFleets",true)){//sinon on écrit le dernier défenseur
	var defender=new ufReport("",null,null,null,null,"",998);
	defender.load();	
	defender.writeD(doc);
	defender.writeTarget(doc);
	var attacker=new ufReport("",null,null,null,null,"",997);
	attacker.load();	
	attacker.writeA(doc);
	}
}
doc.defaultView.addEventListener("unload",ufReportsUninit2,false);

if(ufGetPref("unifoxSimulator",true))//boutons supplémentaires
{
ufReports.init();
doc.defaultView.addEventListener("unload",ufReportsUninit,false);
//displayproperties_o(doc);
//doc.body.setAttribute('onUnload',"ufReportsUninit();");

//ajout des boutons

var inp=doc.getElementsByTagName("input")[0];
if(inp.value.match(/^Reset$/))
	{
	/*inp.setAttribute('type',"reset");
	var body=doc.getElementById("divpage");
	var st=body.innerHTML.replace(/<form action="\?action=simu" method="post">/,'').replace(/<\/form>/,'');
	st='<form action="?action=simu" method="post">'+st+'</form>';
	body.innerHTML=st;*/
	
	inp.setAttribute('type',"button");
	inp.addEventListener("click",uf_simuButtonsListener,false);
	}

inp=doc.getElementsByName("aa")[0];
var table=inp.parentNode.parentNode.parentNode;
var target=table.getElementsByTagName('tr')[0];
var tr=doc.createElement('tr');
tr.innerHTML="";
table.insertBefore(tr,target.nextSibling);
var td=doc.createElement('td');
td.setAttribute('colspan','6');
td.setAttribute('class','c');
tr.appendChild(td);
table = doc.createElement('table');
td.appendChild(table);
tr = doc.createElement('tr');
table.appendChild(tr);

var tds=new Array(6);
for(i=0;i<3;i++)
	{
	tds[i]=doc.createElement('td');
	tr.appendChild(tds[i]);
	}
for(i=0;i<3;i++)
	{
	switch(i)
		{
		case 0:value='save';
				id='sa';
				inp=doc.createElement('input');
				inp.value=value;
				inp.setAttribute('id',id);
				inp.setAttribute('type','button');
				inp.setAttribute('style','width:3.2em;');
				inp.addEventListener("click",uf_simuButtonsListener,false);
				tds[i].appendChild(inp);
				value='load';
				id='la';
				inp=doc.createElement('input');
				inp.value=value;
				inp.setAttribute('id',id);
				inp.setAttribute('type','button');
				inp.setAttribute('style','width:3.2em;');
				inp.addEventListener("click",uf_simuButtonsListener,false);
				tds[i].appendChild(inp);
				select = doc.createElement('select');
				select.setAttribute('id','Aselect');
				select.addEventListener("change",uf_simuButtonsListener,false);
				tds[i].appendChild(select);
				for(x=1;x<=ufReports.nbreports;x++)
					{
					option = doc.createElement('option');
					option.value=x-1;
					option.innerHTML="n\u00B0"+x;
					select.appendChild(option);
					}
				inp=doc.createElement('input');
				inp.setAttribute('id','Aname');
				inp.setAttribute('type','text');
				inp.setAttribute('style','width:5em;');
				tds[i].appendChild(inp);
				//inp.value=ufReports.reports[select.selectedIndex].name;
				/*x=0;
				var test=true;
				while(test)try {
						var rep = PrefsBranchUF.getCharPref("unifoxAttackerReports"+x);
					option = doc.createElement('option');
					option.value=x;
					option.innerHTML="n°"+x;
					select.appendChild(option);
					} catch(e) { test=false}*/
				
				break;
		case 1:value='<->';
				id='permut';
				inp=doc.createElement('input');
				inp.value=value;
				inp.setAttribute('id',id);
				inp.setAttribute('type','button');
				inp.setAttribute('style','width:3.2em;');
				inp.addEventListener("click",uf_simuButtonsListener,false);
				tds[i].appendChild(inp);
				break;
		case 2:value='save';
				id='sd';
				inp=doc.createElement('input');
				inp.value=value;
				inp.setAttribute('id',id);
				inp.setAttribute('type','button');
				inp.setAttribute('style','width:3.2em;');
				inp.addEventListener("click",uf_simuButtonsListener,false);
				tds[i].appendChild(inp);
				value='load';
				id='ld';
				inp=doc.createElement('input');
				inp.value=value;
				inp.setAttribute('id',id);
				inp.setAttribute('type','button');
				inp.setAttribute('style','width:3.2em;');
				inp.addEventListener("click",uf_simuButtonsListener,false);
				tds[i].appendChild(inp);
				select = doc.createElement('select');
				select.setAttribute('id','Dselect');
				select.addEventListener("change",uf_simuButtonsListener,false);
				tds[i].appendChild(select);				
				for(x=1;x<=ufReports.nbreports;x++)
					{
					option = doc.createElement('option');
					option.value=x-1;
					option.innerHTML="n\u00B0"+x;
					select.appendChild(option);
					}
				inp=doc.createElement('input');
				inp.setAttribute('id','Dname');
				inp.setAttribute('type','text');
				inp.setAttribute('style','width:5em;');
				tds[i].appendChild(inp);
				//inp.value=ufReports.reports[select.selectedIndex+ufReports.nbreports].name;
				break;
		default:value="error";
				id="error";
		}

	
	}
}	

}
catch (e) {
		unifoxdebug(e,"simulator",doc);
	}
}

//*****************************************************************************************
function uf_addREListener(doc) {
try {
	if (document && !uf_isMessagesUrl(doc.location.href)) return;
	if (!ufGetPref("unifoxRECopy",true)&&!ufGetPref("ufRENeededShips",true)) return;
		//uf_addJavaScript(doc, "chrome://unifox/content/resources/js/re.js");
	if(ufGetPref("unifoxRECopy",true))
	{
	doc.addEventListener("mouseup",  uf_REListener, true);//listener pour la lecture de RE
	
	//ajout d'un lien vers le simulateur sur la page des messages
	//doc.getElementsByTagName("table")[7].innerHTML+="<th colspan=\"4\"><a href=\"?action=simu\" accesskey=\"s\">Simulateur</a></th>"; //retrait le 19/05/08
	//document.getElementsByTagName("table")[5].innerHTML+="<th colspan=\"4\"><a href=\"?action=simu\" accesskey=\"s\">Simulateur</a></th>";
	var allth=doc.getElementsByTagName("td");
	var i=0;
	for(i=0;i<allth.length-1;i++)
		{
		if(allth[i].innerHTML.match(/(Tour de contr.le)/gi) && allth[i+1].innerHTML.match(/(Espionnage)/))
			{
			var th=allth[i];
			//var th=allth[i].parentNode.nextSibling.firstChild;
			th.innerHTML='';
			var inp=doc.createElement('input');
			inp.setAttribute('type','button');
			inp.setAttribute('value','SIMULER');
			
			th.appendChild(inp);
			inp.addEventListener("click",  uf_RELinkListener, true);//listener pour la lecture de RE
			//doc.addEventListener("DOMNodeInserted", alert, false); 
			//alert(res[2]);
			}
		}
	}
	if(ufGetPref("ufRENeededShips",true))
	{
	var ufUnits = uf_getUnitsData();
	ufLog("ufUnits['fleet'][1]['name']:"+ufUnits['fleet'][1]["name"]);
	//ufDump(ufUnits);
	//var ufUnitsXMLDoc=uf_getXML("ufUnits.xml");
	var shipsConsts = ufUnits['fleet'];//ufReturnArrayOfArraysFromXML(ufUnitsXMLDoc,"ship", new Array("name","capacity"), true);
	
		var allth=doc.getElementsByTagName("td");
		//ufLog("allth="+allth.length);
		var i=0;
		for(i=0;i<allth.length-1;i++)
		{
			if((allth[i].innerHTML.match(/(Tour de contr.le)/gi)|| allth[i].innerHTML.match(/<input value="SIMULER"/)) && allth[i+1].innerHTML.match(/(Espionnage)/) )
			{
				var th=allth[i];
				//if(th.innerHTML.indexOf("Tour de contr")>-1)th.innerHTML='';
				ufLog("th.innerHTML="+th.innerHTML);
				var line = th.parentNode.nextSibling;
				ufLog("line.innerHTML="+line.innerHTML);
				var RE = line.firstChild.nextSibling;
				ufLog("RE="+RE.innerHTML);
				var res = uf_REReadResources(RE);
				
				var ships = uf_REReadShips(RE);
				var totalRes = 0;
				var totalGain = [0,0,0,0];
				var totalCdr = 0;
				ufDump(ships);
				ufDump(res);
				ufLog(i+" "+res.length);
				var test=false;
				for(var j in res)
					if(res[j]>0)
						test=true;
				if(test)//si il y a des ressources à quai
				{//on ajoute la quantité de vaisseaux
					
					
					for(var j in res)
					{
						totalGain[j] += res[j]/2;
						totalRes += res[j];
					}
					
					var shipNum=ufGetPref("ufRENeededShip", 1);
					var capacite = shipsConsts[shipNum]["capacity"];
					var name = shipsConsts[shipNum]["name"];
					var vaisseaux=totalRes/capacite/2;
					ufLog("total:"+totalRes+" "+capacite+" "+name);
					if(vaisseaux<10)vaisseaux=Math.round(100*vaisseaux)/100;
					else if(vaisseaux<100)vaisseaux=Math.round(10*vaisseaux)/10;
					else vaisseaux=Math.round(vaisseaux);
					var span=doc.createElement('span');
					span.style.color=ufTextColor;
					span.innerHTML=" "+vaisseaux+" "+name+" pour piller la moiti\u00E9 des ressources";
					RE.appendChild(span);
				}
				
				test = false;
				for(var j in ships)
					if(ships[j]>0)
						test=true;
				if(test)//si il y a des vaisseaux à quai
				{
					
					for(var j = 0;j< ships.length;j++)
						if(ships[j]>0)
						{
							
							currentTitCDR = ships[j]*Math.floor(shipsConsts[j+1]['price'][0]*0.35);
							currentCarCDR = ships[j]*Math.floor(shipsConsts[j+1]['price'][1]*0.35);
							currentTritCDR = ships[j]*Math.floor(shipsConsts[j+1]['price'][2]*0.35);
							currentCDR = currentTitCDR+currentCarCDR+currentTritCDR;
							totalGain[0] += currentTitCDR;
							totalGain[1] += currentCarCDR;
							totalGain[2] += currentTritCDR;
							ufLog(j+" "+totalCdr+" "+ships[j]+" "+shipsConsts[j+1]['price'][0]+" "+shipsConsts[j+1]['price'][1]+" "+currentCDR);
							totalCdr += currentCDR;
						}
					var rec = Math.ceil(totalCdr/20000);
					var span=doc.createElement('span');
					span.style.color=ufTextColor;
					span.innerHTML=" <br/>CDR: "+totalCdr+" ("+rec+" Collecteur pour l'emporter)";
					RE.appendChild(span);
				}
				for(var j = 0;j<3;j++)
					totalGain[3] += totalGain[j];
				ufDump(totalGain);
				if(totalGain[3] > 0)
				{
					var span=doc.createElement('span');
					span.style.color=ufTextColor;
					span.innerHTML=" <br/>Gain Total: "+totalGain[3]+" ressources ("+totalGain[0]+"/"+totalGain[1]+"/"+totalGain[2]+")";
					RE.appendChild(span);
				}
			}
			
			
		}
	}
}
catch (e) {
		unifoxdebug(e,"add re listener",doc);
	}
}

//*****************************************************************************************
function uf_colorizeAllyMessages(document) {

	if (document && !uf_isMessagesUrl(document.location.href)) return;
	if (!ufGetPref("unifoxHighlightAllyMessages",true)) return;
	//alert('ok');
	
	ufLog("Estamos privados");
	
	try {

		var path = '//td[@class="titmsgally"]';
		var obj = ufEval(path,document);
		var color=ufGetColorPref("ufAllyColor","#AA3333",false);
		
		/*try {
			var color = PrefsBranchUF.getCharPref("ufAllyColor");
		} catch(e) { var color ="#AA3333";}*/
		if(obj.snapshotLength>0)
		{//alert('ok');
			var table = obj.snapshotItem(0).parentNode.parentNode;
			var lines=table.getElementsByTagName('tr');
			//alert(table.innerHTML);
			//displayproperties_o(lines);
			for (var i = 0; i <lines.length; i++)
			{	
				
				if(lines[i].innerHTML.match(/titmsgally/))
				{
				//alert("obj\n"+lines[i].innerHTML);
				myth = lines[i+1].getElementsByTagName('th')[0];
				//alert("myth\n"+myth.innerHTML);
				myth.setAttribute("style", "background-color : "+color+"; background-image : none;");
				//displayproperties_o(myth);
				}
				//alert("obj2\n"+obj2.innerHTML);
				//path = '//th[@colspan="3"]';
				//myth = ufEvalnode(path,document,obj2).snapshotItem(0);

			}
		}
	} catch (e) {
		unifoxdebug(e,"ally messages color",doc);
	}
}
//*****************************************************************************************
/*function uf_removeIdle(str)
{
	if(str.match(/\(\+ 21\)/))
	{
	return str.substr(0,str.length-6);
	}
	else if(str.match(/\(\+ 7\)/))
	{
	return str.substr(0,str.length-5);
	}
}*/

function uf_addRanks(document) {

	if (document && !uf_isGalaxyUrl(document.location.href)) return;
	if (!ufGetPref("unifoxAddRanks",true)) return;	

	ufLog("ranks");

	try {
		var path = "id('divpage')/table/tbody/tr/th[4]/a/span";//noms des joueurs
		
		var obj = ufEval(path,document);

		for (var i = 0; i < obj.snapshotLength; i++) {
			obj2 = obj.snapshotItem(i);

				//récupération du classement
				var code=obj2.parentNode.parentNode.innerHTML;
				var rank=code.substr(code.indexOf("Joueur "));
				rank.substr(0,rank.indexOf("<"));
				if(rank.indexOf("(")>-1)
					rank=rank.substr(rank.indexOf("("),rank.indexOf(")")-rank.indexOf("(")+1);
				else 
					rank="";
				//var L=rank.length;
				//on ne garde que le nombre
				rank=uf_parseInt(rank);
				if(rank!=0){
					var cell=obj2.parentNode.parentNode;
					var coor=uf_getPosition(cell);
					var top=coor.y;
					
					//var right=window.clientWidth-coor.x-cell.clientWidth;
					var div=document.createElement('div');
					div.setAttribute('id','rank'+rank)
					//div.setAttribute('style','font-size:0.85em;color:'+ufTextColor+';position:absolute;right:'+right+'px;top:'+top+'px;');
					div.setAttribute('style','font-size:0.85em;position:absolute;0px;top:0px;');
					div.innerHTML=rank;
					document.body.appendChild(div);
					ufLog("div.clientWidth="+div.clientWidth);
					//div=document.getElementById('rank'+rank);
					var left=coor.x+cell.clientWidth-div.clientWidth;
					div.setAttribute('style','font-size:0.85em;color:'+ufTextColor+';position:absolute;left:'+left+'px;top:'+top+'px;');
					
					}
				//obj2.innerHTML+="#"+rank;
		}
	} catch (e) {
		unifoxdebug(e,"galaxy ranks",document);
	}
}

//*****************************************************************************************
function uf_selectMission(document) {

	function uf_getPref(pref) {
		try {
			return PrefsBranchUF.getCharPref(pref)
		} catch(e) {
			return "-1";
		}
	}
	var missions=new Array('attaque','espionnage','recyclage','coloniser','exploiter','transport','stationnement');

	if (document && !uf_isFlota2Url(document.location.href)) return;

	var path = '//input[@type="submit"]';
	var obj = ufEval(path,document);
	if (obj.snapshotLength > 0) {
		obj.snapshotItem(0).setAttribute('accessKey','z');
		obj.snapshotItem(0).focus();	
	}

	var pref = uf_getPref("ufMissionPreference0");

	if (pref == "-1") return;
	ufLog("Estamos mission select");

	try {
	      var path = '//input[@name="ordre"][@checked="checked"]';
     		var obj = ufEval(path,document);
		if (obj.snapshotLength != 0)	return;
			var path = '//input[@name="ordre"][@checked="1"]';
     		var obj = ufEval(path,document);
		if (obj.snapshotLength != 0)	return;
			var path = '//input[@name="ordre"][@checked="true"]';
			var obj = ufEval(path,document);
		if (obj.snapshotLength != 0)	return;
		var i = 0;
		while(pref != "-1") {
			var num=parseInt(pref)-1;
			var st= missions[num];
		      path = '//input[@name="ordre"][@value="'+st+'"]';
      		obj = ufEval(path,document);
			//alert(st);
			if (obj.snapshotLength != 0) {
				obj = obj.snapshotItem(0);
				obj.checked = "true";
				if(st.match(missions[0]))//pour la 2.25, avec la sélection de cible, en cas d'attaque
				{
				//alert('ok1');
				var script = document.createElement('script');
				script.innerHTML = "setCible(1);";
				document.body.appendChild(script);
					//alert('ok');
					}
				if(st.match(missions[4]))
				{
				//alert('ok');
				var speed= ufGetPref("ufVESpeed", 100);//alert(speed);
				var select=document.getElementsByName("vitesse")[0];
				for(i=0;i<select.options.length;i++)
					{
					if(parseInt(select.options[i].value)==speed)
						{
						select.options[i].selected="true";
						i=select.options.length;
						}
					}
				}
				return;
			}
			i++;
			pref = uf_getPref("ufMissionPreference"+i);
		}
		return;
	} catch(e) {
		unifoxdebug(e,"mission selection",document);
	}
}

//*****************************************************************************************
function uf_writeInMessage(event)
{
try {
var table = event.target.parentNode.parentNode.parentNode;
var thetxtarea = table.getElementsByTagName('textarea')[0];		
		var signature=ufGetPref("ufMsgSign","");
		
		/*try {
			var signature = PrefsBranchUF.getCharPref("ufMsgSign");
		} catch(e) { var signature ="";}*/
		if(!ufGetPref("unifoxMessageSignature",false))signature="";
		thetxtarea.value+=signature;
//alert(sign
if (ufGetPref("ufWrittenMessages",false))
	{
	if(ufGetPref("ufWrittenMessagesBold",false))
		{
		thetxtarea.value="[b]"+thetxtarea.value+"[/b]";
		}
	if(ufGetPref("ufWrittenMessagesItalic",false))
		{
		thetxtarea.value="[i]"+thetxtarea.value+"[/i]";
		}
	
	var color=ufGetColorPref("ufWrittenMessagesColor","",true);
	if(uf_isColor(color,false))
		{
		thetxtarea.value="[color="+color+"]"+thetxtarea.value+"[/color]";
		}
	color=ufGetColorPref("ufWrittenMessagesBackground","",true);
	if(uf_isColor(color,false))
		{
		thetxtarea.value="[background="+color+"]"+thetxtarea.value+"[/background]";
		}
	}
//alert(thetxtarea.value);
} catch(e) {
		unifoxdebug(e,"sign",doc);
	}
}

function uf_formatMessage(document) {

	if (document && !uf_isWriteMessagesUrl(document.location.href) && !uf_isWriteAllyMessagesUrl(document.location.href)) return;
	if (!ufGetPref("ufWrittenMessages",false) && !ufGetPref("unifoxMessageSignature",false)) return;

	
	ufLog("Formatage des messages");
	
	try {
	/*if(uf_isWriteMessagesUrl(document.location.href))
		{*/
		var path = '//input[@type="submit"]';
		var obj = ufEval(path,document);
		if (obj.snapshotLength == 0) return;
		var obj = obj.snapshotItem(0);
		obj.addEventListener('click',uf_writeInMessage,true);	
		//alert('ok2');
	/*	}
	else if(uf_isWriteAllyMessagesUrl(document.location.href))
		{
		var path = '//input[@type="submit"]';
		var obj = ufEval(path,document);
		if (obj.snapshotLength == 0) return;
		var obj = obj.snapshotItem(0);
		obj.addEventListener('click',uf_writeInMessage,true);	
		//alert('ok2');
		}*/
	} catch(e) {
		unifoxdebug(e,"message formating",doc);
	}
}

//*****************************************************************************************
function uf_pasteCoords(document) {

	if (document && !uf_isFlota2Url(document.location.href)) return;

	/*var path = '//input[@type="submit"]';
	var obj = ufEval(path,document);
	if (obj.snapshotLength > 0) 
	{
		obj.snapshotItem(0).setAttribute('accessKey','z');
		obj.snapshotItem(0).focus();
	}*/

	if (!ufGetPref("unifoxCoordCopy",false)) return;
	if (!ufGetPref("unifoxStoreCoordFlag",false)) return;

	ufLog("Estamos pegar coordenadas");
	try {
		var str = PrefsBranchUF.getCharPref("unifoxStoreCoord");
	} catch(e) { return;}

	try {
	var evt = document.createEvent("HTMLEvents");
	evt.initEvent("change", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
  
		str = str.split(':');
		uf_Galaxy = str[0];
		uf_System = str[1];
		uf_Planet = str[2];
		//if(uf_System<401)
		if (document.getElementsByName("galaxie_arr")[0].value == document.getElementsByName("galaxie_dep")[0].value && document.getElementsByName("systeme_arr")[0].value == document.getElementsByName("systeme_dep")[0].value && document.getElementsByName("planete_arr")[0].value == document.getElementsByName("planete_dep")[0].value) 
			{
			document.getElementsByName("galaxie_arr")[0].value = uf_Galaxy;
			document.getElementsByName("systeme_arr")[0].value = uf_System;
			document.getElementsByName("planete_arr")[0].value = uf_Planet;
			document.getElementsByName("vitesse")[0].dispatchEvent(evt);
			//alert(document.getElementsByName("vitesse")[0].innerHTML);
			}
		//setTimeout("Infov();",1);	
		
	} catch(e) {
		unifoxdebug(e,"coord pasting",doc);
	}
}

//*****************************************************************************************
function uf_infosDeltas(document){
	if (document && !uf_isBuildingInfosUrl(document.location.href)) return;
	if (!ufGetPref("unifoxInfosDeltas",true)) return;

	
	ufLog("Estamos deltas de info de edificios");
	
	try {

		var path = '//table[@width="519"]/descendant::th/font[@color="lime"]';
		var obj = ufEval(path,document);
		//alert('ok');
		if (obj.snapshotLength == 0) return;
		var row=3;
		for(var i=0;i<3;i++)
			{
			var line = obj.snapshotItem(0).parentNode.parentNode.parentNode.getElementsByTagName("tr")[i+1];
				var cell=line.firstChild;
				if(cell.innerHTML.indexOf('<font')>-1)
				row=i+1;
			}
		
		
		var tr = obj.snapshotItem(0).parentNode.parentNode.parentNode.getElementsByTagName("tr")[row];
		//alert("1:\n"+tr.innerHTML);
		obj = ufEvalnode('.//th[2]',document,tr);
		//alert("2:\n"+obj.snapshotItem(0).innerHTML);
		if (obj.snapshotLength == 0) return;
		var value = uf_doubleParseInt(obj.snapshotItem(0).innerHTML);
		//alert(value);
		obj = ufEvalnode('.//tr/th[2]',document,tr.parentNode);
		//alert("3:\n"+obj.snapshotItem(0).innerHTML);
		unifox_addDeltas2(obj,value,document,0);


		obj = ufEvalnode('.//th[3]',document,tr);
		//alert("4:\n"+obj.snapshotItem(0).innerHTML);
		if (obj.snapshotLength == 0) return;
		var value = uf_parseInt(obj.snapshotItem(0).innerHTML);
		//alert(value);
		obj = ufEvalnode('.//tr/th[3]',document,tr.parentNode);
		//alert("5:\n"+obj.snapshotItem(0).innerHTML);
		unifox_addDeltas2(obj,value,document,1);
		
	} catch(e) {
		unifoxdebug(e,"infos deltas",doc);
	}
}

//*****************************************************************************************
function unifox_addDeltas2(obj, value, document,mode) {
	try {
		var temp, diff;
		for (var i = 1; i < obj.snapshotLength; i++) {
			if(mode==0)temp = uf_doubleParseInt(obj.snapshotItem(i).innerHTML);//prod
			else if(mode==1)temp = uf_parseInt(obj.snapshotItem(i).innerHTML);//conso
			else temp=0;
			if (isNaN(temp)||temp == value)
				continue;
			if (temp < value) {
				diff = temp - value;
				var font = document.createElement('font');
				font.setAttribute('color', 'red');
				font.setAttribute('face', 'Courier New,Arial');
				font.innerHTML=" ("+uf_addFormat(diff)+")";
				obj.snapshotItem(i).appendChild(font);
			} else {
				diff = temp - value;
				var font = document.createElement('font');
				font.setAttribute('color', 'yellow');
				font.setAttribute('face', 'Courier New,Arial');
				font.innerHTML=" (+"+uf_addFormat(diff)+")";
				obj.snapshotItem(i).appendChild(font);
			}
		}
	} catch(e) {
		unifoxdebug(e,"addDeltas2",doc);
	}
}

//*****************************************************************************************
function unifox_addDeltas(obj, temp, document) {
	try {
		for (var i = 0; i < obj.snapshotLength; i++) {
			value = uf_parseInt(obj.snapshotItem(i));
			if (isNaN(value))
				continue;
			if (temp < value) {
				diff = temp - value;
				var font = document.createElement('font');
				font.setAttribute('color', 'red');
				font.innerHTML=" ("+uf_addFormat(diff)+")";
				obj.snapshotItem(i).appendChild(font);
			} else {
				diff = temp - value;
				var font = document.createElement('font');
				font.setAttribute('color', 'lime');
				font.innerHTML=" ("+uf_addFormat(diff)+")";
				obj.snapshotItem(i).appendChild(font);
			}
		}
	} catch(e) {
		unifoxdebug(e,"addDeltas",doc);
	}
}
//*****************************************************************************************
function uf_saveExploitLvl(doc) {
if (doc && !uf_isGlobalviewUrl(doc.location.href)) return;
	//if (!ufGetPref("unifoxAddOverviewTime",false)) return;
	var universe=doc.location.href.replace(/http:\/\/(.*)\.e-univers\.org.*$/,"$1");//;"beta1";
			
	//technologie exploitation
	var line=uf_getNode("id('divpage')/table/tbody/tr[77]",doc);
	var cells=line.getElementsByTagName('th');
	var lvl=0;
	for(var i=1;i<cells.length;i++)
	{
		var ltmp=uf_parseInt(cells[i].innerHTML);
		if(ltmp>lvl)lvl=ltmp;
	}
	ufSetCharPref("unifoxExploitationLevel"+universe,lvl+"");

	//technologie impulsion
	var line=uf_getNode("id('divpage')/table/tbody/tr[69]",doc);
	var cells=line.getElementsByTagName('th');
	var lvl=0;
	for(var i=1;i<cells.length;i++)
	{
		var ltmp=uf_parseInt(cells[i].innerHTML);
		if(ltmp>lvl)lvl=ltmp;
	}
	ufSetCharPref("unifoxImpulsionLevel"+universe,lvl+"");
}
//*****************************************************************************************
function uf_addOverviewFleet(table,divs,description,arrival,number){
try {
var document=table.ownerDocument;
//var scripts=table.getElementsByTagName('script');
//on construit la ligne
var line=document.createElement('tr');
var th1=document.createElement('th');
var th2=document.createElement('th');
th1.innerHTML=description;
line.appendChild(th1);

var date = new Date;
date.setTime(date.getTime()+arrival*1000);
th2.innerHTML='<div id="time'+number+'" title="time'+number+'">-</div>'+"<font color=\""+ufTextColor+"\">"+uf_relativeDate(date)+"</font>";
line.appendChild(th2);

/*var reg = /arrayTimer\[(.*)\] = ([0-9]+);/gi;
var target="";
var num1,num2;
num1=0;
num2=0;
for(var i=0;i<scripts.length;i++)
	{
	//var script = prev.getElementsByTagName("script")[0];
			//alert(script.innerHTML);
	var st=scripts[i].innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	var timer = parseInt(st.replace(reg, "$2"));
	if(timer>num1 && timer<arrival)num1=timer;//on part du principe que les horaires sont dans l'ordre
	else target=
	}
if(target)table.insertBefore(line,target.nextSibling);
else */table.appendChild(line);
/*var script = document.createElement('script');
script.innerHTML = "arrayTimer["+number+"] = "+arrival+";";
document.body.appendChild(script);*/

} catch (e) {
        unifoxdebug(e,"add overview fleet",table.ownerDocument);
}
}
//*****************************************************************************************
function uf_saveProd(doc) {
//alert('1');
	if (doc && !uf_isRessourcesUrl(doc.location.href)) return;
	if (!ufGetPref("unifoxProdTime",false)) return;
	ufLog("Production time");
try {
	path = '//select[@name="temps"]';
	obj = ufEval(path,doc);
	var prodratio=uf_parseInt(obj.snapshotItem(0).options[obj.snapshotItem(0).selectedIndex].value);//production horaire etc
	if(parseInt(prodratio)==3)
	{
	//***récupération des 3 productions
		//var path = '//table/tbody/tr/td[@class="l" and @colspan="2"]';/child::tbody/descendant::
		var path = '//th[.="Total :"]';
		var obj = ufEval(path,doc);
		var box=obj.snapshotItem(0);
		var line=box.parentNode;
		var boxes=line.getElementsByTagName("font");
		var values=new Array(5);//3 prod de ressources, prod de sat et ID de planète
		for(i=0;i<3;i++)
		{
		values[i]=uf_parseInt(boxes[i].innerHTML);
		}
		
	//***récupération de l'énergie par sat
		var table=line.parentNode;
		var lines=table.getElementsByTagName('tr');
		var energ=0;
		var satnb;
		for(i=0;i<lines.length;i++)
			{
			if(test=lines[i].innerHTML.match(/Satellite solaire[(]([0-9].*)[)]/))
				{
				//alert(lines[i].innerHTML.replace(/.*Satellite solaire[(]([0-9]).*[)].*/,"$1"));
				satnb=parseInt(test[test.length-1]);
				//satnb=test
				if(satnb>0)
					{
					boxes=lines[i].getElementsByTagName("th");
					var fonts=boxes[4].getElementsByTagName("font");
					if(fonts[0])
						{
						energ=uf_parseInt(fonts[0].innerHTML);
						//alert('f: '+fonts[0].innerHTML);
						}
					else {
						energ=uf_parseInt(boxes[4].innerHTML);
						}
					values[3]=3600*energ/satnb;
					}
				else values[3]=0;
				i=lines.length;
				//alert('nbsat '+satnb+'\nenerg '+energ+'\nprod '+values[3]);
				}
			}
			
	//***récupération de l'ID de la planète
		path = '//select[@name="planete_select"]';
		obj = ufEval(path,doc);
		values[4]=uf_parseInt(obj.snapshotItem(0).options[obj.snapshotItem(0).selectedIndex].value);//page de la planete

	//***sauvegarde
		//alert(values[2]+" "+values[3]);
		var temp=values.join('#');
		var saved=ufGetPref("unifoxRessources","");
		if(saved==""){var saving=temp;}
		else {
			//alert(saved);
			var tab=saved.split('/');
			//alert(tab[0]);
			var saving="";
			var add=true;
			//alert(tab.length);
			for(i=0;i<tab.length;i++)
			{
			tab2=tab[i].split('#');
			//alert(tab2.length);
			if(parseInt(tab2[tab2.length-1])==parseInt(values[4]))
				{
				if(values[3]==0)//si on n'a pas de sat, on n'écrase pas l'ancienne valeur
					{
					ufLog('pas de sat');
					values[3]=tab2[3];
					temp=values.join('#');
					}
				saving+=temp;//si on avait deja des donnees, on les écrase
				add=false;
				}
			else{
				saving+=tab[i];//sinon on "recole les morceaux"
				}
			if(i!=tab.length-1)saving+="/";
			//alert(i+" "+saving);
			}
			if(add)saving+="/"+temp;//si on n'a rien remplacé, on ajoute
			
			}
		ufSetCharPref("unifoxRessources",saving);
		//alert(saving);
        //alert(doc.location.href);
	}
} catch (e) {
        unifoxdebug(e,"saveprod",doc);
}
}
//***************************************************************************************** 
//////////////////////
////Tochaga's code////
//////////////////////

function getTCTE(doc) {

	var titanenode = uf_getNode("id('diventete')/table[1]/tbody/tr/th[2]",doc);//case contenant "titane \n quantité", dans l'entete
	if(!titanenode)
		titanenode = uf_getNode("/html/body/table/tbody/tr[1]/td[2]/table/tbody/tr/td/table/tbody/tr/th[2]",doc);//v3
		
	var carbonenode = uf_getNode("id('diventete')/table[1]/tbody/tr/th[4]",doc);
	if(!carbonenode)
		carbonenode = uf_getNode("/html/body/table/tbody/tr[1]/td[2]/table/tbody/tr/td/table/tbody/tr/th[4]",doc);//v3
	var tritiumnode = uf_getNode("id('diventete')/table[1]/tbody/tr/th[6]",doc);
	if(!tritiumnode)
		tritiumnode = uf_getNode("/html/body/table/tbody/tr[1]/td[2]/table/tbody/tr/td/table/tbody/tr/th[6]",doc);//v3
	var energienode = uf_getNode("id('diventete')/table[1]/tbody/tr/th[8]",doc);
	if(!energienode)
		energienode = uf_getNode("/html/body/table/tbody/tr[1]/td[2]/table/tbody/tr/td/table/tbody/tr/th[8]",doc);//v3
	var vtitane = parseInt(titanenode.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"").replace(/[^\d]+(\d+)[^\d]+/ig,'$1'));
	var vcarbone = parseInt(carbonenode.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"").replace(/[^\d]+(\d+)[^\d]+/ig,'$1'));
	var vtritium = parseInt(tritiumnode.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"").replace(/[^\d]+(\d+)[^\d]+/ig,'$1'));
	var venergie = parseInt(energienode.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"").replace(/(.*) \/\ (\d+)[^\d]+/ig,'$2'));
	//alert(venergie);
	//ufLog(vtitane+' '+vcarbone+' '+vtritium);
	return [vtitane, vcarbone, vtritium, venergie];
}
/////////////////////////
////End of Tochaga's code////
/////////////////////////

//*****************************************************************************************
function uf_requiredVortexLevel(href){
try{
var lvl=-1;
//var ufUniversesXml = uf_getXML("ufUniverses.xml");
var ufServers = uf_getServerData();
//ufLog("ufUniversesXml="+ufUniversesXml);
//var universes=ufEval("//server/universe",ufUniversesXml);
//ufLog("universes="+universes);
//ufLog("universes.length="+universes.snapshotLength);
ufLog("href="+href);
for(var i in ufServers["servers"]) 
	{
	for(var j in ufServers["servers"][i]["universes"]) 
		{
		var universe = ufServers["servers"][i]["universes"][j];
		//ufLog("obj.attributes.getNamedItem(url).textContent="+obj.attributes.getNamedItem("url").textContent);
		if(href.indexOf(universe["url"])>-1)
			{
			ufLog("obj.attributes.getNamedItem(vortex)="+universe["vortex"]);
			lvl=parseInt(universe["vortex"]);
			//i=universes.snapshotLength;
			}
		}
	}
/*switch(universe)##{##case "beta1"://x10 avec VE##		lvl=5;##		break;##case "beta2"://x10 sans VE##		lvl=3;
		break;##case "beta3"://x1 avec VE##		lvl=2;##		break;##case "beta4"://x5 avec VE##		lvl=4;##		break;##case "beta5"://x10 sans VE##		lvl=3;##		break;
		case "beta6"://x1 sans VE##		lvl=2;##		break;##case "bt"://x50 avec VE##		lvl=8;##		break;##case "testing"://x50 avec VE##		lvl=8;##		break;##default:
		lvl=2;##		break;##}*/
return lvl;
}catch(e){ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");}
}

function uf_vortex(doc,prod,having) {
if (doc && !uf_isVortexUrl(doc.location.href)) return;
ufLog("vortex starts");
//if (!ufGetPref("unifoxProdTime",false)) return;
try {
//var speed=uf_getUniverseSpeed(doc);
var path = "id('divpage')";
var obj = uf_getNode(path,doc);
if(obj.innerHTML.match(/Vous n.avez pas d.velopp. suffisamment votre/) || obj.innerHTML.match(/Vous n.avez pas de vortex sur cette plan.te/))//vortex pas encore débloqué, message d'aide
	{
	var lvl=uf_requiredVortexLevel(doc.location.href);
	if(lvl>=0)
		obj.innerHTML+="<br><span style='color:"+ufTextColor+";'>Il vous faut le niveau "+lvl+" pour pouvoir faire une tentative de cr\u00E9ation de Vortex.</span>";
	else 
		obj.innerHTML+="<br><span style='color:"+ufTextColor+";'>Niveau n\u00E9cessaire inconnu pour pouvoir faire une tentative de cr\u00E9ation de Vortex.</span>";
	}
else if(obj.innerHTML.match(/Vous pouvez tenter la cr.ation d.un vortex./)){//vortex débloqué, affichage du nombre de sats
	path = "id('divpage')/table/tbody/tr[2]/td[1]";//case avec le prix
	var obj = uf_getNode(path,doc);
	var cost=uf_parseInt(obj.innerHTML.replace(/.*Energie: .*\/(.*)/,"$1"));
	var sats=Math.ceil((cost-having[3])*3600/prod[3]);
	//ufLog(prod[3]+" "+cost+" "+having[3]);
	var symbole1=ufGetPref("unifoxProdTimeSymbol1","TIME!");
	if(!isNaN(sats))
		var st=sats+" satellites";
	else var st="nombre satellites n\u00E9cessaires inconnu";
	obj.innerHTML+=symbole1.replace("TIME!",st);			
	}
else if(obj.innerHTML.match(/Vous ne disposez pas de suffisamment d'.nergie pour stabiliser le vortex/)){//vortex naturel, affichage du nombre de sats
	path = "id('divpage')/table/tbody/tr[2]/td";//case avec le prix
	var obj = uf_getNode(path,doc);
	var cost=uf_parseInt(obj.innerHTML.replace(/.*Energie: .*\/(.*)/,"$1"));
	var sats=Math.ceil((cost-having[3])*3600/prod[3]);
	//ufLog(prod[3]+" "+cost+" "+having[3]);
	var symbole1=ufGetPref("unifoxProdTimeSymbol1","TIME!");
	if(!isNaN(sats))
		var st=sats+" satellites";
	else var st="nombre satellites n\u00E9cessaires inconnu";
	obj.innerHTML+=symbole1.replace("TIME!",st);			
	}
else if(obj.innerHTML.match(/Votre r.seau de vortex est indisponible jusqu.au/)){//vortex utilisé
	//<script language="text/javascript" type="text/javascript">arrayTimer[1] = 10;</script>
	//<div id="time1" title="time1">-</div>
	var str=obj.innerHTML.match(/\d\d\/\d\d\/\d\d\d\d/)+" "+obj.innerHTML.match(/\d\d:\d\d\:\d\d/);
	var day=uf_getDateFromFormat(str,"dd/MM/yyyy HH:mm:ss");//jour
	
	/*str=;
	var hour=uf_getDateFromFormat(str,);//jour
	ufLog("indispo"+str+" "+hour);
	var date=day+hour;
	ufLog("indispo"+day+" "+hour+" "+date);*/
	var now=new Date;
	now=now.getTime();
	var relativeDate=(day-now)/1000;
	/*var d=uf_formatDate(new Date(relativeDate),"dd/MM/yyyy HH:mm:ss");
		ufLog("indispo"+str+" "+day+" "+now+" "+relativeDate+" "+d);*/
	
	cell=obj.getElementsByTagName('td')[0];
	cell.innerHTML+='<div style="color:'+ufTextColor+';" id="time1" title="time1">-</div>';
	var script = doc.createElement("script");
	script.setAttribute("type", "text/javascript");
	script.setAttribute('language', 'javascript');
	script.innerHTML='var arrayTimer = new Array();'+
	'arrayTimer[1] = '+relativeDate+';'+
	'multiTimerFlotte ();'+
	/*'document.write(afficheDuree('+relativeDate+');'+*/
	//'alert("ok");'+
	'';
	cell.appendChild(script);
	//cell.innerHTML+="test";
	
	}	
} catch (e) {
        unifoxdebug(e,"vortex",doc);
}
ufLog("vortex ends");
}

//*****************************************************************************************
function uf_calcProdDelta(price,prod,having)
{
var time=0;
if(prod>0)
{
/*var path = '//th[@align="left" and @width="42"] ';
var obj = ufEval(path,doc);*/
var diff=price-having;//on calcule les ressources necessaires
if(diff>0)
	{//on calcule alors le temps necessaire
	time=3600*diff/prod;//temps en secondes
	}
//alert(time);
}
return time;

}

function uf_prodTime(doc) {
try {

if (doc && !uf_isProdTimeUrl(doc.location.href) && !uf_isVortexUrl(doc.location.href) && !uf_isShipyardUrl(doc.location.href)) return;
if (!ufGetPref("unifoxProdTime",false)) return;
ufLog("Production time");

//*********************
//chargement de la prod
//*********************
var saved=ufGetPref("unifoxRessources","");
if(saved==""){return;}
else {
	var Ress=new Array('Titane','Carbone','Tritium','Energie');

	path = '//select[@name="planete_select"]';
	obj = ufEval(path,doc);
	if(!obj)return;
	var planet=uf_parseInt(obj.snapshotItem(0).options[obj.snapshotItem(0).selectedIndex].value);//page de la planete
	var tab=saved.split('/');
	//alert(tab.length);
	var prod=new Array();
	prod[0]=-1;
	for(k=0;k<tab.length;k++)
		{
		tab2=tab[k].split('#');
		//alert(tab2.length);
		if(parseInt(tab2[tab2.length-1])==parseInt(planet))
			{
			for(j=0;j<tab2.length-1;j++)
				prod[j]=tab2[j];
			k=tab.length;
			}
		}
	prod[2]=prod[2]*2;//la production réelle de tritium est doublée (par rapport à l'affichage)
	//on recupere les ressources a quai**************
	var having=getTCTE(doc);
	//page vortex
	if(uf_isVortexUrl(doc.location.href)){
	uf_vortex(doc,prod,having);
	return;//on n'est pas sur batiments ou recherches
	}
	if(uf_isShipyardUrl(doc.location.href)){
	uf_addSatsOnShipyard(doc,prod,having);
	return;//on n'est pas sur batiments ou recherches
	}
	//alert(prod[0]+" "+prod[1]);
	if(prod[0]!=-1)
		{
		//*********************
		//*********************
		//calcul des ressources necessaires
		//*********************	
		
		var path = '//font[@class="prix"]';
		var obj = ufEval(path,doc);
		var price=new Array(4);
		for (var i = 0; i < obj.snapshotLength; i++)
			{			
			var box = obj.snapshotItem(i).parentNode.parentNode;
							//***boucle pour ne faire qu'une fois chaque case****
							var end=0;
							j=0;
							while(end==0)//tant que les font sont dans la même case
								{
								if(i+j<obj.snapshotLength)
									{
									//alert(box.innerHTML+"\n"+obj.snapshotItem(i+j).parentNode.parentNode.innerHTML);
									if(box==obj.snapshotItem(i+j).parentNode.parentNode)
										{
										//valueFonts[j]=obj.snapshotItem(i+j);
										j++;
										}
									else end=1;
									}
								else end=1;
								}
							i+=j-1;
							//***************************************************
			//on recupere le prix*************************
			var st=box.innerHTML;//alert(st);
			var ind=0;
			var ind2=0;
			var sub1="";
			st=st.replace(/\&nbsp;/,"");
			//alert(st);
			for(k=0;k<Ress.length;k++)
			{
			ind1=st.indexOf(Ress[k]);
			if(ind1>-1)
				{
				ind2=st.indexOf('</font>');
				sub1=st.substring(ind1,ind2);
				st=st.substring(ind2+6);//sauvegarde pour la suite
				ind1=sub1.indexOf('class="prix"');
				sub1=sub1.substring(ind1);
				price[k]=uf_parseInt(sub1);
				}
			else price[k]=0;
			}
			//if(box.innerHTML.match(Ress[3]))
			//alert(price[0]+" | "+price[1]+" | "+price[2]+" | "+price[3]+" | "+having[3]);
			//*********************
			//calcul du temps necessaire
			//*********************
			var times=new Array(Ress.length);
			for(j=0;j<Ress.length;j++)
				{
				times[j]=uf_calcProdDelta(price[j],prod[j],having[j]);
				//if(j==3 && price[j]>0)
				//alert(times[j]);
				}
			var min=times[0];
			var nb=0;
			for(k=0;k<3;k++)
			{
			if(times[k]>min)
				{
				nb=k;
				min=times[k];
				}
			}
			if(min>0 || price[3]>0)
				{
				st=box.innerHTML;
				//valueFonts[nb].innerHTML+='<span style="color:yellow; font:Courrier New, Arial;">*</span>';
				for(k=0;k<Ress.length;k++)
					{
					ind1=st.indexOf(Ress[k]);//position du nom de la ressource
					if(ind1>-1)
						{
						ind2=st.indexOf('</font>');//position de la fin de la font
						sub1=st.substring(ind1,ind2);//sub1 contient depuis le nom jusqu'a la fin de la font
						st=st.substring(ind2+6);//ce qui est apres la font
						//alert("sub:"+sub1+"\nst:"+st);
						//***formatage du temps
						var show=false;
						if(k==3)
							{
							st2=Math.ceil(times[k])+" satellites";
							show=true;
							}
						else{
							var t=times[k];
							if(t>0)
							{
							/*var date=new Date();
							date.setTime();*/
							var d=Math.floor(t/86400);
							var h=Math.floor((t-86400*d)/3600);
							var m=Math.floor((t-3600*h-86400*d)/60);
							var s=Math.round(t-86400*d-3600*h-60*m);
							if(h<10)var hh="0"+h;
							else var hh=h+"";
							if(m<10)var mm="0"+m;
							else var mm=m+"";
							if(s<10)var ss="0"+s;
							else var ss=s+"";
							
							var st2="";
							//st+='&nbsp;<span style="color:yellow;  font-family:Courrier New, Arial; font-size:0.8em">';
							if(d>0)st2+=d+'j '+h+'h '+mm+'m '+ss+'s';
							else if(h>0)st2+=h+'h '+mm+'m '+ss+'s';
							else if(m>0)st2+=mm+'m '+s+'s';
							else st2+=s+'s';
							//st+='</span>';
							show=true;
							}
							else show=false;
							}
							if(show)
								{
								//var symbole='*'+i+'<img alt="sablier jaune" src="http://jormund.free.fr/sablier4.gif"/>';
								var symbole1=ufGetPref("unifoxProdTimeSymbol1","TIME!");
								var symbole2=ufGetPref("unifoxProdTimeSymbol2","TIME!");
								symbole1=symbole1.replace(/TIME\!/g,st2);
								//symbole1=symbole1.replace(/\"/g,"'");
								//alert(symbole1);
								symbole2=symbole2.replace(/TIME\!/g,st2);
								//var symbole2='#'+i+'<img alt="sablier noir" src="http://jormund.free.fr/sablier3.gif"/>';
								if(ufGetPref("unifoxShowProdTimeLikeOgame",false))
								{
								if(k==nb)
									{
									line=box.parentNode.nextSibling;
									line.getElementsByTagName("td")[1].innerHTML+=symbole1;
									}
								else if(k==3)
									{
									line=box.parentNode.nextSibling;
									line.getElementsByTagName("td")[1].innerHTML+=symbole1;
									}
								}
								else {
									var reg=new RegExp("("+sub1+"</font></b>)","");
									//if(k==nb)box.innerHTML=box.innerHTML.replace(reg,'$1<a title="'+st2+'" style="color:yellow; font:Courrier New, Arial;">'+symbole1+'</a>');
									//else box.innerHTML=box.innerHTML.replace(reg,'$1<a title="'+st2+'" style="color:#ffffaa; font:Courrier New, Arial;">'+symbole2+'</a>');				
									if(k==nb)box.innerHTML=box.innerHTML.replace(reg,'$1'+symbole1+'');
									else box.innerHTML=box.innerHTML.replace(reg,'$1'+symbole2+'');	
									}
								}	
							
						
						
						}
					}
				}			
			}
			
		}
	}
	//alert('ok');
} catch (e) {
        unifoxdebug(e,"prodTime",doc);
}

}


//*****************************************************************************************
function uf_allyColor(doc) {
try {
if (!((doc && uf_isGalaxyUrl(doc.location.href)) || (doc && uf_isStatUrl(doc.location.href))) ) return;
if (!ufGetPref("unifoxAllyColors",true)) return;
ufLog("Ally Color");

//******//******//******//******
//******on charge la liste//******
//******//******//******//******
var i=0;
var reg;
var saved=ufGetPref("unifoxAllyColorsList","");
if(saved=="")return;

var colors=new Array();//couleurs appliquees sur le nom
var backs=new Array();//couleurs appliquees sur le fond
var allies=new Array();//noms des l'alliances
/*var st="-[te[s]t]";
alert(st.match(/-\[te\[s\]t\]/));
st.uf_escapeRegExpChars();*/
var tab=saved.split(uf_separator1);
for(k=0;k<tab.length;k++)
	{
	tab2=tab[k].split(uf_separator2);
	//alert(tab2.length);
	allies[k]=tab2[0].uf_escapeRegExpChars();
	//allies[k]=allies[k].uf_escapeRegExpChars();
	colors[k]=tab2[1];
	backs[k]=tab2[2];
	}
	//alert(allies[k-1]);
if(allies.length>0)//si on a une liste
	{

	if(uf_isGalaxyUrl(doc.location.href))//on colorie la galaxie
		{
		//alert('ok');
		var tables=doc.getElementsByTagName("table");
		var x=0;
		for(i=0;i<tables.length;i++)
		{
		if(tables[i].innerHTML.match(/me solaire [0-9]{1,2}:[0-9]{1,3}/)){x=i;}
		}
		var table=tables[x];
		var lines=table.getElementsByTagName("tr");
		for(i=2;i<17;i++)
			{
			boxes=lines[i].getElementsByTagName("th");
			//alert(lines[i].innerHTML+" ");
			for(j=0;j<allies.length;j++)
				{
				reg=new RegExp("> "+allies[j]+"<","");
				/*if(i==6 && j==0)
					alert(boxes[4].innerHTML);*/
				if(boxes[4].innerHTML.match(reg))//recherche sur le nom d'alliance
					{
					//alliance
					link=boxes[4].getElementsByTagName("a")[0];
					link.style.color=colors[j];
					boxes[4].style.backgroundColor=backs[j];
					//pseudo
					link=boxes[3].getElementsByTagName("a")[0];
					link.style.color=colors[j];
					boxes[3].style.backgroundColor=backs[j];
					//planète
					link=boxes[1].getElementsByTagName("a")[0];
					link.style.color=colors[j];
					boxes[1].style.backgroundColor=backs[j];
					}
					
				reg=new RegExp(">"+allies[j]+"<","");
				if(boxes[3].innerHTML.match(reg))//recherche sur nom de joueur
					{
					//alliance
					//alert("ligne:"+i+"\nnom"+allies[j]+"\n"+boxes[3].innerHTML);
					link=null;				
					link=boxes[4].getElementsByTagName("a")[0];
					if(link)
					{
					link.style.color=colors[j];
					boxes[4].style.backgroundColor=backs[j];
					}
					//pseudo
					link=boxes[3].getElementsByTagName("a")[0];
					link.style.color=colors[j];
					boxes[3].style.backgroundColor=backs[j];
					//planète
					link=boxes[1].getElementsByTagName("a")[0];
					link.style.color=colors[j];
					boxes[1].style.backgroundColor=backs[j];
					}
				else {
						reg=new RegExp(">"+allies[j]+" [(]","");//pour les inactifs
						if(boxes[3].innerHTML.match(reg))
							{//alliance
							link=boxes[4].getElementsByTagName("a")[0];
							if(link)//si le joueur a une alliance
							{
								link.style.color=colors[j];
							boxes[4].style.backgroundColor=backs[j];
							}
							//pseudo
							link=boxes[3].getElementsByTagName("a")[0];
							link.style.color=colors[j];
							boxes[3].style.backgroundColor=backs[j];
							//planète
							link=boxes[1].getElementsByTagName("a")[0];
							link.style.color=colors[j];
							boxes[1].style.backgroundColor=backs[j];
							}
						}
				}
			}
		}
	else if(uf_isStatUrl(doc.location.href))//ou le classement
		{
		path = '//select[@name="who"]';
		obj = ufEval(path,doc);
		if(obj)var who=obj.snapshotItem(0).options[obj.snapshotItem(0).selectedIndex].value;//joueurs ou alliance
		var tables=doc.getElementsByTagName("table");
		var x=0;
		for(i=0;i<tables.length;i++)
		{
		if(tables[i].innerHTML.match(/Place/)){x=i;}
		}
		var table=tables[x];
		var lines=table.getElementsByTagName("tr");
		for(i=1;i<lines.length;i++)
			{
			boxes=lines[i].getElementsByTagName("th");
			for(j=0;j<allies.length;j++)
				{
				reg=new RegExp(">"+allies[j]+"<","");
			
				if(boxes[3].innerHTML.match(reg))
					{
					boxes[3].getElementsByTagName("a")[0].style.color=colors[j];//coloration du lien plutot que de la case pour éviter écrasement par le css de la page
					boxes[3].style.backgroundColor=backs[j];
					boxes[1].style.color=colors[j];
					boxes[1].style.backgroundColor=backs[j];
					}
				else 
					{
					reg=new RegExp(">"+allies[j]+"<","");
					if(boxes[2].innerHTML.match(reg))
						{//alert(boxes[2]);
						boxes[1].style.color=colors[j];
						boxes[1].style.backgroundColor=backs[j];
						//boxes[1].innerHTML=boxes[1].innerHTML.replace(/(.*)/gi,"<font color="+colors[j]+">$1</font>");
						}
					}
				if(who=="player")//on ne verifie les joueurs que sur la page des joueurs
					{
				//si le nom était celui d'un joueur, ça marche aussi :)	
					reg=new RegExp("^"+allies[j]+"$","");
					if(boxes[1].innerHTML.match(reg))
						{
						boxes[3].style.color=colors[j];
						boxes[3].style.backgroundColor=backs[j];
						boxes[1].style.color=colors[j];
						boxes[1].style.backgroundColor=backs[j];
						}
					else 
						{
						reg=new RegExp(">"+allies[j]+"<","");
						if(boxes[1].innerHTML.match(reg))
							{
							boxes[1].style.color=colors[j];
							boxes[1].style.backgroundColor=backs[j];
							}
						}
					}
				}
			}
		}
	}
} catch (e) {
        unifoxdebug(e,"allyColor",doc);
}

}

//*****************************************************************************************
function uf_adjustOverviewHour(document)
{
try{
/*var obj = ufEval( '//div[@class="exploitTime"]', document);
for ( var i = 0; i < obj.snapshotLength; i++) {//pour chaque bouton retour
		var div=obj.snapshotItem(i);
		//on récupère l'heure de fin
		var end=parseInt(div.getAttribute('end'));
		var date=new Date();
		date.setTime(end-date.getTime());
		
		div.innerHTML=formatDate(date,"j HH:mm:ss");
		}
	
	setTimeout(function(){uf_adjustOverviewHour(document)},1000);
//setTimeout("uf_fleetReturnTime2(document)",500);*/
}catch (e) {
		unifoxdebug(e,"adjust overview times",document);
	}
}	

/////////////////////
////Tochaga's code////
/////////////////////
// ==UserScript==
// @name           e-univerS modif v2
// @description    Modification de l'interface sous www.e-univerS.org
// @include        http://www.e-univers.org/univers-beta*
// @include	http://91.121.22.90/univers-beta*/index.php*
// @include	http://beta*.e-univers.org/*

// ==/UserScript==
//{3366e7f2-0902-49e3-b6a6-286bfe845102}

// version 1.5.20070927.1

var marge_pt = 0; 
var marge_gt = 0;

// Fonction prototype pour suprimer les espaces dans une string.
String.prototype.uf_stripSpaces = function( ){ return this.replace( /\s/g, "" ); };


function uf_AddEspace(Sentence){
	var SentenceModified = '';
	var Rest = '';
	while (Sentence >= 1000 || Sentence <= -1000) {
		Rest = Sentence - Math.floor(Sentence/1000)*1000;
		if (Rest<10) 
			Rest='00'+Rest;
		else if (Rest<100) 
			Rest='0'+Rest;
		Sentence = Math.floor(Sentence/1000);
		SentenceModified = ' '+Rest+SentenceModified;
	}
	return (Sentence+SentenceModified);
}




/*
	retourne une liste des nodes correspondantes
	fonctions applicables sur la sortie :
		snapshotLength : retourne le nombre d'?l?ments
		snapshotItem(i): retourne l'?l?ment i
*/
function uf_getByAt(parent, balise, attribut, valeur,doc) {
	if (valeur!="") {
		return doc.evaluate(
			"//"+balise+"[@"+attribut+"=\""+valeur+"\"]",
			parent,
		    null,
		    XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,
		    null);
	}else{
		return doc.evaluate(
		    "//"+balise+"[@"+attribut+"]",
		    parent,
		    null,
		    XPathResult.ORDERED_NODE_SNAPSHOT_TYPE,
		    null);
	}
}

/*
	fonction pour d?terminer le max d'un type de construction
*/
function uf_getMin(dispo, demande) {
	var min = -1;
	for (var i=0; i<dispo.length; i++) {
		//ufLog('i:'+i+' min:'+min+' dispo:'+dispo[i]+' demande:'+demande[i]+' quantité:'+Math.floor(dispo[i]/demande[i]));
		if (min == -1) {
			min = Math.floor(dispo[i]/demande[i]);
		}else if (demande[i] != 0) {
			min = Math.min(min,Math.floor(dispo[i]/demande[i]));
			/*if ( Math.floor(dispo[i]/demande[i]) < min) {
				min = Math.floor(dispo[i]/demande[i]);
			}*/
			
		}
		//ufLog('i:'+i+' newmin:'+min);
	}
	return min;
}

/*
	renvoie un tableau ? 3 ?l?ments avec les couts demand?s dans le parent de type <tbody>
		parent d?signe le tbody du cadre associ? ? la construction
*/
function uf_getCout(tbody) {
	
	var tdcout = tbody.getElementsByTagName("tr")[2].getElementsByTagName("td")[0];
	var chaine = tdcout.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"");
	var res = [0, 0, 0, 0];
	var reg;
	var linkreg = /<a[^>]*>(.*)<\/a>.*/ig;
	reg = /.*Titane\s*: <b><font class=.?prix[^>]*>(.*)<\/font>.*/ig;
	if (reg.test(chaine)) {
		res[0] = chaine.replace(reg, "$1");
		if(linkreg.test(res[0]))
			res[0] = res[0].replace(linkreg,"$1");
		res[0] = parseInt(res[0].uf_stripSpaces());
	}
	
	reg = /.*Carbone\s*: <b><font class=.?prix[^>]*>(.*)<\/font>.*/ig;
	if (reg.test(chaine)) {
		res[1] = chaine.replace(reg, "$1");
		if(linkreg.test(res[1]))
			res[1] = res[1].replace(linkreg,"$1");
		res[1] = parseInt(res[1].uf_stripSpaces());
	}
	
	reg = /.*Tritium\s*: <b><font class=.?prix[^>]*>(.*)<\/font>.*/ig;
	if (reg.test(chaine)) {
		res[2] = chaine.replace(reg, "$1");
		if(linkreg.test(res[2]))
			res[2] = res[2].replace(linkreg,"$1");
		res[2] = parseInt(res[2].uf_stripSpaces());
	}
	
	reg = /.*Energie\s*: <b><font class=.?prix[^>]*>(.*)<\/font>.*/ig;
	if (reg.test(chaine)) {
		res[3] = chaine.replace(reg, "$1");
		if(linkreg.test(res[3]))
			res[3] = res[3].replace(linkreg,"$1");
		res[3] = parseInt(res[3].uf_stripSpaces());
	}
	//ufLog(res[0]+' '+res[1]+' '+res[2]+' '+tdcout.innerHTML);
	return res;
}

/*
	ajoute le lien Max: XXX qui modifie la valeur de l'input de la ligne <tbody> pass? en param?tre parent
		parent d?signe le tbody du cadre associ? ? la construction
*/
function uf_addBtMax(tbody,doc) {
	var tdcommande = tbody.getElementsByTagName("tr")[3].getElementsByTagName("td")[0];
	
	var input = tdcommande.getElementsByTagName("input")[0];
	if (input != null) {
		var max = uf_getMin(getTCTE(doc), uf_getCout(tbody));
		tdcommande.innerHTML+="<a onclick='document.getElementsByName(\""+input.name+"\")[0].value=\""+max+"\";return false;'>Max: "+uf_addFormat(max)+"</a>";
	}
}

/*
	colorise les couts selon s'il y a assez de ressource en r?serve
		parent : node de type <tbody> 
		ex:/html/body/table/tbody/tr[2]/td/form/table[2]/tbody/tr/td/table/tbody
*/
function uf_coloriseCout(tbody,doc) {
	var tdcout = tbody.getElementsByTagName("tr")[2].getElementsByTagName("td")[0];
	var chaine = tdcout.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	var res = [0, 0, 0, 0];
	var dispo = getTCTE(doc);
	var reg;
	
	reg = /(.*Titane\s*: <b><font class=")prix(">)([\d\s]+)(<\/font>.*)/ig;
	if (reg.test(chaine)) {
		res[0] = parseInt(chaine.replace(reg, "$3").uf_stripSpaces());
		if (res[0]<=dispo[0]) {
			chaine = chaine.replace(reg,"$1prix_good$2$3$4");
		}else{
			chaine = chaine.replace(reg,"$1prix_bad$2<a class='prix_bad' title='Manque: "+uf_addFormat(res[0]-dispo[0])+"'>$3</a>$4");
		}
	}
	
	reg = /(.*Carbone\s*: <b><font class=")prix(">)([\d\s]*)(<\/font>.*)/ig;
	if (reg.test(chaine)) {
		res[1] = parseInt(chaine.replace(reg, "$3").uf_stripSpaces());
		if (res[1]<=dispo[1]) {
			chaine = chaine.replace(reg,"$1prix_good$2$3$4");
		}else{
			chaine = chaine.replace(reg,"$1prix_bad$2<a class='prix_bad' title='Manque: "+uf_addFormat(res[1]-dispo[1])+"'>$3</a>$4");
		}
	}
	
	reg = /(.*Tritium\s*: <b><font class=")prix(">)([\d\s]+)(<\/font>.*)/ig;
	if (reg.test(chaine)) {
		res[2] = parseInt(chaine.replace(reg, "$3").uf_stripSpaces());
		if (res[2]<=dispo[2]) {
			chaine = chaine.replace(reg,"$1prix_good$2$3$4");
		}else{
			chaine = chaine.replace(reg,"$1prix_bad$2<a class='prix_bad' title='Manque: "+uf_addFormat(res[2]-dispo[2])+"'>$3</a>$4");
		}
		
	}
	
	reg = /(.*Energie\s*: <b><font class=")prix(">)([\d\s]+)(<\/font>.*)/ig;
	if (reg.test(chaine)) {
		res[3] = parseInt(chaine.replace(reg, "$3").uf_stripSpaces());
		if (res[3]<=dispo[3]) {
			chaine = chaine.replace(reg,"$1prix_good$2$3$4");
		}else{
			chaine = chaine.replace(reg,"$1prix_bad$2<a class='prix_bad' title='Manque: "+uf_addFormat(res[3]-dispo[3])+"'>$3</a>$4");
		}
		
	}
	tdcout.innerHTML = chaine;
}

/*
	Changement de la pr?sentation des batiments
*/
function uf_init_interface2(table1,doc) {
	var tdparent = table1.parentNode.parentNode;
	var table = doc.createElement("table");
	table.setAttribute("width", "600");
	table.setAttribute("align", "center");
	table.setAttribute("cellpaddin", "2");
	table.setAttribute("id", "interface2");
	table1.parentNode.setAttribute("id", "interface");
	tdparent.appendChild(table);
}

function uf_changeInterface2(tbody,doc) {
	//alert('ok');
	var table = doc.getElementById("interface2");//[0].getElementsByTagName("tbody")[0];
	var tdtitre = tbody.getElementsByTagName("tr")[0].getElementsByTagName("td")[0];
	var tdimg = tbody.getElementsByTagName("tr")[1].getElementsByTagName("td")[0];
	var tddesc = tbody.getElementsByTagName("tr")[1].getElementsByTagName("td")[1];
	var tdcout = tbody.getElementsByTagName("tr")[2].getElementsByTagName("td")[0];
	var tdordre = tbody.getElementsByTagName("tr")[3].getElementsByTagName("td")[0];
	var tdtemps = tbody.getElementsByTagName("tr")[3].getElementsByTagName("td")[1];
	var titre = tdtitre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	var desc = tddesc.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		
	if (ufGetPref("unifoxResizeImg",true)) {
		var img = tdimg.getElementsByTagName("img")[0];
		var imgsize=ufGetPref("unifoxImgSize",30);
			img.setAttribute("width",imgsize);
			img.setAttribute("height",imgsize);
	}
		
	if (ufGetPref("unifoxDescriptionTooltips",true)) {
		var id = "";
	
		var reg = /(.*)id=([\d]+)(">)(.*)(<\/a>.*)/ig;
		if (reg.test(titre)) {
			id = parseInt(titre.replace(reg,"$2"));
			titre = titre.replace(reg,"$4");
			var a = tdimg.getElementsByTagName("a")[0];
			a.setAttribute("onmouseover", 'return overlib(\'<table width=100%><tr><td class=c>'+titre.replace(/\'/g, '\\\'')+'</td></tr><tr><td class=l>'+desc.replace(/\'/g, '\\\'')+'</td></tr></table>\', HAUTO, VAUTO, FGBACKGROUND, \'http://univers.magicbook.info/spacer.gif\', FGCOLOR, \'\', BORDER, \'0\');');
			a.setAttribute("onmouseout", 'return nd();');
		}
		
	}
	
	tdtitre = tdtitre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	tdimg = tdimg.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	tdordre2 = tdordre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	
	if (ufGetPref("unifoxMaxButton",true)) {
		var input = tdordre.getElementsByTagName("input")[0];
		if (input != null) {
			var inputparent = input.parentNode;	
			var reg = /(.*)id=(107|108)">(.*)<\/a> \((\d*)\)(.*)/ig;
			if (reg.test(tdtitre)) {//cas particulier des boucliers
				var nb = parseInt(tdtitre.replace(reg,"$4"));
				if (nb == 1) {
					tdordre2 = "";
				} else {
					tdordre.innerHTML = inputparent.innerHTML+" <a onclick='document.getElementsByName(\""+input.name+"\")[0].value=\"1\";return false;'>Max: 1</a>";
					tdordre2 = tdordre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
				}
			} else {
				var max = uf_getMin(getTCTE(doc), uf_getCout(tbody));
				tdordre.innerHTML = inputparent.innerHTML+" <a onclick='document.getElementsByName(\""+input.name+"\")[0].value=\""+max+"\";return false;'>Max: "+uf_addFormat(max)+"</a>";
				tdordre2 = tdordre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
			}
		}
	}
		
	if (ufGetPref("unifoxColoriseRessources",true)) {
		uf_coloriseCout(tbody,doc);
	}
	
	// meilleur lisibilit? des chiffres
	var reg = /(.*)<\/a> \((\d*)\)(.*)/ig;
	if (reg.test(tdtitre)){
		//tdtitre = tdtitre.replace(reg, "$1<\/a> ("+uf_AddEspace(qty)+")$3";
		var qty = uf_addFormat(parseInt(tdtitre.replace(reg, "$2")));
		tdtitre = tdtitre.replace(reg, "$1</a> ("+qty+")$3");
	}
	
	tdcout = tdcout.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	tdtemps = tdtemps.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
	
	// Reduction de l'affichage du temps requis.
	reg = /(.*)Temps (n\u00E9cessaire):(.*)/ig;
	if (reg.test(tdtemps)) {
		tdtemps = "Temps : "+tdtemps.replace(reg, "$3");//alert(tdtemps);
	}
	
	var tr = "<tr><td class='l' width="+imgsize+">"+tdimg+"</td>"
		+"<td class='l' width='30%' nowrap>"+tdordre2+"</td>"
		+"<td class='l' align='center' nowrap>"+tdtitre+"</td>"
		+"<td class='l' nowrap>"+tdcout+"</td>"
		+"<td class='l' nowrap>"+tdtemps+"</td>"
		+"</tr>";
	
	table.innerHTML+=tr;
}

function uf_check_interface(table,doc) {
	
	if (table != null) {
		if (ufGetPref("unifoxRestructurateBody",true)) {
			ufLog("Restructurating Body");
			// Correction d'un bug de positionnement en hauteur de ligne lie au rowspan du menu.
			var trbug = uf_getNode("/html/body/table/tbody/tr",doc);
			trbug.setAttribute("height", "20");
			
			var tbodys = table.getElementsByTagName("tbody");
			if (tbodys.length != 0) {
				
				uf_init_interface2(table,doc);
			
				for (var cpt=0; cpt< tbodys.length; cpt++) {
					uf_changeInterface2(tbodys[cpt],doc);
				}
				var newTable = doc.getElementById("interface2");
				var oldTable = doc.getElementById("interface");
				var div = oldTable.parentNode;
				div.removeChild(oldTable);
				//div.replaceChild(newTable,oldTable );
				ufLog("newTable:"+newTable);
				ufLog("oldTable:"+oldTable);
				ufLog("table:"+table);
				ufLog("table.parentNode:"+table.parentNode);
				ufLog("oldTable.parentNode:"+oldTable.parentNode);
				//ufDump(table);
				//var parentTable = table.parentNode.parentNode;
				//ufLog(parentTable);
				//parentTable.replaceChild(newTable,oldTable );
			}
			ufLog("fin Restructurating Body");
		//table.innerHTML+="";
		} else {
			var tbodys = table.getElementsByTagName("tbody");
			for (var cpt=0; cpt< tbodys.length; cpt++) {
				if (ufGetPref("unifoxResizeImg",true)) {
					//On redimensionne les images
					var imgs = tbodys[cpt].getElementsByTagName("img");
					for (var cpt2 = 0; cpt2 < imgs.length; cpt2++) {
						
						var parent = imgs[cpt2].parentNode;
						var center = doc.createElement("center");
						var copy = imgs[cpt2];
						center.appendChild(copy);
						parent.appendChild(center);
						var imgsize=ufGetPref("unifoxImgSize",30);
						imgs[cpt2].setAttribute("height",imgsize);
						imgs[cpt2].setAttribute("weigth",imgsize);
						imgs[cpt2].setAttribute("style","align:middle;" + imgs[cpt2].getAttribute("style"));
					}
				}
				
				if (ufGetPref("unifoxColoriseRessources",true)) {
					//On colorie les couts
					uf_coloriseCout(tbodys[cpt],doc);
				}
				
				if (ufGetPref("unifoxMaxButton",true)) {
					//On ajoute le boutons "Max:XXX"
					uf_addBtMax(tbodys[cpt],doc);
				}
			}
		}
	}
}




/*
	Affichage des heures d'arriv?e des flottes sur la page d'accueil
*/
function uf_affiche_heure_accueil(table,document) {
//on récupère l'univers et sa vitesse
var universe=document.location.href.replace(/http:\/\/(.*)\.e-univers\.org.*$/,"$1");
var speed=uf_getUniverseSpeed(document);
//on charge le niveau d'exploitation
var exploitLvl=ufGetPref("unifoxExploitationLevel"+universe,2);
var impulsionLvl=ufGetPref("unifoxImpulsionLevel"+universe,7);



//on cacule le temps total d'exploitation
//var exploitTime=150000/(exploitLvl*speed);//formule jusqu'à la 2.25
var exploitTime=(32768/exploitLvl+16384)/speed;//formule depuis la 2.26

//et la vitesse d'un VE
var exploitSpeed=500*(1+impulsionLvl/10);
			
	//var tableroot = table.parentNode.setAttribute("width", "600");
	var divs = table.getElementsByTagName("div");
	//alert(divs.length);
	var exploits=new Array();//pour stocker les exploitations en cours
	//var nextExploits=new Array();
	var arrayTimerLength=divs.length;
	var divs2=new Array();
	for(var i=0;i<divs.length;i++)
		{
		divs2[i]=divs[i];
		}
	for (var cpt=0; cpt< divs2.length; cpt++) {
		var prev = divs[cpt].parentNode.parentNode.getElementsByTagName("th")[0];
		var prevhtml=prev.innerHTML;
		var divid = divs[cpt].getAttribute("id");
		if (divid != null && prev !=null)
		{
		//dates, pour les versions antérieures au 03/05/08
		if(divs[cpt].innerHTML != "-" && ufGetPref("unifoxAddOverviewTime",true)) {
		//alert(prev.innerHTML);
			var script = prev.getElementsByTagName("script")[0];
			//alert(script.innerHTML);
			script = script.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
			reg = /arrayTimer\[(.*)\] = ([0-9]+);/gi;
			var timer = parseInt(script.replace(reg, "$2"));
			var date = new Date;
			date.setTime(date.getTime()+timer*1000);
			divs[cpt].parentNode.innerHTML+="<font color=\""+ufTextColor+"\">"+uf_relativeDate(date)+"</font>";
			//alert(divs[cpt].parentNode.parentNode.getAttribute('height'));
			}
		if(prevhtml.match(/atteint.*exploiter/))//flotte en train d'aller exploiter
				{
				//on récupère l'heure d'arrivée sur la planète
			var script = prev.getElementsByTagName("script")[0];
			script = script.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
			reg = /arrayTimer\[(.*)\] = ([0-9-]+);/gi;
			var timer = parseInt(script.replace(reg, "$2"));
			var timernumber = parseInt(script.replace(reg, "$1"));
			
			//on en déduit l'heure de fin d'exploitation
			var date = new Date;
			date.setTime(date.getTime()+timer*1000+exploitTime*1000);
			//et on ne l'affiche pas
			
			if(timer<0)//flotte en train d'exploiter
				{//on met la durée et l'heure d'arrivée
				var script = prev.getElementsByTagName("script")[0];
				script = script.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
				reg = /arrayTimer\[(.*)\] = ([0-9-]+);/gi;
				var timer = parseInt(script.replace(reg, "$2"));
				var timernumber = parseInt(script.replace(reg, "$1"));
				
				//on en déduit l'heure de fin d'exploitation
				var date = new Date;
				date.setTime(date.getTime()+timer*1000+exploitTime*1000);
				//et on l'affiche
				divs[cpt].parentNode.innerHTML+="<font color=\""+ufTextColor+"\">"+uf_relativeDate(date)+"</font>";
				var end=timer*1+exploitTime*1;
				var script = document.createElement('script');
				script.innerHTML = "arrayTimer["+timernumber+"] = "+end+";";
				document.body.appendChild(script);
				}
			}
		if(prevhtml.match(/atteint.*exploiter/) &&  ufGetPref("unifoxVEReturnTime",true))//ajout des flottes de retour
			{
			//on crée l'heure de retour
			//extraction du départ (qui sera en fait l'arrivée)
			var str=prevhtml;
			var dep=str.substring(str.indexOf('['),str.indexOf(']')+1);//alert(dep);
			var depg=uf_parseInt(dep.substring(0,dep.indexOf(':')));
			dep=dep.substring(dep.indexOf(':')+1,dep.length);//alert(dep);
			var depss=uf_parseInt(dep.substring(0,dep.indexOf(':')));
			dep=dep.substring(dep.indexOf(':'),dep.length);//alert(dep);
			var depp=uf_parseInt(dep);
			//extraction de l'arrivée (qui sera en fait l'arrivée)
			str=str.substring(str.indexOf(']')+1,str.length);
			var arr=str.substring(str.indexOf('['),str.indexOf(']')+1);
			var arrg=uf_parseInt(arr.substring(0,arr.indexOf(':')));
			arr=arr.substring(arr.indexOf(':')+1,arr.length);
			var arrss=uf_parseInt(arr.substring(0,arr.indexOf(':')));
			arr=arr.substring(arr.indexOf(':'),arr.length);
			var arrp=uf_parseInt(arr);
			
			var distance=uf_distance(arrg,arrss,arrp,depg,depss,depp);
			var flyTime=uf_duree(speed,exploitSpeed,ufGetPref("ufVESpeed", 100)/10,distance);
			var description=prev.innerHTML.replace(/atteint Colonie/,'rentre de Colonie').replace(/Elle a pour/,'Elle avait pour').replace(/class="transport"/g,'class="return owntransport"');
			
			arrayTimerLength++;
			date.setTime(date.getTime()+flyTime);//on ajoute le temps de vol
			var arrival=timer*1+exploitTime*1+flyTime*1;
			//alert("before:"+description);
			description=description.replace(/arrayTimer\[.*\] = [0-9-]+/,"arrayTimer["+arrayTimerLength+"] = "+arrival);	
			//alert("after:"+description);
			uf_addOverviewFleet(table,divs,description,arrival,arrayTimerLength);
			
			if(timer<0)
				{
				/*
				
				var debug="";
													debug+="<br/>"+speed;
													debug+="<br/>"+impulsionLvl;
													debug+="<br/>"+exploitSpeed;
													debug+="<br/>["+arrg+":"+arrss+":"+arrp+"]["+depg+":"+depss+":"+depp+"]";
													debug+="<br/>"+distance;
													debug+="<br/>"+flyTime;
													debug+="<br/>"+arrival;
				description+="<br/>"+debug;*/
												/*	var debug="";
													debug+="<br/>"+speed;
													debug+="<br/>"+exploitLvl;
													debug+="<br/>"+exploitTime;
													debug+="<br/>"+timer;
													debug+="<br/>"+(timer*1+exploitTime*1);*/
				
				//on modifie le message d'exploitation
				prev.innerHTML=prevhtml.replace(/atteint/,"finit d'exploiter").replace(/Elle a pour mission:/,"Elle est en train d'");	
				}
			}
		}
	}
		
	table.innerHTML+="<tr></tr>";
	
	/*var table= table.parentNode.parentNode;
	if(table.innerHTML.match(/Activit\u00E9 Plan\u00E9taire/))
	{
	
	//alert(table2.innerHTML);
	table = table.getElementsByTagName("table");
	//alert(table2.length);
	var x;
	for(var i=0;i<table.length;i++)
	{
		if(table[i].innerHTML.match(/Activit\u00E9 Plan\u00E9taire/))
			{
			x=i;
			i=table.length;
			}
	}
	table = table[x];//table contenant les 3 temps, en bas, avant la liste des planètes
	if(false)//il y a déjà l'heure ajoutée par le jeu
		{
		}
	else {
		//alert(table2.innerHTML);
		var divs = table.getElementsByTagName("div");
		//alert(divs.length);
		for (var cpt=0; cpt< divs.length; cpt++) {
				//var string=divs[cpt].innerHTML;
				var date = uf_readDate(divs[cpt].innerHTML);
				var now = new Date;
				date.setTime(date.getTime()+now.getTime());
				divs[cpt].parentNode.innerHTML+="<font color=\"yellow\">"+uf_relativeDate(date)+"</font>";
				//alert(divs[cpt].parentNode.parentNode.getAttribute('height'));
			}
		table.innerHTML+="<tr></tr>";
		}
	}*/
	
}
/*
	 Affichage de l'heure de fin de construction pour les batiments et les recherche en labo
*/
function uf_affiche_heure_bat_et_labo(table,doc) {

var td = table.getElementsByTagName("td")[1];
//alert(td);
if(td)
	{
	//alert(td.innerHTML);
	var script = td.getElementsByTagName("script")[0];
	//alert(script.innerHTML);
	if(script)
		{
		if(script.innerHTML.match(/valTimer = new Array;/))
			{
			script = script.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
			
			//valTimer = new Array; valTimer['id'] = 3; valTimer['val'] = 2128;
			reg = /(.*)valTimer\['val'\] = (\d+);/ig ;
			var timer = parseInt(script.replace(reg, "$2"));
			var date = new Date;
			date.setTime(date.getTime()+timer*1000);
			td.innerHTML="<font color=\""+ufTextColor+"\">"+uf_relativeDate(date)+"</font>"+td.innerHTML;
			}
		}
	}
}
/*
	Affichage de l'heure d'arriv?e et de retour sur la page d'ordre des flottes.
*/
function uf_affiche_heure_flotte(table2,doc) {
var interval = ufGetPref("unifoxTimersInterval",1000);
//try {interval = uf_parseInt(PrefsBranchUF.getCharPref("unifoxTimersInterval"));interval=interval==0 ? 1000 : interval;}catch(e){var interval=1000;}
var center=table2.parentNode.parentNode;
		var script = doc.createElement("script");
		script.setAttribute("type", "text/javascript");
		//script.setAttribute("src", "http://univers.magicbook.info/js/flotte2.js");
		script.setAttribute("src", "chrome://unifox/content/resources/js/flotte2.js");
		center.appendChild(script);//parentNode.insertBefore(script, center);
		
		//création d'une input contenant le timestamp de l'heure d'impact
		var input = doc.createElement("input");
		input.setAttribute("name", "duree");
		input.setAttribute("value", "");
		input.setAttribute("type", "hidden");
		center.appendChild(input);//insertBefore(input, center.getElementsByTagName("table")[0]);
	

	if (table2 != null) {
		var th = table2.getElementsByTagName("tr")[2].getElementsByTagName("th")[1];
		th.setAttribute("style","text-align:right;");
								
		var tr6  = table2.getElementsByTagName("tr")[5];

		var tr2 = doc.createElement("tr");
		tr2.setAttribute("height", "20");
		var th2 = new Array(doc.createElement('th'), doc.createElement('th'));
		th2[0].innerHTML = "Heure d'arriv\u00E9e";
		th2[1].innerHTML = "<font color='"+ufTextColor+"'><div id=\"arrivee\">-</div></font>";

		for (var i=0; i<th2.length; i++)
			tr2.appendChild(th2[i]);

		table2.insertBefore(tr2,tr6);
		
		var tr = doc.createElement('tr');
		tr.setAttribute("height","20");
		var th = new Array(doc.createElement('th'), doc.createElement('th'));
		th[0].innerHTML = "Heure de retour";
		th[1].innerHTML = "<font color='"+ufTextColor+"'><div id=\"retour\">-</div></font>";
	
		for (var i=0; i<th.length; i++)
			tr.appendChild(th[i]);

		table2.insertBefore(tr,tr6);
	
	/*var evt = doc.createEvent("HTMLEvents");
	evt.initEvent("change", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
	doc.getElementsByName("galaxie_arr")[0].dispatchEvent(evt);*/
	//setTimeout('var evt = document.createEvent("HTMLEvents");evt.initEvent("change", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);document.getElementsByName("vitesse")[0].dispatchEvent(evt);',200);
	//setTimeout('alert("ok");',500);
	var script = doc.createElement("script");
	script.setAttribute("language", "javascript");
	script.innerHTML="Infov();dateArrivee("+interval+");";
	table2.appendChild(script);
	}
}
/*
	Ajout d'un lien sur chaque coordonn?e pointant vers la vue galaxie.
*/
function uf_add_galaxie_link(table,doc) {
	var tr = table.getElementsByTagName("tr");//alert(tr.length);
	for (var cpt=0; cpt< tr.length; cpt++) {
	//alert(tr[cpt].innerHTML);
		var th = tr[cpt].getElementsByTagName("th")[0];
		if (th != null) {
			var a = th.getElementsByTagName("a");
			for (var cpta=0; cpta< a.length; cpta++) {
				var aomover = a[cpta].getAttribute("onmouseover")
				if (aomover != null) {
					reg = /(.*)return escape\("(.*)"\)/gi;
					aomover = aomover.replace(reg, "return overlib(\"<table width=100%><tbody><tr><th  style=\\\"padding: 3px; text-align: left;\\\" bgcolor=\\\"#344566\\\"	align=\\\"left\\\">$2</th></tr></tbody></table>\", HAUTO, VAUTO, FGBACKGROUND, \"chrome://unifox/content/resources/pics/spacer.gif\", FGCOLOR, \"\", BORDER, \"0\");");
//class=\\\""+a[cpta].getAttribute("class")+"\\\"			
				a[cpta].setAttribute("onmouseover", aomover);
					a[cpta].setAttribute("onmouseout", 'return nd();');
					if(a[cpta].innerHTML.match(/flottes/ig))
					{
					//a[cpta].setAttribute("class", 'flotte');
					}
					else {
					//a[cpta].setAttribute("class", 'mission');
					}
				}
			}
			if(ufGetPref("unifoxAddGalaxyLinks",true))
			{
			var span=th.getElementsByTagName("span")[0];
			if(span)
			{
			var aclass = th.getElementsByTagName("span")[0].getAttribute("class");
			var msg = th.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
			reg = /\[(\d*):(\d*):(\d*)\]/gi;
			th.innerHTML = msg.replace(reg, "<a href=\"?action=galaxie&galaxiec=$1&systemec=$2\" class=\""+aclass+"\">[$1:$2:$3]</a>");
			}
			}
		}
	}
}
/*
	Modification pour une meilleur lisibilit? des chiffres
*/
function uf_init_flotte2(table,doc) {
	if (table != null) {
		var th = table.getElementsByTagName("tr")[6].getElementsByTagName("th")[1].getElementsByTagName("font")[0];
		var th2 = table.getElementsByTagName("tr")[7].getElementsByTagName("th")[1].getElementsByTagName("div")[0];
		th.innerHTML = uf_addFormat(th.innerHTML);
		th2.innerHTML = uf_addFormat(th2.innerHTML);
		//alert(th.innerHTML);
	}
}
/*
	Affichage du nombre de transport necessaire pour vider les ressources d'une plan?te dans la page flotte uniquement.
	Et ajotu d'un lien pour seletionner le bon nombre de GT.
*/

/*function uf_viderRessourcesListener(event)
{
//alert(event.which);
	if(event.which==36 || event.which==163 || event.which==164)//36<=>$  163=£ 164=¤
	{
	document=event.target.ownerDocument;
	alert(document.innerHTML);
		var maxGT = document.getElementsByName("maxvaisseau2")[0];
		if (!maxGT) {
			return;
			}
		var input = document.getElementsByName("nbGT")[0];
		if (!input) {
			return;
			}
			
		if (parseInt(maxGT.value) <= parseInt(input.value)) {
			document.getElementsByName("vaisseau2")[0].value = maxGT.value;
			} 
		else {
			document.getElementsByName("vaisseau2")[0].value = input.value;
		}
	}
}	*/

function affiche_PTGT(tr,table,doc) 
{

	if (tr==null || table==null) { return;}
	reg = /\d+/ig;
	var res1 = tr.getElementsByTagName("th")[1].innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ").uf_stripSpaces();
	var res2 = tr.getElementsByTagName("th")[3].innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ").uf_stripSpaces();
	var res3 = tr.getElementsByTagName("th")[5].innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ").uf_stripSpaces();
	res1 = parseInt(res1.match(reg));
	res2 = parseInt(res2.match(reg));
	res3 = parseInt(res3.match(reg));
	var totalres = res1 + res2 + res3;
	var nbPT = marge_pt + Math.ceil(totalres/5000);
	var nbGT = marge_gt + Math.ceil(totalres/50000);
	var totaltica = res1 + res2;
	var TiCA = marge_gt + Math.ceil(totaltica/50000);
	var Tita = marge_gt + Math.ceil(res1/50000);
	var Carb = marge_gt + Math.ceil(res2/50000);
	
	var th = doc.createElement("th");
	th.setAttribute("style","color:"+ufTextColor+"; text-align:right;");
	th.innerHTML = "Transport PT<br>Transport GT";
	var th2 = doc.createElement("th");
	th2.setAttribute("style","color:"+ufTextColor+"; text-align:right;");
	th2.innerHTML = uf_addFormat(nbPT)+"<br>"+uf_addFormat(nbGT);
	tr.appendChild(th);
	tr.appendChild(th2);
	
	//ajout du lien pour remplir automatiquement le bon nombre de GT pour vider les ressources.
	var script = doc.createElement("script");
	script.setAttribute("language", "javascript");
	script.innerHTML = '\nfunction uf_viderRessourcesListener(event){if(event.which==36 || event.which==163 || event.which==164){viderressources('+nbGT+')}} \ndocument.addEventListener("keypress",uf_viderRessourcesListener,true); \nfunction viderressources(nb) { 	\n\tvar maxGT = document.getElementsByName("maxvaisseau2")[0];\n\tif (!maxGT) {return;}\n\tif (maxGT.value <= nb) {\n\t\tdocument.getElementsByName("vaisseau2")[0].value = maxGT.value;\n\t} else {\n\t\tdocument.getElementsByName("vaisseau2")[0].value = nb;\n\t}\n}\n';
	table.appendChild(script);
	var tbody = table.getElementsByTagName("tbody")[0];
	var trs = tbody.getElementsByTagName("tr");
	var trsubmit = trs[trs.length-1];
	var nbGT2=Math.ceil(res3/50000);
	var tr2 = "<tr height='20'><th colspan='4'><a href=\"javascript:viderressources("+nbGT+");\">Vider les ressources</a>"+
					//"<input type='hidden' name='nbGT' value='"+nbGT+"'/>"+
					"</th></tr>";
	//<th colspan='2'><a href=\"javascript:viderressources("+nbGT2+");\">Vider le tritium</a></th></tr>";
	tbody.removeChild(trsubmit);
	tbody.innerHTML += tr2 + trsubmit.innerHTML;
	
	//doc.addEventListener('keydown', uf_viderRessourcesListener, true);
	
	//code de sitting débuggué 03/04/09
	
	if(ufGetPref('uf_Flotte_lien_pour_aider_vidage_ressources', false) )
	{
		//ajout du lien pour remplir automatiquement le bon nombre de GT pour vider le Titane ou le carbone ..
		var trs = tbody.getElementsByTagName("tr");
		var trsubmit = trs[trs.length-1];
		var tr3 = "<tr height='20'><th colspan='2'><a href=\"javascript:viderressources("+Tita+");\">Vider le Titane</a></th>"+
						"<th colspan='2'><a href=\"javascript:viderressources("+Carb+");\">Vider le Carbone</a></th></tr>";
		tbody.removeChild(trsubmit);
		tbody.innerHTML += tr3 + trsubmit.innerHTML;


		//ajout du lien pour remplir automatiquement le bon nombre de GT pour vider Titane+carbone ou le tritium..
		var tbody = table.getElementsByTagName("tbody")[0]
		var trs = tbody.getElementsByTagName("tr");
		var trsubmit = trs[trs.length-1];
		var tr4 = "<tr height='20'><th colspan='2'><a href=\"javascript:viderressources("+TiCA+");\">Vider Titane et Carbone</a></th>"+
					"<th colspan='2'><a href=\"javascript:viderressources("+nbGT2+");\">Vider le TriTri</a></th></tr>";
		tbody.removeChild(trsubmit);
		tbody.innerHTML += tr4 + trsubmit.innerHTML;
	}

	if(ufGetPref('uf_Flotte_lien_pour_aider_remplir_converto', false) )
	{
		//ajout du lien pour remplir convertisseur niveaux 11 a 16.
		var tbody = table.getElementsByTagName("tbody")[0]
		var trs = tbody.getElementsByTagName("tr");
		var trsubmit = trs[trs.length-1];
		var tr5 = "<tr height='20'><th colspan='4'></th></tr>"+
					"<tr height='20'><th colspan='2'><a href=\"javascript:viderressources("+2220+");\">Converto 110M</a></th>"+
					"<th colspan='2'><a href=\"javascript:viderressources("+2420+");\">Converto 120M</a></tr>"+
					"<tr height='20'><th colspan='2'><a href=\"javascript:viderressources("+2620+");\">Converto 130M</a></th>"+
					"<th colspan='2'><a href=\"javascript:viderressources("+2820+");\">Converto 140M</a></th></tr>"+
					"<tr height='20'><th colspan='2'><a href=\"javascript:viderressources("+3020+");\">Converto 150M</a></th>"+
					"<th colspan='2'><a href=\"javascript:viderressources("+3200+");\">Converto 160M</a></th></tr>";
		tbody.removeChild(trsubmit);
		tbody.innerHTML += tr5 + trsubmit.innerHTML;
	}
}

function uf_TochagaFunctions(doc) {
try{
	if(!doc)return;
	ufLog("debut uf_TochagaFunctions");
	
	//ajout des d?clarations de style perso
	var headnode = uf_getNode("/html/head",doc);
	var css = doc.createElement("style");
	css.setAttribute("type","text/css");
	css.innerHTML = ".prix_good {\ncolor:#00ff13;\n}\n.prix_bad {\ncolor:#ff0000;\n}\ntd.l {vertical-align:middle;\n}\n#interface2 {top:0;}\n";
	
	headnode.appendChild(css);
	
	//if (ufGetPref("unifoxDescriptionTooltips",true)) {
		var tooltip = doc.createElement("script");
		tooltip.setAttribute("type", "text/javascript");
		tooltip.innerHTML = "var ol_bgcolor = '';";
		headnode.appendChild(tooltip);
		
		var tooltip = doc.createElement("script");
		tooltip.setAttribute("type", "text/javascript");
		//tooltip.setAttribute("src", "http://univers.magicbook.info/js/overlib.js");
		tooltip.setAttribute("src", "chrome://unifox/content/resources/js/overlib.js");
		tooltip.innerHTML = "<!-- overLIB (c) Erik Bosrup -->";
		headnode.appendChild(tooltip);
	//}
	
	var table = null;
	if (uf_isShipyardUrl(doc.location.href)){
		//page defense ou plateforme
		table = uf_getNode("id('divpage')/form[2]/table/tbody",doc);//corps de page avec une construction en cours
		if(table==null)
			table = uf_getNode("id('divpage')/form/table/tbody",doc);//corps de page sans construction en cours
		if(table==null)unifoxdebug(e,"Tochaga's functions/shipyard",doc);
		uf_check_interface(table,doc);
		//if(ufGetPref("unifoxProdTime",false))uf_addSatsOnShipyard(doc);
	}else if (uf_isBuildingsUrl(doc.location.href) ){
	//uf_prodTime(doc);
		//page Batiments
		table = uf_getNode("id('divpage')/table[2]/tbody",doc);//corps de page
		if(!table)
			table = uf_getNode("/html/body/table/tbody/tr[2]/td/center/table[2]/tbody",doc);//v3
		ufLog("avant uf_check_interface:"+table);
		uf_check_interface(table,doc);
		ufLog("après uf_check_interface:"+table);
		//alert(doc.body.innerHTML);
		//inclus dans le jeu depuis le 02/05/08
		if(ufGetPref("unifoxBuildingsTime",true))
		{
		table = uf_getNode("id('divpage')/table[1]/tbody",doc);//tableau situé au dessus, lorsqu'un batiment est en construction
		if (table != null ) {
			ufLog("avant uf_affiche_heure_bat_et_labo:"+table);
			uf_affiche_heure_bat_et_labo(table,doc);
		}
		/*else {
		table = ufEval("id('divpage')/table[1]/tbody",doc);
		if(table)
			{table=table.snapshotItem(0);
			alert(table.innerHTML);}
			}*/
		ufLog("fin uf_isBuildingsUrl");
		//alert(doc.body.innerHTML);
		}
	}else if (uf_isResearchUrl(doc.location.href) ){
		//centre technique
		table = uf_getNode("id('divpage')/table[3]/tbody",doc);//corps de page
		if(table != null)//avec le super calculateur
			{
			uf_check_interface(table,doc);
			
			table = uf_getNode("id('divpage')/table[2]/tbody",doc);//tableau situé au dessus, lorsqu'une recherche est en construction
			if (table != null && ufGetPref("unifoxResearchTime",true)) {
				uf_affiche_heure_bat_et_labo(table,doc);
			}
			}

		else	{//sans le super calculateur
			table = uf_getNode("id('divpage')/table[2]/tbody",doc);//corps de page
			if(table != null)
			{
			uf_check_interface(table,doc);
			
			table = uf_getNode("id('divpage')/table[1]/tbody",doc);//tableau situé au dessus, lorsqu'une recherche est en construction
			if (table != null && ufGetPref("unifoxResearchTime",true)) {
				uf_affiche_heure_bat_et_labo(table,doc);
			}
			}
		}
		//uf_prodTime(doc);
	}else if (uf_isOverviewUrl(doc.location.href)){
																	//code pour tester les messages d'erreur
																		/*		try{alert(a4565RT);
																			}catch(e)
																			{
																			unifoxdebug(e,ufLang.GetStringFromName("functions.Tochaga"),doc);
																			}*/
	
		//page d'accueil.
		//alert('ok');		
		tables = ufEval("id('divpage')/center/table/tbody",doc);//tables du corps de page
		table=null;
		for(var i=0;i<tables.snapshotLength;i++)
		{
			table=tables.snapshotItem(i);
			if(table.innerHTML.match(/Ev\u00E8nements/))//table contenant les flottes en vol
			{
			//table=tables.snapshotItem(i);
			i=tables.length;
			}
		}
		//alert(table.innerHTML);
		if (table != null) {
				//alert(table.innerHTML);
				if(ufGetPref("unifoxVEReturnTime",true) || ufGetPref("unifoxAddOverviewTime",true)) {
					uf_affiche_heure_accueil(table,doc);
				}
				//if(ufGetPref("unifoxAddGalaxyLinks",true)) {
					uf_add_galaxie_link(table,doc);
				//}
			}
		
		
	}else if (uf_isFlota2Url(doc.location.href)){
		//page flotte2
		var table = uf_getNode("id('divpage')/center/table[1]/tbody",doc);//partie haute du corps de page, avec les coordonnées
		uf_init_flotte2(table,doc);
		if (ufGetPref("unifoxFleetTime",true) ) {
				//var center = uf_getNode("id('divpage')/center/table/tbody",doc);//corps de page
				var table = null;//uf_getNode("id('divpage')/center/table/tbody",doc);
				//ufLog("T1");
				if(!table)
				{
				table = uf_getNode("id('divpage')/center/form/table[1]/tbody",doc);
				//ufLog("T2");
				//center = uf_getNode("id('divpage')/center/form/table[1]/tbody",doc);//corps de page en testing le 10-05-08
				}
				/*if(!table)
				{
				table = uf_getNode("id('divpage')/center/table[2]/tbody",doc);
				ufLog("T3");
				//center = uf_getNode("id('divpage')/center/table[2]/tbody",doc);//corps de page 
				}*/
			uf_affiche_heure_flotte(table,doc);
		}
	}else if (uf_isFleetUrl(doc.location.href)){
		//page flotte
		
		if (ufGetPref("unifoxTransportsNeeded",true) ) {
			var tr = uf_getNode("id('diventete')/table[1]/tbody/tr",doc);//entete, avec les ressources
			var table = uf_getNode("id('divpage')/center/form/table",doc);//partie basse du corps, avec le bouton continuer
			affiche_PTGT(tr,table,doc);
		}
	}
  }
	catch(e)
	{
	unifoxdebug(e,"Tochaga's functions",doc);
	}
}
///////////////////////////
////End of Tochaga's code////
///////////////////////////
function uf_addSatsOnShipyard(doc,prod,having)
{
try{
/*var path = "id('divpage')";//corps de page
	var obj = uf_getNode(path,doc);*/
	var obj=doc.getElementById('divpage');
	var energienode = uf_getNode("id('diventete')/table[1]/tbody/tr/th[8]",doc);
	var st=energienode.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig,"");
	ufLog("st="+st);
	st=st.replace(/.*>([\d-]+)[^\d]* \/\ (\d+)[^\d]+/ig,'$1');
	ufLog("st="+st);
	var realEnergy = parseInt(st);	
	ufLog("realEnergy="+realEnergy);
	if(realEnergy<0)
	{
	var sats=Math.ceil((-1)*realEnergy*3600/prod[3]);
	//ufLog(prod[3]+" "+cost+" "+having[3]);
	//var symbole1=ufGetPref("unifoxProdTimeSymbol1","TIME!");
	if(!isNaN(sats))
		var st=sats+" satellites n\u00E9cessaires pour ramener l'\u00E9nergie \u00E0 z\u00E9ro";
	else var st="nombre satellites n\u00E9cessaires inconnu";
	var span=doc.createElement('span');
	span.innerHTML=st;//symbole1.replace("TIME!",st);
	obj.insertBefore(span,obj.firstChild);
	ufLog("st="+st);
	}
}catch(e)
{
unifoxdebug(e,"addSatsOnShipyard",doc);
}
}
//*****************************************************************************************
function uf_maxEMP(doc) {
try{
	if(!doc || !uf_isGalaxyUrl(doc.location.href))return;
	if (ufGetPref("unifoxMaxButton",true)) {
		var EMPNums = ufEval("id('divpage')/form[2]/table/tbody/tr/th[2]",doc);
		if(EMPNums.snapshotLength>0) {
			for(var i = 0; i<EMPNums.snapshotLength;i++) {
				var numCell = EMPNums.snapshotItem(i);
				var num = uf_parseInt(numCell.innerHTML);
				
				var row = numCell.parentNode;
				var cells = row.getElementsByTagName('th');
				var buttonCell = cells[cells.length-1];
				//ufLog(buttonCell+' '+buttonCell.innerHTMl);
				var button = doc.createElement('a');
				//button.setAttribute('type','button');
				button.setAttribute('id','maxEMP'+i);
				button.setAttribute('EMP',num);
				//button.setAttribute('value','max');
				button.innerHTML = "&nbsp;max&nbsp;";
				button.setAttribute('onclick','this.previousSibling.value='+num+';');
				//ufLog(i+':'+num);
				buttonCell.appendChild(button);
				//ufLog(i+':'+num);
			}
			var firstCellInRows = ufEval("id('divpage')/form[2]/table/tbody/tr/th[1]",doc);
			var last = firstCellInRows.snapshotItem(firstCellInRows.snapshotLength-1);
			var button = doc.createElement('a');
			button.setAttribute('id','maxAllEMP');
			button.setAttribute('onclick',''+
			'var i = 0;'+
			'var button = document.getElementById("maxEMP"+i);'+
			'do {'+
			'button.previousSibling.value=button.getAttribute("EMP");'+
			'i++;'+
			'button = document.getElementById("maxEMP"+i);'+
			'} while(button);'+		
			'');
			button.innerHTML = "&nbsp;max&nbsp;";
			last.appendChild(button);
		}
	}
}
catch(e)
{
unifoxdebug(e,"maxEMP",doc);
}
}
//*****************************************************************************************
function uf_converter(doc) {
try{
	if(!doc || !uf_isConverterUrl(doc.location.href))return;
if (ufGetPref("unifoxMaxButton",true))
	{
	var inp=doc.getElementsByName('r1')[0];
	if(inp)
		{
		var res = getTCTE(doc);
		var script = doc.createElement('script');
		script.innerHTML = 'function setToMax(){	'+
								'var res = ['+res[0]+','+res[1]+','+res[2]+'];'+
								'var current = document.getElementsByName("t1")[0].value - 1;'+
								'var c2 = document.getElementsByName("c2")[0].value;'+
								'var speed = document.getElementsByName("c3")[0].value;'+
								'var max =  c2*1000000*speed;'+
								'max = Math.min(res[current],max);'+
								'var inp=document.getElementsByName("r1")[0];'+
								'inp.value=max;'+
								'convertir();}';
		doc.body.appendChild(script);
		var td=inp.parentNode;//.parentNode.nextSibling.getElementsByTagName('th')[3];
		//alert(td.innerHTML);
		var button=doc.createElement('a');
		//button.setAttribute('type','button');
		button.setAttribute('id','maxConv');
		//button.setAttribute('value','max');
		button.innerHTML = "&nbsp;max&nbsp;";
		button.setAttribute('onclick','setToMax();');
		td.appendChild(button);
		}
		/*var script = doc.createElement("script");
		script.setAttribute("type", "text/javascript");
		script.setAttribute("src", "chrome://unifox/content/dateLibrary.js");
		doc.body.appendChild(script);*/
		
	//doc.addEventListener('click',setToMax,false);
	}
	//ajout de la date de fin de conversion
	var script = doc.createElement("script");
	script.setAttribute("type", "text/javascript");
	script.setAttribute("src", "chrome://unifox/content/resources/js/converter.js");
	doc.body.appendChild(script);
if(ufGetPref("unifoxConverter",true))
	{
	var inp=doc.getElementsByName('r1')[0];
	if(inp)
		{
		var quantity=ufGetPref("ufConverterQuantity",-1);
		var c2 = doc.getElementsByName("c2")[0].value;
		var speed = doc.getElementsByName("c3")[0].value;
		var max=c2*1000000*speed;
		if(quantity==-1 || quantity>max)//si quantité vaut -1, on met au max
			quantity=max
		inp.value=quantity;
		var res=ufGetPref("ufConverterFirstRes",0);
		var select=doc.getElementsByName("t1")[0];
		select.selectedIndex=res;
		res=ufGetPref("ufConverterSdRes",0);
		select=doc.getElementsByName("t2")[0];
		select.selectedIndex=res;
		var script = doc.createElement('script');
		script.innerHTML = 'convertir();';
		doc.body.appendChild(script);
		}
	}

}
catch(e)
{
unifoxdebug(e,"converter",doc);
}
}
//*****************************************************************************************
function uf_fightReportConverter(doc) {
	if(!uf_isFightReportUrl(doc.location.href) || !doc)return;
try{
if(ufGetPref("unifoxCRConverter",true)) {
	ufLog('startingconversion');
	var options = ufGetCRconvOptions();
	/*ufLog("eval"+eval(options));
	for(var i in options)
		ufLog(i+' '+options[i]);
	ufLog('optionsend');*/
	var uni = uf_getCurrentUniverseData(doc.location.href);
	options.universeSpeed = uni.speed;
	var crconv = new ufRCconv(options);
	var cr = doc.body.innerHTML;
	var cr = crconv.convert({text:cr});
	uf_addJavaScript(doc, "chrome://unifox/content/resources/js/CRconverter.js");
	var div = doc.createElement('div');
	div.innerHTML+='<div id="message" '+
	'style="border: 1px ridge white; padding: 5px; visibility: hidden; position: fixed; width: 600px;'+
	'	max-height: 400px; margin-top:20px; margin-bottom:100px;/*height: 320px;*/ top: 50px; left: 50px;'+
	'overflow: auto; background-color: rgb(17, 17, 17);">'+
	'<table width="100%">'+
	'	<tbody><tr>'+
	'		<td><b id="note0">Apercu</b></td>'+
	'		<td align="right"><a href="#titre" onclick="closeMessage()">Close</a></td>'+
	'	</tr>'+
	'	</tbody>'+
	'</table>'+
	'<div id="preview"> </div>'+
	'<table width="100%">'+
	'	<tbody><tr>'+
	'		<td><b id="note1">Apercu</b></td>'+
	'		<td align="right"><a href="#titre" onclick="closeMessage()">Close</a></td>'+
	'	</tr>'+
	'	</tbody>'+
	'</table>'+
	'</div>';
	doc.body.appendChild(div);
	
	var input = doc.createElement('input');
	input.setAttribute('type',"button");
	input.setAttribute('name',"preview");
	input.addEventListener('click',CRpreview,false);
	input.value = "Pr\u00E9visualiser";
	doc.body.appendChild(input);
	var textarea = doc.createElement('textarea');
	textarea.style.height = "500px";
	textarea.setAttribute('readonly',"readonly");
	textarea.setAttribute('id',"formatedReport");
	textarea.setAttribute('onclick',"this.focus(); this.select();");
	textarea.value = cr;
	doc.body.appendChild(textarea);
	
	if(ufGetPref("unifoxCRConverterAutocopy",true)){
		gClipboardHelper = Components.classes["@mozilla.org/widget/clipboardhelper;1"].getService(Components.interfaces.nsIClipboardHelper);  
	   gClipboardHelper.copyString(cr);
	}
}
}catch(e)
{
unifoxdebug(e,"addSatsOnShipyard",doc);
}
}
//*****************************************************************************************
function uf_rssReader(doc) {
try{
	if(!doc || !uf_isOverviewUrl(doc.location.href))return;
if (ufGetPref("unifoxRSS",true)) {

	var head = doc.getElementsByTagName('head')[0];
	var l = doc.createElement('link');
	l.href = "chrome://unifox/content/resources/css/overview.css";
	l.rel = 'stylesheet';
	l.type = 'text/css';
	head.appendChild(l);
	
	//var H = new RSSHandler(doc,"http://forum.e-univers.org/index.php?act=rssout&id=3");
	var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET","http://forum.e-univers.org/index.php?act=rssout&id=3", true);
	xmlReq.onload = uf_processRSS;
	xmlReq.doc = doc;
	xmlReq.defaultDisplay = true;
	xmlReq.id = 0;
	xmlReq.send(null);

	xmlReq2 = new XMLHttpRequest();
	xmlReq2.open("GET","http://travaux.e-univers.org/feed.php?project=0", true);
	xmlReq2.onload = uf_processRSS;
	xmlReq2.doc = doc;
	xmlReq2.defaultDisplay = false;
	xmlReq2.id = 1;
	xmlReq2.send(null);
}
}
catch(e)
{
unifoxdebug(e,"RSS",doc);
}
}
/*function RSSHandler(doc,url) {
	this.doc = doc;
	this.url = url;*/
function uf_processRSS(event) {
	try{
		//ufLog(this);
		//var doc = currentDoc;
		var doc = event.target.doc;
		//ufLog("RSS: doc.location.href"+doc.location.href);
		var xml = event.target.responseXML;
		//ufLog(xml.getElementsByTagName('channel').length);
		var items = xml.getElementsByTagName('item');
		//ufDump(items);
		var id = event.target.id;
		var display = ufGetPref("unifoxRSS-"+id,event.target.defaultDisplay);
		
		var channelTitle = xml.getElementsByTagName('title')[0].textContent;
		var rssTitle = doc.createElement('a');
		rssTitle.innerHTML = channelTitle;
		rssTitle.channelId = id;
		rssTitle.setAttribute('class','channelTitle');
		rssTitle.addEventListener('click',uf_toggleRSSTable,false);
		
		var rssTable = doc.createElement('table');
		rssTable.id = "rssTable"+id;
		if(display)rssTable.style.display = "block";
		else rssTable.style.display = "none";
		//rssTable.setAttribute('class','item');
		var st='';//<tr><th>Annonces</th></tr>';
		for(var i = 0; i < items.length ; i++) {
			var item = items[i];
			var title = item.getElementsByTagName('title')[0].textContent;
			var link = item.getElementsByTagName('link')[0].textContent;
			var date = item.getElementsByTagName('pubDate')[0].textContent;
			var descr = item.getElementsByTagName('description')[0].textContent;
			descr = descr.substr(0,200).replace(/"/g,"&quot;").replace(/'/g,'\\\'')+'...';
			
			date = new Date(date);
			var now = new Date();
			//date.getDate()+"/"+(date.getMonth()+1)+" "+date.getHours()+":"+date.getMinutes()
			st+= "<tr>";
			if(now.getTime() - date.getTime() < 1000*60*60*48) {
			//if(true) {
				st+="<td class='new'>";
				rssTitle.setAttribute('class',rssTitle.getAttribute('class')+' new');
			} else {
				st+="<td>";
			}
			dateText = uf_formatDate(date,"dd/MM/yy HH:mm")
			st+="<a class='itemTitle' href='"+link+"' onmouseover=\"return overlib(\'<div>"+descr+"</div>\');\" onmouseout='return nd();'>"+title+"</a>"+
			" <span class='itemDate'>("+dateText+")</span><td></tr>";
		}
		st+='';
		rssTable.innerHTML = st;
		var rssDiv = doc.getElementById('rss');
		if(!rssDiv) {
			var rssDiv = doc.createElement('div');
			rssDiv.setAttribute('id','rss');
			//rssDiv.innerHTML = st;
			//t.setAttribute('style','position:absolute; left:10px; top:10px; color:white;background-color:black;');
			var page = doc.getElementById('divpage');
			if(page)page.appendChild(rssDiv);
			
		}/* else {
		}*/
		rssDiv.appendChild(rssTitle);
		rssDiv.appendChild(doc.createElement('br'));
		rssDiv.appendChild(rssTable);
		rssDiv.appendChild(doc.createElement('br'));
		
		//doc.getElementById('divpage').innerHTML+='OK';
	}
	catch(e)
	{
	unifoxdebug(e,"process RSS",doc);
	}
}
	/*var xmlReq = new XMLHttpRequest();
	xmlReq.open("GET",this.url, true);
	xmlReq.onload = this.uf_processRSS;
	xmlReq.doc = doc;
	xmlReq.send(null);
}*/

function uf_toggleRSSTable(event) {
	var doc = event.target.ownerDocument;
	var id = event.target.channelId;
	var table = doc.getElementById("rssTable"+id);
	/*if(table.style.visibility == "hidden")
		table.style.visibility = "visible";
	else table.style.visibility = "hidden";*/
	if(table.style.display == "none") {
		table.style.display = "block";
		ufSetBooleanPref("unifoxRSS-"+id,true);
	}
	else {
		table.style.display = "none";
		ufSetBooleanPref("unifoxRSS-"+id,false);
	}
	
	
	//alert();
}

//ufLog('normal ok');
//////////////////////////////
unifox_load();///////////
/////////////////////////////
ufLog('fin du chargement\n');
//throw "unifox loaded fine";