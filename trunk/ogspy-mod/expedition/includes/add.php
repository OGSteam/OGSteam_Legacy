<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'accès direct

//on regarde si on a des rapports à analyser :
analyseRapport($user_data['user_id']);
//définition de la page
$pageAdd = <<<HEREADD
<!-- DEBUT Insertion mod eXpedition : Add -->
<div style="text-align: center;">
	<big style="font-weight: bold;"><big>
		Ajouter une eXpedition</big></big><br />
	Veillez à bien ajouter l'entête avec la date....
</div>
<form name='form' method='post' action=''>
	<input value='Ajouter' type='submit'>
	<input value='Reset' onclick='javascript: reset_data' type='button'>
	<textarea name='datas' onclick='javascript: this.value="";' rows='15' cols='100'>
--- Copié collé de la page des messages ou juste d'un rapport d'eXpedition ---
	</textarea>
	<br>
</form>
<!-- FIN Insertion mod eXpedition : Add -->
HEREADD;

//affichage de la page
echo($pageAdd);

?>
