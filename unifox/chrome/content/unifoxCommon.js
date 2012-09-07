//var ufConsoleService = Components.classes["@mozilla.org/consoleservice;1"].getService(Components.interfaces.nsIConsoleService);
var prefObjUF = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
var PrefsBranchUF = prefObjUF.getBranch("unifox.userprefs.");
//var ufGetPref("ufDebugMode", false); = false;
//var ufGetPref("ufDebugMode", false); = true;ufGetPref("ufDebugMode", false);
//pour ranger des tableaux dans une chaine de caractère
var uf_separator1 = ';';
var uf_separator2 = ',';

//noms du jeu
var uf_resList =new Array('Mati\u00E8res premi\u00E8res','Titane','Carbone','Tritium');
var uf_shipsList = new Array("Flotte","Navette PT-5" ,"Navette GT-50" ,"Chasseur" ,"Chasseur Lance" ,
"Fr\u00E9gate" ,"Destroyer" ,"Overlord" ,"Forteresse Noire" ,"Hyperion" ,
"Collecteur" ,	"Sonde" ,"Satellite solaire" ,"Colonisateur" ,"Vaisseau Extracteur" );
var uf_defsList = new Array("D\u00E9fense","BFG" ,"Smart BFG" ,"Plate-Forme Canon" ,"D\u00E9flecteurs" ,
"Plate-Forme Ionique" ,"Aereon Missile Defense" ,"Champ de force", "Holochamp","Contre Mesure Electromagn\u00E9tique",
"Missile EMP");
var uf_technosList = new Array("Recherche","Armement","Bouclier","Blindage");
var uf_shipsCapacity = new Array();
/*var uf_resList2 =new Array('Mati\u00E8res premi\u00E8res','Titane','Carbone','Tritium');
var uf_shipsList2 = new Array("Flotte","Navette PT-5" ,"Navette GT-50" ,"Chasseur" ,"Chasseur Lance" ,
"Fr\u00E9gate" ,"Destroyer" ,"Overlord" ,"Forteresse Noire" ,"Hyperion" ,
"Collecteur" ,	"Sonde" ,"Satellite solaire" ,"Colonisateur" ,"Vaisseau Extracteur" );
var uf_defsList2 = new Array("D\u00E9fense","BFG" ,"Smart&nbsp;BFG" ,"Plate-Forme Canon" ,"D\u00E9flecteurs" ,
"Plate-Forme Ionique" ,"Aereon Missile Defense" ,"Champ de force", "Holochamp","Contre Mesure Electromagn\u00E9tique",
"Missile EMP");
var uf_technosList2 = new Array("Recherche","Armement","Bouclier","Blindage");*/

var uf_days = new Array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
var uf_months = new Array('Jan', 'F\u00E9v', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Ao\u00FB', 'Sep', 'Oct', 'Nov', 'D\u00E9c');

var uf_colorsList =  new Array(
	'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 
	'beige', 'bisque', 'black', 'blanchedalmond', 'blue', 
	'blueviolet', 'brown', 'burlywood', 'cadetblue', 'chartreuse',
	'chocolate', 'coral', 'cornflowerblue', 'cornsilk', 'crimson', 
	'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod', 'darkgray',
	'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen', 
	'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen',
	'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 
	'deeppink', 'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 
	'floralwhite', 'forestgreen', 'fuchsia', 'gainsboro', 'ghostwhite', 
	'gold', 'goldenrod', 'gray', 'green', 'greenyellow',
	'honeydew',  'hotpink', 'indianred', 'indigo', 'ivory',
	'khaki', 'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon',
	'lightblue', 'lightcoral', 'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 
	'lightgrey', 'lightpink', 'lightsalmon', 'lightseagreen', 'lightskyblue', 
	'lightslategray', 'lightsteelblue', 'lightyellow', 'lime', 'limegreen', 
	'linen', 'magenta', 'maroon', 'mediumaquamarine', 'mediumblue', 
	'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue', 'mediumspringgreen',
	'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream', 'mistyrose', 
	'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 
	'olivedrab', 'orange', 'orangered', 'orchid', 'palegoldenrod', 
	'palegreen', 'paleturquoise', 'palevioletred', 'papayawhip', 'peachpuff', 
	'peru', 'pink', 'plum', 'powderblue', 'purple',
	'red', 'rosybrown', 'royalblue', 'saddlebrown', 'salmon',
	'sandybrown', 'seagreen', 'seashell', 'sienna', 'silver', 
	'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen',
	'steelblue', 'tan', 'teal', 'thistle', 'tomato',
	'turquoise', 'violet', 'wheat', 'white', 'whitesmoke', 
	'yellow', 'yellowgreen', 
	'transparent');
//dumpProperties_o(PrefsBranchUf);	
/*var ufUnitsXMLDoc=uf_getXML("ufUnits.xml");
var shipCapacityList=ufReturnArrayOfArraysFromXML(ufUnitsXMLDoc,"ship", new Array("name","capacity"), true)*/
function ufOptionsDebug(e)
{
if(ufGetPref("ufDebugMode", false))
{
try{
ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
}catch(e){alert(e);}
}
}
function ufLog(msg) {
 if(ufGetPref("ufDebugMode", false))
 {
	var ufConsoleService = Components.classes["@mozilla.org/consoleservice;1"].getService(Components.interfaces.nsIConsoleService);
  ufConsoleService.logStringMessage("UniFox says: \n"+msg);
  }
}
function ufGetBrowserLang()
{
	try {
var ufprefObj = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefService);
var ufPrefsBranch = ufprefObj.getBranch("general.useragent.");
    var ufBrowserLang = ufPrefsBranch.getCharPref("locale");
    } catch (e) {
        var ufBrowserLang="fr";
		  ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"")
    }
	 return ufBrowserLang;
}
//*****
var ufBrowserLang=ufGetBrowserLang();
ufLog("ufBrowserLang="+ufBrowserLang);
//*****
function ufGetLocaleChild(node)
{
//ufLog("ufBrowserLang="+ufBrowserLang);
if(node.hasChildNodes)
	{
	//var lang=ufGetBrowserLang();
	for(var i in node.childNodes)
		{
		//dumpProperties_o(node.childNodes[i]);
		
		if(typeof node.childNodes[i].tagName!="undefined")
		{
		//ufLog("node.childNodes["+i+"].tagName="+node.childNodes[i].tagName+" "+node.childNodes[i].textContent);
		//ufLog()
		if(node.childNodes[i].tagName.match(ufBrowserLang) || ufBrowserLang.match(node.childNodes[i].tagName))
			return node.childNodes[i].textContent;
			}
		}
		st="fr";
		for(var i in node.childNodes)//si on n'a pas la langue, on retourne le fr
			if(st.match(node.childNodes[i].tagName))
				return node.childNodes[i].textContent;
	}
return node.textContent;
}
/*function ufReturnArrayOfArraysFromXML(xmlDoc,parentNode, nodeNames, localised)
{
 var values = xmlDoc.getElementsByTagName(parentNode);
 var result = new Array();
    ufLog("uf_fillListFromXml :"+"values.length="+values.length);
    for (var i=0; i<values.length; i++) {
	 //dumpProperties_o(values[i].getElementsByTagName(labelNode)[0]);
	 var Atemp= ufReturnArrayFromXMLNode(values[i], nodeNames, localised);
	 if(Atemp.length>0)
	 if(Atemp[0].match(/^#[a-zA-Z]*#$/) || Atemp[1].match(/^#[a-zA-Z]*#$/))
		{
		ufLog("error : "+i+" Atemp="+Atemp[0]+" "+Atemp[1]);
		}//
	 else 
	 {
	 result.push(Atemp);
	 ufLog(parentNode+" - result["+(result.length-1)+"]="+result[result.length-1][0]);
	 }
	}
	return result;
}*/

/*function ufReturnArrayFromXMLNode(parentNode, nodeNames, localised)
{
var result=new Array();
for(var i in nodeNames)
	{
	try{
		var child=parentNode.getElementsByTagName(nodeNames[i]);
		if(typeof child!="undefined")
			{
			if(child.length>0)	
				{
				if(localised)
					result[i]=ufGetLocaleChild(child[0]);
				else
					result[i]=child[0].textContent;
				}
				else result[i]="#nodeNotFound#";
			}
		else result[i]="#undefined#";
		}
	catch(e)
		{
		result[i]="#error#";
		}
	}
return result;
}*/



// Fonction permettant de mettre sous forme de tableau un numero de version
function parseVersionString(str) 
{
	if (typeof(str) != 'string') 
	{ 
		return false; 
	}
	
	var x = str.split('.');
	
	// parse from string or default to 0 if can't parse
	var maj = parseInt(x[0]) || 0;
	var min = parseInt(x[1]) || 0;
	var pat = parseInt(x[2]) || 0;    
	var spat = parseInt(x[3]) || 0;

	return {
		major: maj,
		minor: min,
		patch: pat,
		spatch: spat
	}
}

/*
	Fonction permettant de savoir si la derniere version est installé ou non
	@return true => Dans ce cas la derniere version est installer
	@return false => Dans ce cas ce n'est pas la derniere version qui est installé
*/
function checkIfLastVersionInstalled(versionInstaller, derniereVersion)
{
	versionActuel = parseVersionString(versionInstaller);
	derniereVersion = parseVersionString(derniereVersion);
	
	if(versionActuel.major < derniereVersion.major) // On verifie le premier nombre
	{
		return false;
	}
	else
	{
		// Dans le cas ou le premier nombre est a jour
		if(versionActuel.minor < derniereVersion.minor) // On verifie le deuxieme nombre
		{
			return false;
		}
		else
		{
			// Dans le cas ou le deuxieme nombre est a jour
			if(versionActuel.patch < derniereVersion.patch) // On verifie le troisieme nombre
			{
				return false;
			}
			else
			{
				// Dans le cas ou le troisieme nombre est a jour
				if(versionActuel.spatch < derniereVersion.spatch) // On verifie le quatrieme nombre
				{
					return false;
				}
				else
				{
					// Dans le cas ou le quatrieme nombre est a jour, alors la version est a jour
					return true;
				}
			}
		}
	}
}





function ufEncrypt(str,mask)
{
var str2="";
var L=mask.length;
for(var i=0;i<str.length;i++)
	{
	var code=str.charCodeAt(i);
	code=code+(mask.charCodeAt(i%L)-40);
	str2+=String.fromCharCode(code);
	}
return str2;
}

function ufDecrypt(str,mask)
{
var str2="";
var L=mask.length;
for(var i=0;i<str.length;i++)
	{
	var code=str.charCodeAt(i);
	code=code-(mask.charCodeAt(i%L)-40);
	str2+=String.fromCharCode(code);
	}
return str2;
}

function ufSwitchUniFox(){
	if(ufGetPref("ufDisabled",true))ufSetBooleanPref("ufDisabled",false);
	else if(!ufGetPref("ufDisabled",false))ufSetBooleanPref("ufDisabled",true);
	ufLog("switched "+ufGetPref("ufDisabled",false));
}



function ufGetPref(key,defval)
{
var val=defval;
try{
switch(PrefsBranchUF.getPrefType(key))
	{
	case PrefsBranchUF.PREF_INT:
				val = PrefsBranchUF.getIntPref(key);
				break;
	case PrefsBranchUF.PREF_STRING:
				val = PrefsBranchUF.getCharPref(key);
				break;
	case PrefsBranchUF.PREF_BOOL:
				val = PrefsBranchUF.getBoolPref(key);
				break;
	default:val=defval;
	}
} catch (e) {
	  ufOptionsDebug(e);
	  val=defval;
	  }
	  return val;
}

/*function ufGetIntPref(key, defval)
{
	var val = PrefsBranchUF.getIntPref(key);
	 return val;
}
function ufGetCharPref(key, defval)
{
    var val = PrefsBranchUF.getCharPref(key);
    return val;     
}
function ufGetBooleanPref(key) { 
	var val = PrefsBranchUF.getBoolPref(key);
	return val;     
}
*/
function ufSetBooleanPref(key, val) {
    
   PrefsBranchUF.setBoolPref(key,val);    
}
function ufSetIntPref(key, val)
{
	PrefsBranchUF.setIntPref(key,val);
}

function ufSetCharPref(key, val)
{
	PrefsBranchUF.setCharPref(key,val);
}



function ufGetJSONPref(key, defval)
{
if(defval==null)defval = {};
try {
    var val = PrefsBranchUF.getCharPref(key);
	val = eval(val);
    return val;     
    } catch (e) {
        return defval;
    }
}

function ufSetJSONPref(key, val)
{
	var st = uneval(val);
	//alert(st);
	ufSetCharPref(key,st);
}

function ufGetColorPref(key, defval,canBeNull)
{
if(!uf_isColor(defval,canBeNull))
	defval="#000000";
try {
   var val = PrefsBranchUF.getCharPref(key);
	if(!uf_isColor(val,canBeNull))
		val=defval;
   return val;     
   } catch (e) {
      return defval;
   }
}

function configureUniFox() {
    window.openDialog("chrome://unifox/content/unifoxOptions.xul",
                      "", "centerscreen, chrome, resizable=yes");
} 

function unifoxdebug(e,func,doc) {
if(ufGetPref("ufDebugMode",true))
{
	var str=ufLang.GetStringFromName("errors.unifox")+"<br/>";
	str+=e.name+": "+e.message+/*"<br/>line "+e.lineNumber+*/"<br/><br/>;"
	if(e.stack != null)
		str+=e.stack.replace(/\n/g,"<br/>");
	if(func)str+="<br/>"+ufLang.GetStringFromName("errors.in")+" "+func;
	if(doc && doc.body) {
		var div=doc.createElement("div");
		div.innerHTML=str;
		div.setAttribute('style','position:absolute;top:120px;left:100px;color:#000000;background-color:#ffffff;border:1px solid red;');
		doc.body.appendChild(div);
	}
	else {
		try {
			ufLog(str);
		} catch(e) {
			alert(str);
		}
		/*var str="Erreur UniFox\n";
		str+=e.name+"\n"+e.message+"\nline "+e.lineNumber;
		if(func)str+="\nin "+func;
		alert(str);*/
	}
}
//alert(window.document.innerHTML);
/*var span=document.getElementById("datetime");
var th=span.parentNode.parentNode;
alert(str+th.innerHTML);*/
//var table=th.parentNode.parentNode;
}

function uf_parseInt(string) {
if(typeof(string)=="number") return string;
	/*string = string.replace(/^\s*0(.+)/, "$1");
	string = string.replace(/[\.\s,]/g,'');
	string = string.replace(/&nbsp;/g,'');*/
	string = string.replace(/\D/g,'');
	return string ? parseInt(string) : 0;
}
/*function uf_getDir()
{
try {
var file = Components.classes["@mozilla.org/file/directory_service;1"]
                     .getService(Components.interfaces.nsIProperties)
                     .get("ProfD", Components.interfaces.nsIFile);
file.append("UniFox");
if( !file.exists() || !file.isDirectory() ) {   // if it doesn't exist, create
   file.create(Components.interfaces.nsIFile.DIRECTORY_TYPE, 0777);
	}
	return file;
} 
   catch(e) {
            ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
				return null;
   }    
}*/

function uf_getConfigFileURI(fileName) {
  return Components.classes["@mozilla.org/network/io-service;1"]
                   .getService(Components.interfaces.nsIIOService)
                   .newFileURI(uf_getConfigFile(fileName));
}

function uf_getConfigFile(fileName) {
	var file = uf_getConfigDir(null);
	file.append(fileName);
	if (!file.exists()){
		file.create(0,0644);
		var doc = document.implementation.createDocument("", "Config", null);
		doc.firstChild.appendChild(doc.createTextNode("\r\n"))
		var configStream = uf_getWriteStream(file);
		new XMLSerializer().serializeToStream(doc, configStream, "utf-8");
		configStream.close();
  	}
  return file;
}
function uf_getConfigDir(subdir) {
    try {
    
        var dirLocator = Components.classes["@mozilla.org/file/directory_service;1"].getService(Components.interfaces.nsIProperties);
        var dir = dirLocator.get("ProfD", Components.interfaces.nsILocalFile);
        dir.appendRelativePath("UniFox");       
        if (!dir.exists() ) {        
            dir.create(dir.DIRECTORY_TYPE, 0755);
        }     
        if (subdir != null) {
            dir.appendRelativePath(subdir);
            if (!dir.exists() ) {        
                dir.create(dir.DIRECTORY_TYPE, 0755);
            }
        }
       return dir;   
   } 
   catch(e) {
	ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
            return null;
   }    
}
function uf_getWriteStream(file) {
  var stream = Components.classes["@mozilla.org/network/file-output-stream;1"]
    .createInstance(Components.interfaces.nsIFileOutputStream);

  stream.init(file, 0x02 | 0x08 | 0x20, 420, -1);

  return stream;
}
function uf_getContents(aURL, charset){
  if( !charset ) {
    charset = "UTF-8"
  }
  var ioService=Components.classes["@mozilla.org/network/io-service;1"]
    .getService(Components.interfaces.nsIIOService);
  var scriptableStream=Components
    .classes["@mozilla.org/scriptableinputstream;1"]
    .getService(Components.interfaces.nsIScriptableInputStream);
  
  var unicodeConverter = Components
    .classes["@mozilla.org/intl/scriptableunicodeconverter"]
    .createInstance(Components.interfaces.nsIScriptableUnicodeConverter);
  unicodeConverter.charset = charset;

  var channel=ioService.newChannelFromURI(aURL);
  var input=channel.open();
  scriptableStream.init(input);
  var str=scriptableStream.read(input.available());
  scriptableStream.close();
  input.close();

  try {
    return unicodeConverter.ConvertToUnicode(str);
  } catch( e ) {
    return str;
  }
}
function uf_getXML(filename)
{
try {
	var ufXml = document.implementation.createDocument("", "", null);
	
	//dumpProperties_o(ufUniversesXml);
	ufXml.async = false;
	var file = uf_getConfigDir(null);
	file.append(filename);
	if (!file.exists()){
		ufXml.load("chrome://unifox/content/"+filename+"", "text/xml");
	} else {
		//ufUniversesXml.load("file://"+file.path, "text/xml");
		var domParser = Components.classes["@mozilla.org/xmlextras/domparser;1"]
                              .createInstance(Components.interfaces.nsIDOMParser);

    	var configContents = uf_getContents(uf_getConfigFileURI(filename));
    	ufXml = domParser.parseFromString(configContents, "text/xml");
	}
	return ufXml;
} catch (e) {
	ufLog(e.name+": "+e.message+"|line "+e.lineNumber+"");
				return null;
}
}

function uf_isColor(color,canBeNull)
{
//ufLog(canBeNull+" "+(typeof canBeNull)+" "+(typeof canBeNull=="undefined")+" "+(color.length==0));
if(typeof canBeNull=="undefined")var canBeNull=false;
//ufLog("canBeNull="+canBeNull+" "+(color.length==0 && canBeNull));
var test=false;
if(color.match(/^#[0-9a-fA-F]{6}$/))test=true;
for(i=0;i<uf_colorsList.length;i++)
{
if(color.match(uf_colorsList[i]))test=true;
}
if(color.length==0 && canBeNull==true)test=true;
return test;
}

//alert('common ok');
function displayproperties_e(event)
{
var object=event.target;
        w=open("",'popup','width=400,height=400,toolbar=no,scrollbars=yes,resizable=yes');       
        w.document.write("<HTML><HEAD><TITLE>Propriétés de "+object+"</TITLE></HEAD>");
	w.document.write("<BODY><FONT face='arial' size=1>");
	if (object) {
		for (var i in object) {
			w.document.write("<B>"+i+"</B> = "+object[i]+"<BR>");
		}
        } else {
		w.document.write("L'objet <B>"+object+"</B> n'existe pas...<BR> Vérifiez votre saisie.");
	}
	w.document.write("</FONT></BODY></HTML>");
        w.document.close();
}
function ufDump(object) {
	if (typeof object!='undefined') {
		var st=object+' : '+typeof object;
		for (var i in object) {
			st+='\n'+i+' => '+object[i];
		}
		ufLog(st);
	}
	else ufLog("NULL");
}
function displayproperties_o(object)
{
        w=open("",'popup','width=400,height=400,toolbar=no,scrollbars=yes,resizable=yes');       
        w.document.write("<HTML><HEAD><TITLE>Propri\u00E9t\u00E9s de "+object+"</TITLE></HEAD>");
		
	w.document.write("<BODY><FONT face='arial' size=1>");
	if (object) {
		var lim=0;
		for (var i in object) {
		if(lim>=0 && lim<1)
			{lim++;
			w.document.write("<B>"+i+"</B> = "+object[i]+"<BR>");
			}
		}
		/*if(object.length && isarray)
		{alert('ok');
		var j=0;
		for(j=0;j<object.length;j++)
			{
			w.document.write("<B>content "+j+"</B> : <BR>");
			for (var i in object[j]) {
				w.document.write("<B>&nbsp;&nbsp;"+i+"</B> = "+object[j][i]+"<BR>");
				}
			//displayproperties_o(object[j]);
			}
		}*/
        } else {
		w.document.write("L'objet <B>"+object+"</B> n'existe pas...<BR> V\u00E9rifiez votre saisie.");
	}
	w.document.write("</FONT></BODY></HTML>");
        w.document.close();
}
//document.addEventListener("click",displayproperties,false);
function dumpProperties_o(object)
{ 
        var str=("Propri\u00E9t\u00E9s de "+object+" :");
		
	if (object) {
		var lim=0;
		for (var i in object) {
		if(lim>=0 && lim<100)
			{lim++;
			str+=("| "+i+" = "+object[i]+"");
			if(lim%4==0){ufLog(str);str="";}
			}
		}
		str+="|properties:"+lim;
		/*if(object.length && isarray)
		{alert('ok');
		var j=0;
		for(j=0;j<object.length;j++)
			{
			w.document.write("<B>content "+j+"</B> : <BR>");
			for (var i in object[j]) {
				w.document.write("<B>&nbsp;&nbsp;"+i+"</B> = "+object[j][i]+"<BR>");
				}
			//displayproperties_o(object[j]);
			}
		}*/
        } else {
		str+=("L'objet "+object+" n'existe pas... V\u00E9rifiez votre saisie.");
	}
	ufLog(str);
}

function uf_readDate(string)
{
var date=new Date(0);
var h=0;
var m=0;
var s=0;
var j=0;

var i=string.indexOf('j');
if(i>0)
{
j=uf_parseInt(string.substring(0,i));
string=string.substring(i,string.length);
}
i=string.indexOf('h');
if(i>0)
{
h=uf_parseInt(string.substring(0,i));
string=string.substring(i,string.length);
}
i=string.indexOf('m');
if(i>0)
{
m=uf_parseInt(string.substring(0,i));
string=string.substring(i,string.length);
}
i=string.indexOf('s');
if(i>0)
{
s=uf_parseInt(string.substring(0,i));
//string=string.substringing(i,string.length);
}
//s=uf_parseInt(string);

date.setTime((86400*j+3600*h+60*m+s)*1000)
/*date.setTime(0);
date.setDate(j);
date.setHours(h);
date.setMinutes(m);
date.setSeconds(s);*/
return date;
}

/////////////////////
////Tochaga's code////
/////////////////////
function uf_getNode(path,doc) {
	return doc.evaluate(
		path, 
		doc, 
		null, 
		XPathResult.FIRST_ORDERED_NODE_TYPE, 
		null).singleNodeValue;
}

/*
	Conversion de la date en format lisible et relatif ? la date du jour.
	Ne renvoi pas l'information de date et mois si identique ? celle du jour en cour.
*/
function uf_relativeDate(time) {
date = new Date;
date.setTime(time);

if(ufGetPref("unifoxUseServerTime",false))
{
	date_now = new Date;
	//var span =
	date_now.setTime(servTime);
}
else{
	
	
	date_now = new Date;
	date_now.setTime(date_now.getTime());
	}

	var hour = date.getHours();
	var min = date.getMinutes();
	var sec = date.getSeconds();
	var day_number = date.getDate();
	var day_number_now = date_now.getDate();
	var month = date.getMonth();
	var month_now = date_now.getMonth();
	var nextday = "";
	
	if (day_number_now != day_number || month_now != month) {
		nextday = uf_days[date.getDay()] + ' ' + day_number + ' ' + uf_months[date.getMonth()] + ' ';
	}
	if (sec < 10) sec = '0' + sec;
	if (min < 10) min = '0' + min;
	if (hour < 10) hour = '0' + hour;

	var datetime =  nextday + hour + ':' + min + ':' + sec;
	//alert(datetime);
	return datetime;
}
// Fonction prototype pour suprimer les espaces dans une string.
String.prototype.uf_stripSpaces = function( ){ return this.replace( /\s/g, "" ); };
///////////////////////////
////End of Tochaga's code////
///////////////////////////
//*****************************************************************************************
function uf_coordinates(xx,yy)
{
this.x=xx;
this.y=yy;
}
function uf_getOffsetPosition(obj, inTYPE)//found on http://www.asp-php.net/ressources/codes/JavaScript-Coordonnees+d'un+objet+par+offsetParent.aspx
{
 var iVal = 0;
 //var obj = doc.getElementById(inID);
 var sType = 'obj.offset' + inTYPE;
 while (obj && obj.tagName != 'BODY') {
  iVal += eval(sType);
  obj = obj.offsetParent;
 }
 return iVal;
}
function uf_getPosition(object)
{
var x=uf_getOffsetPosition(object,'Left');
var y=uf_getOffsetPosition(object,'Top');
 return new uf_coordinates(x,y);
 //return new Array(x,y);
}
//*****************************************************************************************
function ufEvalnode(path,document,node) {
	var ret = document.evaluate(path,node,null,
			XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);
	//if (ufGetPref("ufDebugMode", false);) ufLog(ret.snapshotLength);

	return ret;

}

//*****************************************************************************************
function ufEval(path,document) {
	return ufEvalnode(path,document,document);
}
//*****************************************************************************************
function uf_addJavaScript(doc, js) {
    
  var head = doc.getElementsByTagName("head")[0];    

  var script = doc.createElement("script");
  script.setAttribute("language", "JavaScript");
  script.setAttribute("src", js);
  head.appendChild(script);
  
  return script;
    
}

//*****************************************************************************************
function uf_appendBody(document,ele) {
	var body = document.getElementsByTagName("body")[0];    
	body.appendChild(ele);
}

//*****************************************************************************************
function uf_addFormat(str/*,separator*/) {
	var separator = ' ';
	if(arguments.length==2)separator=arguments[1];
	str += '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(str)) {
		str = str.replace(rgx, '$1' + separator + '$2');
	}
	return str;
}

//*****************************************************************************************
function uf_getDocument(element)//doesnt work
{
var p=element;
var p2=false;
while(p=p.parentNode)p2=p;
return p2;
}

//*****************************************************************************************
String.prototype.uf_escapeRegExpChars = function ()
{
var st=this;
st=st.replace(/\\/g,"\\\\");
st=st.replace(/\//g,"\\/");
st=st.replace(/\]/g,"\\]");
st=st.replace(/\|/g,"\\|");
//st=st.replace(/\\\]\]/g,"\\]]");
//alert("lvl1:\n"+st);
st=st.replace(/\[/g,"\\[");
st=st.replace(/\./g,"\\.");
st=st.replace(/\(/g,"\\(");
st=st.replace(/\)/g,"\\)");
st=st.replace(/\+/g,"\\+");
//alert("lvl2:\n"+st);
//alert(this.match(st));
return st;
}
//*****************************************************************************************
function uf_getGET (name,url)
{
if (url.indexOf("#")!=-1)//si il y a un # on le retire
url = url.substring(0,url.indexOf("#"));

url = "&"+url.substring(url.indexOf("?")+1, url.length)+"&";

var retour="";
name = "&"+ name + "=";
//alert(url+"\n"+name);
if (url.indexOf(name)!=-1)
{
 url = url.substring(url.indexOf(name)+name.length,url.length);//on prend ce qui est après le = recherché
 retour = url.substring(0,url.indexOf("&"));//et on s'arrete à la variable suivante
}
 return retour;
 }
//*****************************************************************************************
function uf_getUniverseName(href) 
{
var name="unknown universe";
if(href)
	{
	if(href.match(/.*http:\/\/(.*)\.e-univers\.org.*/))
		name=href.replace(/.*http:\/\/(.*)\.e-univers\.org.*/,"$1")
	//alert(speed);
	}
return name;
}

function uf_getUniverseSpeed(doc) 
{
if(!doc)return 0;
var speed=0;
var p=uf_getNode("id('divmenu')/table[1]/tbody/tr/th/p",doc);
if(p!=null)
{
	speed=uf_parseInt(p.innerHTML.match(/(Vitesse serveur : x.*<br)/)[0]);
}
else {
	p=uf_getNode("id('resumeServeur')/table/tbody/tr/th/p",doc);
	speed=uf_parseInt(p.innerHTML);
	}
//alert(speed);
return speed;
}

//*****************************************************************************************
//code de e-univers, flotte.js
//*****************************************************************************************
/**coordonnées de départ, coordonnées d'arrivée*/
function uf_distance(galaxie_dep,systeme_dep,planete_dep,galaxie_arr,systeme_arr,planete_arr) {
  var dist;
  dist = 0;
  if ((galaxie_arr - galaxie_dep) != 0) {
    dist = Math.abs(galaxie_arr - galaxie_dep) * 20000;
  } else if ((systeme_arr - systeme_dep) != 0) {
    dist = Math.abs(systeme_arr - systeme_dep) * 95 + 2700;
  } else if ((planete_arr - planete_dep) != 0) {
    dist = Math.abs(planete_arr - planete_dep) * 5 + 1000;
  } else {
    dist = 5;
  }

  return(dist);
}
//*****************************************************************************************
/**vitesse de l'uni, vitesse des vaisseaux, % de vitesse, distance*/
function uf_duree(coef_vit,mvit,vit,dist) {
  return Math.ceil(((35000 / vit * Math.sqrt(dist * 10 / mvit) + 10) / coef_vit));
}
//*****************************************************************************************
//fin code e-univers
//*****************************************************************************************

function uf_restartApp() {
ufLog('restartapp');
if(ufGetPref("ufDebugMode", false))
{
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
	else {ufLog('debug mode off, restart aborted');}
}

function uf_reloadChrome() // Ajouter par Max485 le Sam 20 Juin 2009
{
	ufLog('reloadChrome');
	
	if(ufGetPref("ufDebugMode", false))
	{
		try
		{
			// Cette fonction permet de pouvoir recharger uniquement le Chrome, ce qui evite un redemarrage de FireFox
			Components.classes["@mozilla.org/chrome/chrome-registry;1"].getService(Components.interfaces.nsIXULChromeRegistry).reloadChrome();
			// Fonction trouvé dans le code de FireSpy, merci a eux :)
		}
		catch(e)
		{
			ufLog(e.name+": "+e.message+"line "+e.lineNumber);
		}
	}
	else 
	{
		ufLog('debug mode off, reloadChrome aborted');
	}
}

function uf_OpenExtensionManager() // Ajouter par Max485 le Sam 20 Juin 2009
{
	// Permet d'ouvrir la fenetre "Module complementaire" avec un raccourci
	
	ufLog('OpenExtensionManager');
	
	if(ufGetPref("ufDebugMode", false))
	{
		try
		{
			// Fonction trouvé dans le code de FireSpy, que nous remercions
			window.openDialog("chrome://mozapps/content/extensions/extensions.xul?type=extensions", "ext", "chrome,dialog,centerscreen,resizable")
		}
		catch(e)
		{
			ufLog(e.name+": "+e.message+"line "+e.lineNumber);
		}
	}
	else 
	{
		ufLog('debug mode off, OpenExtensionManager aborted');
	}
}

/*----------------------------------------------------------------------------------------------------*/
/*-----------------------------------Convertisseur de RC---------------------------------------*/
/*----------------------------------------------------------------------------------------------------*/
var ufCRconvPref={
						//type: { prefname : defaultvalue 
						bools:{
							'showCoords':true,
							'showTechnos':true,
							'showLostUnits':true,
							'showTotalRenta':true,
							'showTotalGain':true,
							'showTotalCDR':true,
							'showEndLoss':true,
							//'showRentability':true,
							'showDetailledRentability':true,
							'showDetailledCDR':true,
							'showDetailledGain':true,
							'showAttackersName':true,
							'showDefendersName':true,
							'showFlyingTime':true,
							'showConsumption':true
						},
						texts:{
							'separator':' ',
							'startText' : '',//'DEBUT';
							'resultText' : '',//'RESULTS';
							'endText' : '',//'END';
							'afterBattleMessage':'apr\u00E8s la bataille...',
							'attackersAlly' : '',
							'defendersAlly' : ''
						},
						menulists:{
							'recyclingPlayer':-1
						},
						colors:{
							0:{label:'Nav.PT-5' ,color: '#ff9900'},//Nav.PT-5
							1:{label:'Nav.GT-50' ,color: '#00ff00'},//Nav.GT-50
							2:{label:'Chasseur' ,color: '#33ff99'},//Chasseur
							3:{label:'Ch.L' ,color: '#FF00FF'},//Ch.L
							4:{label:'Fr\u00E9gate' ,color: '#00FFFF'},//Fr\u00E9gate
							5:{label:'Destroyer' ,color: '#FFCC00'},//Destroyer
							6:{label:'Overlord' ,color: '#0099FF'},//Overlord
							7:{label:'F.Noire' ,color: '#EEC273'},//F.Noire
							8:{label:'Hyperion' ,color: '#FF0099'},//Hyperion
							9:{label:'Collecteur' ,color: '#00FF99'},//Collecteur
							10:{label:'Sonde' ,color: '#00B0B0'},//Sonde
							11:{label:'Sat.Solaire' ,color: '#B000B0'},//Sat.Solaire
							12:{label:'Colonisateur' ,color: '#A099FF'},//Colonisateur
							13:{label:'Extracteur' ,color: '#99FF99'},//Extracteur
							14:{label:'BFG' ,color: '#FF99A0'},//BFG
							15:{label:'S.BFG' ,color: '#99FFA0'},//S.BFG
							16:{label:'P-F.Canon' ,color: '#99A0FF'},//P-F.Canon
							17:{label:'D\u00E9flecteurs' ,color: '#9900FF'},//D\u00E9flecteurs
							18:{label:'P-F.Ionique' ,color: '#CCFFCC'},//P-F.Ionique
							19:{label:'A.M.D' ,color: '#FFCC99'},//A.M.D
							20:{label:'Ch.force' ,color: '#FF3333'},//Ch.force
							21:{label:'Holochamp' ,color: '#FF9900'},//Holochamp
							22:{label:'Pertes' ,color: '#FF0000'},//pertes
							23:{label:'D\u00E9truit !' ,color: '#FF0000'},//détruit
							24:{label:'Attaquant' ,color: '#CCFFAF'},//attaquant
							25:{label:'D\u00E9fenseur' ,color: '#EEC263'},//défenseur
						}
					};
function ufSetCRconvOptions(options) {
	ufSetJSONPref("unifoxCRConverterOptions",options);
}					
function ufGetCRconvOptions() {
	var options = ufGetJSONPref("unifoxCRConverterOptions",ufCRconvPref);
	/*if(options=='')options="({})";
	ufLog("loading CR options"+options);
	try {
	options = eval(options);
	}catch(e){options = {};}
	for(var i in options) {
		if(typeof options[i] == 'string') {
			options[i] = unescape(options[i]);
		}
	}
	if(typeof options.colors!='undefined') {
		for(var i in options.colors) {
			var val = options.colors[i];
			if(typeof val!='undefined')
				options.colors[i] = unescape(options.colors[i]);
		}
	}*/
	//ufDump(options.colors);
	return options;
}

function ufSerialize(object) {
	var st = '{';
	for(var i in object) {
		var type = typeof object[i];
		st+= i+':';
		if(type == 'object') {
			st+=ufSerialize(object[i]);
		}
		else if(type == 'string') {
			st+='"'+escape(object[i])+'"';
		}
		else st+=object[i];
		st+=',';
	}
	if(st!='{')
		st = st.substr(0,st.length-1);
	st += '}';
	return st;
}
  
  //dumpProperties_o(PrefsBranchUF);
  
  
