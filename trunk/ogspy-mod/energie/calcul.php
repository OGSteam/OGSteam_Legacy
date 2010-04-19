<?php
/***************************************************************************
*	filename	: calcul.php
*	package		: Mod Energie
*	version		: 0.8
*	desc.			: Calcul du moyen de production d'énergie le plus rentable
*	Authors		: Scaler - http://ogsteam.fr
*	created		: 10:33 08/11/2007
*	modified	: 09:53 05/09/2009
***************************************************************************/

if (!defined('IN_SPYOGAME')) die("Hacking attempt");

$user_empire = user_get_empire();
$user_building = $user_empire["building"];
$user_technology = $user_empire["technology"];
$sep_mille = $lang['energy_thousands_separator'];
$query = mysql_fetch_assoc(mysql_query("SELECT `off_ingenieur` FROM ".TABLE_USER." WHERE `user_id` = ".$user_data["user_id"]));
$ingenieur = $query["off_ingenieur"];
// Récupération des pourcentages des mines
$quet = mysql_query("SELECT planet_id, M_percentage, C_percentage, D_percentage FROM ".TABLE_USER_BUILDING." WHERE user_id = ".$user_data["user_id"]." AND planet_id < 10 ORDER BY planet_id");
while ($row = mysql_fetch_assoc($quet)) {
	$arr = $row;
	unset($arr["planet_id"]);
	$user_percentage[$row["planet_id"]] = $arr;
}
?>
<script type="text/javascript">
// Récupération des valeurs de la base de données
donnees = new Array();
planetes = new Array();
<?php
$n = 0;
for ($i=1;$i<=9;$i++) {
	if ($user_building[$i]['planet_name'] != '') {
		echo "donnees[".$i."] = new Array(".
			$user_building[$i]['M'].", ".
			$user_building[$i]['C'].", ".
			$user_building[$i]['D'].", ".
			$user_building[$i]['Ter'].", ".
			$user_technology['Graviton'].", ".
			$user_building[$i]['CES'].", ".
			$user_building[$i]['CEF'].", ".
			$user_building[$i]['Sat'].", ".
			$user_building[$i]['temperature'].", ".
			$user_percentage[$i]["M_percentage"].", ".
			$user_percentage[$i]["C_percentage"].", ".
			$user_percentage[$i]["D_percentage"].");\n".
			"planetes[".$n."] = ".$i.";\n";
		$n += 1;
	}
}
echo "NRJ = ".$user_technology['NRJ'].";\n";
?>
planete = 1;
classement = 0;
// Fonction pour le classement du tableau
function sortNumber(a,b) {return a[classement] - b[classement];}
// Fonctions de remise à zéro des niveaux des bâtiments
function metal(n) {
if (n == 1) document.getElementById('niv_M').value = parseFloat(document.getElementById('niv_M').value) + 1;
else if (n == -1) document.getElementById('niv_M').value = parseFloat(document.getElementById('niv_M').value) - 1;
else if (n == 0) document.getElementById('percent_M').value = parseFloat(document.getElementById('percent_M').value);
else document.getElementById('niv_M').value = donnees[planete][0];
verif_donnee();
}
function cristal(n) {
if (n == 1) document.getElementById('niv_C').value = parseFloat(document.getElementById('niv_C').value) + 1;
else if (n == -1) document.getElementById('niv_C').value = parseFloat(document.getElementById('niv_C').value) - 1;
else if (n == 0) document.getElementById('percent_C').value = parseFloat(document.getElementById('percent_C').value);
else document.getElementById('niv_C').value = donnees[planete][1];
verif_donnee();
}
function deut(n) {
if (n == 1) document.getElementById('niv_D').value = parseFloat(document.getElementById('niv_D').value) + 1;
else if (n == -1) document.getElementById('niv_D').value = parseFloat(document.getElementById('niv_D').value) - 1;
else if (n == 0) document.getElementById('percent_M').value = parseFloat(document.getElementById('percent_M').value);
else document.getElementById('niv_D').value = donnees[planete][2];
verif_donnee();
}
function terra(n) {
if (n == 1) document.getElementById('niv_T').value = parseFloat(document.getElementById('niv_T').value) + 1;
else if (n == -1) document.getElementById('niv_T').value = parseFloat(document.getElementById('niv_T').value) - 1;
else document.getElementById('niv_T').value = donnees[planete][3];
verif_donnee();
}
function graviton(n) {
if (n == 1) document.getElementById('niv_G').value = parseFloat(document.getElementById('niv_G').value) + 1;
else if (n == -1) document.getElementById('niv_G').value = parseFloat(document.getElementById('niv_G').value) - 1;
else document.getElementById('niv_G').value = donnees[planete][4];
verif_donnee();
}
function verif_donnee() {
// Récupération des données et limitations
if (isNaN(parseFloat(document.getElementById('RM').value)) || parseFloat(document.getElementById('RM').value) <= 0 ) document.getElementById('RM').value = '3';
RM = parseFloat(document.getElementById('RM').value);
if (isNaN(parseFloat(document.getElementById('RC').value)) || parseFloat(document.getElementById('RC').value) <= 0 ) document.getElementById('RC').value = '2';
RC = parseFloat(document.getElementById('RC').value);
if (isNaN(parseFloat(document.getElementById('RD').value)) || parseFloat(document.getElementById('RD').value) <= 0 ) document.getElementById('RD').value = '1';
RD = parseFloat(document.getElementById('RD').value);
if (isNaN(parseFloat(document.getElementById('energie').value)))  document.getElementById('energie').value = '0';
if (isNaN(parseFloat(document.getElementById('planete').value))) document.getElementById('planete').value = '1';
if (parseFloat(document.getElementById('planete').value) != planete) {
	planete = parseFloat(document.getElementById('planete').value);
	document.getElementById('niv_M').value = niv_M = donnees[planete][0];
	document.getElementById('niv_C').value = niv_C = donnees[planete][1];
	document.getElementById('niv_D').value = niv_D = donnees[planete][2];
	document.getElementById('niv_T').value = niv_T = donnees[planete][3];
	document.getElementById('niv_G').value = niv_G = donnees[planete][4];
	document.getElementById('percent_M').value = percent_M = donnees[planete][9];
	document.getElementById('percent_C').value = percent_C = donnees[planete][10];
	document.getElementById('percent_D').value = percent_D = donnees[planete][11];
} else if (parseFloat(document.getElementById('energie').value) != energie) {
	type = 1;
	if (parseFloat(document.getElementById('energie').value) < 0) document.getElementById('energie').value = 0;
}
energie = parseFloat(document.getElementById('energie').value);
if (isNaN(parseFloat(document.getElementById('niv_M').value)) || parseFloat(document.getElementById('niv_M').value) < donnees[planete][0]) document.getElementById('niv_M').value = niv_M = donnees[planete][0];
if (isNaN(parseFloat(document.getElementById('niv_C').value)) || parseFloat(document.getElementById('niv_C').value) < donnees[planete][1]) document.getElementById('niv_C').value = niv_C = donnees[planete][1];
if (isNaN(parseFloat(document.getElementById('niv_D').value)) || parseFloat(document.getElementById('niv_D').value) < donnees[planete][2]) document.getElementById('niv_D').value = niv_D = donnees[planete][2];
if (isNaN(parseFloat(document.getElementById('niv_T').value)) || parseFloat(document.getElementById('niv_T').value) < donnees[planete][3]) document.getElementById('niv_T').value = niv_T = donnees[planete][3];
if (isNaN(parseFloat(document.getElementById('niv_G').value)) || parseFloat(document.getElementById('niv_G').value) < donnees[planete][4]) document.getElementById('niv_G').value = niv_G = donnees[planete][4];
if (isNaN(parseFloat(document.getElementById('percent_M').value))) document.getElementById('percent_M').value = percent_M = donnees[planete][9];
if (isNaN(parseFloat(document.getElementById('percent_C').value))) document.getElementById('percent_C').value = percent_C = donnees[planete][10];
if (isNaN(parseFloat(document.getElementById('percent_D').value))) document.getElementById('percent_D').value = percent_D = donnees[planete][11];
if (parseFloat(document.getElementById('niv_M').value) != niv_M || parseFloat(document.getElementById('niv_C').value) != niv_C || parseFloat(document.getElementById('niv_D').value) != niv_D || parseFloat(document.getElementById('niv_T').value) != niv_T || parseFloat(document.getElementById('niv_G').value) != niv_G || parseFloat(document.getElementById('percent_M').value) != percent_M || parseFloat(document.getElementById('percent_C').value) != percent_C || parseFloat(document.getElementById('percent_D').value) != percent_D) type = 2;
niv_M = parseFloat(document.getElementById('niv_M').value);
niv_C = parseFloat(document.getElementById('niv_C').value);
niv_D = parseFloat(document.getElementById('niv_D').value);
niv_T = parseFloat(document.getElementById('niv_T').value);
niv_G = parseFloat(document.getElementById('niv_G').value);
percent_M = parseFloat(document.getElementById('percent_M').value);
percent_C = parseFloat(document.getElementById('percent_C').value);
percent_D = parseFloat(document.getElementById('percent_D').value);
if (niv_M > 50) niv_M = 50;
if (niv_C > 50) niv_C = 50;
if (niv_D > 50) niv_D = 50;
if (niv_T > 10) niv_T = 10;
if (niv_G > 2) niv_G = 2;
ingenieur = 1;
if (document.getElementById('ingenieur').checked) ingenieur = 1.1;
conso_CEF = 1;
if (document.getElementById('conso_CEF').checked) conso_CEF = 0;
if (isNaN(parseFloat(document.getElementById('sat_max').value)) || parseFloat(document.getElementById('sat_max').value) < 0) document.getElementById('sat_max').value = 0;
if (parseFloat(document.getElementById('sat_max').value) < donnees[planete][7] && parseFloat(document.getElementById('sat_max').value) > 0) document.getElementById('sat_max').value = donnees[planete][7];
sat_max = parseFloat(document.getElementById('sat_max').value);
// Définition du tableau des valeurs
tableau = new Array(8);
for (i=3;i<7;i++) tableau[i] = new Array(9);
tableau[0] = new Array('<a><?php echo $lang['energy_building_SoP'];?></a>',donnees[planete][5],donnees[planete][5],0,0,0,0,0,0);
tableau[1] = new Array('<a><?php echo $lang['energy_building_FR'];?></a>',donnees[planete][6],donnees[planete][6],0,0,0,0,0,1);
tableau[2] = new Array('<a><?php echo $lang['energy_SS'];?></a>',donnees[planete][7],donnees[planete][7],0,0,0,0,0,2);
tableau[3][0] = new Array(tableau[0][0],'+ '+tableau[1][0]);
tableau[3][1] = new Array(tableau[0][1],tableau[1][1]);
tableau[3][2] = new Array(tableau[0][2],tableau[1][2]);
tableau[3][8] = 3;
tableau[4][0] = new Array(tableau[0][0],'+ '+tableau[2][0]);
tableau[4][1] = new Array(tableau[0][1],tableau[2][1]);
tableau[4][2] = new Array(tableau[0][2],tableau[2][2]);
tableau[4][8] = 4;
tableau[5][0] = new Array(tableau[1][0],'+ '+tableau[2][0]);
tableau[5][1] = new Array(tableau[1][1],tableau[2][1]);
tableau[5][2] = new Array(tableau[1][2],tableau[2][2]);
tableau[5][8] = 5;
tableau[6][0] = new Array(tableau[0][0],'+ '+tableau[1][0],'+ '+tableau[2][0]);
tableau[6][1] = new Array(tableau[0][1],tableau[1][1],tableau[2][1]);
tableau[6][2] = new Array(tableau[0][2],tableau[1][2],tableau[2][2]);
tableau[6][8] = 6;
tableau[7] = new Array('<a><?php echo $lang['energy_technology_En'];?></a>',NRJ,NRJ,0,0,0,0,0,7);;
for (i=3;i<7;i++) {
	for (j=3;j<8;j++) tableau[i][j] = 0;
}
// Calcul de l'énergie totale et disponible sur la planète
energie_tot = Math.floor((Math.floor(20 * tableau[0][1] * Math.pow(1.1, tableau[0][1])) + Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * NRJ, tableau[1][1])) + Math.floor(donnees[planete][8] / 4 + 20) * tableau[2][1]) * ingenieur);
energie_dispo = energie_tot - Math.ceil(10 * donnees[planete][0] * Math.pow(1.1, donnees[planete][0]) * percent_M /100) - Math.ceil(10 * donnees[planete][1] * Math.pow(1.1, donnees[planete][1]) * percent_C /100) - Math.ceil(20 * donnees[planete][2] * Math.pow(1.1, donnees[planete][2]) * percent_D /100);
// Calcul de l'énergie nécessaire en fonction des bâtiments à construire
if (type == 2) {
	energie = Math.ceil(10 * niv_M * Math.pow(1.1, niv_M) * percent_M /100) + Math.ceil(10 * niv_C * Math.pow(1.1, niv_C) * percent_C /100) + Math.ceil(20 * niv_D * Math.pow(1.1, niv_D) * percent_D /100) - energie_tot;
	if (niv_T > donnees[planete][3]) energie = Math.max(energie, Math.floor(1000 * Math.pow(2, niv_T - 1)) - energie_tot);
	if (niv_G > donnees[planete][4]) energie = Math.max(energie, Math.floor(300000 * Math.pow(3, niv_G - 1)) - energie_tot);
}
if (energie > 900000) energie = 900000;
// Calcul de l'énergie gagnée avec le nombre maximal de satellite
energie_sat_max = Math.max(Math.floor((sat_max - tableau[2][1]) * Math.floor(donnees[planete][8] / 4 + 20) * ingenieur), 0);
// Calcul des niveaux CES, CEF et CES + CEF nécessaires
a = Math.floor(225 * Math.pow(1.5, donnees[planete][2]));
c = Math.floor((Math.floor(10 * (donnees[planete][2] + 1) * Math.pow(1.1, donnees[planete][2] + 1) * (-0.002 * donnees[planete][8] + 1.28 )) - Math.floor(10 * (donnees[planete][2]) * Math.pow(1.1, donnees[planete][2]) * (-0.002 * donnees[planete][8] + 1.28 ))) * ingenieur);
d = Math.floor(20 * (donnees[planete][2] + 1) * Math.pow(1.1, donnees[planete][2] + 1)) - Math.floor(20 * (donnees[planete][2]) * Math.pow(1.1, donnees[planete][2]));
f = Math.floor(75 * Math.pow(1.5, donnees[planete][2]));
tableau[3][7] = tableau[6][7] = -1;
// boucle sur la CES
for (; tableau[0][3] < energie; tableau[0][2]++) {
	temp3 = new Array(tableau[1][1],0,0,0,0,0);
	if (tableau[0][2] > 69) {
		tableau[0] = Array(tableau[0][0],tableau[0][1],'<font color="red"><?php echo $lang['energy_error'];?></font>',0,0,0,0,0);
		tableau[3][2][0] = tableau[3][2][1] = '<font color="red"><?php echo $lang['energy_error'];?></font>';
		for (k=3;k<8;k++) tableau[3][k] = 0;
		break;
	}
	tableau[0][3] = Math.floor((Math.floor(20 * tableau[0][2] * Math.pow(1.1, tableau[0][2])) - Math.floor(20 * tableau[0][1] * Math.pow(1.1, tableau[0][1]))) * ingenieur);
	if (tableau[0][2] > tableau[0][1]) {
		tableau[0][4] += Math.floor(75 * Math.pow(1.5, tableau[0][2] - 1));
		tableau[0][5] += Math.floor(30 * Math.pow(1.5, tableau[0][2] - 1));
	}
	tableau[0][7] = Math.floor((tableau[0][4] * RC / RM + tableau[0][5]) / tableau[0][3]);
	if (tableau[0][3] == 0) tableau[0][7] = 0;
// Cas CES + Sat
	if ((tableau[0][3] <= energie) || ((sat_max > 0) && (Math.floor((Math.floor(20 * (tableau[0][2] - 1) * Math.pow(1.1, tableau[0][2] - 1)) - Math.floor(20 * tableau[0][1] * Math.pow(1.1, tableau[0][1]))) * ingenieur) < energie - energie_sat_max))) {
		tableau[4][2][0] = tableau[0][2];
		for (k=3;k<8;k++) tableau[4][k] = tableau[0][k];
	}
	temp1 = new Array(0,0,0,0,0);
// boucle sur la CEF
	for (j = tableau[1][1]; tableau[0][3] + temp1[0] < energie; j++) {
		if (j > 60) {
			j = 'erreur';
			break;
		}
		temp1[0] += Math.floor((Math.floor(30 * (j + 1) * Math.pow(1.05 + 0.01 * NRJ, j + 1)) - Math.floor(30 * j * Math.pow(1.05 + 0.01 * NRJ, j))) * ingenieur);
		temp1[1] += Math.floor(900 * Math.pow(1.8, j));
		temp1[2] += Math.floor(360 * Math.pow(1.8, j));
		temp1[3] += Math.floor(180 * Math.pow(1.8, j));
// prise en compte de la consommation en deut de la CEF
		if (conso_CEF == 1){
			b = Math.floor(10 * (j + 1) * Math.pow(1.1, j + 1)) - Math.floor(10 * tableau[1][1] * Math.pow(1.1, tableau[1][1]));
			e = Math.floor((Math.floor(30 * (j + 1) * Math.pow(1.05 + 0.01 * NRJ, j + 1)) - Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * NRJ, tableau[1][1]))) * ingenieur);
			temp2 = new Array(0,0,0);
			for (k=1;k<12;k++) {
				temp2[0] = Math.floor(b / c * (a + d / e * (temp1[1] + temp2[0])));
				temp2[1] = Math.floor(b / c * (f + d / e * (temp1[2] + temp2[1])));
				temp2[2] = Math.floor(b * d / (c * e) * (temp1[3] + temp2[2]));
			}
			temp1[1] += temp2[0];
			temp1[2] += temp2[1];
			temp1[3] += temp2[2];
		}
		temp1[4] = Math.floor((temp1[1] * RC / RM + temp1[2] + temp1[3] * RC / RD) / temp1[0]);
		if (temp1[0] == 0) temp1[4] = 0;
// Cas CEF
		if (tableau[0][3] == 0) {
			tableau[1][2] = j + 1;
			for (k=3;k<8;k++) tableau[1][k] = temp1[k-3];
			tableau[1][7] = temp1[4];
// Cas CEF + Sat
			if ((tableau[1][3] <= energie) || ((sat_max > 0) && (Math.floor((Math.floor(30 * j * Math.pow(1.05 + 0.01 * NRJ, j)) - Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * NRJ, tableau[1][1]))) * ingenieur) < energie - energie_sat_max))) {
				tableau[5][2][0] = j + 1;
				for (k=3;k<8;k++) tableau[5][k] = temp1[k-3];
			}
		}
// Préparation du cas CES + CEF + Sat
		if ((tableau[0][3] + temp1[0] <= energie) || ((sat_max > 0) && (tableau[0][3] + Math.floor((Math.floor(30 * j * Math.pow(1.05 + 0.01 * NRJ, j)) - Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * NRJ, tableau[1][1]))) * ingenieur) < energie - energie_sat_max))) {
			temp3[0] = j + 1;
			for (k=1;k<6;k++) temp3[k] = temp1[k-1];
		}
	}
	if (j == 'erreur' && tableau[0][3] == 0) tableau[1] = Array(tableau[1][0],tableau[1][1],'<font color="red"><?php echo $lang['energy_error'];?></font>',0,0,0,0,0);
// Cas CES + CEF
	if (tableau[0][7] + temp1[4] <= tableau[3][7] || tableau[3][7] < 0) {
		tableau[3][2][0] = tableau[0][2];
		tableau[3][2][1] = j;
		for (k=3;k<7;k++) tableau[3][k] = tableau[0][k] + temp1[k-3];
		tableau[3][7] = Math.floor((tableau[3][4] * RC / RM + tableau[3][5] + tableau[3][6] * RC / RD) / tableau[3][3]);
		if (tableau[3][3] == 0) tableau[3][7] = 0;
	}
// Cas CES + CEF + Sat
	if ((tableau[0][7] + temp3[5] <= tableau[6][7] || tableau[6][7] < 0) && ((tableau[0][3] + temp3[1] < energie) || ((sat_max > 0) && (tableau[0][3] + Math.floor((Math.floor(30 * (temp3[0] - 1) * Math.pow(1.05 + 0.01 * NRJ, temp3[0] - 1)) - Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * NRJ, tableau[1][1]))) * ingenieur) < energie - energie_sat_max)))) {
		tableau[6][2][0] = tableau[0][2];
		tableau[6][2][1] = temp3[0];
		for (k=3;k<7;k++) tableau[6][k] = tableau[0][k] + temp3[k-2];
		tableau[6][7] = Math.floor((tableau[6][4] * RC / RM + tableau[6][5] + tableau[6][6] * RC / RD) / tableau[6][3]);
		if (tableau[6][3] == 0) tableau[6][7] = 0;
	}
	if (tableau[0][3] >= energie) tableau[0][2] -= 1;
}
if (tableau[3][7] < 0) tableau[3][7] = 0;
if (tableau[6][7] < 0) tableau[6][7] = 0;
// Calcul du nombre de satellites nécessaire
for (; tableau[2][3] < energie; tableau[2][2]++) {
	if (tableau[2][3] > 999999) {
		tableau[2] = Array(tableau[2][0],donnees[planete][7],'<font color="red"><?php echo $lang['energy_error'];?></font>',0,0,0,0,0);
		break;
	}
	tableau[2][3] = Math.floor((tableau[2][2] - tableau[2][1] + 1) * Math.floor(donnees[planete][8] / 4 + 20) * ingenieur);
	tableau[2][5] += 2000;
	tableau[2][6] += 500;
// Cas CES + Sat
	if (tableau[4][3] + tableau[2][3] >= energie && tableau[4][3] < energie) {
		tableau[4][2][1] = tableau[2][2] + 1;
		for (i=3;i<7;i++) tableau[4][i] += tableau[2][i];
		tableau[4][7] = Math.floor((tableau[4][4] * RC / RM + tableau[4][5] + tableau[4][6] * RC / RD) / tableau[4][3]);
		if (tableau[4][3] == 0) tableau[4][7] = 0;
	}
// Cas CEF + Sat
	if (tableau[5][3] + tableau[2][3] >= energie && tableau[5][3] < energie) {
		tableau[5][2][1] = tableau[2][2] + 1;
		for (i=3;i<7;i++) tableau[5][i] += tableau[2][i];
		tableau[5][7] = Math.floor((tableau[5][4] * RC / RM + tableau[5][5] + tableau[5][6] * RC / RD) / tableau[5][3]);
		if (tableau[5][3] == 0) tableau[5][7] = 0;
	}
// Cas CES + CEF + Sat
	if (tableau[6][3] + tableau[2][3] >= energie && tableau[6][3] < energie) {
		tableau[6][2][2] = tableau[2][2] + 1;
		for (i=3;i<7;i++) tableau[6][i] += tableau[2][i];
		tableau[6][7] = Math.floor((tableau[6][4] * RC / RM + tableau[6][5] + tableau[6][6] * RC / RD) / tableau[6][3]);
		if (tableau[6][3] == 0) tableau[6][7] = 0;
	}
}
tableau[2][7] = Math.floor((tableau[2][5] + tableau[2][6] * RC / RD) / tableau[2][3]);
if (tableau[2][3] == 0) tableau[2][7] = 0;
// Calcul du niveau d'NRJ nécessaire
for (; tableau[7][3] < energie; tableau[7][2]++) {
	if (tableau[1][1] == 0) {
		tableau[7] = Array(tableau[7][0],tableau[7][1],tableau[7][1],0,0,0,0,'<font color="red" title="<?php echo $lang['energy_no_FR'];?>"><img style="cursor: help;" src="images/help_2.png"> <?php echo $lang['energy_error'];?></font>');
		break;
	} else if (tableau[7][2] > 19) {
		tableau[7] = Array(tableau[7][0],tableau[7][1],tableau[7][1],0,0,0,0,'<font color="orange" title="<?php echo $lang['energy_FR_too_small'];?>"><img style="cursor: help;" src="images/help_2.png"> <?php echo $lang['energy_error'];?></font>');
		break;
	}
	tableau[7][3] += Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * (tableau[7][2] + 1), tableau[1][1])) - Math.floor(30 * tableau[1][1] * Math.pow(1.05 + 0.01 * tableau[7][2], tableau[1][1]));
	tableau[7][5] += Math.floor(800 * Math.pow(2, tableau[7][2]));
	tableau[7][6] += Math.floor(400 * Math.pow(2, tableau[7][2]));
	energie_CEF_tot = 0;
	for (i = 0; i < planetes.length; i++) {
		energie_CEF_tot += Math.floor(30 * donnees[planetes[i]][6] * Math.pow(1.05 + 0.01 * (tableau[7][2] + 1), donnees[planetes[i]][6])) - Math.floor(30 * donnees[planetes[i]][6] * Math.pow(1.05 + 0.01 * tableau[7][1], donnees[planetes[i]][6]));
	}
	tableau[7][7] += Math.floor((tableau[7][5] + tableau[7][6] * RC / RD) / energie_CEF_tot);
	if (energie_CEF_tot == 0) tableau[7][7] = 0;
}
// Rajout de la différence
for (i = 0; i < tableau.length; i++) {
	tableau[i][9] = 0;
	if (isNaN(parseFloat(tableau[i][1].length)) && !isNaN(tableau[i][2])) {
		if ((tableau[i][2] > sat_max) && (sat_max > 0)) tableau[i][9] = 1;
		tableau[i][2] = String(format(tableau[i][2])) + ' (+' + String(format(tableau[i][2]-tableau[i][1])) + ')';
	}
	else {
		if ((tableau[i][2][tableau[i][0].length - 1] > sat_max) && (sat_max > 0)) tableau[i][9] = 1;
		for (k = 0; k < tableau[i][0].length; k++) {
			if (!isNaN(tableau[i][2][k])) tableau[i][2][k] = String(format(tableau[i][2][k])) + ' (+' + String(format(tableau[i][2][k]-tableau[i][1][k])) + ')';
		}
	}
}
classer(classement);
}
function classer(valeur) {
if (!isNaN(parseFloat(valeur))) classement = valeur;
// Tri du tableau selon la colonne souhaitée
if (classement > 2) tableau.sort(sortNumber);
// Création de l'affichage
ligne = '';
for (i = 0; i < tableau.length; i++) {
	if (isNaN(parseFloat(tableau[i][1].length))) {
		ligne += '<tr>\n';
		for (j = 0; j < tableau[i].length - 2; j++) {
			if ((tableau[i][0] == '<a><?php echo $lang['energy_SS'];?></a>') && (j == 2) && (tableau[i][9] == 1)) ligne += '\t<th><font color="darkorange" title="<?php echo $lang['energy_SS_exceeded'];?>"><img style="cursor: help;" src="images/help_2.png"> ' + String(format(tableau[i][j])) + '</font></th>\n';
			else if ((tableau[i][0] == '<a><?php echo $lang['energy_technology_En'];?></a>') && (j == 7) && (tableau[i][3] > 0)) ligne += '\t<th><font color="darkorange" title="<?php echo $lang['energy_all_planets'];?>"><img style="cursor: help;" src="images/help_2.png"> ' + String(format(tableau[i][j])) + '</font></th>\n';
			else ligne += '\t<th><font color="lime">' + String(format(tableau[i][j])) + '</font></th>\n';
		}
		ligne += '</tr>\n';
	} else {
		for (k = 0; k < tableau[i][0].length; k++) {
			ligne += '<tr>\n';
			if (k == 0) taille = tableau[i].length - 2;
			else taille = 3;
			for (j = 0; j < taille; j++) {
				if (j < 3) {
					if ((tableau[i][0][k] == '+ <a><?php echo $lang['energy_SS'];?></a>') && (j == 2) && (tableau[i][9] == 1)) ligne += '\t<th><font color="darkorange" title="<?php echo $lang['energy_SS_exceeded'];?>"><img style="cursor: help;" src="images/help_2.png"> ' + String(format(tableau[i][j][k])) + '</font></th>\n';
					else ligne += '\t<th><font color="lime">' + String(format(tableau[i][j][k])) + '</font></th>\n';
				}
				else ligne += '\t<th rowspan="' + String(tableau[i][1].length) + '"><font color="lime">' + String(format(tableau[i][j])) + '</font></th>\n';
			}
		}
		ligne += '</tr>\n';
	}
	if (i < tableau.length - 1) ligne += '<tr><td class="c" colspan="8"></td></tr>\n';
}

ligne0 = '<table width="100%">\n<tr>\n\t<td class="c" rowspan="2" style="text-align:center" width="29%" id="moyen"';
if (classement != 8) ligne0 += ' title="<?php echo $lang['energy_sort_prod'];?>" onClick="javascript:classer (8)"';
ligne0 += '><?php echo $lang['energy_means_prod'];?></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align:center" width="6%"><?php echo $lang['energy_before'];?></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align:center" width="8%"><?php echo $lang['energy_after'];?></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align:center" width="14%" id="prod"';
if (classement != 3) ligne0 += ' title="<?php echo $lang['energy_sort_energy'];?>" onClick="javascript:classer (3)"';
ligne0 += '><?php echo $lang['energy_means_prod'];?></td>\n'
	+ '\t<td class="c" colspan="3" style="text-align:center"><?php echo $lang['energy_cost'];?></td>\n'
	+ '\t<td class="c" rowspan="2" style="text-align:center" width="12%" id="unitaire"';
if (classement != 7) ligne0 += ' title="<?php echo $lang['energy_sort_unit_cost'];?>" onClick="javascript:classer (7)"';
ligne0 += '><a><?php echo $lang['energy_unit_cost'];?></a></td>\n</tr>\n<tr>\n'
	+ '\t<td class="c" style="text-align:center" width="10%" id="metal"';
if (classement != 4) ligne0 += ' title="<?php echo $lang['energy_sort_metal_cost'];?>" onClick="javascript:classer (4)"';
ligne0 += '><a><?php echo $lang['energy_M'];?></a></td>\n'
	+ '\t<td class="c" style="text-align:center" width="10%" id="cristal"';
if (classement != 5) ligne0 += ' title="<?php echo $lang['energy_sort_crystal_cost'];?>" onClick="javascript:classer (5)"';
ligne0 += '><a><?php echo $lang['energy_C'];?></a></td>\n'
	+ '\t<td class="c" style="text-align:center" width="10%" id="deuterium"';
if (classement != 6) ligne0 += ' title="<?php echo $lang['energy_sort_deut_cost'];?>" onClick="javascript:classer (6)"';
ligne0 += '><a><?php echo $lang['energy_D'];?></a></td>\n</tr>';
//Affichage des valeurs
document.getElementById('ligne').innerHTML = ligne0 + ligne + '</table>\n';
if (niv_M == donnees[planete][0]) document.getElementById('niv_M_act').innerHTML = donnees[planete][0];
else document.getElementById('niv_M_act').innerHTML = '<a onClick="javascript:metal ()" style="cursor: pointer;" title="<?php echo $lang['energy_reset'];?>">'+String(donnees[planete][0])+'</a>';
if (niv_C == donnees[planete][1]) document.getElementById('niv_C_act').innerHTML = donnees[planete][1];
else document.getElementById('niv_C_act').innerHTML = '<a onClick="javascript:cristal ()" style="cursor: pointer;" title="<?php echo $lang['energy_reset'];?>">'+String(donnees[planete][1])+'</a>';
if (niv_D == donnees[planete][2]) document.getElementById('niv_D_act').innerHTML = donnees[planete][2];
else document.getElementById('niv_D_act').innerHTML = '<a onClick="javascript:deut ()" style="cursor: pointer;" title="<?php echo $lang['energy_reset'];?>">'+String(donnees[planete][2])+'</a>';
if (niv_T == donnees[planete][3]) document.getElementById('niv_T_act').innerHTML = donnees[planete][3];
else document.getElementById('niv_T_act').innerHTML = '<a onClick="javascript:terra ()" style="cursor: pointer;" title="<?php echo $lang['energy_reset'];?>">'+String(donnees[planete][3])+'</a>';
if (niv_G == donnees[planete][4]) document.getElementById('niv_G_act').innerHTML = donnees[planete][4];
else document.getElementById('niv_G_act').innerHTML = '<a onClick="javascript:graviton ()" style="cursor: pointer;" title="<?php echo $lang['energy_reset'];?>">'+String(donnees[planete][4])+'</a>';
document.getElementById('niv_M').value = niv_M;
document.getElementById('niv_C').value = niv_C;
document.getElementById('niv_D').value = niv_D;
document.getElementById('niv_T').value = niv_T;
document.getElementById('niv_G').value = niv_G;
document.getElementById('prod').innerHTML = '<a><?php echo $lang['energy_gained_energy'];?></a>';
if (classement==3) document.getElementById('prod').innerHTML = '<font color="lime"><?php echo $lang['energy_gained_energy'];?></font>';
document.getElementById('metal').innerHTML = '<a><?php echo $lang['energy_M'];?></a>';
if (classement==4) document.getElementById('metal').innerHTML = '<font color="lime"><?php echo $lang['energy_M'];?></font>';
document.getElementById('cristal').innerHTML = '<a><?php echo $lang['energy_C'];?></a>';
if (classement==5) document.getElementById('cristal').innerHTML = '<font color="lime"><?php echo $lang['energy_C'];?></font>';
document.getElementById('deuterium').innerHTML = '<a><?php echo $lang['energy_D'];?></a>';
if (classement==6) document.getElementById('deuterium').innerHTML = '<font color="lime"><?php echo $lang['energy_D'];?></font>';
document.getElementById('unitaire').innerHTML = '<a><?php echo $lang['energy_unit_cost'];?></a>';
if (classement==7) document.getElementById('unitaire').innerHTML = '<font color="lime"><?php echo $lang['energy_unit_cost'];?></font>';
document.getElementById('moyen').innerHTML = '<a><?php echo $lang['energy_means_prod'];?></a>';
if (classement==8) document.getElementById('moyen').innerHTML = '<font color="lime"><?php echo $lang['energy_means_prod'];?></font>';
document.getElementById('energie').value = String(energie);
if (energie_dispo>=0) document.getElementById('energie_dispo').innerHTML = format(energie_dispo);
else document.getElementById('energie_dispo').innerHTML = '<font color="red">-'+format(Math.abs(energie_dispo))+'</font>';
document.getElementById('energie_tot').innerHTML = format(energie_tot);
document.getElementById('temp').innerHTML = format(donnees[planete][8]);
}
// Fonction de mise en forme des chiffres
function format(x) {
var str = x.toString(), n = str.length;
if (n < 4 || isNaN(x)) {return x;}
else {return ((n % 3) ? str.substr(0, n % 3) + '.' : '') + str.substr(n % 3).match(new RegExp('[0-9]{3}', 'g')).join('.');}
}
// Lancement du script au chargement de la page
window.onload = function () {Biper(); verif_donnee();}
</script>
<table width='100%'>
<tr>
	<td class='c' colspan='4'><?php echo $lang['energy_mod'];?></td>
</tr>
<tr>
	<th onmouseover="Tip('<table width=&quot;200&quot;><tr><td style=&quot;text-align:center&quot; class=&quot;c&quot;><?php echo $lang['energy_ratio'];?></td></tr><tr><th style=&quot;text-align:center&quot;><a><?php echo $lang['energy_ratio_help'];?></a></th></tr></table>')" onmouseout="UnTip()"><?php echo $lang['energy_ratio_ressources'];?>&nbsp;<input type='text' id='RM' name='RM' size='3' maxlength='3' onBlur='javascript:verif_donnee ()' value='3'><?php echo $lang['energy_M_short'];?>&nbsp;=&nbsp;<input type='text' id='RC' name='RC' size='3' maxlength='3' onBlur='javascript:verif_donnee ()' value='2'><?php echo $lang['energy_C_short'];?>&nbsp;=&nbsp;<input type='text' id='RD' name='RD' size='3' maxlength='3' onBlur='javascript:verif_donnee ()' value='1'><?php echo $lang['energy_D_short'];?></th>
	<th colspan='2' style='min-width:180px' onmouseover="Tip('<table width=&quot;200&quot;><tr><td style=&quot;text-align:center&quot; class=&quot;c&quot;><?php echo $lang['energy_officer_E'];?></td></tr><tr><th style=&quot;text-align:center&quot;><a><?php echo $lang['energy_officer_E_help'];?></a></th></tr></table>')" onmouseout="UnTip()"><label><input type='checkbox' id='ingenieur' name='ingenieur' <?php if ($ingenieur == 1) echo "checked"; ?> onClick='javascript:verif_donnee ()'> <?php echo $lang['energy_using_officer_E'];?>.</label></th>
	<th style='min-width:300px'><label><input type='checkbox' id='conso_CEF' name='conso_CEF' onClick='javascript:verif_donnee ()'> <?php echo $lang['energy_not_FR_D'];?>.</label></th>
</tr>
<tr>
	<th colspan='2' width='50%'><?php echo $lang['energy_needed_energy'];?> <input type='text' id='energie' name='energie' size='6' maxlength='6' onBlur='javascript:verif_donnee ()' value='0'></th>
	<th colspan='2' rowspan='2' width='50%'><?php echo $lang['energy_planet'];?> &nbsp;<select id='planete' name='planete' onChange='javascript:verif_donnee ()'>
<?php
	for ($i=1; $i<=9; $i++) {
		if ($user_building[$i]['planet_name']) echo "\t<option value='".$i."'>".$user_building[$i]["planet_name"]." [".$user_building[$i]['coordinates']."]</option>\n";
	}
?>
	</select><br /><br />
	<?php echo $lang['energy_energy_available'];?> <font color='lime' id='energie_dispo'>-</font> / <font color='lime' id='energie_tot'>-</font><br />
	<?php echo $lang['energy_temperature'];?> <font color='lime' id='temp'>-</font></th>
</tr>
<tr>
	<th colspan='2' rowspan='2'>
	<table width='100%' style='border:none'>
	<tr style='border:2'>
		<th width='50%' style='border:none' />
		<th style='border:none;text-align:right;white-space:nowrap'><?php echo $lang['energy_building_M']." ".$lang['energy_from_level'];?></th>
		<th style='border:none'><font color='lime' id='niv_M_act'>-</font></th>
		<th style='border:none'><?php echo $lang['energy_to'];?></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_remove.png' onClick='javascript:metal (-1)' alt='-' /></th>
		<th style='border:none'><input type='text' id='niv_M' name='niv_M' size='2' maxlength='2' onBlur='javascript:verif_donnee ()' value='<?php echo $user_building[1]['M']; ?>'></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_add.png' onClick='javascript:metal (1)' alt='+' /></th>
		<th style='border:none'><select id='percent_M' name='percent_M' onChange='javascript:metal (0)'>
<?php
for($i=100; $i>=0; $i=$i-10) {
	echo "\t\t\t<option value='".$i."'";
	if ($i == $user_percentage[1]["M_percentage"]) echo " selected";
	echo ">".$i."%</option>\n";
}
?>
			</select></th>
		<th width='50%' style='border:none' />
	</tr>
	<tr>
		<th />
		<th style='border:none;text-align:right;white-space:nowrap'><?php echo $lang['energy_building_C']." ".$lang['energy_from_level'];?></th>
		<th style='border:none'><font color='lime' id='niv_C_act'>-</font></th>
		<th style='border:none'><?php echo $lang['energy_to'];?></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_remove.png' onClick='javascript:cristal (-1)' alt='-' /></th>
		<th style='border:none'><input type='text' id='niv_C' name='niv_C' size='2' maxlength='2' onBlur='javascript:verif_donnee ()' value='<?php echo $user_building[1]['C']; ?>'></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_add.png' onClick='javascript:cristal (1)' alt='+' /></th>
		<th style='border:none'><select id='percent_C' name='percent_C' onChange='javascript:cristal (0)'>
<?php
for($i=100; $i>=0; $i=$i-10) {
	echo "\t\t\t<option value='".$i."'";
	if ($i == $user_percentage[1]["C_percentage"]) echo " selected";
	echo ">".$i."%</option>\n";
}
?>
			</select></th>
		<th />
	</tr>
	<tr>
		<th />
		<th style='border:none;text-align:right;white-space:nowrap'><?php echo $lang['energy_building_D']." ".$lang['energy_from_level'];?></th>
		<th style='border:none'><font color='lime' id='niv_D_act'>-</font></th>
		<th style='border:none'><?php echo $lang['energy_to'];?></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_remove.png' onClick='javascript:deut (-1)' alt='-' /></th>
		<th style='border:none'><input type='text' id='niv_D' name='niv_D' size='2' maxlength='2' onBlur='javascript:verif_donnee ()' value='<?php echo $user_building[1]['D']; ?>'></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_add.png' onClick='javascript:deut (1)' alt='+' /></th>
		<th style='border:none'><select id='percent_D' name='percent_D' onChange='javascript:deut (0)'>
<?php
for($i=100; $i>=0; $i=$i-10) {
	echo "\t\t\t<option value='".$i."'";
	if ($i == $user_percentage[1]["D_percentage"]) echo " selected";
	echo ">".$i."%</option>\n";
}
?>
			</select></th>
		<th />
	</tr>
	<tr>
		<th />
		<th style='border:none;text-align:right;white-space:nowrap'><?php echo $lang['energy_building_T']." ".$lang['energy_from_level'];?></th>
		<th style='border:none'><font color='lime' id='niv_T_act'>-</font></th>
		<th style='border:none'><?php echo $lang['energy_to'];?></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_remove.png' onClick='javascript:terra (-1)' alt='-' /></th>
		<th style='border:none'><input type='text' id='niv_T' name='niv_T' size='2' maxlength='2' onBlur='javascript:verif_donnee ()' value='<?php echo $user_building[1]['Ter']; ?>'></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_add.png' onClick='javascript:terra (1)' alt='+' /></th>
		<th />
		<th />
	</tr>
	<tr>
		<th />
		<th style='border:none;text-align:right;white-space:nowrap'><?php echo $lang['energy_technology_G']." ".$lang['energy_from_level'];?></th>
		<th style='border:none'><font color='lime' id='niv_G_act'>-</font></th>
		<th style='border:none'><?php echo $lang['energy_to'];?></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_remove.png' onClick='javascript:graviton (-1)' alt='-' /></th>
		<th style='border:none'><input type='text' id='niv_G' name='niv_G' size='2' maxlength='2' onBlur='javascript:verif_donnee ()' value='<?php echo $user_technology['Graviton']; ?>'></th>
		<th style='border:none'><img style='cursor: pointer;vertical-align: middle;' src='images/action_add.png' onClick='javascript:graviton (1)' alt='+' /></th>
		<th />
		<th />
	</tr>
	</table>
	</th>
</tr>
<tr>
	<th colspan='2'><img style="cursor: help;" src="images/help_2.png" onmouseover="Tip('<table width=&quot;150&quot;><tr><td style=&quot;text-align:center&quot; class=&quot;c&quot;><?php echo $lang['energy_help'];?></td></tr><tr><th style=&quot;text-align:center&quot;><?php echo $lang['energy_max_SS_help'];?></th></tr></table>')" onmouseout="UnTip()" /> <?php echo $lang['energy_max_SS'];?> <input type='text' id='sat_max' name='sat_max' size='5' maxlength='5' onBlur='javascript:verif_donnee ()' value='0'></th>
</tr>
</table>
<span id='ligne'></span>
<br />
