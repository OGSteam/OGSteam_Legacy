<table width="100%">
<tr>
<td class="c" style="width:25%;">{admin_Column1}</td><td class="c" style="width:25%;">{admin_Column2}</td>
<td class="c" style="width:25%;">{admin_Column1}</td><td class="c" style="width:25%;">{admin_Column2}</td>
</tr>
<tr>
	<th><a>{admin_CountMember}</a></th><th>{users_info}</th>
	<th><a>{admin_CountFreePlanet}</a></th><th>{nb_planets_free}</th>
</tr>
<tr>
	<th><a>{admin_CountPlanet}</a></th><th>{nb_planets}</th>
	<th rowspan="2"><a>{admin_DBSize}</a></th><th>{db_size_info}</th>
</tr>
<tr>
	<th><a>{admin_LogSize}</a></th><th>{log_size_info}</th>
	<th><a href="{admin_OptimizeDB_link}"><i>{admin_OptimizeDB}</i></a></th>
</tr>
<tr>
	<th><a>{admin_CountSessionOpen}</a></th>
	<th>{connectes}&nbsp;<a href="{admin_drop_sessions_link}">{admin_drop_sessions}</a></th>
	<th colspan='2'>
	<form action="?action=import_RE" method="get">
		<div>
			<input type="submit" value="{admin_update_RE}" />
		</div>
	</form>
	</th>
</tr>
<tr>
	<th colspan='4'>&nbsp;</th>
</tr>
<tr>
	<th><a>{admin_ServerConnection}</a></th><th>{connection_server}</th>
	<th><a>{admin_OGSConnection}</a></th><th>{connection_ogs}</th>
</tr>
<tr>
	<th><a>{admin_ServerPlanets}</a></th><th>{planetimport_server}</th>
	<th><a>{admin_OGSPlanets}</a></th><th>{planetimport_ogs}</th>
</tr>
<tr>
	<th><a>{admin_ServerSpy}</a></th><th>{spyimport_server}</th>
	<th><a>{admin_OGSSpy}</a></th><th>{spyimport_ogs}</th>
</tr>
<tr>
	<th><a>{admin_ServerRanking}</a></th><th>{rankimport_server}</th>
	<th><a>{admin_OGSRanking}</a></th><th>{rankimport_ogs}</th>
</tr>
<tr>
	<th class="c" colspan="4">&nbsp;</th>
</tr>
<tr>
	<th colspan="2"><a href="php/phpinfo.php" onclick="window.open(this.href); return false;">PHPInfo</a></th>
	<th colspan="2"><a href="php/phpmodules.php" onclick="window.open(this.href); return false;">Modules PHP</a></th>
</tr>
</table>
<br />
<table width="100%">
<tr>
	<td class="c">{admin_VersionInformation}</td>
</tr>
<tr>
	<th style="text-align:left">
		<span id="version_info"><img src="images/ajax.gif" style="vertical-align:middle;" alt=""/>&nbsp;...</span><br />
		<span id="version_subinfo">{admin_prepare_check_version}</span>
	</th>
</tr>
</table>
<br />
<table width="100%">
<tr>
<td class="c">{admin_MemberName}</td>
<td class="c">{admin_Connection}</td>
<td class="c">{admin_LastActivity}</td>
<td class="c">{admin_IPAddress}</td>
</tr>
<!-- BEGIN users_list -->
<tr>
	<th style="width:25%;">{users_list.name}</th>
	<th style="width:25%;">{users_list.connexion}</th>
	<th style="width:25%;">{users_list.time}</th>
	<th style="width:25%;">{users_list.ip}</th>
</tr>
<!-- END users_list -->
</table>

<script type="text/JavaScript">
<!-- Begin
	setTimeout('Get_Last_Version()',2000);
	
	function Get_Last_Version()
	{
		var br_string = '<br />';
		var img_tag = '<img src="images/ajax.gif" alt="Loading..." style="vertical-align: middle;" />&nbsp;';
		var VersionInfo		= $('version_info');
		var VersionSubInfo	= $('version_subinfo');
		
		jQuery.ajax({
			url : "index.php",
			dataType : "json",
			data: {
				action  : 'administration',
				ajax	: '1'
			},
			beforeSend : function() 
			{ 
				VersionInfo.innerHTML = img_tag+'{common_AjaxChargement}'; 
			},
			success: function(data)
			{
				var versiontext = new Element('font', { style: 'color:red;' }).update(data.up_to_date ? '' : data.version.stripScripts());
				var a			= new Element('a', { href: data.link }).update(data.linkmessage.stripScripts());	
				VersionInfo.update(data.message).style.color = data.version_checked ? data.up_to_date ? 'green' : 'red' : 'orange';
				VersionSubInfo.update(data.message2.stripScripts()).appendChild(versiontext);
				VersionSubInfo.insert(br_string).appendChild(a);
			},
			error : function()
			{
				alert('Something went wrong...');
			}
		});
	}
// End -->
</script>
