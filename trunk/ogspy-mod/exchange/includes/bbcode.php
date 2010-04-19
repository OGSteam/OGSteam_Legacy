<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct
//définition de la page
$pageBBCode = <<<HEREBBCODE

<!-- DEBUT Insertion mod eXchange : BBCode -->

<br /><br /><br /><br />
HEREBBCODE;

$pageBBCode .= <<<HEREBBCODE

	<big><big><big>BBCode -> Pas encore fait !</big></big></big>
	
	<!-- FIN Insertion mod eXchange : BBCode -->

HEREBBCODE;



//affichage de la page
echo($pageBBCode);

?>
