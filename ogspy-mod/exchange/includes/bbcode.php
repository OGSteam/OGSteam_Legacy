<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'acc�s direct
//d�finition de la page
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
