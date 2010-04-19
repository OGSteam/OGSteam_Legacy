<table style="text-align:center;margin-left:auto;margin-right:auto;">
<tr>
	<td class="c" colspan="{colspan_head}" align="center">{stats_cartoState}</td>
</tr>
<!-- define=1st_row -->
<tr>
	<td class="c" style="width:45px;">&nbsp;</td>
<!-- define=1st_row.cell -->
	<td class="c" style="width:60px;" colspan="2">{1st_row.cell.name}</td>
<!-- /define -->
	<td class="c" style="width:45px;">&nbsp;</td>
</tr>
<!-- /define -->
<!-- define=row -->
<tr>
	<td class="c" align="center">{row.interval}</td>
<!-- define=row.cell -->
	<th style="width:30px;" {row.cell.link_colonized}>{row.cell.colonized}</th>
	<th style="width:30px;" {row.cell.link_free}>{row.cell.free}</th>
<!-- /define -->
	<td class='c' align='center'>{row.interval}</td>
</tr>
<!-- /define -->
<tr>
	<td class="c" colspan="{colspan_head}" align="center" onmouseover="Tip('{tip_legend}');" onmouseout="UnTip();">{stats_Legend}</td>
<!-- define=legend -->
	<table width="225">
		<tr><td class="c" colspan="2" style="text-align:center; text-decoration:bold;width:150px;">{stats_Legend}</td></tr>
		<tr><td class="c">{stats_KnownPlanets}</td><th><font color="#1EFF38">xx</font></th></tr>
		<tr><td class="c">{stats_FreePlanets}</td><th><font color="#FF6600"><b>xx</b></font></th></tr>
		<tr><td class="c">{stats_UpdatedRecentlyPlanets}</td><th><font color="#1EFF38"><blink><b>xx</b></blink></font></th></tr>
	</table>
<!-- /define -->
</tr>
</table>
