//classe dont une instance gère une page donnée
//alert("TOTO");
//alert((typeof UniFox));
if(!UniFox)
	var UniFox = {};
/**
* Constructor
*/
UniFox.PageHandler = function (doc,win,usWin)
{
	this.document = doc;
	this.doc = doc;
	this.headNode = this.document.getElementsByTagName('head');
	if(this.headNode.length && this.headNode.length >= 1)
		this.headNode = this.headNode[0];
	this.body = document.body;
	
	this.window = win;
	this.unsafeWindow = usWin;
	if(this.document.location)
		this.url = this.document.location.href;
	else
	{
		this.url = "";
		ufLog("No document.location",UFLog.ERROR);
	}
	this.parameters = [];
	this.page = UniFox.PageTypes.NOPAGE;
	this.runningModules = [];
	this.stats = {};
	
	this.serverData = null;
	this.gameData = null;
	this.currentServer = null;
	this.currentUniverse = null;
	
	this.addedScripts = {};
	this.tooltipsInitiated = false;
	
	this.stock = [];
	this.planet = null;
}

UniFox.PageHandler.prototype = {
	
	xpaths : {
		stock : "id('diventete')/table/tbody/tr/th",
		planets : "//select[@name='planete_select']"
	},
	
	initTooltips : function()
	{
		this.addScriptCode("var ol_bgcolor = '';");
		this.addScriptByUrl(UFUtils.chromeContentResourcesUrl+"js/overlib.js",true,"<!-- overLIB (c) Erik Bosrup -->");
		this.tooltipsInitiated = true;
	},
	
	addTooltip : function (targetElement,tooltipHTML)
	{
		if(!this.tooltipsInitiated)
			this.initTooltips();
		var spacerUrl = UFUtils.chromeContentResourcesUrl+"pics/spacer.gif";
		targetElement.setAttribute("onmouseover", 'return overlib(\''+tooltipHTML+'\', HAUTO, VAUTO, FGBACKGROUND, \''+spacerUrl+'\', FGCOLOR, \'\', BORDER, \'0\');');
		targetElement.setAttribute("onmouseout", 'return nd();');
	},
	
	addScriptCode : function (code/*,once,id*/)//TODO: coder le "once"
	{
		var script = this.document.createElement('script');
		script.setAttribute("type", "text/javascript");
		script.innerHTML = code;
		this.headNode.appendChild(script);
	},
	
	/**
	* Appends a js script to the page
	* @param url: string, url to the script
	* @param once: optional bool, true if script must be only added once, 
	*							false if can be added more than once, 
	*							default is true
	*/
	addScriptByUrl : function (url,once,comments)
	{
		once = typeof once != "undefined" ? once : true;
		if((once==true && (typeof this.addedScripts[url] == "undefined")) || once==false)
		{
			var script = this.document.createElement('script');
			script.setAttribute('src',url);
			script.setAttribute("type", "text/javascript");
			
			this.headNode.appendChild(script);
			if(typeof comments!= "undefined")
				script.innerHTML = comments;
			
			if(once)
				this.addedScripts[url] = true;
		}
		
		
	},
	
	/**
	* 
	*/
	getPlanet : function ()
	{
		if(this.planet == null)
		{
			var path = this.xpaths.planets;
			var select = this.getSingleNode(path);
			var option = select.options[select.selectedIndex];
			var planet = {};
			planet.fullName = option.innerHTML;
			planet.id = option.value.match(/planete_select=(\d+)/)
			planet.id = planet.id[1];
			
			this.planet = planet;
		}
		return this.planet;
	},
	
	/**
	* 
	*/
	getGameData : function ()
	{
		if(this.gameData == null)
		{
			this.gameData = UFUtils.getGameData();
		}
		return this.gameData;
	},
	/**
	* 
	*/
	getServerData : function ()
	{
		if(this.serverData == null)
		{
			this.serverData = UFUtils.getServerData();
		}
		return this.serverData;
	},
	
	/**
	* 
	*/
	getStock : function ()
	{
		if(this.stock.length == 0)
		{
			var path = this.xpaths.stock;
			var cells = this.getOrderedSnapshotNodes(path);
			if(cells.snapshotLength == 8)
			{
				for(var i=0; i < 3;i++)
				{
					var cell = cells.snapshotItem(i*2+1);
					var quantity = UFUtils.stripNotDigit(cell.textContent);
					this.stock.push(quantity);
				}
				//cas particulier pour l'énergie
				var cell = cells.snapshotItem(7);
				var parts = cell.textContent.split("/");
				var quantity = UFUtils.stripNotDigit(parts[1],true);//on stocke d'abord l'energie max, car c'est celle qui sera le plus souvent utilisée
				this.stock.push(quantity);
				quantity = UFUtils.stripNotDigit(parts[0]);
				this.stock.push(quantity);
			}
		}
		return this.stock;
	},
	
	/* Xpath management	*/
	/**
	* @param xpath: XPath string
	* @param node: optional Node, the context node, default is the whole document
	* @return: the found set of XPathResult  
	*/
	getNumberValue : function (xpath,node) {
		node = node ? node : this.document;
		return this.document.evaluate(xpath,node,null,XPathResult.NUMBER_TYPE, null).numberValue;
	},
	getStringValue : function (xpath,node) {
		node = node ? node : this.document;
		return this.document.evaluate(xpath,node,null,XPathResult.STRING_TYPE, null).stringValue;
	},
	getOrderedSnapshotNodes : function (xpath,node) {
		node = node ? node : this.document;
		return this.document.evaluate(xpath,node,null,XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
	},
	getUnorderedSnapshotNodes : function (xpath,node) {
		node = node ? node : this.document;
		return this.document.evaluate(xpath,node,null,XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);
	},
	getSingleNode : function (xpath,node) {
		node = node ? node : this.document;
		return this.document.evaluate(xpath,node,null,XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
	},
	/* End of Xpath management */

	/**
	* Instantiate the given module
	* @param module: UniFox.FunctionContext, the module to be instantiated
	*/
	runModule : function(module)
	{
		var startDate = new Date();
		var newMod = module.methods.newMod.apply(module.scope,[this]);
		var endDate = new Date();
		var diff = endDate.getTime()-startDate.getTime();
		this.stats[newMod.moduleName] = {time:diff};
		this.runningModules.push(newMod);
		
		//alert(this.runningModules.length);
		//ufDir(this.runningModules);
	},
	
	/**
	* Analyses URL to qualify current page
	* @param url: 	if url is a string, it will be parsed, 
	*				if url is a UniFox.Url, it will be used
	* 				if no url is given, this.parsedUrl is used
	*/
	getPage : function(url)
	{
		var purl = null;
		if(typeof url == "string")
			purl = UniFox.Url.parse(url);
		else if(typeof url == "undefined")
			purl = this.parsedUrl;
		else
			purl = url;
		
		var validDomain = false;
		for(var i in this.serverData.servers)
		{
			if(this.serverData.servers[i].domain == purl.mainDomain)
			{
				validDomain = true;
				this.currentServer = this.serverData.servers[i];
				break;
			}
		}
		if(validDomain)
		{
			var isLoginUrl = false;
			for(var i in this.currentServer.login)
			{
				if(purl.domain == this.currentServer.login[i])
				{
					isLoginUrl = true;
					break;
				}		
			}
			if(isLoginUrl)
				return UniFox.PageTypes.LOGIN;
			else {
				var isGameUrl = false;
				for(var i in this.currentServer.universes)
				{
					if(purl.domain == this.currentServer.universes[i].url)
					{
						isGameUrl = true;
						this.currentUniverse = this.currentServer.universes[i];
						break;
					}		
				}
				if(isGameUrl)
				{
					if(purl.page == "index.php")
					{ 
						if(typeof this.parameters['action'] == "undefined")
							return UniFox.PageTypes.OVERVIEW;
						switch(this.parameters['action'])
						{
							case 'accueil':
										return UniFox.PageTypes.OVERVIEW;
							case 'ressources':
										return UniFox.PageTypes.RESOURCES;
							case 'batiments':
										return UniFox.PageTypes.BUILDINGS;	
							case 'labo':
										return UniFox.PageTypes.LABO;				
							case 'chantier':
								switch(this.parameters['subaction'])
								{
									case 'def':
										return UniFox.PageTypes.DEFENSE;
									case 'flotte':
									default:
										return UniFox.PageTypes.SHIPYARD;
								}
							default: 
										return UniFox.PageTypes.OTHER;
						}
					}
					else 
						return UniFox.PageTypes.OTHER;
				}
				else 
					return UniFox.PageTypes.NOPAGE;
			}
		}
		else 
			return UniFox.PageTypes.NOPAGE;
	},

	/**
	* Entry point, launched by UniFox
	*/
	onPageLoaded : function() {
		var startDate = new Date();
		
		this.getServerData();
		this.parsedUrl = UniFox.Url.parse(this.url);
		//ufDir(this.parsedUrl);
		this.parameters = this.parsedUrl.parameters;
		//ufDir(this.parameters);
		
		this.page = this.getPage(this.parsedUrl);
		
		if(this.page != UniFox.PageTypes.NOPAGE)
		{
			ufLog("Page found on "+this.url+" : "+UniFox.PageTypes.getString(this.page),UFLog.MESSAGE);
			//ufDir(this.getServerData(),{depth:Infinity});
			//ufDir(this.currentUniverse);
			for(var i in UniFox.browserHandler.modulesIndexByPage[this.page])
			{
				this.runModule(UniFox.browserHandler.modulesIndexByPage[this.page][i]);
			}
			var endDate = new Date();
			var diff = endDate.getTime()-startDate.getTime();
			var message = "Launched modules on "+this.url+" : "+this.runningModules.length+"\nTotal: "+diff+"ms\n";
			for(var i in this.stats)
				message += "\t"+i+" "+this.stats[i].time+"ms\n";
			ufLog(message,UFLog.MESSAGE);
		}
		
	}
}

