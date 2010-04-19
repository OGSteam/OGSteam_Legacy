<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

if(!isset($pub_offset))
{
	$pub_offset = 0;
} 

$nbUserMsg = nbMsgUserForUser($user_data['user_id']);

//définition de la page
$pageUser = " <!-- DEBUT Insertion mod eXchange : User --> ";

if($nbUserMsg != 0)
{
	$UserMsg = readDBUser($user_data['user_id'], $pub_offset);

	$pageUser .= ouvrirTableau($nbUserMsg, $pub_offset);
	
	foreach($UserMsg as $msg)
	{
		$coords = "[".$msg['pos_galaxie'].":".$msg['pos_sys'].":".$msg['pos_pos']."]";
		$pageUser .= afficheMessage($msg['date'], $msg['player'], $coords, $msg['body'], $msg['title']);
	}	
	
	$pageUser .= fermerTableau($nbUserMsg, $pub_offset, 'user');

}
else
{
	$pageUser .= " <big> Aucun message trouvé ! </big>";
}

$pageUser .= "<!-- FIN Insertion mod eXchange : User -->";


//affichage de la page
echo($pageUser);

?>
