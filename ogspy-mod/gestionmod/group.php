<?php
/**
* group.php Fichier de gestion des groupes
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}
if (!defined('GESTION_MOD')) {
	die("Hacking attempt");
}
?>
<table align="center">
		
	<tr><td class="c" colspan="6" width="650">Groupe de MODS</td></tr>
	<tr></tr>
	<form method='POST' action='index.php?action=gestion&subaction=new_group'>
	<tr><td class="c" colspan="6"  width='650'>Nouveau Groupe</td></tr>
	<tr><th class="c" colspan="3" rowspan='2' width='100'>Nom</th>
	<th colspan="2">Afficher un espace <?php infobulle("Pour le premier groupe ne pas afficher d'espace","Conseil"); ?></th></tr>
	<tr><th>Oui</th>
	<th>Non</th></tr>
	<tr><th colspan="3"><input type='text' name='new_group' size='100' maxlength='250'></th>
	<th><input type="radio"  name="espace" value="oui" checked="checked"/></th>
	<th><input type="radio" name="espace" value="non"  /></th>
	</tr>
	<tr><th class="c" colspan="6"  width='650'><input type='submit' value='Nouveau Groupe'></th></tr>
	</form>
	<tr></tr>
	<tr><td class="c" colspan="6"  width='650'>Groupe Existant</td></tr>
	<tr><th class="c" width='100' rowspan="2">Nom</th>
	<th colspan="2">Afficher un espace <?php infobulle("Pour le premier groupe ne pas afficher d'espace","Conseil"); ?></th>
	<th rowspan="2"></th>
	<th colspan="2" rowspan="2"></th></tr>
	<tr><th>Oui</th>
	<th>Non</th></tr>
	<?php 
$list_group = list_group();
	for ($i=0;$i < count($list_group);$i++) {
	echo "<form method='POST' action='index.php?action=gestion&subaction=action_group'>";
	echo "<input type='hidden' name='num_group' value='".$list_group[$i]['Num']."'>";
	echo "<tr><th><input type='text' name='nom_group' size='100' maxlength='250' value='".name_group($list_group[$i]['Nom'])."'></th>";
	echo "<th><input type='radio'  name='espace' value='oui'";
	if ($list_group[$i]['Espace'] == 'oui' ) echo "checked='checked'/></th>";
	else echo "/></th>";
	echo "<th><input type='radio' name='espace' value='non'";
	if ($list_group[$i]['Espace'] == 'non' ) echo "checked='checked'/></th>";
	else echo "/></th>";
	echo "<th class='c' ><input type='submit' name='ordre' value='Renommer Groupe'></th>";
	echo "<th class='c'colspan='2' ><input type='submit' name='ordre' value='Supprimer Groupe'></th></tr>";
	echo "</form>";
}?>	
</table>
