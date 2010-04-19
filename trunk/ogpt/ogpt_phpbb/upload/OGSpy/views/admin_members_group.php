<?php
/***************************************************************************
*	filename	: admin_members_group.php
*	desc.		:
*	Author		: Kyser - http://ogs.servebbs.net/
*	created		: 16/12/2005
*	modified	: 22/08/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$usergroup_list = usergroup_get();
$usergroup_info = false;
if (isset($pub_group_id)) {
	if (check_var($pub_group_id, "Num")) {
		$group_id = $pub_group_id;
		$usergroup_info = usergroup_get($group_id);
	}
}
?>

<table>
<tr><td colspan="3">&nbsp;</td></tr>
<form method="POST" action="index.php?action=administration&subaction=group">
<tr>
	<td class="c" colspan="2">Permissions</td>
	<td>&nbsp;</td>
</tr>
<tr>
	<th>
		<select name="group_id">
			<option>Sélectionnez un groupe</option>
<?php
foreach ($usergroup_list as $value) {
	echo "\t\t\t\t"."<option value='".$value["group_id"]."'>".$value["group_name"]."</option>";
}
?>
		</select>
	</th>
	<th><input type="submit" value="Voir les permissions"></th>
	<td>&nbsp;</td>
</tr>
</form>
</table>
<?php
if ($usergroup_info !== false)  {
	$usergroup_member = usergroup_member($group_id);
	?>
<br />
<table border="1" align="center" width="800">
<tr>
	<td class="c" colspan="8">Membre du groupe</td>
</tr>
<?php
if (sizeof($usergroup_member) > 0) {
	$index = 0;
	echo "<tr>";
	foreach ($usergroup_member as $user) {
		if ($index == 4) {
			$index = 0;
			echo "</tr>"."\n"."<tr>";		}
		echo "\t"."<th width='175'>".$user["username"]."</th>";
		$index++;
	}
	for ($index ; $index<4 ; $index++) {
		echo "\t"."<th width='175'>&nbsp;</th><th width='25'>&nbsp;</th>";
	}
	echo "</tr>"."\n";
}
?>
</table>
<br />
<table align="center">
<form method="POST" action="index.php?action=usergroup_setauth">
<input type="hidden" name="group_id" value="<?php echo $usergroup_info["group_id"];?>">
<tr>
	<td valign="top" width="450">
		<table align="center" width="100%">
		<tr>
			<td class="c" width="300">Nom du groupe</th>
			<td class="c" width="150" align="center"><input type="text" name="group_name" value="<?php echo $usergroup_info["group_name"];?>"></th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
			<td class="c" width="300">Droit serveur OGSpy</td>
			<td class="c" width="150">Permission</td>
		</tr>
		<tr>
			<th>Ajout/Mise à jour système solaire</th>
			<th><input name="server_set_system" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Ajout rapport espionnage</th>
			<th><input name="server_set_spy" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Ajout classement</th>
			<th><input name="server_set_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_ranking"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Visualiser coordonnées alliances protégées</th>
			<th><input name="server_show_positionhided" type="checkbox" value="1" <?php echo ($usergroup_info["server_show_positionhided"]) ? "checked" : ""?>></th>
		</tr>
		</table>
	</td>
	<td>&nbsp;</td>
	<td valign="top" width="450">
		<table align="center" width="100%">
		<tr>
			<td class="c" width="300">Droit clients externes (OGame Stratège)</td>
			<td class="c" width="150">Permission</td>
		</tr>
		<tr>
			<th>Connexion serveur</th>
			<th><input name="ogs_connection" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_connection"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Importation système solaire</th>
			<th><input name="ogs_set_system" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Exportation système solaire</th>
			<th><input name="ogs_get_system" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Importation rapport espionnage</th>
			<th><input name="ogs_set_spy" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Exportation rapport espionnage</th>
			<th><input name="ogs_get_spy" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Importation classement</th>
			<th><input name="ogs_set_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_ranking"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
			<th>Exportation classement</th>
			<th><input name="ogs_get_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_ranking"]) ? "checked" : ""?>></th>
		</tr>
		</table>
	</td>
</tr>
<tr><td colspan="3">&nbsp;</th></tr>
<tr><td align="center" colspan="3"><input type="submit" value="Valider les permissions"></form></th></tr>
</table>
<?php
}
?>