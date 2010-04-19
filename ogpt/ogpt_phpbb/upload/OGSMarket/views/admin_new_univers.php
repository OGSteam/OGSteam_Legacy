<?php
/***************************************************************************
*	filename	: Admin_new_univers.php
*	desc.		: 
*	Author		: Mirtador
*	created		: 11/21/06
***************************************************************************/

if (!defined('IN_OGSMARKET')) {
	die("Hacking attempt");
}

require_once("views/page_header.php");
require_once("views/admin_menu.php");
?>
<form action="index.php" method="post">
<input type="hidden" name="action" value="admin_new_univers_execute" />
<table width="80%">
<?php 
	if(isset($ogs_info)) echo "<tr><th class='c' colspan='2'><h2>".$ogs_info."</h2></th></tr>";
?>
<tr>
	<td class="c" colspan="2" align="center">Ajouter un univers</td>
</tr>
<tr>
	<th>Nom de l'univers</th><th><input type="text" name="name" value="" />
</tr>
<tr>
	<th>Adresse de l'univers</th><th><input type="text" name="url" value="" />
</tr>
<tr>
	<th colspan="2"><input type="submit" value="Créer" /></th>
</tr>
</table>
</form>

<?php
require_once("views/page_tail.php");
?>
