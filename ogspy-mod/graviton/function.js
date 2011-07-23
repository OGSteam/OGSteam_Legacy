function upgrade_bat(bat,level,res,planete){
 var ressources=0;
 var niv=0;
 switch(bat) {
	case "CES" :
	niv=parseFloat(batimentsOGSpy[planete][2]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources +=Math.round( 75 * Math.pow(1.5,(niv-1)));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources +=Math.round( 30 * Math.pow(1.5,(niv-1)));
			niv++;
		}
		break;	
	}
 	break;
	case "CEF" :
	niv=parseFloat(batimentsOGSpy[planete][3]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources +=Math.round( 900 * Math.pow(1.5,(niv-1)));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources +=Math.round( 360 * Math.pow(1.5,(niv-1)));
			niv++;
		}
		break;
		case "D":
		while (niv<=level){
			ressources +=Math.round( 180 * Math.pow(1.5,(niv-1)));
			niv++;
		}
		break;		
	}
	break;
	case "UdR" :
	niv=parseFloat(batimentsOGSpy[planete][8]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources += 400 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources += 120 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "D":
		while (niv<=level){
			ressources += 200 * Math.pow(2,(niv-1));
			niv++;
		}
		break;	
	}
	break;
	case "UdN" :
	niv=parseFloat(batimentsOGSpy[planete][4]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources += 1000000 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources += 500000 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "D":
		while (niv<=level){
		ressources += 100000 * Math.pow(2,(niv-1));
		niv++;
		}
		break;	
	}
	break;
	case "CSp" :
	niv=parseFloat(batimentsOGSpy[planete][5]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources += 400 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources += 200 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "D":
		while (niv<=level){
			ressources += 100 * Math.pow(2,(niv-1));
			niv++;
		}
		break;	
	}		
	break;
	case "Lab" :
	niv=parseFloat(batimentsOGSpy[planete][7]) + 1;
	switch(res) {
		case "M":
		while (niv<=level){
			ressources += 200 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "C":
		while (niv<=level){
			ressources += 400 * Math.pow(2,(niv-1));
			niv++;
		}
		break;
		case "D":
		while (niv<=level){
			ressources += 200 * Math.pow(2,(niv-1));
			niv++;
		}
		break;	
	}	
	break;
	default :
	ressources=0;
	break;}
	return ressources;
}

function temps_usine (bat,level,planete) {
	var temps =0;
	var niv = 0;
	var res = 0;
	var batiment = 0;
	switch (bat) {
		case "UdN":
		niv=parseFloat(batimentsOGSpy[planete][4]) + 1;
		while (niv<=level){
			res = ((1000000 * Math.pow(2,(niv-1))) + (500000 * Math.pow(2,(niv-1))) ) / 1000;
			batiment = (parseFloat(batimentsOGSpy[planete][8]) + 1) * (Math.pow (2,(niv-1))) ;
			temps += Math.floor ( ( (res) / (batiment) ) * 24 * 60);
			niv++;}
		break;
		case "UdR":
		niv=parseFloat(batimentsOGSpy[planete][8]) + 1;
		case "M":
		while (niv<=level){
			res = ((400 * Math.pow(2,(niv-1))) + (120 * Math.pow(2,(niv-1))) ) / 1000;
			batiment = (niv) * (UdN[planete]) ;
			temps += Math.floor ( ( (res) / (batiment) ) * 24 * 60);
			niv++;
		}
		break;
		default :
		temps =0;
		break;
	}
 return temps;
}		
	
function calcul (i) {
 UdR = new Array();
 UdN = new Array();
 CSp = new Array();
 NRJ_nec = 300000 * Math.pow (3,(niv_grav-1));
 	
 Prod['CES'][i] = Math.round ((20 * (niv_bat['CES'][i]) * (Math.pow(1.1,(niv_bat['CES'][i])))));
 Prod['CEF'][i] = Math.round ((50 * (niv_bat['CEF'][i]) * (Math.pow(1.1,(niv_bat['CEF'][i])))));
		
 Sat['prod_un'][i] = Math.floor (((batimentsOGSpy[i][1]) / 4) + 20);
 Prod['Sat'][i] = Math.round ((niv_bat['Sat'][i]) * (Sat['prod_un'][i]));
	
 Prod['tot'][i] = Prod['CES'][i] + Prod['CEF'][i] + Prod['Sat'][i];
 Sat['nb_nec'][i] = Math.ceil(((NRJ_nec - (Prod['tot'][i])) / (Sat['prod_un'][i])));
	
 Ress['Sat']['Cristal'][i] = 2000 * Sat['nb_nec'][i];
 Ress['Sat']['Deut'][i] = 500 *Sat['nb_nec'][i];
		
	if (niv_bat['Lab'][i] > 12) {niv_lab[i] = niv_bat['Lab'][i];} else {niv_lab[i] = 12;}
	
 Ress['Lab']['Metal'][i] = upgrade_bat ('Lab', niv_lab[i], 'M', i);
 Ress['Lab']['Cristal'][i] = upgrade_bat ('Lab', niv_lab[i], 'C', i);
 Ress['Lab']['Deut'][i] = upgrade_bat ('Lab', niv_lab[i], 'D', i);
	
 Ress['CES']['Metal'][i] = upgrade_bat ('CES', niv_bat['CES'][i], 'M', i);
 Ress['CES']['Cristal'][i] = upgrade_bat ('CES', niv_bat['CES'][i], 'C', i);
 Ress['CEF']['Metal'][i] = upgrade_bat ('CEF', niv_bat['CEF'][i], 'M', i);
 Ress['CEF']['Cristal'][i] = upgrade_bat ('CEF', niv_bat['CEF'][i], 'C', i);
 Ress['CEF']['Deut'][i] = upgrade_bat ('CEF', niv_bat['CEF'][i], 'D', i);
	
 Ress['Centrale']['Metal'][i] = Ress['CES']['Metal'][i] +Ress['CEF']['Metal'][i];
 Ress['Centrale']['Cristal'][i] = Ress['CES']['Cristal'][i] + Ress['CEF']['Cristal'][i];
 Ress['Centrale']['Deut'][i] = Ress['CEF']['Deut'][i];
		
 Ress['UdN']['Metal'][i] = upgrade_bat ('UdN', niv_bat['UdN'][i], 'M', i);
 Ress['UdN']['Cristal'][i] = upgrade_bat ('UdN', niv_bat['UdN'][i], 'C', i);
 Ress['UdN']['Deut'][i] = upgrade_bat ('UdN',niv_bat['UdN'][i], 'D', i);
 Ress['UdR']['Metal'][i] = upgrade_bat ('UdR', niv_bat['UdR'][i], 'M', i);
 Ress['UdR']['Cristal'][i] = upgrade_bat ('UdR', niv_bat['UdR'][i], 'C', i);
 Ress['UdR']['Deut'][i] = upgrade_bat ('UdR', niv_bat['UdR'][i], 'D', i);
 Ress['CSp']['Metal'][i] = upgrade_bat ('CSp', niv_bat['CSp'][i], 'M', i);
 Ress['CSp']['Cristal'][i] = upgrade_bat ('CSp', niv_bat['CSp'][i], 'C', i);
 Ress['CSp']['Deut'][i] = upgrade_bat ('CSp', niv_bat['CSp'][i], 'D', i);
		
 Ress['Usine']['Metal'][i] = Ress['UdN']['Metal'][i] + Ress['UdR']['Metal'][i] + Ress['CSp']['Metal'][i];
 Ress['Usine']['Cristal'][i] = Ress['UdN']['Cristal'][i] + Ress['UdR']['Cristal'][i] + Ress['CSp']['Cristal'][i];
 Ress['Usine']['Deut'][i] = Ress['UdN']['Deut'][i] + Ress['UdR']['Deut'][i] + Ress['CSp']['Deut'][i];		
		
 Ress['Total']['Metal'][i] = Ress['Lab']['Metal'][i] + Ress['Centrale']['Metal'][i] + Ress['Usine']['Metal'][i];
 Ress['Total']['Cristal'][i] = Ress['Sat']['Cristal'][i] + Ress['Lab']['Cristal'][i] + Ress['Centrale']['Cristal'][i] + Ress['Usine']['Cristal'][i];
 Ress['Total']['Deut'][i] = Ress['Sat']['Deut'][i] + Ress['Lab']['Deut'][i] + Ress['Centrale']['Deut'][i] + Ress['Usine']['Deut'][i];
		
 UdR[i] = 1 + parseFloat(niv_bat['UdR'][i]);
 UdN[i] = Math.pow (2,(niv_bat['UdN'][i]));
 CSp[i] = 1 + parseFloat(niv_bat['CSp'][i]);
	
 Temps['Lab'][i] = Math.floor (( ((Ress['Lab']['Metal'][i] + Ress['Lab']['Cristal'][i]) / 1000) / ((UdR[i]) * (UdN[i]))) * 24 * 60);
 Temps['Sat_un'][i] = Math.floor ((2000 / ((CSp[i]) * (UdN[i])) ) * 1.44);
 Temps['Sat'][i] = Sat['nb_nec'][i] * Temps['Sat_un'][i];
 Temps['Centrale'][i] = 	Math.floor (( ((Ress['Centrale']['Metal'][i] + Ress['Centrale']['Cristal'][i]) / 1000) / ((UdR[i]) * (UdN[i]))) * 24 * 60);
 Temps['CSp'][i] = Math.floor (( ((Ress['CSp']['Metal'][i] + Ress['CSp']['Cristal'][i]) / 1000) / ((UdR[i]) * (UdN[i]))) * 24 * 60);
 Temps['UdN'][i] = temps_usine ('UdN',niv_bat['UdN'][i],i);
 Temps['UdR'][i] = temps_usine ('UdR',niv_bat['UdR'][i],i);
 Temps['Usine'][i] = Temps['CSp'][i] + Temps['UdN'][i] + Temps['UdR'][i];
 
 Temps['Total'][i] = Temps['Lab'][i] + Temps['Sat'][i] + Temps['Centrale'][i] + Temps['Usine'][i];

 
ecrire (i);
}

function format(x) {
if (x==0) {return x;} else {
var str = x.toString(), n = str.length;

if (n <4) {return x;} else {

	return ((n % 3) ? str.substr(0, n % 3) + ' ' : '') + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join(' ');
}}}


function conv_temps (temps) {
        var jour = Math.floor (temps / 86400);
		var heures = Math.floor ((temps - (jour * 86400)) / 3600);
        var minutes = Math.floor ((temps - ((jour * 86400) + (heures * 3600))) / 60);
		var secondes = temps - (jour * 86400) - (heures * 3600) - (minutes * 60);
        if (jour < 10) 
				{jour = "0" + jour;}
		if (heures < 10)
				{heures= "0" + heures;}
		if (minutes < 10)
                {minutes = "0" + minutes;}
       	if (secondes < 10)
                {secondes = "0" + secondes;}
		temps_decomp = jour + "J " + heures + "H " + minutes + "min " + secondes + "s";
        return temps_decomp;
}