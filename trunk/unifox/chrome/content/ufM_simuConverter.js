// ==UserScript==
// @name           simuConverter
// @namespace      e-univers
// @include        http://*.e-univers.org/index.php?action=simu*
// @version	22.17.19.05.2009
// ==/UserScript==

function ufEvalnode(path,document,node) {
	var ret = document.evaluate(path,node,null,
			XPathResult.UNORDERED_NODE_SNAPSHOT_TYPE, null);
	return ret;

}
function ufEval(path,document) {
	return ufEvalnode(path,document,document);
}

/*utils*/
String.prototype.ufTrimInt = function() {
	string = this.replace(/\D/g,'');
	return string ? parseInt(string) : 0;
}
String.prototype.ufStripHTML = function() {
	return this.replace(/<[^>]*>/g,'');
}
String.prototype.ufFirstUpperCase = function() {
	return this.substring(0,1).toUpperCase()+this.substring(1);
}

/*constructors*/
function ufRCplayer(args) {
	this.name = '';
	this.ally = '';
	this.coords = '';
	this.technos = new Array('','','');//1 case par techno
	this.units = [new Array(),new Array()];//\u00E9 deux dimensions, 0 pour le d\u00E9but, 1 pour la fin, puis le n\u00E9 de l'unit\u00E9 dans la 2e dimension
	this.renta = [new Array(0,0,0,0),new Array(0,0,0,0)];//\u00E9 deux dimensions, 0 pour sans CDR, 1 pour avec, puis 1 case par ressource + 1 case pour le total*/
	this.loss = [new Array(0,0,0,0),new Array(0,0,0,0)];//\u00E9 deux dimensions, 0 pour le tout, 1 pour seulement la flotte, puis 1 case par ressource + 1 case pour le total*/
	
	for(var i in args)
		{
			eval('this.'+i+' = args.'+i+';');
			//eval('this.'+i+' = typeof args.'+i+' != "undefined" ? args.'+i+' : this.'+i+';');
		}
}
function ufRCunit(args) {
	this.name = '';
	this.price = new Array(0,0,0);
	
	for(var i in args)
		{
			eval('this.'+i+' = args.'+i+';');
		}
}

function SimuConverter(args) {
	//this.text='';//RC d'entr\u00E9e
	this.result='';//rapport converti
	this.players=new Array(new ufRCplayer(),new ufRCplayer());//0 pour l'attaquant, 1 pour le d\u00E9fenseur
	this.gain=new Array(-1,-1,-1,-1);//ressources pill\u00E9es
	this.CDR=new Array(0,0,0,-1);//ressources du CDR
	this.endLoss=new Array(-1,-1);//0 pour l'attaquant, 1 pour le d\u00E9fenseur
	//this.loss=Array();
	this.date='';//chaine de caract\u00E9re avec la date du RC
	this.units={
						0:new ufRCunit({name:'Nav.PT-5',price:new Array(3000,1500,0)}),
						1:new ufRCunit({name:'Nav.GT-50',price:new Array(25000,20000,0)}),
						2:new ufRCunit({name:'Chasseur',price:new Array(3500,1000,0)}),
						3:new ufRCunit({name:'Ch.L',price:new Array(7000,5000,0)}),
						4:new ufRCunit({name:'Fr\u00E9gate',price:new Array(22000,10000,3500)}),
						5:new ufRCunit({name:'Destroyer',price:new Array(45000,15000,0)}),
						6:new ufRCunit({name:'Overlord',price:new Array(60000,25000,20000)}),
						7:new ufRCunit({name:'F.Noire',price:new Array(75000,70000,25000)}),
						8:new ufRCunit({name:'Hyperion',price:new Array(10000000,10000000,2500000)}),
						9:new ufRCunit({name:'Collecteur',price:new Array(12500,5000,1000)}),
						10:new ufRCunit({name:'Sonde',price:new Array(500,1000,0)}),
						11:new ufRCunit({name:'Sat.Solaire',price:new Array(0,2500,500)}),
						12:new ufRCunit({name:'Colonisateur',price:new Array(10000,20000,10000)}),
						13:new ufRCunit({name:'Extracteur',price:new Array(50000,50000,25000)}),
						14:new ufRCunit({name:'Frelon',price:new Array(10000,10000,75000)}),
						15:new ufRCunit({name:'BFG',price:new Array(3000,0,0)}),
						16:new ufRCunit({name:'S.BFG',price:new Array(2500,1000,0)}),
						17:new ufRCunit({name:'P-F.Canon',price:new Array(7500,3000,0)}),
						18:new ufRCunit({name:'D\u00E9flecteurs',price:new Array(20000,15000,2000)}),
						19:new ufRCunit({name:'P-F.Ionique',price:new Array(1500,7500,0)}),
						20:new ufRCunit({name:'A.M.D',price:new Array(60000,35000,30000)}),
						21:new ufRCunit({name:'Ch.force',price:new Array(6000,0,1000)}),
						22:new ufRCunit({name:'Holochamp',price:new Array(15000,3000,10000)})
						};//liste des unit\u00E9s
	this.lang={
						0 :'Attaquant',
						'attacker' :'Attaquant',	
						1 :'Defenseur',
						'defender' :'Defenseur',
						2 :'Armes: ',
						'weapons' :'Armes: ',
						3 :'Bouclier: ',
						'shield' :'Bouclier: ',
						4 :'Coque: ',
						'structure' :'Coque: ',
						5 :'unit\u00E9s',
						'units' : 'unit\u00E9s',
						6 :'Il emporte ',
						'taking' :'Il emporte ',
						7 :'unit\u00E9s de ',
						'unitsOf' :'unit\u00E9s de ',
						8 :'titane',
						'titan' :'titane',
						9 :'carbone',
						'carbon' :'carbone',
						10 :'tritium',
						'tritium' :'tritium',
						11 :'et',
						'and' :'et',
						12 :'D\u00E9truit',
						'destroyed' :'D\u00E9truit',
						13 :'R\u00E9sultat de la simulation du ',
						'intro' :'R\u00E9sultat de la simulation du ',
						14 :'Un champ de d\u00E9bris contenant ',
						'CDR' :'Un champ de d\u00E9bris contenant ',
						15 :' se forme dans l orbite de cette plan\u00E9te.',
						'orbit' :' se forme dans l orbite de cette plan\u00E9te.',
						16 :'Total: ',
						'total' :'Total: ',
						17 :'L\'attaquant a perdu ',
						'attackerLoss' :'L\'attaquant a perdu ',
						18 :'Le d\u00E9fenseur a perdu ',
						'defenderLoss' :'Le d\u00E9fenseur a perdu ',
						19 :'Rentabilit\u00E9',
						'renta' :'Rentabilit\u00E9',
						20 :'avec/sans recyclage',
						'withOrWithout' :'avec/sans recyclage'
						};

	this.colors={//TODO: ajouter les couleurs pour fond clair
						0 : '#ff9900',//Nav.PT-5
						1 : '#00ff00',//Nav.GT-50
						2 : '#33ff99',//Chasseur
						3 : '#FF00FF',//Ch.L
						4 : '#00FFFF',//Fr\u00E9gate
						5 : '#FFCC00',//Destroyer
						6 : '#0099FF',//Overlord
						7 : '#EEC273',//F.Noire
						8 : '#FF0099',//Hyperion
						9 : '#00FF99',//Collecteur
						10 : '#00B0B0',//Sonde
						11 : '#B000B0',//Sat.Solaire
						12 : '#A099FF',//Colonisateur
						13 : '#99FF99',//Extracteur
						14 : '#FF99A0',//BFG
						15 : '#99FFA0',//S.BFG
						16 : '#99A0FF',//P-F.Canon
						17 : '#9900FF',//D\u00E9flecteurs
						18 : '#CCFFCC',//P-F.Ionique
						19 : '#FFCC99',//A.M.D
						20 : '#FF3333',//Ch.force
						21 : '#FF9900',//Holochamp
						22 : '#FF0000',//pertes
						23 : '#FF0000',//d\u00E9truit
						24 : '#ccffaf',//attaquant
						25 : '#eec263',//d\u00E9fenseur
						};
	this.link="http://forum.e-univers.org/index.php?showtopic=9010";
	
	//options
	this.centerCR = true;
	this.afterBattleMessage = 'apr\u00E9s la bataille...';
	this.startText = ''//'DEBUT';
	this.resultText = ''//'RESULTS';
	this.endText = ''//'END';
	this.showTechnos = true;
	this.showCoords = false;
	this.showAttackersName = true;
	this.showDefendersName = true;
	/*this.showAttackersAlly = true;
	this.showDefendersAlly = true;*/
	this.attackersAlly = '';
	this.defendersAlly = '';
	this.showLostUnits = true;
	this.showTotalRenta = true;
	this.showTotalGain = true;
	this.showTotalCDR = true;
	this.showEndLoss = true;
	//this.showRentability = true;
	this.showDetailledRentability = true;
	this.showDetailledCDR = true;
	this.showDetailledGain = true;
	this.recyclingPlayer = -1;//-1 inconnu, 0 attaquant, 1 defenseur
	this.separator = ' ';
	this.thresholds = [100000,10000000,1000000000];
	this.formatColors = ['#d5d560'/*jaune pale*/,'#ffd910'/*jaune plus vif*/,'#ffa320'/*orange*/,'#ff0000'/*rouge*/];
	
	for(var i in args)
		{
			eval('this.'+i+' = args.'+i+';');
		}
}
/*functions*/
SimuConverter.prototype.convert = function(args)
{
	for(var i in args)
	{
		eval('this.'+i+' = args.'+i+';');
	}

	/*this.getFinalData(end);*/
	this.setPlayers();
	/*if(this.showDetailledRentability || this.showTotalRenta)*/
	this.setRenta();
	
	this.result=this.createBeginMessage()+
				this.createPlayerMessage(0,0)+
				this.createPlayerMessage(1,0);
	//alert(this.result+' |'+this.lang['destroyed']);
	/*if(this.result.indexOf(this.lang['destroyed']) < 0)
	{*/
				this.result+=this.createMiddleMessage(this.afterBattleMessage)+
				this.createPlayerMessage(0,1)+
				this.createPlayerMessage(1,1);
	/*}*/
	this.result+=this.createEndMessage();
	return this.result;
	
}
SimuConverter.prototype.setPlayer = function(num) {
	var p = this.players[num];
	
	if(num == 0) {
		p.name = 'Nomdelattaquant';
		p.ally = this.attackersAlly;
		p.coords = 'Coordonn\u00E9esdelattaquant';
		
		//technos
		p.technos[0]=parseFloat(document.getElementsByName("aa")[0].value);
		p.technos[1]=parseFloat(document.getElementsByName("ba")[0].value);
		p.technos[2]=parseFloat(document.getElementsByName("ca")[0].value);
		
		//units
		for(var i = 0 ; i < 14 ; i++) {//ships
			var inputs = document.getElementsByName("a_"+(i+1));
		//alert(inputs.length);
			//alert(input.value);
			if(inputs.length>0) {
				p.units[0][i] = inputs[0].value.ufTrimInt();
				var cell = inputs[0].parentNode.nextSibling;
				while(!cell.innerHTML)
					cell = cell.nextSibling;
				p.units[1][i] = cell.innerHTML.ufTrimInt();
			}
		}
		/*for(var i = 101 ; i <= 110 ; i++) {//defense
		}*/
		//p.units[0][j]=shipNumbers[i].ufTrimInt();
	}
	else if(num == 1) {
		p.name = 'Nomdud\u00E9fenseur';
		p.ally = this.defendersAlly;
		p.coords = 'Coordonn\u00E9esdud\u00E9fenseur';
		
		//technos
		p.technos[0]=parseFloat(document.getElementsByName("ad")[0].value);
		p.technos[1]=parseFloat(document.getElementsByName("bd")[0].value);
		p.technos[2]=parseFloat(document.getElementsByName("cd")[0].value);
		
		//units
		for(var i = 0 ; i < 14 ; i++) {//ships
			var inputs = document.getElementsByName("d_"+(i+1));
			if(inputs.length>0) {
				p.units[0][i] = inputs[0].value.ufTrimInt();
				var cell = inputs[0].parentNode.nextSibling;
				while(!cell.innerHTML)
					cell = cell.nextSibling;
				p.units[1][i] = cell.innerHTML.ufTrimInt();
			}
		}
		for(var i = 14 ; i < 22 ; i++) {//defense
			var inputs = document.getElementsByName("d_"+(i+87));
			if(inputs.length>0) {
				p.units[0][i] = inputs[0].value.ufTrimInt();
				var cell = inputs[0].parentNode.nextSibling;
				while(!cell.innerHTML)
					cell = cell.nextSibling;
				p.units[1][i] = cell.innerHTML.ufTrimInt();
			}
		}
	}
	
	for(var j in p.units[0]) {//pour chaque vaisseau
		for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
			p.loss[0][k]+=(this.units[j].price[k])*(p.units[0][j]-p.units[1][j]);
			if(j<=13) {
				p.loss[1][k]+=(this.units[j].price[k])*(p.units[0][j]-p.units[1][j]);
			}
		}
	}
	for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
		p.loss[0][3]+=p.loss[0][k];
		p.loss[1][3]+=p.loss[1][k];
	}
}
SimuConverter.prototype.setRenta = function()
{
	//calcul du CDR
	for(var i = 0 ; i < 2 ; i++) {//pour chaque joueur
		var p = this.players[i];
		for(var k = 0 ; k < 4 ; k++) {//pour chaque ressource
				this.CDR[k] += p.loss[1][k]*0.35; 
			}
	}
	
	for(var i = 0 ; i < 2 ; i++) {//pour chaque joueur
		var p = this.players[i];
		
		//vaisseaux
		//for(var j in p.units[0]) {//pour chaque vaisseau
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[0][k]-=p.loss[0][k];
			}
		//}
		
		//pillage
		/*if(this.gain[3]!=-1 && i==0)//pour l'attaquant uniquement
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[0][k]+=this.gain[k];
			}
			*/
		
		for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[1][k]+=p.renta[0][k];
			}
		//CDR
		if(this.CDR[3]!=-1)
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[0][k]+=this.CDR[k];
			}
		
		//total
		for(var j = 0 ; j < 2 ; j++)//avec ou sans
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[j][3] += p.renta[j][k];
			}
		//alert(p.name+' '+p.renta[0][3]);
	}	
}
SimuConverter.prototype.setPlayers = function()
{
	for(var i = 0 ; i < 2 ; i++) {
		this.setPlayer(i);
	}
}

SimuConverter.prototype.createBeginMessage = function(str)
{
	var st='';
	if(this.centerCR)st+='[center]';
	if(this.startText!='')st+=this.startText+'\n';
	var d = new Date();
	st+=this.lang['intro']+'[b]'+
		d.getDate()+'/'+(d.getMonth()+1)+'/'+d.getFullYear()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds()+
		'[/b] :\n';
	return st;
}
SimuConverter.prototype.createMiddleMessage = function(str)
{
	return '\n'+str+'\n';
}
SimuConverter.prototype.createEndMessage = function(str)
{
	var st='';
	if(this.resultText!='')st+='\n'+this.resultText;
	/*var thr=[this.threshold];
	var cols=[this.colors[0],this.colors[22]];*/
	//pillage//pas de pillage dans une simulation
	/*if((this.showDetailledGain || this.showTotalGain) && this.gain[3]>-1) {
		st+='\n'+this.lang['taking'];
		if(this.showTotalGain && !this.showDetailledGain) {
			st+=this.formatNumber(this.gain[3])+' '+this.lang['units']+'.';
		}
		else {
			if(this.showDetailledGain) {
				for(var i=0;i<3;i++) {
					st+=this.formatNumber(this.gain[i])+' '+this.lang['unitsOf']+this.lang[i+8];
					if(i==0)st+=', ';
					if(i==1)st+=' '+this.lang['and']+' ';
					if(i==2)st+='.';
				}
			}
			if(this.showTotalGain)
			st+='\n'+this.lang['total']+this.formatNumber(this.gain[3]);
		}
	}*/
	//pertes
	if(this.showEndLoss) {
		for(var i = 0;i<2;i++) {//pour chaque joueur
			st+='\n'+this.lang[17+i];
			var p = this.players[i];
			for(var k=0;k<3;k++) {
					st+=this.formatNumber(p.loss[0][k])+' '+this.lang['unitsOf']+this.lang[i+8];
					if(k==0)st+=', ';
					if(k==1)st+=' '+this.lang['and']+' ';
					if(k==2)st+='.';
			}
			st+='\n'+this.lang['total']+this.formatNumber(p.loss[0][3]);
		}
	}
	//CDR
	if((this.showDetailledCDR || this.showTotalCDR) && this.CDR[3]>-1) {
		st+='\n'+this.lang['CDR'];
		if(this.showTotalCDR && !this.showDetailledCDR) {
			st+=this.formatNumber(this.CDR[3])+' '+this.lang['units']+this.lang['orbit'];
		}
		else {
			if(this.showDetailledCDR) {
				for(var i=0;i<3;i++) {
					st+=this.formatNumber(this.CDR[i])+' '+this.lang['unitsOf']+this.lang[i+8];
					if(i==0)st+=', ';
					if(i==1)st+=' '+this.lang['and']+' ';
					if(i==2)st+=this.lang['orbit'];
					}
			}
			if(this.showTotalCDR)
				st+='\n'+this.lang['total']+this.formatNumber(this.CDR[3]);
		}
	}
	//renta
	if(this.showDetailledRentability || this.showTotalRenta)
	{
		st+='\n\n[b]'+this.lang['renta'];
		if(this.recyclingPlayer == -1)
			st+=' '+this.lang['withOrWithout'];
		st+='[/b]';
		for(var i = 0;i<2;i++) {
			st+='\n[b]'+this.lang[i]+'[/b]';
			if(this.recyclingPlayer == i)
				st+=' (recycle)';
			var p = this.players[i];
			if(this.showDetailledRentability) {
				if(this.recyclingPlayer == -1) {
					for(var j = 0; j<3 ; j++) {
						st+='\n'+this.lang[8+j].ufFirstUpperCase()+': '+this.formatNumber(p.renta[0][j])+'/'+this.formatNumber(p.renta[1][j]);
					}
				}
				else {
					for(var j = 0; j<3 ; j++) {
						//alert((this.recyclingPlayer+i)%2);
						//si p=0 et r=0, i = 0 
						//si p=0 et r=1, i = 1
						//si p=1 et r=0, i = 1
						//si p=1 et r=1, i = 0						
						st+='\n'+this.lang[8+j]+': '+this.formatNumber(p.renta[(this.recyclingPlayer+i)%2][j]);
					}
				}
			}
			if(this.showTotalRenta) {
				if(this.recyclingPlayer == -1)
					st+='\n'+this.lang['total']+this.formatNumber(p.renta[0][3])+'/'+this.formatNumber(p.renta[1][3]);
				else 
					st+='\n'+this.lang['total']+this.formatNumber(p.renta[(this.recyclingPlayer+i)%2][3]);
			}
		}
	}
	if(this.endText!='')st+='\n'+this.endText;
	st+="\n\n-- [url=http://jormund.free.fr/e-univers/simuConverter.user.js]Generated by simuConverter[/url] --"
	if(this.centerCR)st+='[/center]';
	return st;
}
SimuConverter.prototype.createPlayerMessage = function(num,isStart)
{	
	//alert(num+" "+isStart);
	var st = '\n';
	var p = this.players[num];
	st += this.lang[num];
	if((this.showAttackersName && num == 0) || (this.showDefendersName && num == 1))
		st += ' [color='+this.colors[24+num]+']'+p.name+'[/color] ';
	if(/*((this.showAttackersAlly && num == 0) || (this.showDefendersAlly && num == 1)) && */(p.ally!=''))
		st += '-'+p.ally+'- ';
	if(this.showCoords)
		st += '('+p.coords+')';
	if(this.showTechnos && isStart==0) {
		st += '\n'
		for(var i = 0 ; i < 3 ; i++) {
			if(p.technos[i]!='')
				st += this.lang[2+i]+'[b]'+p.technos[i]+'%[/b] ';
		}
	}
	
	var sum = 0;
	for(var i in p.units[isStart]) {
		sum += p.units[isStart][i];
	}
	
	if(sum <= 0) {//d\u00E9truit
		st += '\n[b][color='+this.colors[23]+']'+this.lang['destroyed']+' ![/color][/b]';
	}
	else {//sinon vaisseaux
		for(var i in p.units[isStart]) {
			//alert(p.units[isStart][i]+' '+this.units[i].name+' '+(p.units[isStart][i]!=0 || this.showLostUnits));
			if(p.units[isStart][i]!=0 || ( this.showLostUnits && isStart==1 && p.units[0][i]!=0))
				st += '\n[color='+this.colors[i]+']'+this.units[i].name+' '+this.ufAddSeparator(p.units[isStart][i])+'[/color]';
			if(this.showLostUnits && isStart==1) {
				var temp = p.units[1][i] - p.units[0][i];
				if(temp!=0)
					st += ' [b][color='+this.colors[22]+']'+this.ufAddSeparator(temp)+'[/color][/b]';
			}
		}
	}
	//alert(st);
	st += '\n';
	return st;
}
SimuConverter.prototype.formatNumber = function(nb/*,thresholds,colors*/) {
	var str='';
	for(var i=0;i<this.thresholds.length;i++)
		{//alert(nb+ ' '+thresholds[i]);
			if(nb<this.thresholds[i])
				{
				str='[b][color='+this.formatColors[i]+']';
				break;
				}
		}
	if(str=='')str='[b][color='+this.formatColors[i]+']';
	str+=this.ufAddSeparator(nb);
	str+='[/color][/b]';
	return str;
}
SimuConverter.prototype.ufAddSeparator = function (str/*,separator*/) {
	var separator = ' ';
	if(arguments.length==2)separator=arguments[1];
	else if(typeof this.separator != 'undefined')separator=this.separator;
	if(separator == '') return str;//si il n'y a pas de s\u00E9parateur, \u00E9vite les boucles infinies
	str += '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(str)) {
		str = str.replace(rgx, '$1' + separator + '$2');
	}
	return str;
}


var table=ufEval("id('divpage')/form/table[1]/tbody/tr/td[2]/table/tbody",document);
table=table.snapshotItem(0);
var line = document.createElement('tr');
table.appendChild(line);
var cell = document.createElement('td');
cell.setAttribute('colspan','4');
line.appendChild(cell);
var resultArea = document.createElement('textarea');
resultArea.setAttribute('id','formatedReport');
cell.appendChild(resultArea);


var converter = new SimuConverter();
var RC = converter.convert();
resultArea.value = RC;