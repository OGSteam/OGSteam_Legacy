//Production par heure
function production (building, level, tech, uni_speed, xp_min, temperature) {
	switch (building) {
		case "Ti":
		result = 20*uni_speed+(30 * level * Math.pow((1.1+tech/1000), level) * uni_speed * (1 + xp_min)/100);
		break;

		case "Ca":
		result = 10 * uni_speed + (20 * level * Math.pow((1.1+tech/1000), level) * uni_speed * (1 + xp_min)/100); 
		break;

		case "Tr":
		result = 10 * level * Math.pow((1.1+tech/1000), level) * uni_speed * (1+xp_min)/100;
		break;

		case "CG":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CaT":
		result = 50 * level * Math.pow(1.1, level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}

//Production des satellites
function production_sat (temperature) {
	return Math.floor((temperature / 4) + 20);
}

//Consommation d"énergie
function consumption (building, level) {
	switch (building) {
		case "Ti":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "Ca":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "Tr":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CaT":
		result = 10 * level * Math.pow(1.1, level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}

function update_page() {

var Ti_conso_tot=0, Ti_prod_tot =0,Ca_conso_tot=0, Ca_prod_tot=0, Tr_conso_tot=0, Tr_prod_tot=0, NRJ_tot=0;

var Alli = document.getElementById("tech_Alli").value;
var SC = document.getElementById("tech_SC").value;
var Raf = document.getElementById("tech_Raf").value;
var xp_mineur = document.getElementById("xp_mineur").value;
var uni_speed = document.getElementById("uni_speed").value;

for(var i = 1;i<=document.getElementById("nb_planets").value;i++){

	var Temp = document.getElementById("Temp_"+i).value;

	//Titane
	var Ti = document.getElementById("Ti_"+i).value;
	var Ti_percentage = document.getElementById("Ti_"+i+"_percentage").value;


	var Ti_conso = Math.round(consumption("Ti", Ti) * Ti_percentage / 100);
	var Ti_prod = Math.round(production("Ti", Ti, Alli, uni_speed, xp_mineur) * Ti_percentage / 100);

	document.getElementById("Ti_"+i+"_conso").innerHTML = Ti_conso;
	document.getElementById("Ti_"+i+"_prod").innerHTML = Ti_prod;

	//Carbone
	var Ca = document.getElementById("Ca_"+i).value;
	var Ca_percentage = document.getElementById("Ca_"+i+"_percentage").value;

	var Ca_conso = Math.round(consumption("Ca", Ca) * Ca_percentage / 100);
	var Ca_prod = Math.round(production("Ca", Ca, SC, uni_speed, xp_mineur) * Ca_percentage / 100);

	document.getElementById("Ca_"+i+"_conso").innerHTML = Ca_conso;
	document.getElementById("Ca_"+i+"_prod").innerHTML = Ca_prod;

	//Centrale Géothermique
	var CG = document.getElementById("CG_"+i).value;
	var CG_percentage = document.getElementById("CG_"+i+"_percentage").value;
	var CG_production = production("CG", CG) * CG_percentage / 100;

	//Centrale à Tritium
	var CaT = document.getElementById("CaT_"+i).value;
	var CaT_percentage = document.getElementById("CaT_"+i+"_percentage").value;
	var CaT_production = production("CaT", CaT) * CaT_percentage / 100;

	//Sat
	var Sat = document.getElementById("Sat_"+i).value;
	var Sat_percentage = document.getElementById("Sat_"+i+"_percentage").value;
	var Sat_production = production_sat(Temp) * Sat * Sat_percentage / 100;


	//Tritium
	var Tr = document.getElementById("Tr_"+i).value;
	var Tr_percentage = document.getElementById("Tr_"+i+"_percentage").value;

	var Tr_conso = Math.round(consumption("Tr", Tr) * Tr_percentage / 100);
	var Tr_prod = Math.round(production("Tr", Tr, Raf, uni_speed, xp_mineur) * Tr_percentage / 100) - Math.round(consumption("CaT", CaT) * CaT_percentage / 100);

	document.getElementById("Tr_"+i+"_conso").innerHTML = Tr_conso;
	document.getElementById("Tr_"+i+"_prod").innerHTML = Tr_prod;

	//Energie
	var NRJ = Math.round(CG_production + CaT_production + Sat_production);
	var NRJ_delta = NRJ - (Ti_conso + Ca_conso + Tr_conso);
	if (NRJ_delta < 0) NRJ_delta = "<font color='red'>" + NRJ_delta + "</font>";
	document.getElementById("NRJ_"+i).innerHTML = NRJ_delta + " / " + NRJ;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ / (Ti_conso + Ca_conso + Tr_conso);
	if (ratio_conso < 1) {
		Ti_prod = Math.round(Ti_prod * ratio_conso);
		document.getElementById("Ti_"+i+"_prod").innerHTML = Ti_prod;

		Ca_prod = Math.round(Ca_prod * ratio_conso);
		document.getElementById("Ca_"+i+"_prod").innerHTML = Ca_prod;

		Tr_prod = Math.round(Tr_prod * ratio_conso);
		document.getElementById("Tr_"+i+"_prod").innerHTML = Tr_prod;
	}
	
	Ti_conso_tot += Ti_conso;
	Ti_prod_tot += Ti_prod;
	Ca_conso_tot += Ca_conso;
	Ca_prod_tot += Ca_prod;
	Tr_conso_tot += Tr_conso;
	Tr_prod_tot += Tr_prod;
	NRJ_tot += NRJ;
	
}

	//
	// Totaux
	//

	//Titane
	document.getElementById("Ti_conso").innerHTML = Ti_conso_tot;
	document.getElementById("Ti_prod").innerHTML = Ti_prod_tot;

	//Carbone
	document.getElementById("Ca_conso").innerHTML = Ca_conso_tot;
	document.getElementById("Ca_prod").innerHTML = Ca_prod_tot;

	//Tritium
	document.getElementById("Tr_conso").innerHTML = Tr_conso_tot;
	document.getElementById("Tr_prod").innerHTML = Tr_prod_tot;

	//Energie
	var Delta_NRJ = NRJ_tot - (Ti_conso_tot + Ca_conso_tot + Tr_conso_tot);

	if (Delta_NRJ < 0) Delta_NRJ = "<font color='red'>"+Delta_NRJ+"</font>";
	else Delta_NRJ = "<font color='lime'>"+Delta_NRJ+"</font>";
	NRJ_tot = "<font color='lime'>"+NRJ_tot+"</font>"
	document.getElementById("NRJ").innerHTML = Delta_NRJ + " / " + NRJ_tot;


	//
	// Points
	//

	init_b_prix = new Array(720, 1600000, 700, 4000, 6000, 8000, 800, 150000, 41000, 80000, 80000, 8000000);
var total_pts = new Array;
var total_b_pts=0;
for(var i = 1;i<=document.getElementById("nb_planets").value;i++){
	var Ti = document.getElementById("Ti_"+i).value;
	var Ca = document.getElementById("Ca_"+i).value;
	var CG = document.getElementById("CG_"+i).value;
	var CaT = document.getElementById("CaT_"+i).value;
	var Tr = document.getElementById("Tr_"+i).value;
	// Batiments

	var building = document.getElementById("building_"+i).value;
	building = building.split('<>');
	var b_pts = ((50 + 20) * (1 - Math.pow(1.5, Ti)) / (-0.5)) + ((60 + 25) * (1 - Math.pow(1.5, Ca)) / (-0.5)) + ((225 +75) * (1 - Math.pow(1.5, Tr)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CG)) / (-0.5)) + ((960 + 360 + 180) * (1 - Math.pow(1.7, CaT)) / (-0.7));
	for(j=0; j<(building.length-2); j++) {
		b_pts = b_pts + init_b_prix[j] * (Math.pow(2, building[j]) - 1);
	}
	total_pts[i] = b_pts;
	total_b_pts += b_pts;
	document.getElementById("building_pts_"+i).innerHTML = Math.round(b_pts/1000);
}


	document.getElementById("total_b_pts").innerHTML = Math.round(total_b_pts/1000);


	init_d_prix = new Array(2000, 2000, 8000, 37000, 8000, 130000, 20000, 100000, 10000, 25000);

	// Defence planete 1
var total_d_pts=0;
for(var i = 1;i<=document.getElementById("nb_planets").value;i++){

	var defence = document.getElementById("defence_"+i).value;
	defence = defence.split('<>');
	var d_pts = 0;
	for(j=0; j<defence.length; j++) {
		d_pts = d_pts + init_d_prix[j] * defence[j];
	}
	total_pts[i] += d_pts;
	total_d_pts += d_pts;
	document.getElementById("defence_pts_"+i).innerHTML = Math.round(d_pts/1000);
}

	document.getElementById("total_d_pts").innerHTML = Math.round(total_d_pts/1000);

// Sat planete
var total_sat_pts = 0;
for(var i = 1;i<=document.getElementById("nb_planets").value;i++){
	var Sat = document.getElementById("Sat_"+i).value;
	
	var sat_pts = Math.round(Sat*2.5);
	document.getElementById("sat_pts_"+i).innerHTML = "<font color='lime'>"+sat_pts+"</font>";

	total_sat_pts += sat_pts;

	document.getElementById("total_pts_"+i).innerHTML = Math.round((total_pts[i])/1000)+sat_pts;

}	
	document.getElementById("total_sat_pts").innerHTML = total_sat_pts;
	document.getElementById("total_pts").innerHTML = Math.round((total_b_pts + total_d_pts)/1000)+total_sat_pts;



	// Technologies planete avec le labo de plus au niveau

	init_t_prix = new Array(1400, 1000, 1000, 800, 1000, 1200, 6000, 1000, 6600, 36000, 300, 1400, 7000, 800000,0,0,0,0,0,0,0);

	var techno = document.getElementById("techno").value;
	var n_techno = document.getElementById("n_techno").value;
	
	techno = techno.split('<>');
	n_techno = n_techno.split('<>');
	
	var techno_pts = 0;
	for(i=0; i<(techno.length-1); i++) {
		techno_pts = techno_pts + init_t_prix[i] * (Math.pow(2, techno[i]) - 1);
	}
	document.getElementById("techno_pts").innerHTML = Math.round(techno_pts/1000);
}