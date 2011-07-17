<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

$typeUser = $user_data['user_id'];

if(isset($pub_sousmodule))
{
	if($pub_sousmodule == 'global')
	{
		$typeUser = 0;	
	}
}


// on charge les valeurs de la base :
$res   = readDB($typeUser);
$res4month= readDB($typeUser, mktime(0, 0, 0, date('m'), 1, date('Y')), mktime(0, 0, 0, date('m')+1, 1, date('Y')));
$moisEnCours = date('m/Y');
$dateOrigine = date('d/m/Y', $res['dateOrigine']);

// Génération des graphs
if($res['nombreExpTot'] != 0)
{
	$graphicTot = <<<GRAPH
	<img src="index.php?action=graphic_pie&values=$res[nombreExpRess]_x_$res[nombreExpVaiss]_x_$res[nombreExpMarch]_x_$res[nombreExpRate]&legend=Ressources_x_Vaisseaux_x_Marchands_x_Ratees&title=Proportion%20des%20differents%20types" alt="Pas de graphique disponible">
GRAPH;
}
else
{
	$graphicTot = '';
}
if($res4month['nombreExpTot'] != 0)
{
	$graphicTot4month = <<<GRAPH
	<img src="index.php?action=graphic_pie&values=$res4month[nombreExpRess]_x_$res4month[nombreExpVaiss]_x_$res4month[nombreExpMarch]_x_$res4month[nombreExpRate]&legend=Ressources_x_Vaisseaux_x_Marchands_x_Ratees&title=Proportion%20des%20differents%20types%20pour%20le%20mois" alt="Pas de graphique disponible">
GRAPH;
}
else
{
	$graphicTot4month = '';
}


if($res['nombreExpRess'] != 0)
{
	$graphicRess = <<<GRAPH
	<img src="index.php?action=graphic_pie&values=$res[sumMetal]_x_$res[sumCristal]_x_$res[sumDeuterium]_x_$res[sumAntiMat]&legend=Metal_x_Cristal_x_Deuterium_x_Antimatiere&title=Proportion%20des%20ressources" alt="Pas de graphique disponible">
GRAPH;
}
else
{
	$graphicRess = '';
}
if($res4month['nombreExpRess'] != 0)
{
	$graphicRess4month = <<<GRAPH
	<img src="index.php?action=graphic_pie&values=$res4month[sumMetal]_x_$res4month[sumCristal]_x_$res4month[sumDeuterium]_x_$res4month[sumAntiMat]&legend=Metal_x_Cristal_x_Deuterium_x_Antimatiere&title=Proportion%20des%20ressources%20pour%20le%20mois" alt="Pas de graphique disponible">
GRAPH;
}
else
{
	$graphicRess4month = '';
}

if($res['nombreExpVaiss'] != 0)
{
	//Graphique des vaisseaux du mois
	$graphicVaiss = '	<img src="index.php?action=graphic_pie&values=';
	if($res['sumpt'] != 0) $graphicVaiss .= "$res[sumpt]_x_";
	if($res['sumgt'] != 0) $graphicVaiss .= "$res[sumgt]_x_";
	if($res['sumcle'] != 0) $graphicVaiss .= "$res[sumcle]_x_";
	if($res['sumclo'] != 0) $graphicVaiss .= "$res[sumclo]_x_";
	if($res['sumcr'] != 0) $graphicVaiss .= "$res[sumcr]_x_";
	if($res['sumvb'] != 0) $graphicVaiss .= "$res[sumvb]_x_";
	if($res['sumvc'] != 0) $graphicVaiss .= "$res[sumvc]_x_";
	if($res['sumrec'] != 0) $graphicVaiss .= "$res[sumrec]_x_";
	if($res['sumse'] != 0) $graphicVaiss .= "$res[sumse]_x_";
	if($res['sumbmb'] != 0) $graphicVaiss .= "$res[sumbmb]_x_";
	if($res['sumdst'] != 0) $graphicVaiss .= "$res[sumdst]_x_";
	if($res['sumtra'] != 0) $graphicVaiss .= "$res[sumtra]_x_";
	$graphicVaiss .= '&legend=';
	if($res['sumpt'] != 0) $graphicVaiss .= 'pt_x_';
	if($res['sumgt'] != 0) $graphicVaiss .= 'gt_x_';
	if($res['sumcle'] != 0) $graphicVaiss .= 'cle_x_';
	if($res['sumclo'] != 0) $graphicVaiss .= 'clo_x_';
	if($res['sumcr'] != 0) $graphicVaiss .= 'cr_x_';
	if($res['sumvb'] != 0) $graphicVaiss .= 'vb_x_';
	if($res['sumvc'] != 0) $graphicVaiss .= 'vc_x_';
	if($res['sumrec'] != 0) $graphicVaiss .= 'rec_x_';
	if($res['sumse'] != 0) $graphicVaiss .= 'se_x_';
	if($res['sumbmb'] != 0) $graphicVaiss .= 'bmb_x_';
	if($res['sumdst'] != 0) $graphicVaiss .= 'dst_x_';
	if($res['sumtra'] != 0) $graphicVaiss .= 'tra_x_';
	$graphicVaiss .= '&title=Proportion%20des%20vaisseaux%20en%20nombre" alt="Pas de graphique disponible">';

	//Graphique des unités des vaisseaux du mois
	$graphicUVaiss = '	<img src="index.php?action=graphic_pie&values=';
	if($res['sumUpt'] != 0) $graphicUVaiss .= "$res[sumUpt]_x_";
	if($res['sumUgt'] != 0) $graphicUVaiss .= "$res[sumUgt]_x_";
	if($res['sumUcle'] != 0) $graphicUVaiss .= "$res[sumUcle]_x_";
	if($res['sumUclo'] != 0) $graphicUVaiss .= "$res[sumUclo]_x_";
	if($res['sumUcr'] != 0) $graphicUVaiss .= "$res[sumUcr]_x_";
	if($res['sumUvb'] != 0) $graphicUVaiss .= "$res[sumUvb]_x_";
	if($res['sumUvc'] != 0) $graphicUVaiss .= "$res[sumUvc]_x_";
	if($res['sumUrec'] != 0) $graphicUVaiss .= "$res[sumUrec]_x_";
	if($res['sumUse'] != 0) $graphicUVaiss .= "$res[sumUse]_x_";
	if($res['sumUbmb'] != 0) $graphicUVaiss .= "$res[sumUbmb]_x_";
	if($res['sumUdst'] != 0) $graphicUVaiss .= "$res[sumUdst]_x_";
	if($res['sumUtra'] != 0) $graphicUVaiss .= "$res[sumUtra]_x_";
	$graphicUVaiss .= '&legend=';
	if($res['sumUpt'] != 0) $graphicUVaiss .= 'pt_x_';
	if($res['sumUgt'] != 0) $graphicUVaiss .= 'gt_x_';
	if($res['sumUcle'] != 0) $graphicUVaiss .= 'cle_x_';
	if($res['sumUclo'] != 0) $graphicUVaiss .= 'clo_x_';
	if($res['sumUcr'] != 0) $graphicUVaiss .= 'cr_x_';
	if($res['sumUvb'] != 0) $graphicUVaiss .= 'vb_x_';
	if($res['sumUvc'] != 0) $graphicUVaiss .= 'vc_x_';
	if($res['sumUrec'] != 0) $graphicUVaiss .= 'rec_x_';
	if($res['sumUse'] != 0) $graphicUVaiss .= 'se_x_';
	if($res['sumUbmb'] != 0) $graphicUVaiss .= 'bmb_x_';
	if($res['sumUdst'] != 0) $graphicUVaiss .= 'dst_x_';
	if($res['sumUtra'] != 0) $graphicUVaiss .= 'tra_x_';
	$graphicUVaiss .= '&title=Proportion%20des%20vaisseaux%20en%20structure" alt="Pas de graphique disponible">';
	
	
}
else
{
	$graphicVaiss = '';
	$graphicUVaiss = '';
}

if($res4month['nombreExpVaiss'] != 0)
{
	//Graphique des vaisseaux du mois
	$graphicVaiss4month = '	<img src="index.php?action=graphic_pie&values=';
	if($res4month['sumpt'] != 0) $graphicVaiss4month .= "$res4month[sumpt]_x_";
	if($res4month['sumgt'] != 0) $graphicVaiss4month .= "$res4month[sumgt]_x_";
	if($res4month['sumcle'] != 0) $graphicVaiss4month .= "$res4month[sumcle]_x_";
	if($res4month['sumclo'] != 0) $graphicVaiss4month .= "$res4month[sumclo]_x_";
	if($res4month['sumcr'] != 0) $graphicVaiss4month .= "$res4month[sumcr]_x_";
	if($res4month['sumvb'] != 0) $graphicVaiss4month .= "$res4month[sumvb]_x_";
	if($res4month['sumvc'] != 0) $graphicVaiss4month .= "$res4month[sumvc]_x_";
	if($res4month['sumrec'] != 0) $graphicVaiss4month .= "$res4month[sumrec]_x_";
	if($res4month['sumse'] != 0) $graphicVaiss4month .= "$res4month[sumse]_x_";
	if($res4month['sumbmb'] != 0) $graphicVaiss4month .= "$res4month[sumbmb]_x_";
	if($res4month['sumdst'] != 0) $graphicVaiss4month .= "$res4month[sumdst]_x_";
	if($res4month['sumtra'] != 0) $graphicVaiss4month .= "$res4month[sumtra]_x_";
	$graphicVaiss4month .= '&legend=';
	if($res4month['sumpt'] != 0) $graphicVaiss4month .= 'pt_x_';
	if($res4month['sumgt'] != 0) $graphicVaiss4month .= 'gt_x_';
	if($res4month['sumcle'] != 0) $graphicVaiss4month .= 'cle_x_';
	if($res4month['sumclo'] != 0) $graphicVaiss4month .= 'clo_x_';
	if($res4month['sumcr'] != 0) $graphicVaiss4month .= 'cr_x_';
	if($res4month['sumvb'] != 0) $graphicVaiss4month .= 'vb_x_';
	if($res4month['sumvc'] != 0) $graphicVaiss4month .= 'vc_x_';
	if($res4month['sumrec'] != 0) $graphicVaiss4month .= 'rec_x_';
	if($res4month['sumse'] != 0) $graphicVaiss4month .= 'se_x_';
	if($res4month['sumbmb'] != 0) $graphicVaiss4month .= 'bmb_x_';
	if($res4month['sumdst'] != 0) $graphicVaiss4month .= 'dst_x_';
	if($res4month['sumtra'] != 0) $graphicVaiss4month .= 'tra_x_';
	$graphicVaiss4month .= '&title=Proportion%20des%20vaisseaux%20en%20nombre%20pour%20le%20mois" alt="Pas de graphique disponible">';

	//Graphique des unités des vaisseaux du mois
	$graphicUVaiss4month = '	<img src="index.php?action=graphic_pie&values=';
	if($res4month['sumUpt'] != 0) $graphicUVaiss4month .= "$res4month[sumUpt]_x_";
	if($res4month['sumUgt'] != 0) $graphicUVaiss4month .= "$res4month[sumUgt]_x_";
	if($res4month['sumUcle'] != 0) $graphicUVaiss4month .= "$res4month[sumUcle]_x_";
	if($res4month['sumUclo'] != 0) $graphicUVaiss4month .= "$res4month[sumUclo]_x_";
	if($res4month['sumUcr'] != 0) $graphicUVaiss4month .= "$res4month[sumUcr]_x_";
	if($res4month['sumUvb'] != 0) $graphicUVaiss4month .= "$res4month[sumUvb]_x_";
	if($res4month['sumUvc'] != 0) $graphicUVaiss4month .= "$res4month[sumUvc]_x_";
	if($res4month['sumUrec'] != 0) $graphicUVaiss4month .= "$res4month[sumUrec]_x_";
	if($res4month['sumUse'] != 0) $graphicUVaiss4month .= "$res4month[sumUse]_x_";
	if($res4month['sumUbmb'] != 0) $graphicUVaiss4month .= "$res4month[sumUbmb]_x_";
	if($res4month['sumUdst'] != 0) $graphicUVaiss4month .= "$res4month[sumUdst]_x_";
	if($res4month['sumUtra'] != 0) $graphicUVaiss4month .= "$res4month[sumUtra]_x_";
	$graphicUVaiss4month .= '&legend=';
	if($res4month['sumUpt'] != 0) $graphicUVaiss4month .= 'pt_x_';
	if($res4month['sumUgt'] != 0) $graphicUVaiss4month .= 'gt_x_';
	if($res4month['sumUcle'] != 0) $graphicUVaiss4month .= 'cle_x_';
	if($res4month['sumUclo'] != 0) $graphicUVaiss4month .= 'clo_x_';
	if($res4month['sumUcr'] != 0) $graphicUVaiss4month .= 'cr_x_';
	if($res4month['sumUvb'] != 0) $graphicUVaiss4month .= 'vb_x_';
	if($res4month['sumUvc'] != 0) $graphicUVaiss4month .= 'vc_x_';
	if($res4month['sumUrec'] != 0) $graphicUVaiss4month .= 'rec_x_';
	if($res4month['sumUse'] != 0) $graphicUVaiss4month .= 'se_x_';
	if($res4month['sumUbmb'] != 0) $graphicUVaiss4month .= 'bmb_x_';
	if($res4month['sumUdst'] != 0) $graphicUVaiss4month .= 'dst_x_';
	if($res4month['sumUtra'] != 0) $graphicUVaiss4month .= 'tra_x_';
	$graphicUVaiss4month .= '&title=Proportion%20des%20vaisseaux%20en%20structure%20pour%20le%20mois" alt="Pas de graphique disponible">';
	
}
else
{
	$graphicVaiss4month = '';
	$graphicUVaiss4month = '';
}


// Formattage :
if(count($res)!=0)
{
	foreach($res as $i => $number)
	{
		$res[$i] = format($number);
	}
}
if(count($res4month)!=0)
{
	foreach($res4month as $i => $number)
	{
		$res4month[$i] = format($number);
	}
}




//définition de la page
$pageStat = <<<HERESTAT



<!-- DEBUT Insertion mod eXpedition : Stat -->



<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td style="width: 500px;"></td>
			<td class="c" style="width: 100px;"><big>Depuis le $dateOrigine</big></td>
			<td class="c" style="width: 100px;"><big>Pour le mois $moisEnCours</big></td>
		</tr>
		<tr>
			<td class="c" style="width: 500px;"><big>Nombre total d'eXpedition :</big></td>
			<td class="c" style="width: 100px;"><big>$res[nombreExpTot]</big></td>
			<td class="c" style="width: 100px;"><big>$res4month[nombreExpTot]</big></td>
		</tr>
		<tr>
			<td class="c" style="width: 500px;"><big>Nombre d'eXpeditions ayant ramené des ressources :</big></td>
			<td class="c" style="width: 100px;"><big>$res[nombreExpRess] ($res[pourcentExpRess]%)</big></td>
			<td class="c" style="width: 100px;"><big>$res4month[nombreExpRess] ($res4month[pourcentExpRess]%)</big></td>
		</tr>
		<tr>
			<td class="c" style="width: 500px;"><big>Nombre d'eXpeditions ayant ramené des vaisseaux :</big></td>
			<td class="c" style="width: 100px;"><big>$res[nombreExpVaiss] ($res[pourcentExpVaiss]%)</big></td>
			<td class="c" style="width: 100px;"><big>$res4month[nombreExpVaiss] ($res4month[pourcentExpVaiss]%)</big></td>
		</tr>
		<tr>
			<td class="c" style="width: 500px;"><big>Nombre d'eXpeditions ayant ramené un marchand :</big></td>
			<td class="c" style="width: 100px;"><big>$res[nombreExpMarch] ($res[pourcentExpMarch]%)</big></td>
			<td class="c" style="width: 100px;"><big>$res4month[nombreExpMarch] ($res4month[pourcentExpMarch]%)</big></td>
		</tr>
		<tr>
			<td class="c" style="width: 500px;"><big>Nombre d'eXpeditions n'ayant rien ramené :</big></td>
			<td class="c" style="width: 100px;"><big>$res[nombreExpRate] ($res[pourcentExpRate]%)</big></td>
			<td class="c" style="width: 100px;"><big>$res4month[nombreExpRate] ($res4month[pourcentExpRate]%)</big></td>
		</tr>
	</tbody>
</table>
<br />

$graphicTot
$graphicTot4month

<br />
<br />
<br />
<br />
<br /><span style="font-weight: bold;">
	<big>Total des ressources récoltées :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left; " border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">En tout depuis le $dateOrigine :</td>
			<td class="c" style="width: 125px;"></td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Pour le mois $moisEnCours :</td>
			<td class="c" style="width: 125px;"></td>
		</tr>
		<tr>
			<th style="width: 225px;">Métal</th>
			<th style="width: 125px;">$res[sumMetal]</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Métal</th>
			<th style="width: 125px;">$res4month[sumMetal]</th>
		</tr>
		<tr>
			<th style="width: 225px;">Cristal </th>
			<th style="width: 125px;">$res[sumCristal]</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Cristal</th>
			<th style="width: 125px;">$res4month[sumCristal]</th>
		</tr>
		<tr>
			<th style="width: 225px;">Deutérium</th>
			<th style="width: 125px;">$res[sumDeuterium]</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Deutérium</th>
			<th style="width: 125px;">$res4month[sumDeuterium]</th>
		</tr>
		<tr>
			<th style="width: 225px;">Antimatière</th>
			<th style="width: 125px;">$res[sumAntiMat]</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Antimatière</th>
			<th style="width: 125px;">$res4month[sumAntiMat]</th>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne par eXp :</td>
			<td class="c" style="width: 125px;">$res[moyRess]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne par eXp :</td>
			<td class="c" style="width: 125px;">$res4month[moyRess]</td>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Total en points :</td>
			<td class="c" style="width: 125px;">$res[totPtRess]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Total en points :</td>
			<td class="c" style="width: 125px;">$res4month[totPtRess]</td>
		</tr>
	</tbody>
</table>
<br />

$graphicRess
$graphicRess4month

<br />
<br />
<br />
<br />
<span style="font-weight: bold;">
	<big>Total des vaisseaux ramenés :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">En tout depuis le $dateOrigine :</td>
			<td class="c" style="width: 125px;"></td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Pour le mois $moisEnCours :</td>
			<td class="c" style="width: 125px;"></td>
		</tr>
		<tr>
			<th style="width: 225px;">Petit Transporteur</th>
			<th style="width: 125px;">$res[sumpt] ($res[sumUpt] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Petit Transporteur</th>
			<th style="width: 125px;">$res4month[sumpt] ($res4month[sumUpt] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Grand Transporteur</th>
			<th style="width: 125px;">$res[sumgt] ($res[sumUgt] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Grand Transporteur</th>
			<th style="width: 125px;">$res4month[sumgt] ($res4month[sumUgt] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Chasseur Léger</th>
			<th style="width: 125px;">$res[sumcle] ($res[sumUcle] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Chasseur Léger</th>
			<th style="width: 125px;">$res4month[sumcle] ($res4month[sumUcle] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Chasseur Lourd</th>
			<th style="width: 125px;">$res[sumclo] ($res[sumUclo] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Chasseur Lourd</th>
			<th style="width: 125px;">$res4month[sumclo] ($res4month[sumUclo] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Croiseur</th>
			<th style="width: 125px;">$res[sumcr] ($res[sumUcr] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Croiseur</th>
			<th style="width: 125px;">$res4month[sumcr] ($res4month[sumUcr] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Vaisseau de Bataille</th>
			<th style="width: 125px;">$res[sumvb] ($res[sumUvb] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Vaisseau de Bataille</th>
			<th style="width: 125px;">$res4month[sumvb] ($res4month[sumUvb] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Vaisseau de Colonisation</th>
			<th style="width: 125px;">$res[sumvc] ($res[sumvc] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Vaisseau de Colonisation</th>
			<th style="width: 125px;">$res4month[sumvc] ($res4month[sumUvc] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Recycleur</th>
			<th style="width: 125px;">$res[sumrec] ($res[sumrec] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Recycleur</th>
			<th style="width: 125px;">$res4month[sumrec] ($res4month[sumUrec] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Sonde d'Espionnage</th>
			<th style="width: 125px;">$res[sumse] ($res[sumUse] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Sonde d'Espionnage</th>
			<th style="width: 125px;">$res4month[sumse] ($res4month[sumUse] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Bombardier</th>
			<th style="width: 125px;">$res[sumbmb] ($res[sumUbmb] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Bombardier</th>
			<th style="width: 125px;">$res4month[sumbmb] ($res4month[sumUbmb] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Destructeur</th>
			<th style="width: 125px;">$res[sumdst] ($res[sumUdst] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Destructeur</th>
			<th style="width: 125px;">$res4month[sumdst] ($res4month[sumUdst] pts)</th>
		</tr>
		<tr>
			<th style="width: 225px;">Traqueur</th>
			<th style="width: 125px;">$res[sumtra] ($res[sumUtra] pts)</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Traqueur</th>
			<th style="width: 125px;">$res4month[sumtra] ($res4month[sumUtra] pts)</th>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en nombre par eXp :</td>
			<td class="c" style="width: 125px;">$res[moyVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en nombre par eXp :</td>
			<td class="c" style="width: 125px;">$res4month[moyVaiss]</td>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en points par eXp :</td>
			<td class="c" style="width: 125px;">$res[moyUVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en points par eXp :</td>
			<td class="c" style="width: 125px;">$res4month[moyUVaiss]</td>
		</tr>		
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en nombre par eXp Vaiss. :</td>
			<td class="c" style="width: 125px;">$res[moyVVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en nombre par eXp Vaiss. :</td>
			<td class="c" style="width: 125px;">$res4month[moyVVaiss]</td>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en points par eXp Vaiss. :</td>
			<td class="c" style="width: 125px;">$res[moyUVVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Moyenne en points par eXp Vaiss. :</td>
			<td class="c" style="width: 125px;">$res4month[moyUVVaiss]</td>
		</tr>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Total en nombre :</td>
			<td class="c" style="width: 125px;">$res[totVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Total en nombre :</td>
			<td class="c" style="width: 125px;">$res4month[totVaiss]</td>
		</tr>		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">Total en points :</td>
			<td class="c" style="width: 125px;">$res[totUVaiss]</td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Total en points :</td>
			<td class="c" style="width: 125px;">$res4month[totUVaiss]</td>
		</tr>
	</tbody>
</table>
<br />

$graphicVaiss
$graphicVaiss4month

<br />

$graphicUVaiss
$graphicUVaiss4month

<br />
<br />
<br />
<br />
<br />
<span style="font-weight: bold;">
	<big>Total des marchands réquisitionnés :</big>
</span>
<br />
<br />
<br />
<table style="text-align: left;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 225px; font-weight: bold;">En tout depuis le $dateOrigine :</td>
			<td class="c" style="width: 125px;"></td>
			<td style="width: 50px;"></td>
			<td class="c" style="width: 225px; font-weight: bold;">Pour le mois $moisEnCours :</td>
			<td class="c" style="width: 125px;"></td>
		</tr>
		<tr>
			<th style="width: 225px;">Total</th>
			<th style="width: 125px;">$res[sumM]</th>
			<td style="width: 50px;"></td>
			<th style="width: 225px;">Total</th>
			<th style="width: 125px;">$res4month[sumM]</th>
		</tr>
	</tbody>
</table>
<br>



<!-- FIN Insertion mod eXpedition : Stat -->



HERESTAT;

//affichage de la page
echo($pageStat);

?>
