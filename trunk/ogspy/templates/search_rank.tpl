
<!-- BEGIN rank -->
<table width="480">
<!-- IF show_rank -->
	<tr>
		<td class="c" colspan="8">{rank.title}</td>
	</tr>
	<tr>
		<td class="c">{search_date}</td>
		<td class="c" colspan="2">{search_GeneralPoints}</td>
		<td class="c" colspan="2">{search_FlottePoints}</td>
		<td class="c" colspan="2">{search_ResearchPoints}</td>
<!-- IF rank.ally -->
		<td class="c">{search_MemberCount}</td>
<!-- END IF rank.ally -->
	</tr>
<!-- BEGIN rank_{rank.id} -->
	<tr>
		<th style="width=150px;white-space:nowrap;">{rank_{rank.id}.date}</th>
		<th style="width:70px;">{rank_{rank.id}.general_points}</th>
		<th style="width:40px;color:lime;"><i>{rank_{rank.id}.general_rank}</i></th>
		<th style="width:70px;">{rank_{rank.id}.fleet_points}</th>
		<th style="width:40px;color:lime;"><i>{rank_{rank.id}.fleet_rank}</i></th>
		<th style="width:70px;">{rank_{rank.id}.research_points}</th>
		<th style="width:40px;color:lime;"><i>{rank_{rank.id}.research_rank}</i></th>
<!-- IF rank.ally -->
		<th style="width:70px;">{rank_{rank.id}.number_member}</th>
<!-- END IF rank.ally -->
	</tr>
<!-- END rank_{rank.id} -->
<!-- ELSE IF show_rank -->
	<tr><th>{search_NoResult}</th></tr>
<!-- END IF show_rank -->
</table>
<!-- END rank -->
