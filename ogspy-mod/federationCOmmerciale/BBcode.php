<?php
/***************************************************************************
*	filename	: BBcode.php
*	Author		:  Mirtador
*	created		: 29/11/06
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

//BBcode
	//Le haut de page et le pied de page
 	$header = '[u][size=18][b][color=red]�change:[/color][/b][/size][/u]';
	$footer = 'Ce compte rendu � �t� fait avec le mod [url=http://www.ogsteam.fr/forums/viewtopic.php?pid=35316#p35316] F�d�ration commerciale [/url].';
	
	//D�but du BBcode
	$BBcode  = $header;
		$BBcode .= "\n";
		$BBcode .= "\n";
		$BBcode .='<p>Vendeur<br>';
		for ($i=1 ; $i<=$nb_vendeur ; $i++) {
			$BBcode .='<br>';
			$BBcode .='[color=red]'.$pseudo_vendeur[$i].'[/color]<br>';
			$BBcode .='<br>';
			$BBcode .='� envoyer<br>';
			$BBcode .='[color=blue]M�tal:[/color] [color=darkred]'.$metal_vendeur[$i].'[/color]<br>';
			$BBcode .='[color=blue]cristal:[/color] [color=darkred]'.$cristal_vendeur[$i].'[/color]<br>';
			$BBcode .='[color=blue]deut�rium:[/color] [color=darkred]'.$deuterium_vendeur[$i].'[/color]<br>';
			$BBcode .='<br>';
			$BBcode .='� recevoir<br>';
			$BBcode .='[color=blue]M�tal:[/color] [color=darkred]'.round($M_vendeur[$i]).'[/color]<br>';
			$BBcode .='[color=blue]cristal:[/color] [color=darkred]'.round($C_vendeur[$i]).'[/color]<br>';
			$BBcode .='[color=blue]deut�rium:[/color] [color=darkred]'.round($D_vendeur[$i]).'[/color]<br>';
		}
		$BBcode .='<p>acheteur<br>';
		for ($i=1 ; $i<=$nb_acheteur ; $i++) {
			$BBcode .='<br>';
			$BBcode .='[color=red]'.$pseudo_acheteur[$i].'[/color]<br>';
			$BBcode .='<br>';
			$BBcode .='� envoyer<br>';
			$BBcode .='[color=blue]M�tal:[/color] [color=darkred]'.$metal_acheteur[$i].'[/color]<br>';
			$BBcode .='[color=blue]cristal:[/color] [color=darkred]'.$cristal_acheteur[$i].'[/color]<br>';
			$BBcode .='[color=blue]deut�rium:[/color] [color=darkred]'.$deuterium_acheteur[$i].'[/color]<br>';
			$BBcode .='<br>';
			$BBcode .='� recevoir<br>';
			$BBcode .='[color=blue]M�tal:[/color] [color=darkred]'.round($M_acheteur[$i]).'[/color]<br>';
			$BBcode .='[color=blue]cristal:[/color] [color=darkred]'.round($C_acheteur[$i]).'[/color]<br>';
			$BBcode .='[color=blue]deut�rium:[/color] [color=darkred]'.round($D_acheteur[$i]).'[/color]<br>';
		}
		$BBcode .= "\n";
    $BBcode .= $footer;
	
?>