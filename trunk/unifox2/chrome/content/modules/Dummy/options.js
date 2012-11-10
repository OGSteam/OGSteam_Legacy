UniFox.DummyOptions = {
	moduleName : "Dummy",
	
	
	/**
	* Launched when the pref window is opened
	*/
	load : function(args) {
		this.parent = args[0];
		//this.folder = UFUtils.modulesUrl+this.moduleName;
		var bundleURL = UFUtils.modulesLocalesUrl+this.moduleName+"/lang.properties";
		this.bundle = new UniFox.Bundle(bundleURL);
		//alert('dummy loads !'+this.bundle.getString("test"));
		//alert('dummy loads !'+this.bundle.getString("test2",["titi","tata"])+this.bundle.getString("test3","toto"));
		var descr = this.bundle.getString("WriteDummySpeaks");
		var writeDummySpeaksOption = {
				id : "WriteDummySpeaks",
				pages : [UniFox.PageTypes.OVERVIEW],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : descr,
				autosave : true
			};
		
		UniFox.OptionsManager.createOptionElement(writeDummySpeaksOption);
	},
	
	/**
	* Launched when the pref window is closed
	* @return : bool, returns true if everything is ok, false if closing must abort
	*/
	unload : function() {
		//tout va bien, on return true
		return true;
	}
}

UniFox.OptionsManager.registerModuleOptions(UniFox.DummyOptions,UniFox.DummyOptions.load,UniFox.DummyOptions.unload);