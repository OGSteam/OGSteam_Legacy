/***************************************************************************
*	filename	: function.js
*	desc.		: Fonctions JavaScript de 'Optimisation de la défence'
*	Author		: Lothadith
*	created		: 15/12/2006
*	modified	: 03/09/2007
*	version		: 0.8b
***************************************************************************/

// Changer la couleur de la sélection
function autofill(planet_id) {
	var i = 1;
	var lign = 0;
	var id = 0;
	var lim = 8;
	
	if(planet_id > 9) {
		lim = 19;
		planet_id -= 9; 
	}
	for(i = 1; i <= 9; i++) {
		for(lign = 1; lign <= lim; lign++) {
			id = lign*10+i;
			if (document.getElementById(id).value.split(">").length != 2) {
				document.getElementById("col_"+id).style.color = 'lime'; } } }

	for(i = 1; i <= lim; i++) {
		id = i*10+planet_id;
		if (document.getElementById(id).value.split(">").length != 2) {
			document.getElementById("col_"+id).style.color = 'yellow'; } }
	
	if (document.getElementById('opt_def_fixe').value != 'fixer_0') {
		fix_defence(planet_id); }
}

// Activation de la boîte de fixation des unités
function fix_defence(planet_id) {
	if (document.getElementById('opt_def_fixe').value != 'fixer_0') {
		id_option = 0;
		for ( i = 1; i < 7; i++) {
			if (document.getElementById(i).value == document.getElementById('opt_def_fixe').value) {
				id_option = i;
				i = 7; } }
		
		if (planet_id != 0) {
			for (i = 1; i < 10; i++) {
				if (i != planet_id) { raz_defence(i); }
				else {
					document.getElementById('fixer_' + i).disabled = false;
					document.getElementById('fixer_' + i).title = "Fixer le nombre de " + document.getElementById('opt_def_fixe').value;
					if (document.getElementById(i+(10*id_option)).value.indexOf(" ") != -1) {
						document.getElementById('fixer_' + i).value = document.getElementById(i+(10*id_option)).value.slice(0, document.getElementById(i+(10*id_option)).value.indexOf(" ")); }
					else { document.getElementById('fixer_' + i).value = document.getElementById(i+(10*id_option)).value; } } } }
		else {
			for (i = 1; i < 10; i++) {
				// Trouver la planète active
				if (document.getElementById("col_"+(i+10)).style.color == 'yellow' || document.getElementById("col_"+(i+20)).style.color == 'yellow') {
					document.getElementById('fixer_' + i).disabled = false;
					document.getElementById('fixer_' + i).title = "Fixer le nombre de " + document.getElementById('opt_def_fixe').value;
					if (document.getElementById(i+(10*id_option)).value.indexOf(" ") != -1) {
						document.getElementById('fixer_' + i).value =  document.getElementById(i+(10*id_option)).value.slice(0, document.getElementById(i+(10*id_option)).value.indexOf(" ")); }
					else { document.getElementById('fixer_' + i).value = document.getElementById(i+(10*id_option)).value; } } } } }
	
	else { for (i = 1; i < 10; i++) { raz_defence(i); } }
}

// Vider les boîtes inutilisées des unités fixées
function raz_defence(i) {
	document.getElementById('fixer_' + i).disabled = true;
	document.getElementById('fixer_' + i).title = '';
	document.getElementById('fixer_' + i).value = '';
}

// Effacer la boîte de réception des données importées de OGame
function clear_text2() {
	document.sub_optimize.data.value = "";
}

// Lancer la page de simulation de bataille
function open_simulator(simulator, armes, bouclier, protection, flottes, attack) {
	var def_url_out;
	var val_tmp;
	var index_flotte;
	index_flotte = 0;
	
	for (i = 1; i < 10; i++) {
		// Trouver la planète active
		if (document.getElementById("col_"+(i+10)).style.color == 'yellow' || document.getElementById("col_"+(i+20)).style.color == 'yellow') {
			// Trouver la flotte correspondant à la planète active
			if (flottes != 0) {
				for (j = 1; j < 10; j++) {
					if (document.getElementById(i+100).value == flottes[j][0]) {
						index_flotte = j;
						j = 10; } } }

			switch (simulator) {
				case "speedsim" :
					def_url_out = "http://websim.speedsim.net/?lang=fr&";

					// Insérer la flotte attaquante
					for (j = 0; j < 15; j++) {
						k = (j < 11) ? j+2 : j+1;
						def_url_out += "ship_a0_"+j+"_b="+attack[1][k]+"&"; }

					// Insérer la flotte défensive
					if (index_flotte != 0) {
						// Si l'utilisateur le souhaite
						if (attack[1][15] == 1) {
							for (j = 0; j < 14; j++) {
								def_url_out += "ship_d0_"+j+"_b="+flottes[index_flotte][j+2]+"&"; } }
						// Sinon ne mettre que les satellites solaires
						else {
							def_url_out += "ship_d0_10_b="+flottes[index_flotte][12]+"&"; } }


					// Insérer la défense
					for (j = 1; j < 9; j++) {
						if (document.getElementById(i+(j*10)).value.indexOf(" ") != -1) {
							val_tmp = document.getElementById(i+(j*10)).value.substring(0, document.getElementById(i+(j*10)).value.indexOf(" "));
							if (document.getElementById("simu").checked == true) {
								if (document.getElementById(i+(j*10)).value.indexOf("(") != -1) {
									val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+(j*10)).value.substring(document.getElementById(i+(j*10)).value.indexOf("(") + 1, document.getElementById(i+(j*10)).value.indexOf(")"))); }
								else {
									val_tmp = document.getElementById(i+(j*10)).value.substring(document.getElementById(i+(j*10)).value.indexOf(">") + 1, document.getElementById(i+(j*10)).value.length); } }
							def_url_out += "ship_d0_"+(j+13)+"_b="+val_tmp+"&"; }
						else {
							def_url_out += "ship_d0_"+(j+13)+"_b="+document.getElementById(i+(j*10)).value+"&"; } }

					// Insérer les technologies de l'attaquant
					for (j = 0; j < 3; j++) {
						def_url_out += "tech_a0_"+j+"="+attack[1][j+16]+"&"; }

					// Insérer les technologies de la défense
					def_url_out += "tech_d0_0="+armes+"&";
					def_url_out += "tech_d0_1="+bouclier+"&";
					def_url_out += "tech_d0_2="+protection;

					break;
				case "dragosim" :
					def_url_out = "http://drago-sim.com/index.php?lang=french&";

					// Insérer la flotte attaquante
					def_url_out += "numunits[0][0][k_t]="+attack[1][2]+"&";
					def_url_out += "numunits[0][0][g_t]="+attack[1][3]+"&";
					def_url_out += "numunits[0][0][l_j]="+attack[1][4]+"&";
					def_url_out += "numunits[0][0][s_j]="+attack[1][5]+"&";
					def_url_out += "numunits[0][0][kr]="+attack[1][6]+"&";
					def_url_out += "numunits[0][0][sc]="+attack[1][7]+"&";
					def_url_out += "numunits[0][0][ko]="+attack[1][8]+"&";
					def_url_out += "numunits[0][0][re]="+attack[1][9]+"&";
					def_url_out += "numunits[0][0][sp]="+attack[1][10]+"&";
					def_url_out += "numunits[0][0][bo]="+attack[1][11]+"&";
					def_url_out += "numunits[0][0][z]="+attack[1][12]+"&";
					def_url_out += "numunits[0][0][t]="+attack[1][13]+"&";
					def_url_out += "numunits[0][0][sk]="+attack[1][14]+"&";

					// Insérer la flotte défensive
					if (index_flotte != 0) {
						// Si l'utilisateur le souhaite
						if (attack[1][15] == 1) {
							def_url_out += "numunits[1][0][k_t]="+flottes[index_flotte][2]+"&";
							def_url_out += "numunits[1][0][g_t]="+flottes[index_flotte][3]+"&";
							def_url_out += "numunits[1][0][l_j]="+flottes[index_flotte][4]+"&";
							def_url_out += "numunits[1][0][s_j]="+flottes[index_flotte][5]+"&";
							def_url_out += "numunits[1][0][kr]="+flottes[index_flotte][6]+"&";
							def_url_out += "numunits[1][0][sc]="+flottes[index_flotte][7]+"&";
							def_url_out += "numunits[1][0][ko]="+flottes[index_flotte][8]+"&";
							def_url_out += "numunits[1][0][re]="+flottes[index_flotte][9]+"&";
							def_url_out += "numunits[1][0][sp]="+flottes[index_flotte][10]+"&";
							def_url_out += "numunits[1][0][bo]="+flottes[index_flotte][11]+"&";
							def_url_out += "numunits[1][0][so]="+flottes[index_flotte][12]+"&";
							def_url_out += "numunits[1][0][z]="+flottes[index_flotte][13]+"&";
							def_url_out += "numunits[1][0][t]="+flottes[index_flotte][14]+"&";
							def_url_out += "numunits[1][0][sk]="+flottes[index_flotte][15]+"&"; }
						// Sinon ne mettre que les satellites solaires
						else {
							def_url_out += "numunits[1][0][so]="+flottes[index_flotte][12]+"&"; } }

					// Insérer la défense
					if (document.getElementById(i+10).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+10).value.substring(0, document.getElementById(i+10).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+10).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+10).value.substring(document.getElementById(i+10).value.indexOf("(") + 1, document.getElementById(i+10).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+10).value.substring(document.getElementById(i+10).value.indexOf(">") + 1, document.getElementById(i+10).value.length); } }
						def_url_out += "numunits[1][0][ra]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][ra]="+document.getElementById(i+10).value+"&"; }
					if (document.getElementById(i+20).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+20).value.substring(0, document.getElementById(i+20).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+20).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+20).value.substring(document.getElementById(i+20).value.indexOf("(") + 1, document.getElementById(i+20).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+20).value.substring(document.getElementById(i+20).value.indexOf(">") + 1, document.getElementById(i+20).value.length); } }
						def_url_out += "numunits[1][0][l_l]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][l_l]="+document.getElementById(i+20).value+"&"; }
					if (document.getElementById(i+30).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+30).value.substring(0, document.getElementById(i+30).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+30).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+30).value.substring(document.getElementById(i+30).value.indexOf("(") + 1, document.getElementById(i+30).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+30).value.substring(document.getElementById(i+30).value.indexOf(">") + 1, document.getElementById(i+30).value.length); } }
						def_url_out += "numunits[1][0][s_l]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][s_l]="+document.getElementById(i+30).value+"&"; }
					if (document.getElementById(i+40).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+40).value.substring(0, document.getElementById(i+40).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+40).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+40).value.substring(document.getElementById(i+40).value.indexOf("(") + 1, document.getElementById(i+40).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+40).value.substring(document.getElementById(i+40).value.indexOf(">") + 1, document.getElementById(i+40).value.length); } }
						def_url_out += "numunits[1][0][g]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][g]="+document.getElementById(i+40).value+"&"; }
					if (document.getElementById(i+50).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+50).value.substring(0, document.getElementById(i+50).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+50).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+50).value.substring(document.getElementById(i+50).value.indexOf("(") + 1, document.getElementById(i+50).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+50).value.substring(document.getElementById(i+50).value.indexOf(">") + 1, document.getElementById(i+50).value.length); } }
						def_url_out += "numunits[1][0][i]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][i]="+document.getElementById(i+50).value+"&"; }
					if (document.getElementById(i+60).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+60).value.substring(0, document.getElementById(i+60).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+60).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+60).value.substring(document.getElementById(i+60).value.indexOf("(") + 1, document.getElementById(i+60).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+60).value.substring(document.getElementById(i+60).value.indexOf(">") + 1, document.getElementById(i+60).value.length); } }
						def_url_out += "numunits[1][0][p]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][p]="+document.getElementById(i+60).value+"&"; }
					if (document.getElementById(i+70).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+70).value.substring(0, document.getElementById(i+70).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+70).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+70).value.substring(document.getElementById(i+70).value.indexOf("(") + 1, document.getElementById(i+70).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+70).value.substring(document.getElementById(i+70).value.indexOf(">") + 1, document.getElementById(i+70).value.length); } }
						def_url_out += "numunits[1][0][k_s]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][k_s]="+document.getElementById(i+70).value+"&"; }
					if (document.getElementById(i+80).value.indexOf(" ") != -1) {
						val_tmp = document.getElementById(i+80).value.substring(0, document.getElementById(i+80).value.indexOf(" "));
						if (document.getElementById("simu").checked == true) {
							if (document.getElementById(i+80).value.indexOf("(") != -1) {
								val_tmp = parseInt(val_tmp) + parseInt(document.getElementById(i+80).value.substring(document.getElementById(i+80).value.indexOf("(") + 1, document.getElementById(i+80).value.indexOf(")"))); }
							else {
								val_tmp = document.getElementById(i+80).value.substring(document.getElementById(i+80).value.indexOf(">") + 1, document.getElementById(i+80).value.length); } }
						def_url_out += "numunits[1][0][g_s]="+val_tmp+"&"; }
					else {
						def_url_out += "numunits[1][0][g_s]="+document.getElementById(i+80).value+"&"; }

					// Insérer les technologies de l'attaquant
					def_url_out += "techs[0][0][w_t]="+attack[1][16]+"&";
					def_url_out += "techs[0][0][s_t]="+attack[1][17]+"&";
					def_url_out += "techs[0][0][r_p]="+attack[1][18]+"&";

					// Insérer les technologies de la défense
					def_url_out += "techs[1][0][w_t]="+armes+"&";
					def_url_out += "techs[1][0][s_t]="+bouclier+"&";
					def_url_out += "techs[1][0][r_p]="+protection;

					break;
				default :
					alert("Une erreur est survenue dans le choix du simulateur. Contactez le blaireau qui a pondu ce code de merde tout buggué.");
					return; }

			// Ouverture du simulateur
			window.open(def_url_out);
			return; } }
	
	alert("Aucune planète sélectionnée.");
}
