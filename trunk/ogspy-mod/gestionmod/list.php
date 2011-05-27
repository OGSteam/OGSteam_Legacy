<?php
/**
* list.php Fichier de gestion pour ordonenr les mods
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
?>
<style type="text/css">
<!--
.lime {color: lime;}
.red {color: red;}
.blue {color: blue;}
.yellow {color: yellow;}
-->
</style>
<table align="center">
	<tr><td class="c" colspan="5" width="650">Liste des MODS</td></tr>
	<tr></tr>
	<?php 
	$list_all = list_all();
	for ($i=1;$i <= count($list_all);$i++) {
	switch ($list_all[$i]['type']) {
	 case 0 :
	 	if ($list_all[$i]['active'] == 1) echo "\t<tr class='lime'>\n\t\t<th>".$list_all[$i]['position']."</th>\n";
		else echo "\t<tr class='red'>\n\t\t<th>".$list_all[$i]['position']."</th>\n";
		echo "\t\t<th>".$list_all[$i]['menu']."</th>\n";
	 break;
	 case 1 :
	 	echo "\t<tr class='blue'>\n\t\t<th>".$list_all[$i]['position']."</th>\n";
		echo "\t\t<th><u>Groupe : ".name_group($list_all[$i]['menu'])."</u></th>\n";
	 break;
	 case 2 :
	 	echo "\t<tr class='yellow'>\n\t\t<th>".$list_all[$i]['position']."</th>\n";
		echo "\t\t<th>Espace</th>\n";
	 break;
	}
	echo "\t\t<form method='POST' action='index.php?action=gestion&subaction=action_mod'>\n";
	echo "\t\t<input type='hidden' name='page' value='".$pub_subaction."'>";
	echo "\t\t<input type='hidden' name='id' value='".$list_all[$i]['id']."'>";
	echo "\t\t<input type='hidden' name='position' value='".$list_all[$i]['position']."'>";
	echo "\t\t<input type='hidden' name='place_limite' value='".count($list_all)."'>\n";
	echo "\t\t<th><input type='submit' name='ordre' value='Monter'>";
	echo "<input type='submit' name='ordre' value='Descendre'></th>\n";
	echo "\t\t<th><input type='text' name='place_voulue' size='2' maxlength='2' value='".$list_all[$i]['position']."'></th>\n";
	echo "\t\t<th><input type='submit' name='ordre' value='Deplacer'></th></tr>";
	echo "</form>\n\n";
}?>	
</table>
