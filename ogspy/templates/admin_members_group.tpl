<table>
	<tr>
		<td valign="top">
		
			<table width="450">
				<tr>
					<td class="c" style="text-align:center;">{admingroup_Informations}</td>
				</tr>
				<tr>
					<th style="height:25px;">
					<span id="info" style="display:block; text-align:center; margin:0px; padding:0px; font-weight:bold;">&nbsp;</span>
					</th>
				</tr>
			</table>
			
		</td>
	</tr>
</table>
<div id="new_group" style="visibility:hidden;position: fixed; top: 200px; left: 500px;z-index: 100;">
<table width="100%">
	<tr><td>
	<table width="400" style="border:1px #003399 solid;background-color:#000000" cellpadding="3"> 
	<tr>
		<td style="width:450px;">
		
		<form method="post" action="?" onsubmit="create_group(); return false;" style="margin:0px;">
			<table width="450">
				<tr>
					<td class="c" colspan="3">{admingroup_GroupCreate}</td>
				</tr>
				<tr>
					<th style="width:33%; height:25px;">{admingroup_GroupName}</th>
					<th style="width:33%;"><input id="group_name" name="group_name" type="text" maxlength="15" size="20" /></th>
				</tr>
				<tr>
					<th colspan="2" style="text-align:center;">
						<input type="button" value="{admingroup_Create}" onclick="create_group(); document.getElementById('new_group').style.visibility = 'hidden';" />
						<input type="button" value="{admingroup_Cancel}" onclick="document.getElementById('new_group').style.visibility = 'hidden';" />
					</th>
				</tr>
			</table>
			</form>
			
		</td>
	</tr>
	</table>
	</td></tr>
</table>
</div>
<table>
	<tr>
		<td valign="top">
			<table width="450">
				<tr>
					<td class="c">{admingroup_Group}</td>
				</tr>
				<tr>
					<th style="text-align:center;">
					<span id="group_list"></span>
					<input type="button" value="{admingroup_GroupCreate}" onclick="document.getElementById('new_group').style.visibility = 'visible';" />
					</th>
				</tr>
			</table>
			
			<div id="group_members_block" style="display:none;">
			<table width="450">
				<tr>
					<td class="c">{admingroup_MemberList}</td>
				</tr>
				<tr>
					<th id="group_members"></th>
				</tr>
				<tr>
					<th>
					<span id="add_member1" style="display:none;">
						<select id="user" style="width:130px;"><option>&nbsp;</option></select>&nbsp;
						<input type="button" value="{admingroup_AddToGroup}" onclick="javascript:add_member();" />
					</span>
					<span id="add_member2" style="display:none;">{admingroup_NoMemberToAdd}</span>
					</th>
				</tr>
			</table>
			</div>			
			<div id="group_mods_block" style="display:none;">
			<table width="450">
				<tr>
					<td class="c">{admingroup_ModsList}</td>
				</tr>
				<tr>
					<th id="group_mods"></th>
				</tr>
				<tr>
					<th>
					<span id="add_mod1" style="display:none;">
						<select id="module" style="width:130px;"><option>&nbsp;</option></select>&nbsp;
						<input type="button" value="{admingroup_RestrictGroup}" onclick="add_mod();" />
					</span>
					<span id="add_mod2" style="display:none;">{admingroup_NoModsToRestrict}</span>
					</th>
				</tr>
			</table>
			</div>			
		</td>
		<td valign="top">
			<div id="group_infos_block" style="display:none;">
			<table width="100%">
				<tr>
					<td class="c">{admingroup_GroupSelected} <span id="group_name1"></span></td>
				</tr>
				<tr>
					<th>{admingroup_GroupRename}<input type="text" id="new_name" size="20" maxlength="15" value="" /> <input type="button" value="{admingroup_Rename}" onclick="group_rename();" /></th>
				</tr>
				<tr>
					<th>
					<a id="del_group1" onclick="display('del_group2'); hide('del_group1');" style="cursor:pointer;display:block;">{admingroup_DeleteGroup}</a>
					<a id="del_group2" onclick="group_delete();" style="color:#FF9900;cursor:pointer;display:none;">{admingroup_DeleteGroupConf}</a>
					</th>
				</tr>
			</table>
			</div>			
			<div id="group_auth_block" style="display:none;">
			<table width="100%">
				<tr>
					<td class="c" colspan="2">{admingroup_Permissions}</td>
				</tr>
				<tr>
					<th style="width:50%;" valign="top">
						<!-- Table des droits du server -->
						<table width="100%">
							<tr>
								<td class="c" colspan="2">{admin_ServerRights}</td>
							</tr>
							<tr>
								<th>{admin_AddSolarSystem}</th>
								<th><input id="server_set_system" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_AddSpyReport}</th>
								<th><input id="server_set_spy" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_AddCombatReport}</th>
								<th><input id="server_set_rc" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_AddRanking}</th>
								<th><input id="server_set_ranking" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ViewHiddenPosition}</th>
								<th><input id="server_show_positionhided" type="checkbox" value="1" /></th>
							</tr>
						</table>
						<!-- END -->
					</th>
					<th style="width:50%; vertical-align:top;">
						<!-- Table des droits OGS -->
						<table width="100%">
							<tr>
								<td class="c" colspan="2">{admin_ExternalClientRights}</td>
							</tr>
							<tr>
								<th>{admin_ServerConnection}</th>
								<th><input id="ogs_connection" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ImportSolarSystem}</th>
								<th><input id="ogs_set_system" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ExportSolarSystem}</th>
								<th><input id="ogs_get_system" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ImportSpyReport}</th>
								<th><input id="ogs_set_spy" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ExportSpyReport}</th>
								<th><input id="ogs_get_spy" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ImportRanking}</th>
								<th><input id="ogs_set_ranking" type="checkbox" value="1" /></th>
							</tr>
							<tr>
								<th>{admin_ExportRanking}</th>
								<th><input id="ogs_get_ranking" type="checkbox" value="1" /></th>
							</tr>
						</table>
						<!-- END -->
					</th>
				</tr>
				<tr>
					<th colspan="2"><input type="button" onclick="set_auth();" value="{admingroup_ValidatePermissions}" /></th>
				</tr>
			</table>
			</div>
		</td>
	</tr>
</table>
<script src="library/prototype/prototype.js" type="text/javascript"></script>
<!-- We need to put this javascript variables here to be replaced by the parser -->
<script type="text/javascript">
	<!-- Begin
	var group_list = new Array({java_group_list});
	var group_id = new Array({java_group_id});
	var mod_list = new Array({java_mod_list});
	var mod_id = new Array({java_mod_id});
	var user_names = new Array({java_user_names});
	var user_id = new Array({java_user_id});
	var message_lang = new Array();
	message_lang[0] = '{admingroup_Error}';
	message_lang[1] = '{admingroup_FatalError}';
	message_lang[2] = '{admingroup_GroupAlreadyExist}';
	message_lang[3] = '{admingroup_InvaldGroupName}';
	message_lang[4] = '{admingroup_GroupCreated}';
	message_lang[5] = '{admingroup_NoMembers}';
	message_lang[6] = '{admingroup_NoMods}';
	message_lang[7] = '{admingroup_GroupNameChanged}';
	message_lang[8] = '{admingroup_GroupDeleted}';
	message_lang[9] = '{admingroup_CanDeleteThisGroup}';
	message_lang[10] = '{admingroup_MemberAdded}';
	message_lang[11] = '{admingroup_ModAdded}';
	message_lang[12] = '{admingroup_MemberRemoved}';
	message_lang[13] = '{admingroup_ModRemoved}';
	message_lang[14] = '{admingroup_PermsChanged}';
	message_lang[15] = '{common_AjaxChargement}';
	message_lang[16] = '{common_AjaxEndLoad}';
	// End -->
</script>
<script src="./js/admin_members_group.js" type="text/javascript"></script>

