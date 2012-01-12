<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

require_once(FOLDEREXP."includes/subHeaderDateChooser.php"); //on inclut le subheader pour la date...
$titrePeriode = "HoF pour les ".$titrePeriode;


// on charge les valeurs de la base :
$superTableau = readDBuserHOF($datedebut, $datefin);



//définition de la page
$pageHOF = <<<HEREHOF
<span style="font-weight: bold;">
	<big><big>$titrePeriode</big></big>
</span>
<br />
<br />
<br />


<!-- DEBUT Insertion mod eXpedition : HOF -->


Classement meilleur cumul (resources + vaisseaux) :

<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 20px;">#</td>
			<td class="c" style="width: 100px;"><big>Pseudo</big></td>
			<td class="c" style="width: 100px;"><big>Points</big></td>
		</tr>	
HEREHOF;

for($i = 0 ; $i < 10 ; $i++)
{
	$indice = $i + 1;
	$pageHOF .= '
		<tr>
			<td class="c" style="width: 20px;">'.$indice.'</td>
			<th style="width: 100px;"><big>'.$superTableau['tout'][$i]['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['tout'][$i]['quantite'].'</big></th>
		</tr>';
}

$pageHOF .= <<<HEREHOF
	</tbody>
</table>
<br />
<br />
<br />
<br />



Classement total ressource :

<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 20px;">#</td>
			<td class="c" style="width: 100px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Métal</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Cristal</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Deutérium</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Antimatière</big></td>

		</tr>
HEREHOF;
for($i = 0 ; $i < 10 ; $i++)
{
	$indice = $i + 1;
	$pageHOF .= '
		<tr>
			<td class="c" style="width: 20px;">'.$indice.'</td>
			<th style="width: 100px;"><big>'.$superTableau['ress'][$i]['M']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ress'][$i]['M']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ress'][$i]['C']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ress'][$i]['C']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ress'][$i]['D']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ress'][$i]['D']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ress'][$i]['A']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ress'][$i]['A']['quantite'].'</big></th>
		</tr>';
}

$pageHOF .= <<<HEREHOF
	</tbody>
</table>
<br />
<br />
<br />
<br />

Classement total vaisseau :

<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 20px;">#</td>
			<td class="c" style="width: 100px;"><big>Pseudo</big></td>
			<td class="c" style="width: 100px;"><big>Points</big></td>
		</tr>	
HEREHOF;
for($i = 0 ; $i < 10 ; $i++)
{
	$indice = $i + 1;
	$pageHOF .= '
		<tr>
			<td class="c" style="width: 20px;">'.$indice.'</td>
			<th style="width: 100px;"><big>'.$superTableau['vaiss'][$i]['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['vaiss'][$i]['quantite'].'</big></th>
		</tr>';
}

$pageHOF .= <<<HEREHOF
	</tbody>
</table>
<br />
<br />
<br />
<br />

Classement meilleure eXpedition ressource :

<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 20px;">#</td>
			<td class="c" style="width: 100px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Métal</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Cristal</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Deutérium</big></td>
			<td style="width: 20px;"></td>
			<td class="c" style="width: 90px;"><big>Pseudo</big></td>
			<td class="c" style="width: 75px;"><big>Antimatière</big></td>

		</tr>
HEREHOF;
for($i = 0 ; $i < 10 ; $i++)
{
	$indice = $i + 1;
	$pageHOF .= '
		<tr>
			<td class="c" style="width: 20px;">'.$indice.'</td>
			<th style="width: 100px;"><big>'.$superTableau['ressM'][$i]['M']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ressM'][$i]['M']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ressM'][$i]['C']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ressM'][$i]['C']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ressM'][$i]['D']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ressM'][$i]['D']['quantite'].'</big></th>
			<td style="width: 20px;"></td>
			<th style="width: 90px;"><big>'.$superTableau['ressM'][$i]['A']['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['ressM'][$i]['A']['quantite'].'</big></th>
		</tr>';
}

$pageHOF .= <<<HEREHOF
	</tbody>
</table>
<br />
<br />
<br />
<br />

Classement meilleure eXpedition vaisseau :

<table style="text-align: left; height: 150px;" border="0" cellpadding="2" cellspacing="2">
	<tbody>
		<tr>
			<td class="c" style="width: 20px;">#</td>
			<td class="c" style="width: 100px;"><big>Pseudo</big></td>
			<td class="c" style="width: 100px;"><big>Points</big></td>
		</tr>	
HEREHOF;

for($i = 0 ; $i < 10 ; $i++)
{
	$indice = $i + 1;
	$pageHOF .= '
		<tr>
			<td class="c" style="width: 20px;">'.$indice.'</td>
			<th style="width: 100px;"><big>'.$superTableau['vaissM'][$i]['pseudo'].'</big></th>
			<th style="width: 75px;"><big>'.$superTableau['vaissM'][$i]['quantite'].'</big></th>
		</tr>';
}

$pageHOF .= <<<HEREHOF
	</tbody>
</table>
<br />



<!-- FIN Insertion mod eXpedition : HOF -->



HEREHOF;

//affichage de la page
echo($pageHOF);

?>
