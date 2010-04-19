<table width="100%">
	<tbody>
<!-- BEGIN info -->
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th colspan='3' style="text-align:left;">{info.text}</th>
	</tr>
<!-- END info -->
	<tr>
		<td class="h" style="width:2%;">&nbsp;</td>
		<td class="k" style="width:78%;">{adminmod_ActiveMods}</td>
		<td class="g" style="width:20%;">&nbsp;</td>
	</tr>
<!-- Liste des modules installés et actifs -->
<!-- BEGIN active -->
<!-- IF active.module -->
		<tr>
			<th style="width:50px;"> 
				{active.up_down_icons}
			</th>
			<th style="width:200px;">"
				<span id='edit_mod_{active.id}' style='display:none;text-align:left;'>
					{active.title}<br/>{adminmod_Mods_ChooseNewName}<br/>
					<input type='text' id='new_mod_name_{active.id}' size='104' value="{active.menu}" />
					<input type='submit' value='{basic_Ok}' onclick="mod_rename({active.id})" />
					<input type='button' value='{basic_Cancel}' onclick="reset_edits();" /><br/>
					{adminmod_Mods_ChooseNewAdminLink}<br/>
					<input type='text' id='new_mod_admin_link_{active.id}' size='104' value="{active.admin_link}" />
					<input type='submit' value='{basic_Ok}' onclick="mod_adminlink({active.id})" />
					<input type='button' value='{basic_Cancel}' onclick="reset_edits();" />
				</span>
				<span id='selectcat_mod_{active.id}' style='display:none; text-align:left;'>
					{active.title}&nbsp;{adminmod_Mods_ChooseACat}<br/>
					<select id="cat_id_{active.id}">
						{cat_select_list}
					</select>
					<input type='submit' value='{basic_Ok}' onclick="mod_addtocat({active.id})" />
					<input type='button' value='{basic_Cancel}' onclick="reset_edits();" />
				</span>
				<span id='normal_mod_{active.id}' style='display:block; text-align:left;'>
			{active.Text}
				</span>
			</th>
			<th style="text-align:right;">
				{active.action}
			</th>
		</tr>
<!-- ELSE IF active.module -->
		<tr>
			<th>
				{active.up_down_icons}
			</th>
			<th>
				<span id='edit_cat_{active.id}' style='display:none;text-align:left;'>
					{active.Text}&nbsp;{adminmod_Mods_ChooseNewName}<br/>
					<input type='text' id='new_cat_title_{active.id}' size='20' title='{adminmod_SelectTitle}' value='{active.title}' {active.readonly} />
					<input type='text' id='new_cat_name_{active.id}' size='81' title='{adminmod_SelectMenu_cat}' value='{active.menu}' />
					<input type='submit' value='{basic_Ok}' onclick='cat_rename({active.id})' />
					<input type='button' value='{basic_Cancel}' onclick='reset_edits();' />
				</span>
				<span id='normal_cat_{active.id}' style='display:block; text-align:left;'>
					{active.Text}
				</span>
			</th>
			<th style="text-align:right;">
				{active.action}
			</th>
		</tr>
<!-- END IF active.module -->
<!-- END active -->
	<tr>
		
		<td class="d" colspan="2">&nbsp;</td>
		<td class="d" align="right">
			&nbsp;
			<span onclick="document.getElementById('new_cat').style.visibility = 'visible';" style='cursor:pointer;'>
				{adminmod_CatCreate}
			</span>
		</td>
	</tr>
<!-- IF is_inactive -->
	<tr>
		<td class="h">&nbsp;</td>
		<td class="k">{adminmod_InactiveMods}</td>
		<td class="g">&nbsp;</td>
	</tr>
<!--- Liste des modules installés innactifs --->
<!-- BEGIN inactive -->
		<tr>
			<th>
				{inactive.up_down_icons}
			</th>
			
			<th style="text-align:left;">{inactive.title}</th>
			<th style="text-align:right;">
				{inactive.action}
			</th>
		</tr>
<!-- END inactive -->
	<tr>
		<td>&nbsp;</td>
	</tr>
<!-- END IF is_inactive -->
<!-- IF is_uninstalled -->
	<tr>
		<td class="h">&nbsp;</td>
		<td class="k">{adminmod_InstallableMods}</td>
		<td class="g">&nbsp;</td>
	</tr>
<!--- Liste des modules non installés --->
<!-- BEGIN uninstalled -->
		<tr>
		<th>&nbsp;</th>
		<th style="text-align:left;">{uninstalled.title}</th>
		<th style="text-align:right;">
			{uninstalled.action}
		</th>
	</tr>
<!-- END uninstalled -->
	<tr>
		<td>&nbsp;</td>
	</tr>
<!-- END IF is_uninstalled -->
<!-- IF is_wrong -->
	<tr>
		<td class="h">&nbsp;</td>
		<td class="k">{adminmod_InvalidMods}</td>
		<td class="g">&nbsp;</td>
	</tr>
<!--- Liste des modules invalides --->
<!-- BEGIN wrong -->
	<tr>
		<th>&nbsp;</th>
		<th style="text-align:left;">{wrong.title}</th>
		<th style="text-align:right;">
			{wrong.action}
		</th>
	</tr>
<!-- END wrong -->
<!-- END IF is_wrong -->
	</tbody>
</table>
<input type='hidden' id='mod_list' value='{x_mod_list}' />
<input type='hidden' id='cat_list' value='{x_cat_list}' />

<!-- Formulaire de creation d'une nouvelle categorie -->
<div id="new_cat" style="visibility: hidden; position: fixed; top: 180px; left: 500px;z-index: 100;"> 
	<table width="200" style="border:1px #003399 solid;" cellpadding="3">
		<tr>
			<td style="text-align:center;" class="c">
				{adminmod_Add}
			</td>
		</tr>
		<tr>
			<th style="text-align:center;"> 
			<!-- <form action="?action=administration&subaction=mod&make=cat_create" method="post">	-->
				{adminmod_CatName}<br/>
			<input type="text" id="cat_name" size="48" value="" /><br /><br /> 
			<input type="button" value="{basic_Ok}" onclick="cat_create();" /> 
			<input type="button" value="{basic_Cancel}" onclick="document.getElementById('new_cat').style.visibility = 'hidden';" /> 
			<!-- </form> -->
			</th>
		</tr>
	</table> 
</div>
<script type="text/javascript">
<!-- Begin
function mod_rename(id){
	name = document.getElementById('new_mod_name_'+id).value;
	window.location = '?action=administration&subaction=mod&make=mod_rename&'+'mod_id='+id+'&'+'new_mod_name='+name;
}
function cat_rename(id){
	title = document.getElementById('new_cat_title_'+id).value;
	name = document.getElementById('new_cat_name_'+id).value;
	window.location = '?action=administration&subaction=mod&make=cat_rename&'+'cat_id='+id+'&'+'new_cat_title='+title+'&'+'new_cat_name='+name;
}
function cat_create(){
	name = document.getElementById('cat_name').value;
	window.location = '?action=administration&subaction=mod&make=cat_create&'+'cat_name='+name;
}
function mod_adminlink(id){
	link = document.getElementById('new_mod_admin_link_'+id).value;
	window.location = '?action=administration&subaction=mod&make=mod_admin_link&'+'mod_id='+id+'&'+'new_mod_admin_link='+link;
}
function mod_addtocat(id){
	cat = document.getElementById('cat_id_'+id).value;
	window.location = '?action=administration&subaction=mod&make=cat_add_mod&'+'mod_id='+id+'&'+'cat_id='+cat;
}
function show_edit_for_mod(mod_id){	
	reset_edits();
	document.getElementById('edit_mod_'+mod_id).style.display = 'block';
	document.getElementById('normal_mod_'+mod_id).style.display = 'none';
}
function show_edit_for_cat(cat_id){	
	reset_edits();
	document.getElementById('edit_cat_'+cat_id).style.display = 'block';
	document.getElementById('normal_cat_'+cat_id).style.display = 'none';
}
function show_select(mod_id){
	reset_edits();
	document.getElementById('selectcat_mod_'+mod_id).style.display = 'block';
	document.getElementById('normal_mod_'+mod_id).style.display = 'none';
}
function reset_edits(){
	var list = document.getElementById('mod_list').value;
	var id_list = list.split('<|>');
	for(var i=0;i< id_list.length;i++){
		var id = id_list[i];
		a = document.getElementById('selectcat_mod_'+id);
		b = document.getElementById('edit_mod_'+id);
		c = document.getElementById('normal_mod_'+id);
		if(a) a.style.display = 'none';
		if(b) b.style.display = 'none';
		if(c) c.style.display = 'block';
	}
	var list = document.getElementById('cat_list').value;
	var id_list = list.split('<|>');
	for(var i=0;i< id_list.length;i++){
		var id = id_list[i];
		document.getElementById('edit_cat_'+id).style.display = 'none';
		document.getElementById('normal_cat_'+id).style.display = 'block';
	}
}
// End -->
</script>
