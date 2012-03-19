<?php
/**
* BBcode.php
* @package convertisseur
* @author Mirtador
* @link http://www.ogsteam.fr
* created : 29/11/06
*/

if (!defined('IN_SPYOGAME')) {	die("Hacking attempt"); }

//BBcode
	//Le haut de page et le pied de page
 	$header = '[u][size=18][b][color=red]Échange:[/color][/b][/size][/u]';
	$footer = '[color=';
	if ($couleur=='clair')$footer .='blue';
	elseif ($couleur=='foncer')$footer .='cyan';
	$footer .= ']La conversion des ressources a été fait avec le mod[/color] [color=red]Aide au commerce[/color] [color=';
	if ($couleur=='clair')$footer .='blue';
	elseif ($couleur=='foncer')$footer .='cyan';
	$footer .= ']fait par [/color] [color=red]Mirtador[/color]';
	
	//Début du BBcode
	$BBcode  = $header;
		$BBcode .= "\n";
		$BBcode .= "\n".'[i][b] [color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .= ']Offre:[/color][/b][/i]';
		$BBcode .= "\n".'Métal: '.$offreM;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n".'Cristal: '.$offreC;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n".'Deutérium: '.$offreD;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n";
		$BBcode .= "\n".'Au taux de [b][color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .=']'.$tauxm.'Métal='.$tauxc.'Cristal='.$tauxd.'Deutérium[/color][/b]';
		$BBcode .= "\n";
		$BBcode .= "\n".'[i][b][color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .=']Demande:[/color][/b][/i]';
		$BBcode .= "\n".'Métal: '.$demandeM;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n".'Cristal: '.$demandeC;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n".'Deutérium: '.$demandeD;
		if ($unitée=='1000') $BBcode .=' Kilo';
		elseif ($unitée=='1000000') $BBcode .=' Million';
		$BBcode .= "\n"."\n";
		if ($transporteur=="pt"){
		$BBcode .= 'Le nombre de petits transporteurs nécessaires au transport de la demande est:'.$transporteurressus."\n"."\n";
		$BBcode .= 'Le nombre de petits transporteurs nécessaires au transport de l\'offre est:'.$transporteurenvoyer."\n";
		}
		if ($transporteur=="gt"){
		$BBcode .= 'Le nombre de grands transporteurs nécessaires au transport de la demande est:'.$transporteurressus."\n"."\n";
		$BBcode .= 'Le nombre de grands transporteurs nécessaires au transport de l\'offre est:'.$transporteurenvoyer."\n";
		}
		$BBcode .= "\n";
    $BBcode .= $footer;
	
?>
