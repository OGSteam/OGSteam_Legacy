/*
* simulation_mip.js Fait les simulations de missiles
* @package [MOD] Tout sur les MIP
* @author darksteel
* @version 0.4a
*/

function temps_vol() {

	var maxii = Math.max(document.Eingaben.arriv.value,document.Eingaben.dep.value);
	var minii = Math.min(document.Eingaben.arriv.value,document.Eingaben.dep.value);

	var distancea = maxii - minii;

	var tempp = ((distancea*60)+30)/60;
	var mnn = Math.abs(Math.floor(tempp));
	var ss = (tempp - mnn);
	var secc = 60*ss;
	if (mnn == 0){
		document.getElementById("temps_vol").innerHTML = secc+" secondes";
	} else {
		document.getElementById("temps_vol").innerHTML = mnn+" mn "+secc+" secondes";
	}
};

function sim() {

	for (var i = 0; i < 12; i++) {
		if (document.Eingaben.a[i].value == "") document.Eingaben.a[i].value = "0";
	}
	/* Variablen initialisieren */
	var metall = new Array(8);
	var kristall = new Array(8);
	var deuterium = new Array(8);
	var verloren = new Array(8);
	var uebrig = new Array(8);
	var hull = new Array(8);
	var temp;
	var t_m = 0, t_c = 0, t_d = 0, t_v = 0, t_k = 0;
	var m_cost = new Array(2,1.5,6,20,2,50,10,50);
	var c_cost = new Array(0,0.5,2,15,6,50,10,50);
	var d_cost = new Array(0,0,0,2,0,30,0,0);
	var iraks = parseInt(document.Eingaben.a[10].value);
	var araks = parseInt(document.Eingaben.a[8].value);
	var pziel = document.Eingaben.priz.selectedIndex;
	var z = 8;
	if (pziel == 8) pziel = 7;
	hull[0] = hull[1] = 200*(1+(parseInt(document.Eingaben.a[9].value)/10));
	hull[2] = hull[4] = 800*(1+(parseInt(document.Eingaben.a[9].value)/10));
	hull[3] = 3500*(1+(parseInt(document.Eingaben.a[9].value)/10));
	hull[5] = hull[7] = 10000*(1+(parseInt(document.Eingaben.a[9].value)/10));
	hull[6] = 2000*(1+(parseInt(document.Eingaben.a[9].value)/10));
	var schaden = (parseInt(document.Eingaben.a[10].value)-parseInt(document.Eingaben.a[8].value))*(12000*(1+(parseInt(document.Eingaben.a[11].value)/10)));
	/* Ergebnis für Abfang- und IP - Raks anzeigen */
	if(schaden>=0) {
		if(araks > 0) {
			document.getElementById("v9").innerHTML = "0";
			document.getElementById("k9").innerHTML = document.Eingaben.a[8].value;
			document.getElementById("m9").innerHTML = document.Eingaben.a[8].value * 8 + " k";
			document.getElementById("c9").innerHTML = "0";
			document.getElementById("d9").innerHTML = document.Eingaben.a[8].value * 2 + " k";
		} else {
			document.getElementById("v9").innerHTML = "-";
			document.getElementById("k9").innerHTML = "-";
			document.getElementById("m9").innerHTML = "-";
			document.getElementById("c9").innerHTML = "-";
			document.getElementById("d9").innerHTML = "-";
		}
	} else {
		document.getElementById("v9").innerHTML = araks-iraks;
		document.getElementById("k9").innerHTML = iraks;
		document.getElementById("m9").innerHTML = iraks * 8 + " k";
		document.getElementById("c9").innerHTML = "0";
		document.getElementById("d9").innerHTML = iraks * 2 + " k";
	}
	if (iraks > 0) {
		document.getElementById("v10").innerHTML = "0";
		document.getElementById("k10").innerHTML = iraks;
		document.getElementById("m10").innerHTML = iraks * 12.5 + " k";
		document.getElementById("c10").innerHTML = iraks * 2.5 + " k";
		document.getElementById("d10").innerHTML = iraks * 10 + " k";
	} else {
		document.getElementById("v10").innerHTML = "-";
		document.getElementById("k10").innerHTML = "-";
		document.getElementById("m10").innerHTML = "-";
		document.getElementById("c10").innerHTML = "-";
		document.getElementById("d10").innerHTML = "-";
	}
	/* Schadensberechnung */
	if (document.Eingaben.priz.selectedIndex == 8) {
		z = 5;
		for (i=7;i>5;i--) { 
			if(parseInt(document.Eingaben.a[i].value) > 0) {
				temp = Math.floor((schaden / hull[i]));
				if (document.Eingaben.a[i].value < temp) temp -= (temp - parseInt(document.Eingaben.a[i].value));
				document.getElementById("v"+i).innerHTML = parseInt(document.Eingaben.a[i].value) - temp;
				document.getElementById("k"+i).innerHTML = temp;
				document.getElementById("m"+i).innerHTML = m_cost[i] * temp + " k";
				document.getElementById("c"+i).innerHTML = c_cost[i] * temp + " k";
				document.getElementById("d"+i).innerHTML = d_cost[i] * temp + " k";
				schaden -= temp * hull[i];
				t_v += parseInt(document.Eingaben.a[i].value) - temp;
				t_k += temp;
				t_m += temp * m_cost[i];
				t_c += temp * c_cost[i];
				t_d += temp * d_cost[i];
			} else {
				document.getElementById("v"+i).innerHTML = "-";
				document.getElementById("k"+i).innerHTML = "-";
				document.getElementById("m"+i).innerHTML = "-";
				document.getElementById("c"+i).innerHTML = "-";
				document.getElementById("d"+i).innerHTML = "-";
			}
		};
	}
	if (parseInt(document.Eingaben.a[pziel].value) > 0) {
		temp = Math.floor((schaden / hull[pziel]));
		if (document.Eingaben.a[pziel].value < temp) temp -= (temp - parseInt(document.Eingaben.a[pziel].value));
		document.getElementById("v"+pziel).innerHTML = parseInt(document.Eingaben.a[pziel].value) - temp;
		document.getElementById("k"+pziel).innerHTML = temp;
		document.getElementById("m"+pziel).innerHTML = m_cost[pziel] * temp + " k";
		document.getElementById("c"+pziel).innerHTML = c_cost[pziel] * temp + " k";
		document.getElementById("d"+pziel).innerHTML = d_cost[pziel] * temp + " k";
		schaden -= temp * hull[pziel];
		t_v += parseInt(document.Eingaben.a[pziel].value) - temp;
		t_k += temp;
		t_m += temp * m_cost[pziel];
		t_c += temp * c_cost[pziel];
		t_d += temp * d_cost[pziel];
	} else {
		document.getElementById("v"+pziel).innerHTML = "-";
		document.getElementById("k"+pziel).innerHTML = "-";
		document.getElementById("m"+pziel).innerHTML = "-";
		document.getElementById("c"+pziel).innerHTML = "-";
		document.getElementById("d"+pziel).innerHTML = "-";
	}
	for (i=0;i<z;i++) { 
		if (i != pziel) {
			if (parseInt(document.Eingaben.a[i].value) > 0) {
				temp = Math.floor((schaden / hull[i]));
				if (document.Eingaben.a[i].value < temp) temp -= (temp - parseInt(document.Eingaben.a[i].value));
				document.getElementById("v"+i).innerHTML = parseInt(document.Eingaben.a[i].value) - temp;
				document.getElementById("k"+i).innerHTML = temp;
				document.getElementById("m"+i).innerHTML = m_cost[i] * temp + " k";
				document.getElementById("c"+i).innerHTML = c_cost[i] * temp + " k";
				document.getElementById("d"+i).innerHTML = d_cost[i] * temp + " k";
				schaden -= temp * hull[i];
				t_v += parseInt(document.Eingaben.a[i].value) - temp;
				t_k += temp;
				t_m += temp * m_cost[i];
				t_c += temp * c_cost[i];
				t_d += temp * d_cost[i];
			} else {
				document.getElementById("v"+i).innerHTML = "-";
				document.getElementById("k"+i).innerHTML = "-";
				document.getElementById("m"+i).innerHTML = "-";
				document.getElementById("c"+i).innerHTML = "-";
				document.getElementById("d"+i).innerHTML = "-";
			}
		}
	};
	document.getElementById("v8").innerHTML = t_v;
	document.getElementById("k8").innerHTML = t_k;
	document.getElementById("m8").innerHTML = t_m + " k";
	document.getElementById("c8").innerHTML = t_c + " k";
	document.getElementById("d8").innerHTML = t_d + " k";
};

function sim2() {
	for (var i=0;i<12;i++) {
		if (document.Eingaben.a[i].value == "") document.Eingaben.a[i].value = "0";
	};
	var schaden = 12000 * (1+(parseInt(document.Eingaben.a[11].value)/10));
	var noetig = ((parseInt(document.Eingaben.a[0].value)+parseInt(document.Eingaben.a[1].value))*200 + (parseInt(document.Eingaben.a[2].value)+parseInt(document.Eingaben.a[4].value))*800 + parseInt(document.Eingaben.a[3].value)*3500 + (parseInt(document.Eingaben.a[5].value)+parseInt(document.Eingaben.a[7].value))*10000 + parseInt(document.Eingaben.a[6].value)*2000)*(1+(parseInt(document.Eingaben.a[9].value)/10)); 
	var req = Math.floor(noetig/schaden+0.99999999999999) + parseInt(document.Eingaben.a[8].value);
	alert("Missiles requis : " + req + " ( " + req*12500 + " Métal, " + req*2500 + " Cristal, " + req*10000 + " Deutérium )");
};

function lesen() {
	var text = document.Eingaben.Bericht.value;
	var text = points(text);
	if (text.indexOf('Défense') != -1) {
		var Pos1 = text.indexOf('Lanceur de missiles');
		var Pos2 = text.indexOf('Artillerie laser légère');
		var Pos3 = text.indexOf('Artillerie laser lourde');
		var Pos4 = text.indexOf('Artillerie à ions');
		var Pos5 = text.indexOf('Canon de Gauss');
		var Pos6 = text.indexOf('Lanceur de plasma');
		var Pos9 = text.indexOf('Missile Interception');
		var a = parseInt(text.substring(Pos1 + 20,Pos1 + 28));
		var b = parseInt(text.substring(Pos2 + 23,Pos2 + 31));
		var c = parseInt(text.substring(Pos3 + 23,Pos3 + 31));
		var d = parseInt(text.substring(Pos4 + 18,Pos4 + 27));
		var e = parseInt(text.substring(Pos5 + 14,Pos5 + 22));
		var f = parseInt(text.substring(Pos6 + 17,Pos6 + 27));
		var g = parseInt(text.substring(Pos9 + 20,Pos9 + 30));
		if (Pos1 == -1) a = 0;
		if (Pos2 == -1) b = 0;
		if (Pos3 == -1) c = 0;
		if (Pos4 == -1) d = 0;
		if (Pos5 == -1) e = 0;
		if (Pos6 == -1) f = 0;
		if (Pos9 == -1) g = 0;
		document.Eingaben.a[0].value = a;
		document.Eingaben.a[1].value = b;
		document.Eingaben.a[2].value = c;
		document.Eingaben.a[4].value = d;
		document.Eingaben.a[3].value = e;
		document.Eingaben.a[5].value = f;
		document.Eingaben.a[8].value = g;
		if (text.indexOf('Petit bouclier') != -1) document.Eingaben.a[6].value = "1";
		else document.Eingaben.a[6].value = "0";
		if (text.indexOf('Grand bouclier') != -1) document.Eingaben.a[7].value = "1";
		else document.Eingaben.a[7].value = "0";
		if (text.indexOf('Technologie Protection des vaisseaux spatiaux') != -1) {
			Pos10 = text.indexOf('Technologie Protection des vaisseaux spatiaux');
			document.Eingaben.a[9].value = parseInt(text.substring(Pos10 + 45,Pos10 + 50));
		}
	} else alert("Le rapport d'espionnage est incomplet !");
}

function points(texte) {
	/* Supression des . (points) créé par Christ24 */
	var aRemplacer = /\./g;
	texte = texte.replace(aRemplacer, "");
	return texte;
}