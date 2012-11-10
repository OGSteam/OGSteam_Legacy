/**
* The only use of this object is to be registered to UniFox,
* thus enabling UniFox to instantiate the current module
*/

UniFox.DummyModuleFactory = {
	/**
	* Instantiate a new module
	* @param parent: UniFox.PageHandler, the caller
	* @return : UniFox.DummyModule, the new module
	*/
	newDummyModule : function (parent)
	{
		return new UniFox.DummyModule(parent);
	}
}

/**
* The module class itself
*/
UniFox.DummyModule = function (parent) {
	//on garde une référence sur le UniFox.PageHandler qui a instancié le module
	this.parent = parent;
	//cette ligne ajoute tous les attributs du parent sur le module
	//on ne devrait donc plus avoir besoin du parent par la suite
	UFUtils.implement(this,this.parent);
	//on lance les actions du module sur la page
	this.run();
}

UniFox.DummyModule.prototype = {	
	moduleName : "Dummy",
	/**
	* Entry point
	*/
	run : function() {
		//alert('dummy speaks !');
		//this.parent.document.body.innerHTML = 'dummy speaks !';
		if(UFUtils.getPref("WriteDummySpeaks",true))
			this.document.body.innerHTML = '<h1 style="color:white" >dummy speaks !</h1>';
		//this.initOptions();
	}
}

UniFox.browserHandler.registerModule(UniFox.DummyModuleFactory,UniFox.DummyModuleFactory.newDummyModule,[UniFox.PageTypes.OVERVIEW]);