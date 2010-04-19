<table width="200">
<tr>
	<td class="c" style="white-space:nowrap;">{admin_CreateNewAccount}&nbsp;</td>
	<th style="width:100px;">
		<input type="button" value="{admin_Create}" 
			onclick="document.getElementById('new_member').style.visibility = 'visible';" />
	</th>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c" style="width:16px;">{active_header}</td>
	<td class="c" style="text-align:center;cursor:pointer;width:120px;"  onclick="TableOrder(event,1);">
		{common_Player}&nbsp;<span>&#9650;</span>
	</td>
	<td class="c" style="text-align:center;cursor:pointer;width:100px;"  onclick="TableOrder(event,1);">
		{admin_RegisteredOn}&nbsp;<span>&nbsp;</span>
	</td>
	<td class="c" style="text-align:center;cursor:pointer;" onclick="TableOrder(event,1);">
		{admin_Group}&nbsp;<span>&nbsp;</span>
	</td>
	<td class="c" style="text-align:center;cursor:pointer;width:64px;"  onclick="TableOrder(event,1);">
		{admin_Ratio}&nbsp;<span>&nbsp;</span>
	</td>
	<td class="c" style="text-align:center;white-space:nowrap;width:60px;" >
		{admin_Access}&nbsp;{access_Help}
	</td>
	<td class="c" style="text-align:center;cursor:pointer;width:100px;"  onclick="TableOrder(event,1);">
		{admin_LastConnection}&nbsp;<span>&nbsp;</span>
	</td>
	<td class="c" style="text-align:center;width:60px;" >&nbsp;</td>
</tr>
<!-- IF show_list -->
<!-- BEGIN users -->
<tr>
	<th>
		{users.active_pic}
		<input type="hidden" id="name_{users.id}" value="{users.name}" />
		<input type="hidden" id="active_{users.id}" value="{users.is_active}" />
		<input type="hidden" id="coadmin_{users.id}" value="{users.is_coadmin}" />
		<input type="hidden" id="rankman_{users.id}" value="{users.is_rankman}" />
		<input type="hidden" id="userman_{users.id}" value="{users.is_userman}" />
	</th>
	<th onmouseover="Tip('{users.auth}');" onmouseout="UnTip();">
		{users.name}
	</th>
	<th>{users.reg_date}</th>
	<th>
		{users.groups}
	</th>
	<th>
		{users.ratio}
	</th>
	<th style="text-align:right;" >
		{users.admin_pic}
		{users.members_man_pic}
		{users.ranking_man_pic}
	</th>
	<th><span style="visibility:{users.last_visit_visibility};">{users.last_visit}</span></th>
	<th style="white-space:nowrap;">
		<input type='image' src='images/user_edit.png' title='{users.admin_ModifParameters}' 
			onclick="user_edit('{users.id}');" />
		<input type='image' src="images/key.png" title="{users.admin_PasswordChange}" 
			onclick="user_pass('{users_id}','{users.admin_ConfirmPasswordChange}');" alt="" />
		<input type='image' src='images/action_delete.png' title='{users.admin_DeleteUser}' 
			onclick="user_delete('{users.id}','{users.admin_ConfirmDelete}');" />
	</th>	
<!--	</form> -->
</tr>
<!-- END users -->
<!-- END IF show_list -->
</table>
<div id="new_pass_div" style="visibility:hidden;position:fixed;top:130px;left:50%;width:200px;margin-left:-100px;z-index:100;"> 
	<form method="post" action="?action=new_password">
	<table width="200" style="border:1px #003399 solid;" cellpadding="3">
		<tr>
			<td class="c" style="text-align:center;">{admin_pass}</td>
		</tr>
		<tr>
			<th style="text-align:center;"> 
				{admin_LeaveBlankPwd}<br /> 
				<input type="text" name="new_pass" id="new_pass_input" value="" /><br /><br /> 
				<input type="hidden" id="this_id_newpass" value="" name="user_id" />
				<input type="submit" value="{admin_Ok}" /> 
				<input type="button" value="{admin_Cancel}" onclick="document.getElementById('new_pass_div').style.visibility = 'hidden';" /> 
			</th>
		</tr>
	</table> 
	</form>
</div> 

<div id="new_member" style="visibility:hidden;position:fixed;top:130px;left:50%;width:400px;margin-left:-200px;z-index:100;"> 
	<form method="post" action="?action=newaccount"> 
	<table>
		<tr>
			<td> 
				<table width="400" style="border:1px #003399 solid;background-color:#000000" cellpadding="3"> 
				<tr> 
					<td style="text-align:center;" class="c" colspan="2">{admin_CreateNewAccount}</td> 
				</tr>
				<tr> 
					<th style="text-align:center;">{admin_name}</th> 
					<th style="text-align:center;"><input name="pseudo" type="text" maxlength="15" size="20" /></th> 
				</tr>
				<tr> 
					<th style="text-align:center;">{admin_pass}</th> 
					<th style="text-align:center;"><input name="pass" type="text" maxlength="15" size="20" /></th> 
				</tr>
				<tr> 
					<th style="text-align:center;">{admin_Rights}</th> 
					<th style="text-align:center;"> 
<!-- IF is_admin -->
						{admin_CoAdmin}
						<select name='user_coadmin'>
							<option value='1'>{basic_Yes}</option>
							<option value='0' selected='selected'>{basic_No}</option>
						</select><br />
<!-- END IF is_admin -->
<!-- IF is_admin_or_co -->
						{admin_MembersManagement}
						<select name='management_user'>
							<option value='1'>{basic_Yes}</option>
							<option value='0' selected='selected'>{basic_No}</option>
						</select><br />
<!-- END IF is_admin_or_co -->
						{admin_RankingManagement}
						<select name='management_ranking'>
							<option value='1'>{basic_Yes}</option>
							<option value='0' selected='selected'>{basic_No}</option>
						</select><br />
					</th> 
				</tr>
				<tr> 
					<th style="text-align:center;">{admin_Group}</th> 
					<th style="text-align:center;"> 
						<select name="group_id">
<!-- BEGIN group_list -->
							<option value="{group_list.value}">{group_list.text}</option>
<!-- END group_list -->
						</select>
					</th> 
				</tr>
				<tr> 
					<th style="text-align:center;" colspan="2"> 
						<input type="submit" value="{admin_Ok}" /> 
						<input type="button" value="{admin_Cancel}" onclick="document.getElementById('new_member').style.visibility = 'hidden';" /> 
					</th> 
				</tr> 
			</table> 
			</td>
		</tr>
	</table> 
	</form> 
</div>

<div id="edit_member" style="visibility:hidden;position:fixed;top:130px;left:50%;width:400px;margin-left:-200px;z-index:100;">
	<form method="post" action="?action=administration&amp;subaction=members&amp;postaction=admin_modify_member">
	<table>
		<tr>
			<td> 
				<table width="400" style="border:1px #003399 solid;background-color:#000000" cellpadding="3"><tbody> 
				<tr> 
					<td style="text-align:center;" class="c" colspan="3">{admin_EditAccount}</td> 
				</tr>
				<tr> 
					<th style="text-align:center;">{admin_name}</th> 
					<th colspan="2">
						<span id="edit_member_name" style="text-align:center;">&nbsp;</span>
					</th> 
				</tr>
				<tr> 
					<th style="text-align:center;" rowspan="4">{admin_Rights}</th> 
					<th style="text-align:left">
						{admin_ActiveAccount}
					</th>
					<th style="text-align:right">
						<select id='active' name="active">
							<option value='1'>{basic_Yes}</option>
							<option value='0' id='no_active'>{basic_No}</option>
						</select>
					</th>
				</tr>
				<tr>
<!-- IF is_admin -->
					<th style="text-align:left">
						{admin_CoAdmin}
					</th>
					<th style="text-align:right">
						<select id='user_coadmin' name="user_coadmin">
							<option value='1'>{basic_Yes}</option>
							<option value='0' id='no_coadmin'>{basic_No}</option>
						</select>
					</th>
<!-- END IF is_admin -->
				</tr>
				<tr>
<!-- IF is_admin_or_co -->
					<th style="text-align:left">
						{admin_MembersManagement}
					</th>
					<th style="text-align:right">
						<select id='management_user' name="management_user">
							<option value='1'>{basic_Yes}</option>
							<option value='0' id='no_userman'>{basic_No}</option>
						</select>
					</th>
<!-- END IF is_admin_or_co -->
				</tr>
				<tr>
					<th style="text-align:left">
						{admin_RankingManagement}
					</th>
					<th style="text-align:right">
						<select id='management_ranking' name="management_ranking">
							<option value='1'>{basic_Yes}</option>
							<option value='0' id='no_rankman'>{basic_No}</option>
						</select>
					</th> 
				</tr>
				<tr> 
					<th style="text-align:center;" colspan="3"> 
						<input type="hidden" id="user_id_edit" name="user_id" value="" />
						<input type="submit" value="{admin_Ok}" /> 
						<input type="button" value="{admin_Cancel}" onclick="document.getElementById('edit_member').style.visibility = 'hidden';" /> 
					</th> 
				</tr> 
			</tbody></table> 
			</td>
		</tr>
	</table>
	</form>
</div>
<script type="text/javascript" src="./js/admin_members.js"></script>
