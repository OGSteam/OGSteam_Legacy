if(!UniFox.Modules.Login)
	UniFox.Modules.Login = {};
else
	ufLog("Module Login already exists",UFLog.ERROR);
/**
* The only use of this object is to be registered to UniFox,
* thus enabling UniFox to instantiate the current module
*/
UniFox.Modules.Login.Factory = {
	/**
	* Instantiate a new module
	* @param parent: UniFox.PageHandler, the caller
	* @return : UniFox.DummyModule, the new module
	*/
	newLoginModule : function (parent)
	{
		return new UniFox.Modules.Login.Handler(parent);
	}
}

/**
* The module class itself
*/
UniFox.Modules.Login.Handler = function(parent) {
	//on garde une référence sur le UniFox.PageHandler qui a instancié le module
	this.parent = parent;
	//cette ligne ajoute tous les attributs du parent sur le module
	//on ne devrait donc plus avoir besoin du parent par la suite
	UFUtils.implement(this,this.parent);
	//on lance les actions du module sur la page
	this.run();
}

UniFox.Modules.Login.Handler.prototype = {
	moduleName : "Login",
	paths : {
		login : "//input[@name='login']",
		password : "//input[@name='pass']",
		universe : "//select[@name='Uni']"
	},
	/**
	* 
	*/
	addUniverseToList : function(universe,list) {
		
		var option = this.document.createElement('option');
		option.value = "http://"+universe.url+"/login.php";
		option.innerHTML = universe.name;
		list.appendChild(option);
			
	},
	/**
	* Entry point
	*/
	run : function() {
		var activated = UFUtils.getPref("AutoSelectUniverse",false);
		if(activated)
		{
			var game = UFUtils.getJSONPref("Game",{value:0});
			if(game.value == this.currentServer.index)
			{
				game = this.serverData.servers[game.value];
				var universe = UFUtils.getJSONPref("Universe",{value:1});
				universe = game.universes[universe.value];
				
				var login = UFUtils.getPref("Login","");
				var password = UFUtils.getPref("Password","");
				
				var loginInput = this.getSingleNode(this.paths.login);
				var passwordInput = this.getSingleNode(this.paths.password);
				var uniSelect = this.getSingleNode(this.paths.universe);
				
				//ajout des unis manquant
				if(UFUtils.getPref("DebugMode",UFDebugLevels.NONE) == UFDebugLevels.ALL)
					for(var i in game.missingFromLogin)
					{
						this.addUniverseToList(game.universes[game.missingFromLogin[i]],uniSelect);
					}
				
				
				loginInput.value = login;
				passwordInput.value = password;
				uniSelect.selectedIndex = universe.indexInLogin;
			}
		}
	}
}

UniFox.browserHandler.registerModule(UniFox.Modules.Login.Factory,UniFox.Modules.Login.Factory.newLoginModule,[UniFox.PageTypes.LOGIN]);