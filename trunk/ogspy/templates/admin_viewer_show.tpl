<table width="100%">
	<tr>
		<th colspan="3"><big>
		{selected_date}
		</big></th>
	</tr>
	<tr>
		<th width="25%" style="text-align:right;{type_log_style}" onclick="{type_log_onclick}">{type_log}</th>
		<td width="50%" class='k'><big>{type_selected}</big></td>
		<th width="25%" style="text-align:left;{type_sql_style}" onclick="{type_sql_onclick}">{type_sql}</th>
	</tr>
	<tr>
		<td class="l" colspan="3"><b>{adminviewer_Viewer}</b><br/>
<!-- BEGIN log -->
			<font color='orange'>{log.date}</font>{log.line}<br/>
<!-- END log -->
		</td>
	</tr>
</table>
<input type='hidden' id='save_return' value='{save_return}'>
