if(!UniFox)
	var UniFox = {};

UniFox.Bundle = function (bundleUrl)
{
	this.bundle = srGetStrBundle(bundleUrl);
}
UniFox.Bundle.prototype = {
	getString : function(stringName,params)
	{
		try{
			if(typeof params != "undefined")
			{
				if(params instanceof Array)
				{
					return this.bundle.formatStringFromName(stringName,params,params.length);
				}
				else
				{
					return this.bundle.formatStringFromName(stringName,[params],1);
				}
			}
			else
				return this.bundle.GetStringFromName(stringName);
		} catch (e)
		{
			ufLog("can't get string("+stringName+","+params+") : "+e,UFLog.ERROR);
		}
	},
	toString : function()
	{
		var enumerator = this.bundle.getSimpleEnumeration();
		var s = "";
		while (enumerator.hasMoreElements()) {
		  var property = enumerator.getNext().QueryInterface(Components.interfaces.nsIPropertyElement);
		  s += property.key + ' = ' + property.value + ';\n';
		}
		return s;
	},
}
UniFox.Coordinates = function (g,s,p)
{
	this.galaxy = g || 0;
	this.system = s || 0;
	this.planet = p || 0;
	this[0] = this.galaxy;
	this[1] = this.system;
	this[2] = this.planet;
	this.full = g+":"+s+":"+p;
}
UniFox.Coordinates.prototype = {
	toString : function()
	{
		return this.full;
	}
}
UniFox.Coordinates.parse = function(text)
{
	text = text+"";
	var m = text.match(/\d+:\d+:\d+/g);
	var result = false;
	if(m.length > 1)
	{
		result = [];
		for(var i = 0; i < m.length; i++)
		{
			var m2 = m[i].match(/(\d+):(\d+):(\d+)/);
			result.push(new UniFox.Coordinates(m2[1],m2[2],m2[3]));
		}
	}
	else if(m.length == 1)
	{
		var m2 = m[0].match(/(\d+):(\d+):(\d+)/);
		result = new UniFox.Coordinates(m2[1],m2[2],m2[3]);
	}
	return result;
}

//TODO: renommer
/**
* Entity used for function registration
*/
UniFox.FunctionContext = function(scope,methods)
{
	this.scope = scope;
	this.methods = methods;
}
/*UniFox.FunctionContext.prototype.toString = function()//comment because of infinite loop
{
	return this.scope+'.'+UFUtils.getPropertyList(this.methods);
}*/

/**
* Represents a parsed URL
*/
UniFox.Url = function(protocol,domain,mainDomain,country,folders,page,parameters,anchor,url)
{
	this.url = url ? url : "";
	this.protocol = protocol ? protocol : "";
	this.domain = domain ? domain : "";
	this.mainDomain = mainDomain ? mainDomain : "";
	this.country = country ? country : "";
	this.folders = folders ? folders : [];
	this.page = page ? page : "";
	this.parameters = parameters ? parameters : {};
	this.anchor = anchor ? anchor : "";
}
UniFox.Url.parse = function(url)
{
	var result = new UniFox.Url();
	result.url = url;
	
	var splitedUrl = url.split('/');
	if(splitedUrl.length <= 1)//url vide ou de type about:config par exemple
		return result;
	result.protocol = splitedUrl[0].substr(0,splitedUrl[0].length-1);//before the "://", eg: http
	//splitedUrl[1] is null
	result.domain = splitedUrl[2];
	var splitedDomain = result.domain.split('.');
	if(splitedDomain.length >= 2)
	{
		result.country = splitedDomain[splitedDomain.length-1];
		result.mainDomain = splitedDomain[splitedDomain.length-2]+"."+result.country;
	}
	
	
	if(splitedUrl[3] != "")
	{
		if(splitedUrl.length >= 5)
		{
			for(var i = 3; i < splitedUrl.length-1; i++)
			{
				result.folders.push(splitedUrl[i]);
			}
		}
		var lastPart = splitedUrl[splitedUrl.length-1];
		lastPart = lastPart.split('#');
		if(lastPart.length > 1)
			result.anchor = lastPart[1];
		lastPart = lastPart[0];
		
		var index = lastPart.indexOf('?');
		lastPart = lastPart.split('?');
		result.page = lastPart[0];
		if(index > -1)
		{
			lastPart = lastPart[1];
			//ufLog("lastPart:"+lastPart);
			lastPart = lastPart.split('&');
			//ufDir(lastPart);
			var sTmp = "";
			for(var i in lastPart)
			{
				sTmp = lastPart[i];
				sTmp = sTmp.split('=');
				result.parameters[sTmp[0]] = sTmp[1];
			}
			//ufDir(result.parameters);
		}
	}

	return result;
}

/**
* Enumeration, gives one code per page of the game
*/
UniFox.PageTypes = {
	NOPAGE : 0,
	LOGIN : 1,
	OVERVIEW : 2,
	RESOURCES : 4,
	CONVERTER : 8,
	BUILDINGS : 16,
	LABO : 32,
	SHIPYARD : 64,
	DEFENSE : 128,
	MESSAGES : 256,
	SIMULATOR : 512,
	CR : 1024,
	FLEET : 2048,
	VORTEX : 4096,
	GALAXY : 8192,
	RANK : 16384,
	GLOBALVIEW : 32768,
	ALLYMEMBERS : 65536,
	OTHER : 1073741824
}
UniFox.PageTypes.getString = function(pageType) {
	switch(pageType) {
		case this.LOGIN: 
					return "LOGIN";
					break;
		case this.OVERVIEW: 
					return "OVERVIEW";
					break;
		case this.RESOURCES: 
					return "RESOURCES";
					break;
		case this.CONVERTER: 
					return "CONVERTER";
					break;
		case this.BUILDINGS: 
					return "BUILDINGS";
					break;
		case this.LABO: 
					return "LABO";
					break;
		case this.SHIPYARD: 
					return "SHIPYARD";
					break;
		case this.DEFENSE: 
					return "DEFENSE";
					break;
		case this.MESSAGES: 
					return "MESSAGES";
					break;
		case this.SIMULATOR: 
					return "SIMULATOR";
					break;
		case this.CR: 
					return "CR";
					break;
		case this.FLEET: 
					return "FLEET";
					break;
		case this.VORTEX: 
					return "VORTEX";
					break;
		case this.GALAXY: 
					return "GALAXY";
					break;
		case this.RANK: 
					return "RANK";
					break;
		case this.GLOBALVIEW: 
					return "GLOBALVIEW";
					break;
		case this.ALLYMEMBERS: 
					return "ALLYMEMBERS";
					break;
		case this.OTHER: 
					return "OTHER";
					break;
		case this.ALL: 
					return "ALL";
					break;
		case this.NOPAGE :
					return "NOPAGE";
		default:	
			return "COMPLEX("+pageType+")";
	}
}
UniFox.PageTypes.initALL = function() {
	var a = 0;
	for(var i in UniFox.PageTypes)
	{
		if(typeof UniFox.PageTypes[i] == "number")
			a+=UniFox.PageTypes[i];
	}
	UniFox.PageTypes.ALL = a;
}
UniFox.PageTypes.initALL();

UniFox.ColorList = {
	'aliceblue':1, 'antiquewhite':1, 'aqua':1, 'aquamarine':1, 'azure':1, 
	'beige':1, 'bisque':1, 'black':1, 'blanchedalmond':1, 'blue':1, 
	'blueviolet':1, 'brown':1, 'burlywood':1, 'cadetblue':1, 'chartreuse':1,
	'chocolate':1, 'coral':1, 'cornflowerblue':1, 'cornsilk':1, 'crimson':1, 
	'cyan':1, 'darkblue':1, 'darkcyan':1, 'darkgoldenrod':1, 'darkgray':1,
	'darkgreen':1, 'darkkhaki':1, 'darkmagenta':1, 'darkolivegreen':1, 
	'darkorange':1, 'darkorchid':1, 'darkred':1, 'darksalmon':1, 'darkseagreen':1,
	'darkslateblue':1, 'darkslategray':1, 'darkturquoise':1, 'darkviolet':1, 
	'deeppink':1, 'deepskyblue':1, 'dimgray':1, 'dodgerblue':1, 'firebrick':1, 
	'floralwhite':1, 'forestgreen':1, 'fuchsia':1, 'gainsboro':1, 'ghostwhite':1, 
	'gold':1, 'goldenrod':1, 'gray':1, 'green':1, 'greenyellow':1,
	'honeydew':1,  'hotpink':1, 'indianred':1, 'indigo':1, 'ivory':1,
	'khaki':1, 'lavender':1, 'lavenderblush':1, 'lawngreen':1, 'lemonchiffon':1,
	'lightblue':1, 'lightcoral':1, 'lightcyan':1, 'lightgoldenrodyellow':1, 'lightgreen':1, 
	'lightgrey':1, 'lightpink':1, 'lightsalmon':1, 'lightseagreen':1, 'lightskyblue':1, 
	'lightslategray':1, 'lightsteelblue':1, 'lightyellow':1, 'lime':1, 'limegreen':1, 
	'linen':1, 'magenta':1, 'maroon':1, 'mediumaquamarine':1, 'mediumblue':1, 
	'mediumorchid':1, 'mediumpurple':1, 'mediumseagreen':1, 'mediumslateblue':1, 'mediumspringgreen':1,
	'mediumturquoise':1, 'mediumvioletred':1, 'midnightblue':1, 'mintcream':1, 'mistyrose':1, 
	'moccasin':1, 'navajowhite':1, 'navy':1, 'oldlace':1, 'olive':1, 
	'olivedrab':1, 'orange':1, 'orangered':1, 'orchid':1, 'palegoldenrod':1, 
	'palegreen':1, 'paleturquoise':1, 'palevioletred':1, 'papayawhip':1, 'peachpuff':1, 
	'peru':1, 'pink':1, 'plum':1, 'powderblue':1, 'purple':1,
	'red':1, 'rosybrown':1, 'royalblue':1, 'saddlebrown':1, 'salmon':1,
	'sandybrown':1, 'seagreen':1, 'seashell':1, 'sienna':1, 'silver':1, 
	'skyblue':1, 'slateblue':1, 'slategray':1, 'snow':1, 'springgreen':1,
	'steelblue':1, 'tan':1, 'teal':1, 'thistle':1, 'tomato':1,
	'turquoise':1, 'violet':1, 'wheat':1, 'white':1, 'whitesmoke':1, 
	'yellow':1, 'yellowgreen':1, 
	'transparent':1
}

UniFox.OptionsTypes = {
	//NONE : 0, //??
	CHECKBOX : 1,
	ONEROWTEXT: 2,
	NUMBER : 4,
	MULTIPLEROWTEXT : 8,
	COLOR: 16,
	DROPDOWNLIST: 32,
	LISTBOX: 64,
	DOUBLE_LISTBOX : 128
	
}

/**
* Describes a userpref
* @param p: array of UniFox.PageTypes, the pages corresponding to the pref
* @param t: UniFox.OptionsTypes, the nature of the pref
* @param d: any type, the default value of the pref
*/
function UFOption (p,t,d) //TODO compléter
{
	this.pages = p;
	this.type = t;
	this.defaultVal = d;

}