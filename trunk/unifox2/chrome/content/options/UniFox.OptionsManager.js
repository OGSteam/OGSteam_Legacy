if(!UniFox)
{
	var UniFox = {};
}
UniFox.Modules = {};//namespace for modules
UniFox.OptionsManager = {
	
	moduleNames : [],
	modules : [],
	optionsToSave : [],
	optionsToMove : {},

	/* functions to be used by the modules */
	/**
	*
	*/
	createOptionElement : function(option)
	{
		var val = "";
		var elem = null;
		switch(option.type)
		{
			case UniFox.OptionsTypes.CHECKBOX:
						val = UFUtils.getPref(option.id,option.defaultValue);
						elem = this.createCheckbox(option.id,val,option.description);
						break;
			case UniFox.OptionsTypes.ONEROWTEXT:
						val = UFUtils.getPref(option.id,option.defaultValue);
						elem = this.createOneRowText(option.id,val,option.description,option.loadParams);
						break;
			case UniFox.OptionsTypes.NUMBER:
						val = UFUtils.getPref(option.id,option.defaultValue);
						elem = this.createNumber(option.id,val,option.description,option.loadParams);
						break;
			case UniFox.OptionsTypes.DROPDOWNLIST:
						val = UFUtils.getJSONPref(option.id,{ index:option.defaultValue});
						var selectedIndex = val.index;
						elem = this.createDropdownlist(option.id,selectedIndex,option.description,option.loadParams);
						break;
			/*case UniFox.OptionsTypes.LISTBOX:
						elem = this.createListBox(option.id,option.description,option.loadParams);
						break;*/
			case UniFox.OptionsTypes.DOUBLE_LISTBOX:
						elem = this.createDoubleListBox(option.id,option.description,option.loadParams);
						break;
			default:ufLog("can't create Element, uknown UFOptionType ("+option.type+')',UFLog.ERROR);
		}
		if(elem != null)
		{
			//for(var i in option.pages) {
				this.addOptionElementToPage(elem,option.pages[0]);//on n'ajoute l'élément que sur la première page, on le déplacera sur les suivantes					
			//}
			for(var i in option.pages) {
				this.addOptionToMove(option.id,option.pages[i]);
			}
			if(option.autosave)
			{
				this.optionsToSave.push(option);
			}
		}
	},
	
	/**
	*
	*/
	createOptionElements : function(options)
	{
		for(var i in options) {
			this.createOptionElement(options[i]);
		}
	},
	
	/**
	*
	*/
	createLabelWithVBox : function(args)
	{
		var value = args.value || '';
		var id = args.id || '';
		var control = args.control || '';
		var vbox = document.createElement('vbox');
		var spring = document.createElement('spring');
		spring.setAttribute('flex',"1");
		vbox.appendChild(spring);
		var labelElem = document.createElement('label');
		labelElem.setAttribute('control',control);
		labelElem.setAttribute('id',id);
		labelElem.setAttribute('value',value);
		vbox.appendChild(labelElem);
		var spring = document.createElement('spring');
		spring.setAttribute('flex',"1");
		vbox.appendChild(spring);
		return vbox;
	},
	
	/**
	*
	*/
	refreshDropdownlist : function(list,values,selectedIndex)
	{
		if(typeof selectedIndex == "undefined")
		{
			selectedIndex = 0;
		}
		var menupopup = list.firstChild;
		while (menupopup.childNodes.length > 0) {
			menupopup.removeChild(menupopup.firstChild);
		}
		for(var i = 0; i < values.length; i++)
		{
			var menuitem = document.createElement('menuitem');
			menuitem.setAttribute('label',values[i].label);
			menuitem.setAttribute('value',values[i].value);
			menupopup.appendChild(menuitem);
		}
		list.selectedIndex = selectedIndex;
	},
	/**
	*
	*/
	createDropdownlist : function(id,selectedIndex,label,params)
	{
		var sizetopopup = "always";
		if(typeof params!="undefined")
		{
			if(typeof params.values != "undefined")
				var values = params.values;
			if(typeof params.sizetopopup != "undefined")
				var sizetopopup = params.sizetopopup;
		}
		if(typeof values == "undefined" || isNaN(selectedIndex))
		{
			ufLog("can't create Dropdownlist "+id,UFLog.ERROR);
			return null;
		}
		
		var hbox = document.createElement('hbox');
		this.inviVbox.appendChild(hbox);
		hbox.setAttribute('id',id+'Container');
		var vbox = this.createLabelWithVBox({value:label,control:id});
		hbox.appendChild(vbox);
		var menulist = document.createElement('menulist');
		menulist.setAttribute('sizetopopup',sizetopopup);
		menulist.setAttribute('id',id);
		hbox.appendChild(menulist);
		var menupopup = document.createElement('menupopup');
		menulist.appendChild(menupopup);
		this.refreshDropdownlist(menulist,values,selectedIndex);
		
		return hbox;
	},
	
	/**
	* //TODO terminer ?
	*/
	createDoubleListBox : function(id,label,params)
	{
		if(typeof params!="undefined")
		{
			if(typeof params.values != "undefined")
				var values = params.values;
		}
		
		var groupbox = document.createElement('groupbox');
		groupbox.setAttribute('id',id+'Container');
		this.inviVbox.appendChild(groupbox);
		var caption = document.createElement('caption');
		caption.setAttribute('label',label);
		groupbox.appendChild(caption);
		var hbox = document.createElement('hbox');
		groupbox.appendChild(hbox);
		
		
		var listboxEnabled = document.createElement('listbox');
		var listboxDisabled = document.createElement('listbox');
		var buttonEnable = document.createElement('button');
		var buttonDisable = document.createElement('button');
		var vbox = document.createElement('vbox');
		hbox.appendChild(listboxEnabled);
		vbox.appendChild(buttonEnable);
		vbox.appendChild(buttonDisable);
		hbox.appendChild(vbox);
		hbox.appendChild(listboxDisabled);
		
		listboxEnabled.setAttribute('id',id+'listboxEnabled');
		buttonEnable.setAttribute('id',id+'buttonEnable');
		buttonEnable.setAttribute('label','<-');
		buttonDisable.setAttribute('id',id+'buttonDisable');
		buttonDisable.setAttribute('label','->');
		//TODO add eventlistener
		listboxDisabled.setAttribute('id',id+'listboxDisabled');
		for(var i in values)
		{
			var item = document.createElement('listitem');
			item.setAttribute('label',values[i].name);
			item.setAttribute('value',values[i].id);
			
			if(values[i].enabled)
				listboxEnabled.appendChild(item);
			else
				listboxDisabled.appendChild(item);
		}
		
		return groupbox;
	},
	
	/**
	*
	*/
	createNumber : function(id,value,label,params)
	{
		if(typeof params!="undefined")
		{
			if(typeof params.maxlength != "undefined")
				var maxlength = params.maxlength;
			if(typeof params.size != "undefined")
				var size = params.size;
			if(typeof params.max != "undefined")
				var max = params.max;
			if(typeof params.min != "undefined")
				var min = params.min;
		}
		if(typeof maxlength == "undefined" && typeof max != "undefined")
		{
			var max2 = max+"";
			maxlength = max2.length;
		}
		if(typeof maxlength != "undefined")
			size = maxlength;
		
		var hbox = document.createElement('hbox');
		hbox.setAttribute('id',id+'Container');
		var vbox = this.createLabelWithVBox({value:label,control:id});
		hbox.appendChild(vbox);
		
		var tb = document.createElement('textbox');
		tb.setAttribute('id',id);
		tb.setAttribute('value',value);
		tb.setAttribute('type','number');
		if(typeof min != "undefined")
			tb.setAttribute('min',min);
		if(typeof max != "undefined")
			tb.setAttribute('max',max);
		
		if(typeof maxlength != "undefined")
			tb.setAttribute("maxlength",maxlength);
		if(typeof size != "undefined")
			tb.setAttribute("size",size);
		hbox.appendChild(tb);
		return hbox;
	},
	
	/**
	*
	*/
	createOneRowText : function(id,value,label,params)
	{
		if(typeof params!="undefined")
		{
			if(typeof params.maxlength != "undefined")
				var maxlength = params.maxlength;
			if(typeof params.size != "undefined")
				var size = params.size;
			if(typeof params.type != "undefined")
				var type = params.type;
		}
		var hbox = document.createElement('hbox');
		hbox.setAttribute('id',id+'Container');
		var vbox = this.createLabelWithVBox({value:label,control:id});
		hbox.appendChild(vbox);
		var tb = document.createElement('textbox');
		tb.setAttribute('id',id);
		tb.setAttribute('value',value);
		if(typeof maxlength != "undefined")
			tb.setAttribute("maxlength",maxlength);
		if(typeof size != "undefined")
			tb.setAttribute("size",size);
		if(typeof type != "undefined")
			tb.setAttribute("type",type);
		hbox.appendChild(tb);
		return hbox;
	},
	
	/**
	*
	*/
	createCheckbox : function(id,value,label)
	{
		var cb = document.createElement('checkbox');
		cb.setAttribute('id',id);
		cb.setAttribute('checked',value);
		cb.setAttribute('label',label);
		return cb;
	},
	
	/**
	*
	*/
	addOptionElementToPage : function(optionElement,page)
	{
		var panelName = this.getPanelNameFromPage(page);
		if(panelName != '')
			this.addOptionElementToPanel(optionElement,panelName);
	},
	
	/**
	*
	*/
	addOptionElementToPanel : function(optionElement,panelName)
	{
		var vbox = document.getElementById(panelName+"Vbox");
		vbox.appendChild(optionElement);
	},
	
	/**
	* 
	*/
	saveCheckbox : function(optionId) {
		var cb = document.getElementById(optionId);
		UFUtils.setBoolPref(optionId,cb.checked);
	},
	
	/**
	* 
	*/
	saveNumber : function(optionId) {
		var tb = document.getElementById(optionId);
		val = tb.value;
		UFUtils.setIntPref(optionId,val);
	},
	
	/**
	* 
	*/
	saveOneRowText : function(option) {
		var tb = document.getElementById(option.id);
		val = tb.value;
		if(typeof option.saveParams!='undefined')
			if(typeof option.saveParams.check!='undefined')
			{
				var test = UniFox.Checker.check(val,option.saveParams.check);
				if(!test)
					val = option.defaultValue;
			}
		/*if(typeof option.saveParams!='undefined')//TODO y'a-t-il d'autres types à gérer que les string ?
		{
			if(option.saveParams.type == "int")
				UFUtils.setIntPref(option.id,val);
			else 
				UFUtils.setCharPref(option.id,val);
		}
		else */
			UFUtils.setCharPref(option.id,val);
	},
	/**
	* 
	*/
	saveDropdownlist : function(option) {
		var ddl = document.getElementById(option.id);
		var val = ddl.value;
		var ind = ddl.selectedIndex;
		var saveItem = {index: ind,value:val};
		
		UFUtils.setJSONPref(option.id,saveItem);
	},
	
	/**
	* //TODO terminer ?
	*/
	saveDoubleListBox : function(option) {
		var ddl = document.getElementById(option.id);
	//TODO
		
		//UFUtils.setJSONPref(option.id,saveItem);
	},
	
	/**
	* 
	*/
	saveOption : function(option) {
		switch(option.type)
		{
			case UniFox.OptionsTypes.ONEROWTEXT:
						this.saveOneRowText(option);
						break;
			case UniFox.OptionsTypes.NUMBER:
						this.saveNumber(option.id);
						break;
			case UniFox.OptionsTypes.CHECKBOX:
						this.saveCheckbox(option.id);
						break;
			case UniFox.OptionsTypes.DROPDOWNLIST:
						this.saveDropdownlist(option);
						break;
			case UniFox.OptionsTypes.DOUBLE_LISTBOX:
						this.saveDoubleListBox(option);
						break;
			default:ufLog("can't save Element, uknown UFOptionType ("+option.type+')',UFLog.ERROR);
		}
	},
	/* End of functions to be used by the modules*/
	
	/**
	*
	*/
	getPanelNameFromPage : function(page) {
		switch(page)
		{
			case UniFox.PageTypes.BUILDINGS:
							return "buildings";
			case UniFox.PageTypes.OVERVIEW:
							return "overview";
			case UniFox.PageTypes.LABO:
							return "labo";
			case UniFox.PageTypes.SHIPYARD:
							return "shipyard";
			case UniFox.PageTypes.DEFENSE:
							return "defense";
			case UniFox.PageTypes.MESSAGES:
							return "messages";
			case UniFox.PageTypes.LOGIN:
							return "login";
			case UniFox.PageTypes.NOPAGE:
							return "others";
			default : return "";
		}
	},
	/**
	*
	*/
	getPageFromPanelName : function(panelName) {
		switch(panelName)
		{
			case "buildings":
							return UniFox.PageTypes.BUILDINGS;
			case "overview":
							return UniFox.PageTypes.OVERVIEW;
			case "labo":
							return UniFox.PageTypes.LABO;
			case "shipyard":
							return UniFox.PageTypes.SHIPYARD;
			case "defense":
							return UniFox.PageTypes.DEFENSE;
			case "messages":
							return UniFox.PageTypes.MESSAGES;
			case "login":
							return UniFox.PageTypes.LOGIN;
			case "others":
							return UniFox.PageTypes.NOPAGE;
			default:return -1;
		}
	},
	
	refreshTab : function (tab) 
	{
		
		var panelName = tab.getAttribute('id');
		panelName = panelName.substring(0,panelName.length-3);//on retire "Tab" à la fin
		var page = this.getPageFromPanelName(panelName);
		if(page != -1)
			this.moveOptions(page);
	},
	/**
	*
	*/
	tabsSelectedForOptionsToMove : function(event) 
	{
		var UFO = UniFox.OptionsManager;//"this"!=UFO when in a listener
		var tabs = event.target;
		var tab = tabs.selectedItem;
		UFO.refreshTab(tab);
	},
	/**
	*
	*/
	initOptionsToMove : function() 
	{
		for(var i in UniFox.PageTypes) 
		{
			this.optionsToMove[UniFox.PageTypes[i]] = [];
		}
		var tabss = document.getElementsByTagName("tabs");
		for(var i = 0; i < tabss.length; i++)
			tabss[i].addEventListener('select',this.tabsSelectedForOptionsToMove,false);
	},
	/**
	*
	*/
	addOptionToMove : function(id,page) 
	{
		this.optionsToMove[page].push(id);
	},
	/**
	*
	*/
	moveOptions : function(page) 
	{
		for(var i in this.optionsToMove[page]) 
		{
			this.moveOption(this.optionsToMove[page][i],page);
		}
	},
	/**
	*
	*/
	moveOption : function(id,page) 
	{
		var elem = document.getElementById(id+'Container');
		if(!elem)
			elem = document.getElementById(id);
		var textBoxes = elem.getElementsByTagName('textbox');
		var textBoxesValues = [];
		for(var i = 0; i < textBoxes.length ; i++)
		{
			textBoxesValues.push(textBoxes[i].value);
		}
		this.addOptionElementToPage(elem,page);
		for(var i = 0; i < textBoxes.length ; i++)
		{
			textBoxes[i].value = textBoxesValues[i];
		}
	},
	
	/**
	* 
	*/
	autoSave : function() {
		for(var i in this.optionsToSave)
		{
			this.saveOption(this.optionsToSave[i]);
		}
	},
	
	/**
	* 
	*/
	specialSave : function() {
		//liste des modules
		for(var i =0; i<this.modulesList.length ; i++)
		{
			var checkbox = document.getElementById("Modules"+i);
			this.modulesList[i].enabled = checkbox.checked;
		}
		UFUtils.setJSONPref("Modules",this.modulesList);
		
		this.saveLastUsedPanel();
	},
	
	/**
	* 
	*/
	saveLastUsedPanel : function()
	{
		var tabs = document.getElementById("tabs");
		var index = tabs.selectedIndex;
		UFUtils.setIntPref("LastUsedPanel",index);
	},
	
	/**
	* 
	*/
	loadLastUsedPanel : function()
	{
		var tabs = document.getElementById("tabs");
		var index = UFUtils.getPref("LastUsedPanel",1);
		tabs.selectedIndex = index;
		//this.refreshTab(tabs.selectedItem);
		
	},
	
	/**
	* 
	*/
	unloadModule : function(module) {
		var accept = true;
		accept = module.methods.unload.apply(module.scope,[this]);
		return accept;
	},
	
	/**
	* 
	*/
	unloadModules : function() {
		var accept = true;
		var booltemp = true;
		for(var i in this.modules)
			{
				booltemp = this.unloadModule(this.modules[i]);
				if(booltemp==false)
					accept = false;
			}
		return accept;
	},
	
	/**
	* 
	*/
	runModule : function(module) {
		module.methods.load.apply(module.scope,[this]);
	},
	
	/**
	* 
	*/
	runModules : function() {
		for(var i in this.modules)
			{
				this.runModule(this.modules[i]);
			}
	},
	
	/**
	* Loads the given module to the current context
	* @param moduleName: string, name of the module
	*/
	loadModule : function(moduleName) {
		var location = UFUtils.modulesUrl+moduleName+"/options.js";
		var subscriptLoader = Components.classes["@mozilla.org/moz/jssubscript-loader;1"]
                      .getService(Components.interfaces.mozIJSSubScriptLoader);
		subscriptLoader.loadSubScript(location);
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
	* Called by a module to register itself
	* @param module: object, module
	* @param loadFunction: function, the function to call when the option window is loaded
	* @param unloadFunction: function, the function to call when the option window is unloaded
	*/
	registerModuleOptions : function(module,loadFunction,unloadFunction) {
		this.modules.push(new UniFox.FunctionContext(module,{load:loadFunction,unload:unloadFunction}));
	},
	
	/**
	* 
	*/
	reloadWindow : function() {
		var saveFlag = confirm(UFUtils.getString("options.saveOptionsConfirm"));
		if(saveFlag)
			this.unload();
		window.close();
		window.openDialog("chrome://unifox2/content/options/UniFoxOptions.xul", "", "centerscreen, dialog, chrome, resizable=yes");
		//alert('ok');
	},
	
	/**
	* 
	*/
	updateRemotePrefsCallback : function(args) {
		var label = document.getElementById('LastUpdateLabel');
		var lastUpdateTime = UFUtils.getPref("LastUpdate",0);
		var str = UFUtils.formatDate(lastUpdateTime*1000);
		str = UFUtils.getString("options.lastUpdate",str);
		label.value = str;
		
		this.reloadWindow();
	},
	/**
	* 
	*/
	updateRemotePrefs : function() {
		UFUtils.updateRemotePrefs({scope:UniFox.OptionsManager,callback:UniFox.OptionsManager.updateRemotePrefsCallback});
	},
	
	/**
	* Close window and save preferences
	*/
	addGlobalOptions : function()
	{
		var options = [
			{
				id : "UniFoxEnabled",
				pages : [UniFox.PageTypes.NOPAGE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : UFUtils.getString("options.enableUniFox"),
				autosave : true
			}/*,
			{
				id : "Modules",
				pages : [UniFox.PageTypes.NOPAGE],
				type : UniFox.OptionsTypes.DOUBLE_LISTBOX,
				description : UFUtils.getString("options.modules"),
				loadParams : { values : UFUtils.getJSONPref("Modules",[])},//TODO créer la liste à partir des dossiers 
				
				autosave : true
			}*/
		]
		this.createOptionElements(options);	
		
		var hbox = document.createElement('hbox');
		hbox.setAttribute('id', "LastUpdateContainer");
		var b = document.createElement('button');
		b.setAttribute('label', UFUtils.getString("options.forceUpdate"));
		b.setAttribute('oncommand', "UniFox.OptionsManager.updateRemotePrefs();");
		//b.setAttribute('id', "LastUpdate");
		hbox.appendChild(b);
		
		
		var lastUpdateTime = UFUtils.getPref("LastUpdate",0);
		var str = UFUtils.formatDate(lastUpdateTime*1000);
		str = UFUtils.getString("options.lastUpdate",str);
		
		var d = this.createLabelWithVBox({value:str,id:"LastUpdateLabel"});
		hbox.appendChild(d);
		this.addOptionElementToPage(hbox,UniFox.PageTypes.NOPAGE);
		this.addOptionToMove("LastUpdate",UniFox.PageTypes.NOPAGE);
		
		//liste des modules
		var groupbox = document.createElement('groupbox');
		groupbox.setAttribute('id', "ModulesContainer");
		this.addOptionElementToPage(groupbox,UniFox.PageTypes.NOPAGE);
		this.addOptionToMove("Modules",UniFox.PageTypes.NOPAGE);
		var caption = document.createElement('caption');
		caption.setAttribute('label',UFUtils.getString("options.modules"));
		groupbox.appendChild(caption);
		
		//var moduleList = UFUtils.getJSONPref("Modules",[]);//TODO charger la liste à partir des dossiers ?
		for(var i =0; i<this.modulesList.length ; i++)
		{
			var checkbox = this.createCheckbox("Modules"+i,this.modulesList[i].enabled,this.modulesList[i].name);
			groupbox.appendChild(checkbox);
		}
		
		var hbox = document.createElement('hbox');
		var description = document.createElement('description');
		description.textContent = UFUtils.getString("options.modulesNeedFirefoxRestart");
		description.setAttribute('width','320');
		var button = document.createElement('button');
		button.setAttribute('label',UFUtils.getString("options.restartFirefox"));
		button.addEventListener('command',this.restartFirefoxCommand,false);
		hbox.appendChild(description);
		hbox.appendChild(button);
		groupbox.appendChild(hbox);
		
	},
	
	/**
	* 
	*/
	restartFirefoxCommand : function(event)
	{
		var closeFlag = confirm(UFUtils.getString("options.restartFirefoxConfirm"));
		if(closeFlag)
			if(UniFox.OptionsManager.unload())
				UFUtils.restartApp();
		
	},
	
	
	/**
	* Close window and save preferences
	*/
	unload : function()
	{
		var accept = true;
		this.autoSave();
		this.specialSave();
		accept = this.unloadModules();
		
		//this.saveLastUsedPanel();
		return accept;
	},
	
	load : function()
	{
		this.dialog = document.getElementById("UniFoxOptionsDialog");
		//this.dialog.setAttribute('title',"&unifox2.menu.configure;"+" "+UFUtils.extensionFullName);
		var title = UFUtils.getString("options.options")+" "+UFUtils.extensionFullName;
		this.dialog.setAttribute('title',title);
		//this.dialog.setAttribute('title',"&unifox2.menu.configure;");
		this.inviVbox = document.getElementById('inviVbox');
		this.initOptionsToMove();
		this.loadModules();
		this.runModules();
		this.addGlobalOptions();
		this.loadLastUsedPanel();
	}
}