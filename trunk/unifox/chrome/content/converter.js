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
	this.coords = [0,0,0];
	this.technos = new Array('','','');//1 case par techno
	this.units = [new Array(),new Array()];//à deux dimensions, 0 pour le début, 1 pour la fin, puis le n° de l'unité dans la 2e dimension
	this.renta = [new Array(0,0,0,0),new Array(0,0,0,0)];//à deux dimensions, 0 pour sans CDR, 1 pour avec, puis 1 case par ressource + 1 case pour le total*/
	
	for(var i in args)
		{
			this[i] = args[i];
			//eval('this.'+i+' = args.'+i+';');
			//eval('this.'+i+' = typeof args.'+i+' != "undefined" ? args.'+i+' : this.'+i+';');
		}
}
function ufRCunit(args) {
	this.name = '';
	this.price = new Array(0,0,0);
	this.conso = 1;
	this.techno = 0;//0 hyperdrive, 1 impulsion, 2 warp
	this.speed = 1;
	
	for(var i in args)
		{
			this[i] = args[i];
			//eval('this.'+i+' = args.'+i+';');
		}
}

function ufRCconv(args) {
	this.text='';//RC d'entrée
	this.result='';//rapport converti
	this.players=new Array(new ufRCplayer(),new ufRCplayer());//0 pour l'attaquant, 1 pour le défenseur
	this.gain=new Array(-1,-1,-1,-1);//ressources pillées
	this.CDR=new Array(-1,-1,-1,-1);//ressources du CDR
	this.endLoss=new Array(-1,-1);//0 pour l'attaquant, 1 pour le défenseur
	//this.loss=Array();
	this.date='';//chaine de caractère avec la date du RC
	this.units=[new ufRCunit({	name:'Nav.PT-5',		price:[3000,1500,0],			conso:20,		techno:0,	speed:5000}),
				new ufRCunit({	name:'Nav.GT-50',		price:[25000,20000,0],			conso:200,		techno:0,	speed:8000}),
				new ufRCunit({	name:'Chasseur', 		price:[3500,1000,0],			conso:20,		techno:0,	speed:12500}),
				new ufRCunit({	name:'Ch.L', 			price:[7000,5000,0],			conso:75,		techno:1,	speed:10000}),
				new ufRCunit({	name:'Fr\u00E9gate',	price:[22000,10000,3500],		conso:250,		techno:1,	speed:15000}),
				new ufRCunit({	name:'Destroyer',		price:[45000,15000,0],			conso:350,		techno:2,	speed:10000}),
				new ufRCunit({	name:'Overlord',		price:[60000,25000,20000],		conso:750,		techno:2,	speed:3500}),
				new ufRCunit({	name:'F.Noire',			price:[75000,70000,25000],		conso:1000,		techno:2,	speed:5000}),
				new ufRCunit({	name:'Hyperion',		price:[10000000,10000000,2500000],conso:10,		techno:2,	speed:100}),
				new ufRCunit({	name:'Collecteur',		price:[12500,5000,1000],		conso:300,		techno:0,	speed:3000}),
				new ufRCunit({	name:'Sonde',			price:[500,1000,0],				conso:1,		techno:0,	speed:100000000}),
				new ufRCunit({	name:'Sat.Solaire',		price:[0,2500,500],				conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'Colonisateur',	price:[10000,20000,10000],		conso:1000,		techno:1,	speed:2500}),
				new ufRCunit({	name:'Extracteur',		price:[50000,50000,25000],		conso:1000,		techno:1,	speed:500}),
				new ufRCunit({	name:'Frelon',			price:[10000,10000,75000],		conso:-2,		techno:-2,	speed:-2}),//à compléter
				new ufRCunit({	name:'BFG',				price:[3000,0,0],				conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'S.BFG',			price:[2500,1000,0],			conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'P-F.Canon',		price:[7500,3000,0],			conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'D\u00E9flecteurs',price:[20000,15000,2000],		conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'P-F.Ionique',		price:[1500,7500,0],			conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'A.M.D',			price:[60000,35000,30000],		conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'Ch.force',		price:[6000,0,1000],			conso:-1,		techno:-1,	speed:-1}),
				new ufRCunit({	name:'Holochamp',		price:[15000,3000,10000],		conso:-1,		techno:-1,	speed:-1})];//liste des unités
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
						5 :'unités',
						'units' : 'unités',
						6 :'Il emporte ',
						'taking' :'Il emporte ',
						7 :'unités de ',
						'unitsOf' :'unités de ',
						8 :'titane',
						'titan' :'titane',
						9 :'carbone',
						'carbon' :'carbone',
						10 :'tritium',
						'tritium' :'tritium',
						11 :'et',
						'and' :'et',
						12 :'Détruit',
						'destroyed' :'Détruit',
						13 :'Les flottes suivantes se sont affrontées le ',
						'fight' :'Les flottes suivantes se sont affrontées le ',
						14 :'Un champ de débris contenant ',
						'CDR' :'Un champ de débris contenant ',
						15 :' se forme dans l orbite de cette planète.',
						'orbit' :' se forme dans l orbite de cette planète.',
						16 :'Total: ',
						'total' :'Total: ',
						17 :'L\'attaquant a perdu au total ',
						'attackerLoss' :'L\'attaquant a perdu au total ',
						18 :'Le d\u00E9fenseur a perdu au total ',
						'defenderLoss' :'Le défenseur a perdu au total ',
						19 :'Rentabilité',
						'renta' :'Rentabilité',
						20 :'avec/sans recyclage',
						'withOrWithout' :'avec/sans recyclage',
						21 :'Temps de vol',
						'flyingTime' :'Temps de vol',
						22 :'Consommation',
						'consumption' :'Consommation'						
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
						23 : '#FF0000',//détruit
						24 : '#ccffaf',//attaquant
						25 : '#eec263',//défenseur
						};
	this.link="http://forum.e-univers.org/index.php?showtopic=9010";
	
	//options
	this.centerCR = true;
	this.afterBattleMessage = 'après la bataille...';
	this.startText = ''//'DEBUT';
	this.resultText = ''//'RESULTS';
	this.endText = ''//'END';
	this.showTechnos = true;
	this.showCoords = true;
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
	this.flyingTechnos = [0,0,20];//technologies de vol de l'attaquant
	this.showFlyingTime = false;
	this.showConsumption = false;
	this.attackerFlyingTime = 0;
	this.attackerConsumption = 0;
	this.universeSpeed = 10;
	
	for(var i in args)
		{
			this[i] = args[i];
			//eval('this.'+i+' = args.'+i+';');
		}
}
/*functions*/
ufRCconv.prototype.getFlyingSpeed = function() {
	var speed = 1000000000;//10 fois la vitesse des sondes
	var i = 0;
	var p = this.players[0];
	var pUnits = p.units[0];
	for(i in pUnits) {
		if(pUnits[i] > 0 && this.units[i].speed >= 0)
		{
			var shipSpeed =  this.units[i].speed * (this.flyingTechnos[this.units[i].techno]/10+1);
			speed = Math.min(speed,shipSpeed);
		}
	}
	return speed;
}
ufRCconv.prototype.getDistance = function() {
	var coordDelta = 0;
	var distance = 0;
	for(var i =0;i<3;i++) {
		coordDelta = Math.abs(this.players[0].coords[i] - this.players[1].coords[i]);
		if(coordDelta > 0){
			switch(i) {
				case 0:	distance = coordDelta*20000;//galaxies différentes
						break;
				case 1:	distance = coordDelta*95+2700;//systèmes solaire différents
						break;
				case 2:	distance = coordDelta*5+1000;//positions différentes
						break;
			}
			break;
		}
	}
	return distance;
}
ufRCconv.prototype.flyingTime = function() {
	var time = 0;
	
	var minSpeed = this.getFlyingSpeed();
	
	var distance = this.getDistance();
	
	var percent = 100;//[TODO à faire varier??]
	var universeSpeed = this.universeSpeed;//
	
	time = Math.ceil(((35000/(percent/10))*(Math.sqrt(((distance*10)/ minSpeed)))+10)/universeSpeed);
	
	return time;
}
ufRCconv.prototype.setFlyingTime = function() {
	this.attackerFlyingTime = this.flyingTime();
}
ufRCconv.prototype.consumption = function() {
	var universeSpeed = this.universeSpeed;//
	var time = this.attackerFlyingTime;
	var distance = this.getDistance();
	var conso = 0;
	var i = 0;
	var p = this.players[0];
	var pUnits = p.units[0];
	for(i in pUnits) {
		if(pUnits[i] > 0 && this.units[i].speed >= 0)
		{
			var num = pUnits[i];
			var baseConso = this.units[i].conso;
			var shipSpeed =  this.units[i].speed * (this.flyingTechnos[this.units[i].techno]/10+1);
			
			var shipConso = Math.round(num*baseConso*distance/35000*Math.pow((((35000/(time*universeSpeed-10)*Math.sqrt(distance*10/shipSpeed))/10)+1), 2));
			//alert(num+" "+baseConso+" "+shipSpeed+" "+shipConso);
			conso += shipConso;
		}
	}
	
	return conso;
}
ufRCconv.prototype.setConsumption = function() {
	this.attackerConsumption = this.consumption();
}

ufRCconv.prototype.convert = function(args)
{
	for(var i in args)
	{
		this[i] = args[i];
		//eval('this.'+i+' = args.'+i+';');
	}
	if(this.text=='')return this.text;//fin si pas de RC
	
	this.splitedRC = this.text.replace(/\n|\r|\t/g,' ');
	
	this.splitedRC = this.splitedRC.split(/<\/?table[^>]*>/);
	
	var start = this.splitedRC[0];
	var end = this.splitedRC[this.splitedRC.length-1];
	
	this.date = start.substring(start.indexOf(this.lang['fight'])+this.lang['fight'].length);
	this.getFinalData(end);
	this.setPlayers();
	if(this.showFlyingTime || this.showConsumption)
		this.setFlyingTime();
	if(this.showConsumption)
		this.setConsumption();
	if(this.showDetailledRentability || this.showTotalRenta)
		this.setRenta();
	
	this.result=this.createBeginMessage(start)+
				this.createPlayerMessage(0,0)+
				this.createPlayerMessage(1,0);
	//alert(this.result+' |'+this.lang['destroyed']);
	if(this.result.indexOf(this.lang['destroyed']) < 0)
	{
				this.result+=this.createMiddleMessage(this.afterBattleMessage)+
				this.createPlayerMessage(0,1)+
				this.createPlayerMessage(1,1);
	}
	this.result+=this.createEndMessage(end);
	return this.result;
	
}
ufRCconv.prototype.getFinalData = function(str)
{
	//pillage
	//alert(str);
	var ind = str.indexOf(this.lang['taking']);
	if(ind > -1) {
		str = str.substring(ind);
		this.gain[3] = 0;
		for(var i = 0;i<3;i++) {
			ind = str.indexOf(this.lang['units']);
			this.gain[i] = str.substring(0,ind).ufTrimInt();
			this.gain[3] += this.gain[i];
			str = str.substring(ind+this.lang['units'].length);
		}
	//alert(this.gain[3]);
	}
	
	//pertes
	for(var i = 0 ; i < 2 ; i++) {
		ind = str.indexOf(this.lang[17+i]);
		str = str.substring(ind);
		ind = str.indexOf(this.lang['units']);
		this.endLoss[i] = str.substring(0,ind).ufTrimInt();
		str = str.substring(ind+this.lang['units'].length);
	}
	
	//CDR
	ind = str.indexOf(this.lang['CDR']);
	if(ind > -1) {
		str = str.substring(ind);
		this.CDR[3] = 0;
		for(var i = 0;i<3;i++) {
			var ind = str.indexOf(this.lang['units']);
			this.CDR[i] = str.substring(0,ind).ufTrimInt();
			this.CDR[3] += this.CDR[i];
			str = str.substring(ind+this.lang['units'].length);
		}
	//alert(this.CDR[3]);
	}
	
}
ufRCconv.prototype.setPlayer = function(num,generalTable,firstShipTable,lastShipTable)
{
	var p = this.players[num];
	var reg = new RegExp(this.lang[num]+'(.*)\\((.*)\\)');
	var m = generalTable.match(reg);
	if(m)
		{
			p.name = m[1];
			p.coords = m[2];
			p.coords = p.coords.split(":");
		}
	if(num == 0)
		p.ally = this.attackersAlly;
	else if(num == 1)
		p.ally = this.defendersAlly;
	//technos
	for(var i = 0 ; i < 3 ; i++) {
		reg = new RegExp(this.lang[2+i]+'([\\d.]+)%');
		m = generalTable.match(reg);
		if(m)
			p.technos[i] = m[1];
	}
	if(firstShipTable.match(this.lang['destroyed'])) {
		//NO SHIPS
		/*for(var i in this.units) {
			p.units[isStart]
		}*/
		
	}
	else {
		firstShipTable = firstShipTable.split(/<\/?tr[^>]*>/);
		var shipNames = firstShipTable[1].split(/<\/th[^>]*><th[^>]*>/);
		var shipNumbers = firstShipTable[3].split(/<\/th[^>]*><th[^>]*>/);
		for(var i = 1; i < shipNames.length ; i++ ) {
			for(var j in this.units)
				{
					//if(i==1 && j==1)alert(shipNames[i]+' '+this.units[j].name);
					if(shipNames[i].ufStripHTML()==this.units[j].name)
						p.units[0][j]=shipNumbers[i].ufTrimInt();
				}
		}

		for(var j in p.units[0]) {
			p.units[1][j] = 0;//p.units[0][j];
		}
		//alert(lastShipTable)
		if(lastShipTable.match(this.lang['destroyed'])) {
			//alert('NO SHIPS'+lastShipTable);
		}
		else {
			//alert(lastShipTable);
			lastShipTable = lastShipTable.split(/<\/?tr[^>]*>/);
			
			var shipNames = lastShipTable[1].split(/<\/th[^>]*><th[^>]*>/);
			var shipNumbers = lastShipTable[3].split(/<\/th[^>]*><th[^>]*>/);

			for(var i = 1; i < shipNames.length ; i++ ) {
				for(var j in this.units) {
					//if(i==1 && j==1)alert(shipNames[i]+' '+this.units[j].name);
					if(shipNames[i].ufStripHTML()==this.units[j].name)
						p.units[1][j]=shipNumbers[i].ufTrimInt();
				}
			}		
		}
	}
}
ufRCconv.prototype.setRenta = function()
{
	for(var i = 0 ; i < 2 ; i++) {//pour chaque joueur
		var p = this.players[i];
		
		//vaisseaux
		for(var j in p.units[0]) {//pour chaque vaisseau
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[0][k]+=(this.units[j].price[k])*(p.units[1][j]-p.units[0][j]);
			}
		}
		
		//pillage
		if(this.gain[3]!=-1 && i==0)//pour l'attaquant uniquement
			for(var k = 0 ; k < 3 ; k++) {//pour chaque ressource
				p.renta[0][k]+=this.gain[k];
			}
			
		//on copie avant d'ajouter le CDR
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
ufRCconv.prototype.setPlayers = function()
{
	//alert();
	var lastShipTable=new Array();
	if(this.splitedRC[this.splitedRC.length-2].indexOf(this.lang['destroyed']) > -1) {
		lastShipTable[1] = this.splitedRC[this.splitedRC.length-2];
		lastShipTable[0] = this.splitedRC[this.splitedRC.length-5];
	}
	else {
		lastShipTable[1] = this.splitedRC[this.splitedRC.length-3];
		if(this.splitedRC[this.splitedRC.length-6].indexOf(this.lang['destroyed']) > -1) {
			lastShipTable[0] = this.splitedRC[this.splitedRC.length-6];
		}
		else lastShipTable[0] = this.splitedRC[this.splitedRC.length-7];
		
	}
	for(var i = 0 ; i < 2 ; i++) {
		
		if(this.splitedRC.length<8 && i==1) {//pillage
			var generalTable = this.splitedRC[5];
			//alert('generalTable'+generalTable)
			var firstShipTable = generalTable;
			}
		else {
			var generalTable = this.splitedRC[1+i*4];
			var firstShipTable = this.splitedRC[2+i*4];
		}
		//if(lastShipTable.match
		this.setPlayer(i,generalTable,firstShipTable,lastShipTable[i]);
	}
}
ufRCconv.prototype.createBeginMessage = function(str)
{
	var st='';
	if(this.centerCR)st+='[center]';
	if(this.startText!='')st+=this.startText+'\n';
	st+=this.lang['fight']+'[b]'+this.date+'[/b] :\n';
	return st;
}
ufRCconv.prototype.createMiddleMessage = function(str)
{
	return '\n'+str+'\n';
}
ufRCconv.prototype.createEndMessage = function(str)
{
	var st='';
	if(this.resultText!='')st+='\n'+this.resultText;
	/*var thr=[this.threshold];
	var cols=[this.colors[0],this.colors[22]];*/
	//pillage
	if((this.showDetailledGain || this.showTotalGain) && this.gain[3]>-1) {
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
	}
	//pertes
	if(this.showEndLoss) {
		for(var i = 0;i<2;i++) {
			if(this.endLoss[i] > -1) {
				st+='\n'+this.lang[17+i]+this.formatNumber(this.endLoss[i])+' '+this.lang['units']+'.';
			}
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
			
			if(this.recyclingPlayer	== i)
				rIndex = 0;
			else
				rIndex = 1;
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
							st+='\n'+this.lang[8+j]+': '+this.formatNumber(p.renta[rIndex][j]);
					}
				}
			}
			if(this.showTotalRenta) {
				if(this.recyclingPlayer == -1)
					st+='\n'+this.lang['total']+this.formatNumber(p.renta[0][3])+'/'+this.formatNumber(p.renta[1][3]);
				else 
					st+='\n'+this.lang['total']+this.formatNumber(p.renta[rIndex][3]);
			}
		}
	}

	//conso et temps de vol
	if(this.showFlyingTime||this.showConsumption)
		st+= '\n';
	if(this.showFlyingTime)
		st+= '\n'+this.lang['flyingTime']+': [b]'+this.formatTime(this.attackerFlyingTime)+'[/b]';
	if(this.showConsumption)
		st+= '\n'+this.lang['consumption']+': '+this.formatNumber(this.attackerConsumption)+'';
	

	if(this.endText!='')st+='\n'+this.endText;
	st+="\n\n-- [url=http://forum.e-univers.org/index.php?showtopic=9010]Generated by UniFox[/url] --"
	if(this.centerCR)st+='[/center]';
	return st;
}
ufRCconv.prototype.createPlayerMessage = function(num,isStart)
{	
	var st = '\n';
	var p = this.players[num];
	st += this.lang[num];
	if((this.showAttackersName && num == 0) || (this.showDefendersName && num == 1))
		st += '[color='+this.colors[24+num]+']'+p.name+'[/color]';
	if(/*((this.showAttackersAlly && num == 0) || (this.showDefendersAlly && num == 1)) && */(p.ally!=''))
		st += '-'+p.ally+'- ';
	if(this.showCoords) {
		st += '('+p.coords[0]+":"+p.coords[1]+":"+p.coords[2]+')';
	}
	
	
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
	
	if(sum <= 0) {//détruit
		st += '\n[b][color='+this.colors[23]+']'+this.lang['destroyed']+' ![/color][/b]';
	}
	else {//sinon vaisseaux
		for(var i in p.units[isStart]) {
			if(p.units[isStart][i]!=0 || this.showLostUnits)
				st += '\n[color='+this.colors[i]+']'+this.units[i].name+' '+this.ufAddSeparator(p.units[isStart][i])+'[/color]';
			if(this.showLostUnits && isStart==1) {
				var temp = p.units[1][i] - p.units[0][i];
				if(temp!=0)
					st += ' [b][color='+this.colors[22]+']'+this.ufAddSeparator(temp)+'[/color][/b]';
			}
		}
	}
	st += '\n';
	return st;
}
ufRCconv.prototype.formatTime = function(fullTime) {

	var seconds = fullTime;
  var hours = Math.floor(seconds / 3600);
  seconds -= hours * 3600;

  var minutes = Math.floor(seconds / 60);
  seconds -= minutes * 60;

  if (minutes < 10 && fullTime > 3600) minutes = "0" + minutes;
  if (seconds < 10 && fullTime > 60) seconds = "0" + seconds;

  var time = "";
	if(fullTime > 3600)
		time += hours+"h ";
	if(fullTime > 60)
		time += minutes+"min ";
	time += seconds+"s";
	
  return time;
}
ufRCconv.prototype.formatNumber = function(nb/*,thresholds,colors*/) {
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
ufRCconv.prototype.ufAddSeparator = function (str/*,separator*/) {
	var separator = ' ';
	if(arguments.length==2)separator=arguments[1];
	else if(typeof this.separator != 'undefined')separator=this.separator;
	if(separator == '') return str;//si il n'y a pas de séparateur, évite les boucles infinies
	if(separator.match(/\d/)) return str;//si il y a un chiffre, évite les boucles infinies
	str += '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(str)) {
		str = str.replace(rgx, '$1' + separator + '$2');
	}
	return str;
}
/*Array.prototype.toString = function()
	{
		var st='';
		for(var i in this)
			{
				st+=i+':'+this[i]+'| ';
			}
		return st;
	}*/

/*affichage*/
function CRpreview(event) {
	var document = event.target.ownerDocument;
	var str = document.getElementById("formatedReport").value;
	//alert(str);
	if (!str)
	return;

	str = str.replace(/\[img\](http:\/\/\S*)\[\/img\]/g,'<img src="$1"/>');
	str = str.replace(/\[color=([^\]]*)\]/g,'<span style="color:$1">');
	str = str.replace(/\[url=(http:\/\/[^\]]*)\](.*?)\[\/url\]/g,'<a href="$1"/>$2</a>');
	str = str.replace(/\[i\]/g,'<span style="font-style:italic">');
	str = str.replace(/\[b\]/g,'<span style="font-weight:bold">');
	str = str.replace(/\[center\]/g,'<center>');
	str = str.replace(/\[color=([^\]]*)\]/g,'<span style="color:$1">');
	str = str.replace(/(\[\/i\]|\[\/b\]|\[\/color\])/g,'</span>');
	str = str.replace(/\[\/center\]/g,'</center>');
	str = str.replace(/\n/g,"<br/>");
	str +="<br>"
	var obj = document.getElementById("preview");
	obj.innerHTML = str;
	var obj = document.getElementById("note1");
	obj.innerHTML = "Preview";
	var obj = document.getElementById("note0");
	obj.innerHTML = "Preview";

	//f = document.getElementById('crform');
	var bg = true;
	var b;
	var c;
	if (!bg) {
		b = '#ddddff';
		c = '#001144';
	}
	else {
		b = '#1F273C';
		c = '#B0C0DE';
	}
	document.getElementById("message").style.visibility = "visible";
	document.getElementById("preview").style.background = b;
	document.getElementById("preview").style.color = c;
}