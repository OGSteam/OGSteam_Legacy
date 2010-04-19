//Production par heure
function production (building, level, temperature) {
	switch (building) {
		case "M":
		result = 20 + 30 * level * Math.pow(1.1, level);
		break;

		case "C":
		result = 10 + 20 * level * Math.pow(1.1, level);
		break;

		case "D":
		result = 10 * level * Math.pow(1.1, level) * (-0.002 * temperature + 1.28);
		break;

		case "CES":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CEF":
		result = 50 * level * Math.pow(1.1, level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}

//Production des ReSoellites
function production_ReSo (temperature) {
	return Math.floor((temperature / 4) + 20);
}

//Consommation d"énergie
function consumption (building, level) {
	switch (building) {
		case "M":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "C":
		result = 10 * level * Math.pow(1.1, level);
		break;

		case "D":
		result = 20 * level * Math.pow(1.1, level);
		break;

		case "CEF":
		result = 10 * level * Math.pow(1.1, level);
		break;

		default:
		result = 0;
		break;
	}

	return Math.round(result);
}

function update_page() {
	//
	// Planète 1
	//

	var Temp_1 = document.getElementById("Temp_1").value;

	//Acier - Planète 1
	var M_1 = document.getElementById("M_1").value;
	var M_1_percentage = document.getElementById("M_1_percentage").value;

	var M_1_conso = Math.round(consumption("M", M_1) * M_1_percentage / 100);
	var M_1_prod = Math.round(production("M", M_1) * M_1_percentage / 100);

	document.getElementById("M_1_conso").innerHTML = M_1_conso;
	document.getElementById("M_1_prod").innerHTML = M_1_prod;

	//Silicium - Planète 1
	var C_1 = document.getElementById("C_1").value;
	var C_1_percentage = document.getElementById("C_1_percentage").value;

	var C_1_conso = Math.round(consumption("C", C_1) * C_1_percentage / 100);
	var C_1_prod = Math.round(production("C", C_1) * C_1_percentage / 100);

	document.getElementById("C_1_conso").innerHTML = C_1_conso;
	document.getElementById("C_1_prod").innerHTML = C_1_prod;

	//CES - Planète 1
	var CES_1 = document.getElementById("CES_1").value;
	var CES_1_percentage = document.getElementById("CES_1_percentage").value;
	var CES_1_production = production("CES", CES_1) * CES_1_percentage / 100;

	//CEF - Planète 1
	var CEF_1 = document.getElementById("CEF_1").value;
	var CEF_1_percentage = document.getElementById("CEF_1_percentage").value;
	var CEF_1_production = production("CEF", CEF_1) * CEF_1_percentage / 100;

	//ReSo - Planète 1
	var ReSo_1 = document.getElementById("ReSo_1").value;
	var ReSo_1_percentage = document.getElementById("ReSo_1_percentage").value;
	var ReSo_1_production = production_ReSo(Temp_1) * ReSo_1 * ReSo_1_percentage / 100;


	//Deutéride - Planète 1
	var D_1 = document.getElementById("D_1").value;
	var D_1_percentage = document.getElementById("D_1_percentage").value;

	var D_1_conso = Math.round(consumption("D", D_1) * D_1_percentage / 100);
	var D_1_prod = Math.round(production("D", D_1, Temp_1) * D_1_percentage / 100) - Math.round(consumption("CEF", CEF_1) * CEF_1_percentage / 100);

	document.getElementById("D_1_conso").innerHTML = D_1_conso;
	document.getElementById("D_1_prod").innerHTML = D_1_prod;

	//Energie
	var NRJ_1 = Math.round(CES_1_production + CEF_1_production + ReSo_1_production);
	var NRJ_1_delta = NRJ_1 - (M_1_conso + C_1_conso + D_1_conso);
	if (NRJ_1_delta < 0) NRJ_1_delta = "<font color='red'>" + NRJ_1_delta + "</font>";
	document.getElementById("NRJ_1").innerHTML = NRJ_1_delta + " / " + NRJ_1;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_1 / (M_1_conso + C_1_conso + D_1_conso);
	if (ratio_conso < 1) {
		M_1_prod = Math.round(M_1_prod * ratio_conso);
		document.getElementById("M_1_prod").innerHTML = M_1_prod;

		C_1_prod = Math.round(C_1_prod * ratio_conso);
		document.getElementById("C_1_prod").innerHTML = C_1_prod;

		D_1_prod = Math.round(D_1_prod * ratio_conso);
		document.getElementById("D_1_prod").innerHTML = D_1_prod;
	}


	//
	// Planète 2
	//

	var Temp_2 = document.getElementById("Temp_2").value;

	//Acier - Planète 2
	var M_2 = document.getElementById("M_2").value;
	var M_2_percentage = document.getElementById("M_2_percentage").value;

	var M_2_conso = Math.round(consumption("M", M_2) * M_2_percentage / 100);
	var M_2_prod = Math.round(production("M", M_2) * M_2_percentage / 100);

	document.getElementById("M_2_conso").innerHTML = M_2_conso;
	document.getElementById("M_2_prod").innerHTML = M_2_prod;

	//Silicium - Planète 2
	var C_2 = document.getElementById("C_2").value;
	var C_2_percentage = document.getElementById("C_2_percentage").value;

	var C_2_conso = Math.round(consumption("C", C_2) * C_2_percentage / 100);
	var C_2_prod = Math.round(production("C", C_2) * C_2_percentage / 100);

	document.getElementById("C_2_conso").innerHTML = C_2_conso;
	document.getElementById("C_2_prod").innerHTML = C_2_prod;

	//CES - Planète 2
	var CES_2 = document.getElementById("CES_2").value;
	var CES_2_percentage = document.getElementById("CES_2_percentage").value;
	var CES_2_production = production("CES", CES_2) * CES_2_percentage / 100;

	//CEF - Planète 2
	var CEF_2 = document.getElementById("CEF_2").value;
	var CEF_2_percentage = document.getElementById("CEF_2_percentage").value;
	var CEF_2_production = production("CEF", CEF_2) * CEF_2_percentage / 100;

	//ReSo - Planète 2
	var ReSo_2 = document.getElementById("ReSo_2").value;
	var ReSo_2_percentage = document.getElementById("ReSo_2_percentage").value;
	var ReSo_2_production = production_ReSo(Temp_2) * ReSo_2 * ReSo_2_percentage / 100;


	//Deutéride - Planète 2
	var D_2 = document.getElementById("D_2").value;
	var D_2_percentage = document.getElementById("D_2_percentage").value;

	var D_2_conso = Math.round(consumption("D", D_2) * D_2_percentage / 100);
	var D_2_prod = Math.round(production("D", D_2, Temp_2) * D_2_percentage / 100) - Math.round(consumption("CEF", CEF_2) * CEF_2_percentage / 100);

	document.getElementById("D_2_conso").innerHTML = D_2_conso;
	document.getElementById("D_2_prod").innerHTML = D_2_prod;

	//Energie
	var NRJ_2 = Math.round(CES_2_production + CEF_2_production + ReSo_2_production);
	var NRJ_2_delta = NRJ_2 - (M_2_conso + C_2_conso + D_2_conso);
	if (NRJ_2_delta < 0) NRJ_2_delta = "<font color='red'>" + NRJ_2_delta + "</font>";
	document.getElementById("NRJ_2").innerHTML = NRJ_2_delta + " / " + NRJ_2;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_2 / (M_2_conso + C_2_conso + D_2_conso);
	if (ratio_conso < 1) {
		M_2_prod = Math.round(M_2_prod * ratio_conso);
		document.getElementById("M_2_prod").innerHTML = M_2_prod;

		C_2_prod = Math.round(C_2_prod * ratio_conso);
		document.getElementById("C_2_prod").innerHTML = C_2_prod;

		D_2_prod = Math.round(D_2_prod * ratio_conso);
		document.getElementById("D_2_prod").innerHTML = D_2_prod;
	}


	//
	// Planète 3
	//

	var Temp_3 = document.getElementById("Temp_3").value;

	//Acier - Planète 3
	var M_3 = document.getElementById("M_3").value;
	var M_3_percentage = document.getElementById("M_3_percentage").value;

	var M_3_conso = Math.round(consumption("M", M_3) * M_3_percentage / 100);
	var M_3_prod = Math.round(production("M", M_3) * M_3_percentage / 100);

	document.getElementById("M_3_conso").innerHTML = M_3_conso;
	document.getElementById("M_3_prod").innerHTML = M_3_prod;

	//Silicium - Planète 3
	var C_3 = document.getElementById("C_3").value;
	var C_3_percentage = document.getElementById("C_3_percentage").value;

	var C_3_conso = Math.round(consumption("C", C_3) * C_3_percentage / 100);
	var C_3_prod = Math.round(production("C", C_3) * C_3_percentage / 100);

	document.getElementById("C_3_conso").innerHTML = C_3_conso;
	document.getElementById("C_3_prod").innerHTML = C_3_prod;

	//CES - Planète 3
	var CES_3 = document.getElementById("CES_3").value;
	var CES_3_percentage = document.getElementById("CES_3_percentage").value;
	var CES_3_production = production("CES", CES_3) * CES_3_percentage / 100;

	//CEF - Planète 3
	var CEF_3 = document.getElementById("CEF_3").value;
	var CEF_3_percentage = document.getElementById("CEF_3_percentage").value;
	var CEF_3_production = production("CEF", CEF_3) * CEF_3_percentage / 100;

	//ReSo - Planète 3
	var ReSo_3 = document.getElementById("ReSo_3").value;
	var ReSo_3_percentage = document.getElementById("ReSo_3_percentage").value;
	var ReSo_3_production = production_ReSo(Temp_3) * ReSo_3 * ReSo_3_percentage / 100;


	//Deutéride - Planète 3
	var D_3 = document.getElementById("D_3").value;
	var D_3_percentage = document.getElementById("D_3_percentage").value;

	var D_3_conso = Math.round(consumption("D", D_3) * D_3_percentage / 100);
	var D_3_prod = Math.round(production("D", D_3, Temp_3) * D_3_percentage / 100) - Math.round(consumption("CEF", CEF_3) * CEF_3_percentage / 100);

	document.getElementById("D_3_conso").innerHTML = D_3_conso;
	document.getElementById("D_3_prod").innerHTML = D_3_prod;

	//Energie
	var NRJ_3 = Math.round(CES_3_production + CEF_3_production + ReSo_3_production);
	var NRJ_3_delta = NRJ_3 - (M_3_conso + C_3_conso + D_3_conso);
	if (NRJ_3_delta < 0) NRJ_3_delta = "<font color='red'>" + NRJ_3_delta + "</font>";
	document.getElementById("NRJ_3").innerHTML = NRJ_3_delta + " / " + NRJ_3;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_3 / (M_3_conso + C_3_conso + D_3_conso);
	if (ratio_conso < 1) {
		M_3_prod = Math.round(M_3_prod * ratio_conso);
		document.getElementById("M_3_prod").innerHTML = M_3_prod;

		C_3_prod = Math.round(C_3_prod * ratio_conso);
		document.getElementById("C_3_prod").innerHTML = C_3_prod;

		D_3_prod = Math.round(D_3_prod * ratio_conso);
		document.getElementById("D_3_prod").innerHTML = D_3_prod;
	}


	//
	// Planète 4
	//

	var Temp_4 = document.getElementById("Temp_4").value;

	//Acier - Planète 4
	var M_4 = document.getElementById("M_4").value;
	var M_4_percentage = document.getElementById("M_4_percentage").value;

	var M_4_conso = Math.round(consumption("M", M_4) * M_4_percentage / 100);
	var M_4_prod = Math.round(production("M", M_4) * M_4_percentage / 100);

	document.getElementById("M_4_conso").innerHTML = M_4_conso;
	document.getElementById("M_4_prod").innerHTML = M_4_prod;

	//Silicium - Planète 4
	var C_4 = document.getElementById("C_4").value;
	var C_4_percentage = document.getElementById("C_4_percentage").value;

	var C_4_conso = Math.round(consumption("C", C_4) * C_4_percentage / 100);
	var C_4_prod = Math.round(production("C", C_4) * C_4_percentage / 100);

	document.getElementById("C_4_conso").innerHTML = C_4_conso;
	document.getElementById("C_4_prod").innerHTML = C_4_prod;

	//CES - Planète 4
	var CES_4 = document.getElementById("CES_4").value;
	var CES_4_percentage = document.getElementById("CES_4_percentage").value;
	var CES_4_production = production("CES", CES_4) * CES_4_percentage / 100;

	//CEF - Planète 4
	var CEF_4 = document.getElementById("CEF_4").value;
	var CEF_4_percentage = document.getElementById("CEF_4_percentage").value;
	var CEF_4_production = production("CEF", CEF_4) * CEF_4_percentage / 100;

	//ReSo - Planète 4
	var ReSo_4 = document.getElementById("ReSo_4").value;
	var ReSo_4_percentage = document.getElementById("ReSo_4_percentage").value;
	var ReSo_4_production = production_ReSo(Temp_4) * ReSo_4 * ReSo_4_percentage / 100;


	//Deutéride - Planète 4
	var D_4 = document.getElementById("D_4").value;
	var D_4_percentage = document.getElementById("D_4_percentage").value;

	var D_4_conso = Math.round(consumption("D", D_4) * D_4_percentage / 100);
	var D_4_prod = Math.round(production("D", D_4, Temp_4) * D_4_percentage / 100) - Math.round(consumption("CEF", CEF_4) * CEF_4_percentage / 100);

	document.getElementById("D_4_conso").innerHTML = D_4_conso;
	document.getElementById("D_4_prod").innerHTML = D_4_prod;

	//Energie
	var NRJ_4 = Math.round(CES_4_production + CEF_4_production + ReSo_4_production);
	var NRJ_4_delta = NRJ_4 - (M_4_conso + C_4_conso + D_4_conso);
	if (NRJ_4_delta < 0) NRJ_4_delta = "<font color='red'>" + NRJ_4_delta + "</font>";
	document.getElementById("NRJ_4").innerHTML = NRJ_4_delta + " / " + NRJ_4;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_4 / (M_4_conso + C_4_conso + D_4_conso);
	if (ratio_conso < 1) {
		M_4_prod = Math.round(M_4_prod * ratio_conso);
		document.getElementById("M_4_prod").innerHTML = M_4_prod;

		C_4_prod = Math.round(C_4_prod * ratio_conso);
		document.getElementById("C_4_prod").innerHTML = C_4_prod;

		D_4_prod = Math.round(D_4_prod * ratio_conso);
		document.getElementById("D_4_prod").innerHTML = D_4_prod;
	}


	//
	// Planète 5
	//

	var Temp_5 = document.getElementById("Temp_5").value;

	//Acier - Planète 5
	var M_5 = document.getElementById("M_5").value;
	var M_5_percentage = document.getElementById("M_5_percentage").value;

	var M_5_conso = Math.round(consumption("M", M_5) * M_5_percentage / 100);
	var M_5_prod = Math.round(production("M", M_5) * M_5_percentage / 100);

	document.getElementById("M_5_conso").innerHTML = M_5_conso;
	document.getElementById("M_5_prod").innerHTML = M_5_prod;

	//Silicium - Planète 5
	var C_5 = document.getElementById("C_5").value;
	var C_5_percentage = document.getElementById("C_5_percentage").value;

	var C_5_conso = Math.round(consumption("C", C_5) * C_5_percentage / 100);
	var C_5_prod = Math.round(production("C", C_5) * C_5_percentage / 100);

	document.getElementById("C_5_conso").innerHTML = C_5_conso;
	document.getElementById("C_5_prod").innerHTML = C_5_prod;

	//CES - Planète 5
	var CES_5 = document.getElementById("CES_5").value;
	var CES_5_percentage = document.getElementById("CES_5_percentage").value;
	var CES_5_production = production("CES", CES_5) * CES_5_percentage / 100;

	//CEF - Planète 5
	var CEF_5 = document.getElementById("CEF_5").value;
	var CEF_5_percentage = document.getElementById("CEF_5_percentage").value;
	var CEF_5_production = production("CEF", CEF_5) * CEF_5_percentage / 100;

	//ReSo - Planète 5
	var ReSo_5 = document.getElementById("ReSo_5").value;
	var ReSo_5_percentage = document.getElementById("ReSo_5_percentage").value;
	var ReSo_5_production = production_ReSo(Temp_5) * ReSo_5 * ReSo_5_percentage / 100;


	//Deutéride - Planète 5
	var D_5 = document.getElementById("D_5").value;
	var D_5_percentage = document.getElementById("D_5_percentage").value;

	var D_5_conso = Math.round(consumption("D", D_5) * D_5_percentage / 100);
	var D_5_prod = Math.round(production("D", D_5, Temp_5) * D_5_percentage / 100) - Math.round(consumption("CEF", CEF_5) * CEF_5_percentage / 100);

	document.getElementById("D_5_conso").innerHTML = D_5_conso;
	document.getElementById("D_5_prod").innerHTML = D_5_prod;

	//Energie
	var NRJ_5 = Math.round(CES_5_production + CEF_5_production + ReSo_5_production);
	var NRJ_5_delta = NRJ_5 - (M_5_conso + C_5_conso + D_5_conso);
	if (NRJ_5_delta < 0) NRJ_5_delta = "<font color='red'>" + NRJ_5_delta + "</font>";
	document.getElementById("NRJ_5").innerHTML = NRJ_5_delta + " / " + NRJ_5;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_5 / (M_5_conso + C_5_conso + D_5_conso);
	if (ratio_conso < 1) {
		M_5_prod = Math.round(M_5_prod * ratio_conso);
		document.getElementById("M_5_prod").innerHTML = M_5_prod;

		C_5_prod = Math.round(C_5_prod * ratio_conso);
		document.getElementById("C_5_prod").innerHTML = C_5_prod;

		D_5_prod = Math.round(D_5_prod * ratio_conso);
		document.getElementById("D_5_prod").innerHTML = D_5_prod;
	}


	//
	// Planète 6
	//

	var Temp_6 = document.getElementById("Temp_6").value;

	//Acier - Planète 6
	var M_6 = document.getElementById("M_6").value;
	var M_6_percentage = document.getElementById("M_6_percentage").value;

	var M_6_conso = Math.round(consumption("M", M_6) * M_6_percentage / 100);
	var M_6_prod = Math.round(production("M", M_6) * M_6_percentage / 100);

	document.getElementById("M_6_conso").innerHTML = M_6_conso;
	document.getElementById("M_6_prod").innerHTML = M_6_prod;

	//Silicium - Planète 6
	var C_6 = document.getElementById("C_6").value;
	var C_6_percentage = document.getElementById("C_6_percentage").value;

	var C_6_conso = Math.round(consumption("C", C_6) * C_6_percentage / 100);
	var C_6_prod = Math.round(production("C", C_6) * C_6_percentage / 100);

	document.getElementById("C_6_conso").innerHTML = C_6_conso;
	document.getElementById("C_6_prod").innerHTML = C_6_prod;

	//CES - Planète 6
	var CES_6 = document.getElementById("CES_6").value;
	var CES_6_percentage = document.getElementById("CES_6_percentage").value;
	var CES_6_production = production("CES", CES_6) * CES_6_percentage / 100;

	//CEF - Planète 6
	var CEF_6 = document.getElementById("CEF_6").value;
	var CEF_6_percentage = document.getElementById("CEF_6_percentage").value;
	var CEF_6_production = production("CEF", CEF_6) * CEF_6_percentage / 100;

	//ReSo - Planète 6
	var ReSo_6 = document.getElementById("ReSo_6").value;
	var ReSo_6_percentage = document.getElementById("ReSo_6_percentage").value;
	var ReSo_6_production = production_ReSo(Temp_6) * ReSo_6 * ReSo_6_percentage / 100;


	//Deutéride - Planète 6
	var D_6 = document.getElementById("D_6").value;
	var D_6_percentage = document.getElementById("D_6_percentage").value;

	var D_6_conso = Math.round(consumption("D", D_6) * D_6_percentage / 100);
	var D_6_prod = Math.round(production("D", D_6, Temp_6) * D_6_percentage / 100) - Math.round(consumption("CEF", CEF_6) * CEF_6_percentage / 100);

	document.getElementById("D_6_conso").innerHTML = D_6_conso;
	document.getElementById("D_6_prod").innerHTML = D_6_prod;

	//Energie
	var NRJ_6 = Math.round(CES_6_production + CEF_6_production + ReSo_6_production);
	var NRJ_6_delta = NRJ_6 - (M_6_conso + C_6_conso + D_6_conso);
	if (NRJ_6_delta < 0) NRJ_6_delta = "<font color='red'>" + NRJ_6_delta + "</font>";
	document.getElementById("NRJ_6").innerHTML = NRJ_6_delta + " / " + NRJ_6;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_6 / (M_6_conso + C_6_conso + D_6_conso);
	if (ratio_conso < 1) {
		M_6_prod = Math.round(M_6_prod * ratio_conso);
		document.getElementById("M_6_prod").innerHTML = M_6_prod;

		C_6_prod = Math.round(C_6_prod * ratio_conso);
		document.getElementById("C_6_prod").innerHTML = C_6_prod;

		D_6_prod = Math.round(D_6_prod * ratio_conso);
		document.getElementById("D_6_prod").innerHTML = D_6_prod;
	}


	//
	// Planète 7
	//

	var Temp_7 = document.getElementById("Temp_7").value;

	//Acier - Planète 7
	var M_7 = document.getElementById("M_7").value;
	var M_7_percentage = document.getElementById("M_7_percentage").value;

	var M_7_conso = Math.round(consumption("M", M_7) * M_7_percentage / 100);
	var M_7_prod = Math.round(production("M", M_7) * M_7_percentage / 100);

	document.getElementById("M_7_conso").innerHTML = M_7_conso;
	document.getElementById("M_7_prod").innerHTML = M_7_prod;

	//Silicium - Planète 7
	var C_7 = document.getElementById("C_7").value;
	var C_7_percentage = document.getElementById("C_7_percentage").value;

	var C_7_conso = Math.round(consumption("C", C_7) * C_7_percentage / 100);
	var C_7_prod = Math.round(production("C", C_7) * C_7_percentage / 100);

	document.getElementById("C_7_conso").innerHTML = C_7_conso;
	document.getElementById("C_7_prod").innerHTML = C_7_prod;

	//CES - Planète 7
	var CES_7 = document.getElementById("CES_7").value;
	var CES_7_percentage = document.getElementById("CES_7_percentage").value;
	var CES_7_production = production("CES", CES_7) * CES_7_percentage / 100;

	//CEF - Planète 7
	var CEF_7 = document.getElementById("CEF_7").value;
	var CEF_7_percentage = document.getElementById("CEF_7_percentage").value;
	var CEF_7_production = production("CEF", CEF_7) * CEF_7_percentage / 100;

	//ReSo - Planète 7
	var ReSo_7 = document.getElementById("ReSo_7").value;
	var ReSo_7_percentage = document.getElementById("ReSo_7_percentage").value;
	var ReSo_7_production = production_ReSo(Temp_7) * ReSo_7 * ReSo_7_percentage / 100;


	//Deutéride - Planète 7
	var D_7 = document.getElementById("D_7").value;
	var D_7_percentage = document.getElementById("D_7_percentage").value;

	var D_7_conso = Math.round(consumption("D", D_7) * D_7_percentage / 100);
	var D_7_prod = Math.round(production("D", D_7, Temp_7) * D_7_percentage / 100) - Math.round(consumption("CEF", CEF_7) * CEF_7_percentage / 100);

	document.getElementById("D_7_conso").innerHTML = D_7_conso;
	document.getElementById("D_7_prod").innerHTML = D_7_prod;

	//Energie
	var NRJ_7 = Math.round(CES_7_production + CEF_7_production + ReSo_7_production);
	var NRJ_7_delta = NRJ_7 - (M_7_conso + C_7_conso + D_7_conso);
	if (NRJ_7_delta < 0) NRJ_7_delta = "<font color='red'>" + NRJ_7_delta + "</font>";
	document.getElementById("NRJ_7").innerHTML = NRJ_7_delta + " / " + NRJ_7;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_7 / (M_7_conso + C_7_conso + D_7_conso);
	if (ratio_conso < 1) {
		M_7_prod = Math.round(M_7_prod * ratio_conso);
		document.getElementById("M_7_prod").innerHTML = M_7_prod;

		C_7_prod = Math.round(C_7_prod * ratio_conso);
		document.getElementById("C_7_prod").innerHTML = C_7_prod;

		D_7_prod = Math.round(D_7_prod * ratio_conso);
		document.getElementById("D_7_prod").innerHTML = D_7_prod;
	}


	//
	// Planète 8
	//

	var Temp_8 = document.getElementById("Temp_8").value;

	//Acier - Planète 8
	var M_8 = document.getElementById("M_8").value;
	var M_8_percentage = document.getElementById("M_8_percentage").value;

	var M_8_conso = Math.round(consumption("M", M_8) * M_8_percentage / 100);
	var M_8_prod = Math.round(production("M", M_8) * M_8_percentage / 100);

	document.getElementById("M_8_conso").innerHTML = M_8_conso;
	document.getElementById("M_8_prod").innerHTML = M_8_prod;

	//Silicium - Planète 8
	var C_8 = document.getElementById("C_8").value;
	var C_8_percentage = document.getElementById("C_8_percentage").value;

	var C_8_conso = Math.round(consumption("C", C_8) * C_8_percentage / 100);
	var C_8_prod = Math.round(production("C", C_8) * C_8_percentage / 100);

	document.getElementById("C_8_conso").innerHTML = C_8_conso;
	document.getElementById("C_8_prod").innerHTML = C_8_prod;

	//CES - Planète 8
	var CES_8 = document.getElementById("CES_8").value;
	var CES_8_percentage = document.getElementById("CES_8_percentage").value;
	var CES_8_production = production("CES", CES_8) * CES_8_percentage / 100;

	//CEF - Planète 8
	var CEF_8 = document.getElementById("CEF_8").value;
	var CEF_8_percentage = document.getElementById("CEF_8_percentage").value;
	var CEF_8_production = production("CEF", CEF_8) * CEF_8_percentage / 100;

	//ReSo - Planète 8
	var ReSo_8 = document.getElementById("ReSo_8").value;
	var ReSo_8_percentage = document.getElementById("ReSo_8_percentage").value;
	var ReSo_8_production = production_ReSo(Temp_8) * ReSo_8 * ReSo_8_percentage / 100;


	//Deutéride - Planète 8
	var D_8 = document.getElementById("D_8").value;
	var D_8_percentage = document.getElementById("D_8_percentage").value;

	var D_8_conso = Math.round(consumption("D", D_8) * D_8_percentage / 100);
	var D_8_prod = Math.round(production("D", D_8, Temp_8) * D_8_percentage / 100) - Math.round(consumption("CEF", CEF_8) * CEF_8_percentage / 100);

	document.getElementById("D_8_conso").innerHTML = D_8_conso;
	document.getElementById("D_8_prod").innerHTML = D_8_prod;

	//Energie
	var NRJ_8 = Math.round(CES_8_production + CEF_8_production + ReSo_8_production);
	var NRJ_8_delta = NRJ_8 - (M_8_conso + C_8_conso + D_8_conso);
	if (NRJ_8_delta < 0) NRJ_8_delta = "<font color='red'>" + NRJ_8_delta + "</font>";
	document.getElementById("NRJ_8").innerHTML = NRJ_8_delta + " / " + NRJ_8;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_8 / (M_8_conso + C_8_conso + D_8_conso);
	if (ratio_conso < 1) {
		M_8_prod = Math.round(M_8_prod * ratio_conso);
		document.getElementById("M_8_prod").innerHTML = M_8_prod;

		C_8_prod = Math.round(C_8_prod * ratio_conso);
		document.getElementById("C_8_prod").innerHTML = C_8_prod;

		D_8_prod = Math.round(D_8_prod * ratio_conso);
		document.getElementById("D_8_prod").innerHTML = D_8_prod;
	}


	//
	// Planète 9
	//

	var Temp_9 = document.getElementById("Temp_9").value;

	//Acier - Planète 9
	var M_9 = document.getElementById("M_9").value;
	var M_9_percentage = document.getElementById("M_9_percentage").value;

	var M_9_conso = Math.round(consumption("M", M_9) * M_9_percentage / 100);
	var M_9_prod = Math.round(production("M", M_9) * M_9_percentage / 100);

	document.getElementById("M_9_conso").innerHTML = M_9_conso;
	document.getElementById("M_9_prod").innerHTML = M_9_prod;

	//Silicium - Planète 9
	var C_9 = document.getElementById("C_9").value;
	var C_9_percentage = document.getElementById("C_9_percentage").value;

	var C_9_conso = Math.round(consumption("C", C_9) * C_9_percentage / 100);
	var C_9_prod = Math.round(production("C", C_9) * C_9_percentage / 100);

	document.getElementById("C_9_conso").innerHTML = C_9_conso;
	document.getElementById("C_9_prod").innerHTML = C_9_prod;

	//CES - Planète 9
	var CES_9 = document.getElementById("CES_9").value;
	var CES_9_percentage = document.getElementById("CES_9_percentage").value;
	var CES_9_production = production("CES", CES_9) * CES_9_percentage / 100;

	//CEF - Planète 9
	var CEF_9 = document.getElementById("CEF_9").value;
	var CEF_9_percentage = document.getElementById("CEF_9_percentage").value;
	var CEF_9_production = production("CEF", CEF_9) * CEF_9_percentage / 100;

	//ReSo - Planète 9
	var ReSo_9 = document.getElementById("ReSo_9").value;
	var ReSo_9_percentage = document.getElementById("ReSo_9_percentage").value;
	var ReSo_9_production = production_ReSo(Temp_9) * ReSo_9 * ReSo_9_percentage / 100;


	//Deutéride - Planète 9
	var D_9 = document.getElementById("D_9").value;
	var D_9_percentage = document.getElementById("D_9_percentage").value;

	var D_9_conso = Math.round(consumption("D", D_9) * D_9_percentage / 100);
	var D_9_prod = Math.round(production("D", D_9, Temp_9) * D_9_percentage / 100) - Math.round(consumption("CEF", CEF_9) * CEF_9_percentage / 100);

	document.getElementById("D_9_conso").innerHTML = D_9_conso;
	document.getElementById("D_9_prod").innerHTML = D_9_prod;

	//Energie
	var NRJ_9 = Math.round(CES_9_production + CEF_9_production + ReSo_9_production);
	var NRJ_9_delta = NRJ_9 - (M_9_conso + C_9_conso + D_9_conso);
	if (NRJ_9_delta < 0) NRJ_9_delta = "<font color='red'>" + NRJ_9_delta + "</font>";
	document.getElementById("NRJ_9").innerHTML = NRJ_9_delta + " / " + NRJ_9;

	//Ratio de consommation d'énergie
	var ratio_conso = NRJ_9 / (M_9_conso + C_9_conso + D_9_conso);
	if (ratio_conso < 1) {
		M_9_prod = Math.round(M_9_prod * ratio_conso);
		document.getElementById("M_9_prod").innerHTML = M_9_prod;

		C_9_prod = Math.round(C_9_prod * ratio_conso);
		document.getElementById("C_9_prod").innerHTML = C_9_prod;

		D_9_prod = Math.round(D_9_prod * ratio_conso);
		document.getElementById("D_9_prod").innerHTML = D_9_prod;
	}


	//
	// Totaux
	//

	//Acier
	var M_conso = M_1_conso +  M_2_conso +  M_3_conso +  M_4_conso +  M_5_conso +  M_6_conso +  M_7_conso +  M_8_conso +  M_9_conso;
	document.getElementById("M_conso").innerHTML = M_conso;
	var M_prod = M_1_prod +  M_2_prod +  M_3_prod +  M_4_prod +  M_5_prod +  M_6_prod +  M_7_prod +  M_8_prod +  M_9_prod;
	document.getElementById("M_prod").innerHTML = M_prod;

	//Silicium
	var C_conso = C_1_conso +  C_2_conso +  C_3_conso +  C_4_conso +  C_5_conso +  C_6_conso +  C_7_conso +  C_8_conso +  C_9_conso;
	document.getElementById("C_conso").innerHTML = C_conso;
	var C_prod = C_1_prod +  C_2_prod +  C_3_prod +  C_4_prod +  C_5_prod +  C_6_prod +  C_7_prod +  C_8_prod +  C_9_prod;
	document.getElementById("C_prod").innerHTML = C_prod;

	//Deutéride
	var D_conso = D_1_conso +  D_2_conso +  D_3_conso +  D_4_conso +  D_5_conso +  D_6_conso +  D_7_conso +  D_8_conso +  D_9_conso;
	document.getElementById("D_conso").innerHTML = D_conso;
	var D_prod = D_1_prod +  D_2_prod +  D_3_prod +  D_4_prod +  D_5_prod +  D_6_prod +  D_7_prod +  D_8_prod +  D_9_prod;
	document.getElementById("D_prod").innerHTML = D_prod;

	//Energie
	var NRJ = NRJ_1 +  NRJ_2 +  NRJ_3 +  NRJ_4 +  NRJ_5 +  NRJ_6 +  NRJ_7 +  NRJ_8 +  NRJ_9;
	var Delta_NRJ = NRJ - (M_conso + C_conso + D_conso);

	if (Delta_NRJ < 0) Delta_NRJ = "<font color='red'>"+Delta_NRJ+"</font>";
	else Delta_NRJ = "<font color='lime'>"+Delta_NRJ+"</font>";
	NRJ = "<font color='lime'>"+NRJ+"</font>"
	document.getElementById("NRJ").innerHTML = Delta_NRJ + " / " + NRJ;


	//
	// Points
	//

	init_b_prix = new Array(720, 1600000, 700, 2000, 3000, 4000, 800, 150000, 41000, 80000, 80000, 8000000);

	// Batiments planete 1

	var building_1 = document.getElementById("building_1").value;
	building_1 = building_1.split('<>');
	var b_pts_1 = ((60 + 15) * (1 - Math.pow(1.5, M_1)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_1)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_1)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_1)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_1)) / (-0.8));
	for(i=0; i<(building_1.length-2); i++) {
		b_pts_1 = b_pts_1 + init_b_prix[i] * (Math.pow(2, building_1[i]) - 1);
	}
	var total_pts_1 = b_pts_1;
	var total_b_pts = b_pts_1;
	document.getElementById("building_pts_1").innerHTML = Math.round(b_pts_1/1000);

	// Batiments planete 2

	var building_2 = document.getElementById("building_2").value;
	building_2 = building_2.split('<>');
	var b_pts_2 = ((60 + 15) * (1 - Math.pow(1.5, M_2)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_2)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_2)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_2)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_2)) / (-0.8));
	for(i=0; i<(building_2.length-2); i++) {
		b_pts_2 = b_pts_2 + init_b_prix[i] * (Math.pow(2, building_2[i]) - 1);
	}
	var total_pts_2 = b_pts_2;
	total_b_pts += b_pts_2;
	document.getElementById("building_pts_2").innerHTML = Math.round(b_pts_2/1000);

	// Batiments planete 3

	var building_3 = document.getElementById("building_3").value;
	building_3 = building_3.split('<>');
	var b_pts_3 = ((60 + 15) * (1 - Math.pow(1.5, M_3)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_3)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_3)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_3)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_3)) / (-0.8));
	for(i=0; i<(building_3.length-2); i++) {
		b_pts_3 = b_pts_3 + init_b_prix[i] * (Math.pow(2, building_3[i]) - 1);
	}
	var total_pts_3 = b_pts_3;
	total_b_pts += b_pts_3;
	document.getElementById("building_pts_3").innerHTML = Math.round(b_pts_3/1000);

	// Batiments planete 4

	var building_4 = document.getElementById("building_4").value;
	building_4 = building_4.split('<>');
	var b_pts_4 = ((60 + 15) * (1 - Math.pow(1.5, M_4)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_4)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_4)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_4)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_4)) / (-0.8));
	for(i=0; i<(building_4.length-2); i++) {
		b_pts_4 = b_pts_4 + init_b_prix[i] * (Math.pow(2, building_4[i]) - 1);
	}
	var total_pts_4 = b_pts_4;
	total_b_pts += b_pts_4;
	document.getElementById("building_pts_4").innerHTML = Math.round(b_pts_4/1000);

	// Batiments planete 5

	var building_5 = document.getElementById("building_5").value;
	building_5 = building_5.split('<>');
	var b_pts_5 = ((60 + 15) * (1 - Math.pow(1.5, M_5)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_5)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_5)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_5)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_5)) / (-0.8));
	for(i=0; i<(building_5.length-2); i++) {
		b_pts_5 = b_pts_5 + init_b_prix[i] * (Math.pow(2, building_5[i]) - 1);
	}
	var total_pts_5 = b_pts_5;
	total_b_pts += b_pts_5;
	document.getElementById("building_pts_5").innerHTML = Math.round(b_pts_5/1000);

	// Batiments planete 6

	var building_6 = document.getElementById("building_6").value;
	building_6 = building_6.split('<>');
	var b_pts_6 = ((60 + 15) * (1 - Math.pow(1.5, M_6)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_6)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_6)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_6)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_6)) / (-0.8));
	for(i=0; i<(building_6.length-2); i++) {
		b_pts_6 = b_pts_6 + init_b_prix[i] * (Math.pow(2, building_6[i]) - 1);
	}
	var total_pts_6 = b_pts_6;
	total_b_pts += b_pts_6;
	document.getElementById("building_pts_6").innerHTML = Math.round(b_pts_6/1000);

	// Batiments planete 7

	var building_7 = document.getElementById("building_7").value;
	building_7 = building_7.split('<>');
	var b_pts_7 = ((60 + 15) * (1 - Math.pow(1.5, M_7)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_7)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_7)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_7)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_7)) / (-0.8));
	for(i=0; i<(building_7.length-2); i++) {
		b_pts_7 = b_pts_7 + init_b_prix[i] * (Math.pow(2, building_7[i]) - 1);
	}
	var total_pts_7 = b_pts_7;
	total_b_pts += b_pts_7;
	document.getElementById("building_pts_7").innerHTML = Math.round(b_pts_7/1000);

	// Batiments planete 8

	var building_8 = document.getElementById("building_8").value;
	building_8 = building_8.split('<>');
	var b_pts_8 = ((60 + 15) * (1 - Math.pow(1.5, M_8)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_8)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_8)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_8)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_8)) / (-0.8));
	for(i=0; i<(building_8.length-2); i++) {
		b_pts_8 = b_pts_8 + init_b_prix[i] * (Math.pow(2, building_8[i]) - 1);
	}
	var total_pts_8 = b_pts_8;
	total_b_pts += b_pts_8;
	document.getElementById("building_pts_8").innerHTML = Math.round(b_pts_8/1000);

	// Batiments planete 9

	var building_9 = document.getElementById("building_9").value;
	building_9 = building_9.split('<>');
	var b_pts_9 = ((60 + 15) * (1 - Math.pow(1.5, M_9)) / (-0.5)) + ((48 + 24) * (1 - Math.pow(1.6, C_9)) / (-0.6)) + ((225 +75) * (1 - Math.pow(1.5, D_9)) / (-0.5)) + ((75 + 30) * (1 - Math.pow(1.5, CES_9)) / (-0.5)) + ((900 + 360 + 180) * (1 - Math.pow(1.8, CEF_9)) / (-0.8));
	for(i=0; i<(building_9.length-2); i++) {
		b_pts_9 = b_pts_9 + init_b_prix[i] * (Math.pow(2, building_9[i]) - 1);
	}
	var total_pts_9 = b_pts_9;
	total_b_pts += b_pts_9;
	document.getElementById("building_pts_9").innerHTML = Math.round(b_pts_9/1000);


	document.getElementById("total_b_pts").innerHTML = Math.round(total_b_pts/1000);


	init_d_prix = new Array(2000, 2000, 8000, 37000, 8000, 130000, 20000, 100000, 10000, 25000);

	// Defence planete 1

	var defence_1 = document.getElementById("defence_1").value;
	defence_1 = defence_1.split('<>');
	var d_pts_1 = 0;
	for(i=0; i<defence_1.length; i++) {
		d_pts_1 = d_pts_1 + init_d_prix[i] * defence_1[i];
	}
	total_pts_1 += d_pts_1;
	var total_d_pts = d_pts_1;
	document.getElementById("defence_pts_1").innerHTML = Math.round(d_pts_1/1000);

	// defense planete 2

	var defence_2 = document.getElementById("defence_2").value;
	defence_2 = defence_2.split('<>');
	var d_pts_2 = 0;
	for(i=0; i<defence_2.length; i++) {
		d_pts_2 = d_pts_2 + init_d_prix[i] * defence_2[i];
	}
	total_pts_2 += d_pts_2;
	total_d_pts += d_pts_2;
	document.getElementById("defence_pts_2").innerHTML = Math.round(d_pts_2/1000);

	// defense planete 3

	var defence_3 = document.getElementById("defence_3").value;
	defence_3 = defence_3.split('<>');
	var d_pts_3 = 0;
	for(i=0; i<defence_3.length; i++) {
		d_pts_3 = d_pts_3 + init_d_prix[i] * defence_3[i];
	}
	total_pts_3 += d_pts_3;
	total_d_pts += d_pts_3;
	document.getElementById("defence_pts_3").innerHTML = Math.round(d_pts_3/1000);

	// defense planete 4

	var defence_4 = document.getElementById("defence_4").value;
	defence_4 = defence_4.split('<>');
	var d_pts_4 = 0;
	for(i=0; i<defence_4.length; i++) {
		d_pts_4 = d_pts_4 + init_d_prix[i] * defence_4[i];
	}
	total_pts_4 += d_pts_4;
	total_d_pts += d_pts_4;
	document.getElementById("defence_pts_4").innerHTML = Math.round(d_pts_4/1000);

	// defense planete 5

	var defence_5 = document.getElementById("defence_5").value;
	defence_5 = defence_5.split('<>');
	var d_pts_5 = 0;
	for(i=0; i<defence_5.length; i++) {
		d_pts_5 = d_pts_5 + init_d_prix[i] * defence_5[i];
	}
	total_pts_5 += d_pts_5;
	total_d_pts += d_pts_5;
	document.getElementById("defence_pts_5").innerHTML = Math.round(d_pts_5/1000);

	// defense planete 6

	var defence_6 = document.getElementById("defence_6").value;
	defence_6 = defence_6.split('<>');
	var d_pts_6 = 0;
	for(i=0; i<defence_6.length; i++) {
		d_pts_6 = d_pts_6 + init_d_prix[i] * defence_6[i];
	}
	total_pts_6 += d_pts_6;
	total_d_pts += d_pts_6;
	document.getElementById("defence_pts_6").innerHTML = Math.round(d_pts_6/1000);

	// defense planete 7

	var defence_7 = document.getElementById("defence_7").value;
	defence_7 = defence_7.split('<>');
	var d_pts_7 = 0;
	for(i=0; i<defence_7.length; i++) {
		d_pts_7 = d_pts_7 + init_d_prix[i] * defence_7[i];
	}
	total_pts_7 += d_pts_7;
	total_d_pts += d_pts_7;
	document.getElementById("defence_pts_7").innerHTML = Math.round(d_pts_7/1000);

	// defense planete 8

	var defence_8 = document.getElementById("defence_8").value;
	defence_8 = defence_8.split('<>');
	var d_pts_8 = 0;
	for(i=0; i<defence_8.length; i++) {
		d_pts_8 = d_pts_8 + init_d_prix[i] * defence_8[i];
	}
	total_pts_8 += d_pts_8;
	total_d_pts += d_pts_8;
	document.getElementById("defence_pts_8").innerHTML = Math.round(d_pts_8/1000);

	// defense planete 9

	var defence_9 = document.getElementById("defence_9").value;
	defence_9 = defence_9.split('<>');
	var d_pts_9 = 0;
	for(i=0; i<defence_9.length; i++) {
		d_pts_9 = d_pts_9 + init_d_prix[i] * defence_9[i];
	}
	total_pts_9 += d_pts_9;
	total_d_pts += d_pts_9;
	document.getElementById("defence_pts_9").innerHTML = Math.round(d_pts_9/1000);

	document.getElementById("total_d_pts").innerHTML = Math.round(total_d_pts/1000);





	// Lune planete 1

	var lune_b_1 = document.getElementById("lune_b_10").value;
	lune_b_1 = lune_b_1.split('<>');
	var lune_defence_1 = document.getElementById("lune_d_10").value;
	lune_defence_1 = lune_defence_1.split('<>');
	var lune_pts_1 = 0;
	for(i=0; i<(lune_b_1.length-2); i++) {
		lune_pts_1 += init_b_prix[i] * (Math.pow(2, lune_b_1[i]) - 1);
	}
	for(i=0; i<lune_defence_1.length; i++) {
		lune_pts_1 += init_d_prix[i] * lune_defence_1[i];
	}
	var total_lune_pts = lune_pts_1;
	document.getElementById("lune_pts_10").innerHTML = Math.round(lune_pts_1/1000);

	// Lune planete 2

	var lune_b_2 = document.getElementById("lune_b_11").value;
	lune_b_2 = lune_b_2.split('<>');
	var lune_defence_2 = document.getElementById("lune_d_11").value;
	lune_defence_2 = lune_defence_2.split('<>');
	var lune_pts_2 = 0;
	for(i=0; i<(lune_b_2.length-2); i++) {
		lune_pts_2 += init_b_prix[i] * (Math.pow(2, lune_b_2[i]) - 1);
	}
	for(i=0; i<lune_defence_2.length; i++) {
		lune_pts_2 += init_d_prix[i] * lune_defence_2[i];
	}
	total_lune_pts += lune_pts_2;
	document.getElementById("lune_pts_11").innerHTML = Math.round(lune_pts_2/1000);

	// Lune planete 3

	var lune_b_3 = document.getElementById("lune_b_12").value;
	lune_b_3 = lune_b_3.split('<>');
	var lune_defence_3 = document.getElementById("lune_d_12").value;
	lune_defence_3 = lune_defence_3.split('<>');
	var lune_pts_3 = 0;
	for(i=0; i<(lune_b_3.length-2); i++) {
		lune_pts_3 += init_b_prix[i] * (Math.pow(2, lune_b_3[i]) - 1);
	}
	for(i=0; i<lune_defence_3.length; i++) {
		lune_pts_3 += init_d_prix[i] * lune_defence_3[i];
	}
	total_lune_pts += lune_pts_3;
	document.getElementById("lune_pts_12").innerHTML = Math.round(lune_pts_3/1000);

	// Lune planete 4

	var lune_b_4 = document.getElementById("lune_b_13").value;
	lune_b_4 = lune_b_4.split('<>');
	var lune_defence_4 = document.getElementById("lune_d_13").value;
	lune_defence_4 = lune_defence_4.split('<>');
	var lune_pts_4 = 0;
	for(i=0; i<(lune_b_4.length-2); i++) {
		lune_pts_4 += init_b_prix[i] * (Math.pow(2, lune_b_4[i]) - 1);
	}
	for(i=0; i<lune_defence_4.length; i++) {
		lune_pts_4 += init_d_prix[i] * lune_defence_4[i];
	}
	total_lune_pts += lune_pts_4;
	document.getElementById("lune_pts_13").innerHTML = Math.round(lune_pts_4/1000);

	// Lune planete 5

	var lune_b_5 = document.getElementById("lune_b_14").value;
	lune_b_5 = lune_b_5.split('<>');
	var lune_defence_5 = document.getElementById("lune_d_14").value;
	lune_defence_5 = lune_defence_5.split('<>');
	var lune_pts_5 = 0;
	for(i=0; i<(lune_b_5.length-2); i++) {
		lune_pts_5 += init_b_prix[i] * (Math.pow(2, lune_b_5[i]) - 1);
	}
	for(i=0; i<lune_defence_5.length; i++) {
		lune_pts_5 += init_d_prix[i] * lune_defence_5[i];
	}
	total_lune_pts += lune_pts_5;
	document.getElementById("lune_pts_14").innerHTML = Math.round(lune_pts_5/1000);

	// Lune planete 6

	var lune_b_6 = document.getElementById("lune_b_15").value;
	lune_b_6 = lune_b_6.split('<>');
	var lune_defence_6 = document.getElementById("lune_d_15").value;
	lune_defence_6 = lune_defence_6.split('<>');
	var lune_pts_6 = 0;
	for(i=0; i<(lune_b_6.length-2); i++) {
		lune_pts_6 += init_b_prix[i] * (Math.pow(2, lune_b_6[i]) - 1);
	}
	for(i=0; i<lune_defence_6.length; i++) {
		lune_pts_6 += init_d_prix[i] * lune_defence_6[i];
	}
	total_lune_pts += lune_pts_6;
	document.getElementById("lune_pts_15").innerHTML = Math.round(lune_pts_6/1000);

	// Lune planete 7

	var lune_b_7 = document.getElementById("lune_b_16").value;
	lune_b_7 = lune_b_7.split('<>');
	var lune_defence_7 = document.getElementById("lune_d_16").value;
	lune_defence_7 = lune_defence_7.split('<>');
	var lune_pts_7 = 0;
	for(i=0; i<(lune_b_7.length-2); i++) {
		lune_pts_7 += init_b_prix[i] * (Math.pow(2, lune_b_7[i]) - 1);
	}
	for(i=0; i<lune_defence_7.length; i++) {
		lune_pts_7 += init_d_prix[i] * lune_defence_7[i];
	}
	total_lune_pts += lune_pts_7;
	document.getElementById("lune_pts_16").innerHTML = Math.round(lune_pts_7/1000);

	// Lune planete 8

	var lune_b_8 = document.getElementById("lune_b_17").value;
	lune_b_8 = lune_b_8.split('<>');
	var lune_defence_8 = document.getElementById("lune_d_17").value;
	lune_defence_8 = lune_defence_8.split('<>');
	var lune_pts_8 = 0;
	for(i=0; i<(lune_b_8.length-2); i++) {
		lune_pts_8 += init_b_prix[i] * (Math.pow(2, lune_b_8[i]) - 1);
	}
	for(i=0; i<lune_defence_8.length; i++) {
		lune_pts_8 += init_d_prix[i] * lune_defence_8[i];
	}
	total_lune_pts += lune_pts_8;
	document.getElementById("lune_pts_17").innerHTML = Math.round(lune_pts_8/1000);

	// Lune planete 9

	var lune_b_9 = document.getElementById("lune_b_18").value;
	lune_b_9 = lune_b_9.split('<>');
	var lune_defence_9 = document.getElementById("lune_d_18").value;
	lune_defence_9 = lune_defence_9.split('<>');
	var lune_pts_9 = 0;
	for(i=0; i<(lune_b_9.length-2); i++) {
		lune_pts_9 += init_b_prix[i] * (Math.pow(2, lune_b_9[i]) - 1);
	}
	for(i=0; i<lune_defence_9.length; i++) {
		lune_pts_9 += init_d_prix[i] * lune_defence_9[i];
	}
	total_lune_pts += lune_pts_9;
	document.getElementById("lune_pts_18").innerHTML = Math.round(lune_pts_9/1000);

	document.getElementById("total_lune_pts").innerHTML = Math.round(total_lune_pts/1000);


// ReSo planete
	
	var ReSo_lune_1 = document.getElementById("ReSo_lune_1").value;
	var ReSo_pts_1 = Math.round(ReSo_1*2.5+ReSo_lune_1*2.5);
	document.getElementById("ReSo_pts_1").innerHTML = "<font color='lime'>"+ReSo_pts_1+"</font>";
	var ReSo_lune_2 = document.getElementById("ReSo_lune_2").value;
	var ReSo_pts_2 = Math.round(ReSo_2*2.5+ReSo_lune_2*2.5);
	document.getElementById("ReSo_pts_2").innerHTML = "<font color='lime'>"+ReSo_pts_2+"</font>";
	var ReSo_lune_3 = document.getElementById("ReSo_lune_3").value;
	var ReSo_pts_3 = Math.round(ReSo_3*2.5+ReSo_lune_3*2.5);
	document.getElementById("ReSo_pts_3").innerHTML = "<font color='lime'>"+ReSo_pts_3+"</font>";
	var ReSo_lune_4 = document.getElementById("ReSo_lune_4").value;
	var ReSo_pts_4 = Math.round(ReSo_4*2.5+ReSo_lune_4*2.5);
	document.getElementById("ReSo_pts_4").innerHTML = "<font color='lime'>"+ReSo_pts_4+"</font>";
	var ReSo_lune_5 = document.getElementById("ReSo_lune_5").value;
	var ReSo_pts_5 = Math.round(ReSo_5*2.5+ReSo_lune_5*2.5);
	document.getElementById("ReSo_pts_5").innerHTML = "<font color='lime'>"+ReSo_pts_5+"</font>";
	var ReSo_lune_6 = document.getElementById("ReSo_lune_6").value;
	var ReSo_pts_6 = Math.round(ReSo_6*2.5+ReSo_lune_6*2.5);
	document.getElementById("ReSo_pts_6").innerHTML = "<font color='lime'>"+ReSo_pts_6+"</font>";
	var ReSo_lune_7 = document.getElementById("ReSo_lune_7").value;
	var ReSo_pts_7 = Math.round(ReSo_7*2.5+ReSo_lune_7*2.5);
	document.getElementById("ReSo_pts_7").innerHTML = "<font color='lime'>"+ReSo_pts_7+"</font>";
	var ReSo_lune_8 = document.getElementById("ReSo_lune_8").value;
	var ReSo_pts_8 = Math.round(ReSo_8*2.5+ReSo_lune_8*2.5);
	document.getElementById("ReSo_pts_8").innerHTML = "<font color='lime'>"+ReSo_pts_8+"</font>";
	var ReSo_lune_9 = document.getElementById("ReSo_lune_9").value;
	var ReSo_pts_9 = Math.round(ReSo_9*2.5+ReSo_lune_9*2.5);
	document.getElementById("ReSo_pts_9").innerHTML = "<font color='lime'>"+ReSo_pts_9+"</font>";
	
	var total_ReSo_pts = ReSo_pts_1+ReSo_pts_2+ReSo_pts_3+ReSo_pts_4+ReSo_pts_5+ReSo_pts_6+ReSo_pts_7+ReSo_pts_8+ReSo_pts_9;
	
	document.getElementById("total_ReSo_pts").innerHTML = total_ReSo_pts;
	
	
	document.getElementById("total_pts_1").innerHTML = Math.round((total_pts_1 + lune_pts_1)/1000)+ReSo_pts_1;
	document.getElementById("total_pts_2").innerHTML = Math.round((total_pts_2 + lune_pts_2)/1000)+ReSo_pts_2;
	document.getElementById("total_pts_3").innerHTML = Math.round((total_pts_3 + lune_pts_3)/1000)+ReSo_pts_3;
	document.getElementById("total_pts_4").innerHTML = Math.round((total_pts_4 + lune_pts_4)/1000)+ReSo_pts_4;
	document.getElementById("total_pts_5").innerHTML = Math.round((total_pts_5 + lune_pts_5)/1000)+ReSo_pts_5;
	document.getElementById("total_pts_6").innerHTML = Math.round((total_pts_6 + lune_pts_6)/1000)+ReSo_pts_6;
	document.getElementById("total_pts_7").innerHTML = Math.round((total_pts_7 + lune_pts_7)/1000)+ReSo_pts_7;
	document.getElementById("total_pts_8").innerHTML = Math.round((total_pts_8 + lune_pts_8)/1000)+ReSo_pts_8;
	document.getElementById("total_pts_9").innerHTML = Math.round((total_pts_9 + lune_pts_9)/1000)+ReSo_pts_9;
	
	document.getElementById("total_pts").innerHTML = Math.round((total_b_pts + total_d_pts + total_lune_pts)/1000)+total_ReSo_pts;



	// Technologies planete avec le labo de plus au niveau

	init_t_prix = new Array(1400, 1000, 1000, 800, 1000, 1200, 6000, 1000, 6600, 36000, 300, 1400, 7000, 800000);

	var techno = document.getElementById("techno").value;
	techno = techno.split('<>');
	var techno_pts = 0;
	for(i=0; i<(techno.length-1); i++) {
		techno_pts = techno_pts + init_t_prix[i] * (Math.pow(2, techno[i]) - 1);
	}
	document.getElementById("techno_pts").innerHTML = Math.round(techno_pts/1000);
}
