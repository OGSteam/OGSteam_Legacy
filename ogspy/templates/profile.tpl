<!-- DEBUT DU SCRIPT -->
<script type="text/JavaScript">
<!-- Begin
function check_password(form) {
	var old_password = form.old_password.value
	var new_password = form.new_password.value
	var new_password2 = form.new_password2.value

	if (old_password != "" && (new_password == "" || new_password2 == "")) {
		alert("{ENTER_NEW_PASSWORD}");
		return false;
	}
	if (old_password == "" && (new_password != "" || new_password2 != "")) {
		alert("{ENTER_OLD_PASSWORD}");
		return false;
	}
	if (old_password != "" && new_password != new_password2) {
		alert("{ERROR_PASSWORD_VERIF}");
		return false;
	}
	if (old_password != "" && new_password != "" && new_password2 != "") {
		if (new_password.length < 6 || new_password.length > 15) {
			alert("{ERROR_PASSWORD_LENGTH}");
			return false;
		}
	}

	return true;
}
// End -->
</script>
<!-- FIN DU SCRIPT -->

<form method="post" action="?action=member_modify_member" onsubmit="return check_password(this);">

<table style="margin-left:auto;margin-right:auto;text-align:center" width="450">
	<tr>
		<td class="c" colspan="2">
			{GENERAL_INFO}
			<!-- Pour que le champ "oldpassword" ne soit pas automatiquement rempli -->
			<input type="password" style="visibility:hidden;" />
		</td>
	</tr>
	<tr>
		<th>{LOGIN}</th>
		<th><input name="pseudo" type="text" size="20" maxlength="20" value="{USER_NAME}" /></th>
	</tr>
	<tr>
		<th>{OLD_PASSWORD}</th>
		<th><input name="old_password" type="password" size="20" maxlength="15" /></th>
	</tr>
	<tr>
		<th>{NEW_PASSWORD}</th>
		<th><input name="new_password" type="password" size="20" maxlength="15" /></th>
	</tr>
	<tr>
		<th>{NEW_PASSWORD_VERIF}</th>
		<th><input name="new_password2" type="password" size="20" maxlength="15" /></th>
	</tr>
	<tr>
		<th>{LANGUE}</th>
		<th>
			<select name="userlanguage" style="width:110px">
				{LANGUE_LIST}
			</select>
		</th>
	</tr>
	<tr>
		<td class="c" colspan="2">{GAME_DATA}</td>
	</tr>
	<tr>
		<th>{POSITION_MP}</th>
		<th>
			<select name="galaxy">
<!-- BEGIN galaxy_list -->
				<option value='{galaxy_list.galaxy}'{galaxy_list.selected}>{galaxy_list.galaxy}</option>
<!-- END galaxy_list -->
			</select>
			<select name="system">
<!-- BEGIN system_list -->
				<option value='{system_list.system}'{system_list.selected}>{system_list.system}</option>
<!-- END system_list -->
			</select>
			<select name="row">
<!-- BEGIN row_list -->
				<option value='{row_list.row}'{row_list.selected}>{row_list.row}</option>
<!-- END row_list -->
			</select>
			</th>
	</tr>
	<tr>
		<th>{NAME_IG}</th>
		<th><input name="user_stat_name" type="text" size="20" maxlength="18" value="{USERNAME_IG}" /></th>
	</tr>
	<tr>
		<th>{ALLY_IG}</th>
		<th><input name="ally_stat_name" type="text" size="20" maxlength="18" value="{ALLYNAME_IG}" /></th>
	</tr>
	<tr>
		<td class="c" colspan="2">{VARIOUS}</td>
	</tr>
	<tr>
		<th>{SKIN}</th>
		<th>
			<input name="skin" type="text" size="20" value="{USER_SKIN}" />
		</th>
	</tr>
	<tr>
		<th>{IP_CHECK}</th>
		<th>
			<input name="disable_ip_check" value="1" type="checkbox" {USER_IP_CHECK} />
		</th>
	</tr>
	<tr>
		<td class="c" colspan="2">{OFFICIER}</td>
	</tr>
	<tr>
		<th>{AMIRAL}</th>
		<th>
			<input name="off_amiral" value="1" type="checkbox" {USER_AMIRAL} />
		</th>
	</tr>
	<tr>
		<th>{INGENIEUR}</th>
		<th>
			<input name="off_ingenieur" value="1" type="checkbox" {USER_INGENIEUR} />
		</th>
	</tr><tr>
		<th>{GEOLOGUE}</th>
		<th>
			<input name="off_geologue" value="1" type="checkbox" {USER_GEOLOGUE} />
		</th>
	</tr>
	<tr>
		<th>{TECHNOCRATE}</th>
		<th>
			<input name="off_technocrate" value="1" type="checkbox" {USER_TECHNOCRATE} />
		</th>
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<th colspan="2" align="center"><input type="submit" value="{VALIDATE}" /></th>
	</tr>
</table>
</form>
