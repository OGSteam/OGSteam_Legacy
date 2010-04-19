//création d'un objet ufReport
ufReport =  function(name,ships,defs,technos,res,coord,num)
{
	this.separator0='%%';
	this.pref="unifoxReports";
	//alert(name);
	if(name!="" && typeof(name) !="undefined")this.name=name;
	else name="";
	if(ships)this.ships=ships;
	else {
		this.ships=new Array();
		for(var i=0;i<uf_shipsList.length;i++)this.ships[i]=0;
		}
	if(defs)this.defs=defs;
	else {
		this.defs=new Array();
		for(var i=0;i<uf_defsList.length;i++)this.defs[i]=0;
		}
	if(technos)this.technos=technos;
	else {
		this.technos=new Array();
		for(var i=0;i<uf_technosList.length;i++)this.technos[i]=0;
		}
	if(res)this.res=res;
	else {
		this.res=new Array(uf_resList.length);
		for(var i=0;i<uf_resList.length;i++)this.res[i]=0;
		}
	if(coord!="")this.coord=coord;//chaine
	else this.coord="0:0:0";
	if(num)this.num=num;
	else this.num=-1;

}

ufReport.prototype = {
	
	toString: function()
	{
	var str=this.ships.join(uf_separator2);
	str+=uf_separator1+this.defs.join(uf_separator2);
	str+=uf_separator1+this.technos.join(uf_separator2);
	str+=uf_separator1+this.res.join(uf_separator2);
	str+=uf_separator1+this.coord;
	str+=uf_separator1+this.name;
	str+=uf_separator1+this.num;
	return str;
	},
	
	save: function ()
	{
	var str=this.toString();
	//alert(this.separator0);
	try{var st=PrefsBranchUF.getCharPref(this.pref);}catch(e){st="";}
	if(st==""){var saving=str}
	else
		{
		var tab=st.split(this.separator0);
		var saving="";
		var insert=false;
		for(var i=0;i<tab.length;i++)
			{
			var temp=tab[i].split(uf_separator1);
			if(temp[6]==this.num)//on remplace le rapport existant par le nouveau
				{
				tab[i]=str;
				insert=true;
				//alert('insert: '+this.num);
				}
			}
		if(!insert)tab[i]=str;
		saving=tab.join(this.separator0);
		//alert(saving);
		}
	PrefsBranchUF.setCharPref(this.pref,saving);
	},

	load: function()
	{
	var str="";
	try{var st=PrefsBranchUF.getCharPref(this.pref);}catch(e){st="";}
	//si pas de valeur, génération d'un rapport vide
	if(st=="")
		{
		for(i=0;i<uf_shipsList.length-1;i++)
			str+="0"+uf_separator2;
		str+="0"+uf_separator1;
		for(i=0;i<uf_defsList.length-1;i++)
			str+="0"+uf_separator2;
		str+="0"+uf_separator1;
		for(i=0;i<uf_technosList.length-1;i++)
			str+="0"+uf_separator2;
		str+="0"+uf_separator1;
		for(i=0;i<uf_resList.length-1;i++)
			str+="0"+uf_separator2;
		str+="0"+uf_separator1;
		str+="0:0:0"+uf_separator1;
		str+=""+uf_separator1;//nom vide
		}
	else {
		var tab=st.split(this.separator0);
		var loading="";
		for(var i=0;i<tab.length;i++)
			{
			var temp=tab[i].split(uf_separator1);
			if(temp[6]==this.num)
				{
				loading=tab[i];
				str=loading;
				}
			}
		if(loading==""){
			for(i=0;i<uf_shipsList.length-1;i++)
				str+="0"+uf_separator2;
			str+="0"+uf_separator1;
			for(i=0;i<uf_defsList.length-1;i++)
				str+="0"+uf_separator2;
			str+="0"+uf_separator1;
			for(i=0;i<uf_technosList.length-1;i++)
				str+="0"+uf_separator2;
			str+="0"+uf_separator1;
			for(i=0;i<uf_resList.length-1;i++)
				str+="0"+uf_separator2;
			str+="0"+uf_separator1;
			str+="0:0:0"+uf_separator1;
			str+=""+uf_separator1;;//nom vide
			}
	}
	//alert("loading "+str);
	var tab=str.split(uf_separator1);

	this.ships=tab[0].split(uf_separator2);
	/*for(i=0;i<this.ships.length;i++)
		this.ships[i]=parseInt(this.ships[i]);*/

	this.defs=tab[1].split(uf_separator2);
	/*for(i=0;i<this.defs.length;i++)
		this.defs[i]=parseInt(this.defs[i]);*/

	this.technos=tab[2].split(uf_separator2);
	/*for(i=0;i<this.technos.length;i++)
		this.technos[i]=parseInt(this.technos[i]);*/

	this.res=tab[3].split(uf_separator2);
	/*for(i=0;i<this.res.length;i++)
		this.res[i]=parseInt(this.res[i]);*/

	this.coord=tab[4];
	
	this.name=tab[5];
	//alert("loaded "+this.coord);
	},
	
	readA: function(document)
	{
	//technos
	//alert(document.getElementsByName("aa")[0]);
	this.technos[0]=parseFloat(document.getElementsByName("aa")[0].value);
	this.technos[1]=parseFloat(document.getElementsByName("ba")[0].value);
	this.technos[2]=parseFloat(document.getElementsByName("ca")[0].value);
	//vaisseaux
	for(i=1;i<uf_shipsList.length;i++)
		{
		if(document.getElementsByName("a_"+i)[0])
		this.ships[i-1]=uf_parseInt(document.getElementsByName("a_"+i)[0].value);
		else this.ships[i-1]=0;
		}
		
	//autres
	var inp = document.getElementById('othersA');
	if(inp)
		{
		
		var tab=inp.value.split(uf_separator1);
		this.defs=tab[0].split(uf_separator2);
		//alert(defs.length);
		this.res=tab[1].split(uf_separator2);
		//alert(res.length);
		this.coord=tab[2];
		}
	else{
		}
	},
	
	readD: function(document)
	{
	//technos
	this.technos[0]=parseFloat(document.getElementsByName("ad")[0].value);
	this.technos[1]=parseFloat(document.getElementsByName("bd")[0].value);
	this.technos[2]=parseFloat(document.getElementsByName("cd")[0].value);
	//vaisseaux
	for(i=1;i<uf_shipsList.length;i++)
		{
		if(document.getElementsByName("d_"+i)[0])
			this.ships[i-1]=uf_parseInt(document.getElementsByName("d_"+i)[0].value);
		else this.ships[i-1]=0;
		}
	//defenses
	for(i=1;i<10;i++)
		{
		this.defs[i-1]=uf_parseInt(document.getElementsByName("d_10"+i)[0].value);
		}
	for(i=10;i<uf_defsList.length;i++)
		{
		this.defs[i-1]=uf_parseInt(document.getElementsByName("d_1"+i)[0].value);
		}
	
	//autres
	var inp = document.getElementById('othersD');
	if(inp)
		{
		var tab=inp.value.split(uf_separator1);
		this.res=tab[0].split(uf_separator2);
		this.coord=tab[1];
		}
	else{
		}
	},
	
	writeA: function(document)
	{
	//name
	var inp=document.getElementById("Aname");
	if(inp)inp.value=this.name ? this.name : "";
	//document.getElementById("Aname").value=this.name ? this.name : "";
	//technos
	document.getElementsByName("aa")[0].value=this.technos[0];
	document.getElementsByName("ba")[0].value=this.technos[1];
	document.getElementsByName("ca")[0].value=this.technos[2];
	//vaisseaux
	for(i=1;i<uf_shipsList.length;i++)
		{
		if(document.getElementsByName("a_"+i)[0])
		document.getElementsByName("a_"+i)[0].value=this.ships[i-1];
		}
	//autres
	var inp = document.getElementById('othersA');
	if(inp!=null)
		{
		inp.value = inp.value=this.defs.join(uf_separator2)+uf_separator1+this.res.join(uf_separator2)+uf_separator1+this.coord;
		}
	else{
		inp = document.createElement('input');
		inp.setAttribute('type','hidden');
		inp.setAttribute('id','othersA');
		inp.value = this.defs.join(uf_separator2)+uf_separator1+this.res.join(uf_separator2)+uf_separator1+this.coord;
		document.body.appendChild(inp);
		}
	},
	
	writeD: function(document)
	{
	//name
	var inp=document.getElementById("Dname");
	if(inp)inp.value=this.name ? this.name : "";
	//technos
	document.getElementsByName("ad")[0].value=this.technos[0];
	document.getElementsByName("bd")[0].value=this.technos[1];
	document.getElementsByName("cd")[0].value=this.technos[2];
	//vaisseaux
	for(i=1;i<uf_shipsList.length;i++)
		{
		//alert(typeof(document.getElementsByName("d_"+i)));
		if(document.getElementsByName("d_"+i)[0])
			document.getElementsByName("d_"+i)[0].value=this.ships[i-1];
		}
	//defenses
	for(i=1;i<10;i++)
		{
		document.getElementsByName("d_10"+i)[0].value=this.defs[i-1];
		}
	for(i=10;i<uf_defsList.length;i++)
		{
		document.getElementsByName("d_1"+i)[0].value=this.defs[i-1];
		}
	
	//autres
	var inp = document.getElementById('othersD');
	if(inp!=null)
		{
		inp.value = this.res.join(uf_separator2)+uf_separator1+this.coord;
		}
	else{
		var inp = document.createElement('input');
		inp.setAttribute('type','hidden');
		inp.setAttribute('id','othersD');
		inp.value = this.res.join(uf_separator2)+uf_separator1+this.coord;
		document.body.appendChild(inp);
		}
	},
	
	writeTarget: function(document)
	{
	
	var x=0;
	var tables=document.getElementsByTagName("table");
	for(i=0;i<tables.length;i++)
	{
	if(tables[i].innerHTML.match(/simulation/)){x=i;}
	}
	a=tables[x];
	a=a.getElementsByTagName("tbody")[0];
	var nbgt=0;

	if(document.getElementById('ufTarget'))//si il y avait déjà une cible, on la remplace
		{
			var lines=a.getElementsByTagName("tr");
			lines[0].innerHTML="<td class=\"c\" colspan=\"4\">Cible: "+uf_getCoordLink(this.coord)+"</td>";
			
			
			//on affiche le nombre de GT necessaires
			
			for(i=1;i<uf_resList.length;i++)
			{
			//alert(this.res[i-1]);
			nbgt=nbgt+this.res[i-1];
			}
			nbgt=nbgt/100000;
			if(nbgt<10)nbgt=Math.round(100*nbgt)/100;
			else if(nbgt<100)nbgt=Math.round(10*nbgt)/10;
			else nbgt=Math.round(nbgt);
			
			nbgt=unparseWithThousandsSeparator(nbgt+"",' ');
			var span = document.getElementById('ufGTNumber');
			span.innerHTML = nbgt;
			
			//alert("ok");
			
			row = document.getElementById('ufResList');
			var nb="";
			var strt="";
			var cells = row.getElementByTagName('th');
			for(i=1;i<uf_resList.length;i++)
			{
				strt=""+this.res[i-1]+"";
				//alert(strt);
				nb=unparseWithThousandsSeparator(strt,' ');//on ajoute les espaces entre les milliers
				//st+="<th>"+nb+" "+uf_resList[i]+"</th>";
				//cell = document.createElement('th');
				cells[i].innerHTML = nb+" "+uf_resList[i];
				//row.appendChild(cell);
			}
			/*row = document.getElementById('ufResList2');
			var nb="";
			var strt="";
			var cells = row.getElementByTagName('th');
			for(i=1;i<uf_resList.length;i++)
			{
				strt=""+Math.floor(this.res[i-1]/2)+"";
				//alert(strt);
				nb=unparseWithThousandsSeparator(strt,' ');//on ajoute les espaces entre les milliers
				//st+="<th>"+nb+" "+uf_resList[i]+"</th>";
				//cell = document.createElement('th');
				cells[i].innerHTML = nb+" "+uf_resList[i];
				//row.appendChild(cell);
			}*/
		}
	else{//sinon on la crée
			row = a.firstChild;
			row.setAttribute('id','ufTarget');
			var st="";
			st+="<td class=\"c\" colspan=\"4\">";
			st+="Cible: "+uf_getCoordLink(this.coord);
			st+="</td>";
			
			row.innerHTML = st;
			
			
			
			//on affiche le nombre de GT necessaires

			
			for(i=1;i<uf_resList.length;i++)
			{
				nbgt=nbgt+uf_parseInt(this.res[i-1]);
			}
			nbgt=nbgt/100000;
			if(nbgt<10)nbgt=Math.round(100*nbgt)/100;
			else if(nbgt<100)nbgt=Math.round(10*nbgt)/10;
			else nbgt=Math.round(nbgt);
			
			nbgt=unparseWithThousandsSeparator(nbgt+"",' ');
			st = "GT n\u00E9cessaires: <span id='ufGTNumber' >"+nbgt+"</span>";
			
			
			var row = document.createElement('tr');
			//row.innerHTML = st;
			row.setAttribute('id','ufGTNumberCell');
			//a.insertBefore(row,a.firstChild);
			a.appendChild(row,a.firstChild);
			var cell = document.createElement('td');
			cell.setAttribute('class','c');
			cell.setAttribute('colspan','4');
			cell.innerHTML = st;
			row.appendChild(cell);

			//ressources à quai
			row = document.createElement('tr');
			row.setAttribute('id','ufResList');
			//a.insertBefore(row,a.firstChild);
			a.appendChild(row,a.firstChild);
			
			cell = document.createElement('th');
			//cell.innerHTML = "Ressources \u00E0 quai:";
			cell.innerHTML = "A quai:";
			row.appendChild(cell);
			
			var nb="";
			var strt="";
			for(i=1;i<uf_resList.length;i++)
			{
				strt=""+this.res[i-1]+"";
				//alert(strt);
				nb=unparseWithThousandsSeparator(strt,' ');//on ajoute les espaces entre les milliers
				//st+="<th>"+nb+" "+uf_resList[i]+"</th>";
				cell = document.createElement('th');
				cell.innerHTML = nb+" "+uf_resList[i];
				row.appendChild(cell);
			}
			//moitié
			/*row = document.createElement('tr');
			row.setAttribute('id','ufResList2');
			//a.insertBefore(row,a.firstChild);
			a.appendChild(row,a.firstChild);
			
			cell = document.createElement('th');
			cell.innerHTML = "Pillable:";
			row.appendChild(cell);
			
			var nb="";
			var strt="";
			for(i=1;i<uf_resList.length;i++)
			{
				strt=""+Math.floor(this.res[i-1]/2)+"";
				//alert(strt);
				nb=unparseWithThousandsSeparator(strt,' ');//on ajoute les espaces entre les milliers
				//st+="<th>"+nb+" "+uf_resList[i]+"</th>";
				cell = document.createElement('th');
				cell.innerHTML = nb+" "+uf_resList[i];
				row.appendChild(cell);
			}*/
		
		}
	}
};

/*ufReport.prototype.setShips = function (PT,GT,Ch,ChLa,Freg,Dest,Over,FoNo,Hyp,Coll,So,Ss,Colo,VE)
{
this.ships=new Array(PT,GT,Ch,ChLa,Freg,Dest,Over,FoNo,Hyp,Coll,So,Ss,Colo,VE);
}

ufReport.prototype.setDefs = function (BFG,SBFG,PFC,Def,PFI,AMD,Cdf,Hol,CME,MEMP)
{
this.defs=new Array(BFG,SBFG,PFC,Def,PFI,AMD,Cdf,Hol,CME,MEMP);
}

ufReport.prototype.setTechnos = function (armement,bouclier,blindage)
{
this.technos=new Array(armement,bouclier,blindage);
}

ufReport.prototype.setRes = function (titane,carbone,tritium)
{
this.res=new Array(titane,carbone,tritium);
}

ufReport.prototype.setCoord = function (coord)
{
this.coord=coord;
}*/

//fonction qui lit les ressources du RE situé sous le bouton
function uf_REReadResources(RE)
{
	var res=new Array(0,0,0);
	if(RE.innerHTML.length > 0)
	{
		res=uf_findInRENode(RE.innerHTML,uf_resList);
	}
	for(var i in res)
	{
		//if(!res[i])res[i]=0;
		res[i] = uf_parseInt(res[i]);
		if(isNaN[i])
			res[i]=0;
	}
	return res;
}
function uf_REReadShips(RE)
{

	var ships = [];
	if(RE.innerHTML.length > 0)
	{
		ships=uf_findInRENode(RE.innerHTML,uf_shipsList);
	}
	return ships;
}
//fonction qui lit le RE situé sous le bouton
function uf_RELinkListener(e)
{
//displayproperties_o(e.target);
//doc = e.target.ownerDocument;
//try{
   var link = e.target;
	//alert(link.innerHTML);
	var line = e.target.parentNode.parentNode.nextSibling;
	//var line = e.target.parentNode.parentNode;
	//alert(line.innerHTML);
	var RE = line.firstChild.nextSibling;
	//alert(RE.innerHTML);
	
	var res=new Array();
	var ships=new Array();
	var defs=new Array();
	var technos=new Array();
	var coord="1:1:1";

		if(RE.innerHTML.length > 0)//Si on a un texte selectionne, on regarde son contenu
		{
			//si le texte contient les ressources, c'est un RE
			
			res=uf_findInRENode(RE.innerHTML,uf_resList);
			//alert('ok-1');
			if(res[0]>0 || res[1]>0 || res[2]>0)
			{
			ships=uf_findInRENode(RE.innerHTML,uf_shipsList);
			defs=uf_findInRENode(RE.innerHTML,uf_defsList);
			technos=uf_findInRENode(RE.innerHTML,uf_technosList);
			coord=uf_find_coordNode(RE.innerHTML);

			var selectedufReport=new ufReport("unifoxSpyRepport",ships,defs,technos,res,coord,999);
			//alert("ok0");
			selectedufReport.save();
			//alert("ok1");
			}
			//alert("ok");
		}
/*var temp=e.target;
var temp2=null;
while(temp.innerHTML!=null){temp2=temp;temp=temp.parentNode;}*/
//var a=e.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode;
//temp2=e.target.ownerDocument;
//alert(temp2.location.href);
PrefsBranchUF.setBoolPref("ufLoadRE",true);
e.target.ownerDocument.location.href=e.target.ownerDocument.location.href.replace(/\?action=messages.*/,"?action=simu");

	return;
/*}
catch (e) {
		unifoxdebug(e,"re link listener",doc);
	}*/
}


function uf_findInRENode(str,tab)
{
var i=0;
var strtmp="";
var x=0;
var nb=0;
var retour=new Array();
//alert(tab[0]);

if(str.indexOf(tab[0]))
	{
		for(i=1;i<tab.length;i++)
			{
			retour[i-1]=0;
			
			x=str.indexOf(tab[i]);//"\t"+
			//alert(x);
			if(i<tab.length)y=str.indexOf(tab[i+1]);else y=-1;//on vérifie que si le mot suivant est présent, il est situé après l'actuel
			nb=0;
			if(x!=-1 && (y>x || y==-1))//si on a trouve le mot
				{
				strtmp=str.substring(x);
				z = strtmp.indexOf('</td><td>');
				strtmp=strtmp.substring(z+9);
				a = strtmp.indexOf('</td>');
				strtmp=strtmp.substring(0,a);
				//alert(z+" "+a+" "+strtmp);
				strtmp=strtmp.replace(/\&nbsp\;/g,'');
				nb=uf_parseInt(strtmp);//on cherche sa valeur
				retour[i-1]=nb;
				}
				
				//alert(tab[i]+" "+nb);
			}

	}
	else {

				//si le RE ne contient pas une certaine donnee on retourne un tableau vide

		}
		return retour;
	
}

function uf_find_coordNode(str)
{
var reg=new RegExp("\\[([0-9]{1,2}:[0-9]{1,3}:[0-9]{1,2})\\]</a>","gi");
//var reg=new RegExp("(.[0-9]{1,2}:[0-9]{1,3}:[0-9]{1,2}\]) le","gi");
var str2="0:0:0";
//alert(str);
//alert(str.match(reg));
if(str.match(reg))
{

str2=str.match(reg)
str2=str2[0];
str2=str2.toString();
str2 = str2.replace(reg,"$1");
//alert(str2);
}
return str2;
}


//fonction qui lit la selection
function uf_REListener(e)
{
//doc = e.target.ownerDocument;
//try{
	if ((!e) || ((e.ctrlKey) && (!e.keyCode)))
				return;
	var targetclassname = e.target.toString();

	if(targetclassname.match(/InputElement|SelectElement|OptionElement/i) || targetclassname.match(/object XUL/i))
		return;

	if(e.target.ownerDocument.designMode)
		if(e.target.ownerDocument.designMode.match(/on/i))
			return;

	var str = unifox_getSelection();
	var str2="";
	var res=new Array();
	var ships=new Array();
	var defs=new Array();
	var technos=new Array();
	var coord="1:1:1";
	//alert("ok-1");
		if(str.length > 0)//Si on a un texte selectionne, on regarde son contenu
		{
			str=str.replace(/\r\n/g,"\t");
			//si le texte contient les ressources, c'est un RE
			
			res=uf_findInRE(str,uf_resList);
			//alert('ok-1');
			if(res[0]>0 || res[1]>0 || res[2]>0)
			{
			ships=uf_findInRE(str,uf_shipsList);
			defs=uf_findInRE(str,uf_defsList);
			technos=uf_findInRE(str,uf_technosList);
			coord=uf_find_coord(str);

			var selectedufReport=new ufReport("unifoxSpyRepport",ships,defs,technos,res,coord,999);
			//alert("ok0");
			selectedufReport.save();
			//alert("ok1");
			}
			//alert("ok");
		}
		return;
/*}
catch (e) {
		unifoxdebug(e,"re listener",doc);
	}*/
}


//str est le RE a lire, tab la liste de mots
function uf_findInRE(str,tab)
{
var i=0;
var strtmp="";
var x=0;
var nb=0;
var retour=new Array();
//alert(tab[0]);

if(str.indexOf(tab[0]))
	{
		for(i=1;i<tab.length;i++)
			{
			retour[i-1]=0;
			
			x=str.indexOf(tab[i]);//"\t"+
			if(i<tab.length)y=str.indexOf(tab[i+1]);else y=-1;
			nb=0;
			if(x!=-1 && (y>x || y==-1))//si on a trouve le mot
				{
				strtmp=str.substring(x);
				strtmp=strtmp.split('\t')[1];
				strtmp=strtmp.replace(/ /g,'');
				nb=uf_parseInt(strtmp);//on cherche sa valeur
				retour[i-1]=nb;
				}
				
				//alert(tab[i]+" "+nb);
			}

	}
	else {

				//si le RE ne contient pas une certaine donnee on retourne un tableau vide

		}
		return retour;
	
}

function uf_find_coord(str)
{
var reg=new RegExp("de [a-zA-Z0-9_ -]* (.[0-9]{1,2}:[0-9]{1,3}:[0-9]{1,2}\]) le","gi");
//var reg=new RegExp("(.[0-9]{1,2}:[0-9]{1,3}:[0-9]{1,2}\]) le","gi");
var str2="0:0:0";
//alert(str);
//alert(str.match(reg));
if(str.match(reg))
{

str2=str.match(reg)
str2=str2[0];
str2=str2.toString();
str2 = str2.replace(reg,"$1");
//alert(str2);
}
return str2;
}








function   uf_simuButtonsListener(e)
{//alert(e.target);
//doc = e.target.ownerDocument;
//try{
var id=e.target.getAttribute('id');
var document=e.target.ownerDocument;
var defender, attacker, voidplayer, select;
//alert(id);
switch(id)
	{
	case "sa":
				select=document.getElementById('Aselect');
				name=document.getElementById('Aname');
				//alert(ufReports.reports[select.selectedIndex]);
				ufReports.reports[select.selectedIndex].name=name.value;
				ufReports.reports[select.selectedIndex].readA(document);
				break;
	case "la":
				select=document.getElementById('Aselect');
				//name=document.getElementById('Aname');
				ufReports.reports[select.selectedIndex].writeA(document);
				break;
	case "sd":				
				select=document.getElementById('Dselect');
				name=document.getElementById('Dname');
				ufReports.reports[select.selectedIndex+ufReports.nbreports].name=name.value;
				ufReports.reports[select.selectedIndex+ufReports.nbreports].readD(document);
				break;
	case "ld":
				select=document.getElementById('Dselect');
				//name=document.getElementById('Dname');
				ufReports.reports[select.selectedIndex+ufReports.nbreports].writeD(document);
				ufReports.reports[select.selectedIndex+ufReports.nbreports].writeTarget(document);
				break;
	case "permut"	:
				defender=new ufReport(document.getElementById('Dname').value,null,null,null,null,"",-1);
				defender.readD(document);
				//alert(document.getElementById('Dname').value+" "+defender.name);
				attacker=new ufReport(document.getElementById('Aname').value,null,null,null,null,"",-1);
				attacker.readA(document);
				attacker.writeD(document);
				attacker.writeTarget(document);
				defender.writeA(document);
				break;
	case 'Aselect'://on change le nom de la flotte en fonction du n°
				select=document.getElementById('Aselect');
				document.getElementById('Aname').value=ufReports.reports[select.selectedIndex].name;
				break;
	case 'Dselect'://on change le nom de la flotte en fonction du n°
				select=document.getElementById('Dselect');
				document.getElementById('Dname').value=ufReports.reports[select.selectedIndex+ufReports.nbreports].name;
				break;
	
	default:
			if(e.target.value.match(/^Reset$/))
				{
				voidplayer=new ufReport("",null,null,null,null,"",-1);
				voidplayer.writeD(document);
				voidplayer.writeA(document);
				}
	}
/*}
catch (e) {
		unifoxdebug(e,"simu buttons listener",doc);
	}*/

}


function unparseWithThousandsSeparator(str,separator)
{
try{
var point=str.indexOf('.');
var neg=str.indexOf('-');
var tab=new Array();
var i=0;
var tab3=str.split('.');
//alert(tab3.length+"\n"+str+"\n"+tab3[1]+"\n"+tab3[1].length);
if(tab3.length==1)//si c'est un entier
	{
	for(i=0;i<str.length;i++)
		{
		tab[i]=str.charAt(i);
		}
	var tab2=new Array();
	tab=tab.reverse();
	//alert(tab.join(""));
	var end= neg==0 ? tab.length-1 : tab.length;
	for(i=0;i<end;i++)
		{
		
		//d=Math.floor(i/3);
		if(i%3==0 && i!=0)tab2.push(separator);//tab2[i+d-1]=separator;
		tab2.push(tab[i]);
		//tab2[i+d]=tab[i];
		}
	if(neg>0)tab2.push('-');//on recolle le - si il y en avait un
	
	tab2=tab2.reverse();
	var str2=tab2.join("");
	return str2;
	}
else if(tab3.length==2)//si c'est un float
	{
	//partie entière
	for(i=0;i<tab3[0].length;i++)
		{
		tab[i]=tab3[0].charAt(i);
		}
	var tab2=new Array();
	tab=tab.reverse();
	//alert(tab.join(""));
	var end= neg==0 ? tab.length-1 : tab.length;
	for(i=0;i<end;i++)
		{
		if(i%3==0 && i!=0)tab2.push(separator);//tab2[i+d-1]=separator;
		tab2.push(tab[i]);
		}
	if(neg==0)tab2.push('-');//on recolle le - si il y en avait un	
	tab2=tab2.reverse();
	var str2=tab2.join("");
	
	tab=new Array();
	//partie décimale
	for(i=0;i<tab3[1].length;i++)
		{
		tab[i]=tab3[1].charAt(i);
		}
	tab2=new Array();
	//alert(tab.join(""));
	for(i=0;i<tab.length;i++)
		{
		if(i%3==0 && i!=0)tab2.push(separator);//tab2[i+d-1]=separator;
		tab2.push(tab[i]);
		}
	str2+='.'+tab2.join("");
	
	return str2;	
	}
else return str;//en cas de pbm on retourne quand même l'original

}catch(e){alert('cant add "'+separator+'"\n'+e);}
}

function uf_getCoordLink(str)
{
var tab= str.split(':');
var str2='<a href="index.php?action=flotte&galaxie_g=';

str2+=uf_parseInt(tab[0]);
str2+='&systeme_g=';
str2+=uf_parseInt(tab[1]);
str2+='&planete_g=';
str2+=uf_parseInt(tab[2]);
str2+='&target_mission=attaquer">'+str+'</a>';
return str2;
}


//collection de reports
ufReports = {

	init: function(event)
	{
	this.nbreports=9;
	this.reports=new Array(this.nbreports*2);
	for(var i=0;i<this.reports.length;i++)
		{
		this.reports[i]=new ufReport();
		this.reports[i].num=i;
		this.reports[i].load();
		}

	
	
	},
	
	uninit: function(event)
	{
	//sauvegarde réelle des rapports enregitrés
	for(var i=0;i<this.reports.length;i++)
		{
		this.reports[i].save();
		}
	
	//sauvegarde de l'attaquant et du défenseur
	//alert(doc);
	
		//alert('ok');
	},
	
	uninit2: function(event)
	{
	doc=event.target.ownerDocument ? event.target.ownerDocument : event.target;
	var defender=new ufReport(" ",null,null,null,null,"",998);
	defender.readD(doc);
	defender.save();
	var attacker=new ufReport(" ",null,null,null,null,"",997);
	attacker.readA(doc);
	attacker.save();
	
	}
	/*load: function()
	{
	
	},

	save: function()
	{
	}*/

};

function ufReportsUninit(event)
{
ufReports.uninit(event);
}
function ufReportsUninit2(event)
{
ufReports.uninit2(event);
}