<form method="post" action="?action=set_server_view">
<table width="100%">
<tr>
	<td class="c" colspan="2">{admin_optiongalaxy}</td>
</tr>
<tr>
	<th style="width:60%;">{admin_displaymip}</th>
	<th><input name="enable_portee_missil" type="checkbox" value="1" {enable_portee_missil} onclick="if (view.enable_portee_missil.checked == false)view.enable_portee_missil.checked=false;" /></th>
</tr>
<tr>
	<th>{admin_displayfriendlyphalanx}</th>
	<th>
		<input name="enable_friendly_phalanx" type="checkbox" value="1" {enable_friendly_phalanx} onclick="if (view.enable_friendly_phalanx.checked == false)view.enable_friendly_phalanx.checked=false;" />
	</th>
</tr>
<tr>
	<td class="c" colspan="2">{admin_optiongalaxyandclassement}</td>
</tr>
<tr>
	<th>{admin_countsspecialcolors}</th>
	<th><input name="scolor_count" type="text" size="3" maxlength="3" value="{scolor_count}" /></th>
</tr>
<!-- BEGIN colorspecial -->
<tr>
	<th style="color:{colorspecial.color};">{colorspecial.title}</th>
	<th>
		<input name="scolor_text[{colorspecial.id}]" type="text" size="15" value="{colorspecial.text}" />
		<select name="scolor_type[{colorspecial.id}]">
			<option value='J' {colorspecial.J_selected}>{common_Player}</option>
			<option value='A' {colorspecial.A_selected}>{common_Ally}</option>
		</select>
		&nbsp;{admin_helpspecialcolortext}
		<input name="scolor_color[{colorspecial.id}]" id="scolor_color{colorspecial.id}" type="text" size="15" maxlength="20" value="{colorspecial.color}" />&nbsp;{colorspecial.color_picker}
	</th>
</tr>
<!-- END colorspecial -->
<tr>
	<td class="c" colspan="2">{admin_optionstats}</td>
</tr>
<tr>
	<th>{admin_optionmembers}</th>
	<th><input name="enable_stat_view" type="checkbox" value="1" {enable_stat_view} onclick="if (view.enable_stat_view.checked == false)view.enable_members_view.checked=false;" /></th>
</tr>
<tr>
	<th>{admin_displaymbron}</th>
	<th><input name="enable_members_view" type="checkbox" value="1" {enable_members_view} onclick="if (view.enable_stat_view.checked == false)view.enable_members_view.checked=false;" /></th>
</tr>
<tr>
	<th>{admin_countgalaline}</th>
	<th><input name="galaxy_by_line_stat" type="text" size="5" maxlength="3" value="{galaxy_by_line_stat}" /></th>
</tr>
<tr>
	<th>{admin_countsysline}</th>
	<th><input name="system_by_line_stat" type="text" size="5" maxlength="3" value="{system_by_line_stat}" /></th>
</tr>
<tr>
	<td class="c" colspan="2">{admin_optionallypage}</td>
</tr>
<tr>
	<th>{admin_countscolumns}</th>
	<th><input name="nb_colonnes_ally" type="text" size="3" maxlength="20" value="{nb_colonnes_ally}" /></th>
</tr>
<!-- BEGIN colonnes_ally -->
<tr>
	<th style="color:{colonnes_ally.color};">
		{colonnes_ally.text}<br />
	</th>
	<th>
		<input name="color_ally[{colonnes_ally.id}]" id="color_ally{colonnes_ally.id}" type="text" size="15" maxlength="20" value="{colonnes_ally.color}" />
		&nbsp;{colonnes_ally.color_picker}
	</th>
</tr>
<!-- END colonnes_ally -->
<tr>
	<th>{admin_countgalaline}</th>
	<th><input name="galaxy_by_line_ally" type="text" size="5" maxlength="3" value="{galaxy_by_line_ally}" /></th>
</tr>
<tr>
	<th>{admin_countsysline}</th>
	<th><input name="system_by_line_ally" type="text" size="5" maxlength="3" value="{system_by_line_ally}" /></th>
</tr>
<tr>
	<td class="c" colspan="2">{admin_optionconnexion}</td>
</tr>
<tr>
	<th>{admin_displayregpannel}</th>
	<th>
		<input name="enable_register_view" type="checkbox" value="1" {enable_register_view} 
		onclick="if (view.enable_register_view.checked == false)view.enable_members_view.checked=false;" />
	</th>
</tr>
<tr>
	<th>{admin_allyname}</th>
	<th><input type="text" size="60" name="register_alliance" value="{register_alliance}" /></th>
</tr>
<tr>
	<th>{admin_boardlinkreg}</th>
	<th><input type="text" size="60" name="register_forum" value="{register_forum}" /></th>
</tr>
<tr>
	<th>{admin_usermodconnexion}</th>
	<th>
		<select name="open_user">
<!-- BEGIN open_user -->
			<option value="{open_user.value}" {open_user.selected}>{open_user.text}</option>
<!-- END open_user -->
		</select>
	</th>
</tr>
<tr>
	<th>{admin_adminmodconnexion}</th>
	<th>
		<select name="open_admin">
<!-- BEGIN open_admin -->
			<option value="{open_admin.value}" {open_admin.selected}>{open_admin.text}</option>
<!-- END open_admin -->
		</select>
	</th>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<th colspan="2">
		<input type="submit" value="{adminparam_Validate}" />&nbsp;
		<input type="reset" value="{adminparam_Reset}" />
	</th>
</tr>
</table>
</form>
<script type="text/javascript">
<!-- Begin
var colors = 0;
function View(color) {
	colors = color;
<!-- BEGIN js_loop1 -->
	if((a=document.getElementById("{js_loop1.id}")))
		a.style.backgroundColor = colors;
<!-- END js_loop1 -->
}

function Set(index) {
	switch(index){
<!-- BEGIN js_loop2 -->
		case {js_loop2.index}:
			text_area = document.getElementById("{js_loop2.id}");
			break;
<!-- END js_loop2 -->
	}
	text_area.value = colors;
}
// End -->
</script>


