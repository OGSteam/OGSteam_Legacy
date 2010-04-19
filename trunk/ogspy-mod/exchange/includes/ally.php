<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

if(!isset($pub_offset))
{
	$pub_offset = 0;
}

$nbUserMsg = nbMsgAllyForUser($user_data['user_id']);

$nbPageTotale = ceil($nbUserMsg / $nMsgParPage);
$pageCourante = 1 + $pub_offset / $nMsgParPage;

//définition de la page
$pageAlly = "<!-- DEBUT Insertion mod eXchange : Ally -->";

if($nbUserMsg != 0)
{
	$UserMsg = readDBAlly($user_data['user_id'], $pub_offset);
	
	$pageAlly .= ouvrirTableau($nbUserMsg, $pub_offset);
	
	
	foreach($UserMsg as $msg)
	{
		$pageAlly .= afficheMessage($msg['date'], $msg['player'], $msg['alliance'], $msg['body']);
	}
	
	
	$pageAlly .= fermerTableau($nbUserMsg, $pub_offset, 'ally');
	
}
else
{
	$pageAlly .= " <big> Aucun message trouvé ! </big>";
}

$pageAlly .= "<!-- FIN Insertion mod eXchange : Ally -->";



//affichage de la page
echo($pageAlly);

?>
