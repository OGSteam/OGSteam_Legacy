<?php
/***************************************************************************
*	filename	: BBcode.php
*	Author		:  Mirtador
*	created		: 29/11/06
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

//BBcode
	//Le haut de page et le pied de page
 	$header = '[u][size=18][b][color=red]Échange:[/color][/b][/size][/u]';
	$footer = '[color=blue]La conversion des ressources a été fait avec le mod[/color] [color=red]Aide au commerce[/color] [color=blue]fait par [/color] [color=red]Mirtador[/color]';
	
	//Début du BBcode
	$BBcode  = $header."\n";
		$BBcode .= "\n";
		$BBcode .= '[i][b][color=green]Offre:[/color][/b][/i]'."\n";
		$BBcode .= 'Métal: '.$metal."\n";
		$BBcode .= 'Cristal: '.$cristal."\n";
		$BBcode .= 'Deutérium: '.$deuterium."\n";
		$BBcode .= "\n";
		$BBcode .= '[i][b][color=green]Demande:[/color][/b][/i]'."\n";
		$BBcode .= 'Métal:'.$TotalM."\n";
		$BBcode .= 'Cristal:'.$TotalC."\n";
		$BBcode .= 'Deutérium:'.$TotalD."\n";
		$BBcode .= "\n";
		if ($transporteur=="pt"){
		$BBcode .= 'Le nombre de petit transporteur dont vous aurez besoin pour transporter vos ressources sont:'.$transporteurressus."\n";
		}
		if ($transporteur=="gt"){
		$BBcode .= 'Le nombre de grand transporteur dont vous aurez besoin pour transporter vos ressources sont:'.$transporteurressus."\n";
		}
		$BBcode .= "\n";
    $BBcode .= $footer;