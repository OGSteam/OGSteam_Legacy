<table width="100%">
<tr>
	<td>
		<table style="text-align:center;margin-left:auto;margin-right:auto;">
		<tr style="text-align:center;margin-left:auto;margin-right:auto;">
<!-- BEGIN MENU -->
<!-- IF MENU.this_one -->
			<th style="width:150px;">
				<a>{MENU.title}</a>
			</th>
<!-- ELSE IF MENU.this_one -->
			<td class='c' style="width:150px;" >
				<a style='cursor:pointer;color:lime;' onclick='window.location = "?action=home&amp;subaction={MENU.subaction}";'>{MENU.title}</a>
			</td>
<!-- END IF MENU.this_one -->
<!-- END MENU -->
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
