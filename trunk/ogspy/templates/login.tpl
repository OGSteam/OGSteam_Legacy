<form method='post' action='index.php'>
	<table>
		<tr>
			<td class="c" colspan="2">
				{CONNECTION_PARAMETERS}
				
				<input type='hidden' name='action' value='login_web' />
				<input type='hidden' name='goto' value='{GOTO}' />
			</td>
		</tr>
		
		<tr>
			<th style="width:150px">{LOGIN_USERNAME}</th>
			<th style="width:150px"><input type='text' name='login' id='login' tabindex='1' /></th>
		</tr>
		
		<tr>
			<th>{LOGIN_PASSWORD}</th>
			<th><input type='password' name='password' tabindex='2' /></th>
		</tr>
		
		<tr>
			<th colspan='2'><input type='submit' value='{LOG_IN}' tabindex='3' /></th>
		</tr>
		
		<!-- IF is_register -->
		
		<tr>
			<td class="c" colspan="2">{LOG_CREATE}</td>
		</tr>
		
		<tr>
			<th colspan='2'>{LOG_ALLIANCE}</th>
		</tr>
		
		<th colspan='2'>
			<input type="button" value="{LOG_CALL}" onclick="self.location.href = '{LOG_URL}';" /></th>
		</tr>
		
		<!-- END IF is_register -->
	</table>
</form>