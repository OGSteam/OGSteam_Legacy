/**
* The only use of this object is to be registered to UniFox,
* thus enabling UniFox to instantiate the current module
*/
UniFox.ReshaperModuleFactory = {
	/**
	* Instantiate a new module
	* @param parent: UniFox.PageHandler, the caller
	* @return : UniFox.DummyModule, the new module
	*/
	newReshaperModule : function (parent)
	{
		return new UniFox.ReshaperModule(parent);
	}
}

/**
* The module class itself
*/
UniFox.ReshaperModule = function(parent) {
	//on garde une référence sur le UniFox.PageHandler qui a instancié le module
	this.parent = parent;
	//cette ligne ajoute tous les attributs du parent sur le module
	//on ne devrait donc plus avoir besoin du parent par la suite
	UFUtils.implement(this,this.parent);
	//on lance les actions du module sur la page
	this.run();
}

UniFox.ReshaperModule.prototype = {
	moduleName : "Reshaper",
	paths : {
		unitTables : "id('divpage')//table/tbody/tr/td/table/tbody",
		prod : "id('divpage')/form/table/tbody/tr[13]/th/font",
		time : "//select[@name='temps']",
		numSat : "id('divpage')/form/table/tbody/tr[9]/th[1]",
		prodSat : "id('divpage')/form/table/tbody/tr[9]/th[5]"
	},
	resourceNames : ["Titane","Carbone","Tritium","Energie"],
	
	/**
	*
	*/
	getCurrentProd : function()
	{
		var prod = [0,0,0,0];
		var path = this.paths.prod;
		var cells = this.getOrderedSnapshotNodes(path);
		
		for(var i = 0;i<3;i++)
		{
			var cell = cells.snapshotItem(i);
			prod[i] = UFUtils.stripNotDigit(cell.innerHTML);
		}
		
		path = this.paths.numSat;
		var cell = this.getSingleNode(path);
		var numSat = UFUtils.stripNotDigit(cell.innerHTML);
		if(numSat > 0)
		{
			path = this.paths.prodSat;
			cell = this.getSingleNode(path);
			var prodSat = UFUtils.stripNotDigit(cell.innerHTML);
			prod[3] = prodSat/numSat;
		}
		
		return prod;
	},
	
	/**
	*
	*/
	resizeImage : function(img,width,height)
	{
		img.setAttribute("width",width);
		img.setAttribute("height",height);
	},
	/**
	*
	*/
	resizeImageCell : function(cell,size)
	{
		var img = cell.getElementsByTagName('img')[0];
		this.resizeImage(img,size,size);
		var cell = img.parentNode.parentNode;
		cell.style.textAlign = "center";
		cell.style.verticalAlign = "middle";
		cell.removeAttribute('width');
	},
	/**
	*
	*/
	readPrice : function(cell)
	{
		var str = cell.textContent;
		var indexes = [];
		var resources = [];
		for(var i = 0; i < this.resourceNames.length ; i++)
		{
			indexes[i] = str.indexOf(this.resourceNames[i]);
		}
		for(var i = 0; i < this.resourceNames.length ; i++)
		{
			var index1 = indexes[i];
			if(index1 > -1)
			{
				var index2 = -1;
				if(i+1 < this.resourceNames.length)
				{
					for(var j = i+1; j < this.resourceNames.length ; j++)
					{
						if(indexes[j] > -1)
						{
							index2 = indexes[j];
							break;
						}
					}
				}
				if(index2 > -1)
					var strTemp = str.substring(index1,index2);
				else
					var strTemp = str.substring(index1);
				resources[i] = UFUtils.stripNotDigit(strTemp);
			}
			else
				resources[i] = 0;
		}
		return resources;
	},
	
	/**
	*
	*/
	reshape : function(tbody,reshapeBody,resizeImages,size,addTooltips,
						addThousandSeparatorToShipyard,addPriceColor,increaseShipyardInputLength,
						addProductionTime,addShipyardMaxButton)
	{
		var tdtitre = tbody.getElementsByTagName("tr")[0].getElementsByTagName("td")[0];
		var tdimg = tbody.getElementsByTagName("tr")[1].getElementsByTagName("td")[0];
		var tddesc = tbody.getElementsByTagName("tr")[1].getElementsByTagName("td")[1];
		var tdcout = tbody.getElementsByTagName("tr")[2].getElementsByTagName("td")[0];
		var tdordre = tbody.getElementsByTagName("tr")[3].getElementsByTagName("td")[0];
		var tdtemps = tbody.getElementsByTagName("tr")[3].getElementsByTagName("td")[1];
		
		var titre = tdtitre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		var desc = tddesc.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		var ordre = tdordre.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		var cout = tdcout.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		//var temps = tdtemps.innerHTML.replace(/\n/ig,"").replace(/&nbsp;/ig," ");
		
		var imgLink = tdimg.getElementsByTagName("a")[0];
		
		if (addTooltips) {
			var id = "";
			var reg = /(.*)id=([\d]+)(">)(.*)(<\/a>.*)/ig;
			if (reg.test(titre)) {
				id = parseInt(titre.replace(reg,"$2"));
				titre = titre.replace(reg,"$4");	
				this.addTooltip(imgLink,'<table width=100%><tr><td class=c>'+titre.replace(/\'/g, '\\\'')+'</td></tr><tr><td class=l>'+desc.replace(/\'/g, '\\\'')+'</td></tr></table>');
			}
		}
		if(resizeImages)
			this.resizeImageCell(tdimg,size);
		
		if(addThousandSeparatorToShipyard || addShipyardMaxButton)
		{
			titre = tdtitre.innerHTML;
			var reg = /<\/a> \((\d*)\)/i;
			var currentQuantity = titre.match(reg);
			if(currentQuantity)
				currentQuantity = currentQuantity[1];
			currentQuantity = UFUtils.stripNotDigit(currentQuantity);
		}
		if(addThousandSeparatorToShipyard)
		{
			var qty = UFUtils.addThounsandsSeparator(currentQuantity,'&nbsp;');
			titre = titre.replace(reg, "</a> ("+qty+")");
			tdtitre.innerHTML = titre;
		}
	
		// Reduction de l'affichage du temps requis.
		if(reshapeBody)
		{
			//var reg = /(.*)Temps (n\u00E9cessaire):(.*)/ig;
			var temps = tdtemps.textContent;
			
			//TODO: comprendre pourquoi on n'était pas obligé de retirer les document.write dans unifox 1
			var reg = /document.write\(afficheDuree\([^)]*\)\);/i;
			if (reg.test(temps)) {
				temps = temps.replace(reg,"");
			}
			//temps = temps.replace(/<script[^>]*>[^<]*<\/script>/,"");
			
			var reg = /.*:(.*)/ig;
			if (reg.test(temps)) {
				temps = temps.replace(reg, "$1");//alert(tdtemps);
			}
			tdtemps.innerHTML = temps;
		}
		
		if(addPriceColor || addProductionTime || addShipyardMaxButton)
		{
			var price = this.readPrice(tdcout);
		
			var stock = this.getStock();
			var fonts = tdcout.getElementsByTagName('font');
			var j = 0;
			var max = Infinity;
			for(var i = 0;i<4;i++)
			{
				if(price[i] > 0)
				{
					var diff = price[i] - stock[i];
					if(addPriceColor)
					{
						if(diff > 0)
							fonts[j].style.color = "red";
						else 
							fonts[j].style.color = "lime";
						
					}
					if(addProductionTime && (typeof this.production != "undefined"))
					{
						if(diff > 0)
						{
							
							if(i == 3)//sats
							{
								var nbSat = Math.ceil(diff/this.production[i]);
								if(nbSat > 1)
									var satString = this.bundle.getString("Satellites");
								else 
									var satString = this.bundle.getString("Satellite");
								//var satString = this.bundle.getString("Satellite");
								
								var timeString = nbSat+" "+satString;
							}
							else 
							{
								var time = diff*3600*1000/this.production[i];
								if(time!="Infinity")
									var timeString = UFUtils.formatTimespan(time);
								else
									var timeString = time;
							}
							var span = this.document.createElement('span');
							span.innerHTML = " "+timeString;
							span.style.fontSize = "0.9em";
							tdcout.insertBefore(span,fonts[j].parentNode.nextSibling);
						}
					}
					if(addShipyardMaxButton)
					{
						var num = Math.floor(stock[i]/price[i]);
						if(num < max)
							max = num;

					}
					j++;
				}
			}
			if(addShipyardMaxButton)
			{
				//TODO: cas particulier des boucliers
				var titre = tdtitre.innerHTML;
				if(titre.match(/id=10[78]/))
				{	
					if(currentQuantity == 0)
						max = Math.min(max,1);
					else 
						max = 0;
				}
				//TODO?: cas des EMP
			
				var link = this.document.createElement('a');
				link.setAttribute('onclick',"this.parentNode.parentNode.getElementsByTagName('input')[0].value="+max);
				var maxstr = "";
				if(addThousandSeparatorToShipyard)
				{
					maxstr = UFUtils.addThounsandsSeparator(max,'&nbsp;');
					//maxstr = maxstr.replace(/ /g,'&nbsp;');
				}
				link.innerHTML = "max: "+maxstr;
				
				if(reshapeBody)
				{
					var tdmax = this.document.createElement('td');
					tdmax.setAttribute('class','l');
					tdmax.appendChild(link);
				}
				else
					tdordre.appendChild(link);
			}
		}
		
		if(increaseShipyardInputLength)
		{
			var input = tdordre.getElementsByTagName('input')[0];
			input.setAttribute('maxlength',"10");
			input.setAttribute('size',"11");
		}		
		
		//construction de la nouvelle ligne
		var row = null;
		if(reshapeBody)
		{
			row = this.document.createElement('tr');
			
			tdimg.style.verticalAlign = "middle";
			row.appendChild(tdimg);
			
			tdordre.style.verticalAlign = "middle";
			if(this.page == UniFox.PageTypes.BUILDINGS || this.page == UniFox.PageTypes.LABO)
				tdordre.style.width = "120px";
			row.appendChild(tdordre);
			
			if(typeof tdmax!="undefined")
			{
				tdmax.style.verticalAlign = "middle";
				row.appendChild(tdmax);
			}
			
			tdtitre.style.verticalAlign = "middle";
			row.appendChild(tdtitre);
			
			tdcout.style.verticalAlign = "middle";
			row.appendChild(tdcout);
			
			tdtemps.style.verticalAlign = "middle";
			row.appendChild(tdtemps);
			
			
		}
		return row;
	},
	
	/**
	* Entry point
	*/
	run : function() {
			//actions sur le corps de page
			if(this.page == UniFox.PageTypes.BUILDINGS || this.page==UniFox.PageTypes.LABO ||
				this.page == UniFox.PageTypes.SHIPYARD || this.page==UniFox.PageTypes.DEFENSE)
			{
				var bundleURL = UFUtils.modulesLocalesUrl+this.moduleName+"/lang.properties";
				this.bundle = new UniFox.Bundle(bundleURL);
				
				var path = this.paths.unitTables;
				var unitList = this.getOrderedSnapshotNodes(path);
				var resizeImages = UFUtils.getPref("ResizeImages",true);
				var addTooltips = UFUtils.getPref("AddDescriptionTooltips",true);
				var reshapeBody = UFUtils.getPref("ReshapeBody",true);
				var addProductionTime = UFUtils.getPref("AddProductionTime",true);
				if(addProductionTime)
				{
					var productions = UFUtils.getJSONPref("Productions");
					var planet = this.getPlanet();
					this.production = productions[planet.id];
				}
				if(this.page == UniFox.PageTypes.SHIPYARD || this.page==UniFox.PageTypes.DEFENSE)
				{
					var addThousandSeparatorToShipyard = UFUtils.getPref("AddThousandSeparatorToShipyard",true);
					var increaseShipyardInputLength = UFUtils.getPref("IncreaseShipyardInputLength",false);
					var addShipyardMaxButton = UFUtils.getPref("AddShipyardMaxButton",true);
				}
				else 
				{
					var addThousandSeparatorToShipyard = false;
					var increaseShipyardInputLength = false;
				}
				
				var addPriceColor = UFUtils.getPref("AddPriceColor",true);
				
				var size = UFUtils.getPref("SizeInPixels",20);
				if(unitList.snapshotLength > 0)
				{
					if(reshapeBody)
					{
						var oldTable = unitList.snapshotItem(0).parentNode.parentNode.parentNode.parentNode;
						var tableGrandParent = oldTable.parentNode;
						var newTable = this.document.createElement('tbody');
					}
					for(var i = 0; i < unitList.snapshotLength ; i++)
					{
						var tbody = unitList.snapshotItem(i);
						var row = this.reshape(tbody,reshapeBody,resizeImages,size,addTooltips,
												addThousandSeparatorToShipyard,addPriceColor,increaseShipyardInputLength,
												addProductionTime,addShipyardMaxButton);
						if(reshapeBody)
							newTable.appendChild(row);
					}
					if(reshapeBody)
					{
						tableGrandParent.replaceChild(newTable,oldTable);
						tableGrandParent.removeAttribute('width');
						tableGrandParent.style.width = "auto";
					}
				}
			}
			//sauvegarde de la production
			else if(this.page == UniFox.PageTypes.RESOURCES)
			{
				var path = this.paths.time;
				var select = this.getSingleNode(path);
				if(select.value == "3")//production horaire uniquement
				{
					var productions = UFUtils.getJSONPref("Productions");
					var planet = this.getPlanet();
					var currentProd = this.getCurrentProd();
					if(typeof productions[planet.id] !="undefined")
					{
						if(currentProd[3] == 0 && productions[planet.id][3] != 0)
							currentProd[3] = productions[planet.id][3];
					}
					productions[planet.id] = currentProd;
					UFUtils.setJSONPref("Productions",productions);
					
					//ufLog(UFUtils.formatTimespan((new Date()).getTime()));
				}
			}
	}
}

UniFox.browserHandler.registerModule(UniFox.ReshaperModuleFactory,UniFox.ReshaperModuleFactory.newReshaperModule,[UniFox.PageTypes.BUILDINGS,UniFox.PageTypes.LABO,UniFox.PageTypes.SHIPYARD,UniFox.PageTypes.DEFENSE,UniFox.PageTypes.RESOURCES]);