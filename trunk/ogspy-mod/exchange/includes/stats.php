<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas daccès direct

$nbMessUser  = nbMsgUserForUser($user_data['user_id']);
$nbMessAlly  = nbMsgAllyForUser($user_data['user_id']);
$totMessUser  = nbMsgUserForUser();
$totMessAlly  = nbMsgAllyForUser();
$nMembres = countUser();
//définition de la page
$pageStats = <<<HERESTATS



<!-- DEBUT Insertion mod eXchange : Stats -->

		<big>
		Vous avez <strong>$nbMessUser</strong> messages persos enregistrés. <br />
		Vous avez <strong>$nbMessAlly</strong> messages d'alliance enregistrés. <br /><br />
		Les <strong>$nMembres</strong> membres utilisant ce mod ont enregistrés un total de :<br /><br />
		<strong>$totMessUser</strong> messages persos<br />
		<strong>$totMessAlly</strong> messages d'alliance
		
<!-- FIN Insertion mod eXchange : Stats -->



HERESTATS;

//affichage de la page
echo($pageStats);

?>
