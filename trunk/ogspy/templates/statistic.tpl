<table width="100%">
<tr>
	<td>
		<table style="text-align:center;margin-left:auto;margin-right:auto;">
		<tr>
<!-- IF menu_members -->
			<th style="width:150px;">
				<a>{members}</a>
			</th>
<!-- ELSE IF menu_members -->
			<td class="c" style="width:150px;" onclick="window.location='?action=statistic&amp;subaction=members';">
				<a style="cursor:pointer;color:lime;">{members}</a>
			</td>
<!-- END IF menu_members -->
<!-- IF menu_univers -->
			<th style="width:150px;">
				<a>{universe}</a>
			</th>
<!-- ELSE IF menu_univers -->
			<td class="c" style="width:150px;" onclick="window.location='?action=statistic&amp;subaction=universe';">
				<a style="cursor:pointer;color:lime;">{universe}</a>
			</td>
<!-- END IF menu_univers -->
<!-- IF menu_ranking -->
			<th style="width:150px;">
				<a>{ranking}</a>
			</th>
<!-- ELSE IF menu_ranking -->
			<td class="c" style="width:150px;" onclick="window.location='?action=statistic&amp;subaction=ranking';">
				<a style="cursor:pointer;color:lime;">{ranking}</a>
			</td>
<!-- END IF menu_ranking -->
		</tr>
		<tr><th colspan="3" id="info"></th></tr>
		</table>
	</td>
</tr>
</table>
{content}
