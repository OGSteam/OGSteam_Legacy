<table style="text-align:center;margin-left:auto;margin-right:auto;">
<tr>
	<td class="c" style="width:75px;"><a href="{homespy_pos_link}">{homespy_pos}</a></td>
	<td class="c" style="width:120px;"><a href="{homespy_Allys_link}">{homespy_Allys}</a></td>
	<td class="c" style="width:120px;"><a href="{homespy_Players_link}">{homespy_Players}</a></td>
	<td class="c" style="width:20px;"><a href="{homespy_Moon_link}">{homespy_Moon}</a></td>
	<td class="c" style="width:20px;">&nbsp;</td>
	<td class="c" style="width:250px;"><a href="{homespy_Updated_link}">{homespy_Updated}</a></td>
	<td class="c" style="width:40px;">&nbsp;</td>
	<td class="c" style="width:120px;">&nbsp;</td>
</tr>
<!-- IF is_fs -->
<!-- BEGIN fs -->
<tr>
	<th>{fs.coordinates}</th>
	<th>{fs.ally}</th>
	<th>{fs.player}</th>
	<th>{fs.moon}</th>
	<th>{fs.status}</th>
	<th>{fs.poster}</th>
	<th>
		<input type='button' value="{fs.homespy_Look}" onclick="window.open('{fs.show_report_link}','_blank','width=640, height=480, toolbar=0, location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=0');return(false);" />
	</th>
	<th>
		<input type='button' value="{fs.homespy_Delete}" onclick=\"window.location = '{fs.delete_link}';\" />
	</th>
</tr>
<!-- END fs -->
<!-- END IF is_fs -->
</table>
