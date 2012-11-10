UniFox.ReshaperOptions = {
	moduleName : "Reshaper",
		
	/**
	* Entry point
	*/
	load : function(args) {
		this.parent = args[0];

		var bundleURL = UFUtils.modulesLocalesUrl+this.moduleName+"/lang.properties";
		this.bundle = new UniFox.Bundle(bundleURL);

		//var descr = this.bundle.getString("WriteDummySpeaks");
		var options = [
			{
				id : "ReshapeBody",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("ReshapeBody"),
				autosave : true
			},
			{
				id : "ResizeImages",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("ResizeImages"),
				autosave : true
			},
			{
				id : "SizeInPixels",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.NUMBER,
				defaultValue : 20,
				description : this.bundle.getString("SizeInPixels"),
				autosave : true,
				loadParams : { min: 0, max: 150 },
				saveParams : { }
				//saveParams : { check: [UFCheck.NOT_EMPTY,UFCheck.IS_INT], type : "int"}
			},
			{
				id : "AddDescriptionTooltips",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("AddDescriptionTooltips"),
				autosave : true
			},
			{
				id : "AddPriceColor",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("AddPriceColor"),
				autosave : true
			},
			{
				id : "AddThousandSeparatorToShipyard",
				pages : [UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("AddThousandSeparatorToShipyard"),
				autosave : true
			},		
			{
				id : "IncreaseShipyardInputLength",
				pages : [UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : false,
				description : this.bundle.getString("IncreaseShipyardInputLength"),
				autosave : true
			},		
			{
				id : "AddProductionTime",
				pages : [UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("AddProductionTime"),
				autosave : true
			},		
			{
				id : "AddShipyardMaxButton",
				pages : [UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : true,
				description : this.bundle.getString("AddShipyardMaxButton"),
				autosave : true
			}
		];
		
		UniFox.OptionsManager.createOptionElements(options);
	},
	
	unload : function() {
		//tout va bien, on return true
		return true;
	}
}

UniFox.OptionsManager.registerModuleOptions(UniFox.ReshaperOptions,UniFox.ReshaperOptions.load,UniFox.ReshaperOptions.unload);