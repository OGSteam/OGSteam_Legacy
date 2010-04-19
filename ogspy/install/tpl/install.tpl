<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<!-- IF close_install -->
<form method="post" action="../?">
<!-- ELSE IF close_install -->
<form method="post" action="../install/index.php?lang={lang_install}">
<!-- END IF close_install -->
	
<table width="800">
	<tr>
		<td colspan="2" align="center" style="font-size:3;"><b>{installwelcome}</b></td>
	</tr>
	<tr>
		<td colspan="2" align="center">&nbsp;
		<input type="hidden" name="action" value="install" />
		<!-- IF is_update -->
		<input type="hidden" name="update" value="1" />
		<!-- END IF is_update -->
		</td>
	</tr>
<!-- IF is_error -->
	<tr>
		<td colspan="2" align="center" style="color: #ff0000;"><b>{pub_error}</b></td>
	</tr>
<!-- END IF is_error -->
<!-- IF is_warning -->
	<tr>
		<td colspan="2" align="center" style="color: #ffa500;"><b>{pub_warning}</b></td>
	</tr>
<!-- END IF is_warning -->
<!-- IF is_msgok -->
	<tr>
		<td colspan="2" align="center" style="color: #008000;"><b>{pub_msgok}</b></td>
	</tr>
<!-- END IF is_msgok -->
<!-- IF is_info -->
	<tr>
		<td colspan="2" align="center" style="color: #d3d3d3;"><b>{pub_info}</b></td>
	</tr>
<!-- END IF is_info -->
<!-- IF config_control -->
	<tr>
		<td class="c" colspan="2">{controltitle}</td>
	</tr>
	<tr>
		<th>{PHP_Version}</th>
		<th>{PHP_Version_value}</th>
	</tr>
	<tr>
		<th>{Parameter_Access}</th>
		<th>{Parameter_Access_value}</th>
	</tr>
	<tr>
		<th>{Journal_Access}</th>
		<th>{Journal_Access_value}</th>
	</tr>
	<tr>
		<th>{Mod_Access}</th>
		<th>{Mod_Access_value}</th>
	</tr>
<!-- END IF config_control -->
<!-- IF config_db -->
	<tr>
		<td class="c" colspan="2">{dbconfigtitle}</td>
	</tr>
	<tr>
		<th>{dbhostname}</th>
		<th><input name="sgbd_server" type="text" value="{pub_sgbd_server}" /></th>
	</tr>
	<tr>
		<th>{dbname}</th>
		<th><input name="sgbd_dbname" type="text" value="{pub_sgbd_dbname}" /></th>
	</tr>
	<tr>
		<th>{dbusername}</th>
		<th><input name="sgbd_username" type="text" value="{pub_sgbd_username}" /></th>
	</tr>
	<tr>
		<th>{dbpassword}</th>
		<th><input name="sgbd_password" type="password" /></th>
	</tr>
	<tr>
		<th>{dbtableprefix}</th>
		<th><input name="sgbd_tableprefix" type="text" value="{pub_sgbd_tableprefix}" /></th>
	</tr>
<!-- END IF config_db -->
<!-- IF config_account -->
	<tr>
		<td class="c" colspan="2">{adminconfigtitle}</td>
	</tr>
	<tr>
		<th>{adminloginname}</th>
		<th><input name="admin_username" type="text" value="{pub_admin_username}"/></th>
	</tr>
	<tr>
		<th>{adminpassword}</th>
		<th><input name="admin_password" type="password"/></th>
	</tr>
	<tr>
		<th>{adminpasswordconfirm}</th>
		<th><input name="admin_password2" type="password" /></th>
	</tr>
<!-- END IF config_account -->
<!-- IF config_uni -->
	<tr>
		<td class="c" colspan="2">
			{uniconfigtitle}
			<input name="admin_username" type="hidden" value="{pub_admin_username}" />
			<input name="admin_password" type="hidden" value="{pub_admin_password}" />
		</td>
	</tr>
	<tr>
		<th>{servername}</th>
		<th><input name="servername" type="text" size="32" value="{pub_servername}" /></th>
	</tr>
	<tr>
		<th>{numgalaxies}</th>
		<th><input name="num_of_galaxies" type="text" value="{pub_num_of_galaxies}" size="5" /></th>
	</tr>
	<tr>
		<th>{numsystems}</th>
		<th><input name="num_of_systems" type="text" value="{pub_num_of_systems}" size="5" /></th>
	</tr>
	<tr>
		<th>{speeduni}</th>
		<th><input name="speeduni" type="text" value="{pub_speeduni}" size="5" /></th>
	</tr>
	<tr>
		<th>{ddr}</th>
		<th><select name="ddr">
				<option value="0" {ddr_selected_no}>{common_No}</option>
				<option value="1" {ddr_selected_yes}>{common_Yes}</option>
		</select></th>
	</tr>
	<tr>
		<th>{serverlanguage}</th>
		<th>
			<select name="serverlanguage">
			{lang_list}
			</select>
		</th>
	</tr>
	<tr>
		<th>{parsinglanguage}</th>
           <th>
			<select name="parsinglanguage">
			{lang_list}
			</select>
		</th>
	</tr>
<!-- END IF config_uni -->
<!-- IF module_install -->
	<tr>
		<td class="c">{Mod_Name}</td>
		<td class="c" style="width:10%;">{Install_Button}</td>
	</tr>
<!-- BEGIN mod -->
	<tr>
		<th><span style="text-align:left;width:400px;display:inline;float:left;">{mod.name}</span>{mod.info}</th>
		<th>
<!-- IF mod.disable -->
		<img src="../images/action_check.png" alt="" />
<!-- ELSE IF mod.disable -->
		<input type="checkbox" name="mod[{mod.root}]" checked="checked" />
<!-- END IF mod.disable -->
		</th>
	</tr>
<!-- END mod -->
	<tr>
		<td colspan="2" style="text-align:right;">
		<a href="javascript:select_all();">{select_all}</a>
		&nbsp;/&nbsp;
		<a href="javascript:reverse_all();">{reverse_all}</a>
		&nbsp;/&nbsp;
		<a href="javascript:unselect_all();">{unselect_all}</a>
		</td>
	</tr>
<!-- END IF module_install -->
<!-- IF close_install -->
	<tr><th colspan="2"><big><big>{Thanks_For_Having_Installed_OGSpy}</big></big><br/><br/>{installsuccess}</th></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><th colspan="2" style="text-align:left;">{end_install_notes2}</th></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><th colspan="2">{deleteinstall}</th></tr>
	<tr>
		<th colspan="2">
			<button class="button" type="submit">{Return_to_OGSpy}</button>
		</th>
	</tr>
<!-- ELSE IF close_install -->
<!-- IF end_install -->
	<tr><th colspan="2"><big><big>{Thanks_For_Having_Installed_OGSpy}</big></big><br/><br/>{installsuccess}</th></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><th colspan="2" style="text-align:left;">{end_install_notes}</th></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<th colspan="2">
			<button class="button" style="position:inline; float:left;" type="submit" name="step" value="{prev_step}">&lt;&lt;&lt;</button>
			<button class="button" type="submit" name="step" value="{next_step}">{end_install_button}</button>
		</th>
	</tr>
<!-- ELSE IF end_install -->
	<tr><td colspan="2">&nbsp;</td></tr>
	<tr>
		<th colspan="2">
			<button class="button" style="position:inline; float:left;" type="submit" name="step" value="{prev_step}">&lt;&lt;&lt;</button>
			<button class="button" style="position:inline; float:right;" type="submit" name="step" value="{next_step}"{next_step_style}>&gt;&gt;&gt;</button>
		</th>
	</tr>
<!-- END IF end_install -->
<!-- END IF close_install -->
	<tr><td colspan="2">&nbsp;</td></tr>
	<!--<tr>-->
	<!--	<td colspan="2" align="center"><a target="_blank" href="http://ogspynstall.ogsteam.fr/?lang={lang_install}"><i><font color="#FFA500">{needhelp}</font></i></a></td>-->
	<!--</tr>-->
</table>
</form>

<!-- IF module_install -->
<script type="text/Javascript">
<!-- Begin
function reverse_all(){
	test = document.getElementsByTagName('input');
	ln = test.length;
	for(i=0;i< ln;i++)
		test[i].checked = 1-test[i].checked;
}
function select_all(){
	test = document.getElementsByTagName('input');
	ln = test.length;
	for(i=0;i< ln;i++)
		test[i].checked = 1;
}
function unselect_all(){
	test = document.getElementsByTagName('input');
	ln = test.length;
	for(i=0;i< ln;i++)
		test[i].checked = 0;
}
//  End -->
</script>
<!-- END IF module_install -->
