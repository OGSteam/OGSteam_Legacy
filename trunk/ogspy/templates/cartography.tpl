<form method="post" action="?action=cartography" id="da_form">
<table>
<tr>
<!-- BEGIN titles -->
	<td class='c' align='center' style="color:{titles.color};">{titles.text}</td>
<!-- END titles -->
</tr>
<tr>
<!-- BEGIN form -->
	<th style='text-align:right;width:158px;white-space:nowrap;'>
		{common_Players}&nbsp;
		<input name="search_player[{form.i}]" type="text" maxlength="256" size="25" value="{form.player_input}" />
		<br/>
		{common_Allys}&nbsp;
		<input name="search_ally[{form.i}]" type="text" maxlength="256" size="25" value="{form.ally_input}" />
	</th>
<!-- END form -->
</tr>
<tr>
	<td class="c" colspan="{nb_colonnes_ally_x_2}" align="center">
	<input type="button" value="{cartography_ShowPosition}" onclick="this.form.submit();" />&nbsp;{help_separation}
	</td>
</tr>
</table>
</form>
<br />
<table>
<!-- define=table -->
	<!-- define=table.1st_row -->
	<tr>
		<td class="c" style="width:45px;">&nbsp;</td>
		<!-- define=table.1st_row.cell -->
		<td class='c' style="width:60px" colspan="{nb_colonnes_ally}">{table.1st_row.cell.title}</td>
		<!-- /define -->
		<td class="c" style="width:45px;">&nbsp;</td>
	</tr>
	<!-- /define -->
	<!-- define=table.row -->
	<tr>
		<td class='c' align='center' style="white-space: nowrap;">{table.row.system} - {table.row.up}</td>
		<!-- define=table.row.cell -->
		<th style="width:20px">
			<a style='cursor:pointer;color:{table.row.cell.color};' onmouseover="Tip('{table.row.cell.tip}',CLICKCLOSE,true)">
			{table.row.cell.nb_player}
			</a>
		</th>
		<!-- /define -->
		<!-- define=table.row.cell_empty -->
		<th style="width:20px;">&nbsp;</th>
		<!-- /define -->
		<td class='c' align='center' style="white-space: nowrap;">{table.row.system} - {table.row.up}</td>
	</tr>
	<!-- /define -->
<!-- /define -->
</table>



<!-- define=tooltip -->
<table width="200">
	<tr>
		<td class="c" colspan="2" align="center">
			{cartography_PresentPlayer}
		</td>
	</tr>
	<!-- define=tooltip.row -->
	<tr>
		<td class="c" align="center">{tooltip.row.player}</td>
		<th>{tooltip.row.position}</th>
	</tr>
	<!-- /define -->
</table>
<!-- /define -->
