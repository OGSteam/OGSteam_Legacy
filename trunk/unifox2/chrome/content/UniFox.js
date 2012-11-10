//entry point

//namespace
if(!UniFox)
	var UniFox = {};
/*else
	alert('UniFox namespace already in use, UniFox2 aborted');*/
UniFox.Modules = {};//namespace for modules
UniFox.browserHandler = {
	
	moduleNames : [],
	modulesIndexByPage : {},
	
	//mainWindow : null,
	
	 
	/**
	* 
	*/
	switchEnableUniFoxCommand : function() {
		UFUtils.switchEnableUniFox();
		this.setEnableMenuItem();
	},
	
	/**
	* 
	*/
	setEnableMenuItem : function() {
		var enabled = UFUtils.getPref("UniFoxEnabled",true);
		var menuItem = document.getElementById("unifox2-menu-enable");
		var label = enabled ? UFUtils.getString("options.disableUniFox") : UFUtils.getString("options.enableUniFox");
		menuItem.setAttribute("label",label);
	},
	
	/**
	* Called by a module to register itself
	* @param module: object, module factory
	* @param func: function, the function to call on the module factory to get a new instance of the module
	* @param handledPages: array of UniFox.PageTypes, the list of pages handled by the module
	*/
	registerModule : function(module,func,handledPages)
	{
		for(var i in handledPages)
		{
			var pageType = handledPages[i];
			if(typeof this.modulesIndexByPage[pageType] == 'undefined')
				this.modulesIndexByPage[pageType] = [];
			//this.modulesIndexByPage[i].push({moduleFactory:module,fn:func});
			//this.modulesIndexByPage[i].push(module);
			this.modulesIndexByPage[pageType].push(new UniFox.FunctionContext(module,{newMod:func}));
		}
		/*for(var i in this.modulesIndexByPage)
			for(var j in this.modulesIndexByPage[i])
				alert(i+','+j+'-'+this.modulesIndexByPage[i][j]);*/
	},
	
	/**
	* Loads the given module to the current context
	* @param moduleName: string, name of the module
	*/
	loadModule : function(moduleName) {
		var location = UFUtils.modulesUrl+moduleName+"/handler.js";
		var subscriptLoader = Components.classes["@mozilla.org/moz/jssubscript-loader;1"]
                      .getService(Components.interfaces.mozIJSSubScriptLoader);
		subscriptLoader.loadSubScript(location);
		
		//méthode avec append qui ne marche pas
		/*var script = document.createElement('script');
		script.setAttribute('src',location);
		script.setAttribute('type',"application/x-javascript");
		this.mainWindow.appendChild(script);*/
		
		//utilisation de modules: abandonnée car trop contraignante à cause du scope du module, il n'a pas accès au browser
		/*var location = "resource://unifox2/"+moduleName+"/handler.js";
		Components.utils.import(location);
		this.window = window;
		uftest(UniFox);
		ufalert();*/
	},
	
	/**
	* Loads all activated modules
	*/
	loadModules : function() {
		this.modulesList = UFUtils.getJSONPref("Modules");
		for(var i in this.modulesList)
		{
			if(this.modulesList[i].enabled)
			{
				this.loadModule(this.modulesList[i].name);
			}
		}
	},
	
	/**
	* On each new page opened, creates a handler
	*/
	onPageLoaded2 : function(event)
	{
		var enabled = UFUtils.getPref("UniFoxEnabled",true);
		if(enabled)
		{
			var document = event.originalTarget;
			var win = document.defaultView;
			var unsafeWindow = win.wrappedJSObject;
			var handler = new UniFox.PageHandler(document,win,unsafeWindow);
			handler.onPageLoaded();
		}
		/*var CI = Components.interfaces;
		var nsIDocShell = CI.nsIDocShell;
		var docShell = gBrowser.docShell.getDocShellEnumerator(
        CI.nsIDocShellTreeItem.typeContent,
        gBrowser.docShell.ENUMERATE_FORWARDS).getNext();
		
		var document = docShell.contentViewer.DOMDocument;
		ufDir(document);*/

	},
	
	/**
	* On each new page opened, creates a handler
	*/
	onPageLoaded : function(event)
	{
		UniFox.browserHandler.onPageLoaded2(event);
	},
	
	
	/**
	* Used once, when the Firefox window opens
	*/
	onWindowLoaded2 : function(event)
	{
		//Browser.tabContainer.addEventListener('TabOpen', UniFox.onTabOpen,false );
		//Browser.tabContainer.addEventListener('TabSelect', UniFox.onTabSelect,false );
		window.addEventListener('DOMContentLoaded', this.onPageLoaded, false);
		//UniFox.mainWindow = document.getElementById("main-window");
		//for(var i in UniFox.mainWindow)
		//	alert(i+' '+UniFox.mainWindow[i]);
		//alert(UniFox.mainWindow);
		this.loadModules();
		ufLog('modules chargés',UFLog.MESSAGE);

		this.setEnableMenuItem();
		var lastUpdate = UFUtils.getPref("LastUpdate",0);
		var now = new Date();
		now = Math.round(now.getTime()/1000);
		if(now > lastUpdate+24*3600)
		{
			UFUtils.updateRemotePrefs();
		}
	},
	/**
	* Used once, when the Firefox window opens
	*/
	onWindowLoaded : function(event)
	{
		UniFox.browserHandler.onWindowLoaded2(event);
	}
};

window.addEventListener('load', UniFox.browserHandler.onWindowLoaded, false);








/*UniFox.browserListener =  
 {  
   QueryInterface: function(aIID)  
   {  
    if (aIID.equals(Components.interfaces.nsIWebProgressListener) ||  
        aIID.equals(Components.interfaces.nsISupportsWeakReference) ||  
        aIID.equals(Components.interfaces.nsISupports))  
      return this;  
    throw Components.results.NS_NOINTERFACE;  
   },  
   
   onStateChange: function(aWebProgress, aRequest, aFlag, aStatus)  
   {  
   
   if(aWebProgress.DOMWindow)
   {
	if(aWebProgress.DOMWindow.location.href.indexOf("console.xul") < 0)
	{
		ufLog("flag is "+aFlag+"\nstatus is "+aStatus+"\nDOMWindow found: "+aWebProgress.DOMWindow.location);
		if(aWebProgress.DOMWindow.document)
			ufLog("document found: "+aWebProgress.DOMWindow.document.location);
	}
   }
    if(aFlag & Components.interfaces.nsIWebProgressListener.STATE_IS_DOCUMENT)  
    { 
		// If you use myListener for more than one tab/window, use  
		// aWebProgress.DOMWindow to obtain the tab/window which triggers the state change  
		if(aFlag & Components.interfaces.nsIWebProgressListener.STATE_START)  
		{  
		  // This fires when the load event is initiated  
		  //ufLog("start on:"+aWebProgress.DOMWindow.location);
		  //ufDir(aWebProgress.DOMWindow.document);
		  //aWebProgress.DOMWindow.document.title = "TOTO !";
		  
		}  
		
		  //

		if(aFlag & Components.interfaces.nsIWebProgressListener.STATE_STOP)  
		{  
		  // This fires when the load finishes  
		  //ufLog("stop on:"+aWebProgress.DOMWindow.location.href);
		  //ufLog("stop on:"+aWebProgress.DOMWindow.location);
		  //ufDir(aWebProgress.DOMWindow.document);
		  //aWebProgress.DOMWindow.document.title = "TITI !";
		}  
	
		
		//ufDir(aWebProgress.DOMWindow.document);
		//ufDir(aWebProgress.DOMWindow.document.body.innerHTML);
	}
   },  
   
   onLocationChange: function(aProgress, aRequest, aURI)  
   {  
    // This fires when the location bar changes; i.e load event is confirmed  
    // or when the user switches tabs. If you use myListener for more than one tab/window,  
    // use aProgress.DOMWindow to obtain the tab/window which triggered the change.  
   },  
   
   // For definitions of the remaining functions see related documentation  
   onProgressChange: function(aWebProgress, aRequest, curSelf, maxSelf, curTot, maxTot) { },  
   onStatusChange: function(aWebProgress, aRequest, aStatus, aMessage) { },  
   onSecurityChange: function(aWebProgress, aRequest, aState) { }  
 }  
 
  
 window.addEventListener('load', function(){
	gBrowser.addProgressListener(UniFox.browserListener, Components.interfaces.nsIWebProgress.NOTIFY_STATE_DOCUMENT); 
 }, false);*/