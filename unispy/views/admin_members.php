<?php
/***************************************************************************
*	filename	: admin_members.php
*	desc.		:
*	Author		: Kyser - http://www.ogsteam.fr/
*	created		: 16/12/2005
*	modified	: 30/07/2006 00:00:00
***************************************************************************/

if (!defined('IN_SPYOGAME')) {
	die("Hacking attempt");
}

if ($user_data["user_admin"] != 1 && $user_data["user_coadmin"] != 1 && $user_data["management_user"] != 1) {
	redirection("index.php?action=message&id_message=forbidden&info");
}

$user_info = user_get();
?>

<table>
<form method="POST" action="index.php?action=newaccount">
<tr>
<td class="c" colspan="3"><?php echo $LANG["admin_CreateNewAccount"];?></td>
</tr>
<tr>
	<th width="100">Pseudo</th>
	<th width="150"><input name="pseudo" type="text" maxlength="15" size="20"></th>
	<th width="100"><input type="submit" value="<?php echo $LANG["admin_CreateNewAccount"];?>"></th>
</tr>
</form>
</table>
<br />
<table>
<tr>
<td class="c" width="120"><?php echo $LANG["univers_Player"];?></td>
<td class="c" width="120"><?php echo $LANG["admin_RegisteredOn"];?></td>
<td class="c" width="120"><?php echo $LANG["admin_ActiveAccount"];?></td>
<?php
if ($user_data["user_admin"] == 1) {?>
	<td class="c" width="120"><?php echo $LANG["admin_CoAdmin"];?></td></td>
<?php }
if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {?>
	<td class="c" width="120"><?php echo $LANG["admin_UserManagement"];?>&nbsp;<?php echo help("admin_member_manager");?></td>
<?php }?>
	<td class="c" width="120"><?php echo $LANG["admin_RankingManagement"];?>&nbsp;<?php echo help("admin_ranking_manager");?></td>
	<td class="c" width="120"><?php echo $LANG["admin_LastConnection"];?></td>
	<td class="c" colspan="3">&nbsp;</td>
</tr>
<?php
foreach ($user_info as $v) {
	$user_id = $v["user_id"];
	if (($v["user_admin"] == 1) ||
	($user_data["user_coadmin"] == 1 && $v["user_coadmin"] == 1) ||
	(($user_data["user_coadmin"] != 1 && $user_data["management_user"] == 1) && ($v["user_coadmin"] == 1 || $v["management_user"] == 1))) {
		continue;
	}

	$YesNo = array("<font color=\"red\">".$LANG["basic_No"]."</font>", "<font color=\"lime\">".$LANG["basic_Yes"]."</font>");
	$user_auth = user_get_auth($user_id);

	$auth = "<table>";
	$auth .= "<tr><td class=\"c\" colspan=\"2\">".$LANG["admin_ServerRights"]."</td></tr>";
	$auth .= "<tr><th>".$LANG["admin_AddSolarSystem"]."</th><th>".$YesNo[$user_auth["server_set_system"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_AddSpyReport"]."</th><th>".$YesNo[$user_auth["server_set_spy"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_AddRanking"]."</th><th>".$YesNo[$user_auth["server_set_ranking"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ViewHiddenPosition"]."</th><th>".$YesNo[$user_auth["server_show_positionhided"]]."</th></tr>";
	$auth .= "<tr><td colspan=\"2\">&nbsp;</th></tr>";

	$auth .= "<tr><td class=\"c\" colspan=\"2\">".$LANG["admin_ExternalClientRights"]."</td></tr>";
	$auth .= "<tr><th>".$LANG["admin_ServerConnection"]."</th><th>".$YesNo[$user_auth["ogs_connection"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ImportSolarSystem"]."</th><th>".$YesNo[$user_auth["ogs_set_system"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ExportSolarSystem"]."</th><th>".$YesNo[$user_auth["ogs_get_system"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ImportSpyReport"]."</th><th>".$YesNo[$user_auth["ogs_set_spy"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ExportSpyReport"]."</th><th>".$YesNo[$user_auth["ogs_get_spy"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ImportRanking"]."</th><th>".$YesNo[$user_auth["ogs_set_ranking"]]."</th></tr>";
	$auth .= "<tr><th>".$LANG["admin_ExportRanking"]."</th><th>".$YesNo[$user_auth["ogs_get_ranking"]]."</th></tr>";
	$auth .= "</table>";

$auth = addslashes(htmlentities($auth));

	$name = $v["user_name"];

	$reg_date =  strftime("%d %b %Y %H:%M", $v["user_regdate"]);

	$active_off = !$v["user_active"] ? " selected" : "";
	$user_coadmin_off = !$v["user_coadmin"] ? " selected" : "";
	$management_user_off = !$v["management_user"] ? " selected" : "";
	$management_ranking_off = !$v["management_ranking"] ? " selected" : "";

	if ($v["user_lastvisit"] != 0) {
		$last_visit =  strftime("%d %b %Y %H:%M", $v["user_lastvisit"]);
	}
	else {
		$last_visit = "--";
	}

	echo "<tr>"."\n";

	echo "<form method='POST' action='index.php?action=admin_modify_member&user_id=".$user_id."'>"."\n";
	echo "\t"."<th><a onmouseover=\"this.T_WIDTH=260;this.T_TEMP=15000;return escape('".$auth."')\">".$name."</a></th>"."\n";
	echo "\t"."<th>".$reg_date."</th>"."\n";
	echo "\t"."<th><select name='active'><option value='1'>".$LANG["basic_Yes"]."</option><option value='0'$active_off>".$LANG["basic_No"]."</option></select></th>"."\n";
	if ($user_data["user_admin"] == 1) {
		echo "\t"."<th><select name='user_coadmin'><option value='1'>".$LANG["basic_Yes"]."</option><option value='0'$user_coadmin_off>".$LANG["basic_No"]."</option></select></th>"."\n";
	}
	if ($user_data["user_admin"] == 1 || $user_data["user_coadmin"] == 1) {
		echo "\t"."<th><select name='management_user'><option value='1'>".$LANG["basic_Yes"]."</option><option value='0'$management_user_off>".$LANG["basic_No"]."</option></select></th>"."\n";
	}
		echo "\t"."<th><select name='management_ranking'><option value='1'>".$LANG["basic_Yes"]."</option><option value='0'$management_ranking_off>".$LANG["basic_No"]."</option></select></th>"."\n";
		echo "\t"."<th>".$last_visit."</th>"."\n";
	echo "\t"."<th><input type='image' src='images/usercheck.png' title='".$LANG["admin_ValidateParameters"]." ".$name."'></th>"."\n";
	echo "</form>"."\n";

	echo "<form method='POST' action='index.php?action=delete_member&user_id=".$user_id."' onsubmit=\"return confirm('".sprintf($LANG["admin_ConfirmDelete"],$name)."');\">"."\n";
	echo "\t"."<th><input type='image' src='images/userdrop.png' title='Supprimer le compte de ".$name."'></th>"."\n";
	echo "</form>"."\n";

	echo "<form method='POST' action='index.php?action=new_password&user_id=".$user_id."' onsubmit=\"return confirm('".sprintf($LANG["admin_ConfirmPasswordChange"],$name)."');\">"."\n";
	echo "\t"."<th><input type='image' src='images/userpwd.png' title='Changer le mot de passe de ".$name."'></th>"."\n";
	echo "</form>"."\n";

	echo "</tr>"."\n";
}
?>
</table>
