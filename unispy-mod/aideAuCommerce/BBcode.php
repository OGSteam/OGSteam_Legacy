<?php
/***************************************************************************
*	filename	: BBcode.php
*	Author		:  Mirtador
*	created		: 29/11/06
***************************************************************************/

if (!defined('IN_SPYOGAME') && !defined('IN_UNISPY2')) {
	die("Hacking attempt");
}

//BBcode
	//Le haut de page et le pied de page
 	$header = '[b][color=red]Modalités de l\'échange:[/color][/b]';
	$footer = '[color=';
	if ($couleur=='clair')$footer .='blue';
	elseif ($couleur=='foncer')$footer .='cyan';
	$footer .= ']La conversion des ressources a été fait avec le mod[/color] [color=red]Aide au commerce[/color] [color=';
	if ($couleur=='clair')$footer .='blue';
	elseif ($couleur=='foncer')$footer .='cyan';
	$footer .= ']fait par [/color] [color=red]Mirtador[/color] [color=';
	if ($couleur=='clair')$footer .='blue';
	elseif ($couleur=='foncer')$footer .='cyan';
	$footer .= '] adapté pour e-univers par [/color] [color=red]Draliam[/color]';
	
	//Début du BBcode
	$BBcode  = $header;
		$BBcode .= "\n";
		$BBcode .= "\n".'[i][b] [color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .= ']Offre:[/color][/b][/i]';
		if ($offreM<>0){
		$BBcode .= "\n".'Titane: '.$offreM;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		if ($offreC<>0){
		$BBcode .= "\n".'Carbone: '.$offreC;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		if ($offreD<>0){
		$BBcode .= "\n".'Tritium: '.$offreD;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		$BBcode .= "\n";
		$BBcode .= "\n".'Au taux de [b][color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .=']'.$tauxm.' Titane = '.$tauxc.' Carbone = '.$tauxd.' Tritium[/color][/b]';
		$BBcode .= "\n";
		$BBcode .= "\n".'[i][b][color=';
		if ($couleur=='clair')$BBcode .='green';
		elseif ($couleur=='foncer')$BBcode .='lime';
		$BBcode .=']Demande:[/color][/b][/i]';
		if ($demandeM<>0){
		$BBcode .= "\n".'Titane: '.$demandeM;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		if ($demandeC<>0){
		$BBcode .= "\n".'Carbone: '.$demandeC;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		if($demandeD<>0){
		$BBcode .= "\n".'Tritium: '.$demandeD;
		if ($unitée=='1000') $BBcode .=' K';
		elseif ($unitée=='1000000') $BBcode .=' M';
		elseif ($unitée=='1000000000') $BBcode .=' G';}
		$BBcode .= "\n"."\n";
		if ($transporteur=="pt"){
		$BBcode .= 'Le nombre de PT-5 nécessaires au transport de la demande est: '.$transporteurressus."\n";
		$BBcode .= 'Le nombre de PT-5 nécessaires au transport de l\'offre est: '.$transporteurenvoyer."\n";
		}
		if ($transporteur=="gt"){
		$BBcode .= 'Le nombre de GT-50 nécessaires au transport de la demande est: '.$transporteurressus."\n";
		$BBcode .= 'Le nombre de GT-50 nécessaires au transport de l\'offre est: '.$transporteurenvoyer."\n";
		}
		$BBcode .= "\n";
    $BBcode .= $footer;
	
?>