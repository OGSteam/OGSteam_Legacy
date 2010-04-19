<table width="100%">
<tr>
	<td>
		<table border="1" style="text-align:center;margin-left:auto;margin-right:auto;">
		<tr align="center">
<!-- BEGIN MENU -->
<!-- IF not_admin -->
<!-- IF user_manage -->
<!-- IF MENU.this_one -->
			<th style="width:150px;">
				<a>{MENU.title}</a>
			</th>
<!-- ELSE IF MENU.this_one -->
			<td class='c' style="width:150px;color:lime;" onclick="window.location = '?action=administration&amp;subaction={MENU.subaction}';">
				<a style='cursor:pointer'>{MENU.title}</a>
			</td>
<!-- END IF MENU.this_one -->
<!-- END IF user_manage -->
<!-- ELSE IF not_admin -->
<!-- IF MENU.this_one -->
			<th style="width:150px;">
				<a>{MENU.title}</a>
			</th>
<!-- ELSE IF MENU.this_one -->
			<td class='c' style="width:150px;color:lime;" onclick="window.location = '?action=administration&amp;subaction={MENU.subaction}';">
				<a style='cursor:pointer'>{MENU.title}</a>
			</td>
<!-- END IF MENU.this_one -->
<!-- END IF not_admin -->
<!-- END MENU -->
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
