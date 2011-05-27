<?php
/**
* rename.php Magnifique renommeur de MOD
* @package Gestion MOD
* @author Kal Nightmare
* @link http://www.ogsteam.fr
*/
if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

?>

<table align="center">
	<tr><td colspan="6" width="650"><center><FONT size=5>ATTENTION: Ne pas oublier dans les noms de mettre &lt;br&gt; pour aller à la ligne !!!</FONT></center></td></tr>
	<tr><td class="c" colspan="3">Liste des MODS</td></tr>
	<tr></tr>
	<tr>
		<th>Nom du MOD (version)</th>
		<th>Nom Menu</th>
		<th>Renommer</th>
	</tr>
<?php 
	$list_all = list_all();
	for ($i=1;$i <= count($list_all);$i++) {
	if ($list_all[$i]['type'] == 0) {
	echo "<form method='POST' action='index.php?action=gestion&subaction=action_mod'>";
	echo "<input type='hidden' name='page' value='".$pub_subaction."'>";
	echo "<input type='hidden' name='id' value='".$list_all[$i]['id']."'>";
	echo "<tr><th width='150'>".$list_all[$i]['title']."<br> (".$list_all[$i]['version'].")</th>";
	echo "<th><textarea name='menu' cols='125' rows='2' >".$list_all[$i]['menu']."</textarea></th>";
	echo "<th><input type='submit' name='ordre' value='Renommer'></th></tr>";
	echo "</form>";
	}
}?>	
</table>
