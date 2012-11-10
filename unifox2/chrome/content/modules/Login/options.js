if(!UniFox.Modules.Login)
	UniFox.Modules.Login = {};
else
	ufLog("Module Login already exists",UFLog.ERROR);
UniFox.Modules.Login.Options = {
	moduleName : "Login",
	games : [],
	universes : [],
		
	refreshUniverses : function(event)
	{
		UniFox.Modules.Login.Options.refreshUniverses2(event);
	},
	
	refreshUniverses2 : function(event)
	{
		var gamelist = document.getElementById("Game");
		var selectedGame = gamelist.selectedIndex;
		//ufLog("gamelist.selectedIndex"+gamelist.selectedIndex);
		var unilist = document.getElementById("Universe");
		//ufDir(this.universes[selectedGame]);
		UniFox.OptionsManager.refreshDropdownlist(unilist,this.universes[selectedGame]);
	},
	/**
	* Entry point
	*/
	load : function(args) {
		this.parent = args[0];

		var bundleURL = UFUtils.modulesLocalesUrl+this.moduleName+"/lang.properties";
		this.bundle = new UniFox.Bundle(bundleURL);
		
		var serverData = UFUtils.getServerData();
		
		for(var i in serverData.servers)
		{
			var game = serverData.servers[i];
			this.games.push({label:game.name,value:i});
			this.universes.push([]);
			for(var j in game.universes)
			{
				var universe = game.universes[j];
				this.universes[i].push({label:universe.name,value:j});
			}
		}
		
		var savedGame = UFUtils.getJSONPref("Game",{ index:0, value:0 });
		savedGame = savedGame.value
		//ufLog("savedGame"+savedGame);
		var game = serverData.servers[savedGame];
		if(typeof game == "undefined")
		{
			savedGame = 0;
			game = serverData.servers[0];
		}
		
		var options = [
			{
				id : "AutoSelectUniverse",
				pages : [UniFox.PageTypes.LOGIN],
				type : UniFox.OptionsTypes.CHECKBOX,
				defaultValue : false,
				description : this.bundle.getString("AutoSelectUniverse"),
				autosave : true
			},
			{
				id : "Game",
				pages : [UniFox.PageTypes.LOGIN],
				type : UniFox.OptionsTypes.DROPDOWNLIST,
				defaultValue : 0,
				description : this.bundle.getString("Game"),
				autosave : true,
				loadParams : { values : this.games },
				saveParams : { }
			},
			{
				id : "Universe",
				pages : [UniFox.PageTypes.LOGIN],
				type : UniFox.OptionsTypes.DROPDOWNLIST,
				defaultValue : 0,
				description : this.bundle.getString("Universe"),
				autosave : true,
				loadParams : { values : this.universes[savedGame] },
				saveParams : { }
			},
			{
				id : "Login",
				pages : [UniFox.PageTypes.LOGIN],
				type : UniFox.OptionsTypes.ONEROWTEXT,
				defaultValue : "",
				description : this.bundle.getString("Login"),
				autosave : true,
			},
			{
				id : "Password",
				pages : [UniFox.PageTypes.LOGIN],
				type : UniFox.OptionsTypes.ONEROWTEXT,
				defaultValue : "",
				description : this.bundle.getString("Password"),
				autosave : true,
				loadParams : { type : "password" }
			}
		];
		
		UniFox.OptionsManager.createOptionElements(options);
		
		var menulist = document.getElementById("Game");
		menulist.addEventListener('command',UniFox.Modules.Login.Options.refreshUniverses,false);
	},
	
	unload : function() {
		//tout va bien, on return true
		return true;
	}
}

UniFox.OptionsManager.registerModuleOptions(UniFox.Modules.Login.Options,UniFox.Modules.Login.Options.load,UniFox.Modules.Login.Options.unload);