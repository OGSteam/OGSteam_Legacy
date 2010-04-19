<form method="post" action="?action=set_serverconfig">
<table width="100%">
	<tr>
		<td class="c" colspan="2">
			{adminparam_GeneralOptions}
			<input name="max_battlereport" type="hidden" size="5" value="10" />
		</td>
	</tr>
	<tr>
		<th style="width:60%;">{adminparam_ServerName}</th>
		<th><input type="text" name="servername" size="60" value="{servername}" /></th>
	</tr>
	<tr>
		<th>{adminparam_Language}</th>
		<th>
			<select name="serverlanguage" style="width:150px">
				{language_list}
			</select>
		</th>
	</tr>
	<tr>
		<th>{adminparam_Language_parsing}</th>
		<th>
			<select name="parsinglanguage" style="width:150px">
				{parsinglang_list}
			</select>
		</th>
	</tr>
	<tr>
		<th>{adminparam_ActivateServer}</th>
		<th><input name="server_active" type="checkbox" value="1" {server_active} /></th>
	</tr>
	<tr>
		<th>{adminparam_ServerDownReason}</th>
		<th><input type="text" name="reason" size="60" value="{reason}" /></th>
	</tr>
	<tr>
		<td class="c" colspan="2">{adminparam_MembersOptions}</td>
	</tr>
	<tr>
		<th>{adminparam_EnableDesactivateIPCheck}</th>
		<th><input name="disable_ip_check" type="checkbox" value="1" {disable_ip_check} /></th>
	</tr>
	<tr>
		<th>{adminparam_DefaultSkin}</th>
		<th><input name="default_skin" type="text" size="60" value="{default_skin}" /></th>
	</tr>
	<tr>
		<th>{adminparam_MaximumFavorites} <a>[0-99]</a></th>
		<th><input name="max_favorites" type="text" size="5" maxlength="2" value="{max_favorites}" /></th>
	</tr>
	<tr>
		<th>{adminparam_MaximumSpyReport} <a>[0-99]</a></th>
		<th><input name="max_favorites_spy" type="text" size="5" maxlength="2" value="{max_favorites_spy}" /></th>
	</tr>
	<tr>
		<td class="c" colspan="2">{adminparam_SessionsManagement}</td>
	</tr>
	<tr>
		<th>{adminparam_SessionDuration} <a>[5-180 {adminparam_Minutes}]</a> <a>[0={adminparam_InfiniteSession}]</a></th>
		<th><input name="session_time" type="text" size="5" maxlength="3" value="{session_time}" /></th>
	</tr>
	<tr>
		<td class="c" colspan="2">{adminparam_AllianceProtection}</td>
	</tr>
	<tr>
		<th>{adminparam_HidenAllianceList}</th>
		<th><input type="text" size="60" name="ally_protection" value="{ally_protection}" /></th>
	</tr>
	<tr>
		<th style="color:{ally_protection_color};">{adminparam_color_ally_hided}</th>
		<th>
			<input name="ally_protection_color" id="output" type="text" size="15" maxlength="20" value="{ally_protection_color}" />&nbsp;
			{color_picker}
		</th>
	</tr>
	<tr>
		<td class="c" colspan="2">{adminparam_OtherParameters}</td>
	</tr>
	<tr>
		<th>{adminparam_AllyBoardLink}</th>
		<th><input type="text" size="60" name="url_forum" value="{url_forum}" /></th>
	</tr>
	<tr>
		<th>{adminparam_BanRatioMod}</th>
		<th><input name="block_ratio" type="checkbox" value="1" {block_ratio} /></th>
	</tr>
	<tr>
		<th>{adminparam_MaxRatioMod}</th>
		<th><input name="ratio_limit" type="text" size="10" maxlength="9" value="{ratio_limit}" /></th>
	</tr>
	<tr>
		<td class="c" colspan="2">{adminparam_Maintenance}</td>
	</tr>
	<tr>
		<th>{adminparam_KeepRankingDuration}</th>
		<th>
			<input type="text" name="max_keeprank" maxlength="4" size="5" value="{max_keeprank}" />&nbsp;
			<select name="keeprank_criterion">
				<option value="quantity" {quantity_selected}>{adminparam_Number}</option>
				<option value="day" {day_selected}>{adminparam_Days}</option>
			</select>
		</th>
	</tr>
	<tr>
		<th>{adminparam_MaximumSpyReportByPlanets}</th>
		<th><input type="text" name="max_spyreport" maxlength="4" size="5" value="{max_spyreport}" /></th>
	</tr>
	<tr>
		<th>{adminparam_KeepSpyReportDuration}</th>
		<th><input type="text" name="max_keepspyreport" maxlength="4" size="5" value="{max_keepspyreport}" /></th>
	</tr>
	<tr>
		<th>{adminparam_KeepLogfileDuration}</th>
		<th><input name="max_keeplog" type="text" size="5" maxlength="3" value="{max_keeplog}" /></th>
	</tr>
<!-- IF is_admin -->
	<tr>
		<td class="c" colspan="2">{adminparam_OptionUni}</td>
	</tr>
	<tr>
		<th>{adminparam_NberGalaxy}</th>
		<th>
			<input name="num_of_galaxies" id="galaxies" type="text" size="5" maxlength="3" value="{num_of_galaxies}" onchange="warn_change('galaxies')" readonly="readonly" />&nbsp; &nbsp;
			{adminparam_Activate} (<input id="enable_input_galaxies" type="checkbox" onclick="active('galaxies')" />)
		</th>
	</tr>
	<tr>
		<th>{adminparam_NberSysGalaxy}</th>
		<th>
			<input name="num_of_systems" id="systems" type="text" size="5" maxlength="3" value="{num_of_systems}" onchange="warn_change('systems')" readonly="readonly" />&nbsp; &nbsp;
			{adminparam_Activate} (<input id="enable_input_systems" type="checkbox" onclick="active('systems')" />)
		</th>
	</tr>
	<tr>
		<th>{adminparam_SpeedUni}</th>
		<th>
			<input name="speed_uni" id="speed_uni" type="text" size="5" maxlength="2" value="{speed_uni}" onchange="warn_change('speed_uni')" readonly="readonly" />&nbsp; &nbsp;
			{adminparam_Activate} (<input id="enable_input_speed_uni" type="checkbox" onclick="active('speed_uni')" />)
		</th>
	</tr>
	<tr>
		<th>{adminparam_DepoRav}</th>
		<th><input name="ddr" value="1" type="checkbox"{ddr_checked} /></th>
	</tr>
<!-- END IF is_admin -->
	<tr>
		<td class="c" colspan="2">{adminparam_OptionDebug}</td>
	</tr>
	<tr>
		<th>{adminparam_LogSQLQuery}<br /><div class="z"><i>{adminparam_WarnPerformance}</i></div></th>
		<th><input name="debug_log" type="checkbox" value="1" {debug_log} /></th>
	</tr>
	<tr>
		<th>{adminparam_RecError}<br /></th>
		<th><input name="log_phperror" type="checkbox" value="1" {log_phperror} /></th>
	</tr>
	<tr>
		<th>{adminparam_RecLangError}<br /></th>
		<th><input name="log_langerror" type="checkbox" value="1" {log_langerror} /></th>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th colspan="2">
			<input type="submit" value="{adminparam_Validate}" />&nbsp;<input type="reset" value="{adminparam_Reset}" />
			<input type="hidden" id="adminparam_ConfirmGalaxiesChange" value="{adminparam_ConfirmGalaxiesChange}" />
			<input type="hidden" id="adminparam_ConfirmSystemsChange" value="{adminparam_ConfirmSystemsChange}" />
			<input type="hidden" id="adminparam_ConfirmSpeedChange" value="{adminparam_ConfirmSpeedChange}" />
		</th>
	</tr>
</table>
</form>

<script type="text/javascript">
<!-- Begin
var colors;
function View(color) {
	colors = color;
	document.getElementById("preview").style.backgroundColor = colors;
}

function Set() {
	document.getElementById("output").value = colors;
}

function warn_change(type){
	if(type=='galaxies'){
		msg = document.getElementById('adminparam_ConfirmGalaxiesChange').value;
		value = '{num_of_galaxies}';
	}else if(type=='systems'){
		msg = document.getElementById('adminparam_ConfirmSystemsChange').value;
		value = '{num_of_systems}';
	}else if(type=='speed_uni'){
		msg = document.getElementById('adminparam_ConfirmSpeedChange').value;
		value = '{speed_uni}';
	}
	var rgx = new RegExp('<br(/)?>');
	msg = msg.replace(rgx,'\n');
	if (!confirm(msg)) document.getElementById(type).value=value;
}
function active(type){
	check = document.getElementById('enable_input_'+type);
	zone = document.getElementById(type);
	(check.checked)? zone.readOnly=false : zone.readOnly=true;
}
// End -->
</script>

