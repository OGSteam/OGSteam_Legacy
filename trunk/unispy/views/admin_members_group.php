<?php
/***************************************************************************
*	filename	: admin_members_group.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 23/11/2006 00:00:00
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
<form method="POST" action="index.php?action=usergroup_create">
<tr>
<td class="c" colspan="3"><?php echo $LANG["admingroup_GroupCreate"];?></td>
</tr>
<tr>
	<th width="150"><?php echo $LANG["admingroup_GroupName"];?></th>
	<th width="150"><input name="groupname" type="text" maxlength="15" size="20"></th>
	<th width="150"><input type="submit" value="<?php echo $LANG["admingroup_GroupCreate"];?>"></th>
</tr>
</form>
<tr><td colspan="3">&nbsp;</td></tr>
<form method="POST" action="index.php?action=administration&subaction=group">
<tr>
<td class="c" colspan="2"><?php echo $LANG["admingroup_Permissions"];?></td>
	<td>&nbsp;</td>
</tr>
<tr>
	<th>
		<select name="group_id">
		<option><?php echo $LANG["admingroup_SelectGroup"];?></option>
<?php
foreach ($usergroup_list as $value) {
	echo "\t\t\t\t"."<option value='".$value["group_id"]."'>".$value["group_name"]."</option>";
}
?>
		</select>
	</th>
	<th><input type="submit" value="<?php echo $LANG["admingroup_ShowPermissions"];?>"></th>
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
<td class="c" colspan="8"><?php echo $LANG["admingroup_GroupMember"];?></td>
</tr>
<?php
if (sizeof($usergroup_member) > 0) {
	$index = 0;
	echo "<tr>";
	foreach ($usergroup_member as $user) {
		if ($index == 4) {
			$index = 0;
			echo "</tr>"."\n"."<tr>";
		}
		echo "\t"."<form method='POST' action='index.php?action=usergroup_delmember&user_id=".$user["user_id"]."&group_id=".$group_id."' onsubmit=\"return confirm('".sprintf($LANG["admingroup_ConfirmMemberDeletion"],$user["user_name"])."');\">"."\n";
		echo "\t"."<th width='175'>".$user["user_name"]."</th><th width='25'><input type='image' src='images/userdrop.png' title='".sprintf($LANG["admingroup_ConfirmMemberDeletion"],$user["user_name"])."'></th>";
		echo "\t"."</form>"."\n";
		$index++;
	}
	for ($index ; $index<4 ; $index++) {
		echo "\t"."<th width='175'>&nbsp;</th><th width='25'>&nbsp;</th>";
	}
	echo "</tr>"."\n";
}
$user_list = user_get();
echo "<form method='POST' action='index.php?action=usergroup_newmember'>"."\n";
echo "<input type='hidden' name='group_id' value='".$group_id."'>"."\n";
echo "<tr>"."\n";
echo "<th width='200' colspan='2'>"."\n";
echo "\t"."<select name='user_id'>"."\n";
echo "\t\t"."<option>".$LANG["admingroup_MemberList"]."</option>";
foreach ($user_list as $user) {
	echo "\t\t"."<option value='".$user["user_id"]."'>".$user["user_name"]."</option>"."\n";
}
echo "\t"."</select>"."\n";
echo "</th>"."\n";
echo "<th width='200' colspan='2'><input type='submit' value='".$LANG["admingroup_AddToGroup"]."'></th>"."\n";
echo "<th colspan='4'>&nbsp;</th>"."\n";
echo "</tr>"."\n";
echo "</form>"."\n";
?>
</table>
<br />
<table align="center">
<?php
if ($group_id != 1) {?>
	<form method="POST" action="index.php?action=usergroup_delete" onsubmit="return confirm('<?php echo $LANG["admingroup_ConfirmGroupDeletion"];?>');">
<input type="hidden" name="group_id" value="<?php echo $group_id;?>">
<tr>
	<td>
	<input type="submit" value="<?php echo $LANG["admingroup_DeleteGroup"];?>">
	</td>
</tr>
</form>
<?php }?>
<form method="POST" action="index.php?action=usergroup_setauth">
<input type="hidden" name="group_id" value="<?php echo $usergroup_info["group_id"];?>">
<tr>
	<td valign="top" width="450">
		<table align="center" width="100%">
		<tr>
		<td class="c" width="300"><?php echo $LANG["admingroup_GroupName"];?></th>
			<td class="c" width="150" align="center"><input type="text" name="group_name" value="<?php echo $usergroup_info["group_name"];?>"></th>
		</tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr>
		<td class="c" width="300"><?php echo $LANG["admin_ServerRights"];?></td>
			<td class="c" width="150"><?php echo $LANG["admingroup_Permissions"];?></td>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_AddSolarSystem"];?></th>
			<th><input name="server_set_system" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_AddSpyReport"];?></th>
			<th><input name="server_set_spy" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_AddRanking"];?></th>
			<th><input name="server_set_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["server_set_ranking"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admingroup_ShowProtectedAlly"];?></th>
			<th><input name="server_show_positionhided" type="checkbox" value="1" <?php echo ($usergroup_info["server_show_positionhided"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["unlimitedratio"];?></th>
			<th><input name="unlimited_ratio" type="checkbox" value="1" <?php echo ($usergroup_info["unlimited_ratio"]) ? "checked" : ""?>></th>
		</tr>
		</table>
	</td>
	<td>&nbsp;</td>
	<td valign="top" width="450">
		<table align="center" width="100%">
		<tr>
		<td class="c" width="300"><?php echo $LANG["admin_ExternalClientRights"];?></td>
		<td class="c" width="150"><?php echo $LANG["admingroup_Permissions"];?></td>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ServerConnection"];?></th>
			<th><input name="ogs_connection" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_connection"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ImportSolarSystem"];?></th>
			<th><input name="ogs_set_system" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ExportSolarSystem"];?></th>
			<th><input name="ogs_get_system" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_system"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ImportSpyReport"];?></th>
			<th><input name="ogs_set_spy" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ExportSpyReport"];?></th>
			<th><input name="ogs_get_spy" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_spy"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ImportRanking"];?></th>
			<th><input name="ogs_set_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_set_ranking"]) ? "checked" : ""?>></th>
		</tr>
		<tr>
		<th><?php echo $LANG["admin_ExportRanking"];?></th>
			<th><input name="ogs_get_ranking" type="checkbox" value="1" <?php echo ($usergroup_info["ogs_get_ranking"]) ? "checked" : ""?>></th>
		</tr>
		
		</table>
	</td>
</tr>
<tr><td colspan="3">&nbsp;</th></tr>
<tr><td align="center" colspan="3"><input type="submit" value="<?php echo $LANG["admingroup_ValidatePermissions"];?>"></form></th></tr>
</table>
<br/>
<table align="center">
<form method="POST" action="index.php?action=usergroup_setgroupperms">
<input type="hidden" name="group_id" value="<?php echo $usergroup_info["group_id"];?>" />
	<tr>
		<td class="c" width="300"><?php echo $LANG["admingroup_Modname"]; ?></td>
		<td class="c" colspan="2" width="150"><?php echo $LANG["admingroup_Permissions"]; ?></td>
	</tr>
	<?php
	$mod_list = mod_list();

	foreach  ($mod_list["actived"] as $mod) 
	{
		$perms = group_mod_perms($usergroup_info["group_id"],$mod['id']);
		echo "<input type='hidden' name='mod_id' value='".$mod['id']."'/>";
		echo "\t<tr>";
		echo "\t\t<th>".$mod["title"]."</th>";
		echo "\t\t<th><label ref='Y'><input name='perms[".$mod["id"]."]' value='Y' type='radio' id='Y' ".($perms ? "checked":"").">".$LANG["basic_Yes"]."</label></th>";
		echo "\t\t<th><label ref='N'><input name='perms[".$mod["id"]."]' value='N' type='radio' id='N' ".($perms ? "":"checked").">".$LANG["basic_No"]."</label></th>";
		echo "\t</tr>\n";
	}
	?>
<tr><td colspan="3">&nbsp;</th></tr>
<tr><td align="center" colspan="3"><input type="submit" value="<?php echo $LANG["admingroup_ValidatePermissions"];?>"></th></tr>	
</form>
</table>
<?php
}
?>
