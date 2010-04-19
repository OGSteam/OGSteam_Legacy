<table>
<!-- IF is_admin -->
	<tr align="right">
			<td colspan="12"><a href="?action=raz_ratio">{stats_reset}</a></td>
	</tr>
<!-- END IF is_admin -->
	<tr align="center">
		<td class="c" style="width:100px;">{stats_Nicknames}</td>
		<td class="c" colspan="2">{stats_Planets}</td>
		<td class="c" colspan="2">{stats_SpyReports}</td>
		<td class="c" colspan="2">{stats_RankingLines}</td>
		<td class="c" colspan="1">{stats_ResearchMade}</td>
		<td class="c" colspan="1">{stats_Ratio}</td>
	</tr>
	<tr align="center">
		<td class="c" style="width:100px;">&nbsp;</td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:100px;">&nbsp;</td>
		<td class="c" style="width:100px;">&nbsp;</td>
	</tr>
<!-- BEGIN stats -->
	<tr>
		<th><span style="color:{stats.color};">{stats.user_name}{stats.here}</span></th>
		<th>{stats.planet_added_web}</th>
		<th>{stats.planet_added_ogs}</th>
		<th>{stats.spy_added_web}</th>
		<th>{stats.spy_added_ogs}</th>
		<th>{stats.rank_added_web}</th>
		<th>{stats.rank_added_ogs}</th>
		<th>{stats.search}</th>
		<th><span style="color:{stats.color};">{stats.result}</span></th>
	</tr>
<!-- END stats -->
<!-- IF big_table -->
	<tr align="center">
		<td class="c" style="width:100px;">&nbsp;</td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromBrowser}">{stats_web}<br/></a></td>
		<td class="c" style="width:50px;"><a title="{stats_LoadedFromPlugin}">{stats_plugin}<br/></a></td>
		<td class="c" style="width:100px;">&nbsp;</td>
		<td class="c" style="width:100px;">&nbsp;</td>
	</tr>
	<tr align="center">
		<td class="c" style="width:100px;">{stats_Nicknames}</td>
		<td class="c" colspan="2">{stats_Planets}</td>
		<td class="c" colspan="2">{stats_SpyReports}</td>
		<td class="c" colspan="2">{stats_RankingLines}</td>
		<td class="c" colspan="1">{stats_ResearchMade}</td>
		<td class="c" colspan="1">{stats_Ratio}</td>
	</tr>
<!-- END IF big_table -->
<!-- IF enable_members_view -->
	<tr>
		<td colspan="12">{stats_ConnectedLegend}</td>
	</tr>
<!-- END IF enable_members_view -->
</table>
