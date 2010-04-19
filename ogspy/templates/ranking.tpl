<table width="100%">
<tr>
	<td>
		<table style="text-align:center;margin-left:auto;margin-right:auto;">
		<tr align="center">
<!-- IF player_selected -->
			<th style="width:150px;"><a>{ranking_Players}</a></th>
			<td class='c' style="width:150px;" onclick="window.location = '?action=ranking&amp;subaction=ally';">
			<a style='cursor:pointer;color:lime;'>{ranking_Allys}</a>
			</td>
<!-- ELSE IF player_selected -->
			<td class="c" style="width:150px;" onclick="window.location = '?action=ranking&amp;subaction=player';">
			<a style="cursor:pointer;color:lime;">{ranking_Players}</a>
			</td>
			<th style="width:150px;"><a>{ranking_Allys}</a></th>
<!-- END IF player_selected -->
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<form method="post" action="{form_action}">
		<table style="text-align:center;margin-left:auto;margin-right:auto;">
			<tr>
				<td align="right">
					<select name="date" onchange="this.form.submit();">
						{date_select_option}
					</select>
					&nbsp;
					<select name="interval" onchange="this.form.submit();">
						{interval_option}
					</select>
				</td>
<!-- IF is_admin -->
	<form method="POST" action="index.php" onsubmit="return confirm('{rankingplayer_Areyousure}');
		<input type="hidden" name="action" value="drop_ranking"/>
		<input type="hidden" name="subaction" value="player"/>
		<input type="hidden" name="datadate" value="<?php echo $datadate;?>"/>
		<td align="right"><input type="image" src="images/drop.png" title="{rankingplayer_Areyousure}"/></td>
	</form>
<!-- END IF is_admin -->
			</tr>
		</table>
		</form>
		<table width="700" style="text-align:center;margin-left:auto;margin-right:auto;">
<tr>
<!-- IF player_selected -->
	<td class="c" style="width:30px;">{ranking_Place}</td>
	<td class="c">{ranking_Member}</td>
	<td class="c">{ranking_Ally}</td>
	<td class="c" colspan="2">{link_general}</td>
	<td class="c" colspan="2">{link_fleet}</td>
	<td class="c" colspan="2">{link_research}</td>
<!-- ELSE IF player_selected -->
	<td class="c" style="width:30px;">{ranking_Place}</td>
	<td class="c">{ranking_Ally}</td>
	<td class="c">{ranking_Member}</td>
	<td class="c" colspan="3">{link_general}</td>
	<td class="c" colspan="3">{link_fleet}</td>
	<td class="c" colspan="3">{link_research}</td>
<!-- END IF player_selected -->
</tr>
<!-- IF is_rank -->
<!-- BEGIN line -->
<tr>
<!-- IF player_selected -->
	<th>{line.rank}</th>
	<th>{line.player}</th>
	<th>{line.ally}</th>
	<th style="width:70px;">{line.general_pts}</th>
	<th style="width:40px;color:lime;"><i>{line.general_rank}</i></th>
	<th style="width:70px;">{line.fleet_pts}</th>
	<th style="width:40px;color:lime;"><i>{line.fleet_rank}</i></th>
	<th style="width:70px;">{line.research_pts}</th>
	<th style="width:40px;color:lime;"><i>{line.research_rank}</i></th>
<!-- ELSE IF player_selected -->
	<th>{line.rank}</th>
	<th>{line.ally}</th>
	<th>{line.nbmember}</th>
	<th style="width:60px;">{line.general_pts}</th>
	<th style="width:40px;color:yellow;"><i>{line.general_pts_per_member}</i></th>
	<th style="width:40px;color:lime;"><i>{line.general_rank}</i></th>
	<th style="width:60px;">{line.fleet_pts}</th>
	<th style="width:40px;color:yellow;"><i>{line.fleet_pts_per_member}</i></th>
	<th style="width:40px;color:lime;"><i>{line.fleet_rank}</i></th>
	<th style="width:60px">{line.research_pts}</th>
	<th style="width:40px;color:yellow;"><i>{line.research_pts_per_member}</i></th>
	<th style="width:40px;color:lime;"><i>{line.research_rank}</i></th>
<!-- END IF player_selected -->
</tr>
<!-- END line -->
<!-- END IF is_rank -->
</table>
	</td>
</tr>
</table>

<!-- define=sort_selection -->
<table width="120">
	<tr>
		<td class="c">
			<a href="?action=ranking&amp;subaction=ally&amp;order_by=type">{ranking_Orderglobal}</a>
		</td>
	</tr>
	<tr>
		<td class="c">
			<a href="?action=ranking&amp;subaction=ally&amp;order_by=type&amp;suborder=member">{ranking_Orderbymember}</a>
		</td>
	</tr>
</table>
<!-- /define -->
