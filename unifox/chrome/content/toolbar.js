/*var ufBar= {

	bar: function(){return document.getElementById("unifoxBar");},
	
	setDoc: function(docu)
	{
	this.doc=docu;
	},
	
	checkDomain: function()
	{
	if(uf_isUniversDomain(this.doc.location.href) && uf_isSimuUrl(this.doc.location.href) && 1<0)this.show();
	else this.hide();
	},
	
	init: function(docu)
	{
	try{
		this.doc=docu;
		this.checkDomain(this.doc);
		this.doc.addEventListener("focus",uf_checkDomain,true);
		}catch(e){unifoxdebug(e,"bar init",doc);}
	},
	
	switchHS: function()
	{

	if(this.bar().getAttribute("hidden").match('^false$'))this.hide();
	else this.show();
	
	},
	
	show: function()
	{
	if(ufGetBooleanPref("unifoxRECopy",true))//on n'affiche la barre que si l'option simulateur est activée
	this.bar().setAttribute("hidden",false);
	},
	
	hide: function()
	{
	//alert(this.bar());
	this.bar().setAttribute("hidden",true);
	//	alert(this.test);
	},
	
	save: function(player)
	{
	try{
		attacker=new ufReport("last_attacker",new Array(0,0,0,0,0,0,0,0,0,0,0,0,0,0),new Array(0,0,0,0,0,0,0,0,0,0),new Array(0,0,0),new Array(0,0,0),"0:0:0");
		attacker.read(this.doc,"a");
		//alert(this.doc.location.href);
		attacker.save();
		var d=new Date();
		this.bar().ownerDocument.getElementById('unifoxbar_prompter').value=d.getHours()+"h"+d.getMinutes()+" "+d.getSeconds()+"s : OK";
		}catch(e){unifoxdebug(e,"bar init",doc);}
	
	
	}
};

function uf_checkDomain(event)
{
ufBar.setDoc(event.target);
ufBar.checkDomain();
}
*/