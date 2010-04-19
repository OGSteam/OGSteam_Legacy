<?php


if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct


function ouvrirTableau ($nbUserMsg, $offset)
{
	global $nMsgParPage;
	if(($nbUserMsg - $offset) <= $nMsgParPage)
	{
		$nbMsgAff = $nbUserMsg - $offset;
	}
	else
	{
		$nbMsgAff = $nMsgParPage;
	}
	$idMsgAffDeb = $offset + 1;
	$idMsgAffFin = $offset + $nbMsgAff;
	$message = <<< HEREMESS
		<br /><big>
		Affichage de $nbMsgAff messages sur un total de $nbUserMsg : du $idMsgAffDeb au $idMsgAffFin.
		<br />
		<table style="text-align: left; width: 75%;" border="1"
		 cellpadding="2" cellspacing="2">
		  <tbody>
HEREMESS;
	return $message;

}

// Pour le formattage des nombres
function afficheMessage ( $date, $player, $provenance, $body, $title = '<PasDeTitre>', $score = '<PasDeScore>')
{

	$colsp = 3;
	$date = "Le : ".date('d-m-Y H:i:s', $date);
	$player = "De : ".stripslashes($player);

	$body = stripslashes($body);
	if($title != '<PasDeTitre>') 
	{
		$title = stripslashes($title);
		$provenance = "Depuis : ".stripslashes($provenance);
		$colsp++;
	}	
	else
	{
		$provenance = "Alliance : [".stripslashes($provenance)."]";	
	}
	if($score != '<PasDeScore>')
	{
		$colsp++;
	}
	$message = <<<HEREMESS

	    <tr>
	      <td class="c" >$date</td>
	      <td class="c" >$player</td>
	      <td class="c" >$provenance</td>
HEREMESS;
if($title != '<PasDeTitre>')  $message .= "<td class=\"c\" >$title</td>";
if($score != '<PasDeScore>') $message .= "<td class=\"c\" >Pertinance : $score</td>";
	$message .= <<<HEREMESS
	    </tr>
	    <tr>
	    	<th colspan="$colsp" rowspan="1">$body</th>
	    </tr>
	    <tr><td colspan="$colsp" height="40px"></td></tr>

	    
HEREMESS;

	return $message;
}


function fermerTableau ($nbUserMsg, $offset, $module)
{
	global $nMsgParPage;
	
	$nbPageTotale = ceil($nbUserMsg / $nMsgParPage);
	$pageCourante = 1 + $offset / $nMsgParPage;
	
	$message = <<< HEREMESS
	  </tbody>
	</table>
	<big>
HEREMESS;
	
	if($pageCourante > 1)
	{
		$offsetPagePrecedente = $offset - $nMsgParPage;
		$message .= "<a href='index.php?action=eXchange&module=$module&offset=$offsetPagePrecedente'><<< Page précédente</a>";
	}

		$message .= "<big>  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Page $pageCourante sur $nbPageTotale. &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </big>";

	if($pageCourante < $nbPageTotale)
	{
		$offsetPageSuivante = $offset + $nMsgParPage;
		$message .= "<a href='index.php?action=eXchange&module=$module&offset=$offsetPageSuivante'>Page suivante >>> </a>";
	}

	$message .=  <<< HEREMESS

	</big>
HEREMESS;
	return $message;

}
?>
