<?php
	if ( !defined('SPGDB_INC') )
		 die('Do not access this file directly.');
		 
	$response = true;
		 
	if ( isset($_POST['gmt'], $_POST['lang'], $_POST['user'], $_POST['pass'], $_POST['passc'], $_POST['email']) )
	{
		$response = array();
		$email = strtolower($_POST['email']);
		
		if ( !preg_match(USER_MATCH, trim($_POST['user'])) )
			$response[] = USER_NOT_VALID;

		if ( !preg_match(PASS_MATCH, trim($_POST['pass'])) )
			$response[] = PASSWORD_NOT_VALID;
			
		if ( md5(trim($_POST['pass'])) !== md5(trim($_POST['passc'])) )
			$response[] = PASSWORD_CHECK_FAILED;

		if ( !preg_match(EMAIL_MATCH, trim($_POST['email'])) )
			$response[] = EMAIL_NOT_VALID;
		
		$dst = ( isset($_POST['dst']) ) ? 1 : 0;
		
		if ( preg_match('/(\+|\-)([0-9]{1,2})/', $_POST['gmt'], $matches) )
		{
			$gmtsign = $matches[1];
			$gmt = ( $matches[2] > 12 ) ? 12 : $matches[2];
		}
		else
		{
			$gmtsign = '';
			$gmt = 0;
		}
		
		if ( $_POST['lang'] !== 'it') # Will add more :D
			$lang = 'it';
		else
			$lang = $_POST['lang'];
		
		if ( empty($response) )
		{
			$query_result = $db->first_result( "SELECT nick
												FROM " . DB_USERS_TABLE . "
												WHERE nick = '" . trim($_POST['user']) . "'" );
			
			if ( $query_result !== false )
				$response[] = USER_EXISTS;
			else
			{
				$query_result = $db->query( "INSERT INTO " . DB_USERS_TABLE . " (nick, pass, email, gmt, gmtsign, dst, lang)
											 VALUES ('" . trim($_POST['user']) . "', '" . md5(trim($_POST['pass'])) . "', '" . trim($_POST['email']) . "', '$gmt', '$gmtsign', '$dst', '$lang')" );
				$response = false;
			}
		}
	}
?> 
<table border="0" cellpadding="0" cellspacing="0" id="output_table" align="center">
	<tr>
		<td class="tl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="top"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="tr"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="name" valign="middle"><?php echo TABLE_REGISTRATION; ?></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td>
			<form action="index.php" method="post" name="search" id="search">
				<table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
					<?php
						if ( is_array($response) )
						{
							echo '<tr><td>' . "\n";
							
							foreach ($response as $msg)
								echo '<span class="label">• ' . $msg . '</span><br />';
		
							echo '</td></tr>' . "\n";
							echo '<tr><td><img src="images/spacer.gif" width="1" height="5" align="right" /></td></tr>' . "\n";
						}
						else if ( $response === false )
						{
							echo '<tr><td>' . "\n";
							echo '<span class="label">• ' . ACC_CREATED . '</span><br />';
							echo '</td></tr>' . "\n";
							echo '<tr><td><img src="images/spacer.gif" width="1" height="5" align="right" /></td></tr>' . "\n";
						}
					?>
					<tr>
						<td>
							<input type="hidden" name="section" id="section" value="registration" />
							<input type="hidden" name="gmt" id="gmt" value="+1" />
							<input type="hidden" name="lang" id="lang" value="it" />
							<span class="label"><?php echo USER_NAME ?>:</span><br />
							<input name="user" type="text" id="user" maxlength="20" />
						</td>
					</tr>
					<tr>
						<td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
					</tr>
					<tr>
						<td> <span class="label"><?php echo USER_PASSWORD; ?>:</span><br />
							<input name="pass" type="password" id="pass" maxlength="32" />
						</td>
					</tr>
					<tr>
						<td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
					</tr>
					<tr>
						<td> <span class="label"><?php echo CONFIRM_USER_PASSWORD; ?>:</span><br />
							<input name="passc" type="password" id="passc" maxlength="32" />
						</td>
					</tr>
					<tr>
						<td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
					</tr>
					<tr>
						<td> <span class="label"><?php echo EMAIL; ?>:</span><br />
							<input name="email" type="text" id="email" maxlength="100" />
						</td>
					</tr>
					<tr>
						<td><img src="images/spacer.gif" width="1" height="5" align="right" /></td>
					</tr>
					<tr>
						<td align="right">
							<input class="button" type="submit" value="<?php echo FORM_SUBMIT; ?>" />
							<input class="button" type="reset" value="<?php echo FORM_RESET; ?>" />
						</td>
					</tr>
				</table>
			</form>
		</td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="left"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="right"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
	<tr>
		<td class="bl"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="bottom"><img src="images/spacer.gif" width="1" height="1" /></td>
		<td class="br"><img src="images/spacer.gif" width="1" height="1" /></td>
	</tr>
</table>