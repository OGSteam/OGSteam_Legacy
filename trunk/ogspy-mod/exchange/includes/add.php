<?php

if (!defined('IN_SPYOGAME')) die("Hacking attempt"); // Pas d'acc�s direct


//on regarde si on a des rapports � analyser :
analyseRapport($user_data['user_id']);

//d�finition de la page
$pageAdd = <<<HEREADD

<!-- DEBUT Insertion mod eXchange : Add -->
 
<br />
<br />

<div style="text-align: center;">
	<big style="font-weight: bold;"><big>
		Ajouter un ou plusieurs messages
	</big></big><br />
	Veillez � bien ajouter l'ent�te avec la date....
</div>
<br />
<br />
<form name='form' method='post' action=''>
	<textarea name='datas' onclick='javascript: this.value="";' rows='20' cols='100'>
--- Copi� coll� de la page des messages ou juste d'un message ---
	</textarea>
	<br>
	<input value='Ajouter' type='submit'>
	<input value='Reset' onclick='javascript: reset_data' type='button'>
</form>



<!-- FIN Insertion mod eXchange : Add -->

HEREADD;

//affichage de la page
echo($pageAdd);

?>
