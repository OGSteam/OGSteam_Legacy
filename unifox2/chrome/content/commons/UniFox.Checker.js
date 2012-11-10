if(!UniFox)
	var UniFox = {};

UniFox.Checker = {
	
	types : {
		NOT_EMPTY : 1,
		IS_INT : 2//,
		//ISCOLOR : 4
	},

		/**
	* 
	*/
	checkInt : function(value) {
		try
		{
			var m = value.match(/\d+/);
			if(m == value)
				return true;
			else
				return false;
		} 
		catch(e)
		{
			return false;
		}
	},
	/**
	* 
	*/
	checkNotEmpty : function(value) {
		if(typeof value == "undefined" || value=="")
			return false;
		else
			return true;
	},
	/**
	* 
	*/
	check : function(value,params) {
		for(var i in params) {
			switch(params[i])
			{
				case UniFox.Checker.types.NOT_EMPTY:
							if(this.checkNotEmpty(value)==false)
								return false;
							break;
				case UniFox.Checker.types.IS_INT:
							if(this.checkInt(value)==false);
								return false;
							break;
			}
		}
		return true;
	}

}