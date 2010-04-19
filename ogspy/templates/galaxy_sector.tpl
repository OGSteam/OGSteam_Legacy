<table>
	<tr align='center'>
		<td class='c'>{link_galaxysector_Previous}</td>
		<td class='c' colspan='3'>{galaxysector_Navigation}<br />{galaxy}:{system_down} - {galaxy}:{system_up}</td>
		<td class='c'>{link_galaxysector_Next}</td>
	</tr>
<!-- define=line -->
	<tr>
<!-- define=line.cell -->
		<td valign='top'>
			<table width='190'>
				<tr align='center'>
					<td class='c' style="width:30px;">&nbsp;</td>
					<td class='c'>
						<a href='{line.cell.link}'>{line.cell.galaxy}:{line.cell.cols}</a>
						<br />{line.cell.last_update}
					</td>
				</tr>
<!-- define=line.cell.row -->
				<tr style="text-align:center;height:50px">
					<td class='c' style="vertical-align:top;">
						{line.cell.row.position}<br />
						{line.cell.row.moon}<br />
						{line.cell.row.status}<br />
						{line.cell.row.spyreport}
					</td>
					<th valign='top'>
						{line.cell.row.planet}<br />
						{line.cell.row.player}<br />
						{line.cell.row.ally}
					</th>
				</tr>
<!-- /define -->
			</table>
		</td>
<!-- /define -->
	</tr>
<!-- /define -->
	<tr align='center'>
		<td class='c'>{link_galaxysector_Previous}</td>
		<td class='c' colspan='3'>{galaxysector_Navigation}<br />{galaxy}:{system_down} - {galaxy}:{system_up}</td>
		<td class='c'>{link_galaxysector_Next}</td>
	</tr>
</table>

<!-- define=cell_planet --><a href='{cell_planet.link}' style='color:gray;'><i>{cell_planet.content}</i></a><!-- /define -->
<!-- define=cell_player --><a href='{cell_player.link}' style='color:lime;'>{cell_player.content}</a><!-- /define -->
<!-- define=cell_ally --><a href='{cell_ally.link}' style='color:orange;'>[{cell_ally.content}]</a><!-- /define -->
<!-- define=cell_nolink --><span style='color:{cell_nolink.color};'>{cell_nolink.content}</span><!-- /define -->
<!-- define=cell_windowopen -->
<a href='#' onClick="window.open('{cell_windowopen.link}','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false)"><font color='{color}'>{cell_windowopen.content}</font></a>
<!-- /define -->
